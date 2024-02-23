<?php

namespace Modules;

use Illuminate\Support\ServiceProvider;
use Modules\Team\Providers\TeamServiceProvider;
use Modules\Profile\Providers\ProfileServiceProvider;
use Modules\UserInvitation\Providers\UserInvitationServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->register(TeamServiceProvider::class);
        $this->app->register(ProfileServiceProvider::class);
        $this->app->register(UserInvitationServiceProvider::class);
    }
}