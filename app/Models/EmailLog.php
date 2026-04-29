<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_email',
        'recipient_type',
        'recipient_id',
        'subject',
        'message',
        'email_type',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    /**
     * Get the recipient user if applicable
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Get the recipient collaborator if applicable
     */
    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class, 'recipient_id');
    }

    /**
     * Scope to get emails by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get emails by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('email_type', $type);
    }

    /**
     * Scope to get emails sent within a date range
     */
    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('sent_at', [$startDate, $endDate]);
    }

    /**
     * Scope to search by recipient email
     */
    public function scopeSearchEmail($query, $email)
    {
        return $query->where('recipient_email', 'like', "%{$email}%");
    }

    /**
     * Get status badge HTML
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'sent' => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Sent</span>',
            'failed' => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Failed</span>',
            'pending' => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Pending</span>',
        ];

        return $badges[$this->status] ?? '<span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Unknown</span>';
    }

    /**
     * Get email type label
     */
    public function getEmailTypeLabelAttribute()
    {
        $labels = [
            'collaborator_active' => 'Collaborator Active',
            'collaborator_login' => 'Collaborator Login',
            'member_signup' => 'Member Signup',
            'order_confirmation' => 'Order Confirmation',
            'custom' => 'Custom Email',
        ];

        return $labels[$this->email_type] ?? 'Unknown';
    }
}
