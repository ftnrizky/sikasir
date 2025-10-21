@extends('layouts.admin')

@section('content')
<div class=" p-6 bg-gray-100 min-h-screen">
    <h1 class="text-2xl font-bold mb-4 text-black">Edit Kategori</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm font-bold mb-2">Nama Kategori</label>
                <input type="text" id="name" name="name" value="{{ $category->name }}"
                    class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-blue-300"
                    required>
            </div>

            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                <i class="fas fa-save mr-2"></i>Update
            </button>
            <a href="{{ route('admin.categories.index') }}"
                class="ml-2 bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded shadow">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
Swal.fire('Berhasil!', '{{ session(' success ') }}', 'success');
</script>
@endif
@endpush