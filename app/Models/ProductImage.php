<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'image_path', 'sort_order'];

    // هاد الصورة تابعة لمنتج واحد
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
