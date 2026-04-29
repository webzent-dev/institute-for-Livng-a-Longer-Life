<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CollaboratorBusinessDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'business_address',
        'business_city',
        'business_state',
        'business_zip_code',
        'business_country',
        'business_phone',
        'business_email',
        'business_website',
        'business_description',
        'tax_id',
        'ein_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
