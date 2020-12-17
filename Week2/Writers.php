<?php


namespace Week2;


interface Writer
{
    public function write();
}

class FileWriter implements Writer
{
    private array $tableHeader = array("Date");
    private array $tableBody = array();
    private array $forecastArrayByTime;
    private array $citiesName;
    private string $filename = "forecastHistory.csv";

    public function __construct($forecastArrayByTime, $citiesName)
    {
        $this->forecastArrayByTime = $forecastArrayByTime;
        $this->citiesName = $citiesName;
    }

    public function write()
    {
        $this->formatInformation();
        if (file_exists($this->filename)) {
            //Поиск строки для перезаписи
            $i = $this->duplicateFinder();
            //Если нашло перезапишет/запишет в конец
            $file = fopen('forecastHistory.csv', 'c+');
            for ($j = 0; $j < $i; $j++) {
                fgetcsv($file, 1000, ";");
            }
            fputcsv($file, $this->tableBody, ';');
        } else {
            $file = fopen('forecastHistory.csv', 'w');
            fputcsv($file, $this->tableHeader, ";");
            fputcsv($file, $this->tableBody, ';');
        }
        fclose($file);
    }

    private function formatInformation()
    {
        array_push($this->tableBody, $this->forecastArrayByTime[0][0][0]->dt_txt->format('Y-m-d H:i:s'));
        //Записываем заголовок и информацию
        foreach ($this->forecastArrayByTime as $key => $field) {
            array_push($this->tableHeader, $this->citiesName[$key]);
            $temp = sprintf("%+.2f", $field[0][1]);
            array_push($this->tableBody, $temp);
        }
    }

    private function duplicateFinder()
    {
        $file = fopen('forecastHistory.csv', 'r');
        $i = 0;
        while (($data = fgetcsv($file, 1000, ";")) !== FALSE) {
            if ($data[0] == $this->tableBody[0]) {
                break;
            }
            $i++;
        }
        fclose($file);
        return $i;
    }
}

class ConsoleWriter implements Writer
{

    private array $forecastArrayByTime;
    private array $citiesName;

    public function __construct($forecastArrayByTime, $citiesName)
    {
        $this->forecastArrayByTime = $forecastArrayByTime;
        $this->citiesName = $citiesName;
    }

    public function write($numberCity = 0)
    {
        echo $this->citiesName[$numberCity]->name . " " .
            $this->citiesName[$numberCity]->country . "\r\n" .
            "Hours\t\t\t\tTemperature C°" . "\r\n";
        foreach ($this->forecastArrayByTime[$numberCity] as $time) {
            echo $time[0]->dt_txt->format('Y-m-d H:i:s') . "\t\t" .
                sprintf("%+.1fC°", $time[1]) . "\r\n";
        }
    }
}