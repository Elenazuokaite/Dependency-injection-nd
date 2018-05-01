<?php

namespace Nfq\WeatherBundle;

class OpenWeatherMapWeatherProvider implements WeatherProviderInterface
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch(Location $location): Weather
    {
        // TODO: Implement this
        $response = file_get_contents("http://api.openweathermap.org/data/2.5/weather?lat=".$location->getLat()."&lon=".$location->getLon()."&units=metric&appid=".$this->apiKey);
        $deals = json_decode($response, true);
        $temp = $deals["main"]["temp"];
        if(!isset($temp)) {
        throw new WeatherProviderException('Unexpected unserialized result from OpenWeatherMapWeatherProvider');
    }
    return  new Weather($temp);
       // return new Weather(24.1);
    }
}
