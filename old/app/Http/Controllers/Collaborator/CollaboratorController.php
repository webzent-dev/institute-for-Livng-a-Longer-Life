<?php

namespace App\Http\Controllers\Collaborator;
use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\CollaboratorLoginMail;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Course;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\UniqueConstraintViolationException;

class CollaboratorController extends Controller
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
            return view('collaborator.index');
        }
    }

    public function collaboratorLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $collaboratorLogin = Auth::attempt(array_merge($credentials, [
            'role' => 'collaborator',
            'status' => 'active', // <-- only active collaborators
        ]));

        if ($collaboratorLogin) {
            $request->session()->regenerate();
            return redirect()->route('collaborator.dashboard')
            ->with('success', 'Welcome Collaborator! Login successful.');
        }

        $user = \App\Models\User::where('email', $request->email)
        ->where('role', 'collaborator')
        ->first();

        if ($user && $user->status !== 'active') {
            return back()->with('error', 'Your account is inactive. Please wait for admin to activate it.')->withInput();
        }

        // If credentials are completely wrong
        return back()->with('error', 'Invalid credentials.')->withInput();
    }

    public function dashboard()
    {
        //Collaborator revenue calculation
        $collaboratorRevenue = Order::whereHas('user', function($query) {
            $query->where('user_id', auth()->id());
            $query->where('role', 'collaborator');
        })->sum('total');

        return view('collaborator.dashboard.index', [
            'totalUsers'      => User::count(),
            'admins'          => User::where('role', 'admin')->count(),
            'collaborators'   => User::where('role', 'collaborator')->count(),
            'customers'       => User::where('role', 'user')->count(),
            'orders'          => Order::where('user_id', auth()->id())->count(),
            'products'        => Product::where('user_id', auth()->id())->count(),
            'courses'         => Course::where('user_id', auth()->id())->count(),
            'collaboratorRevenue' => $collaboratorRevenue,
        ]);
        //return view('collaborator.dashboard.index');
    }

    public function createProfile()
    {
        // Yahan par collaborator ka profile dikhane ka logic likh sakte hain
        return view('collaborator.profile');
    }

    public function profile()
    {
        return view('front.collaborator.profile');
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make(
            [
                'first_name'  => $request->first_name,
                'last_name'  => $request->last_name,
                'phone'  => $request->phone,
                'speciality'  => $request->speciality,
                'professional_credentials'  => $request->professional_credentials,
                'experience'  => $request->experience,
                'organization'  => $request->organization,
                'collaborator_message'  => $request->collaborator_message,
                //'profile_image'  => $request->profile_image,
            ], 
            [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'speciality' => 'required|string|max:255',
                'professional_credentials' => 'required|string|max:255',
                'experience' => 'required|string|max:255',
                'organization' => 'required|string|max:255',
                'collaborator_message' => 'required',
                //'profile_image' => 'file|mimes:jpg,jpeg,png|max:2048',
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $profileImageName = null;
        if ($request->hasFile('profile_image') && !empty($request->profile_image)) {
            $profileImageName = time() . '.' . $request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('user_images'), $profileImageName);
        }

        $collaboratorDetail = User::findOrFail($request->user_id);
        $profile_image = !empty($profileImageName) ? $profileImageName : $collaboratorDetail->profile_image;
        $collaboratorDetail->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone, 
            'profile_image' => !empty($profile_image) ? $profile_image : null,
            'speciality' => $request->speciality,
            'professional_credentials' => $request->professional_credentials,
            'experience' => $request->experience,
            'organization' => $request->organization,
            'website' => $request->website,
            'collaborator_message' => $request->collaborator_message
        ]);

        return redirect()->back()->with('success', 'Profile has been updated successfully.');
    }

    public function becomeCollaborator()
    {
        
        return view('front.collaborator.become-collaborator');
    }
    
    public function store(Request $request)
    {
        /*$request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required',
            'password'   => 'required|min:8|confirmed',
            'specialty'  => 'required',
            'professional_credentials' => 'required',
            'experience' => 'required',
            'organization' => 'required',
            'website'    => 'nullable|url',
            'collaborator_massge' => 'required' 
        ]);*/
        
        try{
            $plainPassword = $request->password;
            if($request->password != $request->password_confirmation){
                return redirect()->route('become.collaborator.store')->with('error', 'Passwords do not match.');
            }else{
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name'  => $request->last_name,
                    'email'      => $request->email,
                    'phone'      => $request->phone,
                    'password'   => Hash::make($request->password),
                    'speciality'  => $request->speciality,
                    'professional_credentials' => $request->professional_credentials,
                    'experience' => $request->experience,
                    'organization' => $request->organization,
                    'website'    => $request->website,
                    'collaborator_message' => $request->collaborator_message,
                    'role'       => 'collaborator',
                    'status'     => 'inactive'
                ]);
                Mail::to($user->email)->send(
                    new CollaboratorLoginMail($user, $plainPassword)
                );
                return redirect()->route('become.collaborator.store')->with('success', 'Collaborator has been created successfully. Please wait for admin approval.');
            }
        } catch (UniqueConstraintViolationException $e) {
            return redirect()->route('become.collaborator.store')->with('error', 'Email already exists. Please use a different email address.');
        } catch (\Exception $e) {
            return redirect()->route('become.collaborator.store')->with('error', 'An error occurred while creating the collaborator. Please try again.');
        }
    }

    public function orders()
    { 
        $orders = Order::with('user')->where('user_id', Auth::id())->get(); 
        return view('collaborator.orders.index', compact('orders'));
    }

    public function orderDetails($id)
    {
        $orderDetail = Order::with('user')->where('id', $id)->first();
        $orderItems = OrderItem::where('order_id', $orderDetail->id)->get();
        return view('collaborator.orders.show', compact('orderDetail', 'orderItems'));
    }

    public function updateOrder(Request $request, string $id)
    {
        $orderDetail = Order::where('id', $id)->first();
        $orderDetail->status = $request->input('status');
        $orderDetail->save();
        return redirect()->back()->with('success', 'Order status has been updated successfully.');
    }

}