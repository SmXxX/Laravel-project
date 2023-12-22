<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24 bg-gray-50 border border-gray-200 ">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-6">
                Добавяне на ремонт
            </h2>
        </header>

        <form method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex w-full justify-center align-center text-center mb-6">
                <label for="car" class="inline-block text-lg mb-2"></label>

                <select class="mb-4 bg-transparent text-black outline-none text-center" name="car_id" id="car">
                    <option value="" disabled>Избери колa</option>
                    @foreach ($cars as $car)
                    <option class="bg-transparent text-black outline-none text-center" value="{{ $car->id }}" @if(old('car_id') == $car->id) selected @endif>{{$car->brand}}</option>
                    @endforeach
                </select>
                @error('car_id')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="repair" class="inline-block text-lg mb-2">Извършен ремонт</label>
                <input type="text" id="reprair" class="border border-gray-200 rounded p-2 w-full" name="repair" placeholder="Извършен ремонт" value="{{ old('repair') }}" />
                @error('repair')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="part" class="inline-block text-lg mb-2">Сменена част</label>
                <input type="text" id="part" class="border border-gray-200 rounded p-2 w-full" name="part" placeholder="Сменена част" value="{{ old('part') }}" />
                @error('part')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="kilometers" class="inline-block text-lg mb-2">Километри</label>
                <input type="text" id="kilometers" class="border border-gray-200 rounded p-2 w-full" name="kilometers" placeholder="Километри" value="{{ old('kilometers') }}"  />
                @error('kilometers')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="work_cost" class="inline-block text-lg mb-2">Цена труд</label>
                <input type="text" id="work_cost" class="border border-gray-200 rounded p-2 w-full" name="work_cost" placeholder="Цена труд" value="{{ old('work_cost') }}" />
                @error('work_cost')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="part_cost" class="inline-block text-lg mb-2">Цена части</label>
                <input type="text" id="part_cost" class="border border-gray-200 rounded p-2 w-full" name="part_cost" placeholder="Цена части" value="{{ old('part_cost') }}" />
                @error('part_cost')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button class="bg-[#007CCA] text-white rounded py-2 px-4">
                    Създай
                </button>

                <a href="{{ route('single', $client->id) }}" class="text-black ml-4"> Назад </a>
            </div>
        </form>
    </x-card>
    @push('scripts')
        <script>
            // Function to get query parameters from the URL
            function getQueryParam(param) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            // Get the carId from the URL
            const carIdFromURL = getQueryParam('carId');

            // If carId is found in the URL, select the corresponding option in the dropdown
            if (carIdFromURL) {
                // Set the value of the #car select dropdown to the carId obtained from the URL
                $('#car').val(carIdFromURL);
            }
        </script>
    @endpush
</x-layout>