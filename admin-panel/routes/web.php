<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'sliders', 'middleware' => 'can:admin'], function () {

        Route::get('/', [SliderController::class, 'index'])->name('slider.index');
        Route::get('/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('/', [SliderController::class, 'store'])->name('slider.store');
        Route::get('/{slider}/edit', [SliderController::class, 'edit'])->name('slider.edit');
        Route::put('/{slider}', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');
    });

    Route::group(['prefix' => 'features', 'middleware' => 'can:admin'], function () {

        Route::get('/', [FeatureController::class, 'index'])->name('feature.index');
        Route::get('/create', [FeatureController::class, 'create'])->name('feature.create');
        Route::post('/', [FeatureController::class, 'store'])->name('feature.store');
        Route::get('/{feature}/edit', [FeatureController::class, 'edit'])->name('feature.edit');
        Route::put('/{feature}', [FeatureController::class, 'update'])->name('feature.update');
        Route::delete('/{feature}', [FeatureController::class, 'destroy'])->name('feature.destroy');
    });

    Route::group(['prefix' => 'about', 'middleware' => 'can:admin'], function () {

        Route::get('/', [AboutController::class, 'index'])->name('about.index');
        Route::get('/{about}/edit', [AboutController::class, 'edit'])->name('about.edit');
        Route::put('/{about}', [AboutController::class, 'update'])->name('about.update');
    });

    Route::group(['prefix' => 'contact', 'middleware' => 'can:admin'], function () {

        Route::get('/', [ContactController::class, 'index'])->name('contact.index');
        Route::get('/{item}/show', [ContactController::class, 'show'])->name('contact.show');
        Route::delete('/{item}', [ContactController::class, 'destroy'])->name('contact.destroy');
    });

    Route::group(['prefix' => 'footer', 'middleware' => 'can:admin'], function () {

        Route::get('/', [FooterController::class, 'index'])->name('footer.index');
        Route::get('/{footer}/edit', [FooterController::class, 'edit'])->name('footer.edit');
        Route::put('/{footer}', [FooterController::class, 'update'])->name('footer.update');
    });

    Route::group(['prefix' => 'category', 'middleware' => 'can:author'], function () {

        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/{categories}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/{categories}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/{categories}', [CategoryController::class, 'destroy'])->name('category.destroy');
    });

    Route::group(['prefix' => 'products', 'middleware' => 'can:author'], function () {

        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/', [ProductController::class, 'store'])->name('product.store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    });

    Route::group(['prefix' => 'coupon', 'middleware' => 'can:admin'], function () {

        Route::get('/', [CouponController::class, 'index'])->name('coupon.index');
        Route::get('/create', [CouponController::class, 'create'])->name('coupon.create');
        Route::post('/', [CouponController::class, 'store'])->name('coupon.store');
        Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('coupon.edit');
        Route::put('/{coupon}', [CouponController::class, 'update'])->name('coupon.update');
        Route::delete('/{coupon}', [CouponController::class, 'destroy'])->name('coupon.destroy');
    });

    Route::group(['prefix' => 'orders', 'middleware' => 'can:admin'], function () {

        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('orders.update');
    });

    Route::group(['prefix' => 'transactions', 'middleware' => 'can:financial'], function () {

        Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::put('/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    });

    Route::group(['prefix' => 'users', 'middleware' => 'can:admin'], function () {

        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
    });

    Route::group(['prefix' => 'roles', 'middleware' => 'can:admin'], function () {

        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/', [RoleController::class, 'store'])->name('role.store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('role.update');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.login.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
