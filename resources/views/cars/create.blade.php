<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24 bg-gray-50 border border-gray-200 ">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-6">
                Създаване на кола
            </h2>
        </header>

        <form method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex w-full justify-center align-center text-center mb-6">
                <label for="client" class="inline-block text-lg mb-2"></label>

                <select class="mb-4 bg-transparent text-black outline-none text-center" name="client_id" id="client">
                    <option value="">Избери клиент</option>
                    @if (count($clients) == 1)
                    @foreach ($clients as $client)
                    <option class="bg-transparent text-black outline-none text-center"  value="{{$client->id}}" selected>{{$client->name}}</option>
                    @endforeach

                    @else
                    
                    @foreach ($clients as $client)
                    <option class="bg-transparent text-black outline-none text-center"  value="{{$client->id}}">{{$client->name}}</option>
                    @endforeach
                    @endif
                </select>
                @error('client_id')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label
                    for="plate"
                    class="inline-block text-lg mb-2"
                    >Рег.номер</label
                >
                <input
                    type="text"
                    id="plate"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="plate"
                    placeholder="Рег.номер"
                    value="{{old('plate')}}"
                />
                @error('plate')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            {{-- <div class="mb-6">
                <label for="image" class="inline-block text-lg mb-2">
                    Снимка на колата
                </label>
                <input
                    type="file"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="image"
                />
                <img
                    class="w-48 mr-6 mb-6"
                    src= {{ $car->image ? asset('storage/' . $listing->logo) : asset('/images/logo.png')}}
                    alt=""
                />
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div> --}}
            <div class="mb-6">
                <label for="brand" class="inline-block text-lg mb-2"
                    >Марка</label
                >
                <input
                    type="text"
                    id="brand"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="brand"
                    placeholder="Марка кола"
                    value="{{old('brand')}}"
                />
                @error('brand')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="model" class="inline-block text-lg mb-2"
                    >Модел</label
                >
                <input
                    type="text"
                    id="model"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="model"
                    placeholder="Модел кола"
                    value="{{old('model')}}"
                />
                @error('model')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="year" class="inline-block text-lg mb-2"
                    >Година</label
                >
                <input
                    type="text"
                    id="year"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="year"
                    placeholder="Година на производство"
                    value="{{old('year')}}"
                />
                @error('year')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="engine" class="inline-block text-lg mb-2"
                    >Литраж на двигателя</label
                >
                <input
                    type="text"
                    id="engine"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="engine"
                    placeholder="Литраж на двигателя"
                    value="{{old('engine')}}"
                />
                @error('engine')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="hp" class="inline-block text-lg mb-2"
                    >Конски сили</label
                >
                <input
                    type="text"
                    id="hp"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="hp"
                    placeholder="Конски сили"
                    value="{{old('hp')}}"
                />
                @error('hp')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6 hidden">
                <label for="kw" class="inline-block text-lg mb-2"
                    >Мощност в kW</label
                >
                <input
                    type="text"
                    id="kw"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="kw"
                    placeholder="Мощност в kW"
                    value="{{old('kw')}}"
                />
                @error('kw')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="fuel" class="inline-block text-lg mb-2"
                    >Вид гориво</label
                >
                <input
                    type="text"
                    id="fuel"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="fuel"
                    placeholder="Вид гориво"
                    value="{{old('fuel')}}"
                />
                @error('fuel')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="vin_num" class="inline-block text-lg mb-2"
                    >Номер на рама</label
                >
                <input
                    type="text"
                    id="vin_num"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="vin_num"
                    placeholder="Номер на рама"
                    value="{{old('vin_num')}}"
                />
                @error('vin_num')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="additional_info" class="inline-block text-lg mb-2"
                    >Бележка</label
                >
                <textarea id="additional_info" rows="4" cols="50" class="border border-gray-200 rounded p-2 w-full" placeholder="Бележка за колата" name="additional_info" value="{{old('additional_info')}}"></textarea>
            </div>
            <div class="mb-6">
                <button
                    class="bg-[#007CCA] text-white rounded py-2 px-4 hover:bg-black"
                >
                    Създай
                </button>

                <a href="/" class="text-black ml-4"> Назад </a>
            </div>
        </form>
    </x-card>
</x-layout>