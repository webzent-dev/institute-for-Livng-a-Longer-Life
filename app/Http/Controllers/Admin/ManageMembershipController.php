<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membership;

class ManageMembershipController extends Controller
{

    protected $properties;
    protected $status;

    public function __construct()
    {
        //$this->status = Config::get('content');
        $this->membership = new Membership;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $memberships = Membership::all();
        return view('admin.membership.index',compact('memberships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.membership.add_membership');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            /*$request->validate([
                'membership_name' => 'required|string|max:255',
                'membership_price' => 'required',
                'membership_period' => 'required',
                'membership_description' => 'required',
                'membership_features' => 'required',
                'membership_benefits' => 'required',
            ]);*/

            if ($this->membership->createMembership($request)) {
                return redirect()->route('admin.manage-membership')->with('success', 'Membership has been created successfully.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $membershipDetail = Membership::findOrFail($id);
            return view('admin.membership.show', compact('membershipDetail'));
        }catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $membership_detail = Membership::findOrFail($id);
            return view('admin.membership.show', compact('membership_detail'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'membership_name' => 'required|string|max:255',
                'membership_price' => 'required',
                'membership_period' => 'required',
                'membership_description' => 'required',
                'membership_features' => 'required',
                'membership_benefits' => 'required',
            ]);

            if ($this->membership->updateMembership($request,$id)) {
                return redirect()->back()->with('success', 'Membership has been updated successfully.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateMembership(Request $request){
        try {
            if ($this->membership->updateMembership($request,$request->membership_id)) {
                return redirect()->back()->with('success', 'Membership has been updated successfully.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deleteMembership = Membership::findOrFail($id)->delete();
            if ($deleteMembership) {
                return redirect('admin/manage-membership')
                ->with('success', 'Membership has been deleted successfully.');
            } else {
                throw new Exception('Membership could not be deleted.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Make Popular the specified resource from storage.
     */
    public function makePopular(Request $request)
    {
        try {
            if ($this->membership->makePopular($request->id, $request->popular_value) == true) {
                if($request->popular_value == 'no'){
                    $message = 'Membership has been unpopulared successfully.';
                }else{
                    $message = 'Membership has been populared successfully.';
                }

                return response()->json([
                    'status' => true,
                    'message' => $message,
                    'membership_popular' => ucfirst($request->popular_value)
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again...',
                'membership_popular' => ucfirst($request->popular_value)
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);
        $membership = Membership::findOrFail($id);
        $membership->status = $request->status;
        $membership->save();
        return response()->json(['success' => true]);
    }

}