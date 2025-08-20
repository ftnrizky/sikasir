<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Laravel Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- Custom Styles Stack --}}
    @stack('styles')
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('components.sidebar')

        <div class="flex-1 flex flex-col">
            {{-- Navbar --}}
            @include('components.navbar')

            {{-- Main Content --}}
            <main class="flex-1 p-4 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- jQuery & DataTables JS --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    {{-- Feather Icons (Opsional) --}}
    <script>
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    </script>

    {{-- Custom Scripts Stack --}}
    @stack('scripts')

    {{-- Optional Section Script --}}
    @yield('script')
</body>

</html>