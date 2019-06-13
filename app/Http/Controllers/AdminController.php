<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use DB;
class AdminController extends Controller
{
    function index() {
        //distinct year for transaction
        $transactionYears = Transaction::select(DB::raw("Year(date) as year"))->distinct()->get(['year']);
        
        return view('admin.home',compact('transactionYears'));
    }
}
