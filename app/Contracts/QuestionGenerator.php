<?php


namespace App\Contracts;


use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Outgoing\Question;

interface QuestionGenerator
{
    public function __construct(BotMan $bot);

    public function getQuestion():Question;
}