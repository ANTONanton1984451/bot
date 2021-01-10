<?php

namespace App\Conversations;

use App\Contracts\QuestionGenerator;
use App\User;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
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
    public $daysCount;

    public $weatherDaysCountQuestion;

    public function __construct(QuestionGenerator $generator)
    {
            $this->weatherDaysCountQuestion = $generator;
    }


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

    private function askPermanentLocation() : void
    {
        $getLocationMessage = config(self::GET_LOCATION);
        //todo::исправить при деплое на сервер
        $this->ask($getLocationMessage,function (Answer $location){
//        $this->askForLocation($getLocationMessage,function (Location $location){

//           $this->latitude = $location->getLatitude();
//           $this->longitude =  $location->getLongitude();
            $this->ask($this->weatherDaysCountQuestion->getQuestion(),function (Answer $answer){
                if($answer->isInteractiveMessageReply()){
                     $this->daysCount = $answer->getValue();
                     $this->saveSettings();
                     $this->sayGoodBye();
                }
            });
        });
    }

    private function setUserInformation() : void
    {
        $this->user_id = $this->bot->getUser()->getId();
        //todo::включить при деплоя для телеги
//        $this->is_bot = $this->bot->getUser()->getInfo()['is_bot'];
        $this->first_name = $this->bot->getUser()->getFirstName();
        $this->username = $this->bot->getUser()->getUsername();
    }

    public function saveSettings() : void
    {
        User::create($this->formSettings());
    }
    //todo:: заменить реализацию при деплое
    public function formSettings():array
    {
        return [
            'id'  => env('DEV_USER_ID'),
            'is_bot' => false,
            'username' => 'test',
            'first_name' => 'test',
            'days_count' => 7,
            'longitude' => 59.9386,
            'latitude' => 30.3141,
        ];
    }

    public function sayGoodBye() :void
    {
        $goodbye_message = \config(self::COMPLETE_SAVING);

        $this->say($goodbye_message);
    }

}
