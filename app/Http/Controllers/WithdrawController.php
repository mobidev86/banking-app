<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WithdrawController extends Controller
{
    public function index(){
        return view('withdraw.add_withdraw');
    }
    
    public function add(Request $request){
        $validated = $request->validate([
            'withdraw_amount' => 'required',
        ]);

        $user_current_balance = getUserBalance(Auth::user()->id);
        
        if($user_current_balance < $request->withdraw_amount){
            return redirect()->back()->with('alert-danger', 'You can not withdraw more than your balance');
        }

        $data = [
            'user_id' => Auth::user()->id,
            'withdraw_amount' => $request->withdraw_amount
        ];

        Withdraw::create($data);
        return redirect('/home')->with('alert-success', 'Your withdraw is successfully done');
    }
}
