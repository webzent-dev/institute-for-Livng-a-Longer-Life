<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberSignupMail;

class UserController extends Controller
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
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$users = User::all();

        //Members List
        $members = User::where('role', 'user')->get();

        //Collaborators List
        $collaborators = User::where('role', 'collaborator')->get();

        //Admins List
        $admins = User::where('role', 'admin')->get();

        return view('admin.users.index', compact('members', 'collaborators', 'admins'));
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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,collaborator,user',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => bcrypt('12345678'), // Set a default password or generate one
        ]);

        Mail::to($request->email)->send(
            new MemberSignupMail($user, '12345678')
        );

        return redirect()->back()->with('success', 'User has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userDetail = User::find($id);
        return view('admin.users.show', compact('userDetail'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id=0)
    {
        $data = [
            'is_deleted'=>'1'
        ];
        $delete = User::deleteUserByID($id, $data);
        if ($delete) {
            return redirect('admin/users')->with('success', 'User has been deleted successfully!');
        } else {
            return redirect()->back()->withErrors('Unable to delete user.Please try again...!!!');
        }
    }

    public function changeStatus(Request $request){
        $id     = !empty($request->id)?$request->id:'';
        $status_value = !empty($request->status_value)?$request->status_value:'';
        $data   = [
            'status' => $status_value
        ];
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
    public function updateUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::find($request->user_id);
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'User has been updated successfully.');
    }

}
