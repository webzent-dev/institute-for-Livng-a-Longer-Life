<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactOption extends Model
{
    protected $fillable = [
        'type','icon','title','description','contact','note'
    ];
}
