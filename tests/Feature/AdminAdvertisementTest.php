<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Advertisement;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can view advertisements and manage campaigns', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.advertisements.index'));
    $response->assertSuccessful();

    // 2. Create Advertisement
    $createResponse = $this->actingAs($admin)->post(route('admin.advertisements.store'), [
        'title' => 'Google Ad Slot 1',
        'placement_key' => 'sidebar_top',
        'type' => 'code',
        'script_code' => '<div>Google Ad Code</div>',
        'status' => '1'
    ]);

    $createResponse->assertRedirect(route('admin.advertisements.index'));
    $this->assertDatabaseHas('advertisements', ['placement_key' => 'sidebar_top']);

    $ad = Advertisement::first();
    expect($ad->script_code)->toBe('<div>Google Ad Code</div>');

    // 3. Toggle Status
    $toggleResponse = $this->actingAs($admin)->post(route('admin.advertisements.toggle-status', $ad->id));
    $toggleResponse->assertJson(['success' => true, 'status' => false]);
});
