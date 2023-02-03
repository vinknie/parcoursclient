@extends('dashboard')

@section('content')
    <h1>{{ $category->title }}</h1>

    @foreach ($getverbatim as $verbatim)
        <div class=" rounded overflow-hidden shadow-lg m-4">


            <div class="px-6 py-4 flex justify-between">
                <div class="font-bold text-xl mb-2">{{ $verbatim->verbatim }}</div>

                <div class="flex items-center">
                    <form action="{{ route('admin.updatepositif' , $verbatim->id_verbatim) }}" method="POST">
                        @csrf
                        @method('PATCH')
                
                        <input type="hidden" name="positif" value="positif">
                        <input type="hidden" name="value" value="{{ $verbatim->positif + 1 }}">
                
                        <button class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 rounded-l">
                          <i class="fas fa-thumbs-up"></i>
                        </button>
                    </form>

                    <form action="{{ route('admin.updateneutre' , $verbatim->id_verbatim) }}" method="POST">
                        @csrf
                        @method('PATCH')
                
                        <input type="hidden" name="neutre" value="neutre">
                        <input type="hidden" name="value" value="{{ $verbatim->neutre + 1 }}">
                
                        <button class="bg-gray-500 hover:bg-gray-400 text-white font-bold py-2 px-4 mx-2 rounded-l">
                            <i class="fas fa-equals"></i>
                        </button>
                    </form>
                    <form action="{{ route('admin.updatenegatif' , $verbatim->id_verbatim) }}" method="POST">
                        @csrf
                        @method('PATCH')
                
                        <input type="hidden" name="negatif" value="negatif">
                        <input type="hidden" name="value" value="{{ $verbatim->negatif + 1 }}">
                
                        <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded-l">
                            <i class="fas fa-thumbs-down"></i>
                        </button>
                    </form>
                    
                   
                </div>
            </div>

            <div class="flex justify-between w-1/3">
                <p class="text-gray-700 mb-4">Positif: {{ $verbatim->positif ? $verbatim->positif : 0 }}</p>
                <p class="text-gray-700 mb-4">neutre: {{ $verbatim->neutre ? $verbatim->neutre : 0 }}</p>
                <p class="text-gray-700 mb-4">Negatif: {{ $verbatim->negatif ? $verbatim->negatif : 0 }}</p>
            </div>
        </div>
    @endforeach
@endsection
