<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $transactions = Transaction::getData(status: 1);

        $transactionChart = $this->chartData($transactions);

        return view('dashboard', compact('transactionChart'));
    }

    public function chartData($transactions)
    {
        for ($i = 0; $i < 12; $i++) {
            $monthName = verta()->subMonths($i)->format('%B %Y');
            $allMonth[$monthName] = 0;
        }
        foreach ($transactions as $transaction) {
            $monthName = verta($transaction->created_at)->format('%B %Y');
            $amount = $transaction->amount;
            if (!isset($data[$monthName])) {
                $data[$monthName] = 0;
            }
            $data[$monthName] += $amount;
        }

        $finalMonthData = array_merge($allMonth, $data);

        $finalMonthDataToJson = [];

        foreach ($finalMonthData as $key => $value) {
            array_push($finalMonthDataToJson,['month' => $key, 'value' => $value]);
        }

        return $finalMonthDataToJson;
    }
}
