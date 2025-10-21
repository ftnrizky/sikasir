<header
    class="fixed top-0 left-64 right-0 z-30 bg-[#ab5c16] text-stone-50 shadow-sm border-b border-gray-200 select-none h-16">
    <div class="flex items-center justify-between px-4 h-full">
        <!-- Mobile Menu -->
        <button class="lg:hidden p-2 text-fuchsia-50 hover:bg-amber-950 rounded-lg" onclick="toggleSidebar()">
            <i class="bi bi-list text-xl"></i>
        </button>

        <!-- Title -->
        <div class="hidden lg:block">
            <h1 class="text-xl font-semibold text-fuchsia-50">Sistem Kasir</h1>
            @if(request()->routeIs('dashboard'))
                <p class="text-sm text-fuchsia-50">Selamat datang, {{ auth()->user()->name }}!</p>
            @endif
        </div>

        <!-- Right Actions -->
        <div class="flex items-center gap-4">
            <!-- Notifications -->
            <button class="relative p-2 text-fuchsia-50 hover:bg-amber-950 rounded-lg">
                <i class="bi bi-bell text-xl"></i>
                <span
                    class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
            </button>

            <!-- Search -->
            <div class="hidden md:flex items-center">
                <div class="relative">
                    <input type="text" placeholder="Cari..."
                        class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-950 focus:border-amber-950">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-fuchsia-50"></i>
                </div>
            </div>

            <!-- Profile -->
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 p-2 hover:bg-amber-950 rounded-lg">
                 @if(request()->routeIs('dashboard'))
                <span class="text-sm font-medium text-fuchsia-50">{{ auth()->user()->name }} -
                    {{ auth()->user()->role }}</span>
                @endif
                <div class="w-8 h-8 bg-gray-800/10 rounded-full flex items-center justify-center">
                    <i class="bi bi-person-circle text-fuchsia-50"></i>
                </div>
            </a>
        </div>
    </div>
</header>