@extends('layouts.admin')

@section('content')
<div class="px-6 py-8">
    <div class="bg-white shadow rounded-xl p-6 w-full max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">Edit Produk</h1>

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                    class="w-full rounded border px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Barcode</label>
                <input type="text" name="barcode" value="{{ old('barcode', $product->barcode) }}" required
                    class="w-full rounded border px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Harga Modal</label>
                <input type="number" name="harga_modal" value="{{ old('harga_modal', $product->harga_modal) }}" required
                    class="w-full rounded border px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Harga Jual</label>
                <input type="number" name="harga_jual" value="{{ old('harga_jual', $product->harga_jual) }}" required
                    class="w-full rounded border px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium">Kategori</label>
                <select name="category_id" id="category_id"
                    class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium">Subkategori</label>
                <select name="subcategory_id" id="subcategory_id"
                    class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Pilih Subkategori --</option>
                    @foreach ($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}"
                            {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                            {{ $subcategory->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 🔹 Bahan Baku --}}
            <div class="mb-6">
                <label class="block font-semibold mb-2">Bahan Baku yang Digunakan</label>
                @foreach ($ingredients as $ingredient)
                    @php
                        $pivot = $product->ingredients->find($ingredient->id)?->pivot;
                    @endphp
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="ingredients[{{ $ingredient->id }}][selected]" value="1"
                            {{ $pivot ? 'checked' : '' }} class="mr-2">
                        <span class="w-40">{{ $ingredient->name }}</span>
                        <input type="number" name="ingredients[{{ $ingredient->id }}][quantity]"
                            value="{{ $pivot->quantity ?? 0 }}" step="0.01" min="0"
                            class="ml-2 w-24 border rounded p-1 text-sm">
                        <span class="ml-1 text-gray-500 text-sm">{{ $ingredient->unit }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mb-6">
                <label class="block font-medium">Gambar Produk</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full border-gray-300 rounded-md shadow-sm">
                @if ($product->image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="h-24 rounded shadow">
                    </div>
                @endif
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700">
                    Update
                </button>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-sm font-medium rounded hover:bg-gray-500">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
