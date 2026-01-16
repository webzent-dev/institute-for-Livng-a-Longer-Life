<?php

namespace App\Http\Controllers\Front\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('front.auth.login');
    }

    public function login(Request $request)
    {
    $request->validate([
    'email' => 'required|email',
    'password' => 'required',
]);
    if (!Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,
        'role' => 'user',   // 👈 IMPORTANT
    ])) 
    {
        return response()->json([
            'message' => 'Invalid credentials or admin access not allowed'
        ], 401);
    }


return response()->json([
    'message' => 'Login successful'
]);

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

}
