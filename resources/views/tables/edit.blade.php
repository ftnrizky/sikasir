@extends('layouts.admin')

@section('content')
<div class="ml-64 mt-28 p-6">
    <h1 class="text-2xl font-bold mb-6 text-amber-800 transition-all hover:text-amber-600">Edit Meja</h1>

    <div class="relative group">
        <!-- RGB Border Animation Container -->
        <div class="absolute -inset-0.5 bg-gradient-to-r from-pink-600 via-amber-600 to-orange-600 rounded-xl blur opacity-75 group-hover:opacity-100 transition duration-1000 group-hover:duration-200 animate-gradient-xy"></div>
        
        <form action="{{ route('tables.update', $table->id) }}" method="POST" 
              class="relative bg-gradient-to-br from-amber-50 to-white p-6 rounded-xl shadow-2xl max-w-md backdrop-blur-sm transition-all duration-300 hover:shadow-amber-200/50">
            @csrf @method('PUT')
            <div class="mb-6">
                <label class="block text-amber-800 font-semibold mb-2 transition-all hover:text-amber-600">Nama Meja</label>
                <input type="text" name="name" value="{{ $table->name }}" 
                       class="w-full border-2 border-amber-200 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-300 bg-white/80 hover:bg-white"
                       required>
            </div>
            <button type="submit" 
                    class="relative inline-flex items-center justify-center px-6 py-3 overflow-hidden font-bold rounded-lg group bg-gradient-to-br from-amber-600 to-orange-600 text-white transition-all duration-300 hover:from-amber-700 hover:to-orange-700 hover:scale-105 active:scale-95">
                <span class="relative">Update</span>
            </button>
        </form>
    </div>
</div>

<style>
    @keyframes gradient-xy {
        0% {
            background-position: 0% 0%;
        }
        50% {
            background-position: 100% 100%;
        }
        100% {
            background-position: 0% 0%;
        }
    }
    
    .animate-gradient-xy {
        animation: gradient-xy 3s ease infinite;
        background-size: 400% 400%;
    }
</style>
@endsection
