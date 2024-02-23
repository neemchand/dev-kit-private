<?php

namespace App\Providers;

use App\Models\User;
use Config;
use Gate;
use App\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user) {
            return $user->hasRole(Config::get('constants.roles.super_admin')) ? true : null;
        });

        ResetPassword::createUrlUsing(function (User $notifiable, string $token) {
            return url(route('password.reset.verify', ['token' => $token]))
                . '?email=' . $notifiable->getEmailForPasswordReset();
        });
    }
}
