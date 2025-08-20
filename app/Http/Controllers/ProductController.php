<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Load relasi kategori & subkategori supaya tidak n+1 query
        $products = Product::with(['category', 'subcategory'])->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('products.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'barcode'        => 'required|string|unique:products,barcode',
            'harga_modal'    => 'required|numeric',
            'harga_jual'     => 'required|numeric',
            'category_id'    => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'name',
            'barcode',
            'harga_modal',
            'harga_jual',
            'category_id',
            'subcategory_id',
        ]);

        if ($request->hasFile('image')) {
            $filename = $request->file('image')->store('products', 'public');
            $data['image'] = $filename;
        }

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'barcode'        => 'required|string|unique:products,barcode,' . $product->id,
            'harga_modal'    => 'required|numeric',
            'harga_jual'     => 'required|numeric',
            'category_id'    => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'name',
            'barcode',
            'harga_modal',
            'harga_jual',
            'category_id',
            'subcategory_id',
        ]);

        if ($request->hasFile('image')) {
            $filename = $request->file('image')->store('products', 'public');
            $data['image'] = $filename;
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}