<?php


namespace App\Services\WeatherAPI;


use App\Contracts\APIWorker;
use App\Contracts\Weather;
use App\DataObjects\YandexWeather;
use GuzzleHttp\Client;

class YandexWorker implements APIWorker
{
    private const YANDEX_API_URL = 'https://api.weather.yandex.ru/v2/forecast?';

    private $httpClient;

    public function __construct(Client $client)
    {
       $this->httpClient = $client;
    }

    public function getWeather(float $latitude, float $longitude) : Weather
    {
        $getWeatherURL = $this->formWeatherURL($latitude,$longitude);

        return new YandexWeather($getWeatherURL);
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

        $response = $this->httpClient->get($getWeatherURL,$headersArray);

        return (string) $response->getBody();
    }
}