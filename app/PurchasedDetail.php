<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasedDetail extends Model
{

    protected $fillable = [
        'user_id', 'vehicle_id', 'parking_id', 'parking_date', 'transaction_id', 'amount'
    ];
}
