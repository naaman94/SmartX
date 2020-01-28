@extends('layouts.app')

@section('header')

@endsection

@section('content')

    <div class="container">

        <form method="post" action="{{route('item.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h1 class="text-primary">Add Items</h1>
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
                <label class="col-form-label" for="Category_name">SKU</label>
                <input name="sku" type="text" class="form-control
                input @error('sku') is-invalid @enderror"
                       value="{{ old('sku') }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Name</label>
                <input name="name" type="text" class="form-control
                input @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="description">Description</label>
                <textarea rows="3" name="description" type="text"
                          class="form-control input @error('description') is-invalid @enderror"
                          id="description"
                >{{ old('description') }}</textarea>
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="short_description">Short Description</label>
                <input  name="short_description" type="text"
                       class="form-control input @error('short_description') is-invalid @enderror"
                       id="short_description" value="{{ old('short_description') }}">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Price</label>
                <input name="price" type="text" class="form-control
                input @error('price') is-invalid @enderror"
                       value="{{ old('price') }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Discount</label>
                <input name="discount" type="text" class="form-control
                input @error('discount') is-invalid @enderror"
                       value="{{ old('discount') }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Status</label>
                <select name="status" class="custom-select @error('status') is-invalid @enderror" id="status">
                    <option selected value="Available">Available</option>
                    <option value="Coming Soon">Coming Soon</option>
                    <option value="Out of Stock">Out of Stock</option>
                </select>
            </div>


            <div class="form-group row">
                <label for="category_id"
                       class="col-form-label">Category</label>
                <select name="category_id" class="custom-select @error('category_id') is-invalid @enderror"
                        id="category_id">
                    @foreach($categories as $category)
                        <option value={{$category->id}}>{{$category->name}}</option>
                    @endforeach
                </select>
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
