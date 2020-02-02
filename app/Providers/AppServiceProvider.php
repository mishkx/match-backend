<?php

namespace App\Providers;

use App\Contracts\Services\AppServiceContract;
use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\ChatContract;
use App\Contracts\Services\ChoiceContract;
use App\Contracts\Services\MatchContract;
use App\Contracts\Services\RecommendationContract;
use App\Contracts\Services\SocialiteContract;
use App\Contracts\Services\UserServiceContract;
use App\Helpers;
use App\Models\Account\User;
use App\Services\AppService;
use App\Services\AuthService;
use App\Services\ChatService;
use App\Services\ChoiceService;
use App\Services\MatchService;
use App\Services\RecommendationService;
use App\Services\SocialiteService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\Resource;
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
        $this->app->singleton(AppServiceContract::class, AppService::class);
        $this->app->singleton(AuthServiceContract::class, AuthService::class);

        $this->app->bind(ChatContract::class, ChatService::class);
        $this->app->bind(ChoiceContract::class, ChoiceService::class);
        $this->app->bind(MatchContract::class, MatchService::class);
        $this->app->bind(RecommendationContract::class, RecommendationService::class);
        $this->app->bind(SocialiteContract::class, SocialiteService::class);
        $this->app->bind(UserServiceContract::class, UserService::class);
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
        Relation::morphMap([
            'users' => User::class,
        ]);
        Resource::withoutWrapping();
    }
}
