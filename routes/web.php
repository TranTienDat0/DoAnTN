<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\HomeAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductReviewController;
use App\Models\ProductReview;
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
    route::controller(SubCategoryController::class)->middleware('checkLogin')->group(function (){
        route::get('/subcategory', 'index')->name('subcategory');
        Route::get('/subcategory-create', 'create')->name('subcategory.create');
        route::post('/subcategory-store', 'store')->name('subcategory.store');
        Route::get('/subcategory-edit/{id}', 'edit')->name('subcategory.edit');
        route::put('/subcategory-update/{id}', 'update')->name('subcategory.update');
        route::delete('/subcategory-delete/{id}', 'delete')->name('subcategory.delete');
    });
    route::controller(ProductsController::class)->middleware('checkLogin')->group(function (){
        route::get('/products', 'index')->name('products');
        Route::get('/products-create', 'create')->name('products.create');
        route::post('/products-store', 'store')->name('products.store');
        Route::get('/products-edit/{id}', 'edit')->name('products.edit');
        route::put('/products-update/{id}', 'update')->name('products.update');
        route::delete('/products-delete/{id}', 'delete')->name('products.delete');
    });
    route::controller(BlogController::class)->middleware('checkLogin')->group(function (){
        route::get('/blog', 'index')->name('blog');
        Route::get('/blog-create', 'create')->name('blog.create');
        route::post('/blog-store', 'store')->name('blog.store');
        Route::get('/blog-edit/{id}', 'edit')->name('blog.edit');
        route::put('/blog-update/{id}', 'update')->name('blog.update');
        route::delete('/blog-delete/{id}', 'delete')->name('blog.delete');
    });
    route::controller(OrderController::class)->middleware('checkLogin')->group(function (){
        route::get('/order-show/{id}', 'show')->name('order.show');
        route::get('order/pdf/{id}','pdf')->name('order.pdf');
    });
});

Route::prefix('user')->group(function (){
    route::controller(FrontendController::class)->group(function (){
        route::get('user-view_login', 'viewLogin')->name('user.view-login');
        route::post('user-login', 'login')->name('user.login');
        route::get('user-logout', 'logout')->name('user.logout');
        route::get('register', 'register')->name('register.form');

        route::get('view_home', 'index')->name('home-user');
        route::get('/product_list', 'productList')->name('product-lists');
        route::get('/product_grids', 'productGrid')->name('product-grids');
        route::get('/product_category/{id}', 'productCate')->name('product-category');
        route::get('/product_sub_category/{id}', 'productSubCate')->name('product-sub-category');
        route::get('/product_detail/{id}', 'productDetail')->name('product-detail');
        Route::match(['get','post'],'/filter','productFilter')->name('shop.filter');
        Route::post('/product/search','productSearch')->name('product.search');
        route::get('/user-order', 'orderIndex')->name('user.order');
        
    });

    route::controller(cartController::class)->group(function (){
        route::get('cart', 'index')->name('cart');
        route::get('/add-to-cart/{id}','addToCart')->name('add-to-cart');
        Route::post('cart-update','cartUpdate')->name('cart.update');
        Route::get('/cart-delete/{id}','cartdelete')->name('cart.delete');
        route::get('checkout', 'checkout')->name('checkout');
    });

    route::controller(OrderController::class)->group(function (){
        route::get('order', 'index')->name('order.index');
        Route::post('cart/order','store')->name('cart.order');
        route::put('/order-update/{id}', 'update')->name('order.edit');
    });

    route::controller(ProductReviewController::class)->group(function (){
        Route::post('product/{id}/review','store')->name('review.store');
    });
});
