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
        $users = DB::table('users')->where('id', 1)->first();
         

        return view('front.dashboard.dashboard', compact('users'));
        
    } 
    public function member()
    {
        return view('components.dashboard.member');
    }
    public function home()
    {
        return view('components.dashboard.index');
    }
  

    private function getRoleStats($role)
    {
        
    }




}
