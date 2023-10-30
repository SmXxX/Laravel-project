<x-layout>
    {{-- @include('partials._search') --}}
    
    <a href="/" class="inline-block text-black ml-4 mb-4"
    ><i class="fa-solid fa-arrow-left"></i> Назад
    </a>
    <div class="lg:mx-4">
    <x-card>
        <div class="grid lg:grid-cols-2 lg:gap-5">
            <div>
                <div class="border-b-2 border-[#FF9800] my-5 lg:my-0 lg:mb-2 separator-single-client"></div>
                <div class="flex flex-col lg:flex-row lg:gap-40">
                    <div class="client-name my-3">
                        <p class="heading-client">
                            Клиент
                        </p>
                        <h3 class="text-2xl my-2">
                            {{$client->name}}
                        </h3>
                    </div>
                <div class="border-b-2 border-[#FF9800] my-5 lg:my-0 lg:mb-2 separator-single-client lg:hidden"></div>
                    <div class="client-phone my-3">
                        <a href="tel:{{$client->phone_number}}">
                            <p class="heading-phone">
                                Телефонен номер
                            </p>
                            <div class="text-xl font-bold my-2 underline">{{$client->phone_number}}</div>
                        </a>
                    </div>
                </div>
                <div class="border-b-2 border-[#FF9800] my-5 lg:my-0 lg:mb-2 separator-single-client"></div>
                <div class="flex flex-row items-center mt-12 justify-between lg:justify-normal">
                        <h3 class="lg:text-2xl mb-2 w-5/12"><span class="font-bold">Избери кола: </span></h3>
                        <select class="mb-2 ml-2 p-3 bg-transparent text-black outline-none w-full border-2 rounded-lg" name="cars" id="carSelect">
                            <option value="" 
                            @if ($cars && $cars->count())
                            disabled 
                            @endif 
                            >Кола</option>
                            @foreach ($cars as $key => $car)
                            <option class="bg-transparent text-black outline-none" 
                            @if ($key == 0)
                                selected
                            @endif 
                            value="{{$car->id}}">{{$car->brand}}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div>
                <div class="flex flex-col" id="car-info">
                    <div class="flex flex-row lg:justify-between mt-5 md:mt-0">
                        <h2 class="lg:text-2xl text-center mb-5 text-[#007CCA]">Описание на колата</h2>
                        <div class="hidden md:block">
                            <a href="{{route('edit_car',[$selectedCar->id, $client->id])}}" class="text-align-center text-[#ff9800] mb-4 py-2 px-5 underline"><i class="fa-solid fa-pencil"></i> Редактирай кола</a>
                        </div>
                    </div>
                    @if(isset($selectedCar->image))
                    <img src={{$selectedCar->image}} class="w-48 mb-4" alt="">
                    @endif
                    <div class="overflow-x-auto">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="grid grid-cols-2 colored-bg p-2">
                                <div class="font-semibold">Рег. номер</div>
                                <div>{{ $selectedCar->plate }}</div>
                            </div>
                            <div class="grid grid-cols-2 p-2">
                                <div class="font-semibold">Рама</div>
                                <div>{{ $selectedCar->vin_num }}</div>
                            </div>
                            <div class="grid grid-cols-2 colored-bg p-2">
                                <div class="font-semibold">Година</div>
                                <div>{{ $selectedCar->year }}</div>
                            </div>
                            <div class="grid grid-cols-2 p-2">
                                <div class="font-semibold">Марка</div>
                                <div>{{ $selectedCar->brand }}</div>
                            </div>
                            <div class="grid grid-cols-2 colored-bg p-2">
                                <div class="font-semibold">Модел</div>
                                <div>{{ $selectedCar->model }}</div>
                            </div>
                            <div class="grid grid-cols-2 p-2">
                                <div class="font-semibold">Двигател</div>
                                <div>{{ $selectedCar->engine }}</div>
                            </div>
                            <div class="grid grid-cols-2 colored-bg p-2">
                                <div class="font-semibold">HP</div>
                                <div>{{ $selectedCar->hp }}</div>
                            </div>
                            <div class="grid grid-cols-2 p-2">
                                <div class="font-semibold">kW</div>
                                <div>{{ intval($selectedCar->hp * 0.7457) }}</div>
                            </div>
                            <div class="grid grid-cols-2 colored-bg p-2">
                                <div class="font-semibold">Гориво</div>
                                <div>{{ $selectedCar->fuel }}</div>
                            </div>
                            <div class="grid grid-cols-2 p-2">
                                <div class="font-semibold">Бележка</div>
                                <div>{{ $selectedCar->additional_info ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="block mt-5 md:hidden">
                        <a href="{{route('edit_car',[$selectedCar->id, $client->id])}}" class="text-align-center text-[#ff9800] mb-4 py-2 underline"><i class="fa-solid fa-pencil"></i> Редактирай кола</a>
                    </div>                 
                </div>
            </div>
        </div>
    </x-card>
    <h2 class="text-2xl font-bold uppercase text-center m-5">Ремонти</h2>
    <x-card class="mt-4 p-2 space-x-6">
        <a href="{{route('repairs',$selectedCar->id)}}">
            <i class="fa-solid fa-pencil"></i> Добавяне на ремонт
            {{-- <table>
                <thead>
                    <tr>
                        <th>Car ID</th>
                        <th>Repair</th>
                        <th>Part</th>
                        <th>Kilometers</th>
                        <th>Work Cost</th>
                        <th>Part Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($repairs as $repair)
                        <tr>
                            <td>{{ $repair->car_id }}</td>
                            <td>{{ $repair->repair }}</td>
                            <td>{{ $repair->part }}</td>
                            <td>{{ $repair->kilometers }}</td>
                            <td>{{ $repair->work_cost }}</td>
                            <td>{{ $repair->part_cost }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
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
                                <div class="flex flex-col" id="car-info">
                                    <div class="flex flex-row lg:justify-between mt-5 md:mt-0">
                                        <h2 class="lg:text-2xl text-center mb-5 text-[#007CCA]">Описание на колата</h2>
                                        <div class="hidden md:block">
                                            <a href="/cars/edit/${data.car.id}/${data.car.client_id}" class="text-align-center text-[#ff9800] mb-4 py-2 px-5 underline"><i class="fa-solid fa-pencil"></i> Редактирай кола</a>
                                        </div>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <div class="grid grid-cols-1 gap-4">
                                            <div class="grid grid-cols-2 colored-bg p-2">
                                                <div class="font-semibold">Рег. номер</div>
                                                <div>${data.car.plate}</div>
                                            </div>
                                            <div class="grid grid-cols-2 p-2">
                                                <div class="font-semibold">Рама</div>
                                                <div>${data.car.vin_num}</div>
                                            </div>
                                            <div class="grid grid-cols-2 colored-bg p-2">
                                                <div class="font-semibold">Година</div>
                                                <div>${data.car.year}</div>
                                            </div>
                                            <div class="grid grid-cols-2 p-2">
                                                <div class="font-semibold">Марка</div>
                                                <div>${data.car.brand}</div>
                                            </div>
                                            <div class="grid grid-cols-2 colored-bg p-2">
                                                <div class="font-semibold">Модел</div>
                                                <div>${data.car.model}</div>
                                            </div>
                                            <div class="grid grid-cols-2 p-2">
                                                <div class="font-semibold">Двигател</div>
                                                <div>${data.car.engine}</div>
                                            </div>
                                            <div class="grid grid-cols-2 colored-bg p-2">
                                                <div class="font-semibold">HP</div>
                                                <div>${data.car.hp}</div>
                                            </div>
                                            <div class="grid grid-cols-2 p-2">
                                                <div class="font-semibold">KW</div>
                                                <div>${data.car.hp * 0.7457}</div>
                                            </div>
                                            <div class="grid grid-cols-2 colored-bg p-2">
                                                <div class="font-semibold">Гориво</div>
                                                <div>${data.car.fuel}</div>
                                            </div>
                                            <div class="grid grid-cols-2 p-2">
                                                <div class="font-semibold">Бележка</div>
                                                <div>${data.car.additional_info !== null ? data.car.additional_info : ''}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block mt-5 md:hidden">
                                        <a href="/cars/edit/${data.car.id}/${data.car.client_id}" class="text-align-center text-[#ff9800] mb-4 py-2 underline"><i class="fa-solid fa-pencil"></i> Редактирай кола</a>
                                    </div>
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
        <div x-data="{show:true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-[#007CCA] text-white px-48 xs-px-12 py-3">
            <p>
                {{session('message')}}
            </p>
        </div>
    @endif
</x-layout>