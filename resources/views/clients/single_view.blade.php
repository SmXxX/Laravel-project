<x-layout>
    @if (session('message'))
        <div x-data="{show:true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-[#007CCA] text-white px-48 xs-px-12 py-3">
            <p>
                {{session('message')}}
            </p>
        </div>
    @endif
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
    <x-card class="mt-4 p-2 lg:space-x-6">
        <div class="text-right">
            <a href="{{route('repairs',$selectedCar->id)}}" class="text-[#007CCA]" id="add_repair">
                <i class="fa-solid fa-plus"></i> Добавяне на ремонт
            </a>
        </div>
        <div id="car-repair-container">
            {{-- Show grid only on >768px devices --}}
            @if ($repairs->count()>0)
            <div class="md:grid grid-cols-6 mt-5 hidden">
                <div class="repair-heading colored-bg rounded-e-none p-2">Кола</div>
                <div class="repair-heading colored-bg rounded-none p-2">Извършен ремонт</div>
                <div class="repair-heading colored-bg rounded-none p-2">Сменена част</div>
                <div class="repair-heading colored-bg rounded-none p-2">Километри</div>
                <div class="repair-heading colored-bg rounded-none p-2">Цена труд</div>
                <div class="repair-heading colored-bg rounded-s-none p-2">Цена части</div>
                @foreach ($repairs as $repair)
                    <div class="repair-data p-2 rounded-e-none">{{$selectedCar->brand}}</div>
                    <div class="repair-data p-2 rounded-none">{{$repair->repair }}</div>
                    <div class="repair-data p-2 rounded-none">{{$repair->part }}</div>
                    <div class="repair-data p-2 rounded-none">{{$repair->kilometers }}</div>
                    <div class="repair-data p-2 rounded-none">{{$repair->work_cost }}</div>
                    <div class="repair-data p-2 rounded-s-none">{{$repair->part_cost }}<form class="text-[#EF4444] px-2 float-right" method="POST" action="{{ route('repair_destroy', ['id' => $repair->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Сигурен ли си ?')"><i class="fa-solid fa-trash"></i></button>
                    </form><a href="{{route('edit_repair',[$repair->id, $car->id])}}" class="text-[#ff9800] px-2 float-right"><i class="fa-solid fa-pencil"></i></a></div>
                @endforeach
            </div>
            @else
                <p>Няма ремонти за тази кола</p>
            @endif
            {{-- END of show grid only on >768px devices --}}

            {{-- Show grid only on <768px devices --}}
            @foreach ($repairs as $repair)
                <div class="grid grid-cols-1 mt-5 md:hidden border mobile-grid-repairs">
                    <div class="grid grid-cols-2 colored-bg p-2">
                        <div class="repair-heading">Кола</div>
                        <div class="repair-data">{{$selectedCar->brand}}<form class="text-[#EF4444] px-2 float-right" method="POST" action="{{ route('repair_destroy', ['id' => $repair->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button  onclick="return confirm('Сигурен ли си ?')"><i class="fa-solid fa-trash"></i></button>
                        </form><a href="{{route('edit_repair',[$repair->id, $car->id])}}" class="text-[#ff9800] px-2 float-right"><i class="fa-solid fa-pencil"></i></a></div>

                    </div>
                    <div class="grid grid-cols-2 p-2">
                        <div class="repair-heading">Извършен ремонт</div>
                        <div class="repair-data">{{$repair->repair }}</div>
                    </div>
                    <div class="grid grid-cols-2 colored-bg p-2">
                        <div class="repair-heading">Сменена част</div>
                        <div class="repair-data">{{$repair->part }}</div>
                    </div>
                    <div class="grid grid-cols-2 p-2">
                        <div class="repair-heading">Километри</div>
                        <div class="repair-data">{{$repair->kilometers }}</div>
                    </div>
                    <div class="grid grid-cols-2 colored-bg p-2">
                        <div class="repair-heading">Цена труд</div>
                        <div class="repair-data">{{$repair->work_cost }}</div>
                    </div>
                    <div class="grid grid-cols-2 p-2">
                        <div class="repair-heading">Цена части</div>
                        <div class="repair-data">{{$repair->part_cost }}</div>
                    </div>
                </div>
            @endforeach
            {{-- END of show grid only on <768px devices --}}
        </div>
    </x-card>
    </div>
    @push("scripts")
        <script>
            jQuery(document).ready(function($){
                var csrf_token = "{{ csrf_token() }}";
                var clientId = " {{ $client->id }} ";
                $('#carSelect').on('change',function(){
                    let carId = $(this).val();
                    let addRepair = $('#add_repair');
                    let originalHref = addRepair.attr('href');

                    // Split the URL by '?' to separate the base URL and existing query parameters
                    let [baseUrl, queryParams] = originalHref.split('?');

                    // Parse the existing query parameters into an object
                    let paramsObject = {};
                    if (queryParams) {
                        let params = queryParams.split('&');
                        params.forEach(param => {
                            let [key, value] = param.split('=');
                            paramsObject[key] = value;
                        });
                    }

                    // Update the 'carId' parameter in the paramsObject
                    paramsObject['carId'] = carId;

                    // Construct the new query parameters string
                    let newParams = Object.keys(paramsObject)
                        .map(key => `${key}=${paramsObject[key]}`)
                        .join('&');

                    // Reconstruct the href with the updated query parameters
                    let newHref = `${baseUrl}?${newParams}`;
                    
                    addRepair.attr('href', newHref);
                    var selectedCar = $(this).val();
                    $.ajax({
                        url: '/get-car-info-and-repairs',
                        type: "POST",
                        data: {
                            _token: csrf_token,
                            selectedCar: selectedCar,
                            clientId: clientId,
                        },
                        success: function(data){
                            var html = '';
                            var htmlRepair = '';
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
                                            <div>${parseInt(data.car.hp * 0.7457)}</div>
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
                            
                            if (data.repair && data.repair.length > 0) {
                                htmlRepair += `
                                        <!-- Show grid only on >768px devices -->
                                        <div class="md:grid grid-cols-6 mt-5 hidden">
                                            <div class="repair-heading colored-bg rounded-e-none p-2">Кола</div>
                                            <div class="repair-heading colored-bg rounded-none p-2">Извършен ремонт</div>
                                            <div class="repair-heading colored-bg rounded-none p-2">Сменена част</div>
                                            <div class="repair-heading colored-bg rounded-none p-2">Километри</div>
                                            <div class="repair-heading colored-bg rounded-none p-2">Цена труд</div>
                                            <div class="repair-heading colored-bg rounded-s-none p-2">Цена части</div>
                                        </div>
                                        <!-- END of show grid only on >768px devices -->
                                `;
                                function confirmDelete(repairId) {
                                    if (confirm('Сигурен ли си ?')) {
                                        deleteRepair(repairId);
                                    }
                                }
                                // Add this function to handle repair deletion
                                function deleteRepair(repairId) {
                                    $.ajax({
                                        url: '/repair/' + repairId,
                                        type: 'DELETE',
                                        data: {
                                            _token: csrf_token,
                                        },
                                        success: function (data) {
                                            // Handle success, maybe refresh the repair list or do something else
                                            console.log(data.message);

                                            // Remove the deleted repair element from the page
                                            $('.repair[data-repair-id="' + repairId + '"]').remove();
                                        },
                                        error: function (xhr) {
                                            console.log('Error: ', xhr);
                                        },
                                    }); 
                                }
                            
                                data.repair.forEach(function (repair){
                                    htmlRepair+=`
                                        {{-- Show grid only on >768px devices --}}
                                        <div class="md:grid grid-cols-6 mt-5 hidden">
                                            <div class="repair-data p-2 rounded-e-none">${data.car.brand}</div>
                                            <div class="repair-data p-2 rounded-none">${repair.repair}</div>
                                            <div class="repair-data p-2 rounded-none">${repair.part}</div>
                                            <div class="repair-data p-2 rounded-none">${repair.kilometers}</div>
                                            <div class="repair-data p-2 rounded-none">${repair.work_cost}</div>
                                            <div class="repair-data p-2 rounded-s-none">${repair.part_cost}<form class="text-[#EF4444] px-2 float-right delete-repair-form" method="POST" action="/repair/${repair.id}" data-repair-id="${repair.id}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-repair-button">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form><a href="/repair/edit/${repair.id}/${data.car.id}" class="text-[#ff9800] px-2 float-right"><i class="fa-solid fa-pencil"></i></a></div>
                                        </div>
                                        {{-- END of show grid only on >768px devices --}}

                                        {{-- Show grid only on <768px devices --}}
                                    
                                        <div class="grid grid-cols-1 mt-5 md:hidden border mobile-grid-repairs">
                                            <div class="grid grid-cols-2 colored-bg p-2">
                                                <div class="repair-heading">Кола</div>
                                                <div class="repair-data">${data.car.brand}<form class="text-[#EF4444] px-2 float-right delete-repair-form" method="POST" action="/repair/${repair.id}" data-repair-id="${repair.id}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="delete-repair-button">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form><a href="/repair/edit/${repair.id}/${data.car.id}" class="text-[#ff9800] px-2 float-right"><i class="fa-solid fa-pencil"></i></a></div>

                                            </div>
                                            <div class="grid grid-cols-2 p-2">
                                                <div class="repair-heading">Извършен ремонт</div>
                                                <div class="repair-data">${repair.repair}</div>
                                            </div>
                                            <div class="grid grid-cols-2 colored-bg p-2">
                                                <div class="repair-heading">Сменена част</div>
                                                <div class="repair-data">${repair.part}</div>
                                            </div>
                                            <div class="grid grid-cols-2 p-2">
                                                <div class="repair-heading">Километри</div>
                                                <div class="repair-data">${repair.kilometers}</div>
                                            </div>
                                            <div class="grid grid-cols-2 colored-bg p-2">
                                                <div class="repair-heading">Цена труд</div>
                                                <div class="repair-data">${repair.work_cost}</div>
                                            </div>
                                            <div class="grid grid-cols-2 p-2">
                                                <div class="repair-heading">Цена части</div>
                                                <div class="repair-data">${repair.part_cost}</div>
                                            </div>
                                        </div>
                                        {{-- END of show grid only on <768px devices --}}
                                    </div>
                                    `
                                });
                            }else{
                                htmlRepair = '<p>Няма ремонти за тази кола</p>';
                            }
                                $('#car-repair-container').html(htmlRepair);
                                
                                $('.delete-repair-button').on('click', function() {
                                    var repairId = $(this).closest('form').data('repair-id');
                                    confirmDelete(repairId);
                                });  
                        },
                        error: function(xhr){
                            console.log('Error: ', xhr);
                        }
                    });
                });
            });

        </script>
    @endpush
</x-layout>