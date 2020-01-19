@extends('layouts.app')

@section('content')

    <div class="container">

        <form method="post" action="{{route('item.store')}}">
            @csrf

            <div class="form-group">
                <h1 class="text-primary">Add Items</h1>
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">SKU</label>
                <input name="sku" type="text" class="form-control
                input {{ $errors->has('sku') ? 'is-invalid' : '' }}"
                       value="{{ old('sku') }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Name</label>
                <input name="name" type="text" class="form-control
                input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       value="{{ old('name') }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="description">Description</label>
                <textarea rows="3" name="description" type="text"
                          class="form-control input {{ $errors->has('description') ? 'is-invalid ' : '' }}"
                          id="description"
                          placeholder="Do you have any notes ? Please  tell us .. ">{{ old('description') }}</textarea>
            </div>
k
            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Price</label>
                <input name="price" type="text" class="form-control
                input {{ $errors->has('price') ? 'is-invalid' : '' }}"
                       value="{{ old('price') }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Discount</label>
                <input name="discount" type="text" class="form-control
                input {{ $errors->has('discount') ? 'is-invalid' : '' }}"
                       value="{{ old('discount') }}" placeholder="">
            </div>

            <div class="form-group row">
                <label for="status"
                       class="col-md-4 col-form-label text-md-right">Status</label>
                <div class="col-md-6">
                    <select name="status" class="custom-select" id="status">
                        <option selected value="'Avalibale">'Avalibale</option>
                        <option value="Coming Soon">Coming Soon</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="category"
                       class="col-md-4 col-form-label text-md-right">Category</label>
                <div class="col-md-6">
                    <select name="category" class="custom-select" id="category">
                        @foreach($categories as $category)
                            <option value="'{{$category->id}}">'{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <label class="col-form-label" for="image">Image</label>
                <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input" id="image">
                    <label class="custom-file-label" for="image">Choose file</label>
                </div>
            </div>


            @if ($errors->any())
                <div class="alert alert-danger alert-dismissable">
                    <div class="alertwrapper clearfix">
                        <div class="alerticon dangerous">
                            <span class="glyphicon glyphicon-warning-sign"></span>
                        </div>
                        <div class="alertcontent">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <button type="submit" class="btn btn-primary float-right">Add</button>

        </form>

    </div>
@endsection
