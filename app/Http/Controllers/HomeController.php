<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_balance = getUserBalance(Auth::user()->id);
        return view('home',['current_balance' => $current_balance]);
    }

    public function statement($type = null)
    {
       // Fetch the user
        $user = User::findOrFail(Auth::user()->id);

        // Fetch all transactions for the user (deposits, withdrawals, and transfers) sorted by creation date
        $transactions = $user->deposits->map(function ($deposit) {
            return [
                'created_at' => $deposit->created_at,
                'type' => 'deposit',
                'amount' => $deposit->deposit_amount,
                'details' => 'deposit',
            ];
        });

        $withdrawals = $user->withdraws->map(function ($withdraw) {
            return [
                'created_at' => $withdraw->created_at,
                'type' => 'withdraw',
                'amount' => -$withdraw->withdraw_amount,
                'details' => 'withdraw',
            ];
        });

        $transfers_out = $user->transfersOut ?? collect([]); // Initialize with an empty collection if transfersOut is null
        $transfers_out = $transfers_out->map(function ($transfer) {
            return [
                'created_at' => $transfer->created_at,
                'type' => 'transfer',
                'amount' => -$transfer->transfer_amount,
                'details' => 'transfer to ' . $transfer->toUser->email,
            ];
        });

        $transfers_in = $user->transfersIn ?? collect([]); // Initialize with an empty collection if transfersIn is null
        $transfers_in = $transfers_in->map(function ($transfer) {
            return [
                'created_at' => $transfer->created_at,
                'type' => 'transfer',
                'amount' => $transfer->transfer_amount,
                'details' => 'transfer from ' . $transfer->fromUser->email,
            ];
        });

        // Merge all transactions into one collection and sort them by creation date
        $transactions = collect()
            ->merge($transactions)
            ->merge($withdrawals)
            ->merge($transfers_out)
            ->merge($transfers_in)
            ->sortBy('created_at');

        // Filter transactions by type if specified
        if ($type) {
            $type = Str::lower($type); // Convert type to lowercase to handle case-insensitive comparison
            $transactions = $transactions->filter(function ($transaction) use ($type) {
                return Str::lower($transaction['type']) === $type;
            });
        }
        // Generate the statement page and calculate the balance
        $balance = 0;
        $statement = [];
        foreach ($transactions as $transaction) {
            $balance += $transaction['amount'];
            $transaction['balance'] = $balance;
            $statement[] = $transaction;
        }

        return view('statement', ['user' => $user, 'statement' => $statement]);
    }
    public function logout(){
        return redirect('login')->with(Auth::logout());
    }
}
