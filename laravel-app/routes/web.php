<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
})->name('home.index');

Route::get('/about', function () {
    return view('about.index');
})->name('about.index');

Route::group(['prefix' => 'contact-us'], function () {
    Route::get('/', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/', [ContactController::class, 'store'])->name('contact.store');
});

Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products', [ProductController::class, 'index'])->name('product.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/check-otp', [AuthController::class, 'checkOtp'])->name('auth.checkOtp');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('auth.resendOtp');
});

Route::get('/logout', [ProfileController::class, 'logout'])->name('auth.logout')->middleware('auth');

Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/{user}', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/addresses', [ProfileController::class, 'address'])->name('profile.address');
    Route::get('/addresses/create', [ProfileController::class, 'addressCreate'])->name('profile.address.create');
    Route::post('/addresses', [ProfileController::class, 'addressStore'])->name('profile.address.store');
    Route::get('/addresses/{address}/edit', [ProfileController::class, 'addressEdit'])->name('profile.address.edit');
    Route::put('/addresses/{address}', [ProfileController::class, 'addressUpdate'])->name('profile.address.update');

    Route::get('/wishlist', [ProfileController::class, 'wishlist'])->name('profile.wishlist');
    Route::get('/remoreWishlist', [ProfileController::class, 'removeWishlist'])->name('profile.wishlist.remove');

    Route::get('/order', [ProfileController::class, 'order'])->name('profile.order');

    Route::get('/transaction', [ProfileController::class, 'transaction'])->name('profile.transaction');
});

Route::get('/profile/add-to-wishlist', [ProfileController::class, 'addWishlist'])->name('wishlist.add');

Route::middleware('auth')->prefix('card')->group(function () {
    Route::get('/', [CardController::class, 'card'])->name('card.index');
    Route::get('/increment', [CardController::class, 'increment'])->name('card.increment');
    Route::get('/decrement', [CardController::class, 'decrement'])->name('card.decrement');
    Route::get('/add', [CardController::class, 'add'])->name('card.add');
    Route::get('/remove', [CardController::class, 'remove'])->name('card.remove');
    Route::get('/clear', [CardController::class, 'clear'])->name('card.clear');
    Route::get('/check-coupon', [CardController::class, 'checkCoupon'])->name('card.checkCoupon');

    Route::get('/remove-coupon', [CardController::class, 'removeCoupon'])->name('coupon.remove');
});

Route::middleware('auth')->prefix('payment')->group(function () {
    Route::post('/send', [PaymentController::class, 'send'])->name('payment.send');
    Route::get('/verify', [PaymentController::class, 'verify'])->name('payment.verify');
});