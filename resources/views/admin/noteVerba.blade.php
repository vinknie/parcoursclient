@extends('dashboard')

@section('content')
    <h1>{{ $category->title }}</h1>

    @foreach ($getverbatim as $verbatim)
        <div class=" rounded overflow-hidden shadow-lg m-4 w-full">


            <div class="px-6 py-4 flex justify-between">
                <div class="font-bold text-xl mb-2">{{ $verbatim->verbatim }}</div>
                <div class="flex items-center">
                    <button class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 rounded-l">
                        <i class="fas fa-thumbs-up"></i>
                    </button>
                    <button class="bg-gray-500 hover:bg-gray-400 text-white font-bold py-2 px-4 mx-2 rounded-l">
                        <i class="fas fa-equals"></i>
                    </button>
                    <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded-l">
                        <i class="fas fa-thumbs-down"></i>
                    </button>
                </div>
            </div>

            <div class="flex justify-between">
                <p class="text-gray-700 mb-4">Positif: {{ $verbatim->positif ? $verbatim->positif : 0 }}</p>
                <p class="text-gray-700 mb-4">neutre: {{ $verbatim->neutre ? $verbatim->neutre : 0 }}</p>
                <p class="text-gray-700 mb-4">Negatif: {{ $verbatim->negatif ? $verbatim->negatif : 0 }}</p>
            </div>
        </div>
    @endforeach
@endsection
