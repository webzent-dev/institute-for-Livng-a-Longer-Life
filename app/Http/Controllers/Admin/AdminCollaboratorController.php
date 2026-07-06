<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CollaboratorBusinessDetails;
use App\Models\CollaboratorBankDetails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Mail\MemberSignupMail;
use App\Mail\CollaboratorActiveMail;
use App\Mail\CollaboratorLoginMail;
use Validator;
use Illuminate\Database\UniqueConstraintViolationException;

class AdminCollaboratorController extends Controller
{
    /**
     * Create $status variable.
     *
     * @return void
     */
    public $status;

    /*public function collaborators_details()
    {
         
        return view('admin.collaborators.collaborators_details');
    }*/
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = config('constant');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collaborators = User::where('role', 'collaborator')
        ->withCount('products')
        ->withCount('courses')
        ->paginate(10);
        return view('admin.collaborators.index', compact('collaborators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*$request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'speciality' => 'required|string|max:255',
            'professional_credentials' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'bio' => 'required|string|max:255',
            'profile_image' => 'file|mimes:jpg,jpeg,png|max:2048',
        ]);*/

        /*$validator = Validator::make(
            [
                'first_name'  => $request->first_name,
                'last_name'  => $request->last_name,
                'email'  => $request->email,
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
                'email' => 'required|email|unique:users,email',
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
            return redirect()->back()->withErrors($validator)->withInput();
        }
        */
        try{
            $profileImageName = null;
            if ($request->hasFile('profile_image')) {
                $profileImageName = time() . '.' . $request->profile_image->getClientOriginalExtension();
                $request->profile_image->move(public_path('user_images'), $profileImageName);
            }

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'profile_image' => $profileImageName,
                'password' => bcrypt(Str::random(32)),
                'speciality' => $request->speciality,
                'professional_credentials' => $request->professional_credentials,
                'experience' => $request->experience,
                'organization' => $request->organization,
                'website' => $request->website,
                'collaborator_message' => $request->collaborator_message,
                'role' => 'collaborator',
                'status' => 'inactive'
            ]);

            if(!empty($user->email)){
                $resetToken = Password::createToken($user);
                $resetUrl = route('password.reset', ['token' => $resetToken, 'email' => $user->email]);
                Mail::to($user->email)->send(
                    new CollaboratorLoginMail($user, null, $resetUrl)
                );
            }

            return redirect()->back()->with('success', 'Collaborator has been created successfully.');
        } catch (UniqueConstraintViolationException $e) {
            return redirect()->back()->with('error', 'Email already exists. Please use a different email address.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the collaborator. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $collaboratorDetail = User::findOrFail($id);
        //Get collaborator products
        $collaboratorProducts = $collaboratorDetail->products()->get();
        //Get collaborator courses
        $collaboratorCourses = $collaboratorDetail->courses()->get();
        //Get business details
        $businessDetails = CollaboratorBusinessDetails::where('user_id', $id)->first();
        //Get bank details
        $bankDetails = CollaboratorBankDetails::where('user_id', $id)->first();
        return view('admin.collaborators.show', compact('collaboratorDetail', 'collaboratorProducts', 'collaboratorCourses', 'businessDetails', 'bankDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $profileImageName = null;
        if ($request->hasFile('profile_image')) {
            $profileImageName = time() . '.' . $request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('user_images'), $profileImageName);
        }

        $collaboratorDetail = User::findOrFail($id);
        $collaboratorDetail->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone, 
            'speciality' => $request->speciality,
            'professional_credentials' => $request->professional_credentials,
            'experience' => $request->experience,
            'organization' => $request->organization,
            'website' => $request->website,
            'collaborator_message' => $request->collaborator_message
        ]);

        return redirect()->back()->with('success', 'Collaborator has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id=0)
    {
        try{
            $data = [
                'is_deleted'=>'1'
            ];
            $delete = User::deleteUserByID($id, $data);
            if ($delete) {
                return redirect('admin/collaborators')->with('success', 'Collaboarator has been deleted successfully!');
            }else{
                return redirect()->back()->with('error','Unable to delete collaborator.Please try again...!!!');
            } 
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->with('error','Unable to delete collaborator because collaborator is associated with other records. Please try again...!!!');
        }
    }

    public function changeStatus(Request $request){
        $id     = !empty($request->id)?$request->id:'';
        $status_value = !empty($request->status_value)?$request->status_value:'';
        $data   = [
            'status' => $status_value
        ];
        //Update tax status
        $update = User::updateUserByID($id, $data);

        $status = $this->status['error']['status'];
        $message = str_replace('{text}', 'user', $this->status['error']['status_change_message']);
        if ($update) {
            $status = $this->status['success']['status'];
            $message = str_replace('{text}', 'User', $this->status['success']['status_change_message']);
        }
        $result = array(
            'status' => !empty($status)?$status:'',
            'message' => !empty($message)?$message:'',
            'user_status' => !empty($status_value)?ucfirst($status_value):''
        );
        return response()->json($result);
    }

    /**
     * Update user information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
    */
    /*public function updateUser(Request $request)
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

        return redirect()->back()->with('success', 'User has been updated successfully.');
    }*/


    public function changeCollaboratorStatus($id)
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
            if(!empty($collaborator->email)) {
                Mail::to($collaborator->email)
                ->send(new CollaboratorActiveMail($collaborator));
            }
        }

        return response()->json([
            'status' => $newStatus
        ]);
    }

    public function updateCollaborator(Request $request)
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $collaboratorDetail = User::findOrFail($request->user_id);
        if ($request->hasFile('profile_image')) {
            $profileImageName = time() . '.' . $request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('user_images'), $profileImageName);
        }else{
            $profileImageName = $collaboratorDetail->profile_image;
        }

        $collaboratorDetail->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone, 
            'profile_image' => $profileImageName,
            'speciality' => $request->speciality,
            'professional_credentials' => $request->professional_credentials,
            'experience' => $request->experience,
            'organization' => $request->organization,
            'website' => $request->website,
            'collaborator_message' => $request->collaborator_message
        ]);

        return redirect()->back()->with('success', 'Collaborator has been updated successfully.');
    }

}
