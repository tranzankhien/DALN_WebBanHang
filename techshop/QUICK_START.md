# 🚀 Quick Start Guide - TechShop

## ⚡ Khởi động nhanh

### 1. Kiểm tra server đã chạy chưa
```bash
# Nếu chưa chạy, khởi động server:
cd "/home/twan/web advance/empty/techshop"
php artisan serve
```

Truy cập: **http://localhost:8000**

### 2. Đăng nhập Admin
- URL: `http://localhost:8000` (sau khi làm authentication)
- Email: `admin@techshop.com`
- Password: `password`

## 🎯 Roadmap Phát triển Admin Panel

### Giai đoạn 1: Authentication (Ưu tiên cao)
```bash
# Cài đặt Laravel Breeze
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run dev
php artisan migrate
```

### Giai đoạn 2: Admin Dashboard
1. Tạo Admin Layout
2. Tạo Dashboard với thống kê:
   - Tổng số sản phẩm trong kho
   - Tổng số sản phẩm đang bán
   - Đơn hàng hôm nay
   - Doanh thu

### Giai đoạn 3: Module Quản lý Kho
**Priority: HIGH** ⭐⭐⭐

Tạo CRUD cho `inventory_items`:
```bash
php artisan make:controller Admin/InventoryController --resource
```

**Features cần có:**
- ✅ Danh sách sản phẩm kho (table với search, filter)
- ✅ Thêm sản phẩm mới vào kho
- ✅ Sửa thông tin sản phẩm
- ✅ Xem chi tiết sản phẩm
- ✅ Quản lý số lượng tồn kho
- ✅ Lịch sử nhập/xuất kho
- ✅ Upload ảnh sản phẩm

**Form fields:**
- SKU (auto-generate hoặc nhập tay)
- Tên sản phẩm
- Mô tả
- Thương hiệu
- Danh mục
- Giá nhập
- Số lượng
- Thuộc tính (RAM, ROM, etc.)

### Giai đoạn 4: Module Quản lý Danh mục
**Priority: HIGH** ⭐⭐⭐

```bash
php artisan make:controller Admin/CategoryController --resource
```

**Features:**
- ✅ Tree view danh mục (parent-child)
- ✅ CRUD danh mục
- ✅ Drag & drop để sắp xếp
- ✅ Active/Inactive status
- ✅ Upload ảnh danh mục

### Giai đoạn 5: Module Quản lý Sản phẩm Bán
**Priority: HIGH** ⭐⭐⭐

```bash
php artisan make:controller Admin/ProductController --resource
```

**Features:**
- ✅ Tạo listing từ inventory_items
- ✅ Đặt giá bán
- ✅ Đặt giá khuyến mãi
- ✅ Giới hạn số lượng bán (max_stock)
- ✅ Quản lý hình ảnh (multi-upload)
- ✅ Draft/Active/Inactive status
- ✅ Sản phẩm nổi bật (featured)
- ✅ SEO fields (meta description, keywords)

**Workflow:**
1. Chọn sản phẩm từ kho (inventory_items)
2. Tạo tên marketing (có thể khác tên kho)
3. Đặt giá bán
4. Upload ảnh đẹp
5. Viết mô tả hấp dẫn
6. Publish

### Giai đoạn 6: Module Quản lý Đơn hàng
**Priority: MEDIUM** ⭐⭐

```bash
php artisan make:controller Admin/OrderController --resource
```

**Features:**
- ✅ Danh sách đơn hàng
- ✅ Filter theo status
- ✅ Xem chi tiết đơn
- ✅ Cập nhật trạng thái
- ✅ In hóa đơn (PDF)
- ✅ Tracking info

**Status flow:**
pending → confirmed → shipped → completed
                  ↓
              cancelled

### Giai đoạn 7: Module Quản lý Người dùng
**Priority: MEDIUM** ⭐⭐

```bash
php artisan make:controller Admin/UserController --resource
```

**Features:**
- ✅ Danh sách users
- ✅ Phân quyền (customer/admin)
- ✅ Active/Deactive users
- ✅ View order history

### Giai đoạn 8: Reports & Analytics
**Priority: LOW** ⭐

- Báo cáo doanh thu
- Sản phẩm bán chạy
- Tồn kho
- Export Excel/PDF

## 🛠️ Tech Stack Đề xuất cho Admin

### Option 1: Custom Build với Tailwind (Recommended)
```bash
npm install -D tailwindcss postcss autoprefixer
npm install alpinejs
npm install chart.js
```

**Pros:**
- Tùy biến hoàn toàn
- Nhẹ, nhanh
- Học được nhiều

**Cons:**
- Mất thời gian build UI

### Option 2: Laravel Filament (Fastest)
```bash
composer require filament/filament:"^3.0"
php artisan filament:install --panels
php artisan make:filament-user
```

**Pros:**
- Cực nhanh, chỉ cần config
- UI đẹp sẵn
- Đầy đủ features

**Cons:**
- Ít tùy biến
- Dependency lớn

### Option 3: AdminLTE + Bootstrap
```bash
npm install admin-lte
npm install bootstrap
```

**Pros:**
- Template miễn phí
- Nhiều components

**Cons:**
- Hơi nặng
- Design hơi cũ

## 📝 Sample Code - Admin Dashboard Controller

```php
// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_inventory' => InventoryItem::count(),
            'total_products' => Product::where('status', 'active')->count(),
            'total_orders' => Order::whereDate('created_at', today())->count(),
            'total_revenue' => Order::whereDate('created_at', today())
                ->where('status', 'completed')
                ->sum('total_amount'),
            'low_stock' => InventoryItem::where('stock_quantity', '<', 10)->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recent_orders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        $top_products = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'top_products'));
    }
}
```

## 🎨 Sample Routes

```php
// routes/web.php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;

// Admin Routes - Require authentication + admin role
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Quản lý kho
    Route::resource('inventory', InventoryController::class);
    Route::post('inventory/{id}/adjust-stock', [InventoryController::class, 'adjustStock'])->name('inventory.adjust');
    Route::get('inventory/{id}/history', [InventoryController::class, 'history'])->name('inventory.history');
    
    // Quản lý danh mục
    Route::resource('categories', CategoryController::class);
    Route::post('categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
    
    // Quản lý sản phẩm
    Route::resource('products', ProductController::class);
    Route::post('products/{id}/publish', [ProductController::class, 'publish'])->name('products.publish');
    Route::post('products/{id}/unpublish', [ProductController::class, 'unpublish'])->name('products.unpublish');
    
    // Quản lý đơn hàng
    Route::resource('orders', OrderController::class)->only(['index', 'show']);
    Route::post('orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders/{id}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    
    // Quản lý người dùng
    Route::resource('users', UserController::class)->only(['index', 'show', 'edit', 'update']);
    Route::post('users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
});
```

## 🔐 Sample Admin Middleware

```php
// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
```

Đăng ký middleware trong `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})
```

## 📦 Useful Packages

```bash
# Image processing
composer require intervention/image

# Excel export
composer require maatwebsite/excel

# PDF generation
composer require barryvdh/laravel-dompdf

# Sluggable URLs
composer require cviebrock/eloquent-sluggable

# Activity log
composer require spatie/laravel-activitylog

# Backup
composer require spatie/laravel-backup

# Media library
composer require spatie/laravel-medialibrary
```

## ✅ Checklist cho từng module

### Module Quản lý Kho
- [ ] Controller created
- [ ] Routes defined
- [ ] Views created (index, create, edit, show)
- [ ] Form validation
- [ ] File upload (images)
- [ ] Search & filter
- [ ] Pagination
- [ ] Stock adjustment
- [ ] Transaction history

### Module Quản lý Danh mục
- [ ] Controller created
- [ ] Routes defined
- [ ] Views created
- [ ] Tree structure display
- [ ] CRUD operations
- [ ] Image upload
- [ ] Reorder functionality

### Module Quản lý Sản phẩm
- [ ] Controller created
- [ ] Routes defined
- [ ] Views created
- [ ] Link with inventory
- [ ] Multiple image upload
- [ ] Status management
- [ ] Featured toggle
- [ ] Publishing workflow

## 🎯 Next Steps

1. **Ngay bây giờ**: Cài đặt authentication (Laravel Breeze)
2. **Tiếp theo**: Tạo Admin Dashboard layout
3. **Sau đó**: Bắt đầu với module Quản lý Kho (quan trọng nhất)
4. **Cuối cùng**: Làm module Danh mục và Sản phẩm

---

**Good luck with your development! 🚀**
