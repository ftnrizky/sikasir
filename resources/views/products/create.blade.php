@extends('layouts.app')

@section('content')
<div class="px-6 py-8">
    <div class="bg-white shadow rounded-xl p-6 w-full max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">Tambah Produk</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="name" id="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode</label>
                <input type="text" name="barcode" id="barcode"
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
                <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select id="category_id" name="category_id" onchange="filterSubcategories(this.value)">
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                        <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}">
                            {{ $subcategory->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:outline-none">
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Simpan
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
@push('scripts')<script>
function filterSubcategories(categoryId) {
    document.querySelectorAll('#subcategory_id option').forEach(option => {
        option.style.display = option.getAttribute('data-category') === categoryId ? 'block' : 'none';
    });

    // Reset pilihan ke yang pertama dari kategori yang dipilih
    const firstMatch = document.querySelector(`#subcategory_id option[data-category="${categoryId}"]`);
    if (firstMatch) firstMatch.selected = true;
}

// Jalankan sekali saat halaman pertama kali load
document.addEventListener('DOMContentLoaded', () => {
    const selectedCategory = document.getElementById('category_id').value;
    filterSubcategories(selectedCategory);
});
</script>
@endpush