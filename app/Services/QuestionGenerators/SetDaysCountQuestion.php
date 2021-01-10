<?php


namespace App\Services\QuestionGenerators;


use App\Contracts\QuestionGenerator;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class SetDaysCountQuestion implements QuestionGenerator
{

    private const DAYS_COUNT = self::BOT_CONFIG.'.introduction.days_count_question';
    private const DAYS_OF_WEEK = 7;

    public function getQuestion(): Question
    {
        $dayCountQuestion = config(self::DAYS_COUNT);

        $question = Question::create($dayCountQuestion);
        $this->addButtons($question);
        return $question;
    }

    private function addButtons(Question $question) : void
    {
        $buttons = [];

        for ($i=1;$i <= self::DAYS_OF_WEEK;$i++)
            $buttons[] = Button::create("$i")->value($i);
        $question->addButtons($buttons);
    }
}