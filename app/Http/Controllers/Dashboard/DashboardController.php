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
     public function member()
        {
            return view('member.member');
            
        }

    public function member_dashboard()
    {
        return view('member.dashboard');
    }

    public function member_profile()
    {
        return view('member.profile');
    }

    public function member_security()
    {
        return view('member.security');
    }

    public function member_subscription()
    {
        return view('member.subscription');
    }

    public function member_orders()
    {
        return view('member.orders');
    }

    public function member_plans()
    {
        return view('member.plans');
    }

    public function member_payments()
    {
        return view('member.payments');
    }

    public function member_videoLibrary()
    {
        return view('member.member-video-library');
    }

    public function member_store()
    {
        return view('member.store');
    }

}
