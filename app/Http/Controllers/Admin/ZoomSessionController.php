<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ZoomSession;
use App\Services\ZoomService;
use App\Models\User;
use App\Models\ZoomSessionRecordedLink;
use Validator;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class ZoomSessionController extends Controller
{
    /**
     * Create $status variable.
     *
     * @return void
     */
    public $status;
    protected $zoom;  
   
    /**
     * Constructor
     */
    public function __construct(ZoomService $zoom)
    {
        $this->status = config('constant'); 
        $this->zoom = $zoom;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get all zoom sessions with user first and last name
        //$zoom_sessions = ZoomSession::with('user')->get();

        // Split sessions into "Upcoming" (scheduled now or later) and "Past"
        // (already ended). date/time are stored as strings (e.g. "13-07-2026" and
        // "05:55 PM"), so they can't be compared in SQL — partition in PHP with
        // Carbon, then paginate each list manually to keep the existing UI/links.
        // Past sessions get their own tab so admins can still upload a recording.
        $now = Carbon::now();
        // Sessions that already have a recording uploaded belong in the Recordings
        // tab, so they are excluded from the Past tab.
        $recordedSessionIds = ZoomSessionRecordedLink::pluck('zoom_session_table_id')->all();

        $partitioned = ZoomSession::latest('id')->get()->groupBy(function ($session) use ($now, $recordedSessionIds) {
            $scheduled = $this->parseSessionDateTime($session->date, $session->time);
            // Unparseable dates stay under "upcoming" so they're never silently lost.
            $isPast = $scheduled !== null && $scheduled->lessThan($now);
            if (! $isPast) {
                return 'upcoming';
            }
            // Past + already recorded → shown only under Recordings, not here.
            return in_array($session->id, $recordedSessionIds) ? 'recorded' : 'past';
        });

        $upcoming = ($partitioned->get('upcoming') ?? collect())->values();
        $past     = ($partitioned->get('past') ?? collect())->values();

        $perPage = 10;

        $upcomingPage = LengthAwarePaginator::resolveCurrentPage('page');
        $zoom_sessions = new LengthAwarePaginator(
            $upcoming->forPage($upcomingPage, $perPage)->values(),
            $upcoming->count(),
            $perPage,
            $upcomingPage,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'page']
        );

        $pastPage = LengthAwarePaginator::resolveCurrentPage('past_page');
        $past_sessions = new LengthAwarePaginator(
            $past->forPage($pastPage, $perPage)->values(),
            $past->count(),
            $perPage,
            $pastPage,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'past_page']
        );

        //Recorded sessions with zoom session and user detail
        $recordings = ZoomSessionRecordedLink::with('zoomSession')->paginate(10);

        //Get members and collaborators
        $hosts = User::where('role', 'user')->orWhere('role', 'collaborator')->where('status', 'active')->get();

        return view('admin.zoom_sessions.index', compact('zoom_sessions','past_sessions','hosts', 'recordings'));
    }

    /**
     * Combine a session's stored date + time strings into a Carbon instance.
     *
     * Values are stored as plain strings whose format has varied over time
     * (create form saves "d-m-Y" + "h:i A", the edit form's date input saves
     * "Y-m-d"), so we try each known format and return null when none match
     * rather than guessing.
     */
    private function parseSessionDateTime($date, $time)
    {
        $raw = trim(trim((string) $date) . ' ' . trim((string) $time));
        if ($raw === '') {
            return null;
        }

        $formats = [
            'd-m-Y h:i A', 'd-m-Y H:i',
            'Y-m-d h:i A', 'Y-m-d H:i',
            'd/m/Y h:i A', 'd/m/Y H:i',
        ];

        foreach ($formats as $format) {
            try {
                // Carbon throws (rather than returning false) when the string does
                // not match the format, so try each format and move on if it fails.
                $parsed = Carbon::createFromFormat($format, $raw);
            } catch (\Exception $e) {
                continue;
            }

            // Reject loose matches that parsed with warnings so we don't mis-date.
            $errors = Carbon::getLastErrors();
            if ($parsed !== false && empty($errors['warning_count']) && empty($errors['error_count'])) {
                return $parsed;
            }
        }

        return null;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //echo now()->addHour()->toIso8601String();exit;
        /*$validator = $request->validate([
            'session_title' => 'required|string',
            'description' => 'required|string',
            'host' => 'required|integer',
            'date' => 'required|string',
            //'time' => 'required|time',
            'duration' => 'required',
            'meeting_link' => 'required|string'
        ]);*/

        $validator = Validator::make(
            [
                'session_title'  => $request->session_title,
                'description'  => $request->description,
                'host'  => $request->host,
                'date'  => $request->date,
                'time'  => $request->time,
                'duration'  => $request->duration,
                'meeting_link'  => $request->meeting_link
            ], 
            [
                'session_title' => 'required|string',
                'description' => 'required|string',
                'host' => 'required|integer',
                'date' => 'required|string',
                'time' => 'required|string',
                'duration' => 'required',
                'meeting_link' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /*$this->createMeeting([
            'session_title' => $request->session_title,
            'description' => $request->description,
            'host' => $request->host,
            'date' => $request->date,
            'time' => $request->time,
            'duration' => $request->duration,
            'meeting_link' => $request->meeting_link
        ]);*/

        /*********Create meeting on zoom start**************/
        $startDateTime = Carbon::parse($request->date . ' ' . $request->time, 'Asia/Kolkata');
        $duration = explode(' ', $request->duration);
        $meeting = $this->zoom->createMeeting('me', [
            'topic' => $request->session_title,
            'type' => 2, // Scheduled
            'start_time' => $startDateTime->format('Y-m-d\TH:i:s'),
            'duration' => isset($duration[0]) ? $duration[0] : 30,
            'timezone' => 'Asia/Kolkata',
            'settings' => [
                'host_video' => true,
                'participant_video' => false,
            ]
        ]);
        //return response()->json($meeting);
        /*********Create meeting on zoom end**************/

        //Save in database
        if(!empty($meeting['id'])){
            $zoomSessions = ZoomSession::create([
                'session_title' => $request->session_title,
                'description' => $request->description,
                'host' => $request->host,
                'date' => $request->date,
                'time' => $request->time,
                'duration' => $request->duration,
                'meeting_link' => $request->meeting_link,
                'zoom_id' => $meeting['id'],
                'meeting_response' => json_encode($meeting)
            ]);

            return redirect()->back()->with('success', 'Zoom session has been created successfully.');
        }else{
            return redirect()->back()->withErrors('Unable to create session.Please try again...!!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $zoomSessionDetail = ZoomSession::findOrFail($id);

        //Get members and collaborators
        $hosts = User::where('role', 'user')->orWhere('role', 'collaborator')->where('status', 'active')->get();

        return view('admin.zoom_sessions.show', compact('zoomSessionDetail','hosts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'session_title' => 'required',
            'description' => 'required',
            'host' => 'required',
            'date' => 'required',
            //'time' => 'required',
            'duration' => 'required',
            'meeting_link' => 'required'
        ]);

        $zoomSession = ZoomSession::findOrFail($id);
        
        /*********Update meeting on zoom start**************/
        $startDateTime = Carbon::parse($request->date . ' ' . $request->time, 'Asia/Kolkata');
        $duration = explode(' ', $request->duration);
        $meeting = $this->zoom->updateMeeting($zoomSession->zoom_id, [
            'topic' => $request->session_title,
            'type' => 2, // Scheduled
            'start_time' => $startDateTime->format('Y-m-d\TH:i:s'), //now()->addHour()->toIso8601String(),
            'duration' => isset($duration[0]) ? $duration[0] : 30,
            'timezone' => 'Asia/Kolkata',
            'settings' => [
                'host_video' => true,
                'participant_video' => false,
            ]
        ]);
        //echo '<pre>';print_r($meeting);exit;
        /*********Update meeting on zoom end**************/

        if(empty($meeting['id'])){
            //Update in database
            $zoomSession->update([
                'session_title' => $request->session_title,
                'description' => $request->description,
                'host' => $request->host,
                'date' => $request->date,
                'time' => $request->time,
                'duration' => $request->duration,
                'meeting_link' => $request->meeting_link
            ]);

            return redirect()->back()->with('success', 'Zoom session has been updated successfully.');
        }else{
            return redirect()->back()->with('error','Unable to update session.Please try again...!!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try{
            //Get zoom session detail
            $zoomSession = ZoomSession::findOrFail($id);

            $delete = ZoomSession::deleteZoomSessionByID($id);
            if ($delete) {
                //Delete recorded session
                ZoomSessionRecordedLink::where('zoom_session_table_id', $id)->delete();

                //Delete session from zoom
                $this->zoom->deleteMeeting($zoomSession->zoom_id);
                return redirect()->back()->with('success', 'Session has been deleted successfully!');
            } else {
                return redirect()->back()->withErrors('Unable to delete session.Please try again...!!!');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Unable to delete session because session is associated with other records. Please try again...!!!');
        }
    }

    /**
     * Update the status of a product
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The product ID to update
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $zoom_session = ZoomSession::findOrFail($id);
        if ($zoom_session->status !== 'active') {
            $newStatus = 'active';
        } else {
            $newStatus = 'inactive';
        }
        $zoom_session->update(['status' => $newStatus]);

        return response()->json([
            'status' => $newStatus
        ]);
    }

    public function updateZoomSession(Request $request)
    {
        //Get zoom session detail
        $zoomSession = ZoomSession::findOrFail($request->zoom_session_id);

        $validator = Validator::make(
            [
                'session_title'  => $request->session_title,
                'description'  => $request->description,
                'host'  => $request->host,
                'date'  => $request->date,
                'time'  => $request->time,
                'duration'  => $request->duration,
                'meeting_link'  => $request->meeting_link
            ], 
            [
                'session_title' => 'required|string',
                'description' => 'required|string',
                'host' => 'required|integer',
                'date' => 'required|string',
                'time' => 'required|string',
                'duration' => 'required',
                'meeting_link' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /*********Update meeting on zoom start**************/
        $duration = explode(' ', $request->duration);
        $meeting = $this->zoom->updateMeeting($zoomSession->zoom_id, [
            'topic' => $request->session_title,
            'type' => 2, // Scheduled
            'start_time' => $request->time, //now()->addHour()->toIso8601String(),
            'duration' => isset($duration[0]) ? $duration[0] : 30,
            'timezone' => 'Asia/Kolkata',
            'settings' => [
                'host_video' => true,
                'participant_video' => false,
            ]
        ]);
        /*********Update meeting on zoom end**************/

        if(!empty($meeting['id'])){
            //Update in database
            $zoomSession->update([
                'session_title' => $request->session_title,
                'description' => $request->description,
                'host' => $request->host,
                'date' => $request->date,
                'time' => $request->time,
                'duration' => $request->duration,
                'meeting_link' => $request->meeting_link
            ]);

            return redirect()->back()->with('success', 'Zoom session has been updated successfully.');
        }else{
            return redirect()->back()->withErrors('Unable to update session.Please try again...!!!');
        }
    }

    public function saveRecording(Request $request){
        $zoom_session_table_id = $request->zoom_session_table_id;
        $recorded_link = $request->recorded_link;

        ZoomSessionRecordedLink::create([
            'zoom_session_table_id' => $zoom_session_table_id,
            'recorded_link' => $recorded_link
        ]);
       
        return redirect()->back()->with('success', 'Zoom recording has been saved successfully.');
    }

    public function updateRecording(Request $request){
        $validator = Validator::make($request->all(), [
            'recording_id'  => 'required',
            'recorded_link' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $recording = ZoomSessionRecordedLink::find($request->recording_id);
        if (! $recording) {
            return redirect()->back()->withErrors('Recording not found.');
        }

        $recording->update([
            'recorded_link' => $request->recorded_link,
        ]);

        return redirect()->back()->with('success', 'Zoom recording has been updated successfully.');
    }

    public function deleteRecording(int $id)
    {
        $delete = ZoomSessionRecordedLink::where('id', $id)->delete();
        if ($delete) {
            return redirect()->back()->with('success', 'Recorded Session has been deleted successfully!');
        } else {
            return redirect()->back()->withErrors('Unable to delete recorded session.Please try again...!!!');
        }
    }

}