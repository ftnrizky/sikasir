@extends('layouts.admin')

@section('content')
    @php
        use SimpleSoftwareIO\QrCode\Facades\QrCode;
    @endphp

    <div class=" p-6 overflow-x-hidden bg-gradient-to-r from-amber-50 to-amber-100 text-gray-900 min-h-screen">
        <h1 class="text-3xl font-playfair mb-6 text-amber-900 animate__animated animate__fadeIn">Daftar Produk</h1>

        <a href="{{ route('products.create') }}"
            class="bg-amber-700 text-white px-6 py-3 rounded-lg hover:bg-amber-800 mb-6 inline-block transition-all duration-300 hover:shadow-lg font-poppins">
            <i class="fas fa-plus mr-2"></i>Tambah Produk
        </a>

        <div class="bg-white rounded-xl shadow-xl p-6 overflow-x-auto animate__animated animate__fadeInUp">
            <table id="productsTable" class="w-full">
                <thead class="bg-amber-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-amber-900 font-semibold">Nama</th>
                        <th class="py-3 px-4 text-left text-amber-900 font-semibold">Kategori</th>
                        <th class="py-3 px-4 text-left text-amber-900 font-semibold">Barcode</th>
                        <th class="py-3 px-4 text-left text-amber-900 font-semibold">Harga Modal</th>
                        <th class="py-3 px-4 text-left text-amber-900 font-semibold">Harga Jual</th>
                        <th class="py-3 px-4 text-left text-amber-900 font-semibold">Margin</th>
                        <th class="py-3 px-4 text-left text-amber-900 font-semibold">Image</th>
                        <th class="py-3 px-4 text-left text-amber-900 font-semibold">QR Code</th>
                        <th class="py-3 px-4 text-left text-amber-900 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-t hover:bg-amber-50 transition-colors duration-200">
                            <td class="py-3 px-4">{{ $product->name }}</td>
                            <td class="py-3 px-4">
                                {{ $product->category ? $product->category->name : 'Tanpa Kategori' }}
                            </td>
                            <td class="py-3 px-4">{{ $product->barcode }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($product->harga_modal, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($product->margin, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-center">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-16 h-16 object-cover rounded-lg inline hover:scale-150 transition-transform duration-300">
                                @else
                                    <span class="text-gray-400">No Image</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if ($product->barcode)
                                    <div class="hover:scale-150 transition-transform duration-300">
                                        {!! QrCode::size(60)->generate($product->barcode) !!}
                                    </div>
                                @else
                                    <span class="text-gray-400">No Barcode</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition-colors duration-300">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <button onclick="deleteProduct({{ $product->id }})"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-300">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>

                                    <!-- Form Hapus (Hidden) -->
                                    <form id="delete-form-{{ $product->id }}"
                                        action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-8">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Poppins:wght@300;400;500&display=swap">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <style>
            .font-playfair {
                font-family: 'Playfair Display', serif;
            }
            .font-poppins {
                font-family: 'Poppins', sans-serif;
            }
            @media (max-width: 1024px) {
                .ml-64 {
                    margin-left: 0;
                }
                table {
                    font-size: 14px;
                }
                .flex.space-x-2 {
                    flex-direction: column;
                    gap: 0.5rem;
                }
            }
        </style>
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
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
