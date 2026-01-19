<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    protected $fillable = [
        'logo',
        'phone',
        'email',
        'address',
        'footer_content',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'logo_content'
    ];
}
