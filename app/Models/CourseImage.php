<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseImage extends Model
{
    protected $table = 'course_images';

    protected $fillable = [
        'course_id',
        'image'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
