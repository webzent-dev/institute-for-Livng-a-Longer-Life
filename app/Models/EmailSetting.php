<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    protected $fillable = [
        'email_type',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    /**
     * Whether a given email type is enabled. Types with no stored row fall back to
     * $default, so existing/unmanaged emails keep sending unless explicitly turned off.
     */
    public static function isEnabled(string $emailType, bool $default = true): bool
    {
        $setting = static::where('email_type', $emailType)->first();

        return $setting ? (bool) $setting->enabled : $default;
    }

    /**
     * Persist the on/off state for an email type (creates the row if needed).
     */
    public static function setEnabled(string $emailType, bool $enabled): void
    {
        static::updateOrCreate(
            ['email_type' => $emailType],
            ['enabled' => $enabled]
        );
    }
}
