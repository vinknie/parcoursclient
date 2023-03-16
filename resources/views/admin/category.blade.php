@extends('master')
<style>
    .category-card {
        cursor: pointer;
        transition: transform 0.2s ease-out;
        transform: scale(1);
    }

    .category-card:hover {
        /* background-color: rgba(0, 0, 0, 0.1); */
        transform: scale(1.02);
        z-index: 10;
    }

    #myPopup,
    #myPopup1,
    #myPopup3 {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    /* Modal Content/Box */
    .popup-content {
        background-color: #fff;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        width: 80%;
    }

    /* The Close Button */
    .close,
    .close1,
    .close3 {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus,
    .close1:hover,
    .close1:focus,
    .close3:hover,
    .close3:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .truncate-text {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .z-0 {
        z-index: 0 !important;
    }
</style>
@section('content')
@if (request()->route('id_category'))
<div class="text-left mb-6 ml-6 mt-24">
    <a href="{{ route('admin.category') }}"
        class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded"><i
            class="fa-solid fa-arrow-left-long"></i></a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-medium mb-6 tracking-wide">Modifier l'étape</h3>
        @if (\Session::has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="bg-teal-100 border border-teal-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{!! \Session::get('success') !!}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
        @endif
        @if (\Session::has('error'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{!! \Session::get('error') !!}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
        @endif
        <form action="{{ route('admin.updateCat', $getcategory->id_category) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="title">Titre de l'étape</label>
                <input class="bg-white border border-gray-400 rounded w-full py-2 px-4" type="text" id="title"
                    name="title" value="{{ $getcategory->title }}" required>
            </div>
            <button class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded">Modifier</button>
        </form>
    </div>
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-medium mb-6 tracking-wide">Modifier les verbatims</h3>
        @if (\Session::has('success1'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="bg-teal-100 border border-teal-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{!! \Session::get('success1') !!}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
        @endif
        @if (\Session::has('error1'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{!! \Session::get('error1') !!}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
        @endif
        @if (count($getverbatim) > 0)
        <form action="{{ route('admin.updateVerba') }}" method="post" enctype="multipart/form-data">
            @csrf
            @foreach ($getverbatim as $verbatim)
            <div class="mb-4 relative">
                <label class="block text-gray-700 font-medium mb-2" for="verbatim">Intitulé du verbatim</label>
                <div class="flex items-center">
                    <input type="hidden" name="id_verbatim[]" value="{{ $verbatim->id_verbatim }}"
                        data-id="{{ $verbatim->id_verbatim }}">

                    <input class="bg-white border border-gray-400 rounded w-full py-2 px-4" type="text"
                        name="verbatim[]" value="{{ $verbatim->verbatim }}" required>
                    <button type="button"
                        class="bg-red-400 hover:bg-red-600 text-slate-50 m-1 rounded absolute right-0 px-2"
                        onclick="deleteInput(this)">
                        Supprimer
                    </button>
                </div>
            </div>
            @endforeach
            <button class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded">Modifier</button>
        </form>
        @else
        <p>Pas de verbatim dans cette catégorie</p>
        @endif
    </div>
</div>
@elseif (Route::currentRouteName() == 'admin.verbatimsWithoutCategory')
<div class="text-left mb-6 ml-6 mt-28">
    <a href="{{ route('admin.category') }}"
        class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded"><i
            class="fa-solid fa-arrow-left-long"></i></a>
</div>
@if (\Session::has('success1'))
<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
    class="bg-teal-100 border border-teal-400 text-green-700 px-4 py-3 rounded relative" role="alert">
    <span class="block sm:inline">{!! \Session::get('success1') !!}</span>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20">
            <title>Close</title>
            <path
                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
        </svg>
    </span>
</div>
@endif
@if (\Session::has('error'))
<div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
    <span class="block sm:inline">{!! \Session::get('error') !!}</span>
    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20">
            <title>Close</title>
            <path
                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
        </svg>
    </span>
</div>
@endif

<div class="flex flex-col items-center mt-5">
    @foreach ($verbatimsWithoutCategory as $verbatim)
    <form class="w-full max-w-sm mt-5" action="{{ route('admin.updateVerbatimWithoutCat') }}" method="post">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2" for="id_category">Etape du Verbatim</label>
            <select class="bg-white border border-gray-400 rounded w-full py-2 px-4" name="id_category[]" required>
                <option value="">--Selectionner l'étape--</option>
                @foreach ($getCategory as $category)
                <option value="{{ $category->id_category }}"> {{ $category->title }} </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2" for="verbatim">Intitulé du verbatim</label>
            <input type="hidden" name="id_verbatim[]" value="{{ $verbatim->id_verbatim }}">
            <input class="bg-white border border-gray-400 rounded w-full py-2 px-4" type="text" name="verbatim[]"
                value="{{ $verbatim->verbatim }}" required>
        </div>
        <button
            class="bg-indigo-500 text-white font-medium py-2 px-4 rounded-full hover:bg-indigo-600">Modifier</button>
    </form>
    @endforeach
</div>
@else
<div class="container mx-auto px-6 py-12 mt-8">
    <div class="text-center">
        <h2 class="text-2xl font-medium mb-4">Gestion des étapes et des verbatims</h2>
    </div>
    @if (Auth::check() && Auth::user()->role === 'admin' ? true : false)
    <span class="text-sm text-green-600 mb-6">* Déplacé les cartes pour modifier l'ordre des étapes qui
        apparaitront dans le graphique</span>
    @endif
    <div class="flex justify-between my-6">
        <button id="myBtn" class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded">
            <i class="fa-solid fa-plus"></i> Créer une étape
        </button>
        <button id="myBtn1" class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded">
            <i class="fa-solid fa-plus"></i> Créer une verbatim
        </button>
        <button id="myBtn3" class="bg-slate-800 hover:bg-slate-700 text-white font-bold py-2 px-4 rounded">
            <i class="fa-solid fa-plus"></i> Créer un dialogue
        </button>
    </div>
    <div id="myPopup" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <div class="text-center text-3xl">
                <h1>Créer une étape</h1>
            </div>
            <form class="bg-white p-6 mx-auto rounded-lg" action="{{ url('/dashboard/createCategory/createCat') }}"
                method="post" enctype="multipart/form-data" onsubmit="history.back();">
                @csrf
                <div class="mb-4">
                    <label class="labels">Titre de l'étape</label>
                    <input class="bg-white border border-gray-400 rounded w-full py-2 px-4" type="text" name="title"
                        required>
                </div>
                <button id="btncreate" type="submit"
                    class="btn btn-success bg-green-500 text-white py-2 px-4 rounded-full hover:bg-green-600">Créer</button>
            </form>
        </div>
    </div>
    @if (\Session::has('success'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
        class="bg-teal-100 border border-teal-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{!! \Session::get('success') !!}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
    @endif
    @if (\Session::has('error'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{!! \Session::get('error') !!}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
    @endif
    <div id="myPopup1" class="popup1">
        <div class="popup-content">
            <span class="close1">&times;</span>
            <div class="text-center text-3xl">
                <h1>Créer une verbatim</h1>
            </div>
            <form class="bg-white p-6 mx-auto rounded-lg" action="{{ url('/dashboard/createCategory/createVerba') }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="labels">Etape du Verbatim</label>
                    <select name="id_category">
                        <option value="">--Selectionner l'étape--</option>
                        @foreach ($getCategory as $category)
                        <option value="{{ $category->id_category }}"> {{ $category->title }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="labels">Intitulé du verbatim</label>
                    <input class="bg-white border border-gray-400 rounded w-full py-2 px-4" type="text" name="verbatim"
                        required="">
                </div>
                <button id="btncreate" type="submit"
                    class="btn btn-success bg-green-500 text-white py-2 px-4 rounded-full hover:bg-green-600">Créer</button>
            </form>
        </div>
    </div>
    @if (\Session::has('success1'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
        class="bg-teal-100 border border-teal-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{!! \Session::get('success1') !!}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
    @endif
    @if (\Session::has('error1'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{!! \Session::get('error1') !!}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
    @endif
    <div id="myPopup3" class="popup3">
        <div class="popup-content">
            <span class="close3">&times;</span>
            <div class="text-center text-3xl">
                <h1 class="font-medium text-gray-900">Créer un dialogue</h1>
            </div>
            <form class="bg-white p-6 rounded-lg mt-5" action="{{ url('/dashboard/createCategory/createDialogue') }}"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Etape du dialogue</label>
                    <select class="form-control" name="id_category">
                        <option value="">--Selectionner l'étape--</option>
                        @foreach ($getCategory as $category)
                        <option value="{{ $category->id_category }}"> {{ $category->title }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Verbatim du dialogue</label>
                    <select class="form-control" name="id_verbatim">
                        <option value="">--Selectionner le verbatim--</option>
                        {{-- @foreach ($getVerbatim as $verbatim)
                        <option value="{{ $verbatim->id_verbatim }}"> {{ $verbatim->verbatim }} </option>
                        @endforeach --}}
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Intitulé du dialogue</label>
                    <input class="form-control" type="text" name="dialogue" required="">
                </div>
                <div class="form-group">
                    <label class="block text-gray-700 font-medium mb-2" for="sentiment">Sentiment:</label>
                    <div>
                        <input type="radio" id="positif" name="sentiment" value="positif">
                        <label for="positif">Positif</label>
                    </div>
                    <div>
                        <input type="radio" id="neutre" name="sentiment" value="neutre">
                        <label for="neutre">Neutre</label>
                    </div>
                    <div>
                        <input type="radio" id="negatif" name="sentiment" value="negatif">
                        <label for="negatif">Négatif</label>
                    </div>
                </div>
                <button id="btncreate" type="submit"
                    class="btn btn-success bg-green-500 text-white py-2 px-4 rounded-full mt-5 hover:bg-green-600">Créer</button>
            </form>
        </div>
    </div>
    @if (\Session::has('success2'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
        class="bg-teal-100 border border-teal-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{!! \Session::get('success2') !!}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
    @endif
    @if (\Session::has('error2'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{!! \Session::get('error2') !!}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
    @endif
    @if (\Session::has('delete'))
    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{!! \Session::get('delete') !!}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 category-list">
        @foreach ($categories as $category)

        <div class="bg-white rounded-lg shadow-lg category-card z-0" data-id="{{ $category->id_category }}">
            <div class="p-6 flex justify-between">
                <h3 class="text-lg font-medium truncate-text tracking-wider">
                    <a href="{{ route('admin.editCategory', ['id_category' => $category->id_category]) }}"> {{
                        $category->position }}. {{ $category->title }}
                    </a>
                </h3>
                <div>
                    <a href="{{ route('admin.editCategory', ['id_category' => $category->id_category]) }}"
                        class="text-gray-400 hover:text-gray-600 m-1 rounded">
                        <i class="fa-regular fa-pen-to-square "></i>
                    </a>
                    <a href="{{ route('admin.deleteCat', ['id_category' => $category->id_category]) }}"
                        class="text-red-300 hover:text-red-600 m-1 rounded"
                        onclick="return confirm('etes vous sur de vouloir supprimé? ')">
                        <i class="fa-regular fa-trash-can"></i>
                    </a>
                </div>
            </div>

            <div class="p-6">
                <p>
                    <span class="bg-gray-800 text-gray-100 px-2 rounded">{{ $category->verbatim_count }}</span>
                    verbatims
                </p>
            </div>
        </div>
        @endforeach
        <div class="bg-white rounded-lg shadow-lg category-card">
            <div class="p-6 flex justify-between">
                <h3 class="text-lg font-medium tracking-wider">
                    <a href="{{ route('admin.verbatimsWithoutCategory') }}">Verbatims sans étape</a>
                </h3>
                <a href="{{ route('admin.verbatimsWithoutCategory') }}"
                    class="text-gray-400 hover:text-gray-600 rounded">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
            </div>
            <div class="p-6">
                <p><span class="bg-gray-800 text-gray-100 px-2 rounded">{{ $noCategoryCount }}</span> verbatims</p>
            </div>
        </div>
    </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        const isAdmin = {{ Auth::check() && Auth::user()->role === 'admin' ? 'true' : 'false' }};

        $(function() {
            if (isAdmin) {
                $(".category-list").sortable({
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
                                    $(this).find('.text-lg.font-medium').text((i +
                                            1) + '. ' + $(this).find(
                                            '.text-lg.font-medium').text()
                                        .split('.')[1]);
                                    return true;
                                });
                                // return true;
                            }
                        });
                    }
                });
                $(".category-list").disableSelection();
            }
        });

        // Get the <span> element that closes the popup
        var span = document.getElementsByClassName("close")[0];
        var span1 = document.getElementsByClassName("close1")[0];
        var span3 = document.getElementsByClassName("close3")[0];

        // Function to set up the popup
        function setUpPopup(btn, popup, span) {
            // When the user clicks the button, open the popup
            btn.onclick = function() {
                popup.style.display = "block";
            }

            // When the user clicks on <span> (x), close the popup
            span.onclick = function() {
                popup.style.display = "none";
            }

            // When the user clicks anywhere outside of the popup, close it
            window.onclick = function(event) {
                if (event.target == popup) {
                    popup.style.display = "none";
                }
            }
        }

        // Get the button and popup for the first popup
        var btn = document.getElementById("myBtn");
        var popup = document.getElementById("myPopup");

        // Set up the first popup
        setUpPopup(btn, popup, span);

        // Get the button and popup for the second popup
        var btn1 = document.getElementById("myBtn1");
        var popup1 = document.getElementById("myPopup1");

        // Set up the second popup
        setUpPopup(btn1, popup1, span1);

        // Get the button and popup for the second popup
        var btn3 = document.getElementById("myBtn3");
        var popup3 = document.getElementById("myPopup3");

        // Set up the third popup
        setUpPopup(btn3, popup3, span3);


        function deleteInput(btn) {
            let id_verbatim = btn.parentNode.querySelector('input[type="hidden"]').getAttribute('data-id');
            if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                fetch('/dashboard/category/deleteVerba/' + id_verbatim, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({id_verbatim: id_verbatim})
                }).then(response => {
                    if (response.ok) {
                        btn.parentNode.remove();
                    } else {
                        alert('Une erreur s\'est produite lors de la suppression de l\'élément.');
                    }
                }).catch(error => {
                    alert('Une erreur s\'est produite lors de la suppression de l\'élément : ' + error.message);
                });
            }
        }

        jQuery(document).ready(function() {
            jQuery('select[name="id_category"]').on('change',function(){
                // const currentUserId = {{Auth::user()->id}};
                const CategoryID = jQuery(this).val();
                console.log(CategoryID);
                if(CategoryID)
                {
                    jQuery.ajax({
                        url : '/dashboard/createCategory/createDialogue/getVerbatim/' +CategoryID,
                        type : "GET",
                        dataType : "json",
                        success:function(data)
                        {
                            jQuery('select[name="id_verbatim"]').empty();
                            jQuery.each(data, function(key,value){
                                
                                $('select[name="id_verbatim"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }
                else{
                    jQuery('select[name="id_verbatim"]').empty();
                    $('select[name="id_verbatim"]').append('<option value="">--Selectionner le verbatim--</option>');
                }
            });
        })
    </script>
    @endsection