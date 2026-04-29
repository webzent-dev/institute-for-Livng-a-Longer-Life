<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table = 'newsletters';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
    ];
}
