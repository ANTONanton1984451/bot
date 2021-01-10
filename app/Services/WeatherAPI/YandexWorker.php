<?php


namespace App\Services\WeatherAPI;


use App\Contracts\APIWorker;
use App\Contracts\Weather;
use App\DataObjects\YandexWeather;
use App\Services\CustomHttpClient;


class YandexWorker implements APIWorker
{
    private const YANDEX_API_URL = 'https://api.weather.yandex.ru/v2/forecast?';

    public $httpClient;

    public function __construct(CustomHttpClient $client)
    {
       $this->httpClient = $client;
    }

    public function getWeather(float $latitude, float $longitude) : Weather
    {
        $getWeatherURL = $this->formWeatherURL($latitude,$longitude);

        return new YandexWeather($this->getAPIWeatherData($getWeatherURL));
    }


    private function formWeatherURL(float $latitude,float $longitude) : string
    {
        return self::YANDEX_API_URL."lat=$latitude"."&lon=$longitude";
    }

    private function getAPIWeatherData(string $getWeatherURL) : string
    {
        $headersArray = [
              'headers' => [
                  'X-Yandex-API-Key' => env('YANDEX_API_KEY')
              ]
        ];

        return $this->httpClient->get($getWeatherURL,$headersArray);
    }
}