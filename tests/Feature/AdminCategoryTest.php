<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can view categories and create category/subcategory', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    // 1. Get Categories index
    $response = $this->actingAs($admin)->get(route('admin.categories.index'));
    $response->assertSuccessful();

    // 2. Create Category
    $createResponse = $this->actingAs($admin)->post(route('admin.categories.store'), [
        'name' => 'Politics',
        'slug' => 'politics',
        'sort_order' => 1,
        'status' => '1'
    ]);

    $createResponse->assertRedirect(route('admin.categories.index'));
    $this->assertDatabaseHas('categories', ['slug' => 'politics']);

    $parentCategory = Category::where('slug', 'politics')->first();

    // 3. Create Subcategory under Politics
    $createSubResponse = $this->actingAs($admin)->post(route('admin.categories.store'), [
        'name' => 'National',
        'slug' => 'national',
        'parent_id' => $parentCategory->id,
        'sort_order' => 2,
        'status' => '1'
    ]);

    $createSubResponse->assertRedirect(route('admin.categories.index'));
    $this->assertDatabaseHas('categories', [
        'slug' => 'national',
        'parent_id' => $parentCategory->id
    ]);
});

test('admin can toggle category status inline', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $category = Category::create([
        'name' => 'Sports',
        'slug' => 'sports',
        'status' => true,
        'sort_order' => 1
    ]);

    $response = $this->actingAs($admin)->post(route('admin.categories.toggle-status', $category->id));
    $response->assertJson(['success' => true, 'status' => false]);
    
    $category->refresh();
    expect($category->status)->toBeFalse();
});
