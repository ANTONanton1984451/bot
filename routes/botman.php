<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('/start',\App\Http\Controllers\IntroductionController::class.'@startIntroduction');

$botman->hears('/weather',\App\Http\Controllers\GetWeatherController::class.'@showWeather');





$botman->hears('Start conversation', BotManController::class.'@startConversation');


$botman->fallback(function ($bot) {
   $bot->reply('i dont understand u');
});
