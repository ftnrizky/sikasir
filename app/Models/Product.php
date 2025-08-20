<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'barcode',
        'harga_modal',
        'harga_jual',
        'image',
        'category_id',
        'subcategory_id', 
    ];

    // Relasi ke kategori utama
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke subkategori
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    // Atribut tambahan: margin
    public function getMarginAttribute()
    {
        return $this->harga_jual - $this->harga_modal;
    }
}