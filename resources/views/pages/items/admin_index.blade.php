@extends('layouts.app')

@section('header')
    {{--    <link href="{{ asset('css/NavBar.css') }}" rel="stylesheet">--}}

@endsection

@section('content')
    <div class="container">
        @if(session("message"))
            <div class="alert alert-success">
                <p class="text-monospace text-center">{{session("message")}}</p>
            </div>
        @endif

        <div class="row justify-content-between">
            <h1 class="col-6"> <i class="fas fa-store-alt"></i> Admin Items dashboard </h1>
            <a class="btn btn-success my-1" href="/item/create"><i class="fas fa-plus"></i> Add item</a>
        </div>
        @foreach($items  as $item)

            <div class="card my-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <a href="/item/{{$item->id}}">
                                <img class="img-fluid rounded" src="/uploads/items_img/{{$item->image}}" alt=""
                                     height="300" width="400">
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <h2 class="card-title">
                                <a style="color:black; text-decoration: none"
                                   href="/item/{{$item->id}}">{{$item->name}}</a>
                            </h2>
                            <hr>
                            <div>
                                <h5>SKU : <span style="color:blue"> {{$item->sku}}</span></h5>
                                <h5>Price : <span style="color:blue"> {{$item->price}} JD</span></h5>
                                <h5>Discount : <span style="color:red"> {{$item->discount}} %</span></h5>
                                @if($item->discount!=0)
                                    <h5>Total Price : <span style="color:red">  {{$item->price-$item->price*$item->discount/100}} JD</span>
                                    </h5>
                                @endif
                                <h5>Status : <span style="color:blue"> {{$item->status}}</span></h5>
                                <h5>Category : <span style="color:blue"> {{$item->category->name}}</span></h5>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <a href="/item/{{$item->id}}" class="btn btn-secondary btn-lg btn-block my-1"><i class="far fa-eye"></i> View
                            </a>
                            <form class=" " method='post' action='{{route('item.destroy',['id' => $item->id])}}'>
                                @method('delete')
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete {{$item->name}} category ?')"
                                        class="float-right btn btn-danger btn-lg btn-block my-1"><i class="far fa-trash-alt"></i> Delete
                                </button>
                                <a href="/item/{{$item->id}}/edit"
                                   class="float-right btn btn-warning btn-lg btn-block my-1 "><i class="far fa-edit"></i>Edit</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    Posted on {{$item->created_at}} - Update on {{$item->updated_at}} </div>
            </div>
        @endforeach
    </div>
@endsection
