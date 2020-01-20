@extends('layouts.app')

@section('content')

    <div class="container">

        <form method="post" action="{{route('category.update',['id' => $category->id])}}">
            @method('PUT')
            @csrf
            <h1 class="text-primary">Edit Categoy</h1>
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
                <label class="col-form-label" for="Category_name">Category name</label>
                <input name="name" type="text" class="form-control
                input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       value="{{ old('name',$category->name) }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="description">Description</label>
                <textarea rows="3" name="description" type="text"
                          class="form-control input {{ $errors->has('description') ? 'is-invalid ' : '' }}"
                          id="description"
                          placeholder="Do you have any notes ? Please  tell us .. ">{{ old('description',$category->description) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary float-right">Update</button>

        </form>

    </div>





@endsection
