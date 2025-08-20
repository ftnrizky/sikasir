@extends('layouts.app')

@section('content')
    <div class="px-6 py-8">
        <div class="bg-white shadow rounded-xl p-6 w-full max-w-3xl mx-auto">
            <h1 class="text-2xl font-semibold mb-6 text-gray-800">Edit Produk</h1>

            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode</label>
                    <input type="text" name="barcode" id="barcode" value="{{ old('barcode', $product->barcode) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="harga_modal" class="block font-medium">Harga Modal</label>
                    <input type="number" name="harga_modal" class="w-full rounded border px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label for="harga_jual" class="block font-medium">Harga Jual</label>
                    <input type="number" name="harga_jual" class="w-full rounded border px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
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
                    <div class="mb-4">
                        <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Subkategori</label>
                        <select name="subcategory_id" id="subcategory_id"
                            class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                            <option value="">-- Pilih Subkategori --</option>
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm">
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
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Update
                    </button>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-sm font-medium rounded hover:bg-gray-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
