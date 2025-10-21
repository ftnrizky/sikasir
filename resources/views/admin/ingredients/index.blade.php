@extends('layouts.admin')

@section('content')
<div class="ml-64 p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Daftar Bahan Baku</h1>
        @role('admin')
        <a href="{{ route('admin.ingredients.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg">Tambah Bahan</a>
        @endrole
    </div>

    <table class="min-w-full bg-white rounded-lg shadow">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Unit</th>
                <th class="px-4 py-2">Stok</th>
                <th class="px-4 py-2">Lokasi</th>
                <th class="px-4 py-2">Status</th>
                @role('admin')
                <th class="px-4 py-2">Aksi</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach ($ingredients as $ingredient)
            <tr class="border-b hover:bg-gray-100">
                <td class="px-4 py-2">{{ $ingredient->name }}</td>
                <td class="px-4 py-2">{{ $ingredient->unit }}</td>
                <td class="px-4 py-2">{{ $ingredient->stock }}</td>
                <td class="px-4 py-2 capitalize">{{ $ingredient->location }}</td>
                <td class="px-4 py-2">
                    <span class="{{ $ingredient->is_available ? 'text-green-600' : 'text-red-600' }}">
                        {{ $ingredient->is_available ? 'Tersedia' : 'Habis' }}
                    </span>
                </td>
                @role('admin')
                <td class="px-4 py-2 flex gap-2">
                    <a href="{{ route('admin.ingredients.edit', $ingredient->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded">Edit</a>
                    <form action="{{ route('admin.ingredients.destroy', $ingredient->id) }}" method="POST" onsubmit="return confirm('Yakin hapus bahan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                    </form>
                </td>
                @endrole
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
