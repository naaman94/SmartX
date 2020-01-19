@extends('layouts.app')

@section('content')

    <div class="container">

        <form method="post" action="{{route('item.store')}}" enctype="multipart/form-data" >
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
                       >{{ old('description') }}</textarea>
            </div>

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
                <label class="col-form-label" for="Category_name">Status</label>
                    <select name="status" class="custom-select" id="status">
                        <option selected value="'Avalibale">'Avalibale</option>
                        <option value="Coming Soon">Coming Soon</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
            </div>



            <div class="form-group row">
                <label for="category_id"
                       class="col-form-label">Category</label>
                    <select name="category_id" class="custom-select" id="category_id">
                        @foreach($categories as $category)
                            <option value={{$category->id}}>'{{$category->name}}</option>
                        @endforeach
                    </select>
            </div>


            <div class="form-group row">
                <label class="col-form-label" for="image">Image</label>
                <div class="custom-file">
                    <input type="file" accept="image/x-png,image/gif,image/jpeg" name="image" class="custom-file-input {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image">
                    <label id="imageLabel" class="custom-file-label" for="image">Choose file</label>
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

            <button type="submit" class="btn btn-success float-right"> <i class="fas fa-plus"></i> Create</button>

        </form>

    </div>
@endsection
