<?php


namespace App\DataObjects;


use App\Contracts\Weather;
use Illuminate\Support\Collection;

class YandexWeather implements Weather
{

    public function __construct(string $weatherInformation)
    {
    }

    public function getSomeDaysWeather(int $daysCount): Collection
    {
        // TODO: Implement getSomeDaysWeather() method.
    }

    public function nowWeather(): Collection
    {
        // TODO: Implement nowWeather() method.
    }
}