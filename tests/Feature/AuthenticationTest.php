<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    // Seed basic roles for auth tests
    Role::create(['name' => 'Reader', 'slug' => 'user']);
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('guest can register as reader and is assigned user role', function () {
    $response = $this->post('/register', [
        'name' => 'Jane Reader',
        'email' => 'jane@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $response->assertRedirect(route('user.dashboard'));
    $this->assertAuthenticated();

    $user = User::where('email', 'jane@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->hasRole('user'))->toBeTrue();
});

test('user can login and is redirected based on role', function () {
    // 1. Create a regular reader
    $reader = User::create([
        'name' => 'Jane Reader',
        'email' => 'jane@example.com',
        'password' => Hash::make('password123')
    ]);
    $reader->roles()->attach(Role::where('slug', 'user')->first());

    $response = $this->post('/login', [
        'email' => 'jane@example.com',
        'password' => 'password123'
    ]);

    $response->assertRedirect(route('user.dashboard'));
    $this->assertAuthenticatedAs($reader);

    // Logout
    $this->post('/logout')->assertRedirect('/');
    $this->assertGuest();

    // 2. Create an admin
    $admin = User::create([
        'name' => 'Super Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('password123')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $response = $this->post('/login', [
        'email' => 'admin@example.com',
        'password' => 'password123'
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($admin);
});

test('failed login attempts show validation errors', function () {
    $user = User::create([
        'name' => 'Jane Reader',
        'email' => 'jane@example.com',
        'password' => Hash::make('password123')
    ]);

    $response = $this->post('/login', [
        'email' => 'jane@example.com',
        'password' => 'wrong-password'
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});
