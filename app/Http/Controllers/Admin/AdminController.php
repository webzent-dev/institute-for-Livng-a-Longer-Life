<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use App\Mail\CollaboratorActiveMail;


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


        // role update function
        public function update(Request $request)
            {
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'role' => 'required|in:admin,collaborator,user',
                ]);

                $user = User::find($request->user_id);
                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'role' => $request->role,
                ]);

                return redirect()->back()->with('success', 'Role updated successfully!');
            }

            public function CollabStatus($id)
            {
                $collaborator = User::findOrFail($id);

                if ($collaborator->status !== 'active') {
                    $newStatus = 'active';
                } else {
                    $newStatus = 'inactive';
                }

                $collaborator->update([
                    'status' => $newStatus
                ]);

                if ($newStatus === 'active') {
                    Mail::to($collaborator->email)
                        ->send(new CollaboratorActiveMail($collaborator));
                }

                return response()->json([
                    'status' => $newStatus
                ]);
            }


}
