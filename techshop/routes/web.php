<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\ProviderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicCategoryController;

// Homepage - accessible by everyone
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public product information page
Route::get('/product/{id}', [PublicProductController::class, 'productInformation'])->name('productInformation');

// Public product search (full results page)
Route::get('/products/search', [PublicProductController::class, 'search'])->name('products.search');

// Shopping Cart & Checkout Routes (require authentication and email verification)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/buy-now', [CartController::class, 'buyNow'])->name('buy-now');
        Route::patch('/{itemId}', [CartController::class, 'update'])->name('update');
        Route::delete('/{itemId}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'count'])->name('count');
    });

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::match(['get', 'post'], '/', [CheckoutController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/review', [CheckoutController::class, 'review'])->name('review');
        Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('place-order');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
    });

    // Order History Routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::post('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::post('/{id}/retry-payment', [OrderController::class, 'retryPayment'])->name('retry-payment');
    });
});

// Social Login Routes
Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect'])
    ->name('social.redirect');
    
Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback'])
    ->name('social.callback');

// VNPay Return URL (no auth required as VNPay will redirect here)
Route::get('/checkout/vnpay-return', [CheckoutController::class, 'vnpayReturn'])
    ->name('checkout.vnpay-return');

// Customer Dashboard (after login)
Route::get('/dashboard', function () {
    // Redirect admin to admin dashboard
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    // Customer sees homepage
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Inventory Management (Quản lý kho)
    Route::resource('inventory', InventoryController::class);
    Route::get('inventory/{id}/details', [InventoryController::class, 'getDetails'])
        ->name('inventory.details');
    Route::get('inventory/attributes/{category_id}', [InventoryController::class, 'getAttributesByCategory'])
        ->name('inventory.attributes');
    
    // Category Management (Quản lý danh mục)
    Route::resource('categories', CategoryController::class);
    Route::post('categories/update-order', [CategoryController::class, 'updateOrder'])
        ->name('categories.update-order');
    
    // Attribute Management (Quản lý thuộc tính)
    Route::resource('attributes', AttributeController::class);
    
    // Product Management (Quản lý sản phẩm)
    Route::resource('products', ProductController::class);
    Route::post('products/{id}/publish', [ProductController::class, 'publish'])
        ->name('products.publish');
    Route::post('products/{id}/unpublish', [ProductController::class, 'unpublish'])
        ->name('products.unpublish');

    // Advertisment Management (Quản lý quảng cáo)
    Route::resource('advertisments', App\Http\Controllers\Admin\AdvertismentController::class)->except(['show']);

    // Order Management (Quản lý đơn hàng)
    Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders/check-new', [App\Http\Controllers\Admin\OrderController::class, 'checkNewOrders'])->name('orders.check-new');

    // User Management (Quản lý người dùng)
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});

require __DIR__.'/auth.php';

// Temporary debug route
Route::post('/debug-form', function(\Illuminate\Http\Request $request) {
    dd([
        'all' => $request->all(),
        'attributes' => $request->attributes,
        'has_attributes' => $request->has('attributes'),
        'is_array' => is_array($request->attributes),
    ]);
})->middleware(['auth', 'admin']);

// Show list products in a catelory
Route::get('/category/{id}', [PublicCategoryController::class, 'products'])->name('categoryProducts');

// Show list products in outstanding
Route::get('/products/outstanding', [PublicProductController::class, 'outstanding'])->name('products.outstanding');

