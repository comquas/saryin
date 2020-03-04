<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use DB;
use App\ReportMonthly;
class AdminController extends Controller
{
    function index() {
        //distinct year for transaction
        //$transactionYears = Transaction::select(DB::raw("Year(date) as year"))->distinct()->orderBy('year', 'DESC')->get(['year']);
        $transactionYears = ReportMonthly::select("year")->distinct()->orderBy('year', 'DESC')->get(['year']);
        return view('admin.home',compact('transactionYears'));
    }
}
