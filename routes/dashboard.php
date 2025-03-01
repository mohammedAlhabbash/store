<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashbooardController;
use App\Http\Controllers\Dashboard\StoreController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProfileController;

Route::get('/dashboard', [DashbooardController::class, 'index'])
    ->middleware(['auth', 'verified','auth.type'])->name('dashboard');
//
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('categories/trashed', [CategoryController::class, 'showTrashed'])->name('category.trashed');
    Route::put('categories/{slug}/restore', [CategoryController::class, 'restore'])->name('category.restore');
    Route::delete('categories/{slug}/force-delete', [CategoryController::class, 'forceDelete'])->name('category.forceDelete');
    // Route::get('categories/{slug}/show',[]);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('stores', StoreController::class);
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
// Route::get('dashboard/categories', [CategoryController::class, 'index'])->name('categories.index');
// Route::get('dashboard/categories/create', [CategoryController::class, 'create'])->name('categories.create');
// Route::get('/dashboard/{slug}/categories', [CategoryController::class, 'edit'])->name('categories.edit');
// Route::delete('dashboard/categories/{slug}', [CategoryController::class, 'destroy'])->name('categories.destroy');
