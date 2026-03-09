<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; //  نعيطو للأصناف باش نختارو منهم

use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // هادي كترد لينا صفحة إضافة منتج
    public function create()
    {
        // كنجيبو كاع الأصناف باش يبانو لينا فالقائمة المنسدلة (Select)
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // هادي كتحفظ المنتج والتصويرة فـ قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'reference' => 'required|string|unique:products,reference',
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'reference' => $request->reference,
            'name' => $request->name,
            'description' => $request->description,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'stock_quantity' => $request->stock_quantity,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Produit ajouté avec succès !');
    }

    // هادي كاتجيب كاع السلعة وكتصيفطها لصفحة الجدول
    public function index()
    {
        // استعملنا with('category') باش نجيبو السمية دالصنف، و latest() باش يبان الجديد هو الأول
        $products = Product::with('category')->latest()->get();

        return view('products.index', compact('products'));
    }


    // هادي كاتجيب لينا صفحة التعديل وعامرة بالمعلومات ديال داك المنتج
    public function edit(Product $product)
    {
        $categories = Category::all(); // كنجيبو الأصناف باش نقدرو نبدلو الصنف
        return view('products.edit', compact('product', 'categories'));
    }

    // هادي كتحفظ التعديلات الجديدة فـ قاعدة البيانات
    public function update(Request $request, Product $product)
    {
        // 1. كنتأكدو من المعلومات (لاحظ الريفيراص زدنا ليها ID باش مايقولش لينا راه ديجا كاينة)
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'reference' => 'required|string|unique:products,reference,' . $product->id,
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. إيلا السيد دخل تصويرة جديدة، كنسجلوها وكنزيدوها مع الداتا
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        // 3. كنديرو التحديث فـ MySQL
        $product->update($validatedData);

        // 4. كنرجعو للجدول مع ميساج ديال النجاح
        return redirect()->route('products.index')->with('success', 'Produit modifié avec succès !');
    }


    // هادي كتمسح المنتج والتصويرة ديالو
    public function destroy(Product $product)
    {
        // 1. كنشوفو واش هاد المنتج عندو تصويرة، إيلا كاينة كنمحيوها من الدوسي
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. كنمحيو المنتج من قاعدة البيانات
        $product->delete();

        // 3. كنرجعو للجدول مع ميساج خضر
        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès !');
    }
}
