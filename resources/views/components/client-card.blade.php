@props(['client'])
<x-card class="client-box">
    <div class="flex flex-col lg:flex-row justify-between">
        <div class="lg:w-1/2">
            <a @if($client->cars->count()>0)
                href="{{ route('single', $client->id) }}"
                @else
                href="#"
                onclick="alert('Този клиент няма кола, създайте новa!');"
                @endif>
                <div class="client-name">
                    <p class=heading-client>
                        Клиент
                    </p>
                    <h3 class="text-2xl underline">
                        {{$client->name}}
                    </h3>
                </div>
            </a>
        </div>
        <div class="border-b-2 lg:border-r-2 border-[#FF9800] lg:border-b-0 sm:border-r-0 my-5 lg:my-0 lg:mb-2  lg:mx-5 separator"></div>
        <div class="lg:w-1/2">
            <div class="client-phone">
                <a href="tel:{{$client->phone_number}}">
                    <p class=heading-phone>
                        Телефонен номер
                    </p>
                    <div class="text-xl font-bold mb-4 underline">{{$client->phone_number}}</div>
                </a>
            </div>
        </div>
    </div>
    <div class="flex flex-col lg:flex-row gap-5 mt-4">
        <a href="{{route('edit_client',$client->id)}}">
            <i class="fa-solid fa-pencil"></i> Редактирай клиент
        </a>
        <form method="POST" action="/clients/{{$client->id}}">
            @csrf
            @method('DELETE')
            <button class="text-red-500" onclick="return confirm('Сигурен ли си ?')"><i class="fa-solid fa-trash"></i> Изтрий клиент</button>
        </form>
    </div>
</x-card>