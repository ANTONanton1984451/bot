<?php


namespace App\DataObjects;


use App\Contracts\Weather;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use function GuzzleHttp\Psr7\str;

class YandexWeather implements Weather
{
    private const YANDEX_DATE_FORMAT = 'Y-m-d';
    private const WEATHER_INFO_INTERVAL = 5;
    private const HOURS_IN_DAY = 24;

    private const API_ONE_DAY_CONFORMITY = [
        'hour',
        'temp',
        'feels_like',
        'condition',
    ];

    private const API_DAY_PART_CONFORMITY = [
        'temp_avg',
        'feels_like',
    ];
    /**
     * @var array
     */
    private $weatherInformation;

    public function __construct(string $weatherInformation)
    {
        $this->weatherInformation = json_decode($weatherInformation,true);
    }

    public function getSomeDaysWeather(int $daysCount): Collection
    {
        if($daysCount === 1){
           return  $this->nowWeather();
        }
        return $this->formSomeDaysWeather($daysCount);
    }

    /**
     * @return Collection
     * Метод возвращает коллекцию с фиксированными полями
     */
    public function nowWeather(): Collection
    {
        $nowDayInfo = $this->weatherInformation['forecasts'][0]['hours'];

        if($this->isNeedleNextDay()){
              $nowWeatherInfo = $this->formNowWeather($nowDayInfo,$this->getNowHour());

              $tomorrowDayInfo = $this->weatherInformation['forecasts'][1]['hours'];
              $needleHours = abs($this->hoursBeforeEndDay());
              $yesterdayWeatherInfo  = $this->formNowWeather($tomorrowDayInfo,0,$needleHours);
              return collect(array_merge($nowWeatherInfo,$yesterdayWeatherInfo));
        }else{
              $nowWeatherInfo = $this->formNowWeather($nowDayInfo,$this->getNowHour(),$this->getNowHour()+self::WEATHER_INFO_INTERVAL);
              return collect($nowWeatherInfo);
        }

    }


    private function getNowHour() : int
    {
       return Carbon::now($this->getTimeZone())->hour;
    }

    private function isNeedleNextDay() : bool
    {
        return $this->hoursBeforeEndDay() < 0;
    }

    private function hoursBeforeEndDay() : int
    {
        return self::HOURS_IN_DAY - ($this->getNowHour() + self::WEATHER_INFO_INTERVAL);
    }

    /**
     * @param array $nowDayInfo
     * @param int $start
     * @param int $end
     * @return array
     * Отбирает данные из данных полученных из АПИ и преобразовывает их определённым полям в массиве на основе
     * массива соответствий ONE_DAY_FIELDS
     */
    private function formNowWeather(array $nowDayInfo,int $start,int $end = self::HOURS_IN_DAY) : array
    {
        $nowWeatherInfo = [];

        for ($i = $start; $i < $end; $i++){
            $nowHour = $nowDayInfo[$i];
            $nowHourSelected = [];

            $conformity = array_combine(self::ONE_DAY_FIELDS,self::API_ONE_DAY_CONFORMITY);

            foreach ($conformity as $k => $v){
                $nowHourSelected[$k] = $nowHour[$v];
            }

            $nowWeatherInfo[] = $nowHourSelected;
        }

        return  $nowWeatherInfo;
    }

    private function formSomeDaysWeather(int $daysCount) : Collection
    {
        $weatherInfo= [];
        $conformity = array_combine(self::PART_OF_DAY_FIELDS,self::API_DAY_PART_CONFORMITY);
        for ($i=0; $i < $daysCount;$i++){

            $weatherSelectedInfo = [];
            $oneDayWeather = $this->weatherInformation['forecasts'][$i];
            $weatherSelectedInfo['date'] = $oneDayWeather['date'];

            foreach (self::DAY_PARTS as $dayPart){
                foreach ($conformity as $original => $api){
                     $weatherSelectedInfo[$dayPart][$original] = $oneDayWeather['parts'][$dayPart][$api];
                }
            }

            $weatherInfo[] = $weatherSelectedInfo;
        }
        return collect($weatherInfo);
    }


    private function getTimeZone() : string
    {
        return $this->weatherInformation['info']['tzinfo']['name'];
    }
}