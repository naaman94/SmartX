@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3">
                <div class="mt-4 row">
                    <h5 class="col mt-2">Sort by </h5>

                    <div class="btn-group col ">

                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            {{isset($_GET['sort_by'])?$_GET['sort_by']:"Time: newly listed"}}
                        </button>

                        <div class="dropdown-menu dropdown-menu-right">
                            @foreach($sort_by_arr as $data)
                                <a class="dropdown-item btn {{isset($_GET['sort_by'])?$_GET['sort_by']==$data?"bg-info disabled ":"":$data=="Time: newly listed"?"bg-info disabled ":""}}}"
                                   href="{{route("item.index",['sort_by'=>$data,'category'=> isset($_GET['category'])?$_GET['category']:"all_item"])}}">
                                    {{$data}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <h1 class="mt-2">Categories</h1>
                <div class="list-group">
                    <a href="{{route("item.index")}}"
                       class="list-group-item {{!isset($_GET['category'])?"  bg-info disabled":""}}">All items</a>
                    @foreach($categories as $category)
                        <a href="{{route("item.index",['category'=>$category->id])}}"
                           class="list-group-item {{isset($_GET['category'])?$_GET['category']==$category->id?"bg-info disabled ":"":""}}}">{{$category->name}}</a>
                    @endforeach
                </div>

            </div>
            <div class="col-lg-9">
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

                <div class="row">
                    @forelse($items  as $item)
                        <div class="col-lg-4 col-md-6 mb-4 hvr-grow">
                            <div class="card h-100">
                                <a href="/item/{{$item->id}}">
                                    <img class="card-img-top" src="/storage/storage/items/{{$item->image}}" alt=""
                                         height="200" width="150">
                                </a>
                                <div class="card-body">
                                    <h4 class="text-secondary card-title">
                                        <a class="text-secondary" style="text-decoration: none"
                                           href="/item/{{$item->id}}">{{$item->name}}</a>
                                    </h4>
                                    @if($item->discount==0)
                                        <h5>{{$item->price}} JD</h5>
                                        @if($item->short_description!=null)
                                            <small class="text-success">{{$item->short_description}}</small>
                                        @endif
                                    @else
                                        <h5 style="text-decoration: line-through">{{$item->price}}
                                            JD</h5>
                                        <h5 style=" color: red">{{$item->price-$item->price*$item->discount/100}}
                                            JD</h5>
                                        @if($item->short_description!=null)
                                            <small class="text-success">{{$item->short_description}}</small>
                                        @else
                                            <small class="text-danger">You save {{$item->discount}} %</small>
                                        @endif

                                    @endif

                                </div>
                                <div class="card-footer ">
                                    <div class="row justify-content-around">
                                        @if($item->status==="Available")
                                            <form class=" " method='post' action='{{route('card.store')}}'>
                                                @csrf
                                                <input type="hidden" value="1" name="quantity">
                                                <input type="hidden" value="{{$item->id}}" name="item_id">
                                                <button type="submit" class="btn btn-sm btn-outline-success"><i
                                                        class="fas fa-cart-plus "></i> Add to Cart
                                                </button>
                                            </form>
                                        @else
                                            <small class="text-muted m-1">{{$item->status}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h1 class="col text-center">There is no items in this category </h1>

                    @endforelse

                </div>
                <div class="row">
                    {{$items->links()}}
                </div>
            </div>


        </div>

    </div>
@endsection
