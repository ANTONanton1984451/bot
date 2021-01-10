<?php

namespace App\Providers;

use App\Services\QuestionGenerators\SetDaysCountQuestion;
use App\Services\QuestionGenerators\SetSettingsQuestion;
use Illuminate\Support\ServiceProvider;

class QuestionGeneratorServiceProvider extends ServiceProvider
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
        $this->app->bind('SetDaysCountQuestion',function($app){
            return new SetDaysCountQuestion();
        });

        $this->app->bind('SetSettingsQuestion',function($app){
            return new SetSettingsQuestion($app->make('botman'));
        });
    }
}
