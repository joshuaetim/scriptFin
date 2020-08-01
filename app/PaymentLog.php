<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PaymentLog extends Model
{
    use Notifiable;

    protected $fillable = [
        'method', 'proof', 'bank', 'account_number', 'account_name', 'depositor_name', 'payment_location'
    ];

    
}
