<?php

use App\Http\Controllers\auth;
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
        Route::get('/view_change_password', 'viewChangePassword')->name('view-change-password');
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
    Route::get('/home', [App\Http\Controllers\HomeAdminController::class, 'index'])->name('home');
    route::controller(HomeAdminController::class)->group(function (){
        route::get('/home', 'index')->name('home');
    });
    route::controller(UserController::class)->group(function (){
        Route::get('/user', 'index')->name('users');
        Route::get('/user-create', 'create')->name('users.create');
        route::post('/user-store', 'store')->name('users.store');
        Route::get('/user-edit/{id}', 'edit')->name('users.edit');
        route::patch('/user-update', 'update')->name('users.update');
    });
});
