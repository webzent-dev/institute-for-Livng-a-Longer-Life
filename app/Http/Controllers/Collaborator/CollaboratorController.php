<?php

namespace App\Http\Controllers\Collaborator;
use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\CollaboratorLoginMail;
use App\Models\User;
class CollaboratorController extends Controller
{
    public function index()
    {
        return view('Collaborator.index');
    }

    public function createProfile()
    {
        // Yahan par collaborator ka profile dikhane ka logic likh sakte hain
        return view('Collaborator.profile');
    }

    public function profile()
    {
        return view('front.collaborator.profile');
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

    public function becomeCollaborator()
    {
        
        return view('front.collaborator.become-collaborator');
    }
    
          public function store(Request $request)
            {
              $request->validate([
                'first_name' => 'required',
                'last_name'  => 'required',
                'email'      => 'required|email|unique:users,email',
                'phone'      => 'required',
                'password'   => 'required|min:8|confirmed',
                'Specialty'  => 'required',
                'professional_credentials' => 'required',
                'experience' => 'required',
                'organization' => 'required',
                'website'    => 'nullable|url',
                'collaborator_massge' => 'required',
                
         ]);

         $plainPassword = $request->password;
          $user = User::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'password'   => Hash::make($request->password),
        'Specialty'  => $request->Specialty,
        'professional_credentials' => $request->professional_credentials,
        'experience' => $request->experience,
        'organization' => $request->organization,
        'website'    => $request->website,
        'collaborator_massge' => $request->collaborator_massge,
        'role'       => 'collaborator',
       ]);
        Mail::to($user->email)->send(
        new CollaboratorLoginMail($user, $plainPassword)
    );
      return redirect()->back()->with('success', 'Collaborator added successfully. Please wait for admin approval.');
     }
}
