@extends('master')

@section('content')
<div class="flex">
    <div class="w-1/2 pr-4">
        <div class="text-center mt-20 mb-4">
            <h1 class="text-2xl font-semibold page-titles">Créer un Evènement</h1>
        </div>
        <x-guest-layout>
            @if(session('success'))
            <p class="text-green-400">{{ session('success') }}</p>
            @endif
            <form method="POST" action="{{ route('admin.storeEvent') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Créer') }}
                    </x-primary-button>
                </div>
            </form>
        </x-guest-layout>
    </div>
<div class="w-1/2 pr-4">
    <div class="text-center mt-20 mb-4">
        <h1 class="text-2xl font-semibold page-titles">Evènements</h1>
        @if(session('success_update'))
        <div class="success-msg">
            <p>{{ session('success_update') }}</p>
            <span class="success__cross-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
@endif
@if(session('success_delete'))
<div class="success-msg">
    <p>{{ session('success_delete') }}</p>
    <span class="success__cross-btn"><i class="fa-solid fa-xmark"></i></span>
</div>
@endif
    </div>
    <div class="event-table">
        @if(session('success'))
        <div class="success-msg">
            <p>{{ session('success') }}</p>
            <span class="success__cross-btn"><i class="fa-solid fa-xmark"></i></span>
        </div>
        @endif
        <table class="text-center rounded w-full">
            <thead class="text-white tracking-wider">
                <tr class="bg-gray-800">
                    <th class="py-3"><b>Nom</b></th>
                    <th class="py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr class="border-b-2">
                    <td class="py-2 cursor-pointer">
                        <span class="event-name">{{ $event->name }}</span>
                    </td>
                    <td class="py-2">
                        <div class="d-flex align-items-center">
                            <a href="#" class="edit-event mr-2" data-event="{{ json_encode($event) }}"><i class="fa-solid fa-pen text-gray-700"></i></a>
                            <span class="font-bold text-lg mr-2">/</span>
                            <form action="{{ route('admin.deleteEvent', ['id' => $event->id_event]) }}" method="POST" class="delete-event-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button ml-2"><i class="fa-solid fa-xmark text-red-700"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
<!-- Ajoutez ce script pour gérer l'événement de clic sur le bouton éditer -->
<script>
    document.querySelectorAll('.edit-event').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const eventData = JSON.parse(button.getAttribute('data-event'));
            const form = document.querySelector('form[action="{{ route('admin.storeEvent') }}"]');
            form.setAttribute('action', `{{ route('admin.updateEvent', ['id' => '_event_id_']) }}`.replace('_event_id_', eventData.id_event));
            form.querySelector('#name').value = eventData.name;
            const submitButton = form.querySelector('.ml-4');
            submitButton.textContent = 'Modifier';
        });
    });


</script>
@endsection


