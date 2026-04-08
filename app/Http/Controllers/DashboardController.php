<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === "admin") {
            $stats = [
                "products"   => Product::count(),
                "users"      => User::count(),
                "brands"     => Brand::count(),
                "categories" => Category::count(),
            ];

            // ====== بيانات الرسوم البيانية ======

            // 1. Top 5 ماركات (حسب عدد الكوموندات)
            $topBrands = Order::select('brand_id', DB::raw('COUNT(*) as orders_count'))
                ->whereNotNull('brand_id')
                ->groupBy('brand_id')
                ->orderByDesc('orders_count')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    $brand = Brand::find($item->brand_id);
                    return [
                        'name'  => $brand ? $brand->name : 'Sans marque',
                        'count' => $item->orders_count,
                    ];
                });

            // 2. الدخل ديال 7 أيام الأخيرة (يوم بيوم)
            $weeklyRevenue = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $revenue = Order::whereDate('created_at', $date)
                    ->where('status', '!=', 'annulé')
                    ->sum('total');
                $weeklyRevenue[] = [
                    'day'     => $date->locale('fr')->isoFormat('ddd D'),
                    'revenue' => $revenue,
                ];
            }

            // 4. Stats إضافية
            $extraStats = [
                'totalRevenue'  => Order::where('status', '!=', 'annulé')->sum('total'),
                'todayOrders'   => Order::whereDate('created_at', Carbon::today())->count(),
                'deliveredRate' => Order::count() > 0
                    ? round((Order::where('status', 'livré')->count() / Order::count()) * 100)
                    : 0,
                'pendingOrders' => Order::where('status', 'en attente')->count(),
            ];
            return view("dashboard", compact("stats", "topBrands", "weeklyRevenue", "extraStats"));
        } else {
            $stats = [
                "products" => Product::where("brand_id", $user->brand_id)->count()
            ];
            return view("dashboard", compact("stats"));
        }
    }
}
