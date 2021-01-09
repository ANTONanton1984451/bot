<?php

namespace App\Providers;

use App\Services\APIDictionary;
use App\Services\CustomHttpClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('HttpClient',function ($app){
            return new CustomHttpClient();
        });

        $this->app->bind('Dictionary',function ($app){
            return new APIDictionary();
        });
    }
}
