<?php

namespace Modules\UserInvitation\Providers;

use Illuminate\Support\ServiceProvider;

class UserInvitationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'team');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }
}