<?php

namespace App\Classes;

use App\Investment;

class Activation
{
    public function createActivationInvestment($id, $receiver)
    {
        $investment = new Investment;

        $investment->user_id = $id;
        $investment->amount_offered = 1000;
        $investment->receiver = $receiver;
        $investment->mature_date = now()->addHours(24);
        $investment->activation = true;

        $investment->save();
        
        return $investment;
    }
}