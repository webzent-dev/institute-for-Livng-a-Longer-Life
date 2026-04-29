<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'order_number',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip_code',
        'country',
        'payment_method',
        'subtotal',
        'shipping_method',
        'shipping_cost',
        'tax',
        'discount',
        'total',
        'status',
        'payment_status',
        'billing_address',
        'shipping_address',
        'notes',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
