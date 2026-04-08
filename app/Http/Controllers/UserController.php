<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // عرض كاع الموظفين
    public function index(Request $request)
    {
        $query = User::with('brand')->latest();

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
        }

        $users = $query->get();
        return view('users.index', compact('users'));
    }

    // صفحة إضافة موظف جديد
    public function create()
    {
        $brands = Brand::all(); // كنجيبو العائلات باش نعزلوهم فالفورميلير
        return view('users.create', compact('brands'));
    }

    // حفظ الموظف فـ قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,employe',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // هادي كتشفر المودباس باش يكون محمي
            'role' => $request->role,
            'brand_id' => $request->brand_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès !');
    }

    // حذف الموظف
    public function destroy(User $user)
    {
        // 🛡️ حماية: الأدمن ما يقدرش يمسح راسو
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', '❌ Vous ne pouvez pas supprimer votre propre compte !');
        }

        $userName = $user->name;
        $user->delete();

        \App\Models\ActivityLog::log("Suppression Utilisateur", "L'utilisateur {$userName} a été supprimé.");

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé !');
    }

    // تعديل معلومات الموظف
    public function edit(User $user)
    {
        $brands = Brand::all();
        return view('users.edit', compact('user', 'brands'));
    }

    // حفظ التعديلات ديال الموظف
    public function update(Request $request, User $user)
    {
        // 🛡️ حماية: الأدمن ما يقدرش ينزل الرول ديال راسو
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return redirect()->back()->with('error', '❌ Vous ne pouvez pas rétrograder votre propre rôle !');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,employe',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'brand_id' => $request->brand_id,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        \App\Models\ActivityLog::log("Modification Utilisateur", "L'utilisateur {$user->name} a été modifié.");

        return redirect()->route('users.index')->with('success', 'Utilisateur modifié avec succès !');
    }

    public function bulkAction(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action;

        if (!$ids) return redirect()->back()->with('error', '❌ Sélectionnez au moins un élément.');

        // 🛡️ حماية: نستثنيو المستخدم الحالي باش ما يمسحش راسو
        $query = \App\Models\User::whereIn('id', $ids)->where('id', '!=', auth()->id());

        if ($action == 'delete') {
            $count = $query->count();
            $query->delete();
            \App\Models\ActivityLog::log("Suppression Massive (Utilisateurs)", "{$count} utilisateurs ont été supprimés.");
            return redirect()->back()->with('success', '🗑️ Suppression réussie.');
        }
        return redirect()->back();
    }
}
