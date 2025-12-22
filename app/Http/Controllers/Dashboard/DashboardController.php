<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
    

class DashboardController extends Controller
{
    // public function __invoke()
    // {
    //     return view('dashboard.index', [
    //         'stats' => DashboardService::stats(),
    //         'activities' => DashboardService::activities(),
    //         'users' => DashboardService::recentUsers(),
    //     ]);
    // }
    public function index()
    {
        $users = DB::table('users')->where('id', 1)->first();
        // $profile = auth()->user()->collaboratorProfile;

        // return view('collaborator.dashboard', [
        //     'stats' => [
        //         'revenue' => $profile->orders()->sum('total_amount'),
        //         'products' => $profile->products()->count(),
        //         'orders' => $profile->orders()->count(),
        //         'views' => $profile->courses()->sum('view_count'),
        //     ]
        // ]);

        // $user = Auth::user();
       // $stats = $this->getRoleStats($user->role); // Dynamic data
       // return view('dashboard', compact('user', 'stats'));

        return view('front.dashboard.dashboard', compact('users'));
        // return view('front.dashboard.index');
    } 
    public function member()
    {
        return view('components.dashboard.member');
    }
 
    // Placeholder methods for other routes
    // public function users() { return view('users'); }
    // public function analytics() { return view('analytics'); }
    // public function reports() { return view('reports'); }
    // public function settings() { return view('settings'); }

    private function getRoleStats($role)
    {
        // Dynamic stats based on role (e.g., Super Admin sees all)
        // return match($role) {
        //     'super_admin' => ['users' => 4823, 'revenue' => 42580, /* etc. */],
        //     'admin' => ['users' => 3000, 'revenue' => 30000],
        //     default => ['users' => 100, 'revenue' => 5000],
        // };
    }




}
