<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'actor_id',
        'action',
        'resource_type',
        'resource_id',
        'description',
    ];

    /**
     * The member the action was performed on.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Who performed it. Null when the subject acted on their own account.
     */
    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /**
     * Record an action taken against a member.
     *
     * Auditing must never be the reason an operation fails: the action the admin
     * asked for has already happened by the time this is called, so a logging
     * failure is logged and swallowed rather than thrown.
     */
    public static function record(
        int $userId,
        string $action,
        ?string $description = null,
        ?string $resourceType = null,
        ?int $resourceId = null,
        ?int $actorId = null
    ): ?self {
        try {
            return self::create([
                'user_id'       => $userId,
                'actor_id'      => $actorId ?? Auth::id(),
                'action'        => $action,
                'resource_type' => $resourceType,
                'resource_id'   => $resourceId,
                'description'   => $description,
            ]);
        } catch (\Exception $e) {
            Log::error('Could not write audit log: ' . $e->getMessage(), [
                'user_id' => $userId,
                'action'  => $action,
            ]);

            return null;
        }
    }

    /**
     * Human-readable version of the stored action key.
     */
    public function getActionLabelAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->action));
    }
}
