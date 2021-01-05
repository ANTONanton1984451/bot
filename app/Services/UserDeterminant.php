<?php


namespace App\Services;


use App\User;
use BotMan\BotMan\BotMan;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserDeterminant
{
    /**
     * @var BotMan
     */
    private $bot;

    public function setBot(BotMan $bot)
    {
        $this->bot = $bot;
    }


    /**
     * @return bool
     * Определяет,есть ли настройки в БД для этого пользователя или нет
     */
    public function isUserDetermine() : bool
    {
        try {
            User::findOrFail($this->getUserId());
        }catch (ModelNotFoundException $e){
            return false;
        }

        return true;
    }

    private function getUserId() : int
    {
        //todo Поменять при деплое ларавеля
//        return  $this->bot->getUser()->getId();
        return env('DEV_USER_ID');
    }
}