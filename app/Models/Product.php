<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   public function collabrator()
   {
        return $this->belongsTo(User::class, 'user_id', 'id')->where('role', 'collabrator');
   }
}
