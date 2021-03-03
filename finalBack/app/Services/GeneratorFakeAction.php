<?php


namespace App\Services;

use App\Models\User;


class GeneratorFakeAction
{

    private $user;

    public function __construct($id)
    {
        $this->user = User::find($id);
    }

    public function generate()
    {
        $startDate = time();
        $m = $this->timeChanger(time(), "-2 years");
        $actionCreator =  new ActionCreator($this->user->id);
        $key = 0;
        for (; $m <= $startDate; $m = $this->timeChanger($m, "+ 1 month")) {
            $uanCount = rand(0,5);
            $usdCount = rand(1,2);
            $i = 0;
            while ($i < $uanCount) {
                $actionCreator->Income(rand(10000,50000),"UAH",date("Ymd",$m));
                $i++;
            }
            $i = 0;
            while ($i < $usdCount) {
                $prevAction = $actionCreator->Income(rand(500,2000),"USD", date("Ymd",$m));
                if ($this->user->force_exchange_flag == 1) {
                    $actionCreator->forceExchange($prevAction->sum,$prevAction->currency,date("Ymd",$m),rand(26,29), $this->user->force_exchange_percentage);
                }
                $i++;
            }
            if ($key >= 12) {
                $actionCreator->exchange(rand(200,500), "USD", date("Ymd",$m),rand(26,29));
            }
            $key++;
        }
    }

    private function timeChanger($time, $quantity)
    {
        return strtotime(date("Ymd", $time) . $quantity);
    }


}
