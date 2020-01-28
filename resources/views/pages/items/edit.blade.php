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
                input @error('sku') is-invalid @enderror"
                       value="{{ old('sku',$item->sku) }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Name</label>
                <input name="name" type="text" class="form-control
                input @error('name') is-invalid @enderror"
                       value="{{ old('name',$item->name  ) }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="description">Description</label>
                <textarea data-autoresize rows="3" name="description" type="text"
                          class="form-control input @error('description') is-invalid @enderror"
                          id="description"
                >{{ old('description',$item->description  ) }}</textarea>
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="short_description">Short Description</label>
                <input name="short_description" type="text" class="form-control
                input @error('short_description') is-invalid @enderror" id="short_description"
                       value="{{ old('short_description',$item->short_description  ) }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Price</label>
                <input name="price" type="text" class="form-control
                input @error('price') is-invalid @enderror"
                       value="{{ old('price',$item->price  ) }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Discount</label>
                <input name="discount" type="text" class="form-control
                input @error('discount') is-invalid @enderror"
                       value="{{ old('discount',$item->discount ) }}" placeholder="">
            </div>

            <div class="form-group row">
                <label class="col-form-label" for="Category_name">Status</label>
                <select value="{{ old('status',$item->status ) }}" name="status"
                        class="custom-select @error('status') is-invalid @enderror" id="status">
                    @foreach(array("Available","Coming Soon","Out of Stock") as $status)
                        <option
                            {{ old('status',$item->status ) == $status?"selected":""}}  value="{{$status}}">{{$status}}</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group row">
                <label for="category_id"
                       class="col-form-label">Category</label>
                <select name="category_id" class="custom-select @error('category_id') is-invalid @enderror"
                        id="category_id"
                        value="{{ old('category_id',$item->category_id ) }}">
                    @foreach($categories as $category)
                        <option
                            {{ old('category_id',$item->category_id ) == $category->id ? "selected":" "}} value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group row">
                <label class="col-form-label" for="image">Image</label>
                <div class="custom-file">
                    <input type="hidden" value="{{ old('image',$item->image ) }}" name="org_image">
                    <input type="file" accept="image/*" name="image" onchange="loadFile(event)"
                           value="{{ old('image') }}"
                           class="custom-file-input @error('image') is-invalid @enderror" id="image">
                    <label class="custom-file-label @error('image') is-invalid @enderror" for="inputGroupFile01">Choose
                        file</label>
                </div>
            </div>
            <script>
                var loadFile = function (event) {
                    var image = document.getElementById('output');
                    image.src = URL.createObjectURL(event.target.files[0]);
                };
            </script>
            <img id="output" width="200" src="/storage/storage/items/{{$item->image}}"/>
            <button type="submit" class="btn btn-success float-right"><i class="fas fa-plus"></i> Edit Item</button>
        </form>

    </div>
@endsection
