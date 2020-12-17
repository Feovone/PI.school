<?php


namespace Week2;

use DateTimeImmutable;
use DateInterval;
use Exception;

class TimeSelector
{
    private DateTimeImmutable $utcTime;
    private array $selectedTimes;
    private array $dataCities;
    private array $forecastArrayByTime = array();
    private int $shift;
    private int $shiftInterval = 0;


    /**
     * @return array
     */
    public function getForecastArrayByTime(): array
    {
        return $this->forecastArrayByTime;
    }

    public function __construct($dataCities, $selectedTimes)
    {
        $this->utcTime = new DateTimeImmutable('UTC');
        $this->dataCities = $dataCities;
        $this->selectedTimes = $selectedTimes;

    }

    public function localToUtc($timezone = 7200, $addedInterval = "Unknown")
    {
        $this->shift = $timezone / 3600;
        if ($addedInterval == "Unknown") {
            $addedInterval = 24 + $this->shift;
        }
        if ($this->shift % 3 != 0) {
            while (($this->shift - $this->shiftInterval) % 3 != 0)
                $this->shiftInterval++;
        }
        try {
            $this->utcTime = $this->utcTime->add(new DateInterval("PT" . $addedInterval . "H"));
        } catch (Exception $e) {
        }
    }

    public function selectObjByTime()
    {
        foreach ($this->selectedTimes as $key => $hour) {
            //Проверка на кратность 3 с учётом сдвига
            $isNotMultiple = false;
            while (($hour - $this->shiftInterval) % 3 != 0) {
                $hour--;
                $isNotMultiple = true;
            }
            //Выборка времени/временых интервалов для каждого города
            foreach ($this->dataCities as $keyC => $city) {
                foreach ($city as $keyT => $timezone) {
                    //Перебираем пока не найдём сходство по дню и часу ($hour)
                    $tempTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $timezone->dt_txt);
                    $tempTime = $this->addSubInterval($tempTime);
                    if ($this->utcTime->format('d') == $tempTime->format('d')) {
                        if ($tempTime->format('H') == $hour) {
                            $this->getTimeForCity($city, $keyT, $keyC, $isNotMultiple);
                            break;
                        }
                    }
                }
            }
        }
        //Приведение времени и температуры подходящей под выбраные часы
        $this->averageTemperatureTime();
    }

    private function getTimeForCity($city, $keyT, $keyC, $isNotMultiple)
    {
        try {
            $tempArray = array();
            array_push($tempArray, $city[$keyT]);
            //Если не кратное 3 тогда выбираем 2 времени для среднего
            if ($isNotMultiple == true) {
                array_push($tempArray, $city[$keyT + 1]);
            }
            //Если для этого массива ещё нет данных, создаем массив для них
            if (!isset($this->forecastArrayByTime[$keyC])) {
                $this->forecastArrayByTime[$keyC] = array();
            }
            //Переносим выбранные данные в массив определенного города
            foreach ($tempArray as $temp) {
                $t = array(clone $temp, $temp->main->temp);
                array_push($this->forecastArrayByTime[$keyC], $t);
            }
        } catch (Exception $e) {
            print($e . " This time can't be get");
        }
    }

    private function addSubInterval($time)
    {
        if ($this->shift < 0) {
            try {
                return $time->sub(new DateInterval("PT" . abs($this->shift) . "H"));
            } catch (Exception $e) {
            }
        } else if ($this->shift > 0) {
            try {
                return $time->add(new DateInterval("PT" . $this->shift . "H"));
            } catch (Exception $e) {
            }
        } else {
            return $time;
        }
    }

    private function averageTemperatureTime()
    {
        foreach ($this->selectedTimes as $key => $hour) {
            for ($i = 0; $i < count($this->forecastArrayByTime); $i++) {
                $isNotMultiple = ($hour - $this->shiftInterval) % 3 != 0;
                $this->temperatureTimeCorrector($i, $key, $hour, $isNotMultiple);
            }
        }
    }

    private function temperatureTimeCorrector($city, $key, $hour, $isNotMultiple)
    {
        $tempTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->forecastArrayByTime[$city][$key][0]->dt_txt);
        $tempTime = $this->addSubInterval($tempTime);
        if ($isNotMultiple == true) {
            $tempTime = $this->distinction($city, $key, $hour, $tempTime);
        }
        $this->forecastArrayByTime[$city][$key][0]->dt_txt = $tempTime;
    }

    private function distinction($city, $key, $hour, $tempTime)
    {
        //Вычислить приблизительное изменение
        $distinction = ($this->forecastArrayByTime[$city][$key + 1][1] - $this->forecastArrayByTime[$city][$key][1]) / 3;
        $tempChange = 0;
        //Перебираем часы пока не дойдем до нужного, попутно записываем изменение в температуре
        while ($tempTime->format('H') != $hour) {
            $tempTime = $tempTime->add(new DateInterval("PT1H"));
            $tempChange += $distinction;
        }
        $this->forecastArrayByTime[$city][$key][1] += number_format($tempChange, 2, '.', '');
        //Удаляем не нужный елемент
        array_splice($this->forecastArrayByTime[$city], $key + 1, 1);
        return $tempTime;
    }
}