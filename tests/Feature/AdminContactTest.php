<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Contact;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can view contacts and toggle read status', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $msg = Contact::create([
        'name' => 'John Reader',
        'email' => 'john@reader.com',
        'subject' => 'Nice website Design',
        'message' => 'Hello team, your portal design is very clean.',
        'status' => 'unread'
    ]);

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.contacts.index'));
    $response->assertSuccessful();

    // 2. Toggle Read
    $toggleResponse = $this->actingAs($admin)->post(route('admin.contacts.toggle-read', $msg->id));
    $toggleResponse->assertJson(['success' => true, 'status' => 'read']);

    $msg->refresh();
    expect($msg->status)->toBe('read');

    // 3. Delete Message
    $deleteResponse = $this->actingAs($admin)->delete(route('admin.contacts.destroy', $msg->id));
    $deleteResponse->assertRedirect(route('admin.contacts.index'));
    $this->assertDatabaseMissing('contacts', ['id' => $msg->id]);
});
