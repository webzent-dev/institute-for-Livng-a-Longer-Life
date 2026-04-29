<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Course;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
    

class DashboardController extends Controller
{
     
    public function index()
    {

        //Admin revenue calculation
        $adminRevenue = Order::whereHas('user', function($query) {
            $query->whereIn('role', ['admin', 'collaborator', 'user']);
        })->sum('total');

        return view('admin.dashboard.index', [
            'totalUsers'      => User::count(),
            'admins'          => User::where('role', 'admin')->count(),
            'collaborators'   => User::where('role', 'collaborator')->count(),
            'customers'       => User::where('role', 'user')->count(),
            'orders'          => Order::count(),
            'products'        => Product::count(),
            'courses'         => Course::count(),
            'adminRevenue'    => $adminRevenue
        ]);
    } 
   
    /*
    public function collaboratorDashboard()
    {
        return view('collaborator.dashboard.index', [
            'totalUsers'      => User::count(),
            'admins'          => User::where('role', 'admin')->count(),
            'collaborators'   => User::where('role', 'collaborator')->count(),
            'customers'       => User::where('role', 'user')->count(),
        ]);
        return view('collaborator.dashboard.index');
    }*/

    private function getRoleStats($role)
    {
        
    }

}