<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Page;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can view static pages and create a new page', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.pages.index'));
    $response->assertSuccessful();

    // 2. Create Page
    $createResponse = $this->actingAs($admin)->post(route('admin.pages.store'), [
        'title' => 'About Us News Portal',
        'slug' => 'about-us',
        'content' => '<p>Welcome to our team news portal page details.</p>',
        'status' => '1'
    ]);

    $createResponse->assertRedirect(route('admin.pages.index'));
    $this->assertDatabaseHas('pages', ['slug' => 'about-us']);
});

test('admin can toggle static page status inline', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $page = Page::create([
        'title' => 'Privacy Info',
        'slug' => 'privacy',
        'content' => 'Some details',
        'status' => true
    ]);

    $response = $this->actingAs($admin)->post(route('admin.pages.toggle-status', $page->id));
    $response->assertJson(['success' => true, 'status' => false]);

    $page->refresh();
    expect($page->status)->toBeFalse();
});
