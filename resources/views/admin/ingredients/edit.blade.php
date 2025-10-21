@extends('layouts.admin')

@section('content')
<div class="ml-64 mt-20 p-6 max-w-lg mx-auto bg-white rounded-lg shadow">
    <h1 class="text-2xl font-semibold mb-4">Edit Bahan Baku</h1>
    <form action="{{ route('admin.ingredients.update', $ingredient->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Bahan</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ $ingredient->name }}" required>
        </div>
        <div class="mb-3">
            <label>Satuan</label>
            <input type="text" name="unit" class="w-full border p-2 rounded" value="{{ $ingredient->unit }}" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stock" class="w-full border p-2 rounded" value="{{ $ingredient->stock }}" required>
        </div>
        <div class="mb-3">
            <label>Lokasi</label>
            <select name="location" class="w-full border p-2 rounded" required>
                <option value="bar" {{ $ingredient->location == 'bar' ? 'selected' : '' }}>Bar</option>
                <option value="kitchen" {{ $ingredient->location == 'kitchen' ? 'selected' : '' }}>Kitchen</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="is_available" class="w-full border p-2 rounded">
                <option value="1" {{ $ingredient->is_available ? 'selected' : '' }}>Tersedia</option>
                <option value="0" {{ !$ingredient->is_available ? 'selected' : '' }}>Habis</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Update</button>
    </form>
</div>
@endsection
