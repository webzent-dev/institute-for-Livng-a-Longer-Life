<?php

namespace App\Http\Controllers\Collaborator;
use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use Illuminate\Http\Request;
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
        $collaborator_data = Collaborator::all();
       
        return view('front.collaborator.become-collaborator', compact('collaborator_data'));
    }
    
    public function store(Request $request)
            {

                // dd($request->all());
    $validated = $request->validate([
                    'first_name' => 'required|string|max:100',
                    'last_name' => 'required|string|max:100',
                    'email' => 'required|email|unique:users,email',
                    'phone'      => 'required|unique:users,phone',
                    'specialty_area_of_expertise' => 'nullable|string|max:255',
                    'professional_credentials' => 'nullable|string|max:255',
                    'experience' => 'nullable|int',
                    'practice_organization'=> 'nullable|string|max:255',
                    'website_url' => 'nullable|string|max:255',
                    'description' => "nullable|string|max:255",
                
                ]);
                  
                 Collaborator::create($validated); 

                return back()->with('success', 'Application submitted successfully!');
                
            }

    

            }
