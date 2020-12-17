<?php

namespace Week2;

include "WeatherParser.php";
include "TimeSelector.php";
include "View.php";
include "Writers.php";

$apiKey = "3481941d6f4af94277a5d2524e7c9732";
//$citiesIds = array("703448","2950159","5128638","5368361");
$citiesNames = array("Kiev", "Berlin", "New York", "Los Angeles");
//$argv[1] = "alaska";
if (isset($argv[1])) {
    $selectedTimes = array(8, 12, 16, 20);
    $dataCity = new WeatherParser($apiKey, array($argv[1]));
    if (strtolower(isset($argv[2])) != strtolower($dataCity->getCitiesInfo()[0]->country)) {
        echo "Warning:Country code entered and found is different\r\n";
    }
    $selectedTime = new TimeSelector($dataCity->getCitiesArray(), $selectedTimes);
    $selectedTime->localToUtc($dataCity->getCitiesInfo()[0]->timezone, "Unknown");
    $selectedTime->selectObjByTime();
    $writer = new ConsoleWriter($selectedTime->getForecastArrayByTime(), $dataCity->getCitiesInfo());
    $view = new View();
    $view->write($writer);
} else {
    $selectedTimes = array(22);
    $dataCities = new WeatherParser($apiKey, $citiesNames);
    $selectedTime = new TimeSelector($dataCities->getCitiesArray(), $selectedTimes);
    $selectedTime->localToUtc();
    $selectedTime->selectObjByTime();
    $writer = new FileWriter($selectedTime->getForecastArrayByTime(), $citiesNames);
    $view = new View();
    $view->write($writer);
}
