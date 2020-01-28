@extends('layouts.app')
@section('content')
    <div class="container mt-lg-5">
        <div class="row ">
            <h1 class="text-secondary">Add New Categoy</h1>
        </div>
        <form method="post" action="{{route('category.store')}}">
            @csrf

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
                <label class="col-form-label" for="Category_name">Category Name</label>
                <input name="name" type="text" class="form-control input {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}">
            </div>
            <div class="form-group row">
                <label class="col-form-label" for="description">Description</label>
                <textarea rows="3" name="description" type="text"
                          class="form-control input {{ $errors->has('description') ? 'is-invalid ' : '' }}">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary float-right">Add</button>
        </form>
    </div>
@endsection
