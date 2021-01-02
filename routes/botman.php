<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

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

$botman->hears('Remember me',\App\Http\Controllers\TestController::class.'@rememberUser');

$botman->hears('How old {name}',\App\Http\Controllers\TestController::class.'@showAges');
