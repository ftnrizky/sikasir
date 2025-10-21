<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'stock',
        'minimum_stock',
        'is_available',
    ];

    // Relasi ke product_ingredients (bahan ini digunakan di banyak produk)
    public function productIngredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }

    // Relasi ke log stok
    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }

    // Cek apakah stok bahan masih tersedia
    public function isLowStock()
    {
        return $this->stock <= $this->minimum_stock;
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_ingredients')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
