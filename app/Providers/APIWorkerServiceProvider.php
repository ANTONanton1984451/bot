<?php

namespace App\Providers;

use App\Services\WeatherAPI\YandexWorker;
use Illuminate\Support\ServiceProvider;

class APIWorkerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('YandexAPIWorker',function ($app){
            return new YandexWorker($app->make('HttpClient'));
        });

    }
}
