<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpCategory extends Model
{
    protected $fillable = [
        'icon','title','slug','description'
    ];
    public function articles()
    {
        return $this->hasMany(HelpArticle::class);
    }
}
