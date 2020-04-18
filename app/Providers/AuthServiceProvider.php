<?php

namespace App\Providers;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //define the policy gate
        Gate::define('menu.admin', 'App\Policies\Menu@admin');
        Gate::define('menu.user', 'App\Policies\Menu@user');
        Gate::define('menu.kasir', 'App\Policies\Menu@kasir');
        Gate::define('menu.userAdmin', 'App\Policies\Menu@userAdmin');
    }
}
