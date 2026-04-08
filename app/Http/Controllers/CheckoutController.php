<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class CheckoutController extends Controller
{
    // 1. نبينو الفورميلير ديال الطلب
    public function index()
    {
        // حماية: نمنعو الموظف/الأدمن من الدخول لصفحة الدفع
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'employe'])) {
            return redirect()->route('orders.index')->with('error', '❌ Accès refusé pour les employés !');
        }

        $cart = session('cart');
        if (!$cart || count($cart) == 0) {
            return redirect()->route('shop.index');
        }
        return view('checkout', compact('cart'));
    }

    // 2. نسجلو الطلب فقاعدة البيانات
    public function store(Request $request)
    {
        // حماية: نمنعو الموظف/الأدمن من تسجيل الكوموند
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'employe'])) {
            return redirect()->route('orders.index')->with('error', '❌ Accès refusé pour les employés !');
        }

        // 1. كنصاوبو رقم تجميع عشوائي
        $groupId = 'CMD-' . strtoupper(substr(uniqid(), -5));

        // 2. كنتأكدو من المعلومات
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string'
        ]);

        $cart = session('cart');
        if (!$cart || count($cart) == 0) {
            return redirect()->route('shop.index');
        }

        // 3. غنصاوبو طابلو خاوي باش نفرقو فيه السلعة على حساب الماركة
        $ordersByBrand = [];

        foreach($cart as $id => $details) {
            $product = \App\Models\Product::find($id);
            $brandId = $product ? $product->brand_id : null;

            if (!isset($ordersByBrand[$brandId])) {
                $ordersByBrand[$brandId] = [
                    'total' => 0,
                    'items' => []
                ];
            }

            $ordersByBrand[$brandId]['items'][$id] = $details;
            $ordersByBrand[$brandId]['total'] += $details['price'] * $details['quantity'];
        }

        // 4. دابا غنكرييو كوموند منفصلة لكل ماركة
        foreach($ordersByBrand as $brandId => $brandOrderData) {
            \App\Models\Order::create([
                'group_id' => $groupId,
                'brand_id' => $brandId,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'total' => round($brandOrderData['total'], 2),
                'items' => $brandOrderData['items'],
                'status' => 'en attente'
            ]);
        }

        // 5. كنخويو السلة
        session()->forget('cart');

        return redirect()->route('shop.index')->with('success', '🎉 Commande enregistrée avec succès ! Nous vous appellerons bientôt pour confirmer.');
    }
}
