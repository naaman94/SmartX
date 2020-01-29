@extends('layouts.app')
@section('content')

    <div style="width:75%" class="container mt-5">
        @if(session("message"))
            <div class="alert alert-success">
                <p class="text-monospace text-center">{{session("message")}}</p>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-center">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="mt-4 mb-3"><i class="fas fa-cash-register"></i> My Order
        </h1>
        @if($orders->total())
            <div class="container mt-4">
                <div class="row mb-1">
                    <div class="col-1 text-center">
                        Order ID
                    </div>
                    <div class="col-1 text-center">
                        Qnt
                    </div>
                    <div class="col-2 text-center">
                        Price
                    </div>
                    <div class="col-3 text-center">
                        Order Placed
                    </div>
                    <div class="col-3 text-center">
                        Status
                    </div>
                    <div class="col-2 text-center">
                    </div>

                </div>
                @foreach($orders  as $order)
                    <hr>
                    <div class="row mb-1">
                        <div class="col-1 text-center">
                            JO-{{$order->id}}
                        </div>
                        <div class="col-1 text-center">
                            {{$order->qnt}}
                        </div>
                        <div class="col-2 text-center">
                            {{$order->total}} JD
                        </div>
                        <div class="col-3 text-center">
                            {{substr($order->created_at,0,10)}}
                        </div>
                        <div class="col-3 text-center">
                            {{$order->status}}
                        </div>
                        <div class="col-2 text-center">
                            <a data-toggle="collapse" href="#collapse_details{{$order->id}}"
                               role="button" aria-expanded="false" aria-controls="collapseExample">
                                More Details
                            </a>
                        </div>
                    </div>
                    <div class="row mb-1 justify-content-center">
                        <div class="col-10 mt-2 ">
                            <div class="collapse" id="collapse_details{{$order->id}}">
                                <h5 class="border-success border-bottom pb-2 ">Order Address</h5>
                                <div class="row pt-2 my-2">
                                    <p class="col-6"><span class="font-weight-bold">Country : </span>{{$order->country}}
                                    </p>
                                    <p class="col-6"><span class="font-weight-bold">State : </span>{{$order->state}}</p>
                                    <p class="col-6"><span class="font-weight-bold">City : </span>{{$order->city}}</p>
                                    <p class="col-6"><span class="font-weight-bold">Address : </span>{{$order->address}}
                                    </p>
                                    <p class="col-6"><span class="font-weight-bold">Phone : </span>{{$order->phone}}</p>
                                </div>
                                <h5 class="border-bottom border-success pb-2 ">Order Items</h5>

                                @foreach($order->card  as $card)
                                    <div class="border border-success rounded my-2">
                                        <div class="row m-3">
                                            <div class="col-md-1">
                                                <a href="/item/{{$card->item_id}}">
                                                    <img class="img-fluid rounded"
                                                         src="/storage/storage/items/{{$card->item->image}}"
                                                         alt=""
                                                         height="225" width="300">
                                                </a>
                                            </div>
                                            <div class="col-md-5">
                                                <h5>
                                                    <a style="color:black; text-decoration: none"
                                                       href="/item/{{$card->item->id}}">{{$card->item->name}}</a>
                                                </h5>
                                                <small>SKU : <span
                                                        style="color:blue"> {{$card->item->sku}}</span></small>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="row justify-content-center">
                                                    <h5 class="col" style="display: inline">
                                                        Qty: {{$card->quantity}}</h5></div>
                                            </div>
                                            <div class="col-md-3">
                                                <h5 id="price" class="text-left"
                                                    style="display: inline "> {{($card->item->price-$card->item->price*$card->item->discount/100)*$card->quantity}}
                                                    JOD</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="row ">
                    <div class="col">
                        {{$orders->links()}}
                    </div>
                </div>
                @else

                    <div class="row mt-5"><h1 class="col text-center">you dont have any orders yet</h1></div>
                @endif

            </div>
    </div>
@endsection
