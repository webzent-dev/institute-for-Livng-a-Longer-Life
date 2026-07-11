<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderStatusNotification;
use Illuminate\Support\Facades\Mail;

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

        //Institute revenue calculation
        $instituteRevenue = Order::sum('total');

        //Institute orders
        $instituteOrders = Order::selectRaw('orders.id as o_id, orders.*')
        //->join('users', 'orders.user_id', '=', 'users.id')
        //->whereIn('users.role', ['user','admin'])
        ->orderBy('orders.created_at', 'desc')
        ->paginate(10);

        //Get Collaborators with Products
        $collaborators = User::where('role', 'collaborator')->paginate(10);

        //Get all collaborator product ids
        $allCollaborators = User::where('role', 'collaborator')->get();
        $collaboratorProductIds = [];
        foreach($allCollaborators as $collaborator) {
            //Get collaborator products
            $collaboratorProducts = Product::where('user_id', $collaborator->id)->get();

            //Create array of product ids
            foreach($collaboratorProducts as $product) {
                $collaboratorProductIds[] = $product->id;
            }
        }

        //Collaborator orders
        $collaboratorOrders = OrderItem::whereIn('order_items.product_id', $collaboratorProductIds)
        ->selectRaw('orders.id as o_id, orders.*, order_items.product_id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->orderBy('orders.created_at', 'desc')
        ->paginate(10);

        //Collaborator revenue calculation
        $collaboratorRevenue = OrderItem::whereIn('order_items.product_id', $collaboratorProductIds)
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->sum('orders.total');


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
        $orderDetail = Order::findorFail($id);
        $orderItems = OrderItem::where('order_id', $orderDetail->id)->get();
        return view('admin.orders.show', compact('orderDetail', 'orderItems'));
    }

    /**
     * Get order details by order id
     *
     * @param int $id order id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getOrderDetails(int $id)
    {
        $orderDetail = Order::findorFail($id);
        $orderItems = OrderItem::where('order_id', $orderDetail->id)->get();

        //Get Collaborators with Products
        $collaborators = User::where('role', 'collaborator')->get();
        $collaboratorProductIds = [];
        foreach($collaborators as $collaborator) {
            //Get collaborator products
            $collaboratorProducts = Product::where('user_id', $collaborator->id)->get();

            //Create array of product ids
            foreach($collaboratorProducts as $product) {
                $collaboratorProductIds[] = $product->id;
            }
        }

        return view('admin.orders.order_details', compact('orderDetail', 'orderItems', 'collaboratorProductIds'));
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
        $orderDetail = Order::with('subOrders')
        ->where('id', $id)
        ->first();
        $orderDetail->status = $request->input('status');
        $orderDetail->save();

        //Send email notification to user about order status update
        if(!empty($orderDetail->email)) {
            Mail::to($orderDetail->email)->send(
                new OrderStatusNotification($orderDetail)
            );
        }

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
