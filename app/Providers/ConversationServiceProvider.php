<?php

namespace App\Providers;

use App\Contracts\QuestionGenerator;
use App\Conversations\IntroductionConversation;
use App\Conversations\SetSettingsConversation;
use App\Conversations\WeatherByLocationConversation;
use App\Conversations\WeatherByUserConversation;
use App\Http\Controllers\GetWeatherController;
use App\Http\Controllers\IntroductionController;
use App\Services\WeatherMessageFormatter;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Support\ServiceProvider;


class ConversationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->when(IntroductionController::class)
            ->needs(Conversation::class)
            ->give(function ($app){
                  return  $app->make('IntroductionConversation');
            });

        $this->app->when(SetSettingsConversation::class)
            ->needs(QuestionGenerator::class)
            ->give(function($app){
               return $app->make('SetDaysCountQuestion');
            });

        $this->app->when(GetWeatherController::class)
            ->needs(WeatherByLocationConversation::class)
            ->give(function($app){
              return $app->make('WeatherByLocationConversation');
            });

        $this->app->when(GetWeatherController::class)
            ->needs(WeatherByUserConversation::class)
            ->give(function($app){
                return $app->make('WeatherByUserConversation');
            });

        $this->app->bind('WeatherByLocationConversation',function($app){
            return new WeatherByLocationConversation($app->make('YandexAPIWorker'),$app->make(WeatherMessageFormatter::class));
        });

        $this->app->bind('WeatherByUserConversation',function ($app){
            return new WeatherByUserConversation($app->make('YandexAPIWorker'),$app->make(WeatherMessageFormatter::class));
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {


        $this->app->bind('SetSettingsConversation',function ($app){
            return new SetSettingsConversation($app->make('SetDaysCountQuestion'));
        });

        $this->app->bind('IntroductionConversation',function($app){
            return new IntroductionConversation(
                $app->make('SetSettingsQuestion'),
                $app->make('SetSettingsConversation')
            );
        });

        $this->app->bind(WeatherMessageFormatter::class,function ($app){
            return new WeatherMessageFormatter($app->make('Dictionary'));
        });

    }

}
