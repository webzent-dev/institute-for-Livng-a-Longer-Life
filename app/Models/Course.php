<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'duration',
        'instructor',
        'category',
        'description',
        'video_file',
        'video_url',
        'thumbnail',
        'featured',
        'published',
        'status',
        'approval_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Only courses whose owner members are still allowed to see.
     *
     * Deactivating a collaborator must take their videos down with them.
     * Institute (admin) courses are unaffected — the rule is about collaborators
     * losing their platform, not about who uploaded the video.
     */
    public function scopeFromActiveOwner($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where(function ($owner) {
                $owner->where('role', '!=', 'collaborator')
                      ->orWhere('status', 'active');
            });
        });
    }

    public function courses()
    {
        return $this->hasMany(Course::class); 
    }

    public function images()
    {
        return $this->hasMany(CourseImage::class);
    }
}