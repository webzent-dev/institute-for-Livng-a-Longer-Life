<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoTestimonial extends Model
{
     protected $fillable = [
        'video_url',
        'thumbnail',
        'quote',
        'name',
        'is_active',
        'sort_order',
    ];
}
