<?php

namespace App\Providers;

use App\Contracts\QuestionGenerator;
use App\Conversations\IntroductionConversation;
use App\Conversations\SetSettingsConversation;
use App\Conversations\ShowWeatherConversation;
use App\Http\Controllers\GetWeatherController;
use App\Http\Controllers\IntroductionController;
use App\Services\QuestionGenerators\SetDaysCountQuestion;
use App\Services\QuestionGenerators\SetSettingsQuestion;
use App\User;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
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

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(SetSettingsConversation::class)
            ->needs(QuestionGenerator::class)
            ->give(function (){
                return new SetDaysCountQuestion();
            });

        $this->app->when(IntroductionController::class)
            ->needs(Conversation::class)
            ->give(function(){
                return new IntroductionConversation(
                    new SetSettingsQuestion($this->app->make('botman')),
                    new SetSettingsConversation(new SetDaysCountQuestion())
                );
            });


        $this->app->when(GetWeatherController::class)
            ->needs(Conversation::class)
            ->give(function(){
                return new ShowWeatherConversation();
            });

    }

}
