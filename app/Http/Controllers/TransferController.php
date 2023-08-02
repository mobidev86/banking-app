<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('money_transfer.index');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'email_id' => 'required|email',
            'transfer_amount' => 'required|numeric|min:0',
        ]);

        $user = User::where('email', '=', $request->email_id)->first();

        

        $user_current_balance = getUserBalance(Auth::user()->id);

        if($user_current_balance < $request->transfer_amount){
            return redirect()->back()->with('alert-danger', 'You can not Transfer more than your balance');
        }

        $data = [
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $user->id,
            'transfer_amount' => $request->transfer_amount
        ];
        
        Transfer::create($data);
        return redirect('/home')->with('alert-success', 'Your Transfer is successfully done');
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');
        // $emails = User::where('email', 'like', '%' . $term . '%')->pluck('email')->toArray();
        $emails = User::where('email', 'like', '%' . $term . '%')
              ->where('email', '!=', Auth::user()->email)
              ->pluck('email')
              ->toArray();
        return response()->json($emails);
    }
}
