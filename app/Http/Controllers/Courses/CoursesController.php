<?php

namespace App\Http\Controllers\Courses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CoursesController extends Controller
{
    public function index()
    {
         $courses = Course::with('user')->where('user_id', Auth::id())->latest()->get();
        return view('collaborator.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('collaborator.courses.create');
    }
    public function store(Request $request)
  {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'duration' => 'nullable|string|max:50',
        'instructor' => 'nullable|string|max:255',
        'category' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'video_file' => 'nullable|mimes:mp4,webm|max:51200',
        'video_url'  => 'nullable|url',
        'featured' => 'nullable|boolean',
        'published' => 'required|boolean',
        'status' => 'required|in:draft,published,archived',
        'approval_status' => 'required|in:pending,approved,rejected',
    ]);

    // Only one video allowed
    if ($request->video_file && $request->video_url) {
        return back()->withErrors([
            'video_file' => 'Upload video OR provide URL, not both'
        ]);
    }

    // Upload video
    if ($request->hasFile('video_file')) {
        $validated['video_file'] =
            $request->file('video_file')->store('courses/videos', 'public');
    }

    $validated['user_id'] = Auth::id();
    $validated['featured'] = $request->has('featured');

    Course::create($validated);

    return redirect()
        ->route('courses.index')
        ->with('success', 'Course created successfully');
}


    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('collaborator.courses.create', compact('course'));
    }

   public function update(Request $request, Course $course)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'duration' => 'nullable|string|max:50',
        'instructor' => 'nullable|string|max:255',
        'category' => 'nullable|string|max:255',
        'description' => 'nullable|string', 
        'video_file' => 'nullable|mimes:mp4,webm|max:51200',
        'video_url'  => 'nullable|url',
        'featured' => 'nullable|boolean',
        'published' => 'required|boolean',
        'status' => 'required|in:draft,published,archived',
        'approval_status' => 'required|in:pending,approved,rejected',
    ]);
    $course->user_id = auth()->id();
    $course->title = $request->title;
    $course->duration = $request->duration;
    $course->instructor = $request->instructor;
    $course->category = $request->category;
    $course->description = $request->description;
    $course->status = $request->status ?? 'draft';
    $course->approval_status = $request->approval_status ?? 'pending';
    $course->featured = $request->has('featured');
    $course->published = $request->has('published');

    if ($request->hasFile('video_file')) {
        if ($course->video_file) {
            Storage::disk('public')->delete($course->video_file);
        }

        $course->video_file = $request->file('video_file')
            ->store('courses/videos', 'public');

        $course->video_url = null;
    }

    if ($request->filled('video_url')) {
        $course->video_url = $request->video_url;
        $course->video_file = null;
    }

    $course->save(); // UPDATE

    return redirect()
        ->route('courses.index')
        ->with('success', 'Course updated successfully');
}

    public function destroy(Course $course)
    {
        if ($course->video_file) {
            Storage::disk('public')->delete($course->video_file);
        }

        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course deleted successfully');
    }




    
}