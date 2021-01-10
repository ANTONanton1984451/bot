<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;


class IntroductionController extends Controller
{
    private $introductionConversation;


    public function __construct(Conversation $conversation)
    {
        $this->introductionConversation = $conversation;
    }
    public function startIntroduction(BotMan $bot)
    {
        $bot->startConversation($this->introductionConversation);
    }
}
