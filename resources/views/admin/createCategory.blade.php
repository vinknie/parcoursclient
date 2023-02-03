@extends('dashboard')

@section('content')
    <div class="grid grid-rows-3 grid-flow-col gap-4">
        <div class="row-span-6 text-3xl">
            <h1>Créer une étape</h1>
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
            <form class="" action="{{ url('/dashboard/createCategory/createCat') }}" method="post"
                enctype="multipart/form-data">
                @csrf

                <label class="labels">Titre de l'étape</label>
                <input class="form-control" type="text" name="title" required="">

                <button id="btncreate" type="submit" class="btn btn-success">Créer</button>
            </form>
        </div>
        <div class="row-span-6 ">
            <h1>Créer une verbatim</h1>
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
            <form class="" action="{{ url('/dashboard/createCategory/createVerba') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="labels">Etape du Verbatim</label>
                    <select name="id_category">
                        <option value="">--Selectionner l'étape--</option>
                        @foreach ($getCategory as $category)
                            <option value="{{ $category->id_category }}"> {{ $category->title }} </option>
                        @endforeach
                    </select>
                </div>
                <label class="labels">Intitulé du verbatim</label>
                <input class="form-control" type="text" name="verbatim" required="">

                <button id="btncreate" type="submit" class="btn btn-success">Créer</button>
            </form>
        </div>
    </div>
@endsection
