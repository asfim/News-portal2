<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Newsletter;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can view subscribers and manage statuses', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $sub = Newsletter::create([
        'email' => 'subscriber@test.com',
        'status' => true
    ]);

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.subscribers.index'));
    $response->assertSuccessful();

    // 2. Toggle Status
    $toggleResponse = $this->actingAs($admin)->post(route('admin.subscribers.toggle-status', $sub->id));
    $toggleResponse->assertJson(['success' => true, 'status' => false]);

    $sub->refresh();
    expect($sub->status)->toBeFalse();

    // 3. Delete subscriber
    $deleteResponse = $this->actingAs($admin)->delete(route('admin.subscribers.destroy', $sub->id));
    $deleteResponse->assertRedirect(route('admin.subscribers.index'));
    $this->assertDatabaseMissing('newsletters', ['id' => $sub->id]);
});
