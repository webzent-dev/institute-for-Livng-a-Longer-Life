<?php

namespace App\Http\Controllers\Front\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberSignupMail;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Create $status variable.
     *
     * @return void
     */
    public $status;  
   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = config('constant');
        //$this->adminID = !empty(Session::get('adminId'))?Session::get('adminId'):0;
    }

    public function showLoginForm()
    {
        if(Auth::check() && Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }else if(Auth::check() && Auth::user()->role == 'collaborator') {
            return redirect()->route('collaborator.dashboard');
        }else if(Auth::check() && Auth::user()->role == 'user') {
            return redirect()->route('member.dashboard');
        }else{
            return view('front.auth.login');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if user exists and has restricted role
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            if ($user->role === 'admin') {
                return response()->json([
                    'message' => 'Admin can not login from this page. Please use the admin login page.'
                ], 403);
            }
            
            if ($user->role === 'collaborator') {
                return response()->json([
                    'message' => 'Collaborator can not login from this page. Please use the collaborator login page.'
                ], 403);
            }

            if ($user->role === 'user' && $user->status !== 'active') {
                return response()->json([
                    'message' => 'Your account is inactive. Please wait for admin approval.'
                ], 403);
            }   
            
            // Attempt login with user role only
            if (!Auth::attempt(['email' => $request->email,'password' => $request->password,'role' => 'user']))
            {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login successful'
            ]);
        }else{
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $adminLogin = Auth::attempt(array_merge($credentials, [
            'role' => 'admin'
        ]));

        if ($adminLogin) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin! Login successful.');
        }
        return back()->with('error', 'Invalid credentials or enter valid  credentials.')->withInput();
    }


    /*public function collaboratorLogin(Request $request)
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
    }*/

    public function signUp(Request $request)
    {
        $singupData = [
            'first_name' => !empty($request->first_name)?$request->first_name:'',
            'last_name' => !empty($request->last_name)?$request->last_name:'',
            'email' => !empty($request->email)?$request->email:'',
            'password' => bcrypt(\Illuminate\Support\Str::random(32)),
            'confirm_password' => !empty($request->confirm_password)?$request->confirm_password:'',
            'phone' => !empty($request->phone)?$request->phone:'',
            'role' => 'user',
            'status' => 'inactive',
        ];

        $validator = Validator::make(
            [
                'first_name'      =>  $singupData['first_name'],
                'last_name'  =>  $singupData['last_name'],
                'email'   =>  $singupData['email'],
                'password' => $singupData['password'],
                'phone'  =>  $singupData['phone'],
                'role'  =>  $singupData['role'],
            ],
            [
                'first_name'  =>  'required|string',
                'last_name'  =>  'required|string',
                'email'  =>  'required|email',
                'password'  =>  'required|string|min:8|confirmed',
                'phone'  =>  'required',
                'role'  =>  'required',
            ]
        );

        if ($validator->fails()) {
            $result = array(
                'status' => $this->status['error']['status'],
                'errortrue' =>  $this->status['error']['errortrue'],
                'message'=> $validator->errors()
            );
            return response()->json($result);
        }

        $user = User::create($singupData);
        if(!empty($singupData['email'])){
            $resetToken = \Illuminate\Support\Facades\Password::createToken($user);
            $resetUrl = route('password.reset', ['token' => $resetToken, 'email' => $user->email]);
            Mail::to($singupData['email'])->send(
                new MemberSignupMail($user, $resetUrl)
            );
        }

        /*$result = array(
            'status' => $this->status['success']['status'],
            'errortrue' =>  $this->status['success']['errortrue'],
            'message'=> 'User registered successfully'
        );
        return response()->json($result);
        */
        return redirect()->route('auth')->with('success', 'Registration successful. Please wait for admin approval.');
    }

}