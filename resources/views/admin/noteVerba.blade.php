@extends('master')
<style>
    .dialogue-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .dialogue-popup .card {
        width: 80%;
        margin: 20px auto;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
    }

    .close-button {
        font-size: 1.5rem;
    }
</style>

@section('content')

@if(Auth::check() && Auth::user()->role === 'admin')
<span class="text-sm font-medium text-gray-500 mt-16"> * Déplacé les cartes pour modifier l'ordre des étapes qui
    apparaitront
    dans le graphique</span>
@endif

<div class="text-center mt-16">
    <h1 class="text-2xl font-medium">{{ $category->title }}</h1>
</div>

<div class="category-list">
    @foreach ($getverbatim as $verbatim)
    {{-- @dd($getverbatim) --}}
    <div class=" rounded-lg overflow-hidden shadow-lg m-4 category-card" data-id="{{ $verbatim->id_verbatim }}">
        <div class="px-6 py-4 flex justify-between">
            <div class="m-4">
                <h3 class="text-lg font-medium">{{ $verbatim->position }}. {{ $verbatim->verbatim }}</h3>

                {{-- button popup dialogue --}}
                <button class="popup-trigger" data-id-verbatim="{{ $verbatim->id_verbatim }}"
                    @if($verbatim->dialogue_count == 0) disabled @endif>{{ $verbatim->dialogue_count }}
                    Dialogue(s)
                </button>
            </div>

            <div class="flex items-center">
                <div>
                    <form action="{{ route('admin.updatepositif', $verbatim->id_verbatim) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="positif" value="positif">
                        <input type="hidden" name="value" value="{{ $verbatim->positif + 1 }}">
                        <button
                            class="bg-green-500 hover:bg-green-400 text-white font-bold py-3 px-5 m-1 rounded-lg shadow-lg">
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
                        <button
                            class="bg-gray-500 hover:bg-gray-400 text-white font-bold py-3 px-5 m-1 rounded-lg shadow-lg">
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

                        <button
                            class="bg-red-500 hover:bg-red-400 text-white font-bold py-3 px-5 m-1 rounded-lg shadow-lg">
                            <i class="fas fa-thumbs-down"></i>
                        </button>
                    </form>

                </div>
                <div>

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
                <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded-sm">
                    <i class="fas fa-minus"></i>
                </button>
            </form>

            <p class="text-gray-700 mb-4">neutre: {{ $verbatim->neutre ? $verbatim->neutre : 0 }}</p>
            <form action="{{ route('admin.decreaseneutre', $verbatim->id_verbatim) }}" method="POST">
                @csrf
                @method('PATCH')

                <input type="hidden" name="neutre" value="neutre">
                <input type="hidden" name="value" value="{{ $verbatim->neutre - 1 }}">

                <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded-sm">
                    <i class="fa-solid fa-minus"></i>
                </button>
            </form>

            <p class="text-gray-700 mb-4">Negatif: {{ $verbatim->negatif ? $verbatim->negatif : 0 }}</p>
            <form action="{{ route('admin.decreasenegatif', $verbatim->id_verbatim) }}" method="POST">
                @csrf
                @method('PATCH')

                <input type="hidden" name="negatif" value="negatif">
                <input type="hidden" name="value" value="{{ $verbatim->negatif - 1 }}">

                <button class="bg-red-500 hover:bg-red-400 text-white font-bold py-1 px-2 rounded-sm"
                    id="decrease-button">
                    <i class="fa-solid fa-minus"></i>
                </button>
            </form>

        </div>
        @if(Auth::check() && Auth::user()->role === 'admin')
        <form action="{{ route('admin.resetvalues', $verbatim->id_verbatim) }}" method="POST">
            @csrf
            @method('PATCH')

            <button onclick="return confirm('Etes vous sur de vouloir Reset les notes?')" type="submit" id="reset"
                class="text-dark font-bold py-3 px-5 m-1"><i class="fa-solid fa-rotate-left"></i>
            </button>
            <span class="hide">Reset</span>
        </form>
        <style>
            .hide {
                display: none;
            }

            #reset:hover+.hide {
                display: inline;
                color: red;
            }
        </style>
        @endif
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

        $('.popup-trigger').click(function() {
            var id_verbatim = $(this).data('id-verbatim');
    
            $.ajax({
                url: '/dashboard/note/get-dialogues',
                type: 'POST',
                dataType: 'json',
                data: {
                    id_verbatim: id_verbatim,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log('Données renvoyées :', data);

                    // Vérifier si les données sont correctement formatées
                    if (typeof data === 'object' && data !== null) {
                        // Générer le contenu HTML des cartes de dialogue
                        var dialoguesHTML = '';
                        var verbatim = data[0].verbatim;
                        $.each(data, function(index, dialogue) {
                            var sentimentIcon = '';
                            if (dialogue.positif > 0) {
                                sentimentIcon += '<span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-green-500 text-white flex-shrink-0 mr-2">+</span>';
                            } else if (dialogue.neutre > 0) {
                                sentimentIcon += '<span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-gray-500 text-white flex-shrink-0 mr-2">=</span>';
                            } else if (dialogue.negatif > 0) {
                                sentimentIcon += '<span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-red-500 text-white flex-shrink-0 mr-2">-</span>';
                            }

                        dialoguesHTML += '<div class="bg-white shadow-md rounded px-8 py-6 m-4">';
                        dialoguesHTML += '<div class="flex items-center mb-4">' + sentimentIcon + '<h2 class="text-lg font-medium text-gray-800">' + dialogue.dialogue + '</h2>';
                        dialoguesHTML += '<button class="delete-button ml-auto text-gray-600 hover:text-gray-800" data-dialogue-id="' + dialogue.id_dialogue + '">&times;</button></div>';
                        dialoguesHTML += '<input type="hidden" name="dialogue_id" value="' + dialogue.id_dialogue + '">';
                        dialoguesHTML += '</div>';
                        });

                        var popupHTML = '<div class="dialogue-popup flex items-center justify-center fixed left-0 bottom-0 w-full h-full bg-gray-800 bg-opacity-75">';
                        popupHTML += '<div class="dialogue-container bg-white w-2/3 lg:max-w-lg mx-auto rounded shadow-lg z-50 overflow-y-auto relative">';
                        popupHTML += '<h1 class="text-xl font-bold text-gray-800 m-4 text-center">'+verbatim+'</h1>';
                        popupHTML += dialoguesHTML;
                        popupHTML += '<button class="close-button absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800">&times;</button>';
                        popupHTML += '</div>';
                        popupHTML += '</div>';

                        $('body').append(popupHTML);

                        $('.close-button').on('click', function() {
                            $('.dialogue-popup').remove();
                        });
                    } else {
                    console.log('Erreur : données incorrectes');
                    }
                },
                error: function() {
                    alert('Une erreur s\'est produite.');
                }
            });
        });

        $(document).on('click', '.delete-button', function() {
            var dialogueId = $(this).data('dialogue-id');
            if (confirm("Êtes-vous sûr de vouloir supprimer ce dialogue ?")) {
                deleteDialogue(dialogueId);
                $(this).closest('.bg-white').remove();
            }
        });
        function deleteDialogue(dialogueId) {
            console.log(dialogueId)
            $.ajax({
                url: '/dashboard/note/deleteDialogue/' + dialogueId,
                type: 'DELETE',
                data: {
                '_token': '{{ csrf_token() }}'
            },
                success: function(response) {
                    console.log('Dialogue supprimé avec succès');
                },
                error: function(error) {
                    console.error('Erreur lors de la suppression du dialogue', error);
                }
            });
        }



</script>

@endsection