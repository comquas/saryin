<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Category;
use Carbon\Carbon;
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

    public function expend()
    {
        $results = [];
        $sum = [];
        $color = [];

        $names = Category::where('type', 2)->get()->pluck('name');
        $expendCategoryId = Category::where('type', 2)->get()->pluck('id');

        foreach ($expendCategoryId as $key => $id) {
            $sumOfSingleCategory = Transaction::where('categoryID', $id)
            ->whereMonth('date', now()->month)
            ->sum('amount');
            array_push($sum, $sumOfSingleCategory);                        
        }

        foreach ($names as $key => $name) {
            $hex = $this->strToHex($name);
            $code = substr($hex, 3, 6);
            $colorCode = '#' . $code;

            array_push($color, $colorCode);
        }

        array_push($results, $names, $sum, $color);
        return $results;
    }

    protected function strToHex($string){
    $hex = '';
    for ($i=0; $i<strlen($string); $i++){
        $ord = ord($string[$i]);
        $hexCode = dechex($ord);
        $hex .= substr('0'.$hexCode, -2);
    }
    return strToUpper($hex);
}
}
