<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-10 bg-gray-50 border border-gray-200 ">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-6">
                Редактиране на ремонт
            </h2>
        </header>

        <form method="POST" enctype="multipart/form-data">
            @csrf
            {{-- <div class="flex w-full justify-center align-center text-center mb-6">
                <label for="client" class="inline-block text-lg mb-2"></label>
                <select class="mb-4 bg-transparent text-black outline-none text-center" name="client_id" id="client">
                    <option value="">Избери клиент</option>
                    @foreach ($clients as $client)
                    <option class="bg-transparent text-black outline-none text-center" 
                    @if ($car->client_id == $client->id)
                        selected
                    @endif 
                    value="{{$client->id}}">{{$client->name}}</option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div> --}
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
                <label for="car_repair" class="inline-block text-lg mb-2"
                    >Извършен ремонт</label
                >
                <input
                    type="text"
                    id="car_repair"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="repair"
                    placeholder="Извършен ремонт"
                    value="{{$repair_car->repair}}"
                />
                @error('car_repair')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="car_part" class="inline-block text-lg mb-2"
                    >Сменена част</label
                >
                <input
                    type="text"
                    id="car_part"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="part"
                    placeholder="Сменена част"
                    value="{{$repair_car->part}}"
                />
                @error('car_part')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="car_kilometers" class="inline-block text-lg mb-2"
                    >Километри</label
                >
                <input
                    type="text"
                    id="car_kilometers"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="kilometers"
                    placeholder="Километри"
                    value="{{$repair_car->kilometers}}"
                />
                @error('car_kilometers')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="car_work_cost" class="inline-block text-lg mb-2"
                    >Цена труд</label
                >
                <input
                    type="text"
                    id="car_work_cost"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="work_cost"
                    placeholder="Цена труд"
                    value="{{$repair_car->work_cost}}"
                />
                @error('car_work_cost')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="car_part_cost" class="inline-block text-lg mb-2"
                    >Цена части</label
                >
                <input
                    type="text"
                    id="car_part_cost"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="part_cost"
                    placeholder="Цена части"
                    value="{{$repair_car->part_cost}}"
                />
                @error('car_part_cost')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <button
                    class="bg-[#007CCA] text-white rounded py-2 px-4 hover:bg-black"
                >
                    Редактирай
                </button>

                <a href="{{ route('single',['id' => $repair_car->car->client_id]) }}" class="text-black ml-4"> Назад </a>
            </div>
        </form>
    </x-card>
</x-layout>