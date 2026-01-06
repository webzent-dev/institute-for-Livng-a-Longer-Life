<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $fillable = [
        'faq_category_id',
        'question',
        'answer',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class);
    }
}
