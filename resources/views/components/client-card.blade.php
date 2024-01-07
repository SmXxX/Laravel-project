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
        <form method="POST" action="/clients/{{$client->id}}" data-client-id="{{$client->id}}">
            @csrf
            @method('DELETE')
            <button class="text-red-500 delete-client-button"><i class="fa-solid fa-trash"></i> Изтрий клиент</button>
        </form>
    </div>
    @push("scripts")
        <script>
            jQuery(document).ready(function($){
                $(document).on('click', '.delete-client-button', function(event){
                    event.preventDefault();
                    var form = $(this).closest('form'); // Get the closest form element
                    var clientId = form.data('client-id'); // Retrieve the repair ID from the form data attribute
                    // Display SweetAlert confirmation dialog
                    Swal.fire({
                        title: 'Сигурен ли си?',
                        text: 'Няма да можеш да върнеш този клиент!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Да',
                        cancelButtonText: 'Не',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, submit the form for repair deletion
                            form.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-card>