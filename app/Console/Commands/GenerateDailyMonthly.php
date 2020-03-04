<?php

namespace App\Console\Commands;

use App\Transaction;
use App\ReportDaily;
use App\ReportMonthly;
use Carbon\Carbon;

use Illuminate\Console\Command;


class GenerateDailyMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate report for monthly and daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $all = Transaction::orderBy("date","asc")->get();
        foreach($all as $transaction) {
            //daily
            if ($transaction->date == null || $transaction->date == "") {
                echo $transaction->date;
                continue;
            }
            $count = ReportDaily::whereDate("date",$transaction->date)->where('type',$transaction->type)->get()->count();
            if($count == 0) {
                //insert it
                $dailyReport = new ReportDaily();
                $dailyReport->date = $transaction->date;
                $dailyReport->amount = $transaction->amount;
                $dailyReport->type = $transaction->type;
                $dailyReport->save();
            }
            else {
                //update it
                $dailyReport = ReportDaily::whereDate("date",$transaction->date)->where('type',$transaction->type)->first();
                $dailyReport->amount = $dailyReport->amount + $transaction->amount;
                $dailyReport->update();
            }

            //monthly
            $month = Carbon::parse($transaction->date)->format('n');
            $year = Carbon::parse($transaction->date)->format('Y');

            $count = ReportMonthly::where("month",$month)->where("year",$year)->where('type',$transaction->type)->get()->count();
            if($count == 0) {
                //insert it
                $reportMonthly = new ReportMonthly();
                $reportMonthly->month = $month;
                $reportMonthly->year = $year;
                $reportMonthly->amount = $transaction->amount;
                $reportMonthly->type = $transaction->type;
                $reportMonthly->save();
            }
            else {
                //update it
                $reportMonthly = ReportMonthly::where("month",$month)->where("year",$year)->where('type',$transaction->type)->first();
                $reportMonthly->amount = $reportMonthly->amount + $transaction->amount;
                $reportMonthly->update();
            }

        }
    }
}
