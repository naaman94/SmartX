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
                    <a href="{{route("item.index",['category'=>"all_item"])}}" class="list-group-item">All items</a>
                    @foreach($categories as $category)
                        <a href="{{route("item.index",['category'=>$category->id])}}" class="list-group-item">{{$category->name}}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row">
                      @forelse($items  as $item)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <a href="/item/{{$item->id}}">
                                    <img class="card-img-top" src="/storage/items_img/{{$item->image}}" alt=""
                                         height="200" width="150">
                                </a>
                                <div class="card-body">
                                    <h4 class="text-secondary card-title">
                                        <a class="text-secondary"    style="text-decoration: none"
                                           href="/item/{{$item->id}}">{{$item->name}}</a>
                                    </h4>
                                    @if($item->discount==0)
                                        <h5>{{$item->price}} JD</h5>
                                        <small>Best Offer</small>

                                    @else
                                        <h5 style="text-decoration: line-through">{{$item->price}}
                                            JD</h5>
                                        <h5 style=" color: red">{{$item->price-$item->price*$item->discount/100}}
                                            JD</h5>
                                        <small>You save {{$item->discount}} %</small>

                                    @endif
{{--                                    <p class="card-text">{{Illuminate\Support\Str::limit($item->description, 150, ' ...')}}</p>--}}
                                </div>
                                <div class="card-footer ">
                                    <div class="row justify-content-around">
                                            @if($item->status==="Available")
                                            <form class=" " method='post' action='{{route('card.store')}}'>
                                                @csrf
                                                <input type="hidden" value="1" name="quantity">
                                                <input type="hidden" value="{{$item->id}}" name="item_id">
                                                <button type="submit" class="btn btn-sm btn-outline-success"><i
                                                        class="fas fa-cart-plus"></i> Add to Cart
                                                </button>
                                            </form>
                                                @else
                                            <small class="text-muted">{{$item->status}}</small>
                                                @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                          @empty
                        <h1 class="col text-center">There is no items in this category </h1>

                    @endforelse


                </div>
                <!-- /.row -->

            </div>
            <!-- /.col-lg-9 -->

        </div>
        <!-- /.row -->

    </div>

@endsection