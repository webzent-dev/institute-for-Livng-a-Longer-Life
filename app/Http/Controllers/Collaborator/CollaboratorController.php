<?php

namespace App\Http\Controllers\Collaborator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class CollaboratorController extends Controller
{
    public function index()
    {
        return view('Collaborator.index');
    }

    public function profile()
    {
        // Yahan par collaborator ka profile dikhane ka logic likh sakte hain
        return view('Collaborator.profile');
    }

    public function updateProfile(Request $request)
{
    $user = auth()->user();
    $data = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:20',
    ]);

    // if ($request->filled('password')) {
    //     $data['password'] = bcrypt($request->password);
    // } else {
    //     unset($data['password']);
    // }
    $user->update($data);

    return back()->with('success', 'Profile updated successfully');
}
}
