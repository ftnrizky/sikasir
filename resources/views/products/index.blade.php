@extends('layouts.app')

@section('content')
@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<div class="ml-64 p-6 overflow-x-hidden bg-gray-100 text-gray-900">
    <h1 class="text-2xl font-bold mb-4 text-white">Daftar Produk</h1>

    <a href="{{ route('products.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">
        <i class="fas fa-plus mr-2"></i>Tambah Produk
    </a>

    <div class="bg-white rounded-lg shadow-md p-6 overflow-x-auto">
        <table id="productsTable" class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left">Nama</th>
                    <th class="py-2 px-4 text-left">Kategori</th>
                    <th class="py-2 px-4 text-left">Barcode</th>
                    <th class="py-2 px-4 text-left">Harga</th>
                    <th class="py-2 px-4 text-left">Stok</th>
                    <th class="py-2 px-4 text-left">Image</th>
                    <th class="py-2 px-4 text-left">QR Code</th>
                    <th class="py-2 px-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ $product->name }}</td>
                    <td class="py-2 px-4">
                        {{ $product->category ? $product->category->name : 'Tanpa Kategori' }}
                    </td>
                    <td class="py-2 px-4">{{ $product->barcode }}</td>
                    <td class="py-2 px-4">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="py-2 px-4">{{ $product->stock }}</td>
                    <td class="py-2 px-4 text-center">
                        @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-16 h-16 object-cover rounded inline">
                        @else
                        <span class="text-gray-400">No Image</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 text-center">
                        @if ($product->barcode)
                        {!! QrCode::size(60)->generate($product->barcode) !!}
                        @else
                        <span class="text-gray-400">No Barcode</span>
                        @endif
                    </td>
                    <td class="py-2 px-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('products.edit', $product) }}"
                                class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="delete-form-{{ $product->id }}"
                                action="{{ route('products.destroy', $product->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button onclick="deleteProduct({{ $product->id }})"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-500 py-4">Belum ada produk.</td>
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
    $('#productsTable').DataTable({
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

function deleteProduct(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush