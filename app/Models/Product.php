<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // الخانات لي غنعمروهم من الفورميلير
    protected $fillable = [
        'category_id', 'brand_id', 'reference', 'name', 'description',
        'purchase_price', 'selling_price', 'stock_quantity',
        'alert_stock', 'is_active', 'image', 'stock'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // المنتج كينتامي لعائلة وحدة
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // المنتج يقدر يكونو عندو بزاف د الصور الإضافية
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }
}
