@extends('admin.layouts.app')

@section('title', $client->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="{{ route('admin.clients.index') }}" class="text-gray-600 hover:text-gray-800 text-sm">
                <i class="fa-solid fa-arrow-left mr-1"></i>Назад към клиенти
            </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $client->name }}</h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.clients.edit', $client->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                <i class="fa-solid fa-pencil mr-2"></i>Редактирай
            </a>
            <a href="{{ route('admin.cars.create') }}?client_id={{ $client->id }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fa-solid fa-car mr-2"></i>Добави кола
            </a>
        </div>
    </div>

    <!-- Client Info -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-500">Телефон</p>
                <a href="tel:{{ $client->phone_number }}" class="text-lg font-medium text-blue-600 hover:underline">
                    {{ $client->phone_number }}
                </a>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="text-lg font-medium">{{ $client->user->email ?? 'Няма акаунт' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Създаден</p>
                <p class="text-lg font-medium">{{ $client->created_at->format('d.m.Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Cars -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">Коли ({{ $cars->count() }})</h2>
            </div>
            @if($cars->count() > 0)
            <div class="divide-y">
                @foreach($cars as $car)
                <div class="p-4 hover:bg-gray-50 {{ $selectedCar && $selectedCar->id == $car->id ? 'bg-blue-50 border-l-4 border-blue-500' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 cursor-pointer car-select" data-car-id="{{ $car->id }}">
                            <p class="font-medium text-gray-800">{{ $car->brand }} {{ $car->model }}</p>
                            <p class="text-sm text-gray-500">{{ $car->plate }} | {{ $car->year }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.cars.edit', $car->id) }}" class="text-yellow-600 hover:text-yellow-800">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <a href="{{ route('admin.repairs.create') }}?client_id={{ $client->id }}&car_id={{ $car->id }}" class="text-green-600 hover:text-green-800">
                                <i class="fa-solid fa-wrench"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-6 text-center text-gray-500">
                <i class="fa-solid fa-car text-4xl mb-2"></i>
                <p>Няма добавени коли</p>
                <a href="{{ route('admin.cars.create') }}?client_id={{ $client->id }}" class="mt-2 inline-block text-blue-600 hover:underline">
                    Добави първата кола
                </a>
            </div>
            @endif
        </div>

        <!-- Selected Car Details -->
        <div class="bg-white rounded-lg shadow" id="car-details">
            @if($selectedCar)
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Детайли за {{ $selectedCar->brand }} {{ $selectedCar->model }}</h2>
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
                @if($selectedCar->additional_info)
                <div class="mt-4 bg-gray-50 p-3 rounded">
                    <p class="text-xs text-gray-500">Бележки</p>
                    <p class="font-medium">{{ $selectedCar->additional_info }}</p>
                </div>
                @endif
            </div>
            @else
            <div class="p-6 text-center text-gray-500">
                <p>Изберете кола за да видите детайлите</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Repairs -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Ремонти</h2>
            @if($selectedCar)
            <a href="{{ route('admin.repairs.create') }}?client_id={{ $client->id }}&car_id={{ $selectedCar->id }}" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                <i class="fa-solid fa-plus mr-1"></i>Добави ремонт
            </a>
            @endif
        </div>
        <div class="overflow-x-auto" id="repairs-container">
            @if($repairs->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Кола</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ремонт</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Част</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Км</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Труд</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Части</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($repairs as $repair)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $selectedCar->brand ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $repair->repair }}</td>
                        <td class="px-6 py-4 text-sm">{{ $repair->part ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($repair->kilometers) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($repair->work_cost, 2) }} лв.</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ number_format($repair->part_cost, 2) }} лв.</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <a href="{{ route('admin.repairs.edit', $repair->id) }}" class="text-yellow-600 hover:text-yellow-800 mr-2">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <form action="{{ route('admin.repairs.destroy', $repair->id) }}" method="POST" class="inline delete-repair-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 delete-repair-btn">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="p-6 text-center text-gray-500">
                <i class="fa-solid fa-wrench text-4xl mb-2"></i>
                <p>Няма ремонти за тази кола</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.delete-repair-btn').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');

        Swal.fire({
            title: 'Сигурен ли си?',
            text: 'Това ще изтрие ремонта!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Да, изтрий!',
            cancelButtonText: 'Отказ',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // AJAX car selection
    $('.car-select').on('click', function() {
        var carId = $(this).data('car-id');
        var clientId = {{ $client->id }};

        $.ajax({
            url: '/admin/get-car-info-and-repairs',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                selectedCar: carId,
                clientId: clientId
            },
            success: function(data) {
                // Reload page with selected car
                window.location.href = '{{ route("admin.clients.show", $client->id) }}?car=' + carId;
            }
        });
    });
});
</script>
@endpush
@endsection
