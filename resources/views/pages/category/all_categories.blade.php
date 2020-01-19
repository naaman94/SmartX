@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <h1 class="col-4"><i class="fas fa-list-ul"></i> All Categories</h1>
            <a class="btn btn-success my-1 " href="/category/create"><i class="fas fa-plus"></i> Add</a>
        </div>

        <div class="row  mt-4">
        @if(session("massage"))
            <p class="text-monospace text-success">{{session("massage")}}</p>
        @endif
        @if(session("massage_delete"))
            <p class="text-center text-monospace text-danger">{{session("massage_delete")}}</p>
        @endif

        @if(!$categories->isEmpty())
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Description</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <th scope="row">{{$category->id}}</th>
                        <td class="text-capitalize"  style="word-wrap: break-word; max-width: 100px;">{{$category->name}}</td>
                        <td class="" style="word-wrap: break-word; max-width: 300px;">{{$category->description}}</td>
                        <td>
                            <form class=" " method='post' action='{{route('category.destroy',['id' => $category->id])}}'>
                                @method('delete')
                                @csrf
                                <button type="submit" onclick="return confirm('Are you sure you want to delete {{$category->name}} category ?')" class="float-right btn btn-danger mb-2"><i class="far fa-trash-alt"></i> Delete</button>
                                <a href="category/{{$category->id}}/edit" class="float-right mx-2 btn btn-warning mb-2 " ><i class="far fa-edit"></i> Edit </a>

                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
        </div>
            <div class="row  mt-2">
                <h1 class="text-center col text-warning" >There is no categories , <a href="/category/create " role="button">Add Categoy</a></h1>

        @endif
    </div>
    </div>
@endsection
