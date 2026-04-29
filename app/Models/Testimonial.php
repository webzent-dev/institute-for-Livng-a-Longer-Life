<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'age',
        'location',
        'rating',
        'quote',
        'result',
        'is_active',
        'sort_order',
    ];
}
