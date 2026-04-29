<?php

namespace App\Http\Controllers\Front\Dashboard;
use App\Http\Controllers\Controller;
    

class DashboardController extends Controller
{
    public function index()
    {
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

        return view('front.dashboard.dashboard');
    }   
    // Placeholder methods for other routes
    public function users() { return view('users'); }
    public function analytics() { return view('analytics'); }
    public function reports() { return view('reports'); }
    public function settings() { return view('settings'); }

    private function getRoleStats($role)
    {
        // Dynamic stats based on role (e.g., Super Admin sees all)
        return match($role) {
            'super_admin' => ['users' => 4823, 'revenue' => 42580, /* etc. */],
            'admin' => ['users' => 3000, 'revenue' => 30000],
            default => ['users' => 100, 'revenue' => 5000],
        };
    }




}
