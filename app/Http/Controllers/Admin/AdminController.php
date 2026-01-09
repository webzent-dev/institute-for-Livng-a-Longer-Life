<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function users(Request $request)
    {
            // $users = User::all()->map(function ($u) {
            //     return [
            //         'name'        => $u->name,
            //         'initials'    => strtoupper(substr($u->name, 0, 2)),
            //         'email'       => $u->email,
            //         'role'        => $u->role ?? 'Viewer',
            //         'roleColor'   => $u->role === 'Admin' ? 'bg-blue-50 text-amber-700'
            //                         : ($u->role === 'Editor' ? 'bg-emerald-50 text-emerald-700'
            //                         : 'bg-amber-50 text-amber-700'),
            //         'status'      => $u->status ?? 'Active',
            //         'statusColor' => $u->status === 'Active' ? 'bg-green-500' : 'bg-slate-400',
            //     ];
            // });
        // 


        $query = User::query();

            if ($request->has('search') && $request->search != '') {
                $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%');
            }

            $users = $query->paginate(5);

            if ($request->ajax()) {
                return response()->json([
                    'data' => $users->items(),
                    'total' => $users->total(),
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                ]);
            }

            return view('admin.dashboard.users-list', compact('users'));



        // return view('admin.dashboard.users-list')->with('users', $users);
    }

    

}
