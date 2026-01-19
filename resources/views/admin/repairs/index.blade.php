@extends('admin.layouts.app')

@section('title', 'Ремонти')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Ремонти</h1>
            <p class="text-gray-600">Всички извършени ремонти</p>
        </div>
        <a href="{{ route('admin.repairs.create') }}" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition inline-flex items-center">
            <i class="fa-solid fa-wrench mr-2"></i>Нов ремонт
        </a>
    </div>

    <!-- Repairs Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Клиент</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кола</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ремонт</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Километри</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Обща цена</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($repairs as $repair)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.clients.show', $repair->car->client->id ?? 0) }}" class="text-sm text-blue-600 hover:underline">
                            {{ $repair->car->client->name ?? 'N/A' }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.cars.show', $repair->car->id ?? 0) }}" class="text-sm text-blue-600 hover:underline">
                            {{ $repair->car->brand ?? 'N/A' }} {{ $repair->car->model ?? '' }}
                        </a>
                        <p class="text-xs text-gray-500">{{ $repair->car->plate ?? '' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ Str::limit($repair->repair, 40) }}</div>
                        @if($repair->part)
                        <div class="text-xs text-gray-500">Част: {{ Str::limit($repair->part, 30) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ number_format($repair->kilometers) }} км
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-medium text-gray-900">{{ number_format($repair->work_cost + $repair->part_cost, 2) }} лв.</span>
                        <p class="text-xs text-gray-500">
                            Труд: {{ number_format($repair->work_cost, 2) }} | Части: {{ number_format($repair->part_cost, 2) }}
                        </p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $repair->created_at->format('d.m.Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.repairs.edit', $repair->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <form action="{{ route('admin.repairs.destroy', $repair->id) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 delete-btn">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Няма регистрирани ремонти
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $repairs->links() }}
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
