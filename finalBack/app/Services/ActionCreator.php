<?php


namespace App\Services;


use App\Models\Action;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ActionCreator
{
    private const ACTION = array("Income", "Exchange", "Force exchange");
    private $user;

    public function __construct($id)
    {
        $this->user = User::find($id);
    }

    public function income($sum, $currency, $date)
    {
        $action = new Action();
        $action->kind_action = ActionCreator::ACTION[0];
        $action->sum = $sum;
        $action->currency = strtoupper($currency);
        $action->description = $action->sum . ' ' . $action->currency . ' credited to the account';
        $action->user_id = $this->user->id;
        $action->date = $date;
        $action->save();
        return $action;
    }

    public function exchange($exchangeSum, $currency, $date, $rate)
    {
        $possibleSum = $this->checkCount($this->user->id, $currency);
        if ($possibleSum > $exchangeSum) {
            $action = new Action();
            $action->kind_action = ActionCreator::ACTION[1];
            $action->sum = $exchangeSum;
            $action->currency = strtoupper($currency);
            $action->description = $action->sum . ' ' . $action->currency . ' converted to ' . $action->sum * $rate . ' with rate ' . $rate;
            $action->user_id = $this->user->id;
            $action->rate = $rate;
            $action->date = $date;
            $action->save();
        } else {
            return 'Not enough money in the account';
        }
    }

    public function forceExchange($exchangeSum, $currency, $date, $rate, $exchangePercentage)
    {
        //$rate = $this->getCurrencyRate($prevAction->currency, $prevAction->date);
        $possibleSum = $this->checkCount($this->user->id, $currency);
        if ($possibleSum > ($exchangeSum * $exchangePercentage / 100)) {
            $action = new Action();
            $action->kind_action = ActionCreator::ACTION[2];
            $action->sum = $exchangeSum * $exchangePercentage / 100;
            $action->currency = strtoupper($currency);
            $action->description = $action->sum . ' ' . $action->currency . ' converted to ' . $action->sum * $rate . ' with rate ' . $rate;
            $action->user_id = $this->user->id;
            $action->rate = $rate;
            $action->date = $date;
            $action->save();
        } else {
            return 'Not enough money in the account';
        }
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

    public function checkCount($id, $currency)
    {
        $query = DB::select("SELECT sum(sum) incomeSum
            ,(SELECT sum(sum) FROM `actions` WHERE `kind_action` = 'Force exchange' && `user_id`=$id && `currency`= '$currency') forceSum
            ,(SELECT sum(sum) FROM `actions` WHERE `kind_action` = 'Exchange' && `user_id`=$id && `currency`= '$currency') exchangeSum
            FROM `actions` WHERE `kind_action` = 'Income' && `user_id`=$id && `currency`= '$currency'");
        if ($query[0]->incomeSum != null) {
            $totallySum = $query[0]->incomeSum;
        } else {
            return 0;
        }
        if ($query[0]->forceSum != null) {
            $totallySum -= $query[0]->forceSum;
        }
        if ($query[0]->exchangeSum != null) {
            $totallySum -= $query[0]->exchangeSum;
        }
        return $totallySum;
    }
}
