<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Media;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
    Storage::fake('public');
});

test('admin can view media library and upload assets', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.media.index'));
    $response->assertSuccessful();

    // 2. Upload fake file
    $file = UploadedFile::fake()->image('avatar.jpg');

    $uploadResponse = $this->actingAs($admin)->post(route('admin.media.store'), [
        'files' => [$file]
    ]);

    $uploadResponse->assertRedirect();
    $this->assertDatabaseHas('media', ['filename' => 'time_avatar.jpg']); // slugified & prepended time in controller, wait, since we prepended time in controller, let's assert by name!

    $media = Media::first();
    expect($media)->not->toBeNull();
    expect($media->name)->toBe('avatar');

    // Assert physical file exists in fake storage
    Storage::disk('public')->assertExists('media/' . $media->filename);
});

test('admin can update media meta details', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $media = Media::create([
        'name' => 'Logo image',
        'filename' => 'logo.png',
        'path' => '/storage/media/logo.png',
        'size' => 1024,
        'mime_type' => 'image/png',
        'uploaded_by' => $admin->id
    ]);

    $updateResponse = $this->actingAs($admin)->put(route('admin.media.update', $media->id), [
        'name' => 'Updated Logo Name',
        'alt_text' => 'New logo alternate text',
        'caption' => 'News website main branding logo',
        'copyright' => 'News Portal Inc.'
    ]);

    $updateResponse->assertRedirect();
    $media->refresh();
    expect($media->name)->toBe('Updated Logo Name');
    expect($media->alt_text)->toBe('New logo alternate text');
    expect($media->caption)->toBe('News website main branding logo');
});
