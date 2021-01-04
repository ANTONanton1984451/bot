<?php


namespace App\Services\QuestionGenerators;


use App\Contracts\QuestionGenerator;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class SetSettingsQuestion implements QuestionGenerator
{
    private const GREETING= 'bot_phrases.introduction.greeting';
    private const SET_SETTINGS_SUGGESTION = 'bot_phrases.introduction.set_settings_suggestion';

    private $botMan;

    public function __construct(BotMan $bot)
    {
        $this->botMan = $bot;
    }

    public function getQuestion(): Question
    {
        $question = Question::create($this->createText())
            ->addButtons([
               Button::create('Да')->value('yes'),
               Button::create('Нет')->value('no')
            ]);

        return $question;
    }

    private function createText():string
    {
        $userName = $this->botMan->getUser()->getFirstName();

        return config(self::GREETING).", $userName!".config(self::SET_SETTINGS_SUGGESTION);
    }
}