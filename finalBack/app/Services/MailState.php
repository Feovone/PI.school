<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;

class MailState
{
    public function getEveryMonth()
    {
        return DB::table('users')->select('*')->where('notification_period', 'Every month')->get();
    }

    public function getEveryQuarter()
    {
        return DB::table('users')->select('*')->where('notification_period', 'Every quarter')->get();
    }
}
