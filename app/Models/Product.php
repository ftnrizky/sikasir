<?php

// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'barcode', 'price', 'stock', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}