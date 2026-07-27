<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
    Role::create(['name' => 'Editor', 'slug' => 'editor']);
});

test('admin can view users list and create a new user account with roles', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.users.index'));
    $response->assertSuccessful();

    // 2. Create Editor User
    $editorRole = Role::where('slug', 'editor')->first();

    $createResponse = $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => 'John Editor',
        'email' => 'john_editor@newsportal.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'roles' => [$editorRole->id],
        'status' => '1'
    ]);

    $createResponse->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseHas('users', ['email' => 'john_editor@newsportal.com']);

    $createdUser = User::where('email', 'john_editor@newsportal.com')->first();
    expect($createdUser->roles->pluck('slug')->toArray())->toContain('editor');
});

test('admin cannot block or delete their own user account', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password'),
        'status' => true
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    // 1. Try blocking self
    $blockResponse = $this->actingAs($admin)->post(route('admin.users.toggle-status', $admin->id));
    $blockResponse->assertStatus(403);
    $admin->refresh();
    expect($admin->status)->toBeTrue();

    // 2. Try deleting self
    $deleteResponse = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin->id));
    $deleteResponse->assertRedirect();
    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});
