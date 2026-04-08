<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    // عرض كاع العائلات
    public function index(Request $request)
    {
        $query = Brand::query();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $brands = $query->latest()->get();

        return view('brands.index', compact('brands'));
    }

    // صفحة إضافة عائلة جديدة
    public function create()
    {
        return view('brands.create');
    }

    // حفظ العائلة فـ قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:brands,name|max:255', // السمية خاصها تكون ماكايناش ديجا
        ]);

        Brand::create([
            'name' => $request->name,
        ]);

        return redirect()->route('brands.index')->with('success', 'Famille ajoutée avec succès !');
    }

    // مسح العائلة
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Famille supprimée !');
    }
    public function bulkAction(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if (!$ids) return redirect()->back()->with('error', '❌ Sélectionnez au moins un élément.');

        $query = \App\Models\Brand::whereIn('id', $ids);

        if ($action == 'delete') {
            $count = $query->count();
            $query->delete();
            \App\Models\ActivityLog::log("Suppression Massive (Familles)", "{$count} familles ont été supprimées.");
            return redirect()->back()->with('success', '🗑️ Suppression réussie.');
        }
        return redirect()->back();
    }
}
