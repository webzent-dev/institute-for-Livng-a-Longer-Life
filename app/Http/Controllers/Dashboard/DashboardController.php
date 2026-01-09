<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
    

class DashboardController extends Controller
{
     
    public function index()
    {
        // $users = DB::table('users')->where('id', 1)->first();
        return view('collaborator.dashboard.index', [
        'totalUsers'      => User::count(),
        'admins'          => User::where('role', 'admin')->count(),
        'collaborators'   => User::where('role', 'collaborator')->count(),
        'customers'       => User::where('role', 'user')->count(),
    ]);
        return view('admin.dashboard.index');
        
    } 
    public function member()
    {
        return view('components.dashboard.member');
    }

    public function collaboratorDashboard()
    {
         return view('collaborator.dashboard.index', [
        'totalUsers'      => User::count(),
        'admins'          => User::where('role', 'admin')->count(),
        'collaborators'   => User::where('role', 'collaborator')->count(),
        'customers'       => User::where('role', 'user')->count(),
    ]);
        return view('collaborator.dashboard.index');
    }
    

    private function getRoleStats($role)
    {
        
    }




}
