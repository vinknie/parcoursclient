@extends('dashboard')

@section('content')
    <div class="grid grid-rows-3 grid-flow-col gap-4">
        <div class="row-span-6 text-3xl">
            <h1>Créer une étape</h1>
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
            <form class="bg-white p-6 rounded-lg" action="{{ url('/dashboard/createCategory/createCat') }}" method="post"
                enctype="multipart/form-data">
                @csrf

                <label class="labels">Titre de l'étape</label>
                <input class="bg-white border border-gray-400 rounded w-full py-2 px-4" type="text" name="title" required="">

                <button id="btncreate" type="submit" class="btn btn-success bg-green-500 text-white py-2 px-4 rounded-full hover:bg-green-600">Créer</button>
            </form>
        </div>
        <div class="row-span-6 ">
            <h1>Créer une verbatim</h1>
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
            <form class="bg-white p-6 rounded-lg" action="{{ url('/dashboard/createCategory/createVerba') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="labels block text-gray-700 font-medium mb-2">Etape du Verbatim</label>
                    <select name="id_category">
                        <option value="">--Selectionner l'étape--</option>
                        @foreach ($getCategory as $category)
                            <option value="{{ $category->id_category }}"> {{ $category->title }} </option>
                        @endforeach
                    </select>
                </div>
                <label class="labels block text-gray-700 font-medium mb-2">Intitulé du verbatim</label>
                <input class="bg-white border border-gray-400 rounded w-full py-2 px-4" type="text" name="verbatim" required="">

                <button id="btncreate" type="submit" class="btn btn-success bg-green-500 text-white py-2 px-4 rounded-full hover:bg-green-600">Créer</button>
            </form>
        </div>
    </div>

      
@endsection
