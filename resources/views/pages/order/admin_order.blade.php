@extends('layouts.app')
@section('content')
    <script>
        function openAll() {
            var more_details = document.getElementsByClassName('more_details');
            for (var i = 0; i < more_details.length; i++) {
                more_details[i].click();
            }
        }
        function printDiv() {
            var originalContents = document.body.innerHTML;
            openAll();
            window.print();
            document.body.innerHTML = originalContents;
        }

        function select_form(id) {
            document.getElementById(`select_form_${id}`).submit();
        }

    </script>
    <div style="width:75%" class="container-fluid ">
        @if(session("message"))
            <div class="alert alert-success">
                <p class="text-monospace text-center">{{session("message")}}</p>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="container mt-4">
            <div class="row mb-5">
                <h1 class="mt-4 mb-3 col"><i class="fas fa-truck"></i> Orders
                </h1>
                <button class="btn btn-secondary col-2  mt-5 mr-5 float-right" type="button"
                        onclick="printDiv()">print
                    all Ordars
                </button>
            </div>
            <div class="row mb-1">
                <div class="col-1 font-weight-bold text-center">
                    Order ID
                </div>
                <div class="col-1 font-weight-bold text-center">
                    Qnt
                </div>
                <div class="col-2 font-weight-bold text-center">
                    Price
                </div>
                <div class="col-3 font-weight-bold text-center">
                    Order Placed
                </div>
                <div class="col-3 font-weight-bold text-center">
                    Status
                </div>
                <div class="col-2 font-weight-bold text-center">
                    <a href="#" onclick="openAll()"> See All Details</a>
                </div>

            </div>
            @foreach($orders  as $order)
                <hr>
                <div id="">
                    <div class="row mb-1">
                        <div class="col-1 font-weight-bold text-center">
                            JO-{{$order->id}}
                        </div>
                        <div class="col-1 font-weight-bold text-center">
                            {{$order->qnt}}
                        </div>
                        <div class="col-2 font-weight-bold text-center">
                            {{$order->total}} JD
                        </div>
                        <div class="col-3 font-weight-bold text-center">
                            {{substr($order->created_at,0,10)}}
                        </div>
                        <div class="col-3 font-weight-bold text-center">
                            <form id="select_form_{{$order->id}}" method="post"
                                  action="{{route("order.update",$order)}}">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="select_form({{$order->id}})" value="{{$order->status}}"
                                        class="custom-select">
                                    @foreach($status_form_array as $status)
                                        <option
                                            {{$status === $order->status ? "selected" : ""}} value="{{$status}}">{{$status}}</option>
                                    @endforeach
                                </select>
                            </form>

                        </div>
                        <div class="col-2 font-weight-bold text-center">
                            <a data-toggle="collapse" href="#collapse_details{{$order->id}}"
                               role="button" class="more_details" aria-expanded="false" aria-controls="collapseExample">
                                More Details
                            </a>
                        </div>
                    </div>
                    <div class="row mb-1 justify-content-center">
                        <div class="col-10 mt-2 ">
                            <div class="collapse" id="collapse_details{{$order->id}}">
                                <h5 class="border-success border-bottom pb-2 ">Order Details</h5>
                                <div class="row pt-2 my-2">
                                    <p class="col-6"><span
                                            class="font-weight-bold">User Name : </span>{{$order->user->name}}</p>
                                    <p class="col-6"><span
                                            class="font-weight-bold">User Email : </span>{{$order->user->email}}</p>
                                    <p class="col-6"><span
                                            class="font-weight-bold">User Phone : </span>{{$order->user->phone}}</p>
                                    <p class="col-6"><span class="font-weight-bold">Country : </span>{{$order->country}}
                                    </p>
                                    <p class="col-6"><span class="font-weight-bold">State : </span>{{$order->state}}</p>
                                    <p class="col-6"><span class="font-weight-bold">City : </span>{{$order->city}}</p>
                                    <p class="col-6"><span class="font-weight-bold">Address : </span>{{$order->address}}
                                    </p>
                                    <p class="col-6"><span
                                            class="font-weight-bold"> Order Phone : </span>{{$order->phone}}</p>
                                </div>
                                <h5 class="border-bottom border-success pb-2 ">Order Items</h5>

                                @foreach($order->card  as $card)
                                    <div class="border border-success rounded my-2">
                                        <div class="row m-3">
                                            <div class="col-md-1">
                                                <a href="/item/{{$card->item_id}}">
                                                    <img class="img-fluid rounded"
                                                         src="/storage/items_img/{{$card->item->image}}"
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
                </div>
            @endforeach
        </div>
    </div>
@endsection

