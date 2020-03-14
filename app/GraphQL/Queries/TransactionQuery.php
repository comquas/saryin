<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Transaction;
use App\ReportMonthly;
use DB;
class TransactionQuery
{
    public function showAll($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        
        $first = $args["first"];
        $page = $args["page"];
        $transactions = Transaction::orderBy("date","DESC");

        $dateRange = "";
        if(array_key_exists("dateRange",$args)) {
            $dateRange = $args["dateRange"];
        }

        return $this->showTransactionPageData($transactions,$dateRange,$first,$page);
    }

    public function dashboardInfo($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $totalIncome = 0;
        $totalExpense = 0;
        $totalAsset = 0;
        $profit = 0;

        $trans = ReportMonthly::select(DB::raw("sum('amount') as amount"),"type")
        ->where("month",DB::raw("Month(Now())"))
        ->where("year",DB::raw("Year(Now())"))
        ->groupBy("type")->get();

        
        foreach($trans as $transaction) {
            
            if($transaction->type == 1) {
                $totalIncome = $transaction->amount;
            }
            else if($transaction->type == 2) {
                $totalExpense = $transaction->amount;
            }
            else if($transaction->type == 3) {
                $totalAsset = $transaction->amount;
            }
        }
        $profit = $totalIncome - ($totalExpense + $totalAsset);

        
        return [
            "totalIncome" => $totalIncome,
            "totalExpense" => $totalExpense,
            "totalAsset" => $totalAsset,
            "profit" => $profit
        ];
    }
    public function searchTransaction($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        
        $query= $args["q"];
        $dateRange = "";
        $first = $args["first"];
        $page = $args["page"];
        if(array_key_exists("dateRange",$args)) {
            $dateRange = $args["dateRange"];
        }
        $transactions = Transaction::where("name","like","%{$query}%")->orderBy("date","DESC");
        return $this->showTransactionPageData($transactions,$dateRange,$first,$page);
    }
    public function categoryData($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver
        $catID = $args["categoryID"];
        $first = $args["first"];
        $page = $args["page"];

        $dateRange = "";
        if(array_key_exists("dateRange",$args)) {
            $dateRange = $args["dateRange"];
        }
        
        
        
        $transactions = Transaction::where("categoryID",$catID)->orderBy("date","DESC");
        return $this->showTransactionPageData($transactions,$dateRange,$first,$page);
    }

    private function fromToTransaction($dateRange,$transactions) {
        $from = "";
        $to = "";

        if($dateRange != "") {
            $fromTo = explode(":",$dateRange);
            
            if(count($fromTo) != 2) {
                abort(400);
            }
            $from = $fromTo[0];
            $to = $fromTo[1];
        }

        if($from != "" && $to != "") {
            $transactions = $transactions->where("date",">=",$from)->where("date","<=",$to);
        }
        return $transactions;
    }

    private function showTransactionPageData($transactions,$dateRange,$first,$page) {
        $transactions = $this->fromToTransaction($dateRange,$transactions);
        $transactions = $transactions->paginate($first,['*'],'page',$page);
        return [
            "data" => $transactions,
            "page" => [
                "currentPage" => $page,
                "lastPage" => $transactions->lastPage()
            ]
        ];
    }
}
