@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <h1 class="mt-4 mb-4">{{$article->title}}
        </h1>
        <div class="row">
            <div class="col-lg-8">

                <img alt="{{$article->image}}" class="img-fluid rounded"
                     src="/storage/storage/news/{{$article->image}}">
                <hr>
                <p>Posted on : {{$article->created_at}}</p>
                <hr>
                <p class="lead">{{$article->body}} </p>
                {{--                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">--}}
            </div>
            <div class="col-md-4">
                @guest
                @else
                    @if(Auth::user()->isAdmin())
                        <div class="card my-4">
                            <h5 class="card-header">Admin Tools</h5>
                            <div class="card-body">
                                <form class="container-fluid" method='post'
                                      action='{{route('news.destroy',['id' => $article->id])}}'>
                                    @method('delete')
                                    @csrf
                                    <div class="row">
                                        <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete {{$article->title}} ')"
                                                class="col  float-right btn btn-danger btn-lg d-block my-1">
                                            <i
                                                class="far fa-trash-alt"></i>
                                            Delete
                                        </button>
                                    </div>
                                    <div class="row">
                                        <a href="/news/{{$article->id}}/edit"
                                           class="col float-right btn btn-warning btn-lg d-block my-1 "><i
                                                class="far fa-edit"></i>Edit</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endguest
            </div>
        </div>
    </div>
@endsection
