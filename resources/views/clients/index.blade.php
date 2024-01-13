 <x-layout>
    @include('partials._search') 
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-2 lg:space-y-0 mx-4">
        {{-- @if (session('message'))
            <div x-data="{show:true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-[#007CCA] text-white px-48 xs-px-12 py-3">
                <p>
                    {{session('message')}}
                </p>
            </div>
        @endif --}}
        @if(count($clients)==0)
            <p>Все още нямате клиентиииииии в сервиза.</p>
        @endif
        @foreach($clients as $client)
            <x-client-card :client="$client"/>
        @endforeach
    </div>
        
        <div class="mt-6 p-4">
            {{$clients->links()}}
        </div>
</x-layout>