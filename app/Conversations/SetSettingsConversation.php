<?php

namespace App\Conversations;

use App\User;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Support\Facades\Config;

class SetSettingsConversation extends Conversation
{

    public const GET_LOCATION = 'bot_phrases.get.location';
    public const COMPLETE_SAVING = 'bot_phrases.introduction.complete_saving';

    private $user_id;
    private $is_bot;
    private $first_name;
    private $username;

    public $latitude;
    public $longitude;

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->setUserInformation();
        $this->askPermanentLocation();
    }

    private function askPermanentLocation()
    {
        $getLocationMessage = config(self::GET_LOCATION);
        //todo::исправить при деплое на сервер
        $this->ask($getLocationMessage,function (Answer $location){
//        $this->askForLocation($getLocationMessage,function (Location $location){

//           $this->latitude = $location->getLatitude();
//           $this->longitude =  $location->getLongitude();

           $this->saveSettings();

           $goodbye_message = \config(self::COMPLETE_SAVING);

           $this->say($goodbye_message);
        });
    }


    private function setUserInformation()
    {
        $this->user_id = $this->bot->getUser()->getId();
        //todo::включить при деплоя для телеги
//        $this->is_bot = $this->bot->getUser()->getInfo()['is_bot'];
        $this->first_name = $this->bot->getUser()->getFirstName();
        $this->username = $this->bot->getUser()->getUsername();
    }

    public function saveSettings()
    {
        User::create($this->formSettings());
    }

    public function formSettings():array
    {
        return [
            'id'  => rand(0,100000),
            'is_bot' => false,
            'username' => 'test',
            'first_name' => 'test',
            'longitude' => 59.9386,
            'latitude' => 30.3141,
        ];
    }

}
