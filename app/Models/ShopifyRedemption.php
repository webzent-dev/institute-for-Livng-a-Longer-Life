<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopifyRedemption extends Model
{
    protected $fillable = [
        'user_id',
        'membership_number',
        'discount_code',
        'shopify_order_id',
        'order_amount',
        'currency',
        'redeemed_at',
        'payload',
    ];

    protected $casts = [
        'order_amount' => 'decimal:2',
        'redeemed_at' => 'datetime',
        'payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
