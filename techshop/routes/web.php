<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\ProviderController;
use Illuminate\Support\Facades\Route;

// Homepage - accessible by everyone
Route::get('/', [HomeController::class, 'index'])->name('home');

// Social Login Routes
Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect'])
    ->name('social.redirect');
    
Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback'])
    ->name('social.callback');

// Customer Dashboard (after login)
Route::get('/dashboard', function () {
    // Redirect admin to admin dashboard
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    // Customer sees homepage
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Inventory Management (Quản lý kho)
    Route::resource('inventory', InventoryController::class);
    Route::get('inventory/attributes/{category_id}', [InventoryController::class, 'getAttributesByCategory'])
        ->name('inventory.attributes');
    
    // Category Management (Quản lý danh mục)
    Route::resource('categories', CategoryController::class);
    Route::post('categories/update-order', [CategoryController::class, 'updateOrder'])
        ->name('categories.update-order');
    
    // Product Management (Quản lý sản phẩm)
    Route::resource('products', ProductController::class);
    Route::post('products/{id}/publish', [ProductController::class, 'publish'])
        ->name('products.publish');
    Route::post('products/{id}/unpublish', [ProductController::class, 'unpublish'])
        ->name('products.unpublish');
});

require __DIR__.'/auth.php';
