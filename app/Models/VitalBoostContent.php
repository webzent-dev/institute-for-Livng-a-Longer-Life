<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitalBoostContent extends Model
{
    protected $table = 'vital_boost_contents';

    protected $fillable = [
        'section_key',
        'heading',
        'subheading',
        'body',
        'items',
        'meta',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'items' => 'array',
        'meta'  => 'array',
    ];

    /**
     * All active sections keyed by section_key, so views can pull one by name.
     */
    public static function sections()
    {
        return static::where('status', 'active')
            ->orderBy('sort_order')
            ->get()
            ->keyBy('section_key');
    }
}
