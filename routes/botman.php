<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('/start',\App\Http\Controllers\IntroductionController::class.'@startIntroduction');



$botman->hears('Hi', function ($bot) {
    $bot->reply(file_get_contents('https://yandex.ru'));
});


$botman->hears('Hello BotMan!', function($bot) {
    $bot->reply('Hello!');
    $bot->ask('Whats your name?', function($answer, $bot) {
        $bot->say('Welcome '.$answer->getText());
    });
});



$botman->hears('Start conversation', BotManController::class.'@startConversation');



$botman->fallback(function ($bot) {
   $bot->reply('i dont understand u');
});
