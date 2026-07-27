<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Author;
use App\Models\Media;
use App\Models\News;
use App\Models\Comment;
use App\Models\Bookmark;
use App\Models\Setting;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('database relationships and schema check', function () {
    // 1. Roles and Permissions
    $permission = Permission::create([
        'name' => 'Create News',
        'slug' => 'news-create',
        'description' => 'Allow creating news articles'
    ]);

    $role = Role::create([
        'name' => 'Reporter',
        'slug' => 'reporter',
        'description' => 'Reporter role'
    ]);

    $role->permissions()->attach($permission);
    expect($role->permissions)->toHaveCount(1);
    expect($role->permissions->first()->slug)->toBe('news-create');

    $user = User::create([
        'name' => 'John Reporter',
        'email' => 'john@newsportal.com',
        'password' => bcrypt('password')
    ]);

    $user->roles()->attach($role);
    expect($user->roles)->toHaveCount(1);
    expect($user->hasRole('reporter'))->toBeTrue();
    expect($user->hasPermission('news-create'))->toBeTrue();

    // 2. Categories parent-child relationships
    $parentCategory = Category::create([
        'name' => 'Sports',
        'slug' => 'sports',
        'description' => 'Sports category'
    ]);

    $childCategory = Category::create([
        'name' => 'Cricket',
        'slug' => 'cricket',
        'description' => 'Cricket news',
        'parent_id' => $parentCategory->id
    ]);

    expect($parentCategory->children)->toHaveCount(1);
    expect($childCategory->parent->name)->toBe('Sports');

    // 3. Author Profile
    $author = Author::create([
        'user_id' => $user->id,
        'name' => 'John Reporter',
        'username' => 'john_rep',
        'email' => 'john@newsportal.com',
        'designation' => 'Sports Reporter'
    ]);

    expect($user->author->username)->toBe('john_rep');
    expect($author->user->email)->toBe('john@newsportal.com');

    // 4. Media
    $media = Media::create([
        'name' => 'Match Image',
        'filename' => 'match.jpg',
        'path' => '/uploads/match.jpg',
        'size' => 2048,
        'mime_type' => 'image/jpeg',
        'uploaded_by' => $user->id
    ]);

    expect($media->uploader->name)->toBe('John Reporter');

    // 5. News and News-Tag
    $news = News::create([
        'category_id' => $parentCategory->id,
        'subcategory_id' => $childCategory->id,
        'author_id' => $author->id,
        'title' => 'Bangladesh wins cricket match',
        'slug' => 'bangladesh-wins-cricket-match',
        'short_description' => 'Bangladesh won against Zimbabwe',
        'content' => 'Full match description goes here.',
        'featured_image' => $media->id,
        'thumbnail' => $media->id,
        'status' => 'published',
        'publish_at' => now(),
    ]);

    $tag = Tag::create([
        'name' => 'Match',
        'slug' => 'match'
    ]);

    $news->tags()->attach($tag);
    expect($news->tags)->toHaveCount(1);
    expect($news->category->name)->toBe('Sports');
    expect($news->subcategory->name)->toBe('Cricket');
    expect($news->author->name)->toBe('John Reporter');
    expect($news->featuredImage->filename)->toBe('match.jpg');

    // 6. Comments
    $comment = Comment::create([
        'news_id' => $news->id,
        'user_id' => $user->id,
        'comment' => 'Great news!',
        'status' => 'approved'
    ]);

    expect($news->comments)->toHaveCount(1);
    expect($comment->news->title)->toBe('Bangladesh wins cricket match');
    expect($comment->user->name)->toBe('John Reporter');

    // 7. Bookmarks
    $bookmark = Bookmark::create([
        'user_id' => $user->id,
        'news_id' => $news->id
    ]);

    expect($user->bookmarks)->toHaveCount(1);
    expect($bookmark->news->title)->toBe('Bangladesh wins cricket match');

    // 8. Settings
    Setting::set('site_name', 'Tech News');
    expect(Setting::get('site_name'))->toBe('Tech News');
});
