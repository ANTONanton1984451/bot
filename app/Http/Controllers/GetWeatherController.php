<?php

namespace App\Http\Controllers;



use App\Conversations\WeatherByLocationConversation;
use App\Conversations\WeatherByUserConversation;
use App\Services\UserDeterminant;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;


class GetWeatherController extends Controller
{
    private $determinant;
    private $askLocationConversation;
    private $weatherByUserConversation;

    public function __construct(UserDeterminant $determinant,
                                WeatherByLocationConversation $askLocationConversation,
                                WeatherByUserConversation $weatherByUserConversation){

        $this->determinant = $determinant;
        $this->askLocationConversation = $askLocationConversation;
        $this->weatherByUserConversation = $weatherByUserConversation;
    }

    public function showWeather(BotMan $bot)
    {
        $this->determinant->setBot($bot);

        $this->determinant->isUserDetermine()?$this->getWeatherForDetermineUser($bot):$this->askLocation($bot);
    }

    private function askLocation(BotMan $bot)
    {
        $bot->startConversation($this->askLocationConversation);
    }

    private function getWeatherForDetermineUser(BotMan $bot)
    {   
        $bot->startConversation($this->weatherByUserConversation);
    }
}
