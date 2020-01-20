@extends('layouts.app')

@section('header')
    {{--    <link href="{{ asset('css/NavBar.css') }}" rel="stylesheet">--}}

@endsection

@section('content')
    <div class="container">

        <div class="row">

            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card mt-4">
                    <img class="card-img-top img-fluid" src="/uploads/items_img/{{$item->image}}"  height="700" width="525" alt="">
                    <div class="card-body">
                        <h3 class="card-title">{{$item->name}}</h3>
                        @if($item->discount==0)
                            <h4>{{$item->price}}</h4>
                        @else
                            <h4 style="text-decoration: line-through;display: inline">{{$item->price}} JD</h4>
                            <h4 style="display: inline">{{$item->price-$item->price*$item->discount/100}} JD</h4>

                        @endif
                        <p class="card-text">{{$item->description}}</p>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Product Reviews
                    </div>
                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore,
                            similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat
                            laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                        <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                        <hr>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore,
                            similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat
                            laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                        <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                        <hr>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore,
                            similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat
                            laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
                        <small class="text-muted">Posted by Anonymous on 3/1/17</small>
                        <hr>
                        <a href="#" class="btn btn-success">Leave a Review</a>
                    </div>
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col-lg-9 -->
            <div class="col-lg-3 mt-4">
                <div class="justify-content-between">
                    <h4 class="col" style="display: inline ">Price :</h4>
                    @if($item->discount==0)
                        <h5 id="price" class="col" style="display: inline ">{{$item->price}} JOD</h5>
                    @else
                        <div class="col" style="display: inline ">
                            <h5 style="text-decoration: line-through;display: inline">{{$item->price}} JD</h5>
                            <h5 id="price" style="display: inline ; color: red">{{$item->price-$item->price*$item->discount/100}} JD</h5>
                        </div>

                    @endif
                </div>
                <br>
                <div class="justify-content-between">
                    <h5 class="col-1 align-self-start" style="display: inline">Quantity :</h5>
                    <input class="col-4 align-self-end"onchange="myFunction()" type="number" id="qnt" value="1" name="quantity" min=1 max=25>
                </div>
                <hr>
                <h4 class="col" style="display: inline " >Total Price </h4>
                <h5 id="T_prise" class="col" style="display: inline "></h5>

                <button type="button" class="btn btn-outline-success btn-lg btn-block mt-2"><i class="fas fa-cart-plus"></i> Add to Cart</button>
<br>
                <div class="list-group">
                    <a href="/item" class="list-group-item">All items</a>

                    @foreach($categories as $category)
                        <a href="{{$category->id}}" class="list-group-item">{{$category->name}}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <script>
            function myFunction() {
                let qnt = document.getElementById("qnt").value;
                let price =<?php echo $item->price-$item->price*$item->discount/100 ;?>;
                console.log(price*qnt);
                document.getElementById("T_prise").innerHTML = (price*qnt) +" JOD";
            }
            myFunction();
        </script>
    </div>
@endsection
