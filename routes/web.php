<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShopController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ActivityLogController;

// ==========================================
// 1. واجهة الكليان (مفتوحة للعموم - برا على الحماية)
// ==========================================
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('shop.show');
// الروابط ديال السلة
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
// الروابط ديال Checkout (الطلب)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// الروابط ديال تتبع الطلبية (Tracking)
Route::get('/suivi', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/suivi', [TrackingController::class, 'search'])->name('tracking.search')->middleware('throttle:5,1');


// ==========================================
// 2. تسجيل الدخول والخروج
// ==========================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 3. منطقة الإدارة (خاصك تكون مكونيكطي باش تدخل ليها)
// ==========================================
Route::middleware(['auth'])->group(function () {

    // لوحة التحكم (الداشبورد)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Endpoint for AJAX polling of pending orders count
    Route::get('/api/pending-orders-count', function () {
        $count = 0;
        if(auth()->user()->role === 'admin') {
            $count = \App\Models\Order::where('status', 'en attente')->count();
        } else {
            $count = \App\Models\Order::where('status', 'en attente')
                        ->where('brand_id', auth()->user()->brand_id)->count();
        }
        return response()->json(['count' => $count]);
    })->name('api.pending.count');

    // هاد الروت غيتكلف بڭاع العمليات الجماعية ديال المنتجات
    Route::post('/products/bulk-action', [App\Http\Controllers\ProductController::class, 'bulkAction'])->name('products.bulk');
    // هادو كاملين كيمشيو لنفس النوع ديال الخدمة كل واحد فـ الكونترولر ديالو
    Route::post('/users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk');
    Route::post('/categories/bulk-action', [CategoryController::class, 'bulkAction'])->name('categories.bulk');
    Route::post('/brands/bulk-action', [BrandController::class, 'bulkAction'])->name('brands.bulk');
    Route::post('/orders/bulk-action', [OrderController::class, 'bulkAction'])->name('orders.bulk');


    // المنتجات (مسموحة للأدمن والموظف)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


    // إدارة الطلبيات فـ الداشبورد
    Route::get('/orders/export', [OrderController::class, 'exportExcel'])->name('orders.export');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

    // الحماية الخاصة غير بالأدمن (الموظف مايدخلش هنا)
    Route::middleware([IsAdmin::class])->group(function () {

        // الأصناف
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // العائلات
        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
        Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

        // المستخدمين
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');


        // Logs
        Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
    });
});
