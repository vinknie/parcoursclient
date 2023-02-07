@extends('dashboard')

@section('content')

    <h1>{{ $category->title }}</h1>
    <div class="category-list">
    @foreach ($getverbatim as $verbatim)
    
        <div class=" rounded overflow-hidden shadow-lg m-4 category-card" data-id="{{ $verbatim->id_verbatim }}">


            <div class="px-6 py-4 flex justify-between">
                <h3 class="text-lg font-medium">{{ $verbatim->position }}. {{ $verbatim->verbatim }}</h3>

                <div class="flex items-center">
                    <div>
                        <form action="{{ route('admin.updatepositif', $verbatim->id_verbatim) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="positif" value="positif">
                            <input type="hidden" name="value" value="{{ $verbatim->positif + 1 }}">

                            <button class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 rounded-l">
                                <i class="fas fa-thumbs-up"></i>
                            </button>
                        </form>

                        <form action="{{ route('admin.decreasepositif', $verbatim->id_verbatim) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="positif" value="positif">
                            <input type="hidden" name="value" value="{{ $verbatim->positif - 1 }}">

                            <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </form>
                    </div>

                    <div>
                    <form action="{{ route('admin.updateneutre', $verbatim->id_verbatim) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="neutre" value="neutre">
                        <input type="hidden" name="value" value="{{ $verbatim->neutre + 1 }}">

                        <button class="bg-gray-500 hover:bg-gray-400 text-white font-bold py-2 px-4 mx-2 rounded-l">
                            <i class="fas fa-equals"></i>
                        </button>
                    </form>
                    <form action="{{ route('admin.decreaseneutre', $verbatim->id_verbatim) }}" method="POST">
                        @csrf
                        @method('PATCH')
    
                        <input type="hidden" name="neutre" value="neutre">
                        <input type="hidden" name="value" value="{{ $verbatim->neutre - 1 }}">
    
                        <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                    </form>
                    </div>
                    <div>
                    <form action="{{ route('admin.updatenegatif', $verbatim->id_verbatim) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="negatif" value="negatif">
                        <input type="hidden" name="value" value="{{ $verbatim->negatif + 1 }}">

                        <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 rounded-l">
                            <i class="fas fa-thumbs-down"></i>
                        </button>
                    </form>
                    <form action="{{ route('admin.decreasenegatif', $verbatim->id_verbatim) }}" method="POST">
                        @csrf
                        @method('PATCH')
    
                        <input type="hidden" name="negatif" value="negatif">
                        <input type="hidden" name="value" value="{{ $verbatim->negatif - 1 }}">
    
                        <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                    </form>
                    </div>
                </div>

            </div>

            <div class="flex justify-between w-1/3">
                <p class="text-gray-700 mb-4">Positif: {{ $verbatim->positif ? $verbatim->positif : 0 }}</p>
                
                <p class="text-gray-700 mb-4">neutre: {{ $verbatim->neutre ? $verbatim->neutre : 0 }}</p>
                
                <p class="text-gray-700 mb-4">Negatif: {{ $verbatim->negatif ? $verbatim->negatif : 0 }}</p>
               
            </div>
        </div>
   
    @endforeach
 </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $( ".category-list" ).sortable({
                update: function(event, ui) {
                    var positions = [];
                    $('.category-card').each(function(i) {
                        positions[i] = $(this).data('id');
                    });
                    $.ajax({
                        type: 'POST',
                        url: '/dashboard/note/update-verbatim-positions',
                        data: {
                            positions: positions,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            console.log("AJAX call success");
                            $('.category-card').each(function(i) {
                                $(this).find('.text-lg.font-medium').text((i + 1) + '. ' + $(this).find('.text-lg.font-medium').text().split('.')[1]);
                                // return true;
                                console.log(data);
                                
                            });
                        }
                    });
                }
            });
            $( ".category-list" ).disableSelection();
        });
    </script>

@endsection
