@extends('admin.layouts.app')

@section('title', 'Редактиране на ремонт')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.repairs.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fa-solid fa-arrow-left mr-2"></i>Назад към ремонти
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h1 class="text-xl font-bold text-gray-800">Редактиране на ремонт</h1>
            <p class="text-gray-600 mt-1">
                {{ $repair->car->brand ?? '' }} {{ $repair->car->model ?? '' }} -
                {{ $repair->car->client->name ?? '' }}
            </p>
        </div>

        <form action="{{ route('admin.repairs.update', $repair->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Клиент</label>
                <select id="client_id" name="client_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}"
                        data-cars="{{ json_encode($client->cars) }}"
                        {{ $repair->car->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} ({{ $client->phone_number }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="car_id" class="block text-sm font-medium text-gray-700 mb-1">Кола *</label>
                <select id="car_id" name="car_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('car_id') border-red-500 @enderror">
                    @foreach($repair->car->client->cars ?? [] as $car)
                    <option value="{{ $car->id }}" {{ old('car_id', $repair->car_id) == $car->id ? 'selected' : '' }}>
                        {{ $car->brand }} {{ $car->model }} ({{ $car->plate }})
                    </option>
                    @endforeach
                </select>
                @error('car_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="repair" class="block text-sm font-medium text-gray-700 mb-1">Описание на ремонта *</label>
                <textarea id="repair" name="repair" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('repair') border-red-500 @enderror">{{ old('repair', $repair->repair) }}</textarea>
                @error('repair')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="part" class="block text-sm font-medium text-gray-700 mb-1">Сменена част</label>
                <input type="text" id="part" name="part" value="{{ old('part', $repair->part) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="kilometers" class="block text-sm font-medium text-gray-700 mb-1">Километри</label>
                    <input type="number" id="kilometers" name="kilometers" value="{{ old('kilometers', $repair->kilometers) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        min="0">
                </div>

                <div>
                    <label for="work_cost" class="block text-sm font-medium text-gray-700 mb-1">Цена труд (лв.)</label>
                    <input type="number" step="0.01" id="work_cost" name="work_cost" value="{{ old('work_cost', $repair->work_cost) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        min="0">
                </div>

                <div>
                    <label for="part_cost" class="block text-sm font-medium text-gray-700 mb-1">Цена части (лв.)</label>
                    <input type="number" step="0.01" id="part_cost" name="part_cost" value="{{ old('part_cost', $repair->part_cost) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        min="0">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.repairs.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Отказ
                </a>
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                    <i class="fa-solid fa-save mr-2"></i>Запази промените
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#client_id').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var cars = selectedOption.data('cars');
        var carSelect = $('#car_id');

        carSelect.empty();
        carSelect.append('<option value="">Изберете кола</option>');

        if (cars && cars.length > 0) {
            cars.forEach(function(car) {
                carSelect.append('<option value="' + car.id + '">' + car.brand + ' ' + car.model + ' (' + car.plate + ')</option>');
            });
        }
    });
});
</script>
@endpush
@endsection
