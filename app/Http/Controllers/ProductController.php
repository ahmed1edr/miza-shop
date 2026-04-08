<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; //  نعيطو للأصناف باش نختارو منهم

use Illuminate\Support\Facades\Storage;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ActivityLog;

class ProductController extends Controller
{
    // هادي كترد لينا صفحة إضافة منتج
    public function create()
    {
        $categories = Category::all();
        $user = auth()->user();

        // إيلا كان أدمن، كنجيبو ليه كاع العائلات
        if ($user->role === 'admin') {
            $brands = Brand::all();
        }
        // إيلا كان موظف، كنجيبو ليه غير العائلة ديالو باش مايقدرش يختار شي وحدة خرى
        else {
            $brands = Brand::where('id', $user->brand_id)->get();
        }

        return view('products.create', compact('categories', 'brands'));
    }

    // هادي كتحفظ المنتج والتصويرة فـ قاعدة البيانات
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'reference' => 'required|string|unique:products,reference',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 🛡️ حماية IDOR: الموظف ما يقدرش يضيف منتج لماركة أخرى
        $brandId = $request->brand_id;
        if ($user->role !== 'admin') {
            $brandId = $user->brand_id;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'brand_id' => $brandId,
            'reference' => $request->reference,
            'name' => $request->name,
            'description' => $request->description,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'stock_quantity' => $request->stock_quantity,
            'image' => $imagePath,
        ]);

        // حفظ الصور الإضافية (Gallery)
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $file) {
                $path = $file->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        ActivityLog::log("Création Produit", "Un nouveau produit a été créé : {$product->name}");

        return back()->with('success', 'Produit ajouté avec succès !');
    }

    // هادي كاتجيب كاع السلعة وكتصيفطها لصفحة الجدول
    public function index(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();

        // كنجيبو المنتجات مع العائلات والأصناف ديالهم
        $query = \App\Models\Product::with(['category', 'brand']);

        // الحماية: إيلا كان موظف، كنجيبو ليه غير السلعة ديالو
        if ($user->role !== 'admin') {
            $query->where('brand_id', $user->brand_id);
        }

        // هادا هو الكود ديال البحث
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                // قلب فـ السمية أو الريفيرونس
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

        // فلتر بالحالة (مفعل / معطل)
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active' ? 1 : 0);
        }

        // كنقسمو الصفحة ايلا كانو 10 produit
        $products = $query->paginate(10);

        // كنجيبو الكاتيغوريات والماركات للفلتر
        $categories = \App\Models\Category::all();
        if ($user->role === 'admin') {
            $brands = \App\Models\Brand::all();
        } else {
            $brands = \App\Models\Brand::where('id', $user->brand_id)->get();
        }

        return view('products.index', compact('products', 'categories', 'brands'));
    }


    // 1. صفحة التعديل
    public function edit(Product $product)
    {
        $product->load('images');
        $user = auth()->user();

        // الحماية: إيلا كان موظف وهاد السلعة ماشي ديالو، جْرّي عليه!
        if ($user->role !== 'admin' && $product->brand_id !== $user->brand_id) {
            return redirect()->route('products.index')->with('error', 'Accès refusé : Vous ne pouvez pas modifier ce produit !');
        }

        $categories = Category::all();

        // بحال ديال create: الأدمن كيشوف كاع العائلات، الموظف كيشوف غير ديالو
        if ($user->role === 'admin') {
            $brands = Brand::all();
        } else {
            $brands = Brand::where('id', $user->brand_id)->get();
        }

        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    // 2. حفظ التعديلات
    public function update(Request $request, Product $product)
    {
        $user = auth()->user();

        // الحماية
        if ($user->role !== 'admin' && $product->brand_id !== $user->brand_id) {
            return redirect()->route('products.index')->with('error', 'Accès refusé !');
        }

        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'reference' => 'required|string|unique:products,reference,' . $product->id,
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:product_images,id',
        ]);

        // إيلا كان موظف، كنفرضو عليه تبقى السلعة فالعائلة ديالو واخا يحاول يبدلها بـ HTML
        if ($user->role !== 'admin') {
            $validatedData['brand_id'] = $user->brand_id;
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validatedData);

        // حذف الصور الإضافية لي تسيلكسيوناو
        if ($request->has('delete_images')) {
            $imagesToDelete = ProductImage::whereIn('id', $request->delete_images)
                ->where('product_id', $product->id)
                ->get();
            foreach ($imagesToDelete as $img) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // إضافة صور جديدة
        if ($request->hasFile('gallery')) {
            $lastOrder = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('gallery') as $index => $file) {
                $path = $file->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $lastOrder + $index + 1,
                ]);
            }
        }

        ActivityLog::log("Modification Produit", "Le produit a été modifié : {$product->name} (Réf: {$validatedData['reference']})");

        return redirect()->route('products.index')->with('success', 'Produit modifié avec succès !');
    }

    // 3. مسح المنتج
    public function destroy(Product $product)
    {
        $user = auth()->user();

        // الحماية: إيلا كان موظف وبغا يمسح سلعة ماشي ديالو
        if ($user->role !== 'admin' && $product->brand_id !== $user->brand_id) {
            return redirect()->route('products.index')->with('error', 'Accès refusé : Vous ne pouvez pas supprimer ce produit !');
        }

        if ($product->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }

        $productName = $product->name;
        $product->delete();

        ActivityLog::log("Suppression Produit", "Le produit a été supprimé : {$productName}");

        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès !');
    }
    public function bulkAction(Request $request)
    {
        $ids = $request->ids; // هادو هما الـ IDs ديال داكشي لي تسيليكسيونا
        $action = $request->action; // واش مسح (delete) ولا تفعيل (activate)
        $user = auth()->user();

        // إيلا ما سيلكسيونا حتى حاجة وبرك على البوطونة
        if (!$ids || count($ids) == 0) {
            return redirect()->back()->with('error', '❌ Veuillez sélectionner au moins un élément.');
        }

        // كنجبدو المنتجات من الداتا بيز (مع احترام الصلاحيات: الموظف كيشوف غير ماركتو)
        $query = \App\Models\Product::whereIn('id', $ids);
        if ($user->role === 'employe') {
            $query->where('brand_id', $user->brand_id);
        }

        // إيلا كليك على "مسح"
        if ($action == 'delete') {
            $count = $query->count();
            $query->delete();
            ActivityLog::log("Suppression Massive (Produits)", "{$count} produits ont été supprimés.");
            return redirect()->back()->with('success', '🗑️ Les éléments sélectionnés ont été supprimés avec succès.');
        }

        // إيلا كليك على "تفعيل / تأكيد"
        if ($action == 'activate') {
            $count = $query->count();
            $query->update(['is_active' => 1]); // مثال: رديناهم خدامين
            ActivityLog::log("Activation Massive (Produits)", "{$count} produits ont été activés.");
            return redirect()->back()->with('success', '✅ Les éléments sélectionnés ont été activés.');
        }
        // إيلا كليك على "إخفاء"
        if ($action == 'deactivate') {
            $count = $query->count();
            $query->update(['is_active' => 0]);
            ActivityLog::log("Désactivation Massive (Produits)", "{$count} produits ont été masqués.");
            return redirect()->back()->with('success', '⏸️ Les éléments sélectionnés ont été cachés du site.');
        }

        return redirect()->back();
    }
}
