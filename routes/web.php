<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect('/uz');
});

Route::group(['prefix' => '{locale}', 'middleware' => 'set.locale'], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Catalog
    Route::get('/catalog', [App\Http\Controllers\ProductController::class, 'index'])->name('catalog.index');
    Route::get('/category/{slug}', [App\Http\Controllers\ProductController::class, 'category'])->name('catalog.category');
    Route::get('/product/{slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

    // News
    Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{slug}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

    // About
    Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about');

    // Application
    Route::post('/application', [App\Http\Controllers\ApplicationController::class, 'store'])->name('application.store');
});
