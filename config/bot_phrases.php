<?php

        /*
        |--------------------------------------------------------------------------
        | Bot phrases
        |--------------------------------------------------------------------------
        |
        |
        |
        |
        |
         */

const PLACEHOLDER = '%';

return [
    'placeholder' => PLACEHOLDER,

    'introduction' => [

        'greeting' => 'Привет',

        'set_settings_suggestion' => 'Желаешь ли ты сделать персональные настройки?',

        'set_settings_rejection' => 'Хорошо,ты можешь просто ввести команду /weather и я покажу погоду',

        'days_count_question' => 'На сколько дней желаешь получать прогноз?',

        'complete_saving' => 'Настройки сохранены,ты можешь их изменить командой /change'

    ],

    'get' => [

        'location' => 'Скинь мне свою геопозицию'

    ],

    'one_day_message' => [

        'hour' => 'Время : '.PLACEHOLDER,

        'temp' => 'Температура :'.PLACEHOLDER,

        'temp_like' => 'Ощущается как :'.PLACEHOLDER,

        'condition' => 'За окном '.PLACEHOLDER,


    ],

    'part_of_day_message' => [

        'part_of_day' => PLACEHOLDER.' :',

        'date' => PLACEHOLDER,

        'temp_avg' => 'Средняя температура :'.PLACEHOLDER,

        'temp_like' => 'Ощущается как :'.PLACEHOLDER,

    ],

    'translations' => [

        'clear' => 'ясно',

        'partly-cloudy' => 'малооблачно',

        'cloudy' => 'облачно',

        'overcast' => 'пасмурно',

        'drizzle' => 'морось',

        'light-rain' => 'небольшой дождь',

        'rain' => 'дождь',

        'moderate-rain' => 'умеренно сильный дождь',

        'heavy-rain' => ' сильный дождь',

        'continuous-heavy-rain' => 'длительный сильный дождь',

        'showers' => 'ливень',

        'wet-snow' => 'дождь со снегом',

        'light-snow' => 'небольшой снег',

        'snow' => 'снег',

        'snow-showers' => 'снегопад',

        'hail' => 'град',

        'thunderstorm' => 'гроза',

        'thunderstorm-with-rain' => 'дождь с грозой',

        'thunderstorm-with-hail' => 'гроза с градом'

    ]
];
