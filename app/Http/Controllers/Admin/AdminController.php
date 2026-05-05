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
use App\Models\AdminBusinessDetails;
use Illuminate\Support\Facades\Validator;


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

    /**
     * Show admin business details page
     */
    public function businessDetails()
    {
        $businessDetails = AdminBusinessDetails::where('user_id', Auth::id())->first();
        return view('admin.business-details', compact('businessDetails'));
    }

    /**
     * Store admin business details
     */
    public function storeBusinessDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'business_address' => 'required|string|max:500',
            'business_city' => 'required|string|max:255',
            'business_state' => 'required|string|max:255',
            'business_zip_code' => 'required|string|max:20',
            'business_country' => 'required|string|max:255',
            'business_phone' => 'required|string|max:20',
            'business_email' => 'required|email|max:255',
            'business_website' => 'nullable|url|max:255',
            'business_description' => 'nullable|string|max:1000',
            'tax_id' => 'nullable|string|max:50',
            'ein_number' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        AdminBusinessDetails::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'business_name' => $request->business_name,
                'business_type' => $request->business_type,
                'business_address' => $request->business_address,
                'business_city' => $request->business_city,
                'business_state' => $request->business_state,
                'business_zip_code' => $request->business_zip_code,
                'business_country' => $request->business_country,
                'business_phone' => $request->business_phone,
                'business_email' => $request->business_email,
                'business_website' => $request->business_website,
                'business_description' => $request->business_description,
                'tax_id' => $request->tax_id,
                'ein_number' => $request->ein_number,
            ]
        );

        return redirect()->back()->with('success', 'Business details have been saved successfully.');
    }

}
