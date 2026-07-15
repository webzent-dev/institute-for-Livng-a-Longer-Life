<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\PageContent;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::with('user')
        ->whereIn('category',['collaborator','institute','vital_boost'])
        ->whereIn('product_type',['supplement','guide','book','vital_boost'])
        ->where('status', 'active')
        ->where(function($query) {
            // Institute + Vital Boost products are always shown; collaborator products
            // only while their seller is active. Vital Boost is available in the common
            // store for everyone at its actual price (non-members pay full price).
            $query->whereIn('category', ['institute', 'vital_boost'])
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('status', 'active');
                  });
        })
        ->get();
        
        // Get active collaborators for dropdown
        $collaborators = User::where('role', 'collaborator')
                            ->where('status', 'active')
                            ->select('id', 'first_name', 'last_name')
                            ->get();

        // Keyed by section_key (hero, member_benefits). The view falls back to its
        // built-in copy for any section that is missing or deactivated.
        $sections = PageContent::sections('shop');

        return view('front.pages.shop', compact('products', 'collaborators', 'sections'));
    }

    public function filter(Request $request)
    {
        $search = $request->search;
        $category = $request->category;
        $products = Product::whereIn('category', ['collaborator', 'institute', 'vital_boost'])
        ->when($search, function($q) use ($search) {
            $q->where('name', 'like', "%$search%");
        })
        ->when($category, function($q) use ($category) {
            $q->where('category', $category);
        })
        ->where('status', 'active')
        ->where(function($query) {
            $query->whereIn('category', ['institute', 'vital_boost'])
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('status', 'active');
                  });
        })
        ->get();
        
        // Get active collaborators for dropdown
        $collaborators = User::where('role', 'collaborator')
                            ->where('status', 'active')
                            ->select('id', 'first_name', 'last_name')
                            ->get();

        $sections = PageContent::sections('shop');

        return view('front.pages.shop', compact('products', 'collaborators', 'sections'));
    }

    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->route('shop')->with('error', 'Product not found.');
        }
        return view('front.pages.product-details', compact('product'));
    }

}