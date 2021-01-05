<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class ShowWeatherConversation extends Conversation
{
    private const ASK_LOCATION = 'bot_phrases.get.location';

    public $longitude;
    public $latitude;

    public function __construct()
    {

    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->getLocation();
    }

    private function getLocation()
    {
        $localeQuestion = config(self::ASK_LOCATION);
        $this->ask($localeQuestion,function (Answer $answer){
            $this->longitude = 59.94;
            $this->latitude = 30.31;
        });
    }
}
