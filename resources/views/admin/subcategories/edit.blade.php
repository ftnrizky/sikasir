@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-8">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Edit Subkategori</h2>
    <form action="{{ route('admin.subcategories.update', $subcategory->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Subkategori</label>
            <input type="text" name="name" id="name" value="{{ $subcategory->name }}"
                class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring-orange-500 focus:border-orange-500" required>
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori Induk</label>
            <select name="category_id" id="category_id"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if($subcategory->category_id == $category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit"
            class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 transition-colors">Update</button>
    </form>
</div>
@endsection
