<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Редактиране на клиент
            </h2>
        </header>

        <form method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label
                    for="name"
                    class="inline-block text-lg mb-2"
                    >Име</label
                >
                <input
                    type="text"
                    id="name"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="name"
                    placeholder="Име"
                    value="{{$client->name}}"
                />
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="phone_number" class="inline-block text-lg mb-2"
                    >Телефонен номер</label
                >
                <input
                    type="text"
                    id="phone_number"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="phone_number"
                    placeholder="Пример: 0881234567/+359881234567"
                    value="{{$client->phone_number}}"
                />
                @error('phone_number')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Редактирай
                </button>

                <a href="{{route('single',$client->id)}}" class="text-black ml-4"> Назад </a>
            </div>
        </form>
    </x-card>
</x-layout>