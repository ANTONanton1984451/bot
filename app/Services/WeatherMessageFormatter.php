<?php


namespace App\Services;
use App\Contracts\Weather;
use Illuminate\Support\Collection;

class WeatherMessageFormatter
{
    private const ONE_DAY_MESSAGE = 'bot_phrases.one_day_message';
    private const DAY_PART_MESSAGE = 'bot_phrases.part_of_day_message';
    /**
     * @var Collection
     */
    private $weatherCollection;

    /**
     * @var string
     */
    private $weatherMessage = '';

    /**
     * @var string
     */
    public $placeholder;

    /**
     * @var Weather
     */
    private $weatherInformation;

    public function __construct()
    {
        $this->placeholder = config('bot_phrases.placeholder');
    }

    public function getFormattedForecast(Weather $weather, int $daysCount = 1) : string
    {
        $this->weatherInformation = $weather;

        if($daysCount === 1){
            $this->formatOneDay();
        }else{
            $this->formatSomeDays($daysCount);
        }

        return $this->weatherMessage;
    }

    private function formatOneDay() : self
    {
        $this->setNowWeather();

        $message = '';
        $this->weatherCollection->each(function ($item) use (&$message){
            foreach (Weather::ONE_DAY_FIELDS as $v){
                $phrases_key = $item[$v];
                if (isset($phrases_key)){
                    $message.= str_replace($this->placeholder,$phrases_key,config(self::ONE_DAY_MESSAGE.'.'.$v))."\n";
                }
            }
        });

        $this->weatherMessage .= $message;
        return $this;
    }

    private function formatSomeDays(int $days) : self
    {
        $message = '';

        $this->setNowWeather()->formatOneDay();
        $this->getSomeDaysWeather($days);

        $formFunction = function ($item) use (&$message){
            $message .= str_replace($this->placeholder,config(self::DAY_PART_MESSAGE.'date'),$item['date']);
            foreach (Weather::DAY_PARTS as $dayPart){
                foreach (Weather::PART_OF_DAY_FIELDS as $part){
                    $message .= str_replace($this->placeholder,$item[$dayPart][$part],config(self::DAY_PART_MESSAGE.'.'.$part))."\n";
                }
            }
        };

        $this->weatherCollection->each($formFunction);
        $this->weatherMessage .= $message;

        return $this;
    }

    private function getSomeDaysWeather(int $days) : self
    {
       $this->weatherCollection = $this->weatherInformation->getSomeDaysWeather($days);
        return $this;
    }

    private function setNowWeather() : self
    {
        $this->weatherCollection = $this->weatherInformation->nowWeather();
        return $this;
    }
}