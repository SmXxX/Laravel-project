@extends('admin.layouts.app')

@section('title', 'Редактиране на ' . $client->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.clients.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fa-solid fa-arrow-left mr-2"></i>Назад към клиенти
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h1 class="text-xl font-bold text-gray-800">Редактиране на клиент</h1>
            <p class="text-gray-600 mt-1">{{ $client->name }}</p>
        </div>

        <form action="{{ route('admin.clients.update', $client->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Client Information -->
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Информация за клиента</h2>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Име *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $client->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Телефонен номер *</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $client->phone_number) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone_number') border-red-500 @enderror">
                    @error('phone_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if($client->user)
            <!-- Account Information -->
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Потребителски акаунт</h2>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $client->user->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Нова парола (оставете празно за да запазите текущата)</label>
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                        placeholder="Минимум 6 символа">
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Потвърдете новата парола</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-yellow-800">
                    <i class="fa-solid fa-warning mr-2"></i>
                    Този клиент няма потребителски акаунт. За да създадете, изтрийте клиента и го създайте наново.
                </p>
            </div>
            @endif

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.clients.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Отказ
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fa-solid fa-save mr-2"></i>Запази промените
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
