<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitalBoostSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'email',
        'product_name',
        'plan',
        'quantity',
        'unit_price',
        'membership_percent',
        'subscription_percent',
        'membership_discount',
        'subscription_discount',
        'item_total',
        'status',
        'started_at',
        'next_billing_at',
    ];

    protected $casts = [
        'started_at'      => 'datetime',
        'next_billing_at' => 'datetime',
        'unit_price'      => 'decimal:2',
        'item_total'      => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
