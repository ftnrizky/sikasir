@extends('layouts.admin')

@section('content')
<div class="ml-64 mt-28 p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Meja</h1>
        <a href="{{ route('tables.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg shadow">+ Tambah Meja</a>
    </div>

    <div class="grid grid-cols-4 gap-4">
        @foreach($tables as $table)
        <div class="bg-white shadow p-4 rounded-xl text-center">
            <h2 class="font-semibold text-lg mb-2">{{ $table->name }}</h2>
            @if($table->qr_code && file_exists(public_path($table->qr_code)))
                <img src="{{ asset($table->qr_code) }}" alt="QR {{ $table->name }}" class="mx-auto w-32 h-32 mb-2">
            @else
                <p class="text-gray-400">QR tidak tersedia</p>
            @endif
            <div class="flex justify-center gap-2 mt-2">
                <a href="{{ route('tables.edit', $table->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg">Edit</a>
                <form action="{{ route('tables.destroy', $table->id) }}" method="POST" onsubmit="return confirm('Yakin hapus meja ini?')">
                    @csrf @method('DELETE')
                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
