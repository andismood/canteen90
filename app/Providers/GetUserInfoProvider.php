<?php

namespace App\Providers;

use App\Services\GetUserInfo;
use Illuminate\Support\ServiceProvider;

class GetUserInfoProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GetUserInfo::class, function ($app) {
            return new GetUserInfo();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
