<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\CollaboratorActiveMail;
use App\Models\Order;


class AdminController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }else if(Auth::check() && Auth::user()->role == 'collaborator') {
            return redirect()->route('collaborator.dashboard');
        }else if(Auth::check() && Auth::user()->role == 'user') {
            return redirect()->route('member.dashboard');
        }else{
            return view('admin.index');
        }
    }
    public function auditLogs()
    {
        return view('admin.audit_logs.audit-logs');
    }
    public function auditLogsDetails()
    {
        return view('admin.audit_logs.audit-logs-detail');
    }
    /*public function content_management()
    {
        
        return view('admin.content_management.content_management');
    }*/

    /*public function Approved()
    {
        // Logic to get approved products can be added here
        $products = Product::get();
        return view('admin.approved_products', compact('products'));
    }*/

    /*public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $product = Product::findOrFail($id);
        $product->status = $request->status;
        $product->save();

        return response()->json(['success' => true]);
    }*/

    /*public function collaborators()
    {
        $collaborators = User::where('role', 'collaborator')->get();
        return view('admin.collaborators', compact('collaborators'));
    }*/

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /*public function courses()
    {
        // Logic to get courses can be added here
        $courses = Course::all();
        return view('admin.courses', compact('courses'));
    }*/

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

    /*public function CollabStatus($id)
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
    */

    /*public function orders()
    {
        //$orders = Order::all();

        //Getr orders with uer and product details
        $orders = Order::with('user', 'product')->get();

        //Count orders
        $orderCount = $orders->count();

        //active collaborators count
        $activeCollaboratorsCount = User::where('role', 'collaborator')->where('status', 'active')->count();

        //Collaborator revenue calculation
        $collaboratorRevenue = Order::whereHas('product', function($query) {
            $query->where('user_id', Auth::id());
        })->sum('total');

        return view('admin.orders.index', compact('orders','orderCount','activeCollaboratorsCount'));
    }*/

}
