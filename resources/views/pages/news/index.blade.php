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
        <div class="row justify-content-between mb-2">
            <h1 class="col-4"><i class="far fa-newspaper"></i> News</h1>
            @guest
            @else
                @if(Auth::user()->isAdmin())

                    <a class="btn btn-success my-1 " href="{{route("news.create")}}"><i class="fas fa-plus"></i> Add</a>
                @endif
            @endguest

        </div>

        @if($news->total()!=0)

            @foreach($news as $article)
                <div class=" row mb-3">
                    <div class="col-md-7">
                        <a href="/news/{{$article->id}}">
                            <img class="img-fluid rounded mb-3 mb-md-0" src="/storage/storage/news/{{$article->image}}"
                                 alt="">
                        </a>
                    </div>
                    <div class="col-md-5">
                        <h3>{{$article->title}}</h3>
                        <hr>
                        <h6 class=""> Posted on : {{$article->created_at}}</h6>
                        <p>{{\Illuminate\Support\Str::limit($article->body, 300)}}</p>
                        @guest
                        @else
                        @if(Auth::user()->isAdmin())
                            <form class="container-fluid" method='post'
                                  action='{{route('news.destroy',['id' => $article->id])}}'>
                                @method('delete')
                                @csrf
                                <div class="row">
                                    <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete {{$article->title}} ')"
                                            class="col-md-6 offset-md-6  float-right btn btn-danger btn-lg d-block my-1">
                                        <i
                                            class="far fa-trash-alt"></i>
                                        Delete
                                    </button>
                                </div>
                                <div class="row">
                                    <a href="/news/{{$article->id}}/edit"
                                       class="col-md-6 offset-md-6 float-right btn btn-warning btn-lg d-block my-1 "><i
                                            class="far fa-edit"></i>Edit</a>
                                </div>
                            </form>
                        @endif
                        @endguest

                    </div>
                </div>
                <hr class="mb-4 mt-4" style="  border-style: inset; border-color: black;  border-width: 1px;">
            @endforeach
        @else
            <div class="row mt-5"><h1 class="col text-center">you dont have any Ads yet</h1></div>
        @endif
        <div class="row justify-content-center">
            {{$news->links()}}
        </div>
    </div>
@endsection
