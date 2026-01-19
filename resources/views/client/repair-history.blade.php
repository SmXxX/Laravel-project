@extends('client.layouts.app')

@section('title', 'История на ремонтите')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800">История на ремонтите</h1>
        <p class="text-gray-600 mt-1">Преглед на всички извършени ремонти по вашите коли.</p>
    </div>

    <!-- Repairs Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($repairs->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кола</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ремонт</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Част</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Километри</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Цена труд</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Цена части</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($repairs as $repair)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $repair->car->brand ?? 'N/A' }} {{ $repair->car->model ?? '' }}</div>
                        <div class="text-xs text-gray-500">{{ $repair->car->plate ?? '' }}</div>
                    </td>
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
            <i class="fa-solid fa-wrench text-6xl text-gray-300 mb-4"></i>
            <h2 class="text-xl font-semibold text-gray-600 mb-2">Няма регистрирани ремонти</h2>
            <p class="text-gray-500">Когато бъдат извършени ремонти по вашите коли, те ще се появят тук.</p>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($repairs->count() > 0)
    <div class="flex justify-center">
        {{ $repairs->links() }}
    </div>
    @endif
</div>
@endsection
