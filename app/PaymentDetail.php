<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{

    protected $fillable = [
        'user_id', 'transaction_on', 'transaction_id', 'transaction_request_id', 'amount'
    ];
}
