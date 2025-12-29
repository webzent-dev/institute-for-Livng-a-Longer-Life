<?php

use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\FAQController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\TestimonialsController; 
use App\Http\Controllers\Front\Auth\LoginController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\HelpCenterController;
use App\Http\Controllers\Front\ShopController;
use App\Http\Controllers\Front\VitalBoostController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\UserRegister;
 

Route::get('/', [IndexController::class, 'index'] );    
Route::get('/about-dr-zeines',[AboutController::class, 'aboutZeines'] )->name('about-dr-zeines');
Route::get('/collaborators',[AboutController::class, 'collaborators'] )->name('collaborators'); 
Route::get('/intro-videos',[IndexController::class, 'introVideos'] )->name('intro-videos');  
Route::get('/membership',[IndexController::class, 'membership'] )->name('membership'); 
Route::post('/membership/store', [UserRegister::class, 'store']);
Route::get('/auth', [LoginController::class, 'showLoginForm'])->name('auth');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/contact', [ContactController::class, 'index'] )->name('contact');
Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletter/subscribe', [ContactController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/testimonials', [TestimonialsController::class, 'index'] )->name('testimonials');
Route::get('/faq', [FAQController::class, 'index'] )->name('faq');
Route::get('/help-center', [HelpCenterController::class, 'helpcenter'] )->name('help-center');
Route::get('/shop', [ShopController::class, 'index'] )->name('shop');
Route::get('/products/filter', [ShopController::class, 'filter'])->name('products.filter');  
Route::get('/vital-boost', [VitalBoostController::class, 'index'] )->name('vital-boost');
Route::resource('index', IndexController::class);
Route::resource('about', AboutController::class);
Route::resource('testimonial', TestimonialsController::class);
Route::resource('faq', FAQController::class);


    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('admin/dashboard/home', [DashboardController::class, 'home'])->name('admin/dashboard/home');
    Route::get('admin/member', [DashboardController::class, 'member'])->name('dashboard');
    Route::get('/das', fn () => view('components.dashboard.sidebar.das'))
        ->name('das');

    Route::get('/orders', fn () => view('components.dashboard.sidebar.orders'))
        ->name('orders');

    Route::get('/security', fn () => view('components.dashboard.sidebar.security'))
        ->name('security');

    Route::get('/subscription', fn () => view('components.dashboard.sidebar.subscription'))
        ->name('subscription');

    Route::get('/member', fn () => view('components.dashboard.sidebar.member'))
        ->name('member');

    Route::get('/payments', fn () => view('components.dashboard.sidebar.payments'))
        ->name('payments');

 