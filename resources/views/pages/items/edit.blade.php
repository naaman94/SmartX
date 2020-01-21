@extends('layouts.app')

@section('header')

@endsection

@section('content')

    <div class="container">

        <form method="post" enctype="multipart/form-data" action="{{route('item.update',['id' => $item->id])}}">
            @method('PUT')
            @csrf

            <div class="form-group">
                <h1 class="text-primary">Edit Items</h1>
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
                input {{ $errors->has('sku') ? 'is-invalid' : '' }}"
                       value="{{ old('sku',$item->sku) }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Name</label>
                <input name="name" type="text" class="form-control
                input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       value="{{ old('name',$item->name  ) }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="description">Description</label>
                <textarea data-autoresize rows="3" name="description" type="text"
                          class="form-control input {{ $errors->has('description') ? 'is-invalid ' : '' }}"
                          id="description"
                >{{ old('description',$item->description  ) }}</textarea>
            </div>
            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Price</label>
                <input name="price" type="text" class="form-control
                input {{ $errors->has('price') ? 'is-invalid' : '' }}"
                       value="{{ old('price',$item->price  ) }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Discount</label>
                <input name="discount" type="text" class="form-control
                input {{ $errors->has('discount') ? 'is-invalid' : '' }}"
                       value="{{ old('discount',$item->discount ) }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Status</label>
                <select value="{{ old('status',$item->status ) }}" name="status" class="custom-select" id="status">
                    <option selected value="Available">Available</option>
                    <option value="Coming Soon">Coming Soon</option>
                    <option value="Out of Stock">Out of Stock</option>
                </select>
            </div>

            <div class="form-group row">
                <label for="category_id"
                       class="col-form-label">Category</label>
                <select name="category_id" class="custom-select" id="category_id"
                        value="{{ old('category_id',$item->category_id ) }}">
                    @foreach($categories as $category)
                        <option value={{$category->id}}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row">
                <label class="col-form-label" for="image">Image</label>
                <div class="custom-file">
                    <input type="hidden" value="{{ old('image',$item->image ) }}" name="org_image">
                    <input type="file" accept="image/*" name="image" onchange="loadFile(event)"
                           value="{{ old('image') }}"
                           class="custom-file-input {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>
            <script>
                var loadFile = function (event) {
                    var image = document.getElementById('output');
                    image.src = URL.createObjectURL(event.target.files[0]);
                };
            </script>
            <img id="output" width="200" src="/uploads/items_img/{{$item->image}}"/>
            <button type="submit" class="btn btn-success float-right"><i class="fas fa-plus"></i> Edit Item</button>
        </form>

    </div>
@endsection
