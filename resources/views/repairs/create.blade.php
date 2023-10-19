<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-6">
                Добавяне на ремонт
            </h2>
        </header>

        <form method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label
                    for="repair"
                    class="inline-block text-lg mb-2"
                    >Извършен ремонт</label
                >
                <input
                    type="text"
                    id="reprair"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="repair"
                    placeholder="Извършен ремонт"
                />
                @error('repair')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label
                    for="part"
                    class="inline-block text-lg mb-2"
                    >Сменена част</label
                >
                <input
                    type="text"
                    id="part"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="part"
                    placeholder="Сменена част"
                />
                @error('part')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="kilometers" class="inline-block text-lg mb-2"
                    >Километри</label
                >
                <input
                    type="text"
                    id="kilometers"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="kilometers"
                    placeholder="Километри"
                />
                @error('kilometers')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="work_cost" class="inline-block text-lg mb-2"
                    >Цена труд</label
                >
                <input
                    type="text"
                    id="work_cost"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="work_cost"
                    placeholder="Цена труд"
                />
                @error('work_cost')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="part_cost" class="inline-block text-lg mb-2"
                    >Цена части</label
                >
                <input
                    type="text"
                    id="part_cost"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="part_cost"
                    placeholder="Цена части"
                />
                @error('part_cost')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Създай
                </button>

                <a href="{{ URL::previous() }}" class="text-black ml-4"> Назад </a>
            </div>
        </form>
    </x-card>
</x-layout>