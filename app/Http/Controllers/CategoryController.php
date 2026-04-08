<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // عيطنا للموديل ديالنا

class CategoryController extends Controller
{
    // هادي كترد لينا صفحة HTML فين كاين الفورميلير
    public function create()
    {
        return view('categories.create');
    }

    // هادي كتشد المعلومات لي دخلنا فالفورميلير وكتسجلهم
    public function store(Request $request)
    {
        // 1. كنتأكدو بلي المعلومات صحيحة (Validation)
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
        ]);

        // 2. كنسجلوهم فـ قاعدة البيانات
        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        // 3. كنرجعو للصفحة وكنقولو ليه راه داكشي تسجل بنجاح
        return back()->with('success', 'Catégorie ajoutée avec succès !');
    }
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $categories = $query->get();

        return view('categories.index', compact('categories'));
    }



    // 1. كاتجيب لينا الصفحة ديال التعديل
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // 2. كتحفظ التعديلات فـ قاعدة البيانات
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // كنزيدو هاد اللعيبة باش يقبل لينا نفس الـ slug ديالو بلا مايعطينا إيرور
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return redirect()->route('categories.index')->with('success', 'Catégorie modifiée avec succès !');
    }

    // 3. كتمسح الصنف من قاعدة البيانات
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès !');
    }
    public function bulkAction(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if (!$ids)
            return redirect()->back()->with('error', '❌ Sélectionnez au moins un élément.');

        $query = \App\Models\Category::whereIn('id', $ids);

        if ($action == 'delete') {
            $count = $query->count();
            $query->delete();
            \App\Models\ActivityLog::log("Suppression Massive (Catégories)", "{$count} catégories ont été supprimées.");
            return redirect()->back()->with('success', '🗑️ Suppression réussie.');
        }
        return redirect()->back();
    }
}
