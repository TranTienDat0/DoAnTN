<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::controller(auth\LoginController::class)->group(function () {
        //login
        Route::get('/view_login', 'viewLogin')->name('view-login');
        Route::post('/login', 'login')->name('login');
        //logout
        Route::post('logout', 'logout')->name('logout');
    });
    route::controller(auth\ChangePassword::class)->group(function () {
        //change password
        Route::get('/view_change_password', 'viewChangePassword')->name('view-change-password')->middleware('checkLogin');
        Route::post('/change_password', 'changePassword')->name('change-password');
    });
    route::controller(auth\ForgotPasswordController::class)->group(function () {
        Route::get('/forgot-password', 'ViewForgotPasswordForm')->name('password.request');
        Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
    });
    route::controller(auth\ResetPasswordController::class)->group(function () {
        Route::get('/reset-password/{token}', 'ViewResetPasswordForm')->name('password.reset');
        Route::post('/reset-password', 'reset')->name('password.update');
    });
});

Route::prefix('admin')->group(function () {
    route::controller(HomeAdminController::class)->middleware('checkLogin')->group(function (){
        route::get('/home', 'index')->name('home');
        route::get('/admin-profile', 'profile')->name('admin.profile');
        route::put('/admin-profile/{id}', 'updateProfile')->name('admin.update.profile');
    });
    route::controller(UserController::class)->middleware('checkLogin')->group(function (){
        Route::get('/user', 'index')->name('users');
        Route::get('/user-create', 'create')->name('users.create');
        route::post('/user-store', 'store')->name('users.store');
        Route::get('/user-edit/{id}', 'edit')->name('users.edit');
        route::put('/user-update/{id}', 'update')->name('users.update');
        route::delete('/user-delete/{id}', 'delete')->name('users.delete');
    });
    route::controller(BannerController::class)->middleware('checkLogin')->group(function (){
        route::get('/banner', 'index')->name('banner');
        Route::get('/banner-create', 'create')->name('banner.create');
        route::post('/banner-store', 'store')->name('banner.store');
        Route::get('/banner-edit/{id}', 'edit')->name('banner.edit');
        route::put('/banner-update/{id}', 'update')->name('banner.update');
        route::delete('/banner-delete/{id}', 'delete')->name('banner.delete');
    });
    route::controller(CategoryController::class)->middleware('checkLogin')->group(function (){
        route::get('/category', 'index')->name('category');
        Route::get('/category-create', 'create')->name('category.create');
        route::post('/category-store', 'store')->name('category.store');
        Route::get('/category-edit/{id}', 'edit')->name('category.edit');
        route::put('/category-update/{id}', 'update')->name('category.update');
        route::delete('/category-delete/{id}', 'delete')->name('category.delete');
    });
});
