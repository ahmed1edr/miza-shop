<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // الخانات لي غنعمروهم من الفورميلير
    protected $fillable = [
        'category_id', 'reference', 'name', 'description',
        'purchase_price', 'selling_price', 'stock_quantity',
        'alert_stock', 'is_active', 'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
