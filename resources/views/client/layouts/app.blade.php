<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/images/logo.jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sofia+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        customColor: "#FF9800",
                        primary: "#007CCA",
                    },
                },
            },
        };
    </script>
    <title>@yield('title', 'Моят профил') - muci7oService</title>
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen" style="font-family:'Sofia Sans',sans-serif">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('client.dashboard') }}" class="flex items-center">
                        <img width="60" height="60" src="/images/logo.jpeg" alt="Logo" class="rounded-lg" />
                        <span class="ml-3 text-xl font-bold text-gray-800">Моят профил</span>
                    </a>
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('client.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('client.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fa-solid fa-gauge-high mr-1"></i> Табло
                        </a>
                        <a href="{{ route('client.repairs') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('client.repairs') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fa-solid fa-wrench mr-1"></i> История на ремонтите
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">
                        <i class="fa-solid fa-user"></i>
                        {{ auth()->user()->name }}
                    </span>
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium text-red-600 hover:bg-red-50">
                            <i class="fa-solid fa-door-closed"></i> Изход
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="md:hidden border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('client.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('client.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-gauge-high mr-1"></i> Табло
                </a>
                <a href="{{ route('client.repairs') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('client.repairs') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fa-solid fa-wrench mr-1"></i> История на ремонтите
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        jQuery(document).ready(function() {
            @if (Session::has('message'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.success("{{ session('message') }}");
            @endif

            @if (Session::has('error'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.error("{{ session('error') }}");
            @endif

            @if (Session::has('info'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true
                }
                toastr.info("{{ session('info') }}");
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>
