<?php

namespace App\Providers;

use App\Contracts\Services\AccountContract;
use App\Contracts\Services\MatchContract;
use App\Contracts\Services\SocialiteContract;
use App\Helpers;
use App\Services\AccountService;
use App\Services\MatchService;
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
        $this->registerQueryBuilderMacro();
    }

    private function registerServices()
    {
        $this->app->bind(AccountContract::class, AccountService::class);
        $this->app->bind(MatchContract::class, MatchService::class);
        $this->app->bind(SocialiteContract::class, SocialiteService::class);
    }

    public function registerQueryBuilderMacro()
    {
        \Illuminate\Database\Query\Builder::macro('toRawSql', function () {
            return Helpers::applySqlQueryBindings($this->toSql(), $this->getBindings());
        });
        \Illuminate\Database\Eloquent\Builder::macro('toRawSql', function () {
            return $this->getQuery()->toRawSql();
        });
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
