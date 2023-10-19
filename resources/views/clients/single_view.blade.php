<x-layout>
    {{-- @include('partials._search') --}}
    
    <a href="/" class="inline-block text-black ml-4 mb-4"
    ><i class="fa-solid fa-arrow-left"></i> Назад
    </a>
    <div class="mx-4">
    <x-card>
        <div
            class="flex flex-col lg:flex-row items-center justify-around text-center"
        >
            <div class="flex flex-col justify-center items-center text-center">
        
                <h3 class="lg:text-2xl mb-2"><span class="font-bold">Име на клиента - </span>{{$client->name}}</h3>
                <div class="lg:text-xl mb-4"><span class="font-bold">Телефонен номер - </span><a href="tel:{{$client->phone_number}}">{{$client->phone_number}}</a></div>
                <div class="flex justify-center text-center">
                    <h3 class="lg:text-2xl mb-2"><span class="font-bold">Избери кола: </span></h3>
                    <select class="mb-2 bg-transparent text-black outline-none text-center" name="cars" id="carSelect">
                        <option value="" 
                        @if ($cars && $cars->count())
                        disabled 
                        @endif 
                        >Кола</option>
                        @foreach ($cars as $key => $car)
                        <option class="bg-transparent text-black outline-none text-center" 
                        @if ($key == 0)
                            selected
                        @endif 
                        value="{{$car->id}}">{{$car->brand}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="border border-gray-200 w-full mb-4 lg:invisible"></div>
            </div>
            <div class="flex flex-col justify-center items-center text-center">
                <h2 class="lg:text-2xl font-bold uppercase text-center mb-5">Описание на колата</h2>
                @if(isset($car->image))
                <img src={{$car->image}} class="w-48 mb-4" alt="">
                @endif
                <div class="flex flex-col justify-center text-center lg:gap-10" id="car-info">
                    <div class="columns-2">
                        <div>
                            <div class="flex justify-center lg:text-xl mb-4"><span class="font-bold">Рег. номер - </span>{{$selectedCar->plate}}</div>
                            <div class="flex justify-center lg:text-xl mb-4"><span class="font-bold">Рама - </span>{{$selectedCar->vin_num}}</div>
                            <div class="flex justify-center lg:text-xl mb-4"><span class="font-bold">Година - </span>{{$selectedCar->year}}</div>
                            <div class="flex justify-center lg:text-xl mb-4"><span class="font-bold">Марка - </span>{{$selectedCar->brand}}</div>
                            <div class="flex justify-center lg:text-xl mb-4"><span class="font-bold">Модел - </span>{{$selectedCar->model}}</div>
                        </div>
                        <div>
                            <div class="flex justify-center lg:text-xl mb-4"><span class="font-bold">Цвят - </span>{{$selectedCar->color}}</div>
                            <div class="flex justify-center lg:text-xl mb-4"><span class="font-bold">Двигател - </span>{{$selectedCar->engine}}</div>
                            <div class="flex justify-center lg:text-xl mb-4"><span class="font-bold">HP - </span>{{$selectedCar->hp}}</div>
                            <div class="flex justify-center lg:text-xl mb-4"><span class="font-bold">KW - </span>{{$selectedCar->kw}}</div>
                            <div class="flex justify-center lg:text-xl mb-4"><span class="font-bold">Гориво - </span>{{$selectedCar->fuel}}</div>
                        </div>
                    </div>
                    <div>
                        <a href="{{route('edit_car',[$selectedCar->id, $client->id])}}" class="text-align-center bg-black text-white mb-4 py-2 px-5">Редактирай кола</a>
                    </div>
                </div>
            </div>
        </div>
    </x-card>
    <x-card class="mt-4 p-2 flex flex-col lg:flex-row text-center gap-5 space-x-6">
        <a href="{{route('edit_client',$client->id)}}">
            <i class="fa-solid fa-pencil"></i> Редактирай клиент
        </a>
        <form method="POST" action="/clients/{{$client->id}}">
            @csrf
            @method('DELETE')
            <button class="text-red-500" onclick="return confirm('Сигурен ли си ?')"><i class="fa-solid fa-trash"></i> Изтрий клиент</button>
        </form>
    </x-card>  
    <h2 class="text-2xl font-bold uppercase text-center m-5">Ремонти</h2>
    <x-card class="mt-4 p-2 space-x-6">
        <a href="{{route('repairs',$selectedCar->id)}}">
            <i class="fa-solid fa-pencil"></i> Добавяне на ремонт
        </a>

    </x-card>
    </div>
    @push("scripts")
        <script>
            jQuery(document).ready(function($){
                var csrf_token = "{{ csrf_token() }}";
                var clientId = " {{$client->id}} ";
                $('#carSelect').on('change',function(){
                    var selectedCar = $(this).val();
                    $.ajax({
                        url: '/get-car-info',
                        type: "POST",
                        data: {
                            _token: csrf_token,
                            selectedCar,
                            clientId
                        },
                        success: function(data){
                            var html = '';
                            html = `
                                <div class="columns-2">
                                    <div>
                                        <div class="flex justify-center text-xl mb-4"><span class="font-bold">Рег. номер - </span>${data.car.plate}</div>
                                        <div class="flex justify-center text-xl mb-4"><span class="font-bold">Номер рама - </span>${data.car.vin_num}</div>
                                        <div class="flex justify-center text-xl mb-4"><span class="font-bold">Година - </span>${data.car.year}</div>
                                        <div class="flex justify-center text-xl mb-4"><span class="font-bold">Марка - </span>${data.car.brand}</div>
                                        <div class="flex justify-center text-xl mb-4"><span class="font-bold">Модел - </span>${data.car.model}</div>
                                    </div>
                                    <div>
                                        <div class="flex justify-center text-xl mb-4"><span class="font-bold">Цвят - </span>${(data.car.color) ? data.car.color : 'Не е зададен'}</div>
                                        <div class="flex justify-center text-xl mb-4"><span class="font-bold">Двигател - </span>${data.car.engine}</div>
                                        <div class="flex justify-center text-xl mb-4"><span class="font-bold">HP - </span>${data.car.hp}</div>
                                        <div class="flex justify-center text-xl mb-4"><span class="font-bold">KW - </span>${data.car.kw}</div>
                                        <div class="flex justify-center text-xl mb-4"><span class="font-bold">Гориво - </span>${data.car.fuel}</div>
                                    </div>
                                </div>
                                <div>
                                    <a href="/cars/edit/${data.car.id}/${data.car.client_id}" class="text-align-center bg-black text-white mb-4 py-2 px-5">Редактирай кола</a>
                                </div>
                                `;
                                $('#car-info').html(html);
                        },
                        error: function(xhr){
                            console.log('Error: ', xhr);
                        }
                    });
                });
            });
        </script>
    @endpush
    @if (session('message'))
    <div x-data="{show:true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-laravel text-white px-48 xs-px-12 py-3">
        <p>
            {{session('message')}}
        </p>
    </div>
@endif
</x-layout>