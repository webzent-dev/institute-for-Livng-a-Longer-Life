<?php

use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\FAQController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\TestimonialsController; 
use App\Http\Controllers\Front\MembershipController;
use App\Http\Controllers\Front\Auth\LoginController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\HelpCenterController;
use App\Http\Controllers\Front\ShopController;
use App\Models\User;

// Route::get('/', function () {
    // $user=User::get();
    // dd($user);
//     return view('welcome');
// });

Route::get('/', [IndexController::class, 'index'] );    
Route::get('/about-dr-zeines',[AboutController::class, 'aboutZeines'] )->name('about-dr-zeines');
Route::get('/collaborators',[AboutController::class, 'collaborators'] )->name('collaborators'); 
Route::get('/intro-videos',[IndexController::class, 'introVideos'] )->name('intro-videos');  
Route::get('/membership',[IndexController::class, 'membership'] )->name('membership'); 
Route::post('/membership/register', [MembershipController::class, 'register'])->name('membership.register');
Route::get('/auth', [LoginController::class, 'showLoginForm'])->name('auth');
Route::get('/contact', [ContactController::class, 'index'] )->name('contact');
Route::get('/testimonials', [TestimonialsController::class, 'index'] )->name('testimonials');
Route::get('/faq', [FAQController::class, 'index'] )->name('faq');
Route::get('/help-center', [HelpCenterController::class, 'helpcenter'] )->name('help-center');
Route::get('/shop', [ShopController::class, 'index'] )->name('shop');

// Route::post('/login', [LoginController::class, 'login']);
Route::resource('index', IndexController::class);
Route::resource('about', AboutController::class);
Route::resource('testimonial', TestimonialsController::class);
Route::resource('faq', FAQController::class);


// Logout
Route::post('/logout', function () {
    // Auth::logout();
    return redirect('/');
})->name('logout');