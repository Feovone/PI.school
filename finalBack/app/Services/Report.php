<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class Report
{
    private $startDate;
    private $endDate;
    private $currency="USD";
    private $id;
    private $tax;

    public function __construct($startDate, $endDate, $userID,$tax)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->id = $userID;
        $this->tax = $tax;
    }

    public function makeReport()
    {
        $income =$this->totalIncome();
        $tax = $income * ($this->tax/100);
       return'"income":"'.$income.'","tax":"'.$tax.'"';
    }

    private function totalIncome()
    {
        //exchange difference
        $sellingDiff = $this->exchangeDifference();
        //income in foreign currency
        $foreignProfit = $this->foreignToUah($this->queries("foreign"));
        //income in UAH and exchange foreign currency
        $uahProfit = $this->uahSum($this->queries("profit"));

        return $totalProfit = $foreignProfit + $uahProfit + $sellingDiff;
    }

    private function exchangeDifference()
    {
        $cash = $this->totallySum($this->queries("sumDiff"));
        $forcedCash = $this->forceSeparator($cash, $this->queries("forceIncome"));
        $forcedCash = array_reverse($forcedCash);
        return $this->differenceCalculate($forcedCash, $this->queries("exchangeDiff"));
    }

    private function uahSum($profit)
    {
        $sum = 0;
        if ($profit[0]->uahSum != null) {
            $sum += $profit[0]->uahSum;
        }
        if ($profit[0]->uahForceSum != null) {
            $sum += $profit[0]->uahForceSum;
        }
        return $sum;
    }

    private function foreignToUah($foreignArray)
    {
        $sum = 0;
        $force = 0;
        foreach ($foreignArray as $foreign) {
            if ($foreign->kind_action == "Force exchange") {
                $force += $foreign->sum * $this->getCurrencyRate($foreign->currency, $foreign->date);
            } else {
                $sum += $foreign->sum * $this->getCurrencyRate($foreign->currency, $foreign->date);
            }

        }
        return $sum - $force;
    }

    private function queries($query)
    {
        switch ($query) {
            case "sumDiff" :
                $property = "and `user_id`=$this->id and `currency`= '$this->currency' and `date`<'$this->startDate'";
                $forceSum = "SELECT sum(sum) FROM `actions` WHERE `kind_action` = 'Force exchange' $property";
                $exchangeSum = "SELECT sum(sum) FROM `actions` WHERE `kind_action` = 'Exchange' $property";
                return DB::select("SELECT sum(sum) incomeSum,($forceSum) forceSum,($exchangeSum) exchangeSum
                    FROM `actions` WHERE `kind_action` = 'Income' $property");
            case "forceIncome":
                return DB::select("SELECT * from actions WHERE (kind_action= 'Income' or kind_action = 'Force exchange')
                    and `currency` = '$this->currency' and `date`<'$this->startDate' ORDER BY date DESC, id DESC");
            case "exchangeDiff":
                return DB::select("SELECT * from actions WHERE kind_action= 'Exchange' and `currency` = '$this->currency'
                    and `date`>'$this->startDate' and `date`<'$this->endDate'");
            case "profit":
                $property = "and `date`>='$this->startDate' and `date`<='$this->endDate'";
                $uahSum = "SELECT sum(sum) FROM `actions` WHERE `kind_action` = 'Income' and currency='UAH' $property";
                $uahForceSum = "SELECT sum(sum*rate) FROM `actions` WHERE `kind_action` = 'Force exchange' $property";
                return DB::select("SELECT ($uahSum) uahSum,($uahForceSum) uahForceSum from `actions`");
            case "foreign":
                return DB::select("SELECT * FROM `actions` WHERE (`kind_action` = 'Income'  or `kind_action` ='Force exchange') and `currency` != 'UAH'
                    and `date`>='$this->startDate' and `date`<='$this->endDate'");
        }
    }

    private function differenceCalculate($afterCash, $exchanges)
    {
        $prevCost = 0;
        $selectedCost = 0;
        for ($i = 0; $i < count($exchanges); $i++) {
            $selectedRate = $exchanges[$i]->rate;
            foreach ($afterCash as $key => $cash) {
                if ($cash->sum != 0) {
                    $prevRate = $this->getCurrencyRate($this->currency, $cash->date);
                    $diff = $exchanges[$i]->sum - $cash->sum;
                    if ($diff > 0) {
                        $exchanges[$i]->sum = $exchanges[$i]->sum - $cash->sum;
                        $this->calCash($prevCost, $selectedCost, $cash, $prevRate, $selectedRate, $this->startDate);
                        $afterCash[$key]->sum = 0;
                    } else {
                        $this->calCash($prevCost, $selectedCost, $exchanges[$i], $prevRate, $selectedRate, $this->startDate);
                        $afterCash[$key]->sum = $cash->sum - $exchanges[$i]->sum;
                        $exchanges[$i]->sum = 0;
                        break;
                    }
                }
            }
        }
        return ($selectedCost - $prevCost) * 0.05;
    }

    private function totallySum($sumDiff)
    {
        if ($sumDiff[0]->incomeSum != null) {
            $totallySum = $sumDiff[0]->incomeSum;
        } else {
            return 0;
        }
        if ($sumDiff[0]->forceSum != null) {
            $totallySum -= $sumDiff[0]->forceSum;
        }
        if ($sumDiff[0]->exchangeSum != null) {
            $totallySum -= $sumDiff[0]->exchangeSum;
        }
        return $totallySum;
    }

    private function forceSeparator(&$cash, $forceIncome)
    {

        $forceSum = 0;
        $currentDate = '';
        $afterCash = array();
        for ($i = 0; $i < count($forceIncome); $i++) {
            if ($forceSum != 0) {
                if ($currentDate != $forceIncome[$i]->date) {
                    exit ('Incorrect data');
                }
            }
            while ($forceIncome[$i]->kind_action == "Force exchange") {
                $forceSum += $forceIncome[$i]->sum;
                $i++;
            }
            $forceIncome[$i]->sum -= $forceSum;
            if ($forceIncome[$i]->sum > 0) {
                $forceSum = 0;
                $cash -= $forceIncome[$i]->sum;
                if ($cash <= 0) {
                    $afterCash[$i] = $forceIncome[$i];
                    $afterCash[$i]->sum = $forceIncome[$i]->sum - abs($cash);
                    break;
                } else {
                    $afterCash[$i] = $forceIncome[$i];
                }
            } else {
                $currentDate = $forceIncome[$i]->date;
                $forceSum = abs($forceIncome[$i]->sum);
            }
        }
        return $afterCash;
    }

    private function calCash(&$prevCost, &$selectedCost, $res, $prevRate, $selectedRate, $startDate)
    {
        $prevCost += $res->sum * $prevRate;
        $selectedCost += $res->sum * $selectedRate;
    }

    private function getCurrencyRate($currency, $date)
    {
        if (gettype($date) == "string") {
            $date = strtotime($date);
        }
        $date = date("Ymd", $date);
        $info = file_get_contents('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?valcode='
            . $currency . '&date=' . $date . '&type=json');
        $info = json_decode($info, true);

        return $info[0]["rate"];

    }
}
