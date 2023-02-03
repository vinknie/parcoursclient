@extends('dashboard')

@section('content')

    @if (request()->route('id_category'))
        <div class="grid grid-rows-3 grid-flow-col gap-4">

            <div class="row-span-6 text-3xl">
                <h1>Modifier l'étape</h1>
                @if (\Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! \Session::get('success') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (\Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {!! \Session::get('error') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form class="" action="{{ route('admin.updateCat', $getcategory->id_category) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <label class="labels">Titre de l'étape</label>
                    <input class="form-control" type="text" name="title" value="{{ $getcategory->title }}"
                        required="">

                    <button id="btncreate" type="submit" class="btn btn-success">Modifier</button>
                </form>
            </div>
            <div class="row-span-6 ">
                <h1>Modifier les verbatim</h1>
                @if (\Session::has('success1'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!! \Session::get('success1') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (\Session::has('error1'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {!! \Session::get('error1') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form class="form" action="{{ route('admin.updateVerba') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @foreach ($getverbatim as $verbatim)
                        <div class="form-group">
                            <label class="labels">Intitulé du verbatim</label>
                            <input type="hidden" name="id_verbatim[]" value="{{ $verbatim->id_verbatim }}">
                            <input class="form-control" type="text" name="verbatim[]" value="{{ $verbatim->verbatim }}"
                                required="">
                        </div>
                    @endforeach
                    <button id="btncreate" type="submit" class="btn btn-success">Modifier</button>
                </form>
            </div>
        </div>
    @elseif (Route::currentRouteName() == 'admin.verbatimsWithoutCategory')
        @if (\Session::has('success1'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! \Session::get('success1') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (\Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {!! \Session::get('error') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
        <div class="d-flex flex-wrap">
            @foreach ($categories as $category)
                <div class="card mb-4 mx-4 shadow-lg" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $category->title }}</h5>
                        <p class="card-text">{{ $category->verbatim_count }} verbatims</p>
                        <a href="{{ route('admin.editCategory', ['id_category' => $category->id_category]) }}"
                            class="btn btn-primary">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="card mb-4 mx-4 shadow-lg" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Verbatims sans étape</h5>
                    <p class="card-text">{{ $noCategoryCount }} verbatims</p>
                    <a href="{{ route('admin.verbatimsWithoutCategory') }}" class="btn btn-primary">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif

@endsection
