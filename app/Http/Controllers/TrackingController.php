<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class TrackingController extends Controller
{
    // 1. صفحة التتبع (فورميلير البحث)
    public function index()
    {
        return view('tracking');
    }

    // 2. البحث عن الطلبيات بالتليفون أو كود CMD
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:3'
        ]);

        $query = trim($request->input('query'));

        // كنشوفو الطلبيات اللي تدارت بهاد نمرة تيليفون أو رقم الطلبية
        $orders = Order::where('phone', $query)
            ->orWhere('group_id', $query)
            ->latest()
            ->get();

        return view('tracking', compact('orders', 'query'));
    }
}
