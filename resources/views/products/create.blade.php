@extends('layouts.admin')

@section('content')
<div class="px-6 py-8">
    <div class="bg-white shadow rounded-xl p-6 w-full max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">Tambah Produk</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode</label>
                <input type="text" name="barcode" id="barcode" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="harga_modal" class="block font-medium">Harga Modal</label>
                <input type="number" name="harga_modal" required class="w-full rounded border px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="harga_jual" class="block font-medium">Harga Jual</label>
                <input type="number" name="harga_jual" required class="w-full rounded border px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="category_id" name="category_id" onchange="filterSubcategories(this.value)">
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Subkategori</label>
                <select name="subcategory_id" id="subcategory_id"
                    class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                    <option value="">-- Pilih Subkategori --</option>
                    @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}">
                        {{ $subcategory->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- 🔹 Bahan Baku --}}
            <div class="mb-6">
                <label class="block font-semibold mb-2">Bahan Baku yang Digunakan</label>
                @foreach ($ingredients as $ingredient)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="ingredients[{{ $ingredient->id }}][selected]" value="1"
                            class="mr-2">
                        <span class="w-40">{{ $ingredient->name }}</span>
                        <input type="number" name="ingredients[{{ $ingredient->id }}][quantity]" step="0.01" min="0"
                            class="ml-2 w-24 border rounded p-1 text-sm" placeholder="Qty">
                        <span class="ml-1 text-gray-500 text-sm">{{ $ingredient->unit }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:outline-none">
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-400 text-white text-sm font-medium rounded hover:bg-gray-500">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function filterSubcategories(categoryId) {
    document.querySelectorAll('#subcategory_id option').forEach(option => {
        option.style.display = option.getAttribute('data-category') === categoryId ? 'block' : 'none';
    });

    const firstMatch = document.querySelector(`#subcategory_id option[data-category="${categoryId}"]`);
    if (firstMatch) firstMatch.selected = true;
}
document.addEventListener('DOMContentLoaded', () => {
    const selectedCategory = document.getElementById('category_id').value;
    filterSubcategories(selectedCategory);
});
</script>
@endsection
