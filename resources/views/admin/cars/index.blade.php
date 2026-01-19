@extends('admin.layouts.app')

@section('title', 'Коли')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Коли</h1>
            <p class="text-gray-600">Всички регистрирани автомобили</p>
        </div>
        <a href="{{ route('admin.cars.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition inline-flex items-center">
            <i class="fa-solid fa-car mr-2"></i>Нова кола
        </a>
    </div>

    <!-- Cars Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Кола</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Рег. номер</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Клиент</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Година</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Двигател</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($cars as $car)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-car text-green-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $car->brand }} {{ $car->model }}</div>
                                <div class="text-sm text-gray-500">{{ $car->color ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-medium text-gray-900">{{ $car->plate }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.clients.show', $car->client->id ?? 0) }}" class="text-sm text-blue-600 hover:underline">
                            {{ $car->client->name ?? 'N/A' }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $car->year }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $car->engine ?? 'N/A' }} | {{ $car->hp ?? 'N/A' }} HP
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.cars.show', $car->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.cars.edit', $car->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" class="inline delete-form">
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
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Няма регистрирани коли
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $cars->links() }}
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
                text: 'Това ще изтрие колата и всичките ѝ ремонти!',
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
