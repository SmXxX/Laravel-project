@extends('admin.layouts.app')

@section('title', $car->brand . ' ' . $car->model)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="{{ route('admin.cars.index') }}" class="text-gray-600 hover:text-gray-800 text-sm">
                <i class="fa-solid fa-arrow-left mr-1"></i>Назад към коли
            </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-2">{{ $car->brand }} {{ $car->model }}</h1>
            <p class="text-gray-600">{{ $car->plate }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.cars.edit', $car->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                <i class="fa-solid fa-pencil mr-2"></i>Редактирай
            </a>
            <a href="{{ route('admin.repairs.create') }}?car_id={{ $car->id }}&client_id={{ $car->client_id }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fa-solid fa-wrench mr-2"></i>Добави ремонт
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Car Details -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Информация за колата</h2>
            </div>
            <div class="p-6">
                @if($car->image)
                <img src="{{ $car->image }}" alt="{{ $car->brand }}" class="w-full h-48 object-cover rounded-lg mb-4">
                @endif
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Клиент</p>
                        <a href="{{ route('admin.clients.show', $car->client->id ?? 0) }}" class="font-medium text-blue-600 hover:underline">
                            {{ $car->client->name ?? 'N/A' }}
                        </a>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Рег. номер</p>
                        <p class="font-medium">{{ $car->plate }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">VIN</p>
                        <p class="font-medium">{{ $car->vin_num ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Година</p>
                        <p class="font-medium">{{ $car->year }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Цвят</p>
                        <p class="font-medium">{{ $car->color ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Двигател</p>
                        <p class="font-medium">{{ $car->engine ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">HP / kW</p>
                        <p class="font-medium">{{ $car->hp ?? 'N/A' }} / {{ intval(($car->hp ?? 0) * 0.7457) }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-xs text-gray-500">Гориво</p>
                        <p class="font-medium">{{ $car->fuel ?? 'N/A' }}</p>
                    </div>
                </div>
                @if($car->additional_info)
                <div class="mt-4 bg-gray-50 p-3 rounded">
                    <p class="text-xs text-gray-500">Бележки</p>
                    <p class="font-medium">{{ $car->additional_info }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Stats -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Статистика</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <p class="text-3xl font-bold text-blue-600">{{ $repairs->count() }}</p>
                        <p class="text-sm text-gray-600">Общо ремонти</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-3xl font-bold text-green-600">{{ number_format($repairs->sum('work_cost') + $repairs->sum('part_cost'), 2) }}</p>
                        <p class="text-sm text-gray-600">лв. общо</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Repairs -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Ремонти ({{ $repairs->count() }})</h2>
            <a href="{{ route('admin.repairs.create') }}?car_id={{ $car->id }}&client_id={{ $car->client_id }}" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition">
                <i class="fa-solid fa-plus mr-1"></i>Добави
            </a>
        </div>
        <div class="overflow-x-auto">
            @if($repairs->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ремонт</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Част</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Километри</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Труд</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Части</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
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
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <a href="{{ route('admin.repairs.edit', $repair->id) }}" class="text-yellow-600 hover:text-yellow-800 mr-2">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <form action="{{ route('admin.repairs.destroy', $repair->id) }}" method="POST" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 delete-btn">
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
    $('.delete-btn').on('click', function(e) {
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
});
</script>
@endpush
@endsection
