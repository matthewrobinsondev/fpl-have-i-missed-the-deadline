<?php

namespace App\Providers;

use App\Services\DeadlineService;
use App\ThirdParty\FPL\Api;
use App\ThirdParty\FPL\ApiInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ApiInterface::class, Api::class);

        $this->app->singleton(DeadlineService::class, function (Container $app) {
            return new DeadlineService($app->make(ApiInterface::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
