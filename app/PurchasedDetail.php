<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasedDetail extends Model
{

    protected $fillable = [
        'user_id', 'vehicle_id', 'parking_id', 'parking_date', 'transaction_id', 'amount'
    ];

    public function vehicle() {
        return $this->belongsTo('App\Vehicle', 'vehicle_id');
    }

    public function parking() {
        return $this->belongsTo('App\Parking', 'parking_id');

    }

    public function payment() {
        return $this->belongsTo('App\PaymentDetail', 'transaction_id', 'transaction_id');
    }
}
