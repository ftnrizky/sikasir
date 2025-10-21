 @extends('layouts.admin')
 <!DOCTYPE html>
 <html lang="id">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Dashboard Admin</title>
     <script src="https://cdn.tailwindcss.com"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <style>
         ::-webkit-scrollbar {
             width: 4px;
         }

         ::-webkit-scrollbar-track {
             background: #f1f1f1;
         }

         ::-webkit-scrollbar-thumb {
             background: #005281;
             border-radius: 2px;
         }

         ::-webkit-scrollbar-thumb:hover {
             background: #003d61;
         }

         .sidebar {
             transition: transform 0.3s ease-in-out;
         }

         @media (max-width: 1023px) {
             .sidebar {
                 transform: translateX(-100%);
             }

             .sidebar.active {
                 transform: translateX(0);
             }
         }

         .overlay {
             display: none;
         }

         @media (max-width: 1023px) {
             .overlay.active {
                 display: block;
             }
         }
     </style>
 </head>

 <body class="h-screen overflow-hidden flex bg-stone-50">

     <!-- Sidebar -->
     @include('components.sidebar')

     <!-- Overlay for mobile -->
     <div class="overlay fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden" onclick="closeSidebar()"
         id="overlay"></div>

     <!-- Main content -->
     <div class="flex-1 flex flex-col ml-64">

         <!-- Navbar -->
         @include('components.navbar')

         <!-- Content -->
         <main class="mt-16 overflow-y-auto h-[calc(100vh-4rem)] p-4">
             @yield('content')
             @php
                 use Illuminate\Support\Facades\Auth;
                 use Carbon\Carbon;

                 $user = Auth::user();
                 $today = Carbon::now()->locale('id')->translatedFormat('l, d F Y');
             @endphp

             <div class="bg-white p-6 rounded-xl shadow-lg mb-6 relative overflow-hidden">
                 <div class="absolute right-0 top-0 w-32 h-32 bg-[#005281]/5 rounded-bl-full"></div>

                 <div class="flex items-center gap-6 relative">
                     {{-- Foto atau Icon --}}
                     @if ($user->profile_image ?? false)
                         <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Foto Profil"
                             class="w-16 h-16 rounded-full object-cover border-2 border-[#005281]">
                     @else
                         <div class="flex items-center justify-center w-16 h-16 bg-[#005281]/10 rounded-full">
                             <i class="bi bi-person-circle text-4xl text-[#005281]"></i>
                         </div>
                     @endif

                     <div class="space-y-2">
                         {{-- Nama dan Role --}}
                         <div class="flex items-center gap-3">
                             <h2 class="text-2xl font-semibold text-gray-700">Halo {{ $user->name ?? 'User' }}!</h2>
                             @if ($user->role ?? false)
                                 <span class="px-3 py-1 text-sm bg-[#005281]/10 text-[#005281] rounded-full capitalize">
                                     {{ $user->role }}
                                 </span>
                             @endif
                         </div>

                         {{-- Tanggal Sekarang --}}
                         <div class="flex items-center gap-2 text-sm text-gray-500">
                             <i class="bi bi-clock"></i>
                             <span>{{ $today }}</span>
                         </div>

                         {{-- Pesan Selamat Datang --}}
                         <p class="text-gray-600 text-sm">
                             Selamat datang di dashboard untuk melihat data real-time dan performa bisnis Anda.
                         </p>
                     </div>
                 </div>
             </div>


             {{-- <div class="bg-white p-6 rounded-xl shadow-lg mb-6">
                 <div class="space-y-6">
                     <div>
                         <h3 class="text-lg font-semibold text-gray-700 mb-4">Filter Periode</h3>
                         <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                             <button onclick="applyPreset('today')" data-preset="today"
                                 class="px-4 py-2.5 text-sm font-medium text-white bg-[#003d61] rounded-lg hover:bg-[#002a45] focus:outline-none focus:ring-2 focus:ring-[#005281] transition-all duration-200">
                                 <div class="flex items-center justify-center gap-2">
                                     <i class="bi bi-calendar-event"></i>
                                     <span>Hari Ini</span>
                                 </div>
                             </button>
                             <button onclick="applyPreset('yesterday')" data-preset="yesterday"
                                 class="px-4 py-2.5 text-sm font-medium text-white bg-[#005281] rounded-lg hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] transition-all duration-200">
                                 <div class="flex items-center justify-center gap-2">
                                     <i class="bi bi-calendar-minus"></i>
                                     <span>Kemarin</span>
                                 </div>
                             </button>
                             <button onclick="applyPreset('last7days')" data-preset="last7days"
                                 class="px-4 py-2.5 text-sm font-medium text-white bg-[#005281] rounded-lg hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] transition-all duration-200">
                                 <div class="flex items-center justify-center gap-2">
                                     <i class="bi bi-calendar-week"></i>
                                     <span>7 Hari</span>
                                 </div>
                             </button>
                             <button onclick="applyPreset('last30days')" data-preset="last30days"
                                 class="px-4 py-2.5 text-sm font-medium text-white bg-[#005281] rounded-lg hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] transition-all duration-200">
                                 <div class="flex items-center justify-center gap-2">
                                     <i class="bi bi-calendar3"></i>
                                     <span>30 Hari</span>
                                 </div>
                             </button>
                             <button onclick="applyPreset('thisMonth')" data-preset="thisMonth"
                                 class="px-4 py-2.5 text-sm font-medium text-white bg-[#005281] rounded-lg hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] transition-all duration-200">
                                 <div class="flex items-center justify-center gap-2">
                                     <i class="bi bi-calendar-check"></i>
                                     <span>Bulan Ini</span>
                                 </div>
                             </button>
                             <button onclick="applyPreset('lastMonth')" data-preset="lastMonth"
                                 class="px-4 py-2.5 text-sm font-medium text-white bg-[#005281] rounded-lg hover:bg-[#003d61] focus:outline-none focus:ring-2 focus:ring-[#005281] transition-all duration-200">
                                 <div class="flex items-center justify-center gap-2">
                                     <i class="bi bi-calendar2-check"></i>
                                     <span>Bulan Lalu</span>
                                 </div>
                             </button>
                         </div>
                     </div>
                 </div>
             </div> --}}
         </main>
     </div>

     <script>
         // Sidebar toggle functionality
         function toggleSidebar() {
             const sidebar = document.querySelector('.sidebar');
             const overlay = document.querySelector('.overlay');

             sidebar.classList.toggle('active');
             overlay.classList.toggle('active');
         }

         function closeSidebar() {
             const sidebar = document.querySelector('.sidebar');
             const overlay = document.querySelector('.overlay');

             sidebar.classList.remove('active');
             overlay.classList.remove('active');
         }

         // Progress bar functionality
         function updateProgress() {
             const checkboxes = document.querySelectorAll('input[type="checkbox"]');
             const completed = Array.from(checkboxes).filter(cb => cb.checked).length;
             const total = checkboxes.length;
             const percentage = Math.round((completed / total) * 100);

             document.getElementById('progressPercentage').textContent = percentage + '%';
             document.getElementById('progressBar').style.width = percentage + '%';
             document.getElementById('completedTasks').textContent = completed;
             document.getElementById('pendingTasks').textContent = total - completed;
         }

         // Clear completed tasks
         function clearCompletedTasks() {
             const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
             checkboxes.forEach(checkbox => {
                 checkbox.closest('.todo-item').style.opacity = '0.5';
                 setTimeout(() => {
                     checkbox.checked = false;
                     checkbox.closest('.todo-item').style.opacity = '1';
                     updateProgress();
                 }, 300);
             });
         }

         // Date filter functionality
         function applyPreset(preset) {
             // Remove active class from all buttons
             document.querySelectorAll('[data-preset]').forEach(btn => {
                 btn.classList.remove('bg-[#003d61]');
                 btn.classList.add('bg-[#005281]');
             });

             // Add active class to clicked button
             document.querySelector(`[data-preset="${preset}"]`).classList.add('bg-[#003d61]');
             document.querySelector(`[data-preset="${preset}"]`).classList.remove('bg-[#005281]');

             const today = new Date();
             let startDate, endDate;

             switch (preset) {
                 case 'today':
                     startDate = endDate = today.toISOString().split('T')[0];
                     break;
                 case 'yesterday':
                     const yesterday = new Date(today);
                     yesterday.setDate(yesterday.getDate() - 1);
                     startDate = endDate = yesterday.toISOString().split('T')[0];
                     break;
                 case 'last7days':
                     const week = new Date(today);
                     week.setDate(week.getDate() - 7);
                     startDate = week.toISOString().split('T')[0];
                     endDate = today.toISOString().split('T')[0];
                     break;
                 case 'last30days':
                     const month = new Date(today);
                     month.setDate(month.getDate() - 30);
                     startDate = month.toISOString().split('T')[0];
                     endDate = today.toISOString().split('T')[0];
                     break;
                 case 'thisMonth':
                     startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                     endDate = today.toISOString().split('T')[0];
                     break;
                 case 'lastMonth':
                     const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                     const lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);
                     startDate = lastMonth.toISOString().split('T')[0];
                     endDate = lastMonthEnd.toISOString().split('T')[0];
                     break;
             }

             document.getElementById('startDate').value = startDate;
             document.getElementById('endDate').value = endDate;

             // Update data based on selected date range
             updateDashboardData();
         }

         function handleDateChange() {
             // Remove active state from preset buttons when custom date is selected
             document.querySelectorAll('[data-preset]').forEach(btn => {
                 btn.classList.remove('bg-[#003d61]');
                 btn.classList.add('bg-[#005281]');
             });
             updateDashboardData();
         }

         function updateDashboardData() {
             // This would typically fetch data from your backend
             // For now, we'll just simulate data updates
             console.log('Updating dashboard data...');
         }

         // Initialize chart
         function initChart() {
             const ctx = document.getElementById('comboChart').getContext('2d');

             new Chart(ctx, {
                 type: 'line',
                 data: {
                     labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                     datasets: [{
                         label: 'Modal',
                         data: [12, 19, 3, 5, 2, 3, 7],
                         borderColor: '#005281',
                         backgroundColor: 'rgba(0, 82, 129, 0.1)',
                         tension: 0.4
                     }, {
                         label: 'Pendapatan',
                         data: [15, 25, 8, 12, 7, 10, 15],
                         borderColor: '#0077b6',
                         backgroundColor: 'rgba(0, 119, 182, 0.1)',
                         tension: 0.4
                     }, {
                         label: 'Keuntungan',
                         data: [3, 6, 5, 7, 5, 7, 8],
                         borderColor: '#00b4d8',
                         backgroundColor: 'rgba(0, 180, 216, 0.1)',
                         tension: 0.4
                     }]
                 },
                 options: {
                     responsive: true,
                     maintainAspectRatio: false,
                     plugins: {
                         legend: {
                             position: 'top',
                         }
                     },
                     scales: {
                         y: {
                             beginAtZero: true,
                             grid: {
                                 color: 'rgba(0, 0, 0, 0.1)'
                             }
                         },
                         x: {
                             grid: {
                                 color: 'rgba(0, 0, 0, 0.1)'
                             }
                         }
                     }
                 }
             });
         }

         document.addEventListener('DOMContentLoaded', function() {
             // Set default date to today
             applyPreset('today');

             // Initialize chart
             initChart();

             // Close sidebar when clicking outside on mobile
             document.addEventListener('click', function(e) {
                 const sidebar = document.querySelector('.sidebar');
                 const mobileToggle = document.querySelector('.lg\\:hidden button');

                 if (window.innerWidth < 1024 &&
                     !sidebar.contains(e.target) &&
                     !mobileToggle.contains(e.target) &&
                     sidebar.classList.contains('active')) {
                     closeSidebar();
                 }
             });

             // Handle window resize
             window.addEventListener('resize', function() {
                 if (window.innerWidth >= 1024) {
                     closeSidebar();
                 }
             });
         });
     </script>

 </body>

 </html>

 <!-- Main Content -->
 <!-- <main class="p-4 lg:p-8"> -->


 <!-- <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Pilih Tanggal Kustom</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Awal</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="bi bi-calendar3 text-gray-400"></i>
                                    </div>
                                    <input type="date" id="startDate"
                                        class="block w-full pl-10 pr-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#005281] focus:border-[#005281] transition-colors duration-200"
                                        onchange="handleDateChange()">
                                </div>
                            </div>
                            <div class="relative">
                                <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Akhir</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="bi bi-calendar3 text-gray-400"></i>
                                    </div>
                                    <input type="date" id="endDate"
                                        class="block w-full pl-10 pr-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#005281] focus:border-[#005281] transition-colors duration-200"
                                        onchange="handleDateChange()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

 <!-- Stats Cards -->
 <!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6"> -->
 <!-- Total Modal -->
 <!-- <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex justify-between items-start">
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <div class="p-2 bg-[#005281]/10 rounded-lg">
                                    <i class="bi bi-cart text-2xl text-[#005281]"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-700">Total Modal</h3>
                            </div>
                            <p class="text-3xl font-bold text-[#005281]" id="totalModal">Rp12.500</p>
                            <div class="flex flex-col gap-1">
                                <p class="text-green-500 text-sm">0.00% (+Rp12.500) dibanding periode sebelumnya</p>
                                <p class="text-gray-500 text-sm">(+Rp12.500) dengan periode sebelumnya</p>
                            </div>
                        </div>
                    </div>
                </div> -->

 <!-- Total Pendapatan -->
 <!-- <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex justify-between items-start">
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <div class="p-2 bg-[#0077b6]/10 rounded-lg">
                                    <i class="bi bi-bar-chart text-2xl text-[#0077b6]"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-700">Total Pendapatan</h3>
                            </div>
                            <p class="text-3xl font-bold text-[#0077b6]" id="totalPendapatan">Rp20.000</p>
                            <div class="flex flex-col gap-1">
                                <p class="text-green-500 text-sm">0.00% (+Rp20.000) dibanding periode sebelumnya</p>
                                <p class="text-gray-500 text-sm">(+Rp20.000) dengan periode sebelumnya</p>
                            </div>
                        </div>
                    </div>
                </div> -->

 <!-- Total Keuntungan -->
 <!-- <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex justify-between items-start">
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <div class="p-2 bg-[#00b4d8]/10 rounded-lg">
                                    <i class="bi bi-cash-stack text-2xl text-[#00b4d8]"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-700">Total Keuntungan</h3>
                            </div>
                            <p class="text-3xl font-bold text-[#00b4d8]" id="totalKeuntungan">Rp7.500</p>
                            <div class="flex flex-col gap-1">
                                <p class="text-green-500 text-sm">0.00% (+Rp7.500) dibanding periode sebelumnya</p>
                                <p class="text-gray-500 text-sm">(+Rp7.500) dengan periode sebelumnya</p>
                            </div>
                        </div>
                    </div>
                </div> -->
 <!-- </div> -->

 <!-- Chart Container -->
 <!-- <div class="bg-white p-6 rounded-xl shadow-lg mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-[#005281]/10 rounded-lg">
                        <i class="bi bi-graph-up text-xl text-[#005281]"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-700">Grafik Performa</h2>
                </div>
                <canvas id="comboChart" style="height: 400px;"></canvas>
            </div> -->

 <!-- To-Do List and Progress Section -->
 <!-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- To-Do List -->
 <!-- <div class="bg-white p-6 rounded-xl shadow-lg">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-[#005281]/10 rounded-lg">
                            <i class="bi bi-list-check text-xl text-[#005281]"></i>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-700">To-Do List</h2>
                    </div>
                    <button onclick="clearCompletedTasks()"
                        class="text-sm text-[#005281] hover:text-[#003d61] transition-colors duration-200">
                        Clear Completed
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="todo-item group">
                        <label
                            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" id="task1"
                                class="form-checkbox h-5 w-5 text-[#005281] border-gray-300 rounded focus:ring-2 focus:ring-[#005281] transition-colors duration-200"
                                onchange="updateProgress()">
                            <div class="ml-4 flex-1">
                                <span
                                    class="text-gray-700 font-medium group-hover:text-[#005281] transition-colors">Buka
                                    Toko</span>
                                <p class="text-sm text-gray-500">Pukul 10:00 WIB</p>
                            </div>
                            <span class="px-2.5 py-0.5 text-sm bg-blue-100 text-blue-800 rounded-full">Pagi</span>
                        </label>
                    </div>

                    <div class="todo-item group">
                        <label
                            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" id="task2"
                                class="form-checkbox h-5 w-5 text-[#005281] border-gray-300 rounded focus:ring-2 focus:ring-[#005281] transition-colors duration-200"
                                onchange="updateProgress()">
                            <div class="ml-4 flex-1">
                                <span
                                    class="text-gray-700 font-medium group-hover:text-[#005281] transition-colors">Persiapan</span>
                                <p class="text-sm text-gray-500">Bersih-bersih & Prepare</p>
                            </div>
                            <span
                                class="px-2.5 py-0.5 text-sm bg-yellow-100 text-yellow-800 rounded-full">Prioritas</span>
                        </label>
                    </div>

                    <div class="todo-item group">
                        <label
                            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" id="task3"
                                class="form-checkbox h-5 w-5 text-[#005281] border-gray-300 rounded focus:ring-2 focus:ring-[#005281] transition-colors duration-200"
                                onchange="updateProgress()">
                            <div class="ml-4 flex-1">
                                <span
                                    class="text-gray-700 font-medium group-hover:text-[#005281] transition-colors">Istirahat</span>
                                <p class="text-sm text-gray-500">Jam Makan Siang</p>
                            </div>
                            <span class="px-2.5 py-0.5 text-sm bg-green-100 text-green-800 rounded-full">Siang</span>
                        </label>
                    </div>

                    <div class="todo-item group">
                        <label
                            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer">
                            <input type="checkbox" id="task4"
                                class="form-checkbox h-5 w-5 text-[#005281] border-gray-300 rounded focus:ring-2 focus:ring-[#005281] transition-colors duration-200"
                                onchange="updateProgress()">
                            <div class="ml-4 flex-1">
                                <span
                                    class="text-gray-700 font-medium group-hover:text-[#005281] transition-colors">Tutup
                                    Toko</span>
                                <p class="text-sm text-gray-500">Pukul 10:00 WIB</p>
                            </div>
                            <span class="px-2.5 py-0.5 text-sm bg-purple-100 text-purple-800 rounded-full">Malam</span>
                        </label>
                    </div>
                </div>
            </div> -->

 <!-- Progress Section -->
 <!-- <div class="bg-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-[#005281]/10 rounded-lg">
                        <i class="bi bi-graph-up text-xl text-[#005281]"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-700">Progress Hari Ini</h2>
                </div>

                <div class="space-y-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Penyelesaian Tugas</h3>
                            <p class="text-xs text-gray-500">Total 4 tugas hari ini</p>
                        </div>
                        <span id="progressPercentage" class="text-lg font-semibold text-[#005281]">0%</span>
                    </div>

                    <div class="relative">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div id="progressBar"
                                class="bg-gradient-to-r from-[#005281] to-[#0077b6] h-3 rounded-full transition-all duration-500 ease-in-out shadow-sm"
                                style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500">Selesai</p>
                            <p id="completedTasks" class="text-xl font-semibold text-[#005281]">0</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500">Pending</p>
                            <p id="pendingTasks" class="text-xl font-semibold text-gray-700">4</p>
                        </div>
                    </div>

                    <!-- Quote of the Day -->
 <!-- <div class="mt-6 p-4 bg-[#005281]/5 rounded-xl">
                <div class="flex items-start gap-3">
                    <i class="bi bi-quote text-3xl text-[#005281]/70"></i>
                    <div class="space-y-2">
                        <p class="text-gray-600 text-sm italic">"Kesuksesan bisnis bukan tentang
                            keberuntungan. Ini tentang melihat peluang dan mengambil tindakan."</p>
                        <p class="text-sm font-medium text-[#005281]">- Richard Branson</p>
                    </div>
                </div>
            </div>
    </div>
    </div> -->
 <!-- </div> -->

 <!-- Footer -->
 <!-- <footer class="text-gray-400 text-center py-4 mt-8">
         <p>Copyright © 2024 atan. All Rights Reserved.</p>
     </footer>
 </main> -->
