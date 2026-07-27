<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Tag;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can view tags and create tags', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.tags.index'));
    $response->assertSuccessful();

    // 2. Create Tag
    $createResponse = $this->actingAs($admin)->post(route('admin.tags.store'), [
        'name' => 'Artificial Intelligence',
        'slug' => 'artificial-intelligence',
        'description' => 'AI related tags',
        'status' => '1'
    ]);

    $createResponse->assertRedirect(route('admin.tags.index'));
    $this->assertDatabaseHas('tags', ['slug' => 'artificial-intelligence']);
});

test('admin can toggle tag status inline', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $tag = Tag::create([
        'name' => 'Politics',
        'slug' => 'politics',
        'status' => true
    ]);

    $response = $this->actingAs($admin)->post(route('admin.tags.toggle-status', $tag->id));
    $response->assertJson(['success' => true, 'status' => false]);

    $tag->refresh();
    expect($tag->status)->toBeFalse();
});
