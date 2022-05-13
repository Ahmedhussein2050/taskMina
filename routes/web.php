<?php

use App\Modules\portal\Controllers\AuthController;
use App\Modules\portal\Controllers\BrandsController;
use App\Modules\portal\Controllers\CartController;
use App\Modules\portal\Controllers\CategoryController;
use App\Modules\portal\Controllers\FavoriteController;
use App\Modules\portal\Controllers\HomeController;
use App\Modules\portal\Controllers\OrdersController;
use App\Modules\portal\Controllers\ProductsController;
use App\Modules\portal\Controllers\UserBalanceController;
use App\Modules\portal\Controllers\UserController;
use App\Notifications\FavouriteProduct;
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

/*-----------------  site routes -----------------*/

Route::group(['middleware' => 'setLocale'], function () {

    Route::get('/',   [HomeController::class, 'index'])->name('home');
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('home_login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register.index');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('register', [AuthController::class, 'register'])->name('promotor.register');
    Route::get('auth/googleMail', [AuthController::class, 'authRedirect'])->name('google.redirect');
    Route::get('auth/google/callbackGoogle', [AuthController::class, 'authCallback'])->name('google.Callback');

    Route::get('password/forgot', [AuthController::class, 'showForgotForm'])->name('password.forgot');
    Route::post('password/forgot', [AuthController::class, 'forgot'])->name('forgot');

    Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('reset.password.token');
    Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('reset');

    Route::get('brand/{id}', [BrandsController::class, 'brand'])->name('brand');
    Route::post('brand/{id}', [BrandsController::class, 'brand']);
    Route::get('classification/{id}', [HomeController::class, 'classification'])->name('classification');
    Route::post('email/subscribe', [HomeController::class, 'subscribe'])->name('subscribe.store');
    Route::get('switch/lang/{code}', [HomeController::class, 'switchLang'])->name('switch.lang');
    Route::get('category/{id}', [CategoryController::class, 'category'])->name('category');
    Route::post('category/{id}', [CategoryController::class, 'category']);
    Route::any('search', [HomeController::class, 'search'])->name('search');
    Route::any('auto_search', [HomeController::class, 'auto_search'])->name('auto_search');

    Route::get('product/{product}', [ProductsController::class, 'show'])->name('home_product.show');
    Route::post('product/{product}/review', [ProductsController::class, 'sendReview'])->name('send_product_review');

    Route::any('search', [HomeController::class, 'search'])->name('search');
    Route::get('favorite/{product}/create', [FavoriteController::class, 'create'])->name('favorite.create');

    Route::middleware(['auth'])->group(function () {
        //user profile
        Route::get('myProfile', [UserController::class, 'index'])->name('user.profile');
        Route::get('myOrders', [UserController::class, 'orders'])->name('user.orders');
        Route::get('myBalance', [UserController::class, 'balance'])->name('user.balance');
        Route::get('myFavourite', [UserController::class, 'favourite'])->name('user.favourite');
        Route::post('updateUserInfo', [UserController::class, 'updateUser'])->name('edit.user.info');
        Route::get('notification/trash', [UserController::class, 'notificationTrash'])->name('notification.trash');
        Route::get('notification/read', [UserController::class, 'notificationRead'])->name('notification.read');
        Route::get('notification', [UserController::class, 'notificationshow'])->name('showNotification');

        Route::get('order/{id}', [UserController::class, 'orderDetails'])->name('order_details');

        Route::post('cart/single/add/{id}', [CartController::class, 'add'])
            ->name('cart.single.add');

        Route::get('cart', [CartController::class, 'index'])
            ->name('cart');

        Route::get('cart/increase/{id}', [CartController::class, 'increase'])
            ->name('cart.increase');

        Route::get('cart/decrease/{id}', [CartController::class, 'decrease'])
            ->name('cart.decrease');

        Route::get('cart/destroy/{id}', [CartController::class, 'destroy'])
            ->name('cart.destroy');

        Route::get('link-for-ajax-call/{id}', function ($id) {
            return App\Bll\Utility::cities($id);
        })->name('helper.cities');

        Route::get('order/{id}', [OrdersController::class, 'orderDetails'])->name('order_details');

        Route::post('order/confirm', [OrdersController::class, 'confirmOrder'])
            ->name('confirm.order');

        Route::get('orders/redirect', [OrdersController::class, 'orderRedirect'])
            ->name('orderRedirect');

        Route::post('order/return', [OrdersController::class, 'orderReturn'])
            ->name('order.return');

        Route::get('thankScreen', [OrdersController::class, 'thankScreen'])
            ->name('thankScrean');

        Route::get('get_available_shipping_methods', [CartController::class, 'get_available_shipping_methods'])
            ->name('get_available_shipping_methods');

        Route::post('balancePayment', [UserBalanceController::class, 'balancePayment'])
            ->name('balancePayment');

        Route::get('userbalance/redirect', [UserBalanceController::class, 'userRedirect'])
            ->name('userRedirect');
    });
    Route::get('/pages/{id}', [HomeController::class,'getPage'])->name('page.get');
    Route::get('/contact_us', [HomeController::class,'contact_us'])->name('contact_us.get');
    Route::post('/contact_uss', [HomeController::class,'contact_us_submit'])->name('contact_us.submit');



});
