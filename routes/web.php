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
use App\Http\Controllers\Courses\CoursesController; 
use App\Http\Controllers\Admin\WebSettingsController;




 
// admin routes

Route::get('/admin', [AdminController::class, 'index']);
Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login');
Route::prefix('admin')->middleware([RoleMiddleware::class.':admin'])->group(function () 
{
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('Approved', [AdminController::class, 'Approved'])->name('admin.approved.products');
    Route::post('/admin/products/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.products.status');
    Route::get('users', [AdminController::class, 'users'])->name('users.index');
    Route::put('user/update', [AdminController::class, 'update'])->name('admin.user.update');
    Route::get('/collaborators', [AdminController::class, 'collaborators'])->name('collaborators.index');

 

    Route::get('/web/settings', [WebSettingsController::class, 'websettings'])->name('admin.web.settings');
    // Route::get('/web/settings', [WebSettingsController::class, 'editSettings'])->name('admin.web.settings.edit');
    Route::post('web/settings/update', [WebSettingsController::class, 'updateSettings'])->name('admin.web.settings.update');

    Route::post('/admin/collaborators/status/{id}', [AdminController::class, 'CollabStatus'])->name('admin.collaborators.status');
    Route::get('admin/courses', [AdminController::class, 'courses'])->name('admin.courses');

    

    // Yahan aur admin routes add kar sakte ho
    // Route::get('users', [DashboardController::class, 'users'])->name('admin.users');
    // Route::get('settings', [DashboardController::class, 'settings'])->name('admin.settings');
});





Route::get('/collaborator', [CollaboratorController::class, 'index']);
Route::post('/collaborator/login', [LoginController::class, 'collaboratorLogin'])->name('collaborator.login');

Route::prefix('collaborator')->middleware([RoleMiddleware::class.':collaborator'])->group(function () 
{
    Route::get('dashboard', [DashboardController::class, 'collaboratorDashboard'])->name('collaborator.dashboard');

    Route::get('/profile', [CollaboratorController::class, 'createProfile'])->name('profile.show');  
    Route::put('/profile/update', [CollaboratorController::class, 'updateProfile'])->name('profile.update');

    //product routes for collaborator
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.delete');

    Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CoursesController::class, 'create'])->name('courses.create');
    Route::post('/courses/store', [CoursesController::class, 'store'])->name('courses.store');
    Route::get('/courses/{id}/edit', [CoursesController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CoursesController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CoursesController::class, 'destroy'])->name('courses.destroy');
   
 
});

//Public Routes
Route::get('/', [IndexController::class, 'index'] );    
Route::get('/about-dr-zeines',[AboutController::class, 'aboutZeines'] )->name('about-dr-zeines');
Route::get('/collaborators',[AboutController::class, 'collaborators'] )->name('collaborators');
Route::get('collaborator/store/{id}', [AboutController::class, 'store'])->name('collaborator.store');
Route::get('/intro-videos',[IndexController::class, 'introVideos'] )->name('intro-videos');  
Route::get('/membership',[IndexController::class, 'membership'] )->name('membership'); 
Route::post('/membership/store', [UserRegister::class, 'store']);
Route::get('/auth', [LoginController::class, 'showLoginForm'])->name('auth');
Route::get('/contact', [ContactController::class, 'index'] )->name('contact');
Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletter/subscribe', [ContactController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/testimonials', [TestimonialsController::class, 'index'] )->name('testimonials');
Route::get('/faq', [FAQController::class, 'index'] )->name('faq.index');
Route::get('/help-center', [HelpCenterController::class, 'helpcenter'] )->name('help-center');
Route::get('/shop', [ShopController::class, 'index'] )->name('shop');
Route::get('/product-details', [ShopController::class, 'productDetails'] )->name('product-details');
Route::get('/products/filter', [ShopController::class, 'filter'])->name('products.filter');  
Route::get('/vital-boost', [VitalBoostController::class, 'index'] )->name('vital-boost');
Route::get('/become-collaborator', [CollaboratorController::class, 'becomeCollaborator'])->name('become-collaborator');

Route::get('/collaborator/profile-details', [CollaboratorController::class, 'profile'])->name('collaborator.profile-details');
Route::post('/become/collaborator', [CollaboratorController::class, 'store'])->name('become.collaborator.store');

   

    Route::prefix('member')->name('member.')->group(function () {

  
    Route::get('/', [DashboardController::class, 'member_dashboard'])
        ->name('dashboard');

    Route::get('/profile', [DashboardController::class, 'member_profile'])
        ->name('profile');

    Route::get('/security', [DashboardController::class, 'member_security'])
        ->name('security');

    Route::get('/subscription', [DashboardController::class, 'member_subscription'])
        ->name('subscription');

    Route::get('/orders', [DashboardController::class, 'member_orders'])
        ->name('orders');

    Route::get('/plans', [DashboardController::class, 'member_plans'])
        ->name('plans');

    Route::get('/payments', [DashboardController::class, 'member_payments'])
        ->name('payments');

    Route::get('/video-library', [DashboardController::class, 'member_videoLibrary'])
        ->name('video-library');

    Route::get('/store', [DashboardController::class, 'member_store'])
        ->name('store');

});

 


   Route::fallback(function () {
    abort(404);
});     