<?php

namespace App\Conversations;

use App\Contracts\APIWorker;
use App\Contracts\Weather;
use App\Services\WeatherMessageFormatter;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class WeatherByLocationConversation extends Conversation
{
    private const ASK_LOCATION = 'bot_phrases.get.location';

    public $longitude;
    public $latitude;

    public $apiWorker;
    public $formatter;

    public function __construct(APIWorker $apiWorker,WeatherMessageFormatter $formatter)
    {
        $this->apiWorker = $apiWorker;
        $this->formatter = $formatter;
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $locationQuestion = config(self::ASK_LOCATION);

        $this->ask($locationQuestion,function (Answer $answer){
            $this->longitude = (float) env('DEV_LONGITUDE');
            $this->latitude = (float) env('DEV_LATITUDE');
            $weather = $this->getWeather();
            $this->say($this->formatter->getFormattedForecast($weather));
        });

    }

    private function getWeather():Weather
    {
         return $this->apiWorker->getWeather($this->latitude,$this->longitude);
    }

    //todo :: Поставить при деплое
//    private function getLocation()
//    {
//        $locationQuestion = config(self::ASK_LOCATION);
//        $this->askForLocation($locationQuestion,function (Location $location){
//           $this->longitude = $location->getLongitude();
//           $this->latitude = $location->getLatitude();
//        });
//    }
}
