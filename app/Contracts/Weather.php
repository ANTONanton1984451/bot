<?php


namespace App\Contracts;


use Illuminate\Support\Collection;

interface Weather
{
    public const ONE_DAY_FIELDS = [
        'hour',
        'temp',
        'temp_like',
        'condition',
    ];

    public const PART_OF_DAY_FIELDS = [

        'temp_avg',
        'temp_like',
    ];

    public const DAY_PARTS = [
        'night' => 'night',
        'morning' => 'morning',
        'day' => 'day',
        'evening' => 'evening'
    ];

    public function __construct(string $weatherInformation);

    /**
     * @param int $daysCount
     * @return Collection
     * Получение погоды по нескольким дням кроме первого
     */
    public function getSomeDaysWeather(int $daysCount):Collection;


    public function nowWeather():Collection;
}