<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // كنتأكدو واش السيد ديجا مكونيكطي
        if (Auth::check()) {
            // إيلا كان مكونيكطي، كنصيفطوه نيشان لجدول السلعة
            return redirect()->route('products.index');
        }

        // إيلا ماكانش مكونيكطي، عاد كنبينو ليه صفحة تسجيل الدخول
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('products.index');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
