<?php
use App\Models\Withdraw;
use App\Models\Deposit;
use App\Models\Transfer;
use App\Models\User;

if (! function_exists('getUserBalance')) {
    function getUserBalance($user_id) {
        
        $deposit_sum = $withdraw_sum = $transfer_sum = 0;
        $deposit_sum = Deposit::where('user_id', $user_id)->sum('deposit_amount');
        $withdraw_sum = Withdraw::where('user_id', $user_id)->sum('withdraw_amount');
        $transfer_sum = Transfer::where('from_user_id', $user_id)->sum('transfer_amount');

        return ($deposit_sum - $withdraw_sum - $transfer_sum);
    }
    
}

?>