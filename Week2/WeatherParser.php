<?php
namespace Week2;

class WeatherParser{

    private string $apiKey;
    private array $citiesNames;
    private array $citiesInfo =array();
    private array $citiesArray=array();

    /**
     * @return array
     */
    public function getCitiesInfo(): array
    {
        return $this->citiesInfo;
    }

    /**
     * @return array
     */
    public function getCitiesArray(): array
    {
        return $this->citiesArray;
    }

    public function __construct($apiKey,$citiesNames)
    {
        $this->apiKey = $apiKey;
        $this->citiesNames = $citiesNames;
        $this->curlParse();
    }

    private function curlParse(){
        $cRequest = curl_init();
        curl_setopt($cRequest, CURLOPT_HEADER, 0);
        curl_setopt($cRequest, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cRequest, CURLOPT_VERBOSE, 0);
        curl_setopt($cRequest, CURLOPT_SSL_VERIFYPEER, false);
        foreach($this->citiesNames as $cityName){
            $apiUrl = "http://api.openweathermap.org/data/2.5/forecast?q=" . $cityName . "&units=metric&APPID=" . $this->apiKey;
            curl_setopt($cRequest, CURLOPT_URL, $apiUrl);
            $response = curl_exec($cRequest);
            $data = json_decode($response);
            if($data->cod==404) {
               exit ($data->cod." ".$data->message);
            }else {
                array_push($this->citiesArray, $data->list);
                array_push($this->citiesInfo, $data->city);
            }
        }
        curl_close($cRequest);
    }
}