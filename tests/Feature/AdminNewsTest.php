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

test('when 9 trending articles exist setting a 10th automatically turns off the oldest trending article', function () {
    $admin = User::create([
        'name' => 'Admin User 2',
        'email' => 'admin2@newsportal.com',
        'password' => bcrypt('password')
    ]);
    $admin->roles()->attach(Role::where('slug', 'super-admin')->first());

    $category = Category::create([
        'name' => 'Sports',
        'slug' => 'sports-test',
        'status' => true,
        'sort_order' => 1
    ]);

    $author = Author::create([
        'name' => 'Reporter',
        'username' => 'reporter',
        'email' => 'reporter@newsportal.com',
        'status' => true
    ]);

    // Create 9 trending news articles
    $trendingArticles = [];
    for ($i = 1; $i <= 9; $i++) {
        $trendingArticles[] = News::create([
            'title' => "Trending Article {$i}",
            'slug' => "trending-article-{$i}",
            'category_id' => $category->id,
            'author_id' => $author->id,
            'short_description' => 'Summary',
            'content' => '<p>Content</p>',
            'status' => 'published',
            'trending_news' => true,
            'created_at' => now()->subMinutes(100 - $i),
        ]);
    }

    // Now create a 10th article with trending_news = true
    $response = $this->actingAs($admin)->post(route('admin.news.store'), [
        'title' => 'Trending Article 10',
        'slug' => 'trending-article-10',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'short_description' => 'Summary 10',
        'content' => '<p>Content</p>',
        'status' => 'published',
        'trending_news' => '1',
    ]);

    $response->assertRedirect(route('admin.news.index'));

    // The oldest trending article (#1) should now have trending_news = false
    expect($trendingArticles[0]->fresh()->trending_news)->toBeFalse();

    // Total active trending articles in DB should remain 9
    expect(News::where('trending_news', true)->count())->toBe(9);
});
