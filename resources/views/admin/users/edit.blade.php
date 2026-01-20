@extends('admin.layouts.app')

@section('title', 'Редактиране на ' . $user->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fa-solid fa-arrow-left mr-2"></i>Назад към администратори
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h1 class="text-xl font-bold text-gray-800">Редактиране на администратор</h1>
            <p class="text-gray-600 mt-1">{{ $user->email }}</p>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Име *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('name') border-red-500 @enderror">
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('email') border-red-500 @enderror">
                @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Нова парола (оставете празно за да запазите текущата)</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('password') border-red-500 @enderror"
                    placeholder="Минимум 6 символа">
                @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Потвърдете новата парола</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Отказ
                </a>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    <i class="fa-solid fa-save mr-2"></i>Запази промените
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
