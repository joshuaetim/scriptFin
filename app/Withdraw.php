<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{

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

    public function pendingPayment($user)
    {
        $withdraws = Withdraw::where([
            ['user_id', $user->id],
            ['submitted_payment', 1]
        ])->get();
        
        return ["collection" => $withdraws, "count" => $withdraws->count()];
    }

    public function totalPaid()
    {
        $withdraws = Withdraw::where([
            ['paid', 1]
        ])->get();
        
        $totalPaid = 0;

        foreach($withdraws as $withdraw)
        {
            $totalPaid += $withdraw->amount;
        }

        return $totalPaid;
    }

    public function getMergedWithdraws()
    {
        $withdraws = Withdraw::where([
            ['complete_matched', 1]
        ])->get();

        return $withdraws;
    }

    public function getUnmatchedWithdraws()
    {
        $withdraws = Withdraw::where([
            ['complete_matched', 0]
        ])->get();

        return $withdraws;
    }
}
