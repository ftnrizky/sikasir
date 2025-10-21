@extends('layouts.admin')

@section('content')
<div class="ml-64 mt-28 p-6">
    <h1 class="text-2xl font-bold mb-6 text-amber-800">Tambah Meja Baru</h1>

    <div class="max-w-md p-6 bg-white rounded-lg shadow-lg border-2 border-amber-600 animate-border relative">
        <form action="{{ route('tables.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-amber-900 font-medium mb-2">Nama Meja</label>
                <input type="text" 
                    id="name" 
                    name="name" 
                    class="w-full px-4 py-2 rounded-lg border border-amber-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 outline-none"
                    required>
            </div>
            <button type="submit" 
                class="w-full bg-gradient-to-r from-amber-600 to-amber-800 text-white py-2 px-6 rounded-lg hover:from-amber-700 hover:to-amber-900 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-amber-300/50">
                Simpan
            </button>
        </form>
    </div>
</div>

<style>
    @keyframes borderGlow {
        0% { box-shadow: 0 0 5px #c2855a, 0 0 10px #b36a31, 0 0 15px #8b4513; }
        50% { box-shadow: 0 0 10px #c2855a, 0 0 20px #b36a31, 0 0 30px #8b4513; }
        100% { box-shadow: 0 0 5px #c2855a, 0 0 10px #b36a31, 0 0 15px #8b4513; }
    }

    .animate-border {
        animation: borderGlow 2s infinite;
    }

    .animate-border:hover {
        transform: translateY(-2px);
        transition: transform 0.3s ease;
    }
</style>
@endsection
