@extends('layouts.app')

@section('content')

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
        <h1 class="mt-4 mb-3"><i class="fas fa-cash-register"></i> Check Out
        </h1>
        <h1>My Order</h1>

        @if(empty($order->card))
            <div class="row ">

                <h1 class="col text-center">Your Cart is Empty </h1>
            </div>
        @else

            <div class="row ">
                <div class="col-lg-7">
                    @foreach($order->card  as $card)
                        <div class="card mb-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-1">
                                        <a href="/item/{{$card->item_id}}">
                                            <img class="img-fluid rounded"
                                                 src="/storage/items_img/{{$card->item->image}}"
                                                 alt=""
                                                 height="225" width="300">
                                        </a>
                                    </div>
                                    <div class="col-lg-5">
                                        <h5>
                                            <a style="color:black; text-decoration: none"
                                               href="/item/{{$card->item->id}}">{{$card->item->name}}</a>
                                        </h5>
                                        <small>SKU : <span
                                                style="color:blue"> {{$card->item->sku}}</span></small>

                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row justify-content-center">
                                            <h5 class="col" style="display: inline">
                                                Qty: {{$card->quantity}}</h5></div>
                                    </div>
                                    <div class="col-lg-3">
                                        <h5 id="price" class="text-left"
                                            style="display: inline "> {{($card->item->price-$card->item->price*$card->item->discount/100)*$card->quantity}}
                                            JOD</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <hr>
                    <div class="row ">
                        <h3 class="col text-right">Total ({{$total['qnt']}} Items) : {{$total['after_dis']}} JD</h3>
                    </div>
                </div>
                <div class="col-lg-5">
                    <form class="container" method="post" action="{{route('order.update',$order)}}">
                            @method('PUT')
                            @csrf
                        <div class="row">
                            <h3>Order Address </h3>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="country"
                                   class="col-md-2 col-form-label text-md-right">Country </label>

                            <div class="col-md-9">
                                <input id="country" type="text" class="form-control " style="pointer-events:none;" name="country"
                                       value="Jordan"  autocomplete="country">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state"
                                   class="col-md-2 col-form-label text-md-right">State</label>
                            <div class="col-md-9">
                                <select name="state" value="{{ old('state',$order->state) }}" class="custom-select"
                                        id="state">
                                    <option selected value="Amman">Amman</option>
                                    <option value="Ajlun">Ajlun</option>
                                    <option value="Al Aqabah">Al 'Aqabah</option>
                                    <option value="Al Balqa'">Al Balqa'</option>
                                    <option value="Al Karak">Al Karak</option>
                                    <option value="Al Mafraq">Al Mafraq</option>
                                    <option value="At Tafilah">At Tafilah</option>
                                    <option value="Az Zarqa'">Az Zarqa'</option>
                                    <option value="Irbid">Irbid</option>
                                    <option value="Jarash">Jarash</option>
                                    <option value="Ma'an">Ma'an</option>
                                    <option value="Madaba">Madaba</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city"
                                   class="col-md-2 col-form-label text-md-right">City</label>

                            <div class="col-md-9">
                                <input id="city" type="text" class="form-control " name="city"
                                       value="{{ old('city',$order->city) }}" required autocomplete="city">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address"
                                   class="col-md-2 col-form-label text-md-right">Address</label>

                            <div class="col-md-9">
                                <input id="address" type="text" class="form-control " name="address"
                                       value="{{ old('address',$order->address) }}" required autocomplete="address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone"
                                   class="col-md-2 col-form-label text-md-right">Phone</label>
                            <div class="col-md-9">
                                <input id="phone" type="text" class="form-control " name="phone"
                                       value="{{ old('phone' ,$order->phone)}}" required autocomplete="phone">
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <button type="submit"  class="col-md-8 offset-md-2 btn btn-primary btn-lg btn-block"><i class="far fa-check-circle"></i> Confirm</button>

                        </div>
                    </form>

                </div>
                @endif
            </div>
    </div>


@endsection
