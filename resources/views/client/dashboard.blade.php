@extends('client.layouts.app')

@section('title', 'Моят профил')

@section('content')
<div class="space-y-6">
    <!-- Welcome -->
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800">Здравей, {{ $client->name }}!</h1>
        <p class="text-gray-600 mt-1">Тук можеш да следиш всички свои коли и техните ремонти.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fa-solid fa-car text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Моите коли</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $cars->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fa-solid fa-wrench text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Общо ремонти</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalRepairs }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($cars->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Cars List -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Моите коли</h2>
            </div>
            <div class="divide-y">
                @foreach($cars as $car)
                <div class="p-4 hover:bg-gray-50 cursor-pointer car-select {{ $selectedCar && $selectedCar->id == $car->id ? 'bg-blue-50 border-l-4 border-blue-500' : '' }}"
                    data-car-id="{{ $car->id }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">{{ $car->brand }} {{ $car->model }}</p>
                            <p class="text-sm text-gray-500">{{ $car->plate }} | {{ $car->year }}</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-gray-400"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Selected Car Details -->
        <div class="bg-white rounded-lg shadow" id="car-details">
            @if($selectedCar)
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">{{ $selectedCar->brand }} {{ $selectedCar->model }}</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Рег. номер</p>
                        <p class="font-medium">{{ $selectedCar->plate }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">VIN</p>
                        <p class="font-medium">{{ $selectedCar->vin_num ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Година</p>
                        <p class="font-medium">{{ $selectedCar->year }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Двигател</p>
                        <p class="font-medium">{{ $selectedCar->engine ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">HP / kW</p>
                        <p class="font-medium">{{ $selectedCar->hp ?? 'N/A' }} / {{ intval(($selectedCar->hp ?? 0) * 0.7457) }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Гориво</p>
                        <p class="font-medium">{{ $selectedCar->fuel ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="p-6 text-center text-gray-500">
                <p>Изберете кола от списъка</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Repairs for Selected Car -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-800">
                Ремонти на {{ $selectedCar ? $selectedCar->brand . ' ' . $selectedCar->model : 'избраната кола' }}
            </h2>
        </div>
        <div class="overflow-x-auto" id="repairs-container">
            @if($repairs->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ремонт</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Част</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Километри</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Цена труд</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Цена части</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($repairs as $repair)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">{{ $repair->repair }}</td>
                        <td class="px-6 py-4 text-sm">{{ $repair->part ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($repair->kilometers) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($repair->work_cost, 2) }} лв.</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($repair->part_cost, 2) }} лв.</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $repair->created_at->format('d.m.Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="p-6 text-center text-gray-500">
                <i class="fa-solid fa-wrench text-4xl mb-2"></i>
                <p>Няма регистрирани ремонти за тази кола</p>
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <i class="fa-solid fa-car text-6xl text-gray-300 mb-4"></i>
        <h2 class="text-xl font-semibold text-gray-600 mb-2">Нямате регистрирани коли</h2>
        <p class="text-gray-500">Моля, свържете се с администратора за да добави вашите коли.</p>
    </div>
    @endif
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.car-select').on('click', function() {
        var carId = $(this).data('car-id');

        $.ajax({
            url: '{{ route("client.car.info") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                selectedCar: carId
            },
            success: function(data) {
                // Reload page with selected car
                window.location.href = '{{ route("client.dashboard") }}?car=' + carId;
            },
            error: function(xhr) {
                console.log('Error:', xhr);
            }
        });
    });
});
</script>
@endpush
@endsection
