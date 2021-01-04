<?php

namespace App\Providers;

use App\Contracts\QuestionGenerator;
use App\Conversations\IntroductionConversation;
use App\Conversations\SetSettingsConversation;
use App\Http\Controllers\IntroductionController;
use App\Services\QuestionGenerators\SetSettingsQuestion;
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

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(IntroductionController::class)
            ->needs(Conversation::class)
            ->give(function(){
                return new IntroductionConversation(
                    new SetSettingsQuestion($this->app->make('botman')),
                    new SetSettingsConversation()
                );
            });
    }

}
