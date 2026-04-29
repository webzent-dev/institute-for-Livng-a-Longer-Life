<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'iso',
        'nicename',
        'iso3',
        'numcode',
        'phonecode',
    ];
}
