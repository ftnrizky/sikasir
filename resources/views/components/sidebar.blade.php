<aside class="sidebar fixed left-0 top-0 h-full w-64 bg-amber-900 shadow-lg z-50 overflow-y-auto">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex flex-col items-center p-2 border-b border-gray-200">
            <div class="w-40 h-40 bg-amber-900 rounded-lg flex items-center justify-center mb-1">
                <img src="{{ asset('assets/image/logocafe.png') }}" alt="Logo" class="w-36 h-36 object-contain p-1">
            </div>
            <div class="text-center">
                <h1 class="text-2xl font-semibold text-fuchsia-50">Ali Akbar </h1>
                <p class="text-sm text-fuchsia-50">Shisa & Coffe Shop</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 bg-amber-900 font-poppins">
            <ul class="space-y-2">
                <li><a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 bg-amber-950 rounded-lg"><i
                            class="bi bi-house-door"></i><span class="font-medium">Dashboard</span></a></li>
                <li><a href="{{ route('products.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 hover:bg-amber-950 rounded-lg"><i
                            class="bi bi-cart"></i><span>Produk</span></a></li>
                <li class="relative">
                    <button
                        class="w-full flex items-center gap-3 px-4 py-3 text-fuchsia-50 hover:bg-amber-950 rounded-lg">
                        <i class="bi bi-list"></i>
                        <span>Kelola Kategori</span>
                        <i class="bi bi-chevron-down ml-auto transition-transform duration-200"></i>
                    </button>
                    <ul class="hidden mt-2 bg-amber-800 rounded-lg overflow-hidden">
                        <li>
                            <a href="{{ route('admin.categories.index') }}"
                                class="block px-4 py-3 text-fuchsia-50 hover:bg-amber-950 pl-11">
                                Kategori Menu
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.subcategories.index') }}"
                                class="block px-4 py-3 text-fuchsia-50 hover:bg-amber-950 pl-11">
                                Sub Kategori
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('kasir.transaksi.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 hover:bg-amber-950 rounded-lg"><i
                            class="bi bi-receipt"></i><span>Kasir</span></a></li>
                <li><a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 hover:bg-amber-950 rounded-lg"><i
                            class="bi bi-receipt"></i><span>Transaksi</span></a></li>
                <li><a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 hover:bg-amber-950 rounded-lg"><i
                            class="bi bi-bar-chart"></i><span>Laporan</span></a></li>
                <li><a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 hover:bg-amber-950 rounded-lg"><i
                            class="bi bi-people"></i><span>Pengguna</span></a></li>
                <li><a href="#"
                        class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 hover:bg-amber-950 rounded-lg"><i
                            class="bi bi-gear"></i><span>Pengaturan</span></a></li>
            </ul>
        </nav>

        <!-- Logout -->
        <div class="mt-auto p-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}"
                class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 hover:bg-amber-950 rounded-lg">
                @csrf
                <i class="bi bi-box-arrow-right"></i>
                <button type="submit" class="flex-1 text-left">{{ __('Log Out') }}</button>
            </form>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButtons = document.querySelectorAll('.relative button');

        dropdownButtons.forEach(button => {
            const dropdownMenu = button.nextElementSibling;
            const icon = button.querySelector('.bi-chevron-down');

            // Toggle dropdown dengan click
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Tutup dropdown lain
                dropdownButtons.forEach(otherButton => {
                    if (otherButton !== button) {
                        const otherMenu = otherButton.nextElementSibling;
                        const otherIcon = otherButton.querySelector('.bi-chevron-down');
                        otherMenu.classList.add('hidden');
                        otherIcon.style.transform = 'rotate(0deg)';
                    }
                });

                // Toggle current dropdown
                dropdownMenu.classList.toggle('hidden');
                icon.style.transform = dropdownMenu.classList.contains('hidden') ?
                    'rotate(0deg)' : 'rotate(180deg)';
            });
        });

        // Tutup dropdown ketika mengklik di luar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                dropdownButtons.forEach(button => {
                    const dropdownMenu = button.nextElementSibling;
                    const icon = button.querySelector('.bi-chevron-down');
                    dropdownMenu.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                });
            }
        });

        // Tutup dropdown ketika menekan tombol Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                dropdownButtons.forEach(button => {
                    const dropdownMenu = button.nextElementSibling;
                    const icon = button.querySelector('.bi-chevron-down');
                    dropdownMenu.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                });
            }
        });
    });
</script>

<style>
    .relative ul {
        transition: all 0.3s ease-in-out;
    }

    .relative button .bi-chevron-down {
        transition: transform 0.3s ease;
    }

    .relative ul {
        margin-top: 0;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease-in-out;
    }

    .relative ul.hidden {
        margin-top: -10px;
        opacity: 0;
        visibility: hidden;
    }

    .relative ul:not(.hidden) {
        margin-top: 0;
        opacity: 1;
        visibility: visible;
    }
</style>