<?php


namespace App\Contracts;


use Illuminate\Support\Collection;

interface Weather
{
    public function __construct(string $weatherInformation);

    /**
     * @param int $daysCount
     * @return Collection
     * Получение погоды по нескольким дням
     */
    public function getSomeDaysWeather(int $daysCount):Collection;


    public function nowWeather():Collection;
}