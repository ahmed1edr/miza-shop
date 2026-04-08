<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['group_id','brand_id','name', 'phone', 'address', 'total', 'items', 'status'];

    protected $casts = [
        'items' => 'array',
    ];

    // الطلبية تابعة لماركة وحدة
    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class);
    }
}
