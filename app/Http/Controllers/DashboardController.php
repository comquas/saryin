<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use DB;
class DashboardController extends Controller
{
    public function groupByMonth($year,$type) {
        $transaction = Transaction::select(DB::raw("(SUM(amount)) as count"),DB::raw("(Month(date)) as month"),DB::raw("(Year(date)) as year"));
        
        if($type== "in") {
            $transaction->where("type",1);
        }
        else {
            $transaction->where("type","!=",1);
        }

        $transaction->whereYear("date",$year);

        $result = $transaction->groupBy(DB::raw("Year(date)"),DB::raw("Month(date)"))->get();
        return $result;
    }
}
