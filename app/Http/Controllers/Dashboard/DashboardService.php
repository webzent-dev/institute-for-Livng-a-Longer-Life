<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

class DashboardService
{
    public static function stats()
    {
        // $user = auth()->user();

        // return match (true) {
        //     $user->hasRole('super_admin') => SuperAdminStats::get(),
        //     $user->hasRole('admin') => AdminStats::get(),
        //     $user->hasRole('collaborator') => CollaboratorStats::get($user),
        //     default => UserStats::get($user),
        // };
    }

    public static function activities() { /* same pattern */ }
    public static function recentUsers() { /* same pattern */ }
}
