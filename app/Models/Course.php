<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
      protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'description',
    ];
}
