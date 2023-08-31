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


    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JqueryUI -->
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

    {{-- manual javascript --}}
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{-- Chart Js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.0/dist/chart.umd.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js"
        integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- custom css --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/css/app.css')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @include('layouts.navigation')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold mb-4">Satisfaction de l'événement</h1>
    
        <h2 class="text-2xl font-semibold mb-2">Catégories de l'événement :</h2>
        <div class="container mx-auto px-4 py-8">
            @foreach ($categories as $category)
                <div>
                    <h2 class="text-2xl font-semibold mb-2">{{ $category->title }}</h2>
        
                    @foreach ($verbatimsByCategory[$category->id_category] as $verbatim)
                        <div class="rounded-lg overflow-hidden shadow-lg m-4 px-4 py-4 category-card" data-id="{{ $verbatim->id_verbatim }}">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-lg font-medium tracking-wider font-semibold">{{ $verbatim->position }}. {{ $verbatim->verbatim }}</h3>
                                   
                                </div>
                                <div class="flex items-center">
                                    @php
                                    $userVote = $verbatim->userVote(auth()->user()->id); // Ajoutez cette méthode dans le modèle Verbatim
                                    @endphp
                                     @if ($userVote)
                                     <p>Déjà voté : {{ $userVote->vote_type }}</p>
                                 @else
                                    <form action="{{ route('satisfaction.updatepositif', $verbatim->id_verbatim) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="positif" value="positif">
                                        <input type="hidden" name="value" value="{{ $verbatim->positif + 1 }}">
                                        <button class="bg-green-500 hover:bg-white text-white hover:text-green-500 hover:drop-shadow-md font-bold py-2 px-2 m-1 rounded-full shadow-lg" >
                                            <i class="fa-regular fa-thumbs-up"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('satisfaction.updateneutre', $verbatim->id_verbatim) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="neutre" value="neutre">
                                        <input type="hidden" name="value" value="{{ $verbatim->neutre + 1 }}">
                                        <button class="bg-gray-500 hover:bg-white text-white hover:text-gray-500 hover:drop-shadow-md font-bold py-2 px-2 m-1 rounded-full shadow-lg">
                                            <i class="fas fa-equals"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('satisfaction.updatenegatif', $verbatim->id_verbatim) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="negatif" value="negatif">
                                        <input type="hidden" name="value" value="{{ $verbatim->negatif + 1 }}">
                                        <button class="bg-red-500 hover:bg-white text-white hover:text-red-500 hover:drop-shadow-md font-bold py-2 px-2 m-1 rounded-full shadow-lg">
                                            <i class="fa-regular fa-thumbs-down"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        
    </div>
















</body>
</html>