<?php

use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\FAQController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\TestimonialsController; 
use App\Http\Controllers\Front\MembershipController;
use App\Http\Controllers\Front\Auth\LoginController;
use App\Http\Controllers\Front\ContactController;
use App\Models\User;

// Route::get('/', function () {
    // $user=User::get();
    // dd($user);
//     return view('welcome');
// });

Route::get('/', [IndexController::class, 'index'] );    
Route::get('/about-dr-zeines',[AboutController::class, 'aboutZeines'] );
Route::get('/collaborators',[AboutController::class, 'collaborators'] ); 
Route::get('/intro-videos',[IndexController::class, 'introVideos'] );  
Route::get('/membership',[IndexController::class, 'membership'] ); 
Route::post('/membership/register', [MembershipController::class, 'register'])->name('membership.register');
Route::get('/auth', [LoginController::class, 'showLoginForm']);
Route::get('/contact', [ContactController::class, 'index'] );
Route::get('/testimonials', [TestimonialsController::class, 'index'] );
// Route::get('/faq', [FAQController::class, 'index'] );

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