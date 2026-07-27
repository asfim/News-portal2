<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('all sidebar menus load valid placeholder responses for admin', function (string $routeName, string $expectedContent) {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $response = $this->actingAs($admin)->get(route($routeName));

    $response->assertSuccessful();
    $response->assertSee($expectedContent);
})->with([
    ['admin.news.index', 'News Articles'],
    ['admin.news.create', 'Create Article'],
    ['admin.tags.index', 'Tag Management'],
    ['admin.menus.index', 'Menu Management'],
    ['admin.pages.index', 'Static Pages'],
    ['admin.authors.index', 'Author Management'],
    ['admin.users.index', 'Users List'],
    ['admin.comments.index', 'Comments Moderation'],
    ['admin.media.index', 'Media Library'],
    ['admin.advertisements.index', 'Advertisements Management'],
    ['admin.subscribers.index', 'Newsletter Subscribers'],
    ['admin.contacts.index', 'Contact Inbox'],
]);
