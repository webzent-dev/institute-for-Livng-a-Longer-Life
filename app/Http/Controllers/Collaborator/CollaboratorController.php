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
      public function become_collaborator()
        {
            return view('front.collaborator.become-collaborator');
        }
    public function store(Request $request)
            {
                $request->validate(
                    [
                        'first_name' => 'required|string|max:255',
                        'last_name'  => 'required|string|max:255',

                        'email' => 'required|email|unique:become_collaborators,email',

                        'phone' => [
                                    'required',
                                    'string',
                                    'max:20',
                                    'unique:become_collaborators,phone',

                                    // valid phone characters & length
                                    'regex:/^\+?[0-9\s\-\(\)]{10,20}$/',

                                    // reject only full repeated digits
                                    'not_regex:/^(\+?)(\d)\2{9}$/',
                                ],

                        'specialty_area_of_expertise' => 'required|string',
                        'professional_credentials'   => 'required|string|max:255',
                        'experience'                 => 'required|integer|min:0',
                        'practice_organization'      => 'required|string|max:255',
                        'website_url'                => 'nullable|url|max:255',
                        'description'                => 'required|string|max:2000',
                    ],
                    [
                        // First name
                        'first_name.required' => 'First name is required.',
                        'first_name.string'   => 'First name must be a valid text.',
                        'first_name.max'      => 'First name cannot exceed 255 characters.',

                        // Last name
                        'last_name.required' => 'Last name is required.',
                        'last_name.string'   => 'Last name must be a valid text.',
                        'last_name.max'      => 'Last name cannot exceed 255 characters.',

                        // Email
                        'email.required' => 'Email address is required.',
                        'email.email'    => 'Please enter a valid email address.',
                        'email.unique'   => 'This email is already registered.',

                        // Phone
                        'phone.required'    => 'Phone number is required.',
                        'phone.string'      => 'Phone number must be a valid string.',
                        'phone.max'         => 'Phone number cannot exceed 20 characters.',
                        'phone.unique'      => 'This phone number is already registered.',
                        'phone.regex'       => 'Please enter a valid phone number.',
                        'phone.not_regex'   => 'Phone number cannot contain repeated or sequential digits.',

                        // Specialty
                        'specialty_area_of_expertise.required' => 'Please select your area of expertise.',

                        // Credentials
                        'professional_credentials.required' => 'Professional credentials are required.',
                        'professional_credentials.max'      => 'Professional credentials are too long.',

                        // Experience
                        'experience.required' => 'Experience is required.',
                        'experience.integer'  => 'Experience must be a number.',
                        'experience.min'      => 'Experience cannot be negative.',

                        // Organization
                        'practice_organization.required' => 'Practice organization is required.',
                        'practice_organization.max'      => 'Organization name is too long.',

                        // Website
                        'website_url.url' => 'Please enter a valid website URL.',
                        'website_url.max' => 'Website URL is too long.',

                        // Description
                        'description.required' => 'Description is required.',
                        'description.max'      => 'Description cannot exceed 2000 characters.',
                    ]
                );

                
            }
}
