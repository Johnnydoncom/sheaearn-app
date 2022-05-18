<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class UserTransactionChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $transactions = auth()->user()->transactions()->latest()->limit(30)->get();
        $transactions = collect($transactions)->sortBy([['id',  'asc']])->all();

        $depositTransactions = collect($transactions)->where('type','deposit')->all();
        $withdrawTransactions = collect($transactions)->where('type', 'withdraw')->all();


        $labels = collect($transactions)->map(function($tx) {
            return $tx->created_at->format('Y-m-d h:i');
        });

        $exp = [];
        $inc = [];
        foreach ($transactions as $key => $tx) {
            if($tx->type == 'deposit'){
                $inc[$key] = $tx->amount;
                $exp[$key] = 0;
            }else{
                $exp[$key] = $tx->amount;
                $inc[$key] = 0;
            }
        }



        return Chartisan::build()
            ->labels($labels->toArray())
            ->dataset('Earning', $inc)
            ->dataset('Withdraw',  $exp);
    }
}
