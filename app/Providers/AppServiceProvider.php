<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Super Admin gets access to everything
        Gate::before(function ($user, $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        // Register database permissions as Gates dynamically
        try {
            if (Schema::hasTable('permissions')) {
                $permissions = Permission::pluck('slug');
                foreach ($permissions as $slug) {
                    Gate::define($slug, function ($user) use ($slug) {
                        return $user->hasPermission($slug);
                    });
                }
            }
        } catch (\Exception $e) {
            // Handle exceptions during initial migrations/seeding
        }
    }
}

