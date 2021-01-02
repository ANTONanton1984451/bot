<?php

namespace App\Http\Controllers;

use App\Conversations\TestConversation;
use App\Test;
use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function showAges(BotMan $bot,string $name)
    {
       $response = Test::where(['name'=>$name])->get(['age'])->toArray();
       $response_str = 'Oh it is about'. implode('or',$response);

       $bot->reply($response_str);
    }

    public function rememberUser(BotMan $bot)
    {
        $bot->startConversation(new TestConversation());
    }
}
