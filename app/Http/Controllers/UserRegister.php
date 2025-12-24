<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRegister extends Controller
{
     public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'phone'      => 'required|unique:users,phone',
        'password'   => 'required|min:9|confirmed',
    ]);

    User::create([
        'first_name' => $validated['first_name'],
        'last_name'  => $validated['last_name'],
        'email'      => $validated['email'],
        'phone'      => $validated['phone'],
        'password'   => Hash::make($validated['password']),
    ]);

    return response()->json([
        'message' => 'Registration successful!'
    ]);
}
}
