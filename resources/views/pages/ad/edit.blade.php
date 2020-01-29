@extends('layouts.app')

@section('header')

@endsection

@section('content')

    <div class="container mt-5">

        <form method="post" action="{{route('item.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h1 class="text-primary mt-4">Add New Ad </h1>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group row">
                <label class="col-form-label" for="title">Title</label>
                <input name="title" type="text" class="form-control
                input @error('title') is-invalid @enderror"
                       value="{{ old('title') }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="url">URL</label>
                <input name="url" type="text" class="form-control
                input @error('url') is-invalid @enderror"
                       value="{{ old('url') }}" placeholder="">
            </div>

            <div class="form-check">
                <input class="form-check-input @error('show_in_home') is-invalid @enderror" name="show_in_home[]" type="checkbox" value="{{ old('show_in_home') }}" id="show_in_home">
                <label class="form-check-label @error('show_in_home') is-invalid @enderror" for="show_in_home">
                    Show an Ad in Home
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input @error('show_in_store') is-invalid @enderror" name="show_in_store[]" type="checkbox" value="{{ old('show_in_store') }}" id="show_in_store">
                <label class="form-check-label @error('show_in_store') is-invalid @enderror" for="show_in_store">
                    Show an Ad in Store
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input @error('show_in_items') is-invalid @enderror" name="show_in_items[]" type="checkbox" value="{{ old('show_in_items') }}" id="show_in_items">
                <label class="form-check-label @error('show_in_items') is-invalid @enderror" for="show_in_items">
                    Show an Ad in Store
                </label>
            </div>
            <div class="form-group row">
                <label class="col-form-label" for="image">Image</label>
                <div class="custom-file">
                    <input type="file" accept="image/*" name="image" onchange="loadFile(event)"
                           value="{{ old('image') }}" multiple
                           class="custom-file-input @error('image') is-invalid @enderror" id="image">
                    <label class="custom-file-label @error('image') is-invalid @enderror" for="inputGroupFile01">Choose
                        file</label>
                </div>
            </div>

            <script>
                var loadFile = function (event) {
                    var image = document.getElementById('output');
                    image.src = URL.createObjectURL(event.target.files[0]);
                }
            </script>
            <button type="submit" class="btn btn-success float-right mb-5"><i class="fas fa-plus"></i> Create</button>
            <p><img id="output" width="300"/></p>
        </form>

    </div>
@endsection
