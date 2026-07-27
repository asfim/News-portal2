<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Setting;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    // Setup roles
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can access dashboard and view stats', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertSuccessful();
    $response->assertViewHas('stats');
    $response->assertViewHas('recentNews');
    $response->assertViewHas('recentComments');
});

test('admin can access settings page and update settings', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    // Get settings page
    $response = $this->actingAs($admin)->get(route('admin.settings'));
    $response->assertSuccessful();

    // Update settings
    $updateResponse = $this->actingAs($admin)->post(route('admin.settings.update'), [
        'website_name' => 'New News Portal',
        'email' => 'support@newportal.com',
        'phone' => '123456789',
        'breaking_news_status' => '1',
        'comments_status' => '1'
    ]);

    $updateResponse->assertRedirect();
    $updateResponse->assertSessionHas('success');

    // Verify change persisted
    expect(Setting::get('website_name'))->toBe('New News Portal');
    expect(Setting::get('email'))->toBe('support@newportal.com');
    expect(Setting::get('breaking_news_status'))->toBe('1');
});
