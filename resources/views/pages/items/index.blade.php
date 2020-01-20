@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/NavBar.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-lg-3">
                <h1>Categories</h1>
                <div class="list-group">
                    <a href="/item" class="list-group-item">All items</a>

                    @foreach($categories as $category)
                        <a href="{{$category->id}}" class="list-group-item">{{$category->name}}</a>
                    @endforeach
                </div>

            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                {{--                <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">--}}
                {{--                    <ol class="carousel-indicators">--}}
                {{--                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>--}}
                {{--                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>--}}
                {{--                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>--}}
                {{--                    </ol>--}}
                {{--                    <div class="carousel-inner" role="listbox">--}}
                {{--                        <div class="carousel-item active">--}}
                {{--                            <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="First slide">--}}
                {{--                        </div>--}}
                {{--                        <div class="carousel-item">--}}
                {{--                            <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Second slide">--}}
                {{--                        </div>--}}
                {{--                        <div class="carousel-item">--}}
                {{--                            <img class="d-block img-fluid" src="http://placehold.it/900x350" alt="Third slide">--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">--}}
                {{--                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>--}}
                {{--                        <span class="sr-only">Previous</span>--}}
                {{--                    </a>--}}
                {{--                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">--}}
                {{--                        <span class="carousel-control-next-icon" aria-hidden="true"></span>--}}
                {{--                        <span class="sr-only">Next</span>--}}
                {{--                    </a>--}}
                {{--                </div>--}}

                <div class="row">
                    @foreach($items  as $item)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <a href="/item/{{$item->id}}">
                                    <img class="card-img-top" src="/uploads/items_img/{{$item->image}}" alt=""
                                         height="200" width="150">
                                </a>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <a style="color:black; text-decoration: none"
                                           href="/item/{{$item->id}}">{{$item->name}}</a>
                                    </h4>
                                    @if($item->discount==0)
                                        <h5>{{$item->price}} JD</h5>
                                    @else
                                        <h5 style="text-decoration: line-through;display: inline">{{$item->price}}
                                            JD</h5>
                                        <h5 style="display: inline ; color: red">{{$item->price-$item->price*$item->discount/100}}
                                            JD</h5>

                                    @endif
                                    <p class="card-text">{{Illuminate\Support\Str::limit($item->description, 150, ' ...')}}</p>
                                </div>
                                <div class="card-footer row justify-content-around">
                                    <small class="text-muted">{{$item->status}}</small>
                                    <small class="text-muted">
                                        <button class="btn btn-sm btn-outline-success"><i class="fas fa-cart-plus"></i>
                                            Add to cart
                                        </button>
                                    </small>

                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
                <!-- /.row -->

            </div>
            <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>

@endsection
