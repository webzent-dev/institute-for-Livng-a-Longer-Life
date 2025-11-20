<?php

use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\FAQController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\TestimonialsController; 
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


Route::resource('index', IndexController::class);
Route::resource('about', AboutController::class);
Route::resource('testimonial', TestimonialsController::class);
Route::resource('faq', FAQController::class);

