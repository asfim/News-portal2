<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Author;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can view authors list and create author profile', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.authors.index'));
    $response->assertSuccessful();

    // 2. Create Author linked to admin user
    $createResponse = $this->actingAs($admin)->post(route('admin.authors.store'), [
        'name' => 'John Reporter',
        'username' => 'john_reporter',
        'email' => 'john@newsportal.com',
        'phone' => '123456789',
        'designation' => 'Staff Writer',
        'bio' => 'Reporter bio details',
        'user_id' => $admin->id,
        'status' => '1'
    ]);

    $createResponse->assertRedirect(route('admin.authors.index'));
    $this->assertDatabaseHas('authors', [
        'username' => 'john_reporter',
        'user_id' => $admin->id
    ]);
});

test('admin can toggle author status inline', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $author = Author::create([
        'name' => 'Sarah Writer',
        'username' => 'sarah_w',
        'email' => 'sarah@newsportal.com',
        'status' => true
    ]);

    $response = $this->actingAs($admin)->post(route('admin.authors.toggle-status', $author->id));
    $response->assertJson(['success' => true, 'status' => false]);

    $author->refresh();
    expect($author->status)->toBeFalse();
});
