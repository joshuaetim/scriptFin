<?php

namespace App\Classes;

use App\Investment;

class InvestmentCheck
{
    public function activeInvestmentCount($user)
    {
        $details = Investment::where([
            ['user_id', $user->id],
            ['activation', 0],
            ['completed', 0],
        ])->get();

        return $details->count();
    }

    public function checkPendingInvestments($user)
    {
        $details = Investment::where([
            ['user_id', $user->id],
            ['activation', 0],
            ['withdraw', 1],
            ['completed', 0]
        ])->get();

        return $details->count();
    }

    public function completeInvestmentCount($user)
    {
        $details = Investment::where([
            ['user_id', $user->id],
            ['activation', 0],
            ['paid_complete', true],
            ['completed', 0]
        ])->get();

        return $details->count();
    }
}