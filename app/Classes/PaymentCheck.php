<?php

namespace App\Classes;

use App\PaymentLog;


class PaymentCheck
{
    public function checkPaymentAsPayer($user, $investmentDetails)
    {
        $payment = PaymentLog::where([
            ['user', $user->id],
            ['investment', $investmentDetails->id]
        ])->first();

        return $payment;
    }

    public function checkPaymentAsReceiver($user)
    {
        $payment = PaymentLog::where([
            ['receiver', $user->id]
        ])->first();

        return $payment;
    }
}