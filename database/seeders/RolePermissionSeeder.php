<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Define all permissions
        $permissions = [
            'dashboard-access' => 'Access to administrative control panel',
            'news-create' => 'Create new news articles',
            'news-edit' => 'Edit news articles',
            'news-delete' => 'Delete news articles',
            'news-publish' => 'Publish news articles directly',
            'news-approve' => 'Approve pending news articles',
            'category-management' => 'Manage categories and subcategories',
            'subcategory-management' => 'Manage subcategories directly',
            'tag-management' => 'Manage tags',
            'author-management' => 'Manage authors and reporters',
            'user-management' => 'Manage system users and subscribers',
            'comment-management' => 'Moderate, approve, and delete comments',
            'advertisement-management' => 'Manage display and HTML ads',
            'media-management' => 'Manage media library assets',
            'menu-management' => 'Manage dynamic navigation menus',
            'page-management' => 'Manage custom CMS pages',
            'settings-management' => 'Edit system settings and config',
            'breaking-news-management' => 'Create and toggle breaking news',
            'seo-management' => 'Manage meta descriptions, sitemap and schemas',
            'analytics-access' => 'View analytical traffic data charts',
        ];

        $permissionModels = [];
        foreach ($permissions as $slug => $description) {
            $name = ucwords(str_replace('-', ' ', $slug));
            $permissionModels[$slug] = Permission::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'description' => $description]
            );
        }

        // 2. Define roles
        $roles = [
            'super-admin' => 'Super Administrator with absolute permissions',
            'admin' => 'Administrator with general panel control',
            'editor' => 'Editor in charge of news moderation, categories and comments',
            'reporter' => 'Journalist who creates news posts',
            'author' => 'Author who writes stories',
            'contributor' => 'Contributor who drafts posts for editorial review',
            'user' => 'Registered reader / website customer',
        ];

        $roleModels = [];
        foreach ($roles as $slug => $description) {
            $name = ucwords(str_replace('-', ' ', $slug));
            $roleModels[$slug] = Role::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'description' => $description]
            );
        }

        // 3. Assign permissions to roles
        // Super Admin gets everything (handled via Gate::before in AppServiceProvider, but let's sync anyway)
        $roleModels['super-admin']->permissions()->sync(array_values($permissionModels));

        // Admin gets almost everything except maybe settings
        $adminPermissions = [
            'dashboard-access', 'news-create', 'news-edit', 'news-delete', 'news-publish',
            'news-approve', 'category-management', 'subcategory-management', 'tag-management',
            'author-management', 'user-management', 'comment-management', 'advertisement-management',
            'media-management', 'menu-management', 'page-management', 'settings-management',
            'breaking-news-management', 'seo-management', 'analytics-access'
        ];
        $roleModels['admin']->permissions()->sync(
            collect($adminPermissions)->map(fn($slug) => $permissionModels[$slug]->id)
        );

        // Editor gets editorial permissions
        $editorPermissions = [
            'dashboard-access', 'news-create', 'news-edit', 'news-delete', 'news-publish',
            'news-approve', 'category-management', 'subcategory-management', 'tag-management',
            'comment-management', 'media-management', 'breaking-news-management', 'seo-management', 'analytics-access'
        ];
        $roleModels['editor']->permissions()->sync(
            collect($editorPermissions)->map(fn($slug) => $permissionModels[$slug]->id)
        );

        // Reporter gets news writing, editing (their own) and media uploads
        $reporterPermissions = [
            'dashboard-access', 'news-create', 'news-edit', 'media-management'
        ];
        $roleModels['reporter']->permissions()->sync(
            collect($reporterPermissions)->map(fn($slug) => $permissionModels[$slug]->id)
        );

        // Author gets news writing, editing (their own) and media uploads
        $authorPermissions = [
            'dashboard-access', 'news-create', 'news-edit', 'media-management'
        ];
        $roleModels['author']->permissions()->sync(
            collect($authorPermissions)->map(fn($slug) => $permissionModels[$slug]->id)
        );

        // Contributor gets dashboard access and news create only
        $contributorPermissions = [
            'dashboard-access', 'news-create'
        ];
        $roleModels['contributor']->permissions()->sync(
            collect($contributorPermissions)->map(fn($slug) => $permissionModels[$slug]->id)
        );

        // Reader gets no admin panel access permissions
        $roleModels['user']->permissions()->sync([]);
    }
}
