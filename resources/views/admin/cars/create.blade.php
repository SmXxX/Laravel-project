@extends('admin.layouts.app')

@section('title', 'Нова кола')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.cars.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fa-solid fa-arrow-left mr-2"></i>Назад към коли
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h1 class="text-xl font-bold text-gray-800">Добавяне на нова кола</h1>
        </div>

        <form action="{{ route('admin.cars.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">Клиент *</label>
                <select id="client_id" name="client_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('client_id') border-red-500 @enderror">
                    <option value="">Изберете клиент</option>
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id', request('client_id')) == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} ({{ $client->phone_number }})
                    </option>
                    @endforeach
                </select>
                @error('client_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Марка *</label>
                    <input type="text" id="brand" name="brand" value="{{ old('brand') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('brand') border-red-500 @enderror"
                        placeholder="BMW, Audi, Mercedes...">
                    @error('brand')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Модел *</label>
                    <input type="text" id="model" name="model" value="{{ old('model') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('model') border-red-500 @enderror"
                        placeholder="320d, A4, C200...">
                    @error('model')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="plate" class="block text-sm font-medium text-gray-700 mb-1">Регистрационен номер *</label>
                    <input type="text" id="plate" name="plate" value="{{ old('plate') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('plate') border-red-500 @enderror"
                        placeholder="A1234BC">
                    @error('plate')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Година *</label>
                    <input type="number" id="year" name="year" value="{{ old('year') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('year') border-red-500 @enderror"
                        placeholder="2020" min="1900" max="{{ date('Y') + 1 }}">
                    @error('year')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="vin_num" class="block text-sm font-medium text-gray-700 mb-1">VIN номер</label>
                    <input type="text" id="vin_num" name="vin_num" value="{{ old('vin_num') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="WVWZZZ3CZWE123456">
                </div>

                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Цвят</label>
                    <input type="text" id="color" name="color" value="{{ old('color') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Черен, Бял, Сив...">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="engine" class="block text-sm font-medium text-gray-700 mb-1">Двигател</label>
                    <input type="text" id="engine" name="engine" value="{{ old('engine') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="2.0 TDI">
                </div>

                <div>
                    <label for="hp" class="block text-sm font-medium text-gray-700 mb-1">HP</label>
                    <input type="number" id="hp" name="hp" value="{{ old('hp') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="150">
                </div>

                <div>
                    <label for="fuel" class="block text-sm font-medium text-gray-700 mb-1">Гориво</label>
                    <select id="fuel" name="fuel"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Изберете</option>
                        <option value="Бензин" {{ old('fuel') == 'Бензин' ? 'selected' : '' }}>Бензин</option>
                        <option value="Дизел" {{ old('fuel') == 'Дизел' ? 'selected' : '' }}>Дизел</option>
                        <option value="Газ" {{ old('fuel') == 'Газ' ? 'selected' : '' }}>Газ</option>
                        <option value="Бензин+Газ" {{ old('fuel') == 'Бензин+Газ' ? 'selected' : '' }}>Бензин+Газ</option>
                        <option value="Електрически" {{ old('fuel') == 'Електрически' ? 'selected' : '' }}>Електрически</option>
                        <option value="Хибрид" {{ old('fuel') == 'Хибрид' ? 'selected' : '' }}>Хибрид</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Снимка (URL)</label>
                <input type="url" id="image" name="image" value="{{ old('image') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="https://example.com/image.jpg">
            </div>

            <div>
                <label for="additional_info" class="block text-sm font-medium text-gray-700 mb-1">Допълнителна информация</label>
                <textarea id="additional_info" name="additional_info" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Бележки за колата...">{{ old('additional_info') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.cars.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Отказ
                </a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="fa-solid fa-save mr-2"></i>Добави кола
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
