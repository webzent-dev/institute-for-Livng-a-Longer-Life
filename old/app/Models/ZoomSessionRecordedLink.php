<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoomSessionRecordedLink extends Model
{
    protected $table = 'zoom_session_recorded_links';

    protected $fillable = [
        'zoom_session_table_id',
        'recorded_link'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zoomSession()
    {
        return $this->belongsTo(ZoomSession::class, 'zoom_session_table_id');
    }
}
