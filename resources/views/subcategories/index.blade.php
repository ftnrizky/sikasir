@extends('layouts.app')

@section('content')
<div class="ml-64 p-6 overflow-x-hidden bg-gray-100 text-gray-900">
    <h1 class="text-2xl font-bold mb-4 text-white">Daftar SubKategori</h1>

    <a href="{{ route('subcategories.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">
        <i class="fas fa-plus mr-2"></i>Tambah SubKategori
    </a>

    <div class="bg-white rounded-lg shadow-md p-6 overflow-x-auto">
        <table id="categoriesTable" class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left">Nama SubKategori</th>
                    <th class="py-2 px-4 text-left">Deskripsi</th>
                    <th class="py-2 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subcategories as $subcategory)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ $subcategory->name }}</td>
                    <td class="py-2 px-4">{{ $subcategory->description }}</td>
                    <td class="py-2 px-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('subcategories.edit', $subcategory->id) }}"
                                class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="delete-category-form-{{ $subcategory->id }}"
                                action="{{ route('subcategories.destroy', $subcategory->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button onclick="deleteCategory({{ $subcategory->id }})"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500 py-4">Belum ada subkategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        }
    });
});

function deleteCategory(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data kategori akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-category-form-' + id).submit();
        }
    });
}
</script>
@endpush