@extends('layouts.admin')

@section('content')
<div class="     p-4 md:p-6 overflow-x-hidden bg-gradient-to-r from-gray-100 to-gray-200 text-gray-900 min-h-screen">
    <h1 class="text-2xl md:text-3xl font-bold mb-6 text-gray-800 border-b-2 border-blue-500 pb-2">
        Daftar Kategori
    </h1>

    {{-- Tombol Tambah Kategori --}}
    <a href="{{ route('admin.categories.create') }}"
        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-2.5 rounded-lg hover:from-blue-600 hover:to-blue-700 transition duration-300 ease-in-out mb-6 inline-flex items-center shadow-lg">
        <i class="fas fa-plus mr-2"></i>Tambah Kategori
    </a>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 overflow-x-auto border border-gray-200">
        <table id="categoriesTable" class="w-full text-sm md:text-base">
            <thead>
                <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <th class="py-3 px-4 text-left font-semibold text-gray-700">Nama Kategori</th>
                    <th class="py-3 px-4 text-left font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-t hover:bg-gray-50 transition duration-150">
                        <td class="py-5 px-4 text-base md:text-lg">{{ $category->name }}</td>
                        <td class="py-3 px-4">
                            <div class="flex space-x-3">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                    class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white px-3 py-2 rounded-lg hover:from-yellow-500 hover:to-yellow-600 transition duration-300 ease-in-out shadow-md flex items-center gap-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                {{-- Tombol Delete --}}
                                <form id="delete-category-form-{{ $category->id }}"
                                    action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button type="button"
                                    onclick="deleteCategory({{ $category->id }})"
                                    class="bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-2 rounded-lg hover:from-red-600 hover:to-red-700 transition duration-300 ease-in-out shadow-md flex items-center gap-1">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center text-gray-500 py-8">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<style>
    /* Custom DataTables Styling */
    .dataTables_wrapper .dataTables_length select {
        @apply rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500;
    }
    .dataTables_wrapper .dataTables_filter input {
        @apply rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        @apply px-3 py-1 mx-1 rounded-lg hover:bg-blue-500 hover:text-white;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        @apply bg-blue-500 text-white;
    }
</style>
@endpush

@push('scripts')
{{-- Pastikan jQuery dan DataTables dimuat --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#categoriesTable').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "›",
                    previous: "‹"
                }
            },
            drawCallback: function() {
                $('.dataTables_wrapper').addClass('md:px-4');
            }
        });
    });

    function deleteCategory(id) {
        if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
            document.getElementById('delete-category-form-' + id).submit();
        }
    }
</script>
@endpush
