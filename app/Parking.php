<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{

    protected $fillable = [
        'user_id', 
        'name', 
        't_name', 
        'city', 
        'state', 
        'zip_code', 
        'country',
        'lot_type',
        'image',
        //'status',
        'latitude',
        'longitude',
        'address',
        'capacity',
        'description',
        'rate',
        'availability',
        'from_time',
        'to_time'
        //'cancellation_charges'
    ];
}
