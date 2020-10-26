<?php

namespace App\Providers;

use App\Article;
use App\Permission;
use App\Policies\ArticlePolicy;
use App\Policies\PermissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         Article::class => ArticlePolicy::class,
        Permission::class => PermissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @param Gate $gate
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view_admin', function ($user) {
            return $user->canDo('view_admin');
        });

        Gate::define('view_admin_articles', function ($user) {
            return $user->canDo('view_admin_articles');
        });

        Gate::define('edit_users', function ($user) {
            return $user->canDo('edit_users');
        });
    }
}
