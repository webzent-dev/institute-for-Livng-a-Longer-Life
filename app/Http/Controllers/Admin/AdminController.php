<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Course;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function Approved()
    {
        // Logic to get approved products can be added here
       $products = Product::get();
        return view('admin.approved_products', compact('products'));
    }

     public function updateStatus(Request $request, $id)
    {
            $request->validate([
                'status' => 'required|in:active,inactive'
            ]);

            $product = Product::findOrFail($id);
            $product->status = $request->status;
            $product->save();

            return response()->json(['success' => true]);
    }

    public function collaborators()
    {
            $collaborators = User::where('role', 'collaborator')->get();
            return view('admin.collaborators', compact('collaborators'));
    }

    public function users()
    {
           $users = User::all();
            return view('admin.users', compact('users'));
    }

    public function courses()
    {
            // Logic to get courses can be added here
            $courses = Course::all();
            return view('admin.courses', compact('courses'));
    }
    

    
}   
