<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get(); // Load relasi category
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all(); // Ambil semua kategori
        $subcategories = \App\Models\Subcategory::all(); // Ambil semua subkategori
        return view('products.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'barcode'     => 'required|string|unique:products,barcode',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'barcode', 'price', 'stock', 'category_id']);
        $data['barcode'] = $request->input('barcode', Str::random(10));

        if ($request->hasFile('image')) {
            $filename = $request->file('image')->store('products', 'public');
            $data['image'] = $filename;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $subcategories = \App\Models\Subcategory::all(); // Ambil semua kategori
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'barcode'     => 'required|string|unique:products,barcode,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'barcode', 'price', 'stock', 'category_id', 'subcategory_id']);

        $data['barcode'] = $request->input('barcode', Str::random(10));

        if ($request->hasFile('image')) {
            $filename = $request->file('image')->store('products', 'public');
            $data['image'] = $filename;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}