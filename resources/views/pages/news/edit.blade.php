@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        <form method="post" action="{{route('news.update',['id' => $article->id])}}" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="form-group">
                <h1 class="text-primary mt-4">Edit Article </h1>
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
                       value="{{ old('title',$article->title) }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="body">Body</label>
                <textarea rows="3" name="body" type="text"
                          class="form-control input @error('body') is-invalid @enderror"
                          id="body"
                >{{ old('body',$article->body) }}</textarea>
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="image">Image</label>
                <div class="custom-file">
                    <input type="hidden" value="{{ old('image',$article->image ) }}" name="org_image">
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
            <button type="submit" class="btn btn-success float-right mb-5"><i class="fas fa-plus"></i> Edit</button>
            <div class="row justify-content-center">
                <img class="col-lg-6 mt-2 " id="output" width="200" src="/storage/storage/news/{{$article->image}}"/>
            </div>
        </form>

    </div>
@endsection
