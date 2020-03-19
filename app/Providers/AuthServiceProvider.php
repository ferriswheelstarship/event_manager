<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 特権ユーザのみ許可
        Gate::define('system-only', function ($user) {
            return ($user->role->level > 0 && $user->role->level == 1);
        });

        // 支部ユーザのみに許可
        Gate::define('area-only', function ($user) {
            return ($user->role->level > 0 && $user->role->level == 3);
        });

        // 法人ユーザのみに許可
        Gate::define('admin-only', function ($user) {
            return ($user->role->level > 0 && $user->role->level == 5);
        });

        // 個人ユーザのみに許可
        Gate::define('user-only', function ($user) {
            return ($user->role->level > 0 && $user->role->level == 10);
        });


        
        // 支部ユーザ以上に許可
        Gate::define('area-higher', function ($user) {
            return ($user->role->level > 0 && $user->role->level <= 3);
        });

        // 法人ユーザ以上（特権＆支部＆法人ユーザ）に許可
        Gate::define('admin-higher', function ($user) {
            return ($user->role->level > 0 && $user->role->level <= 5);
        });

        // 一般ユーザ以上（全権限）に許可
        Gate::define('user-higher', function ($user) {
            return ($user->role->level > 0 && $user->role->level <= 10);
        });


    }
}
