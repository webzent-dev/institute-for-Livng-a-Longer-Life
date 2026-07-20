<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SubOrder;
use App\Services\OrderStatusService;
use App\Services\ShippingLabelService;
use Illuminate\Validation\Rule;

class AdminOrderController extends Controller
{
    /**
     * Statuses an order or sub-order can be moved to.
     *
     * Defined on OrderStatusService so the member profile screen validates
     * against the same list.
     */
    private const STATUSES = OrderStatusService::STATUSES;

    public function __construct(
        private OrderStatusService $orderStatus,
    ) {
    }

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
     *
     * /orders/{id} and /orders/details/{id} are two doors onto the same page,
     * so both serve the full detail view with per-seller shipping and labels.
     */
    public function show(string $id)
    {
        return $this->getOrderDetails((int) $id);
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
        $orderItems = OrderItem::with('product.user')->where('order_id', $orderDetail->id)->get();

        //Get Collaborators with Products
        $collaboratorProductIds = Product::whereHas('user', function ($query) {
            $query->where('role', 'collaborator');
        })->pluck('id')->toArray();

        //One sub-order per seller, so each seller's label is generated on its own row
        $subOrders = SubOrder::with(['seller', 'items'])
            ->where('order_id', $orderDetail->id)
            ->orderBy('created_at')
            ->get();

        return view('admin.orders.order_details', compact('orderDetail', 'orderItems', 'collaboratorProductIds', 'subOrders'));
    }

    /**
     * Update a single sub-order's status.
     *
     * The admin manages every seller's sub-order here, whether the seller is the
     * Institute itself or a collaborator.
     */
    public function updateSubOrder(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        $subOrder = SubOrder::with('order')->findOrFail($id);

        $result = $this->orderStatus->updateSubOrder($subOrder, $validated['status']);

        return redirect()->back()->with($result['ok'] ? 'success' : 'error', $result['message']);
    }

    /**
     * Generate a Shippo shipping label for a single sub-order.
     */
    public function generateShippingLabel(Request $request, string $id)
    {
        $subOrder = SubOrder::findOrFail($id);

        $result = app(ShippingLabelService::class)->purchase($subOrder);

        return redirect()->back()->with($result['ok'] ? 'success' : 'error', $result['message']);
    }

    /**
     * Redirect to the label PDF for download.
     */
    public function downloadLabel(string $id)
    {
        $subOrder = SubOrder::findOrFail($id);

        if (!$subOrder->label_pdf_url) {
            return redirect()->back()->with('error', 'No label available for download.');
        }

        return redirect($subOrder->label_pdf_url);
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
        $validated = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        $orderDetail = Order::with('subOrders')->findOrFail($id);

        $result = $this->orderStatus->updateOrder($orderDetail, $validated['status']);

        return redirect()->back()->with($result['ok'] ? 'success' : 'error', $result['message']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
