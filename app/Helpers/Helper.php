<?php

use App\User;
use App\Withdraw;
use Carbon\Carbon;
use App\PaymentLog;

if(!function_exists('getUser')){
    function getUser($id)
    {
        return User::findOrFail($id);
    }
}

if(!function_exists('getCarbonInstance')){
    function getCarbonInstance($date)
    {
        return Carbon::create($date);
    }
}

if(!function_exists('getPaymentDetails')){
    function getPaymentDetails($id)
    {
        return PaymentLog::findOrFail($id);
    }
}

if(!function_exists('activationPayment')){
    function activationPayment($id)
    {
        return PaymentLog::where([
            ['investment', $id]
        ])->get()->first();
    }
}

if(!function_exists('countReferrals')){
    function countReferrals($user)
    {
        return User::where([
            ['referral', $user->userID]
        ])->get()->count();
    }
}

if(!function_exists('getTotalWithdrawAmount')){
    function getTotalWithdrawAmount($investment)
    {
        $withdraws = Withdraw::where([
            ['investment', $investment->id]
        ])->get();

        if(!$withdraws->count())
        {
            return false;
        }
        
        $totalAmount = 0;

        foreach ($withdraws as $withdraw) {
            $totalAmount += $withdraw->amount;
        }

        return $totalAmount;
    }
}