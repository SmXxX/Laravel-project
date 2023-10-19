@props(['client'])
<x-card>
    <a href="{{route('single',$client->id)}}">
        <div class="flex">
            <div>
                <h3 class="text-2xl">
                    {{$client->name}}
                </h3>
                <div class="text-xl mb-4">Телефонен номер - <a href="tel:{{$client->phone_number}}" class="font-bold">{{$client->phone_number}}</a></div>
            </div>
        </div>
    </a>
</x-card>