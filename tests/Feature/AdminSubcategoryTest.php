<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can view subcategories list and create subcategory', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $parentCategory = Category::create([
        'name' => 'Sports',
        'slug' => 'sports',
        'status' => true,
        'sort_order' => 1
    ]);

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.subcategories.index'));
    $response->assertSuccessful();

    // 2. Create Subcategory
    $createResponse = $this->actingAs($admin)->post(route('admin.subcategories.store'), [
        'name' => 'Cricket News',
        'slug' => 'cricket',
        'parent_id' => $parentCategory->id,
        'sort_order' => 5,
        'status' => '1'
    ]);

    $createResponse->assertRedirect(route('admin.subcategories.index'));
    $this->assertDatabaseHas('categories', [
        'slug' => 'cricket',
        'parent_id' => $parentCategory->id
    ]);

    $sub = Category::where('slug', 'cricket')->first();
    expect($sub->name)->toBe('Cricket News');

    // 3. Toggle Status
    $toggleResponse = $this->actingAs($admin)->post(route('admin.subcategories.toggle-status', $sub->id));
    $toggleResponse->assertJson(['success' => true, 'status' => false]);
});
