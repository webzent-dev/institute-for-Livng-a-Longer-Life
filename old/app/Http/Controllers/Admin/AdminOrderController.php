<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\OrderItem;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get all orders
        //$orders = Order::all();

        //Get orders with uer and product details
        $orders = Order::with('user')->get();

        //Count orders
        $orderCount = $orders->count();

        //active collaborators count
        $activeCollaboratorsCount = User::where('role', 'collaborator')->where('status', 'active')->count();

        //Member revenue calculation
        $memberRevenue = Order::whereHas('user', function($query) {
            $query->where('role', 'user');
        })->sum('total');

        //Collaborator revenue calculation
        $collaboratorRevenue = Order::whereHas('user', function($query) {
            $query->where('role', 'collaborator');
        })->sum('total');

        //Institute revenue calculation
        $instituteRevenue = Order::whereHas('user', function($query) {
            $query->whereIn('role', ['user','collaborator','admin']);
        })->sum('total');

        //Institute orders
        $instituteOrders = Order::selectRaw('orders.id as o_id, orders.*')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->whereIn('users.role', ['user','admin'])->get();

        //Collaborator orders
        $collaboratorOrders = Order::selectRaw('orders.id as o_id, orders.*')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->where('users.role', 'collaborator')->get();

        //Get Collaborators with Total Orders,Total Revenue
        $collaborators = User::where('role', 'collaborator')->get();
        foreach($collaborators as $collaborator) {
            $collaborator->totalOrders = Order::where('user_id', $collaborator->id)->count();
            $collaborator->totalRevenue = Order::where('user_id', $collaborator->id)->sum('total');
        }

        return view('admin.orders.index', compact('orders','orderCount','activeCollaboratorsCount','memberRevenue','instituteRevenue','collaboratorRevenue','instituteOrders','collaboratorOrders','collaborators'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orderDetail = Order::with('user')->where('id', $id)->first();
        $orderItems = OrderItem::where('order_id', $orderDetail->id)->get();
        return view('admin.orders.show', compact('orderDetail', 'orderItems'));
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
        $orderDetail = Order::where('id', $id)->first();
        $orderDetail->status = $request->input('status');
        $orderDetail->save();
        return redirect()->back()->with('success', 'Order status has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
