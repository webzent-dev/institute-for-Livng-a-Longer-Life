<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Membership;
use App\Models\ZoomSession;
use App\Models\ZoomSessionRecordedLink;
use App\Models\Product;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Charge;
use Carbon\Carbon;
use App\Models\PaymentHistory;

class MemberController extends Controller
{
    public function member()
    {
        return view('member.member');
    }

    public function member_dashboard()
    {
        //Get zoom session with user detail
        $upcomingSessions = ZoomSession::all();
        $recordedSessions = ZoomSessionRecordedLink::with('user','zoomSession')->get();
        return view('member.dashboard', compact('upcomingSessions','recordedSessions'));
    }

    public function member_profile()
    {
        $userDetail = auth()->user();
        $userInfo = json_decode($userDetail, true);

        //Get user address detail
        $userAddressInfo = UserAddress::where('user_id', $userInfo['id'])->first();
        if(empty($userAddressInfo)){
            $userAddressInfo = [
                'address_line_1' => '',
                'address_line_2' => '',
                'city' => '',
                'state' => '',
                'zip_code' => '',
                'bio' => ''
            ];   
        }else{
            $userAddressInfo = [
                'address_line_1' => $userAddressInfo->address_line_1,
                'address_line_2' => $userAddressInfo->address_line_2,
                'city' =>  $userAddressInfo->city,
                'state' =>  $userAddressInfo->state,
                'zip_code' =>  $userAddressInfo->zip_code,
                'bio' =>  $userAddressInfo->bio
            ];
        }
        $userAddressDetail = json_encode($userAddressInfo, true);
        //echo $userDetail;
        //echo '<br>';
        //echo $userAddressDetail;exit;
        //echo '<pre>';print_r($userAddressDetail);exit;

        return view('member.profile', compact('userDetail', 'userAddressDetail', 'userInfo'));
    }

    public function member_security()
    {
        return view('member.security');
    }

    public function member_subscription()
    {
        $nextBilling = auth()->user()->plan_expiry;
        return view('member.subscription');
    }

    public function member_orders()
    {
        //Get orders 
        $orders = Order::where('user_id', auth()->user()->id)->get();

        //Get delivered orders
        $deliveredOrders = Order::where('user_id', auth()->user()->id)->where('status', 'delivered')->get();

        return view('member.orders',compact('orders','deliveredOrders'));
    }

    public function member_plans()
    {
        $memberships = Membership::where('status', 'active')->get();
        return view('member.plans',compact('memberships'));
    }

    public function member_payments()
    {
        $paymentHistory = PaymentHistory::where('user_id', auth()->user()->id)->get();
        return view('member.payments', compact('paymentHistory'));
    }

    public function member_videoLibrary()
    {
        $collaborators = User::where('role', 'collaborator')->get();

        //Course categories
        $courseCategories = [
            'health_wellness' => 'Health & Wellness',
            'nutrition' => 'Nutrition',
            'biohacking' => 'Biohacking',
            'mental_health' => 'Mental Health',
            'fitness' => 'Fitness',
            'longevity_science' => 'Longevity Science',
            'supplements' => 'Supplements',
            'lifestyle' => 'Lifestyle'
        ];

        return view('member.member-video-library', compact('collaborators', 'courseCategories'));
    }

    public function member_store()
    {
        //Get products
        $products = Product::with('user')->where('category','member_exclusive')->where('product_type','supplement')->where('status', 'active')->get();
        
        //Get guides
        $guides = Product::with('user')->where('category','member_exclusive')->where('product_type','guide')->where('status', 'active')->get();

        //Get books
        $books = Product::with('user')->where('category','member_exclusive')->where('product_type','book')->where('status', 'active')->get();
        
        return view('member.store', compact('products', 'guides', 'books'));
    }

    public function saveProfile(Request $request){
        $first_name = $request->firstName;
        $last_name = $request->lastName;
        $email = auth()->user()->email;
        $phone = $request->phone;
        $address = $request->address;
        $city = $request->city;
        $state = $request->state;
        $zip_code = $request->zipCode;
        $bio = $request->bio;

        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        // ================= IMAGE UPLOAD =================
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($user->profile_image && file_exists(public_path('user_images/'.$user->profile_image))) {
                unlink(public_path('user_images/'.$user->profile_image));
            }

            $file = $request->file('profile_image');
            $filename = time().'_'.rand(1000,9999).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('user_images'), $filename);
            $user->profile_image = $filename;
        }

        // ================= UPDATE USER =================
        $user->first_name = $request->firstName;
        $user->last_name  = $request->lastName;
        $user->phone      = $request->phone;
        $user->save();

        //Get detail from user_addresses table
        $userAddressDetail = UserAddress::where('user_id', $user_id)->first();

        if(!empty($userAddressDetail)){
            //Update user address
            UserAddress::where('user_id', $user_id)->update([
                'address_line_1' => $address,
                'city' => $city,
                'state' => $state,
                'zip_code' => $zip_code,
                'bio' => $bio
            ]);
        }else{
            //Create new user address
            UserAddress::create([
                'user_id' => $user_id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'phone' => $phone,
                'address_line_1' => $address,
                'city' => $city,
                'state' => $state,
                'zip_code' => $zip_code,
                'bio' => $bio
            ]);
        }
        return response()->json(['success' => 'Profile has been updated successfully.']);
    }

    public function updatePassword(Request $request){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
       
        //Check current password
        if(Hash::check($request->current_password, $user->password)){
            //Add validation for new password at length 8 character
            $request->validate([
                'new_password' => 'required|string|min:8',
            ]);

            if($request->new_password != $request->confirm_password){
                return response()->json(['status'=>false,'message' => 'Password does not match.']);
            }else{
                //Update password
                $user->password = bcrypt($request->new_password);
                $user->save();

                return response()->json(['status'=>true,'message' => 'Password has been updated successfully.']);
            }
        }else{
            return response()->json(['status'=>false,'message' => 'Current password does not match.']);
        }
    }

    public function upgradeMembership(Request $request){
        $plan_id = $request->plan_id;
        $user_id = auth()->user()->id;
        $userDetail = User::find($user_id);
        $planDetail = Membership::find($plan_id);

        /************Stripe payment start here****************/
        session(['planDetail'=>$planDetail]);
        Stripe::setApiKey(config('services.stripe.secret'));
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $planDetail['membership_name'],
                        'description' => $planDetail['membership_name'],
                    ],
                    'unit_amount' => (int)($planDetail['membership_price'] * 100), // Dynamic total in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'invoice_creation' => [
                'enabled' => true
            ],
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel')
        ]);
        return redirect($session->url, 303);
        /************Stripe payment end here*****************/
    }

}