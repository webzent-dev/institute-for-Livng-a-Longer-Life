<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CollaboratorBankDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_holder_name',
        'bank_name',
        'account_number',
        'routing_number',
        'account_type',
        'swift_code',
        'iban',
        'bank_address',
        'bank_city',
        'bank_state',
        'bank_zip_code',
        'bank_country',
        'beneficiary_address',
        'beneficiary_city',
        'beneficiary_state',
        'beneficiary_zip_code',
        'beneficiary_country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
