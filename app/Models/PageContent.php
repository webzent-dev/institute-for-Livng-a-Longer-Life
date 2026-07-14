<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $table = 'page_contents';

    protected $fillable = [
        'page_key',
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
     * Active sections of one page keyed by section_key, so views can pull one by name.
     */
    public static function sections(string $pageKey)
    {
        return static::where('page_key', $pageKey)
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get()
            ->keyBy('section_key');
    }
}
