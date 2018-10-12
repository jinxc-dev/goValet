<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    protected $fillable = [
        'model', 'brand', 'plate_number', 'expire_date', 'photo'
    ];
}
