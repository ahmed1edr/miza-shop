<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // 1. نشوفو شنو كاين فالسلة
    public function index()
    {
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'employe'])) {
            return redirect()->route('orders.index')->with('error', '❌ Accès refusé !');
        }
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // 2. نزيدو منتج للسلة

    public function add(\Illuminate\Http\Request $request, $id)
    {
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'employe'])) {
            return redirect()->route('orders.index')->with('error', '❌ Les employés ne peuvent pas passer de commandes depuis leur compte professionnel !');
        }
        $product = Product::findOrFail($id);

        // حماية: ما نخليوهش يزيد منتج مخبي أو خاوي من الستوك
        if (!$product->is_active || $product->stock_quantity <= 0) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Ce produit n\'est plus disponible.'], 422);
            }
            return redirect()->back()->with('error', 'Ce produit n\'est plus disponible.');
        }

        $cart = session()->get('cart', []);

        // حماية: ما نخليوهش يزيد أكثر من الستوك
        $currentQty = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        if ($currentQty + 1 > $product->stock_quantity) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Stock insuffisant.'], 422);
            }
            return redirect()->back()->with('error', 'Stock insuffisant pour ce produit.');
        }

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->selling_price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        // نحسبو شحال من بياسة ولات فالسلة
        $cartCount = count(session('cart'));

        // إيلا كان الطلب جاي من الجافاسكريبت (AJAX)، غنجاوبوه بـ JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté au panier !',
                'cartCount' => $cartCount
            ]);
        }

        // هادي غتبقى غير للاحتياط إيلا الجافاسكريبت ماكانش خدام
        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès !');
    }

    // 3. نمسحو منتج من السلة
    public function remove($id)
    {
        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produit retiré du panier !');
    }
    // 4. نحدثو الكمية ديال السلعة فالسلة (بـ AJAX)
    public function update(\Illuminate\Http\Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            if($request->action == 'increase') {
                // حماية: ما نخليوهش يزيد أكثر من الستوك
                $product = Product::find($id);
                if ($product && $cart[$id]['quantity'] + 1 > $product->stock_quantity) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json(['success' => false, 'message' => 'Stock insuffisant.'], 422);
                    }
                    return redirect()->back()->with('error', 'Stock insuffisant.');
                }
                $cart[$id]['quantity']++;
            }
            elseif($request->action == 'decrease' && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            }
            elseif($request->has('quantity') && $request->quantity > 0) {
                $cart[$id]['quantity'] = $request->quantity;
            }

            session()->put('cart', $cart);

            // إيلا كان الطلب جاي من الجافاسكريبت، كنحسبو المجموع ونرجعوه
            if ($request->ajax() || $request->wantsJson()) {
                // مجموع المنتج بوحدو (الثمن x الكمية)
                $itemTotal = $cart[$id]['price'] * $cart[$id]['quantity'];

                // المجموع الكلي ديال السلة كاملة
                $grandTotal = 0;
                foreach(session('cart') as $item) {
                    $grandTotal += $item['price'] * $item['quantity'];
                }

                return response()->json([
                    'success' => true,
                    'newQuantity' => $cart[$id]['quantity'],
                    'itemTotal' => number_format($itemTotal, 2),
                    'grandTotal' => number_format($grandTotal, 2)
                ]);
            }
        }

        return redirect()->back();
    }
}
