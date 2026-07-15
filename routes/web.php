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
use App\Http\Controllers\Collaborator\CollaboratorProductController;
//use App\Http\Controllers\Courses\CoursesController;
use App\Http\Controllers\Collaborator\CollaboratorCourseController;
use App\Http\Controllers\Admin\WebSettingsController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Admin\ManageMembershipController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminCollaboratorController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\ZoomSessionController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\StripeWebhookController;
use App\Http\Controllers\Front\MemberController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\ContentManagementController;
use App\Http\Controllers\Admin\VitalBoostContentController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminVideoTestimonialController;
use App\Http\Controllers\Admin\AdminFaqCategoryController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminHelpCategoryController;
use App\Http\Controllers\Admin\AdminHelpArticleController;
use App\Http\Controllers\Admin\AdminIntroVideosController;
use App\Http\Controllers\Admin\AdminSubscriberController;
use App\Http\Controllers\Admin\EmailManagementController;

//------------Admin routes start here--------//
Route::get('/admin', [AdminController::class, 'index']);
Route::post('/admin/login', [LoginController::class, 'adminLogin'])->middleware('throttle:5,1')->name('admin.login');
Route::prefix('admin')->middleware([RoleMiddleware::class.':admin'])->group(function ()
{
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/audit/logs', [AdminController::class, 'auditLogs'])->name('admin.audit.logs');
    Route::get('/audit/logs/details', [AdminController::class, 'auditLogsDetails'])->name('admin.audit.logs.details');
    
    //------------Product management start here--------//
    #Route::get('Approved', [AdminController::class, 'Approved'])->name('admin.approved.products');
    Route::resource('/products', AdminProductController::class)->only(
        ['create','store','show','edit','update','destroy']
    );
    Route::post('/products/{id}/status', [AdminProductController::class, 'updateStatus'])->name('admin.products.status');
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::put('/products/{id}/update', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}/delete', [AdminProductController::class, 'destroy'])->name('admin.products.delete');
    Route::post('/products/remove-image', [AdminProductController::class, 'removeImage'])->name('admin.products.removeImage');
    //------------Product management end here--------//

    //------------User management start here--------//
    #Route::get('users', [AdminController::class, 'users'])->name('users.index');
    Route::resource('/users', UserController::class)->only(
        ['create','store','show','edit','update','destroy']
    );
    Route::post('/users/changeStatus', [UserController::class,'changeStatus'])->name('admin.users.changestatus');
    Route::put('user/update', [UserController::class, 'updateUser'])->name('admin.users.update');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    //------------User management end here--------//

    //------------Collaborator management start here--------//
    //Route::get('/collaborators', [AdminController::class, 'collaborators'])->name('collaborators.index');
    #Route::get('/collaborators/details', [AdminCollaboratorController::class, 'collaborators_details'])->name('collaborators.details');
    Route::resource('/collaborators', AdminCollaboratorController::class)->only(
        ['index','create','store','show','edit','destroy']
    );
    Route::put('collaborators/update', [AdminCollaboratorController::class, 'updateCollaborator'])->name('admin.collaborators.update');
    Route::post('/collaborators/status/{id}', [AdminCollaboratorController::class, 'changeCollaboratorStatus'])->name('admin.collaborators.status');
    //------------Collaborator management end here---  collaborators_details -----//

    //------------Orders management start here--------//
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::resource('/orders', AdminOrderController::class)->only(
        ['create','store','show','edit','destroy']
    );
    Route::put('/orders/{id}/update', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::get('/orders/details/{id}', [AdminOrderController::class, 'getOrderDetails'])->name('admin.order.details');
    //------------Orders management end here--------//

    //------------Course management start here--------//
    Route::get('/courses', [AdminCourseController::class, 'index'])->name('admin.courses');
    Route::resource('/courses', AdminCourseController::class)->only(
        ['create','store','show','edit','destroy']
    );
    Route::put('/courses/{id}/update', [AdminCourseController::class, 'update'])->name('admin.courses.update');
    Route::delete('/courses/{id}/delete', [AdminCourseController::class, 'destroy'])->name('admin.courses.delete');
    Route::post('/courses/remove-image', [AdminCourseController::class, 'removeImage'])->name('admin.courses.removeImage');
    Route::post('/courses/{id}/status', [AdminCourseController::class, 'updateStatus'])->name('admin.courses.status');
    //------------Course management end here--------//

    //------------Membership management start here--------//
    Route::get('manage-membership', [ManageMembershipController::class, 'index'])->name('admin.manage-membership');
    Route::get('manage-membership/create', [ManageMembershipController::class, 'create'])->name('admin.manage-membership.create');
    Route::post('manage-membership/store', [ManageMembershipController::class, 'store'])->name('admin.manage-membership.store');
    Route::get('manage-membership/edit/{id}', [ManageMembershipController::class, 'edit'])->name('admin.manage-membership.edit');
    Route::put('manage-membership/{id}/update', [ManageMembershipController::class, 'update'])->name('admin.manage-membership.update');
    Route::any('manage-membership/delete/{id}', [ManageMembershipController::class, 'destroy'])->name('admin.manage-membership.destroy');
    Route::any('manage-membership/make-popular', [ManageMembershipController::class, 'makePopular'])->name('admin.manage-membership.makepopular');
    Route::post('/manage-membership/{id}/status', [ManageMembershipController::class, 'updateStatus'])->name('admin.manage-membership.status');
    Route::resource('/manage-membership', ManageMembershipController::class)->only(
        ['create','store','show','edit','destroy']
    );
    //------------Membership management end here--------//

    //------------Settings management start here--------//
    Route::get('settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('settings', [SettingsController::class, 'store'])->name('admin.settings.store');
    Route::put('settings', [SettingsController::class, 'updateGeneralSetting'])->name('admin.settings.updategeneralsettings');
    //------------Settings management end here--------//

    //------------Web Settings management start here--------//
    //Route::get('/web/settings', [WebSettingsController::class, 'websettings'])->name('admin.web.settings');
    // Route::get('/web/settings', [WebSettingsController::class, 'editSettings'])->name('admin.web.settings.edit');
    //Route::post('web/settings/update', [WebSettingsController::class, 'updateSettings'])->name('admin.web.settings.update');
    Route::put('web/settings', [WebSettingsController::class, 'updateWebSettings'])->name('admin.web.settings.update');
    //------------Web Settings management end here--------//

    //------------Content management start here--------//
    Route::get('/content/management', [ContentManagementController::class, 'index'])->name('admin.content.management');
    Route::post('/content/management', [ContentManagementController::class, 'store'])->name('admin.content.management.store');
    Route::put('/content/management', [ContentManagementController::class, 'updateSiteSettings'])->name('admin.content.management.updateSiteSettings');

    //Vital Boost page sections
    Route::get('/content/vital-boost', [VitalBoostContentController::class, 'index'])->name('admin.content.vital-boost');
    Route::put('/content/vital-boost', [VitalBoostContentController::class, 'update'])->name('admin.content.vital-boost.update');

    //Section-based pages (about, collaborators, intro_videos, shop, contact, faq, help_center, testimonials)
    Route::get('/content/pages/{page}', [PageContentController::class, 'index'])->name('admin.content.page');
    Route::put('/content/pages/{page}', [PageContentController::class, 'update'])->name('admin.content.page.update');
    //------------Content management end here--------//

    //------------Zoom Session management start here--------//
    Route::get('/zoom-sessions', [ZoomSessionController::class, 'index'])->name('admin.zoom-sessions');
    Route::resource('/zoom-sessions', ZoomSessionController::class)->only(
        ['create','store','show','edit','destroy']
    );
    Route::post('/zoom-sessions/{id}/status', [ZoomSessionController::class, 'updateStatus'])->name('admin.zoom-sessions.status');
    //Route::put('zoom-sessions/update', [ZoomSessionController::class, 'updateZoomSession'])->name('admin.zoom-sessions.update');
    Route::put('/zoom-sessions/{id}/update', [ZoomSessionController::class, 'update'])->name('admin.zoom-sessions.update');
    Route::post('save-recording-session', [ZoomSessionController::class, 'saveRecording'])->name('admin.zoom-sessions.save-recording');
    Route::delete('delete-recording-session/{id}', [ZoomSessionController::class, 'deleteRecording'])->name('admin.zoom-sessions.delete-recording');
    //------------Zoom Session management end here--------//



    // Yahan aur admin routes add kar sakte ho
    // Route::get('users', [DashboardController::class, 'users'])->name('admin.users');

    //------------Location management start here--------//
    Route::resource('/locations', LocationController::class)->only(
        ['create','store','show','edit','update','destroy']
    );
    Route::get('/locations', [LocationController::class, 'index'])->name('admin.locations');
    Route::put('/locations/{id}/update', [LocationController::class, 'update'])->name('admin.locations.update');
    Route::post('/locations/{id}/status', [LocationController::class, 'updateStatus'])->name('admin.locations.status');
    //------------User management end here--------//

    //------------Testimonial management start here--------//
    Route::resource('/testimonials', AdminTestimonialController::class)->only(
        ['create','store','show','edit','update','destroy']
    );
    Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('admin.testimonials');
    Route::put('/testimonials/{id}/update', [AdminTestimonialController::class, 'update'])->name('admin.testimonials.update');
    Route::post('/testimonials/{id}/status', [AdminTestimonialController::class, 'updateStatus'])->name('admin.testimonials.status');
    //------------Testimonial management end here--------//

    //------------Video Testimonial management start here--------//
    Route::resource('/video-testimonials', AdminVideoTestimonialController::class)->only(
        ['create','store','show','edit','update','destroy']
    )->names([
        'store' => 'admin.video-testimonials.store',
        'create' => 'admin.video-testimonials.create',
        'show' => 'admin.video-testimonials.show',
        'edit' => 'admin.video-testimonials.edit',
        'update' => 'admin.video-testimonials.update',
        'destroy' => 'admin.video-testimonials.destroy'
    ]);
    Route::get('/video-testimonials', [AdminVideoTestimonialController::class, 'index'])->name('admin.video-testimonials');
    Route::put('/video-testimonials/{id}/update', [AdminVideoTestimonialController::class, 'update'])->name('admin.video-testimonials.update');
    Route::post('/video-testimonials/{id}/status', [AdminVideoTestimonialController::class, 'updateStatus'])->name('admin.video-testimonials.status');
    //------------Video Testimonial management end here--------//

    //------------FAQ Categories management start here--------//
    Route::resource('/faq-categories', AdminFaqCategoryController::class)->only(
        ['create','store','show','edit','update','destroy']
    );
    Route::get('/faq-categories', [AdminFaqCategoryController::class, 'index'])->name('admin.faq-categories');
    Route::put('/faq-category/update', [AdminFaqCategoryController::class, 'updateFAQCategory'])->name('admin.faq-categories.update');
    //------------FAQ Categories management end here--------//

    //------------FAQs management start here--------//
    Route::resource('/faqs', AdminFaqController::class)->only(
        ['create','store','show','edit','update','destroy']
    );
    Route::get('/faqs', [AdminFaqController::class, 'index'])->name('admin.faqs');
    Route::put('/faqs/{id}/update', [AdminFaqController::class, 'update'])->name('admin.faqs.update');
    Route::post('/faqs/{id}/status', [AdminFaqController::class, 'updateStatus'])->name('admin.faqs.status');
    //------------FAQs management end here--------//

    //------------Help Categories management start here--------//
    Route::resource('/help-categories', AdminHelpCategoryController::class)->only(
        ['create','store','show','edit','update','destroy']
    );
    Route::get('/help-categories', [AdminHelpCategoryController::class, 'index'])->name('admin.help-categories');
    Route::put('/help-categories/{id}/update', [AdminHelpCategoryController::class, 'update'])->name('admin.help-categories.update');
    Route::post('/help-categories/{id}/status', [AdminHelpCategoryController::class, 'updateStatus'])->name('admin.help-categories.status');
    //------------Help Categories management end here--------//

    //------------Help Article management start here--------//
    Route::resource('/help-articles', AdminHelpArticleController::class)->only(
        ['create','store','show','edit','update','destroy']
    );
    Route::get('/help-articles', [AdminHelpArticleController::class, 'index'])->name('admin.help-articles');
    Route::put('/help-articles/{id}/update', [AdminHelpArticleController::class, 'update'])->name('admin.help-articles.update');
    Route::post('/help-articles/{id}/status', [AdminHelpArticleController::class, 'updateStatus'])->name('admin.help-articles.status');
    //------------Help Article management end here--------//

    //------------Intro Videos management start here--------//
    Route::resource('/intro-videos', AdminIntroVideosController::class)->only(
        ['create','store','show','edit','update','destroy']
    );
    Route::get('/intro-videos', [AdminIntroVideosController::class, 'index'])->name('admin.intro-videos');
    Route::put('/intro-videos/{id}/update', [AdminIntroVideosController::class, 'update'])->name('admin.intro-videos.update');
    Route::post('/intro-videos/{id}/status', [AdminIntroVideosController::class, 'updateStatus'])->name('admin.intro-videos.status');
    //------------Intro Videos management end here--------//

    //------------Subscribers management start here--------//
    Route::resource('/subscribers', AdminSubscriberController::class)->only(
        ['create','store','show','edit','update','destroy']
    );
    Route::get('/subscribers', [AdminSubscriberController::class, 'index'])->name('admin.subscribers');
    //------------Subscribers management end here--------//

    //------------Email Management start here--------//
    Route::get('/email', [EmailManagementController::class, 'index'])->name('admin.email.index');
    Route::get('/email/templates', [EmailManagementController::class, 'templates'])->name('admin.email.templates');
    Route::get('/email/compose', [EmailManagementController::class, 'compose'])->name('admin.email.compose');
    Route::get('/email/logs', [EmailManagementController::class, 'logs'])->name('admin.email.logs');
    Route::get('/email/logs/details/{id}', [EmailManagementController::class, 'getEmailDetails'])->name('admin.email.logs.details');
    Route::post('/email/send', [EmailManagementController::class, 'sendEmail'])->name('admin.email.send');
    Route::post('/email/resend', [EmailManagementController::class, 'resendEmail'])->name('admin.email.resend');
    Route::post('/email/toggle', [EmailManagementController::class, 'toggleEmail'])->name('admin.email.toggle');
    Route::get('/email/users', [EmailManagementController::class, 'getUsers'])->name('admin.email.users');
    Route::get('/email/collaborators', [EmailManagementController::class, 'getCollaborators'])->name('admin.email.collaborators');
    Route::get('/email/members', [EmailManagementController::class, 'getMembers'])->name('admin.email.members');
    Route::get('/email/all-users', [EmailManagementController::class, 'getAllUser'])->name('admin.email.all-users');
    Route::get('/email/preview', [EmailManagementController::class, 'previewEmail'])->name('admin.email.preview');
    Route::get('/email/edit', [EmailManagementController::class, 'editEmail'])->name('admin.email.edit');
    Route::post('/email/update', [EmailManagementController::class, 'updateEmailTemplate'])->name('admin.email.update');
    //------------Email Management end here--------//

    //------------Admin Business Details start here--------//
    Route::get('/business-details', [AdminController::class, 'businessDetails'])->name('admin.business-details');
    Route::post('/business-details', [AdminController::class, 'storeBusinessDetails'])->name('admin.business-details.store');
    //------------Admin Business Details end here--------//

    Route::post('/intro-videos/{id}/status', [AdminIntroVideosController::class, 'updateStatus'])->name('admin.intro-videos.status');
    //------------Intro Videos management end here--------//


});
//------------Admin routes end here--------//

//------------Collaborator routes start here--------//
Route::get('/collaborator', [CollaboratorController::class, 'index']);
Route::post('/collaborator/login', [CollaboratorController::class, 'collaboratorLogin'])->middleware('throttle:5,1')->name('collaborator.login');
Route::prefix('collaborator')->middleware([RoleMiddleware::class.':collaborator'])->group(function ()
{
    Route::get('dashboard', [CollaboratorController::class, 'dashboard'])->name('collaborator.dashboard');
    Route::get('/profile', [CollaboratorController::class, 'createProfile'])->name('profile.show');
    Route::put('/profile/update', [CollaboratorController::class, 'updateProfile'])->name('collaborator.profile.update');
    Route::get('/business-details', [CollaboratorController::class, 'businessDetails'])->name('collaborator.business-details');
    Route::post('/business-details', [CollaboratorController::class, 'storeBusinessDetails'])->name('collaborator.business-details.store');
    Route::get('/bank-details', [CollaboratorController::class, 'bankDetails'])->name('collaborator.bank-details');
    Route::post('/bank-details', [CollaboratorController::class, 'storeBankDetails'])->name('collaborator.bank-details.store');

    //product routes for collaborator
    /*Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.delete');*/

    //------------Product management start here--------//
    Route::resource('/products', CollaboratorProductController::class)->only(
        ['create','store','show','edit','update','destroy']
    );
    Route::post('/products/{id}/status', [CollaboratorProductController::class, 'updateStatus'])->name('collaborator.products.status');
    Route::get('/products', [CollaboratorProductController::class, 'index'])->name('collaborator.products');
    Route::put('/products/{id}/update', [CollaboratorProductController::class, 'update'])->name('collaborator.products.update');
    Route::delete('/products/{id}/delete', [CollaboratorProductController::class, 'destroy'])->name('collaborator.products.delete');
    Route::post('/products/remove-image', [CollaboratorProductController::class, 'removeImage'])->name('collaborator.products.removeImage');
    //------------Product management end here--------//

    //Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
    // Route::get('/courses/create', [CoursesController::class, 'create'])->name('courses.create');
    // Route::post('/courses/store', [CoursesController::class, 'store'])->name('courses.store');
    // Route::get('/courses/{id}/edit', [CoursesController::class, 'edit'])->name('courses.edit');
    // Route::put('/courses/{course}', [CoursesController::class, 'update'])->name('courses.update');
    // Route::delete('/courses/{course}', [CoursesController::class, 'destroy'])->name('courses.destroy');
    
    //------------Course management start here--------//
    Route::get('/courses', [CollaboratorCourseController::class, 'index'])->name('collaborator.courses');
    Route::resource('/courses', CollaboratorCourseController::class)->only(
        ['create','store','show','edit','destroy']
    );
    Route::put('/courses/{id}/update', [CollaboratorCourseController::class, 'update'])->name('collaborator.courses.update');
    Route::delete('/courses/{id}/delete', [CollaboratorCourseController::class, 'destroy'])->name('collaborator.courses.delete');
    Route::post('/courses/remove-image', [CollaboratorCourseController::class, 'removeImage'])->name('collaborator.courses.removeImage');
    Route::post('/courses/{id}/status', [CollaboratorCourseController::class, 'updateStatus'])->name('collaborator.courses.status');
    //------------Course management end here--------//

    Route::get('/orders', [CollaboratorController::class, 'orders'])->name('collaborator.orders');
    // Sub-order (split shipping) routes — declared before /orders/{id} to keep them explicit
    Route::get('/orders/sub/{id}', [CollaboratorController::class, 'subOrderDetails'])->name('collaborator.sub-order-details');
    Route::put('/orders/sub/{id}/update', [CollaboratorController::class, 'updateSubOrder'])->name('collaborator.sub-orders.update');
    Route::post('/orders/sub/{id}/generate-label', [CollaboratorController::class, 'generateShippingLabel'])->name('collaborator.generate-label');
    Route::get('/orders/sub/{id}/download-label', [CollaboratorController::class, 'downloadLabel'])->name('collaborator.download-label');
    Route::get('/orders/{id}', [CollaboratorController::class, 'orderDetails'])->name('collaborator.order-details');
    Route::put('/orders/{id}/update', [CollaboratorController::class, 'updateOrder'])->name('collaborator.orders.update');
});
//------------Collaborator routes end here--------//

//Public Routes
Route::get('/', [IndexController::class, 'index'] );
Route::get('/about-dr-zeines',[AboutController::class, 'aboutZeines'] )->name('about-dr-zeines');
Route::get('/collaborators',[AboutController::class, 'collaborators'] )->name('collaborators');
Route::get('collaborator/{id}', [AboutController::class, 'collaboratorDetails'])->name('collaborator.details');
Route::get('collaborator/store/{id}', [AboutController::class, 'store'])->name('collaborator.store');
Route::get('/intro-videos',[IndexController::class, 'introVideos'] )->name('intro-videos');
Route::get('/membership',[IndexController::class, 'membership'] )->name('membership');
Route::post('/membership/store', [UserRegister::class, 'store']);
Route::get('/auth', [LoginController::class, 'showLoginForm'])->name('auth');
Route::post('/auth', [LoginController::class, 'signUp'])->name('auth.signup');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1')->name('login');
Route::get('/contact', [ContactController::class, 'index'] )->name('contact');
Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::post('/newsletter/subscribe', [ContactController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/testimonials', [TestimonialsController::class, 'index'] )->name('testimonials');
Route::get('/faq', [FAQController::class, 'index'] )->name('faq.index');
Route::get('/help-center', [HelpCenterController::class, 'helpcenter'] )->name('help-center');
Route::get('/shop', [ShopController::class, 'index'] )->name('shop');
Route::get('/products/{slug}', [ShopController::class, 'productDetails'] )->name('product-details');
Route::get('/products/filter', [ShopController::class, 'filter'])->name('products.filter');
Route::get('/vital-boost', [VitalBoostController::class, 'index'] )->name('vital-boost');
Route::get('/success', [IndexController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/cancel', [IndexController::class, 'paymentCancel'])->name('payment.cancel');
Route::get('/terms-and-conditions', [IndexController::class, 'terms'])->name('terms-and-conditions');
Route::get('/privacy-policy', [IndexController::class, 'privacy'])->name('privacy-policy');

//Collaborator routes
Route::get('/become-collaborator', [CollaboratorController::class, 'becomeCollaborator'])->name('become-collaborator');
Route::post('/become-collaborator', [CollaboratorController::class, 'store'])->name('become.collaborator.store');
Route::get('/collaborator/profile-details', [CollaboratorController::class, 'profile'])->name('collaborator.profile-details');

//cart routes
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/addtocart', [CartController::class, 'addToCart'])->name('cart.addtocart');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

// Stripe webhook — outside auth middleware, CSRF exempted in bootstrap/app.php
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

//checkout routes
Route::get('/checkout/shipping', [CheckoutController::class, 'shipping'])->name('checkout.shipping');
Route::post('/checkout/shipping', [CheckoutController::class, 'shippingStore'])->name('checkout.shipping.store');
Route::get('/checkout/delivery', [CheckoutController::class, 'delivery'])->name('checkout.delivery');
Route::post('/checkout/delivery', [CheckoutController::class, 'deliveryStore'])->name('checkout.delivery.store');
Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/checkout/payment', [CheckoutController::class, 'paymentStore'])->name('checkout.payment.store');
Route::get('/checkout/review', [CheckoutController::class, 'review'])->name('checkout.review');
Route::post('/checkout/order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.payment.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.payment.cancel');

//------------Member routes start here--------//
Route::prefix('member')->middleware([RoleMiddleware::class.':user'])->group(function () {
//Route::prefix('member')->group(function () {
    Route::get('/dashboard', [MemberController::class, 'member_dashboard'])->name('member.dashboard');
    Route::get('/profile', [MemberController::class, 'member_profile'])->name('member.profile');
    Route::get('/security', [MemberController::class, 'member_security'])->name('member.security');
    Route::get('/subscription', [MemberController::class, 'member_subscription'])->name('member.subscription');
    Route::get('/vital-boost-subscriptions', [MemberController::class, 'member_vitalBoostSubscriptions'])->name('member.vital-boost-subscriptions');
    Route::get('/orders', [MemberController::class, 'member_orders'])->name('member.orders');
    Route::get('/orders/{id}', [MemberController::class, 'member_order_details'])->name('member.order-details');
    Route::get('/plans', [MemberController::class, 'member_plans'])->name('member.plans');
    Route::get('/payments', [MemberController::class, 'member_payments'])->name('member.payments');
    Route::get('/video-library/{activeTab?}', [MemberController::class, 'member_videoLibrary'])->name('member.video-library');
    Route::get('/video-library/collaborator/{id}', [MemberController::class, 'collaboratorVideos'])->name('member.video-library.collaborator');
    Route::get('/store', [MemberController::class, 'member_store'])->name('member.store');
    Route::get('/download/{id}', [MemberController::class, 'download'])->name('member.download');
    Route::get('/download-receipt/{transactionId}', [MemberController::class, 'downloadReceipt'])->name('member.download-receipt');
    Route::post('/saveProfile', [MemberController::class, 'saveProfile'])->name('member.saveProfile');
    Route::post('/update-password', [MemberController::class, 'updatePassword'])->name('member.updatepassword');
    Route::post('/upgrade-membership', [MemberController::class, 'upgradeMembership'])->name('member.upgrade-membership');
    Route::post('/renew-membership', [MemberController::class, 'renewMembership'])->name('member.renew-membership');
    Route::post('/delete-payment-method', [MemberController::class, 'deletePaymentMethod'])->name('member.delete-payment-method');
    Route::post('/set-default-payment-method', [MemberController::class, 'setDefaultPaymentMethod'])->name('member.set-default-payment-method');
    Route::post('/add-payment-method', [MemberController::class, 'addPaymentMethod'])->name('member.add-payment-method');
    Route::post('/confirm-payment-method', [MemberController::class, 'confirmPaymentMethod'])->name('member.confirm-payment-method');
});
//------------Member routes end here--------//

Route::fallback(function () {
    abort(404);
});