<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ZoomSessionRecordedLink;

class ZoomSession extends Model
{
    protected $table = 'zoom_sessions';

    protected $fillable = [
        'session_title',
        'description',
        'host',
        'date',
        'time',
        'duration',
        'meeting_link',
        'zoom_id',
        'meeting_response',
        'status'
    ];

    /**
     * Deletes session by its ID.
     * 
     * @param int $id The user ID to delete.
     * 
     * @return int 1 if the session is deleted successfully, 0 otherwise.
     */
    public static function deleteZoomSessionByID(int $id=0)
    {
        $zoomSessionDetail = ZoomSession::where('id', $id)->delete();
        if ($zoomSessionDetail) {
            ZoomSessionRecordedLink::where('zoom_session_table_id', $id)->delete();
            return 1;
        } else {
            return 0;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zoomSessionRecordedLink()
    {
        return $this->hasMany(ZoomSessionRecordedLink::class);
    }
}
