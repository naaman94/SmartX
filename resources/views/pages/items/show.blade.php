@extends('layouts.app')

@section('header')
    {{--    <link href="{{ asset('css/NavBar.css') }}" rel="stylesheet">--}}

@endsection

@section('content')


    <div class="container mt-5">
        @if ($errors->any())
            <div class="alert alert-danger ">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session("message"))
            <div class="alert alert-success">
                <p class="text-monospace text-center">{{session("message")}}</p>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-9">
                <img class="card-img-top img-fluid hvr-round-corners" src="/storage/storage/items/{{$item->image}}" alt="">

                <div class="card mt-4">
                    <div class="card-body">
                        <h1>{{$item->name}}</h1>
                        <h6>{{$item->category->name}}</h6>

                        <div class="row justify-content-between">
                            <small class="col mt-2">{{$item->status}}</small>
                            @if($item->discount!=0)
                                <h5 class="p-1 " style="display:inline; color: red ; border:1px solid red;"> you
                                    save {{intval($item->discount)}} % </h5>
                            @endif
                            <small class="col mr-2 text-right"> SKU : {{$item->sku}}</small>
                        </div>
                        <hr>
                        <br>
                        <h4>Description :</h4>
                        <p class="card-text">{{$item->description}}</p>

                    </div>

                </div>
            </div>

            <div class="col-lg-3 mt-4">
                <div class="justify-content-between">
                    <h4 class="col" style="display: inline ">Price :</h4>
                    @if($item->discount==0)
                        <h5 id="price" class="col" style="display: inline ">{{$item->price}} JOD</h5>
                    @else
                        <div class="col" style="display: inline ">
                            <h6 style="text-decoration: line-through;display: inline">{{$item->price}} JD</h6>
                            <h5 id="price"
                                style="display: inline ; color: red">{{$item->price-$item->price*$item->discount/100}}
                                JD</h5>
                        </div>
                    @endif
                </div>
                <br>
                @if($item->status==="Available")
                    @if($is_in_cart==null)
                        <form class=" " method='post' action='{{route('card.store')}}'>
                            @csrf
                            <div class="justify-content-between">
                                <h5 class="col-1 align-self-start" style="display: inline">Quantity :</h5>
                                <input class="col-4 align-self-end" onchange="myFunction()" type="number" id="qnt"
                                       value="1"
                                       name="quantity" min=1 max=100>
                            </div>
                            @if($item->short_description)
                                <h6 class=" col mt-2 text-success">* {{$item->short_description}}</h6>
                            @elseif($item->discount!=0)
                                <h6 class=" col mt-2 text-danger">* you
                                    save {{intval($item->discount)}} % </h6>
                            @endif
                            <hr>

                            <h4 class="col" style="display: inline ">Total Price </h4>
                            <h5 id="T_prise" class="col" style="display: inline "></h5>
                            <input type="hidden" value="{{$item->id}}" name="item_id">
                            <button type="submit" class="btn btn-outline-success btn-lg btn-block mt-2 hvr-radial-in"><i
                                    class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                    @else
                        @if($item->short_description)
                            <h6 class=" col mt-2 text-success">* {{$item->short_description}}</h6>
                        @elseif($item->discount!=0)
                            <h6 class=" col mt-2 text-danger">* you
                                save {{intval($item->discount)}} % </h6>
                        @endif
                        <a class="btn btn-primary btn-lg btn-block mt-2 hvr-push" href="{{ route('mycart') }}">
                            <i class="fas fa-shopping-cart"></i> View Cart</a>
                    @endif
                @else
                    @if($item->short_description)
                        <h6 class=" col mt-2 text-success">* {{$item->short_description}}</h6>
                    @elseif($item->discount!=0)
                        <h6 class=" col mt-2 text-danger">* you
                            save {{intval($item->discount)}} % </h6>
                    @endif
                    <h2 class="col text-center mt-2">{{$item->status}} </h2>
                @endif
                <br>
                @can('viewAny',App\Item::class)
                    <div>
                        <h3 class="col">Admin Tools</h3>

                        <form class=" " method='post' action='{{route('item.destroy',['id' => $item->id])}}'>
                            @method('delete')
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete {{$item->name}} ')"
                                    class="float-right btn btn-danger btn-lg btn-block my-1"><i
                                    class="far fa-trash-alt"></i>
                                Delete
                            </button>
                            <a href="/item/{{$item->id}}/edit"
                               class="float-right btn btn-warning btn-lg btn-block my-1 "><i
                                    class="far fa-edit"></i>Edit</a>
                        </form>
                    </div>
                @endcan

            </div>
        </div>
        <script>
            function myFunction() {
                let qnt = document.getElementById("qnt").value;
                let price =<?php echo $item->price - $item->price * $item->discount / 100;?>;
                console.log(price * qnt);
                document.getElementById("T_prise").innerHTML = (price * qnt) + " JOD";
            }

            myFunction();
        </script>

    </div>
    <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">

            <div class="carousel-inner" role="listbox">
                @foreach($ads as $ad)
                    <div class="carousel-item {{$loop->first?'active':''}}">
                        <a href="{{$ad->url}}">
                            <img class="d-block img-fluid" src="/storage/storage/ads/{{$ad->image}}"
                                 alt="{{$loop->index}}">
                        </a>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
@endsection
