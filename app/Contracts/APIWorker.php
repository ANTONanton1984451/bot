<?php


namespace App\Contracts;


interface APIWorker
{
    public function getWeather(float $latitude,float $longitude):Weather;
}