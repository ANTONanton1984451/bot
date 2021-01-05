<?php

namespace App\Http\Controllers;



use App\Services\UserDeterminant;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;


class GetWeatherController extends Controller
{
    private $determinant;
    private $askLocationConversation;

    public function __construct(UserDeterminant $determinant,Conversation $askLocationConversation)
    {
        $this->determinant = $determinant;
        $this->askLocationConversation = $askLocationConversation;
    }

    public function showWeather(BotMan $bot)
    {
        $this->determinant->setBot($bot);

        $this->determinant->isUserDetermine()?$this->getWeatherForDetermineUser():$this->askLocation($bot);
    }

    private function askLocation(BotMan $bot)
    {
        $bot->startConversation($this->askLocationConversation);
    }

    private function getWeatherForDetermineUser()
    {

    }
}
