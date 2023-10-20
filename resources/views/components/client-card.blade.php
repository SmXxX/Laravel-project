@props(['client'])
<x-card>
    <a href="{{route('single',$client->id)}}">
        <div class="flex">
            <div>
                <h3 class="text-2xl">
                    {{$client->name}}
                </h3>
                <div class="text-xl mb-4">Телефонен номер - <a href="tel:{{$client->phone_number}}" class="font-bold">{{$client->phone_number}}</a></div>
                <div class="flex flex-col lg:flex-row gap-5">
                    <a href="{{route('edit_client',$client->id)}}">
                        <i class="fa-solid fa-pencil"></i> Редактирай клиент
                    </a>
                    <form method="POST" action="/clients/{{$client->id}}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500" onclick="return confirm('Сигурен ли си ?')"><i class="fa-solid fa-trash"></i> Изтрий клиент</button>
                    </form>
                </div>
            </div>
        </div>
    </a>
</x-card>