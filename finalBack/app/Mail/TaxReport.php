<?php

namespace App\Mail;

use App\Services\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaxReport extends Mailable
{
    use Queueable, SerializesModels;

    protected $report;
    protected $startDate;
    protected $endDate;

    /**
     * Create a new message instance.
     *
     * @param string $report
     */
    public function __construct(string $report,$startDate,$endDate)
    {
        $this->report = json_decode("{" . $report . "}");
        $this->startDate = $startDate;
        $this->endDate = $endDate;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@example.com')
            ->view('mail')
            ->with([
                'income' => $this->report->income,
                'tax' => $this->report->tax,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
            ]);
    }
}
