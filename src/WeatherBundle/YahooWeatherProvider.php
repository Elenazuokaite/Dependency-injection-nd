<?php
namespace Nfq\WeatherBundle;

class YahooWeatherProvider implements WeatherProviderInterface
{
    public function fetch(Location $location): Weather {

    $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
    $yql_query = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="'.$location->getLat().', '.$location->getLon().'") and u="c"'."\n";
    $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
    $session = curl_init($yql_query_url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
    $json = curl_exec($session);
    $phpObj =  json_decode($json);

        if(!isset($phpObj->query->results->channel->item->condition->temp)) {
            throw new WeatherProviderException('Unexpected unserialized result from YahooWeatherProvider');
        }

        return  new Weather($phpObj->query->results->channel->item->condition->temp);
    }
}