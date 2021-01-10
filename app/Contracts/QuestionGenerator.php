<?php


namespace App\Contracts;


use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Outgoing\Question;

interface QuestionGenerator
{
    public const BOT_CONFIG = 'bot_phrases';
    public function getQuestion():Question;
}