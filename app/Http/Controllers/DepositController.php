<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index(){
        return view('deposit.add_deposit');
    }
    public function add(Request $request){
        $validated = $request->validate([
            'deposit_amount' => 'required',
        ]);
        $data = [
            'user_id' => Auth::user()->id,
            'deposit_amount' => $request->deposit_amount
        ];
        Deposit::create($data);
        return redirect('/home')->with('alert-success', 'Your money has been deposited successfully');
    }
}
