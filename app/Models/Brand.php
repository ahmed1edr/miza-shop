<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // العائلة يقدر يكونو فيها بزاف د الموظفين
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // العائلة يقدر يكونو فيها بزاف د المنتجات
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
