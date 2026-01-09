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
use App\Http\Controllers\Collaborator\CollaboratorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserRegister; 
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Product\ProductController;

 
// admin routes

Route::get('/admin', [AdminController::class, 'index']);
Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login');

Route::prefix('admin')->middleware([RoleMiddleware::class.':admin'])->group(function () 
{
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('users',[AdminController::class, 'users'])->name('admin.users');
    
       
    Route::view('collaborators', 'admin.dashboard.collaborators-list')->name('admin.collaborators');   

    // Yahan aur admin routes add kar sakte ho
    // Route::get('users', [DashboardController::class, 'users'])->name('admin.users');
    // Route::get('settings', [DashboardController::class, 'settings'])->name('admin.settings');
});

// Admin Routes closures

//Collaborator  Routes

Route::get('/become-collaborator', [CollaboratorController::class, 'become_collaborator'])->name('become-collaborator');
Route::post('/become/collaborator', [CollaboratorController::class, 'store'])->name('become/collaborator.store');

Route::get('/collaborator', [CollaboratorController::class, 'index']);
Route::post('/collaborator/login', [LoginController::class, 'collaboratorLogin'])->name('collaborator.login');

Route::prefix('collaborator')->middleware([RoleMiddleware::class.':collaborator'])->group(function () 
{
    Route::get('dashboard', [DashboardController::class, 'collaboratorDashboard'])->name('collaborator.dashboard');

    //product routes for collaborator
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');


    // Yahan aur collaborator routes add kar sakte ho
    // Route::get('projects', [DashboardController::class, 'projects'])->name('collaborator.projects');
    // Route::get('profile', [DashboardController::class, 'profile'])->name('collaborator.profile');
});

//Collaborator  Routes closures


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
Route::get('/product-details', [ShopController::class, 'productDetails'] )->name('product-details');
Route::get('/products/filter', [ShopController::class, 'filter'])->name('products.filter');  
Route::get('/vital-boost', [VitalBoostController::class, 'index'] )->name('vital-boost');
Route::resource('index', IndexController::class);
Route::resource('about', AboutController::class);
Route::resource('testimonial', TestimonialsController::class);
Route::resource('faq', FAQController::class);


    

    
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

 