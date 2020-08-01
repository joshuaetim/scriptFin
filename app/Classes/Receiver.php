<?php

namespace App\Classes;
use App\User;
use App\Withdraw;
use App\Investment;

class Receiver{

    // public $user = auth()->user();

    public function __construct()
    {
        //
    }

    public function showActivationReceiver($user)
    {
        $investment = Investment::where([
            ['user_id', $user->id],
            ['activation', true],
            ['paid_complete', false]
        ])->get()->first();
        
        $receiver = User::findOrFail($investment->receiver);

        return [$receiver, $investment];
    }

    public function checkPayer($user)
    {
        $withdraws = Withdraw::where([
            ['payer', $user->id],
            ['paid', 0]
        ])->get();

        // $collection = [];

        // foreach ($withdraws as $withdraw) {
        //     $collection[] = [$withdraw, User::findOrFail($withdraw->user_id)];
        // } // loop through all, and store record  as withdraw info, user info

        // $collection = collect($collection); // convert to collection
        
        return ["collection" => $withdraws, "count" => $withdraws->count()];
    }

    public function checkReceiver($user)
    {
        $withdraws = Withdraw::where([
            ['user_id', $user->id],
            ['paid', 0]
        ])->get();
        
        return ["collection" => $withdraws, "count" => $withdraws->count()];
    }


    public function checkIfPayer($user)
    {
        $investment = Investment::where([
            ['user_id', $user->id],
            ['receiver', '!=', 0],
            ['activation', 0],
            ['paid_complete', 0]
        ])->first();

        return $investment;
    }

    public function checkIfReceiver($user)
    {
        $withdrawal = Withdraw::where([
            ['user_id', $user->id]
        ])->first();

        return $withdrawal;
    }

    public function scheduledMatchPayment($user)
    {
        $investment = Investment::where([
            ['user_id', $user->id],
            ['receiver', '=', 0],
            ['activation', 0],
            ['paid_complete', false]
        ])->first();

        return $investment;
    }

}