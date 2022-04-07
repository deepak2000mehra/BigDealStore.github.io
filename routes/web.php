<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;

Route::get('/', function () {
    return view('welcome');
});

// User route
Route::view('home', 'home');
Route::view('product','product');
Route::middleware('auth')->group(function(){
    Route::get('/dashboard',function(){
        return view('dashboard');
    });
});

require __DIR__.'/auth.php';


// Admin route
Route::prefix('admin')->name('admin.')->group(function(){
    Route::namespace('Auth')->middleware('guest:admin')->group(function(){
        // login route
        Route::get('login',[AuthenticatedSessionController::class,'create'])->name('login');
        Route::post('login',[AuthenticatedSessionController::class,'store'])->name('adminlogin');
        
    });
    Route::middleware('admin')->group(function(){
        Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
        Route::resource('slider',SliderController::class);
        Route::resource('category',CategoryController::class);
        Route::resource('subcategory',SubCategoryController::class);
        Route::post('logout',[AuthenticatedSessionController::class,'destroy'])->name('logout');
    });
});
