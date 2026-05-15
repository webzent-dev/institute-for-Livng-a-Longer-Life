<?php

namespace App\Http\Controllers\Collaborator;
use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\CollaboratorLoginMail;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Course;
use App\Models\OrderItem;
use App\Models\SubOrder;
use App\Models\SubOrderItem;
use App\Models\CollaboratorBusinessDetails;
use App\Models\CollaboratorBankDetails;
use App\Services\ShippingService;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Database\UniqueConstraintViolationException;
use App\Mail\AdminCollaboratorNotification;
use App\Mail\OrderStatusNotification;

class CollaboratorController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }else if(Auth::check() && Auth::user()->role == 'collaborator') {
            return redirect()->route('collaborator.dashboard');
        }else if(Auth::check() && Auth::user()->role == 'user') {
            return redirect()->route('member.dashboard');
        }else{
            return view('collaborator.index');
        }
    }

    public function collaboratorLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $collaboratorLogin = Auth::attempt(array_merge($credentials, [
            'role' => 'collaborator',
            'status' => 'active', // <-- only active collaborators
        ]));

        if ($collaboratorLogin) {
            $request->session()->regenerate();
            return redirect()->route('collaborator.dashboard')
            ->with('success', 'Welcome Collaborator! Login successful.');
        }

        $user = \App\Models\User::where('email', $request->email)
        ->where('role', 'collaborator')
        ->first();

        if ($user && $user->status !== 'active') {
            return back()->with('error', 'Your account is inactive. Please wait for admin to activate it.')->withInput();
        }

        // If credentials are completely wrong
        return back()->with('error', 'Invalid credentials.')->withInput();
    }

    public function dashboard()
    {
        //Get collaborator products
        $collaboratorProducts = Product::where('user_id', Auth::id())->get();

        //Create array of product ids
        $collaboratorProductIds = [];
        foreach($collaboratorProducts as $product) {
            $collaboratorProductIds[] = $product->id;
        }    

        // Get sub-orders for this collaborator
        $subOrders = SubOrder::where('seller_id', Auth::id())
            ->with('order', 'items')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get traditional order items for backward compatibility
        $orderItems = OrderItem::whereIn('order_items.product_id', $collaboratorProductIds)
            ->selectRaw('orders.id as o_id, orders.*, order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        // Collaborator revenue calculation
        $collaboratorRevenue = SubOrder::where('seller_id', Auth::id())->sum('total');

        // Shipping validation
        $shippingValidation = $this->shippingService->validateSellerShippingSetup(Auth::user());

        // Business details for shipping setup
        $businessDetails = Auth::user()->collaboratorBusinessDetails;

        // Products requiring shipping setup
        $productsNeedingShippingSetup = Product::where('user_id', Auth::id())
            ->where('requires_shipping', true)
            ->where(function($query) {
                $query->whereNull('weight')
                      ->orWhere('weight', '<=', 0);
            })
            ->count();

        return view('collaborator.dashboard.index', [
            'totalUsers'      => User::count(),
            'admins'          => User::where('role', 'admin')->count(),
            'collaborators'   => User::where('role', 'collaborator')->count(),
            'customers'       => User::where('role', 'user')->count(),
            'orders'          => count($orderItems),
            'subOrders'       => $subOrders->count(),
            'products'        => Product::where('user_id', auth()->id())->count(),
            'courses'         => Course::where('user_id', auth()->id())->count(),
            'collaboratorRevenue' => $collaboratorRevenue,
            'shippingValidation' => $shippingValidation,
            'businessDetails' => $businessDetails,
            'productsNeedingShippingSetup' => $productsNeedingShippingSetup,
            'recentSubOrders' => $subOrders->take(5),
        ]);
    }

    public function createProfile()
    {
        // Yahan par collaborator ka profile dikhane ka logic likh sakte hain
        return view('collaborator.profile');
    }

    public function profile()
    {
        return view('front.collaborator.profile');
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make(
            [
                'first_name'  => $request->first_name,
                'last_name'  => $request->last_name,
                'phone'  => $request->phone,
                'speciality'  => $request->speciality,
                'professional_credentials'  => $request->professional_credentials,
                'experience'  => $request->experience,
                'organization'  => $request->organization,
                'collaborator_message'  => $request->collaborator_message,
                //'profile_image'  => $request->profile_image,
            ], 
            [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'speciality' => 'required|string|max:255',
                'professional_credentials' => 'required|string|max:255',
                'experience' => 'required|string|max:255',
                'organization' => 'required|string|max:255',
                'collaborator_message' => 'required',
                //'profile_image' => 'file|mimes:jpg,jpeg,png|max:2048',
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $profileImageName = null;
        if ($request->hasFile('profile_image') && !empty($request->profile_image)) {
            $profileImageName = time() . '.' . $request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('user_images'), $profileImageName);
        }

        $collaboratorDetail = User::findOrFail(Auth::id());
        $profile_image = !empty($profileImageName) ? $profileImageName : $collaboratorDetail->profile_image;
        $collaboratorDetail->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone, 
            'profile_image' => !empty($profile_image) ? $profile_image : null,
            'speciality' => $request->speciality,
            'professional_credentials' => $request->professional_credentials,
            'experience' => $request->experience,
            'organization' => $request->organization,
            'website' => $request->website,
            'collaborator_message' => $request->collaborator_message
        ]);

        return redirect()->back()->with('success', 'Profile has been updated successfully.');
    }

    public function becomeCollaborator()
    {
        
        return view('front.collaborator.become-collaborator');
    }
    
    public function store(Request $request)
    {
        /*$request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required',
            'password'   => 'required|min:8|confirmed',
            'specialty'  => 'required',
            'professional_credentials' => 'required',
            'experience' => 'required',
            'organization' => 'required',
            'website'    => 'nullable|url',
            'collaborator_massge' => 'required' 
        ]);*/
        
        try{
            if($request->password != $request->password_confirmation){
                return redirect()->route('become.collaborator.store')->with('error', 'Passwords do not match.');
            }else{
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name'  => $request->last_name,
                    'email'      => $request->email,
                    'phone'      => $request->phone,
                    'password'   => Hash::make(Str::random(32)),
                    'speciality'  => $request->speciality,
                    'professional_credentials' => $request->professional_credentials,
                    'experience' => $request->experience,
                    'organization' => $request->organization,
                    'website'    => $request->website,
                    'collaborator_message' => $request->collaborator_message,
                    'role'       => 'collaborator',
                    'status'     => 'inactive'
                ]);

                if(!empty($user->email)) {
                    $resetToken = Password::createToken($user);
                    $resetUrl = route('password.reset', ['token' => $resetToken, 'email' => $user->email]);
                    Mail::to($user->email)->send(
                        new CollaboratorLoginMail($user, null, $resetUrl)
                    );
                }

                //Send email to admin for new collaborator registration
                $adminDetail = User::where('role', 'admin')->first();
                $adminEmail = $adminDetail ? $adminDetail->email : null;
                if(!empty($adminEmail)){
                    Mail::to($adminEmail)->send(
                        new AdminCollaboratorNotification($user)
                    );
                }

                return redirect()->route('become.collaborator.store')->with('success', 'Collaborator has been created successfully. Please wait for admin approval.');
            }
        } catch (UniqueConstraintViolationException $e) {
            return redirect()->route('become.collaborator.store')->with('error', 'Email already exists. Please use a different email address.');
        } catch (\Exception $e) {
            return redirect()->route('become.collaborator.store')->with('error', 'An error occurred while creating the collaborator. Please try again.');
        }
    }

    public function orders()
    { 
        // Get sub-orders for this collaborator (new split shipping system)
        $subOrders = SubOrder::where('seller_id', Auth::id())
            ->with(['order.user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get traditional order items for backward compatibility
        $collaboratorProducts = Product::where('user_id', Auth::id())->get();
        $collaboratorProductIds = [];
        foreach($collaboratorProducts as $product) {
            $collaboratorProductIds[] = $product->id;
        }    

        $orders = OrderItem::whereIn('order_items.product_id', $collaboratorProductIds)
        ->selectRaw('orders.id as o_id, orders.*, order_items.product_id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->orderBy('orders.created_at', 'desc')
        ->paginate(10);

        return view('collaborator.orders.index', compact('subOrders', 'orders'));
    }

    /**
     * Show sub-order details with shipping information
     */
    public function subOrderDetails($id)
    {
        $subOrder = SubOrder::where('id', $id)
            ->where('seller_id', Auth::id())
            ->with(['order.user', 'items.product', 'seller'])
            ->firstOrFail();

        return view('collaborator.orders.sub-order-details', compact('subOrder'));
    }

    /**
     * Update sub-order status and generate shipping label
     */
    public function updateSubOrder(Request $request, string $id)
    {
        $subOrder = SubOrder::where('id', $id)
            ->where('seller_id', Auth::id())
            ->firstOrFail();

        $subOrder->status = $request->input('status');
        $subOrder->tracking_number = $request->input('tracking_number');
        $subOrder->carrier = $request->input('carrier');
        $subOrder->notes = $request->input('notes');
        $subOrder->save();

        // Send email notification to user about order status update
        if (!empty($subOrder->order->email)) {
            Mail::to($subOrder->order->email)->send(
                new OrderStatusNotification($subOrder->order)
            );
        }

        return redirect()->back()->with('success', 'Sub-order status has been updated successfully.');
    }

    public function orderDetails($id)
    {
        //Get collaborator products
        $collaboratorProducts = Product::where('user_id', Auth::id())->get();

        //Create array of product ids
        $collaboratorProductIds = [];
        foreach($collaboratorProducts as $product) {
            $collaboratorProductIds[] = $product->id;
        }

        $orderDetail = Order::with('user')
            ->where('id', $id)
            ->whereHas('items', function ($q) {
                $q->whereHas('product', function ($q2) {
                    $q2->where('user_id', Auth::id());
                });
            })
            ->firstOrFail();
        $orderItems = OrderItem::where('order_id', $orderDetail->id)->get();
        return view('collaborator.orders.show', compact('orderDetail', 'orderItems', 'collaboratorProductIds'));
    }

    public function updateOrder(Request $request, string $id)
    {
        $orderDetail = Order::where('id', $id)
            ->whereHas('items', function ($q) {
                $q->whereHas('product', function ($q2) {
                    $q2->where('user_id', Auth::id());
                });
            })
            ->firstOrFail();
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

    public function businessDetails()
    {
        $businessDetails = CollaboratorBusinessDetails::where('user_id', Auth::id())->first();
        $shippingValidation = $this->shippingService->validateSellerShippingSetup(Auth::user());
        $productsNeedingShippingSetup = Product::where('user_id', Auth::id())
            ->where('requires_shipping', true)
            ->where(function($query) {
                $query->whereNull('weight')
                      ->orWhere('weight', '<=', 0);
            })
            ->get();
        
        return view('collaborator.business-details', compact('businessDetails', 'shippingValidation', 'productsNeedingShippingSetup'));
    }

    public function storeBusinessDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'business_address' => 'required|string|max:500',
            'business_city' => 'required|string|max:255',
            'business_state' => 'required|string|max:255',
            'business_zip_code' => 'required|string|max:20',
            'business_country' => 'required|string|max:255',
            'business_phone' => 'required|string|max:20',
            'business_email' => 'required|email|max:255',
            'business_website' => 'nullable|url|max:255',
            'business_description' => 'nullable|string|max:1000',
            'tax_id' => 'nullable|string|max:50',
            'ein_number' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        CollaboratorBusinessDetails::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'business_name' => $request->business_name,
                'business_type' => $request->business_type,
                'business_address' => $request->business_address,
                'business_city' => $request->business_city,
                'business_state' => $request->business_state,
                'business_zip_code' => $request->business_zip_code,
                'business_country' => $request->business_country,
                'business_phone' => $request->business_phone,
                'business_email' => $request->business_email,
                'business_website' => $request->business_website,
                'business_description' => $request->business_description,
                'tax_id' => $request->tax_id,
                'ein_number' => $request->ein_number,
            ]
        );

        return redirect()->back()->with('success', 'Business details have been saved successfully.');
    }

    public function bankDetails()
    {
        $bankDetails = CollaboratorBankDetails::where('user_id', Auth::id())->first();
        return view('collaborator.bank-details', compact('bankDetails'));
    }

    public function storeBankDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_holder_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'routing_number' => 'required|string|max:50',
            'account_type' => 'required|in:checking,savings',
            'swift_code' => 'nullable|string|max:50',
            'iban' => 'nullable|string|max:50',
            'bank_address' => 'required|string|max:500',
            'bank_city' => 'required|string|max:255',
            'bank_state' => 'required|string|max:255',
            'bank_zip_code' => 'required|string|max:20',
            'bank_country' => 'required|string|max:255',
            'beneficiary_address' => 'nullable|string|max:500',
            'beneficiary_city' => 'nullable|string|max:255',
            'beneficiary_state' => 'nullable|string|max:255',
            'beneficiary_zip_code' => 'nullable|string|max:20',
            'beneficiary_country' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        CollaboratorBankDetails::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'account_holder_name' => $request->account_holder_name,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'routing_number' => $request->routing_number,
                'account_type' => $request->account_type,
                'swift_code' => $request->swift_code,
                'iban' => $request->iban,
                'bank_address' => $request->bank_address,
                'bank_city' => $request->bank_city,
                'bank_state' => $request->bank_state,
                'bank_zip_code' => $request->bank_zip_code,
                'bank_country' => $request->bank_country,
                'beneficiary_address' => $request->beneficiary_address,
                'beneficiary_city' => $request->beneficiary_city,
                'beneficiary_state' => $request->beneficiary_state,
                'beneficiary_zip_code' => $request->beneficiary_zip_code,
                'beneficiary_country' => $request->beneficiary_country,
            ]
        );

        return redirect()->back()->with('success', 'Bank details have been saved successfully.');
    }

    /**
     * Show shipping configuration page
     */
    public function shippingConfiguration()
    {
        $businessDetails = Auth::user()->collaboratorBusinessDetails;
        $shippingValidation = $this->shippingService->validateSellerShippingSetup(Auth::user());
        
        return view('collaborator.shipping.configuration', compact('businessDetails', 'shippingValidation'));
    }

    /**
     * Update handling fee and shipping preferences
     */
    public function updateShippingConfiguration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'handling_fee' => 'required|numeric|min:0|max:50',
            'default_package_template' => 'required|string|in:usps_flat_rate_small,usps_flat_rate_medium,usps_flat_rate_large,custom_box',
            'shipping_instructions' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        // Store shipping preferences in user metadata or create a separate table
        $user = Auth::user();
        $user->update([
            'shipping_handling_fee' => $request->handling_fee,
            'shipping_package_template' => $request->default_package_template,
            'shipping_instructions' => $request->shipping_instructions,
        ]);

        return redirect()->back()->with('success', 'Shipping configuration has been updated successfully.');
    }

}