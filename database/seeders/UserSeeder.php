<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch roles
        $superAdminRole = Role::where('slug', 'super-admin')->first();
        $editorRole = Role::where('slug', 'editor')->first();
        $reporterRole = Role::where('slug', 'reporter')->first();
        $userRole = Role::where('slug', 'user')->first();

        // 1. Create Super Admin User
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@newsportal.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
            ]
        );
        if ($superAdminRole) {
            $superAdmin->roles()->sync([$superAdminRole->id]);
        }

        // 2. Create Editor User
        $editor = User::updateOrCreate(
            ['email' => 'editor@newsportal.com'],
            [
                'name' => 'News Editor',
                'password' => Hash::make('password'),
            ]
        );
        if ($editorRole) {
            $editor->roles()->sync([$editorRole->id]);
        }

        // 3. Create Reporter User
        $reporter = User::updateOrCreate(
            ['email' => 'reporter@newsportal.com'],
            [
                'name' => 'Senior Journalist',
                'password' => Hash::make('password'),
            ]
        );
        if ($reporterRole) {
            $reporter->roles()->sync([$reporterRole->id]);
        }

        // Create Author profile for the Reporter
        Author::updateOrCreate(
            ['user_id' => $reporter->id],
            [
                'name' => $reporter->name,
                'username' => 'reporter',
                'email' => $reporter->email,
                'phone' => '+8801700000000',
                'profile_photo' => null,
                'designation' => 'Senior Investigative Journalist',
                'bio' => 'Senior reporter covering politics, investigative journalism, and national affairs with over 10 years of experience.',
                'facebook' => 'https://facebook.com/reporter',
                'twitter' => 'https://twitter.com/reporter',
                'instagram' => 'https://instagram.com/reporter',
                'linkedin' => 'https://linkedin.com/in/reporter',
                'status' => true,
            ]
        );

        // 4. Create Normal User / Reader
        $reader = User::updateOrCreate(
            ['email' => 'user@newsportal.com'],
            [
                'name' => 'Regular Reader',
                'password' => Hash::make('password'),
            ]
        );
        if ($userRole) {
            $reader->roles()->sync([$userRole->id]);
        }
    }
}
