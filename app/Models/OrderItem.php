<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'unit_price'
    ];

    // العلاقة 1: هاد السطر تابع لفاكتورة وحدة
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // العلاقة 2: هاد السطر كيعني منتج واحد
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
