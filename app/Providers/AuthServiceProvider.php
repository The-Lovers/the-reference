<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Domains;
use App\Models\Missions;
use App\Models\User;
use App\Policies\DomainsPolicy;
use App\Policies\MissionsPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Domains::class => DomainsPolicy::class,
        Missions::class => MissionsPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
