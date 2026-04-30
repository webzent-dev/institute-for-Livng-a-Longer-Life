<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'sku',
        'product_type',        
        'name',
        'slug',
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
        'weight',
        'length',
        'width',
        'height',
        'shipping_template',
        'requires_shipping',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }
}