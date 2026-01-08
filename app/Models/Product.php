<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = [
        'user_id',        
        'name',
        'description',
        'price',
        'discount',
        'originalPrice',
        'category',
        'rating',
        'reviews',
        'stock_quantity',
        'image',
        'status',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}
