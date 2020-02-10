<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Transaction;
class TransactionQuery
{
    public function showAll($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) {
        $first = $args["first"];
        $page = $args["page"];
        $transactions = Transaction::orderBy("date","DESC")->paginate($first,['*'],'page',$page);
        return [
            "data" => $transactions,
            "page" => [
                "currentPage" => $page,
                "lastPage" => $transactions->lastPage()
            ]
        ];
    }
    public function categoryData($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TODO implement the resolver
        $catID = $args["categoryID"];
        $first = $args["first"];
        $page = $args["page"];
        $transactions = Transaction::where("categoryID",$catID)->orderBy("date","DESC")->paginate($first,['*'],'page',$page);
        return [
            "data" => $transactions,
            "page" => [
                "currentPage" => $page,
                "lastPage" => $transactions->lastPage()
            ]
        ];
    }
}
