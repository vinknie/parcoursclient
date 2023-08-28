<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Parcours Client</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- custom css --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/css/app.css')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
 <!-- Authentication -->
     @include('layouts.navigation')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold mb-4">Bienvenue, {{ $user->name }}!</h1>

        <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="border-b-2 border-gray-300 flex-grow"></div>
                <h2 class="text-2xl font-semibold px-4">À quel événement avez-vous participé ?</h2>
                <div class="border-b-2 border-gray-300 flex-grow"></div>
            </div>

            <form method="POST" action="{{ route('submitEvent') }}">
                @csrf
                <div class="flex items-center mb-4">
                    <label for="event" class="text-gray-700 text-sm font-bold mr-2">Sélectionnez un événement :</label>
                    <div class="relative">
                        <select id="event" name="event" class="appearance-none bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($events as $event)
                                <option value="{{ $event->id_event }}">{{ $event->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Valider
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>