<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
   
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'specialty_area_of_expertise',
        'professional_credentials',
        'experience',
        'practice_organization',
        'website_url',
        'description',
    ];

    // Optional: Accessors/Mutators for phone formatting (e.g., normalize to E.164)
    protected $casts = [
        'experience' => 'integer',
    ];
    
}

