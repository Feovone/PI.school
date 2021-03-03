<?php

namespace App\Http\Controllers;

use App\Mail\TaxReport;
use App\Services\MailState;
use App\Services\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    private $mailState;

    public function __construct()
    {
        $this->mailState = new MailState();
        $current_month =date('m');
        $current_day = date('d');

        if($current_day == 2){
            if($current_month == 1 ||$current_month == 4 ||$current_month == 7 ||$current_month == 10){
                $this->everyQuarter();
            }else{
                $this->everyMonth();
            }
        }

    }

    private function everyMonth(){

        $users=$this->mailState->getEveryMonth();
        $endDate = date('Ymd');
        $diff = strtotime('-1 month');
        $startDate =date('Ymd', $diff);

        foreach ($users as $user){
            $report = new Report($startDate,$endDate,$user->id,$user->tax_rate);
            Mail::to($user->email)->send(new TaxReport($report->makeReport(),$startDate,$endDate));
        }
    }
    private function everyQuarter(){
        $users=$this->mailState->getEveryQuarter();
        var_dump($users);
        $endDate = date('Ymd');
        $diff = strtotime('-3 month');
        $startDate =date('Ymd', $diff);

        foreach ($users as $user){
            $report = new Report($startDate,$endDate,$user->id,$user->tax_rate);
            Mail::to($user->email)->send(new TaxReport($report->makeReport(),$startDate,$endDate));
        }

    }

}
