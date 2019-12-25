<?php

namespace App\Providers;

use App\Contracts\Services\AccountContract;
use App\Contracts\Services\SocialiteContract;
use App\Services\AccountService;
use App\Services\SocialiteService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
    }

    private function registerServices()
    {
        $this->app->bind(AccountContract::class, AccountService::class);
        $this->app->bind(SocialiteContract::class, SocialiteService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
