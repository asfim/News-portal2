<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Author;
use App\Models\Tag;
use App\Models\News;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can view news list and create a news article', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $category = Category::create([
        'name' => 'National',
        'slug' => 'national',
        'status' => true,
        'sort_order' => 1
    ]);

    $author = Author::create([
        'name' => 'Sarah Writer',
        'username' => 'sarah_w',
        'email' => 'sarah@newsportal.com',
        'status' => true
    ]);

    $tag = Tag::create([
        'name' => 'Breaking Alert',
        'slug' => 'breaking-alert',
        'status' => true
    ]);

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.news.index'));
    $response->assertSuccessful();

    // 2. Create News Post
    $createResponse = $this->actingAs($admin)->post(route('admin.news.store'), [
        'title' => 'Important Headline Today',
        'slug' => 'important-headline-today',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'short_description' => 'A short summary details about today.',
        'content' => '<p>This is the main news body content.</p>',
        'status' => 'published',
        'breaking_news' => '1',
        'tags' => [$tag->id]
    ]);

    $createResponse->assertRedirect(route('admin.news.index'));
    $this->assertDatabaseHas('news', [
        'slug' => 'important-headline-today',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'breaking_news' => true
    ]);

    $news = News::first();
    expect($news->tags->pluck('id')->toArray())->toContain($tag->id);
});

test('admin can toggle off breaking news flag', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $category = Category::create([
        'name' => 'National',
        'slug' => 'national',
        'status' => true,
        'sort_order' => 1
    ]);

    $author = Author::create([
        'name' => 'Sarah Writer',
        'username' => 'sarah_w',
        'email' => 'sarah@newsportal.com',
        'status' => true
    ]);

    $news = News::create([
        'title' => 'Headline Today',
        'slug' => 'headline-today',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'short_description' => 'A short summary.',
        'content' => '<p>Content</p>',
        'status' => 'published',
        'breaking_news' => true
    ]);

    // Update and toggle off breaking_news
    $response = $this->actingAs($admin)->put(route('admin.news.update', $news->id), [
        'title' => 'Headline Today',
        'slug' => 'headline-today',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'short_description' => 'A short summary.',
        'content' => '<p>Content</p>',
        'status' => 'published',
        // 'breaking_news' is omitted to turn it off
    ]);

    $response->assertRedirect(route('admin.news.index'));
    
    $news->refresh();
    expect($news->breaking_news)->toBeFalse();
});

test('admin can toggle on and off trending_news, editor_choice, and is_latest', function () {
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $category = Category::create([
        'name' => 'National',
        'slug' => 'national',
        'status' => true,
        'sort_order' => 1
    ]);

    $author = Author::create([
        'name' => 'Sarah Writer',
        'username' => 'sarah_w',
        'email' => 'sarah@newsportal.com',
        'status' => true
    ]);

    $news = News::create([
        'title' => 'Headline Today',
        'slug' => 'headline-today',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'short_description' => 'A short summary.',
        'content' => '<p>Content</p>',
        'status' => 'published',
        'trending_news' => false,
        'editor_choice' => false,
        'is_latest' => false,
    ]);

    // 1. Toggle them ON
    $response = $this->actingAs($admin)->put(route('admin.news.update', $news->id), [
        'title' => 'Headline Today',
        'slug' => 'headline-today',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'short_description' => 'A short summary.',
        'content' => '<p>Content</p>',
        'status' => 'published',
        'trending_news' => '1',
        'editor_choice' => '1',
        'is_latest' => '1',
    ]);

    $response->assertRedirect(route('admin.news.index'));
    $news->refresh();
    expect($news->trending_news)->toBeTrue();
    expect($news->editor_choice)->toBeTrue();
    expect($news->is_latest)->toBeTrue();

    // 2. Toggle them OFF
    $response2 = $this->actingAs($admin)->put(route('admin.news.update', $news->id), [
        'title' => 'Headline Today',
        'slug' => 'headline-today',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'short_description' => 'A short summary.',
        'content' => '<p>Content</p>',
        'status' => 'published',
        // Omitted to turn OFF
    ]);

    $response2->assertRedirect(route('admin.news.index'));
    $news->refresh();
    expect($news->trending_news)->toBeFalse();
    expect($news->editor_choice)->toBeFalse();
    expect($news->is_latest)->toBeFalse();
});
