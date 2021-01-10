<?php

namespace App\Conversations;


use App\Contracts\QuestionGenerator;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class IntroductionConversation extends Conversation
{
    private const REJECT_SET_SETTINGS = 'bot_phrases.introduction.set_settings_rejection';

    private $questionGenerator;

    //todo::если заприватить это свойство,то ничего работать не будет,т.к. оно вызывается в анонмимной функции
    // и по факту это свойство вызывается в другом объекте Closure и соответственно теряется из области видимости,если оно становится
    //приватным
    public $setSettingsConversation;

    public function __construct(QuestionGenerator $generator,Conversation $conversation)
    {
        $this->questionGenerator = $generator;
        $this->setSettingsConversation = $conversation;
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */

    public function run()
    {
        $this->askIsNeedleSettings();
    }

    private function askIsNeedleSettings()
    {
        $this->ask($this->questionGenerator->getQuestion(),function (Answer $answer){
            $this->provideAnswer($answer->getValue());
        });
    }

    private function provideAnswer(string $answer)
    {
        if($answer === 'yes'){
            $this->bot->startConversation($this->setSettingsConversation);
        }else{
            $rejectSetSettings = config(self::REJECT_SET_SETTINGS);

            $this->say($rejectSetSettings);
        }
    }
}
