@extends('admin.layouts.app')

@section('title', 'Администратори')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Администратори</h1>
            <p class="text-gray-600">Управление на администраторски акаунти</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition inline-flex items-center">
            <i class="fa-solid fa-user-plus mr-2"></i>Нов администратор
        </a>
    </div>

    <!-- Admins Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Име</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Създаден</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($admins as $admin)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-user-shield text-purple-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $admin->name }}
                                    @if($admin->id === auth()->id())
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Вие</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm text-gray-900">{{ $admin->email }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $admin->created_at->format('d.m.Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($admin->id !== auth()->id())
                        <a href="{{ route('admin.users.edit', $admin->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 delete-btn">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        Няма администратори
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $admins->links() }}
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
                text: 'Това ще изтрие администраторския акаунт!',
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
