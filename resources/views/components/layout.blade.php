<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="/images/logo.jpeg">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sofia+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @push('style')
            
        @endpush
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            customColor: "#FF9800",
                        },
                    },
                },
            };
        </script>
        <title>muci7oService</title>
    </head>

    <body class="mb-48" style="font-family:'Sofia Sans',sans-serif">
        <header class="w-full">
            <nav class="flex justify-between items-center mb-4 mx-2 lg:mx-56">
                <a href="/"><img width="100" height="100" src="/images/logo.jpeg" alt=""
                        class="logo my-2" /></a>
                <ul class="flex justify-end text-right space-x-6 mr-6 text-lg">

                    @auth
                        <li>
                                <i class="fa-solid fa-user "></i> 
                                Здравей, <span class="font-bold">{{ auth()->user()->name }}</span>
                        </li>
                        <li>
                            <form class="inline" method="POST" action="/logout">
                                @csrf
                                <button type="submit">
                                    <i class="fa-solid fa-door-closed"></i> Изход
                                </button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a href="/register" class="hover:text-laravel"><i class="fa-solid fa-user-plus"></i> Нов</a>
                        </li>
                        <li>
                            <a href="/login" class="hover:text-laravel"><i class="fa-solid fa-arrow-right-to-bracket"></i>
                                Вход</a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </header>
        <main class="lg:mx-56">
            {{ $slot }}
        </main>
        <footer class="fixed bottom-0 left-0 w-full flex flex-row items-center justify-center font-bold text-white lg:h-24 mt-24 opacity-90 gap-2 lg:gap-10">
            <a href="{{ route('create_client') }}"
                class="create-new-client text-align-center text-white my-2 lg:my-4 py-2 px-5">
                Добави нов клиент
            </a>
            <a href="{{route('create_car')}}" class="create-new-car text-align-center text-black my-2 lg:my-4 py-2 px-5">
                Добави нова кола
            </a>
        </footer>
        {{-- <x-message/> --}}
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

                @if (Session::has('warning'))
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.warning("{{ session('warning') }}");
                @endif
            });
        </script>
        @stack('scripts')
    </body>
</html>