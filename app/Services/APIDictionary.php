<?php


namespace App\Services;


class APIDictionary
{
    private const TRANSLATION = 'bot_phrases.translations';


    public function translate(string $word)
    {
        $translatedWord = $word;
        $translations = config(self::TRANSLATION);
        $translationsWords = array_keys($translations);

        if(in_array($word,$translationsWords)){
            $translatedWord = $translations[$word];
        }
        return $translatedWord;
    }
}