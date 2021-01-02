<?php

namespace App\Conversations;

use App\Test;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class TestConversation extends Conversation
{
    protected $age;

    protected $name;
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askName();
    }

    public function askName()
    {
        $this->ask('Please,say you name',function (Answer $answer){
            $this->name = $answer->getText();
            $this->askAge();
        });
    }

    public function askAge()
    {
        $this->ask('And say you age',function (Answer $answer){
           $this->age = $answer->getText();
           $this->saveInfo();
           $this->say('Thanks,u are in list!');
        });
    }

    public function saveInfo()
    {

        $test = new Test();
        $test->name = $this->name;
        $test->age = $this->age;
        $test->save();
    }
}
