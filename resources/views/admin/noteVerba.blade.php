@extends('master')

@section('content')

@if(Auth::check() && Auth::user()->role === 'admin')
<span class="text-sm font-medium text-gray-500"> * Déplacé les cartes pour modifier l'ordre des étapes qui apparaitront dans le graphique</span>
@endif

<div class="text-center">
    <h1 class="text-2xl font-medium">{{ $category->title }}</h1>
</div>

<div class="category-list">
@foreach ($getverbatim as $verbatim)
<div class=" rounded-lg overflow-hidden shadow-lg m-4 category-card" data-id="{{ $verbatim->id_verbatim }}">
    <div class="px-6 py-4 flex justify-between">
        <h3 class="text-lg font-medium">{{ $verbatim->position }}. {{ $verbatim->verbatim }}</h3>
        <div class="flex items-center">
            <div>
                <form action="{{ route('admin.updatepositif', $verbatim->id_verbatim) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="positif" value="positif">
                    <input type="hidden" name="value" value="{{ $verbatim->positif + 1 }}">
                    <button class="bg-green-500 hover:bg-green-400 text-white font-bold py-3 px-5 m-1 rounded-lg shadow-lg">
                        <i class="fas fa-thumbs-up"></i>    
                    </button>
                </form>
               
            </div>
            <div>
                <form action="{{ route('admin.updateneutre', $verbatim->id_verbatim) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="neutre" value="neutre">
                    <input type="hidden" name="value" value="{{ $verbatim->neutre + 1 }}">
                    <button class="bg-gray-500 hover:bg-gray-400 text-white font-bold py-3 px-5 m-1 rounded-lg shadow-lg">
                        <i class="fas fa-equals"></i>
                    </button>
                </form>
                    
                </div>
                <div>
                    <form action="{{ route('admin.updatenegatif', $verbatim->id_verbatim) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="negatif" value="negatif">
                        <input type="hidden" name="value" value="{{ $verbatim->negatif + 1 }}">

                        <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-3 px-5 m-1 rounded-lg shadow-lg">
                            <i class="fas fa-thumbs-down"></i>
                        </button>
                    </form>
                    
                </div>
            </div>

        </div>

        <div class="flex justify-between w-1/3">
            
            <p class="text-gray-700 mb-4">Positif: {{ $verbatim->positif ? $verbatim->positif : 0 }}</p>
            <form action="{{ route('admin.decreasepositif', $verbatim->id_verbatim) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="positif" value="positif">
                <input type="hidden" name="value" value="{{ $verbatim->positif - 1 }}">
                <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded">
                    <i class="fas fa-minus"></i>
                </button>
            </form>

            <p class="text-gray-700 mb-4">neutre: {{ $verbatim->neutre ? $verbatim->neutre : 0 }}</p>
            <form action="{{ route('admin.decreaseneutre', $verbatim->id_verbatim) }}" method="POST">
                @csrf
                @method('PATCH')

                <input type="hidden" name="neutre" value="neutre">
                <input type="hidden" name="value" value="{{ $verbatim->neutre - 1 }}">

                <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded">
                    <i class="fa-solid fa-minus"></i>
                </button>
            </form>

            <p class="text-gray-700 mb-4">Negatif: {{ $verbatim->negatif ? $verbatim->negatif : 0 }}</p>
            <form action="{{ route('admin.decreasenegatif', $verbatim->id_verbatim) }}" method="POST">
                @csrf
                @method('PATCH')

                <input type="hidden" name="negatif" value="negatif">
                <input type="hidden" name="value" value="{{ $verbatim->negatif - 1 }}">

                <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded" id="decrease-button">
                    <i class="fa-solid fa-minus"></i>
                </button>
            </form>

        </div>
    </div>

    @endforeach
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>

    var isAdmin = {{ Auth::check() && Auth::user()->role === 'admin' ? true : false }};
        $(function() {
            if (isAdmin) {
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
                                return true;
                                console.log(data);
                                
                            });
                        }
                    });
                }
            });
            $( ".category-list" ).disableSelection();
        }


        });


       
        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };

        
    </script>

@endsection

