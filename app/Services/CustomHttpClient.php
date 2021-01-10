<?php


namespace App\Services;


use Prophecy\Exception\Doubler\MethodNotFoundException;

class CustomHttpClient
{
    private const HTTP_METHODS = [
        'POST',
        'GET',
        'DELETE',
        'PUT',
        'UPDATE'
    ];

    public function __call($name,$arguments)
    {
        if(in_array(strtoupper($name),self::HTTP_METHODS)){
            return $this->sendRequest($name,$arguments[0],$arguments[1]);
        }else{
            throw new MethodNotFoundException('No such HTTP method in this class',self::class,$name);
        }
    }

    public function sendRequest(string $requestType,string $url,array $options) : string
    {
        $curl = curl_init($url);

        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,strtoupper($requestType));
        curl_setopt($curl,CURLOPT_HTTPHEADER,$this->formCurlHeaders($options['headers']));
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $curlResult = curl_exec($curl);

        curl_close($curl);
        return $curlResult;
    }

    private function formCurlHeaders(array $headers) : array
    {
        $curl_headers = [];
        foreach (array_keys($headers) as $v){
            $curl_headers[] = $v.': '.$headers[$v];
        }

        return $curl_headers;
    }
}