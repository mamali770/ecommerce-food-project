<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::prefix('/sliders')->group(function () {
    Route::get('/', [SliderController::class , 'index'])->name('slider.index');
    Route::get('/create', [SliderController::class , 'create'])->name('slider.create');
    Route::post('/store', [SliderController::class , 'store'])->name('slider.store');
    Route::get('/{slider}/update', [SliderController::class , 'update'])->name('slider.update');
    Route::put('/{slider}', [SliderController::class , 'edit'])->name('slider.edit');
    Route::delete('/{slider}', [SliderController::class , 'destroy'])->name('slider.destroy');
});

Route::prefix('/features')->group(function () {
    Route::get('/', [FeaturesController::class , 'index'])->name('feature.index');
    Route::get('/create', [FeaturesController::class , 'create'])->name('feature.create');
    Route::post('/store', [FeaturesController::class , 'store'])->name('feature.store');
    Route::get('/{feature}/update', [FeaturesController::class , 'update'])->name('feature.update');
    Route::put('/{feature}', [FeaturesController::class , 'edit'])->name('feature.edit');
    Route::delete('/{feature}', [FeaturesController::class , 'destroy'])->name('feature.destroy');
});

Route::prefix('/about-us')->group(function () {
    Route::get('/', [AboutUsController::class , 'index'])->name('about.index');
    Route::get('/{item}/update', [AboutUsController::class , 'update'])->name('about.update');
    Route::put('/{item}', [AboutUsController::class , 'edit'])->name('about.edit');
});