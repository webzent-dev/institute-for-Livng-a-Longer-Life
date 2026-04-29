<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_id',
        'description',
        'payment_method',
        'amount',
        'card_details',
        'invoice_detail',
        'receipt_detail',
        'payment_for',
        'status',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
