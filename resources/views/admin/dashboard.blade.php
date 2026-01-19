@extends('admin.layouts.app')

@section('title', 'Табло')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fa-solid fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Общо клиенти</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalClients ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('admin.clients.index') }}" class="mt-4 inline-block text-sm text-blue-600 hover:underline">
                Виж всички <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fa-solid fa-car text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Общо коли</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalCars ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('admin.cars.index') }}" class="mt-4 inline-block text-sm text-green-600 hover:underline">
                Виж всички <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fa-solid fa-wrench text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Общо ремонти</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalRepairs ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('admin.repairs.index') }}" class="mt-4 inline-block text-sm text-orange-600 hover:underline">
                Виж всички <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Бързи действия</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.clients.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fa-solid fa-user-plus mr-2"></i>Нов клиент
            </a>
            <a href="{{ route('admin.cars.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fa-solid fa-car mr-2"></i>Нова кола
            </a>
            <a href="{{ route('admin.repairs.create') }}" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                <i class="fa-solid fa-wrench mr-2"></i>Нов ремонт
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Clients -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Последни клиенти</h2>
            </div>
            <div class="divide-y">
                @forelse($recentClients ?? [] as $client)
                <a href="{{ route('admin.clients.show', $client->id) }}" class="block p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">{{ $client->name }}</p>
                            <p class="text-sm text-gray-500">{{ $client->phone_number }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $client->cars->count() }} {{ $client->cars->count() == 1 ? 'кола' : 'коли' }}
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="p-4 text-gray-500 text-center">Няма клиенти</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Repairs -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Последни ремонти</h2>
            </div>
            <div class="divide-y">
                @forelse($recentRepairs ?? [] as $repair)
                <div class="p-4 hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">{{ Str::limit($repair->repair, 40) }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $repair->car->brand ?? 'N/A' }} {{ $repair->car->model ?? '' }} -
                                {{ $repair->car->client->name ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-800">{{ number_format($repair->work_cost + $repair->part_cost, 2) }} лв.</p>
                            <p class="text-xs text-gray-500">{{ $repair->created_at->format('d.m.Y') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-gray-500 text-center">Няма ремонти</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
