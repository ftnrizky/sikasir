<aside id="sidebar"
    class="sidebar fixed top-0 left-0 h-full w-64 bg-[#ab5c16] text-white shadow-lg z-50 transform transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 overflow-y-auto">
    <div class="flex flex-col h-full">
        <!-- Header -->
        <div class="flex flex-col items-center p-2 border-b border-gray-200/20">
            <div class="w-40 h-40 bg-[#ab5c16] rounded-lg flex items-center justify-center mb-1">
                <img src="{{ asset('assets/image/logocafe.png') }}" alt="Logo" class="w-36 h-36 object-contain p-1">
            </div>
            <div class="text-center">
                <h1 class="text-2xl font-semibold text-fuchsia-50">Ali Akbar</h1>
                <p class="text-sm text-fuchsia-50">Shisa & Coffee Shop</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 bg-[#ab5c16] font-poppins">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 rounded-lg nav-link">
                        <i class="bi bi-house-door"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 rounded-lg nav-link">
                        <i class="bi bi-cart"></i>
                        <span>Produk</span>
                    </a>
                </li>

                <!-- Dropdown: Manajemen Stock -->
                <li class="relative dropdown-container">
                    <button type="button" class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 rounded-lg nav-link dropdown-button">
                        <i class="bi bi-box-seam"></i>
                        <span>Manajemen Stock</span>
                        <i class="bi bi-chevron-down ml-auto chevron-icon"></i>
                    </button>
                    <ul class="dropdown-menu hidden mt-1 space-y-1 pl-4">
                        <li><a href="{{ route('admin.ingredients.index') }}" class="block px-4 py-2 rounded-md hover:bg-[#8b4513]/60">Bahan Baku</a></li>
                        <li><a href="{{ route('admin.subcategories.index') }}" class="block px-4 py-2 rounded-md hover:bg-[#8b4513]/60">Manajemen Stok</a></li>
                        <li><a href="{{ route('admin.subcategories.index') }}" class="block px-4 py-2 rounded-md hover:bg-[#8b4513]/60">Relasi Produk - Bahan</a></li>
                    </ul>
                </li>

                <!-- Dropdown: Kelola Kategori -->
                <li class="relative dropdown-container">
                    <button type="button" class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 rounded-lg nav-link dropdown-button">
                        <i class="bi bi-list"></i>
                        <span>Kelola Kategori</span>
                        <i class="bi bi-chevron-down ml-auto chevron-icon"></i>
                    </button>
                    <ul class="dropdown-menu hidden mt-1 space-y-1 pl-4">
                        <li><a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 rounded-md hover:bg-[#8b4513]/60">Kategori Menu</a></li>
                        <li><a href="{{ route('admin.subcategories.index') }}" class="block px-4 py-2 rounded-md hover:bg-[#8b4513]/60">Sub Kategori</a></li>
                    </ul>
                </li>

                <li><a href="{{ route('kasir.index') }}" class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 rounded-lg nav-link"><i class="bi bi-receipt"></i><span>Kasir</span></a></li>
                <li><a href="{{ route('kasir.index') }}" class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 rounded-lg nav-link"><i class="bi bi-cash-coin"></i><span>Transaksi</span></a></li>
                <li><a href="{{ route('tables.index') }}" class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 rounded-lg nav-link"><i class="bi bi-table"></i><span>Tables</span></a></li>
                <li><a href="#" class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 rounded-lg nav-link"><i class="bi bi-bar-chart"></i><span>Laporan</span></a></li>
                <li><a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 rounded-lg nav-link"><i class="bi bi-people"></i><span>Pengguna</span></a></li>
                <li><a href="#" class="flex items-center gap-3 px-4 py-3 text-fuchsia-50 rounded-lg nav-link"><i class="bi bi-gear"></i><span>Pengaturan</span></a></li>
            </ul>
        </nav>

        <!-- Logout -->
        <div class="mt-auto p-4 border-t border-gray-200/20">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 text-fuchsia-50 hover:bg-[#8b4513]/60 rounded-lg nav-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="flex-1 text-left">{{ __('Log Out') }}</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Overlay (muncul di mobile saat sidebar aktif) -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 lg:hidden"></div>

<!-- Hamburger Button (tampilkan di navbar atas) -->
<button id="menu-toggle"
    class="fixed top-4 left-4 z-50 lg:hidden bg-[#ab5c16] text-white p-3 rounded-md shadow-md focus:outline-none">
    <i class="bi bi-list text-xl"></i>
</button>

<style>
    .nav-link {
        position: relative;
        overflow: hidden;
        transition: background-color 0.3s ease;
    }
    .nav-link:hover {
        background-color: rgba(120, 53, 15, 0.3);
    }
    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: -100%;
        width: 100%;
        height: 4px;
        background-color: #7d4a1e;
        transition: left 0.3s ease-in-out;
    }
    .nav-link:hover::after {
        left: 0;
    }

    /* Dropdown styling */
    .dropdown-container.active .dropdown-menu {
        display: block !important;
    }
    .dropdown-button {
        width: 100%;
        text-align: left;
    }
    .chevron-icon {
        transition: transform 0.3s ease;
    }
    .dropdown-container.active .chevron-icon {
        transform: rotate(180deg);
    }
</style>

<script>
    // --- Sidebar Responsive ---
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const menuToggle = document.getElementById('menu-toggle');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    // --- Dropdown Menu ---
    document.querySelectorAll('.dropdown-button').forEach(button => {
        button.addEventListener('click', () => {
            const container = button.closest('.dropdown-container');
            container.classList.toggle('active');
        });
    });
</script>
