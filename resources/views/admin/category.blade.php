@extends('master')

@section('content')

    @if (request()->route('id_category'))
    <div class="grid grid-rows-3 grid-flow-col gap-4">
       
        <div class="row-span-6 text-3xl">
            <h1>Modifier l'étape</h1>
        @if (\Session::has('success'))
        
            <div 
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="bg-teal-100 border border-teal-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{!! \Session::get('success') !!}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        @endif
        @if (\Session::has('error'))
        
            <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
             class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{!! \Session::get('error') !!}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        @endif
        <form class="bg-white p-6 rounded-lg" action="{{ route('admin.updateCat' , $getcategory->id_category) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="title">Titre de l'étape</label>
                <input class="bg-white border border-gray-400 rounded w-full py-2 px-4" type="text" id="title" name="title" value="{{ $getcategory->title }}" required="">
            </div>
            <button id="btncreate" class="btn btn-success bg-indigo-500 text-white py-2 px-4 rounded-full hover:bg-indigo-600" type="submit">Modifier</button>      
        </form>
        </div>
        <div class="row-span-6 ">
            <h1>Modifier les verbatim</h1>
            @if (\Session::has('success1'))
          
            <div 
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="bg-teal-100 border border-teal-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{!! \Session::get('success1') !!}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                  <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
              </div>
        @endif
        @if (\Session::has('error1'))
          
            <div 
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{!! \Session::get('error1') !!}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                  <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
              </div>
        @endif
        <form class="bg-white p-6 rounded-lg" action="{{ route('admin.updateVerba') }}" method="post" enctype="multipart/form-data">
            @csrf
            @foreach ($getverbatim as $verbatim )
              <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="verbatim">Intitulé du verbatim</label>
                <input type="hidden" name="id_verbatim[]" value="{{ $verbatim->id_verbatim }}">
                <input class="bg-white border border-gray-400 rounded w-full py-2 px-4" type="text" name="verbatim[]" value="{{ $verbatim->verbatim }}" required="">
              </div>
            @endforeach
            <button id="btncreate" class="btn btn-success bg-indigo-500 text-white py-2 px-4 rounded-full hover:bg-indigo-600" type="submit">Modifier</button>    
          </form>
        </div>
    </div>
    @elseif (Route::currentRouteName() == 'admin.verbatimsWithoutCategory')
    @if (\Session::has('success1'))
          
    <div 
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 2000)"
    class="bg-teal-100 border border-teal-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{!! \Session::get('success1') !!}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
          <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
      </div>
@endif
@if (\Session::has('error'))
  
    <div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 2000)"
     class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{!! \Session::get('error') !!}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
          <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
      </div>
@endif

        @foreach ($verbatimsWithoutCategory as $verbatim)
            <form class="mt-5" action="{{ route('admin.updateVerbatimWithoutCat') }}" method="post">
                @csrf
                <div class="form-group">
                    
                    <label class="labels">Etape du Verbatim</label>
                    <select class="form-control" name="id_category[]">
                        <option value="">--Selectionner l'étape--</option>
                        @foreach ($getCategory as $category)
                            <option value="{{ $category->id_category }}"> {{ $category->title }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="labels">Intitulé du verbatim</label>
                    <input type="hidden" name="id_verbatim[]" value="{{ $verbatim->id_verbatim }}">
                    <input class="form-control" type="text" name="verbatim[]" value="{{ $verbatim->verbatim }}"
                        required="">
                </div>
                <button id="btncreate" type="submit" class="btn btn-success">Modifier</button>
            </form>
        @endforeach
    @else
    @if(Auth::check() && Auth::user()->role === 'admin' ? true : false)
    <span> * Déplacé les cartes pour modifier l'ordre des étapes qui apparaitront dans le graphique</span>
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 category-list">
        @foreach ($categories as $category)
            <div class="bg-white rounded-lg shadow-lg category-card" data-id="{{ $category->id_category }}">
                <div class="p-6 flex justify-between">
                    <h3 class="text-lg font-medium">{{ $category->position }}. {{ $category->title }}</h3>
                    <a href="{{ route('admin.editCategory', ['id_category' => $category->id_category]) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </div>
                <div class="p-6">
                    <p class="text-gray-600">{{ $category->verbatim_count }} verbatims</p>
                </div>
            </div>

        @endforeach
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-6 flex justify-between">
                <h3 class="text-lg font-medium">Verbatims sans étape</h3>
                <a href="{{ route('admin.verbatimsWithoutCategory') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>    
            </div>
            <div class="p-6">
                <p class="text-gray-600">{{ $noCategoryCount }} verbatims</p>
            </div>
        </div>
    </div> 
    @endif

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
                        url: '/dashboard/category/update-category-positions',
                        data: {
                            positions: positions,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            console.log("AJAX call success");
                            $('.category-card').each(function(i) {
                                $(this).find('.text-lg.font-medium').text((i + 1) + '. ' + $(this).find('.text-lg.font-medium').text().split('.')[1]);
                                return true;
                            });
                            // return true;
                        }
                    });
                }
            });
            $( ".category-list" ).disableSelection();
        }
        });
        
    </script>

   

@endsection