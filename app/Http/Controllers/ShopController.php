<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // كنجيبو السلعة لي مفعلة + كاين فالستوك
        $query = \App\Models\Product::with(['category', 'brand'])
            ->where('is_active', 1)
            ->where('stock_quantity', '>', 0);

        // بحث
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('reference', 'like', '%' . $searchTerm . '%');
            });
        }

        // فلتر بالكاتيغوري
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // فلتر بالماركة
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $products = $query->latest()->paginate(12);

        $categories = Category::all();
        $brands = Brand::all();

        return view('shop.index', compact('products', 'categories', 'brands'));
    }

    // صفحة تفاصيل المنتج
    public function show(Product $product)
    {
        // كنجيبو المنتج مع العلاقات ديالو (الصور + الماركة + الصنف)
        $product->load(['images', 'brand', 'category']);

        // كنجيبو منتجات مشابهة (نفس الصنف، ماشي نفس المنتج، مفعلين)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', 1)
            ->where('stock_quantity', '>', 0)
            ->limit(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
