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
