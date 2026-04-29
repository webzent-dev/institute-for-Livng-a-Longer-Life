<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\User;
use App\Models\CourseImage;
use Illuminate\Support\Str;

class CollaboratorCourseController extends Controller
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
        /*$validated = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'nullable|string|max:50',
            'instructor' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'video_file' => 'nullable|mimes:mp4,webm|max:51200',
            'video_url'  => 'nullable|url',
            //'featured' => 'nullable|boolean',
            //'published' => 'required|boolean',
            'status' => 'required|in:draft,published,archived',
            //'approval_status' => 'required|in:pending,approved,rejected',
        ]);*/

        /*$validator = Validator::make(
            [
                'user_id'  => $request->user_id,
                'category'  => $request->category,
                'title'  => $request->title,
                'description'  => $request->description,
                'duration'  => $request->duration,
                'video_url'  => $request->video_url
            ], 
            [
                'user_id' => 'required',
                'product_type' => 'required',
                'title' => 'required|string',
                'description' => 'required|string',
                'duration' => 'required|numeric',
                'video_url' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator)->withInput();
        }*/

        /*
        // Only one video allowed
        if ($request->video_file && $request->video_url) {
            return back()->withErrors([
                'video_file' => 'Upload video OR provide URL, not both'
            ]);
        }

        // Upload video
        if ($request->hasFile('video_file')) {
            $validated['video_file'] = $request->file('video_file')->store('courses/videos', 'public');
        }

        $validated['user_id'] = Auth::id();
        if($request->status == 1){
            $validated['status'] = 'published';
        }else{
            $validated['status'] = 'draft';
        }
        //$validated['featured'] = $request->has('featured');

        Course::create($validated);*/

        $course = Course::create([
            'user_id' => Auth::id(),
            'category'  => $request->category,
            'title'  => $request->title,
            'description'  => $request->description,
            'duration'  => $request->duration,
            'video_url'  => $request->video_url,
            'status' => 'published'
        ]);

        // Check if images exist
        if ($request->hasFile('course_images')) {
            $i = 1;
            foreach ($request->file('course_images') as $image) {
                // Generate unique filename
                $imageName = time().'_'.Str::random(10).'.'.$image->getClientOriginalExtension();

                // Store image
                $image->move(public_path('course_images'), $imageName);

                // Save image in DB
                CourseImage::create([
                    'course_id' => $course->id,
                    'image' => $imageName,
                ]);

                if ($i == 1) {
                    $course->thumbnail = $imageName;
                    $course->save();
                }

                $i++;
            }
        }

        return redirect()->route('collaborator.courses')->with('success', 'Course has been added successfully.');
    }

    public function edit($id)
    {
        $courseDetail = Course::findOrFail($id);

        //Course images
        $courseImages = CourseImage::where('course_id', $id)->get();

        //Get members and collaborators
        $instructors = User::where('role', 'user')->orWhere('role', 'collaborator')->where('status', 'active')->get();

        //Course categories
        $courseCategories = [
            'health_wellness' => 'Health & Wellness',
            'nutrition' => 'Nutrition',
            'biohacking' => 'Biohacking',
            'mental_health' => 'Mental Health',
            'fitness' => 'Fitness',
            'longevity_science' => 'Longevity Science',
            'supplements' => 'Supplements',
            'lifestyle' => 'Lifestyle'
        ];

        return view('collaborator.courses.show', compact('courseDetail', 'courseImages', 'instructors', 'courseCategories'));
    }

    public function show($id)
    {
        $courseDetail = Course::findOrFail($id);

        //Course images
        $courseImages = CourseImage::where('course_id', $id)->get();

        //Get members and collaborators
        $instructors = User::where('role', 'user')->orWhere('role', 'collaborator')->where('status', 'active')->get();

        //Course categories
        $courseCategories = [
            'health_wellness' => 'Health & Wellness',
            'nutrition' => 'Nutrition',
            'biohacking' => 'Biohacking',
            'mental_health' => 'Mental Health',
            'fitness' => 'Fitness',
            'longevity_science' => 'Longevity Science',
            'supplements' => 'Supplements',
            'lifestyle' => 'Lifestyle'
        ];

        return view('collaborator.courses.show', compact('courseDetail', 'courseImages', 'instructors', 'courseCategories'));
    }

    public function update(Request $request, int $id)
    {
        $course = Course::findOrFail($id);

        /*$validated = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'nullable|string|max:50',
            'instructor' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'video_file' => 'nullable|mimes:mp4,webm|max:51200',
            'video_url'  => 'nullable|url',
            //'featured' => 'nullable|boolean',
            //'published' => 'required|boolean',
            'status' => 'required|in:draft,published,archived',
            //'approval_status' => 'required|in:pending,approved,rejected',
        ]);

        if($request->status == 1){
            $status = 'published';
        }else{
            $status = 'draft';
        }
        //$course->approval_status = $request->approval_status ?? 'pending';
        //$course->featured = $request->has('featured');
        //$course->published = $request->has('published');

        if ($request->hasFile('video_file')) {
            if ($course->video_file) {
                Storage::disk('public')->delete($course->video_file);
            }
            $course->video_file = $request->file('video_file')->store('courses/videos', 'public');
            $course->video_url = null;
        }

        if ($request->filled('video_url')) {
            $course->video_url = $request->video_url;
            $course->video_file = null;
        }
        $course->update([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'duration' => $request->duration,
            'instructor' => $request->instructor,
            'category' => $request->category,
            'description' => $request->description,
            'status' => $status,
            'video_file' => $course->video_file,
            'video_url' => $course->video_url,
            //'approval_status' => $request->approval_status ?? 'pending',
            //'featured' => $request->has('featured'),
            //'published' => $request->has('published'),
        ]);*/

        /*$validator = Validator::make(
            [
                'user_id'  => $request->user_id,
                'category'  => $request->category,
                'title'  => $request->title,
                'description'  => $request->description,
                'duration'  => $request->duration,
                'video_url'  => $request->video_url
            ], 
            [
                'user_id' => 'required',
                'product_type' => 'required',
                'title' => 'required|string',
                'description' => 'required|string',
                'duration' => 'required|numeric',
                'video_url' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator)->withInput();
        }*/

        $course->update([
            'user_id' => Auth::id(),
            'category' => $request->category,
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'video_url' => $request->video_url
        ]);

        // Check if images exist
        if ($request->hasFile('course_images')) {
            $i = 1;
            foreach ($request->file('course_images') as $image) {
                // Generate unique filename
                $imageName = time().'_'.Str::random(10).'.'.$image->getClientOriginalExtension();

                // Store image
                //$image->storeAs('public/product_images', $imageName);
                $image->move(public_path('course_images'), $imageName);

                // Save image in DB
                CourseImage::create([
                    'course_id' => $course->id,
                    'image' => $imageName,
                ]);

                if ($i == 1) {
                    $course->thumbnail = $imageName;
                    $course->save();
                }

                $i++;
            }
        }

        return redirect()->route('collaborator.courses')->with('success', 'Course has been updated successfully');
    }

    public function destroy(int $id=0)
    {
        $course = Course::findOrFail($id);
        //Delete image from course_images folder
        if ($course->image && file_exists(public_path('course_images/'.$course->image))) {
            unlink(public_path('course_images/'.$course->image));
        }

        $course->delete();
        return redirect()->route('collaborator.courses')->with('success', 'Course has been deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->status = $request->status;
        $course->save();
        return response()->json(['success' => true]);
    }

    public function removeImage(Request $request)
    {
        $image = CourseImage::findOrFail($request->image_id);
        if ($image->image && file_exists(public_path('course_images/'.$image->image))) {
            unlink(public_path('course_images/'.$image->image));
        }
        $delete = $image->delete();
        if($delete){
            return response()->json(['status' => true, 'message' => 'Image has been deleted successfully.']);
        }else{
            return response()->json(['status' => false, 'message' => 'Unable to remove image.Something went wrong.']);
        }
        
    }

}
