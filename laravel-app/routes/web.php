<?php

use App\Http\Controllers\ContactUsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


Route::group(["prefix" => "/contact"], function () {
    Route::get('/', [ContactUsController::class, 'index'])->name('contact');
    Route::post('/', [ContactUsController::class, 'store'])->name('contact.store');
});
