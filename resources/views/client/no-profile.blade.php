@extends('client.layouts.app')

@section('title', 'Профил не е намерен')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <div class="mb-6">
            <i class="fa-solid fa-user-slash text-6xl text-gray-300"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Профилът не е намерен</h1>
        <p class="text-gray-600 mb-6">
            Вашият акаунт не е свързан с клиентски профил.
            Моля, свържете се с администратора за да бъде създаден вашият профил.
        </p>
        <div class="border-t pt-6">
            <p class="text-sm text-gray-500">
                Ако смятате, че това е грешка, моля свържете се с нас.
            </p>
        </div>
    </div>
</div>
@endsection
