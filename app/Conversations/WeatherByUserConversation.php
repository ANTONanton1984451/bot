<?php

namespace App\Conversations;

use App\Contracts\APIWorker;
use App\Services\WeatherMessageFormatter;
use App\User;
use BotMan\BotMan\Messages\Conversations\Conversation;

class WeatherByUserConversation extends Conversation
{
    public $apiWorker;
    public $messageFormatter;

    /**
     * @var int
     */
    public $dayCount;
    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;

    /**
     * @var User
     */
    public $user;

    public function __construct(APIWorker $apiWorker,WeatherMessageFormatter $formatter)
    {
        //todo :: при деплое
//        $this->user = User::find($this->bot->getUser()->getId());
        $this->apiWorker = $apiWorker;
        $this->messageFormatter = $formatter;
    }
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->setUserInformation();
        $weather = $this->apiWorker->getWeather($this->latitude,$this->longitude);
        $answer = $this->messageFormatter->getFormattedForecast($weather,$this->dayCount);
        $this->say($answer);
    }





    private function setUserInformation(){
        $this->dayCount = (integer) env('DEV_DAYS_COUNT');
        $this->latitude = (float) env('DEV_LATITUDE');
        $this->longitude = (float) env('DEV_LONGITUDE');
    }
//    todo поставить при деплое раскоментить
//    private function setUserInformation()
//    {
//        $this->dayCount = $this->user->days_count;
//        $this->longitude = $this->user->longitude;
//        $this->latitude = $this->user->latitude;
//    }

}
