<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // إيلا كان السيد مكونيكطي ولكن "ماشي أدمن"، غنرجعوه لجدول السلعة
        if (auth()->check() && auth()->user()->role !== 'admin') {
            return redirect()->route('products.index');
        }

        // إيلا كان أدمن، خليه يدخل
        return $next($request);
    }
}
