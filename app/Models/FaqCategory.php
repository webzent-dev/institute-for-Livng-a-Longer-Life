<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faq;

class FaqCategory extends Model
{
     protected $fillable = ['name'];
    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }
}
