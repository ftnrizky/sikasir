@extends('layouts.admin')

@section('content')
<div class="ml-64 mt-20 p-6 max-w-lg mx-auto bg-white rounded-lg shadow">
    <h1 class="text-2xl font-semibold mb-4">Tambah Bahan Baku</h1>
    <form action="{{ route('admin.ingredients.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Bahan</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-3">
            <label>Satuan</label>
            <input type="text" name="unit" class="w-full border p-2 rounded" placeholder="contoh: kg, liter, pcs" required>
        </div>
        <div class="mb-3">
            <label>Stok Awal</label>
            <input type="number" name="stock" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-3">
            <label>Lokasi</label>
            <select name="location" class="w-full border p-2 rounded" required>
                <option value="bar">Bar</option>
                <option value="kitchen">Kitchen</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
