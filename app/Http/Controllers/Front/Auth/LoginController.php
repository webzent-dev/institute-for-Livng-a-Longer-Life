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

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }

    return response()->json([
        'message' => 'Login successful'
    ]);
   }


   public function logout(Request $request)
		{
		    Auth::logout();
		    $request->session()->invalidate();
		    $request->session()->regenerateToken();

		    return redirect('/');
		}

}
