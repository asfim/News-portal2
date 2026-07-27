<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can view menu items and manage links', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.menus.index'));
    $response->assertSuccessful();

    // 2. Create Menu Item
    $createResponse = $this->actingAs($admin)->post(route('admin.menus.store'), [
        'label' => 'Sports Category Link',
        'value' => '/category/sports',
        'type' => 'custom',
        'sort_order' => 5,
        'status' => '1'
    ]);

    $createResponse->assertRedirect(route('admin.menus.index'));
    $this->assertDatabaseHas('menus', ['value' => '/category/sports']);

    $menu = Menu::first();
    expect($menu->label)->toBe('Sports Category Link');

    // 3. Toggle Status
    $toggleResponse = $this->actingAs($admin)->post(route('admin.menus.toggle-status', $menu->id));
    $toggleResponse->assertJson(['success' => true, 'status' => false]);
});
