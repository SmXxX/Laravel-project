<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" type="image/x-icon" href="/images/logo.jpeg">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        @push('style')
            
        @endpush
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            laravel: "#ef3b2d",
                        },
                    },
                },
            };
        </script>
        <title>muci7oService</title>
    </head>

    <body class="mb-48 mx-24">
        <nav class="flex justify-between items-center mb-4">
            <a href="/"><img width="150" height="150" src="/images/logo.jpeg" alt=""
                    class="logo" /></a>
            <ul class="flex justify-end text-right space-x-6 mr-6 text-lg">

                @auth
                    <li>
                        <span class="font-bold uppercase">
                            Здравей, {{ auth()->user()->name }}
                        </span>
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
        <main>
            {{ $slot }}
        </main>
        <footer class="fixed bottom-0 left-0 w-full flex flex-col lg:flex-row items-center justify-center font-bold bg-laravel text-white lg:h-24 mt-24 opacity-90 lg:gap-10">
            <a href="{{ route('create_client') }}"
                class="text-align-center bg-black text-white my-2 lg:my-4 py-2 px-5">
                Добави нов клиент
            </a>
            <a href="{{route('create_car')}}" class="text-align-center bg-black text-white my-2 lg:my-4 py-2 px-5">
                Добави нова кола
            </a>
        </footer>
        {{-- <x-message/> --}}
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        @stack('scripts')
    </body>
</html>