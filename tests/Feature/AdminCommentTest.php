<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Comment;
use App\Models\News;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'Super Admin', 'slug' => 'super-admin']);
});

test('admin can view comments and moderate statuses', function () {
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
        'title' => 'Headline News Today',
        'slug' => 'headline-news-today',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'short_description' => 'A short description summary.',
        'content' => '<p>News content details.</p>',
        'status' => 'published'
    ]);

    $comment = Comment::create([
        'user_id' => $admin->id,
        'news_id' => $news->id,
        'comment' => 'This is a very nice article!',
        'status' => 'pending'
    ]);

    // 1. View Index
    $response = $this->actingAs($admin)->get(route('admin.comments.index'));
    $response->assertSuccessful();

    // 2. Approve Comment
    $approveResponse = $this->actingAs($admin)->post(route('admin.comments.status', $comment->id), [
        'status' => 'approved'
    ]);

    $approveResponse->assertRedirect();
    $comment->refresh();
    expect($comment->status)->toBe('approved');

    // 3. Mark as Spam
    $spamResponse = $this->actingAs($admin)->post(route('admin.comments.status', $comment->id), [
        'status' => 'spam'
    ]);
    $comment->refresh();
    expect($comment->status)->toBe('spam');
});
