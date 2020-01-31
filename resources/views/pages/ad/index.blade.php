@extends('layouts.app')
@section('header')

@endsection
@section('content')
    <div class="container mt-5">
        @if(session("message"))
            <div class="alert alert-success">
                <p class="text-monospace text-center">{{session("message")}}</p>
            </div>
        @endif
        <div class="row justify-content-between">
            <h1 class="col-4"><i class="fas fa-ad"></i> Ads in Website</h1>
            <a class="btn btn-success my-1 " href="{{route("ads.create")}}"><i class="fas fa-plus"></i> Add</a>
        </div>

        @if($ads->total()!=0)

            @foreach($ads as $ad)
                <div class=" row mb-3">
                    <div class="col-md-7">
                        <a href="{{$ad->url}}">
                            <img class="img-fluid rounded mb-3 mb-md-0" src="/storage/storage/ads/{{$ad->image}}"
                                 alt="">
                        </a>
                    </div>
                    <div class="col-md-5">
                        <h3>{{$ad->title}}</h3>
                        <hr>
                        <h6 class=""> Posted on : {{$ad->created_at}}</h6>

                        @if($ad->show_in_home)
                            <h6 class="text-success">display in home</h6>
                        @else
                            <h6 class="text-danger">not display in home</h6>
                        @endif
                        @if($ad->show_in_store)
                            <h6 class="text-success">display in store</h6>
                        @else
                            <h6 class="text-danger">not display in store</h6>
                        @endif
                        @if($ad->show_in_items)
                            <h6 class="text-success">display in items</h6>
                        @else
                            <h6 class="text-danger">not display in items</h6>
                        @endif


                        <form class="container-fluid" method='post' action='{{route('ads.destroy',['id' => $ad->id])}}'>
                            @method('delete')
                            @csrf
                            <div class="row">
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete {{$ad->title}} ')"
                                        class="col-md-6 offset-md-6  float-right btn btn-danger btn-lg d-block my-1"><i
                                        class="far fa-trash-alt"></i>
                                    Delete
                                </button>
                            </div>
                            <div class="row">
                                <a href="/ads/{{$ad->id}}/edit"
                                   class="col-md-6 offset-md-6 float-right btn btn-warning btn-lg d-block my-1 "><i
                                        class="far fa-edit"></i>Edit</a>
                            </div>
                        </form>

                    </div>
                </div>
                <hr style="  border-style: inset; border-color: black;  border-width: 1px;">
            @endforeach
        @else
            <div class="row mt-5"><h1 class="col text-center">you dont have any Ads yet</h1></div>
        @endif
        <div class="row justify-content-center">
            {{$ads->links()}}
        </div>
    </div>
@endsection
