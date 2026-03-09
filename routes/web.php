<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;


// 1. الرابط ديال الجدول
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// 2. الرابط ديال الفورميلير (هنا فين زدنا السمية)
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');

// 3. الرابط لي كيصيفط المعلومات لقاعدة البيانات
Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');


// الرابط لي كيدي لصفحة التعديل
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

// الرابط لي كيحفظ التعديلات الجديدة فالداتا
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

// الرابط لي كيمسح catg
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');




//AJOUTER

use App\Http\Controllers\ProductController;

// الروابط ديال المنتجات (Produits)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
