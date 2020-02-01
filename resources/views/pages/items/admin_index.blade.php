@extends('layouts.app')

@section('header')
    {{--    <link href="{{ asset('css/NavBar.css') }}" rel="stylesheet">--}}

@endsection

@section('content')
    <div class="container mt-5">
        @if(session("message"))
            <div class="alert alert-success">
                <p class="text-monospace text-center">{{session("message")}}</p>
            </div>
        @endif

        <div class="row justify-content-between">
            <h1 class="col-6"><i class="fas fa-store-alt"></i> Admin Items dashboard </h1>
            <div class="btn-group float-right offset-md-3 ">
                <button type="button" class="btn btn-secondary my-1 mb-2 dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    {{isset($_GET['sort_by'])?$_GET['sort_by']:"Sorting By"}}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach($sort_by_arr as $data)
                        <a class="dropdown-item btn {{isset($_GET['sort_by'])?$_GET['sort_by']==$data?"bg-info disabled ":"":$data=="Time: newly listed"?"bg-info disabled ":""}}}"
                           href="{{route("item.admin_index",['sort_by'=>$data])}}">
                            {{$data}}</a>
                    @endforeach
                </div>
                <div>
                    <a class="btn btn-success mx-1 my-1 mb-2" href="/item/create"><i class="fas fa-plus"></i> Add </a>
                </div>

            </div>

        </div>
        @forelse($items  as $item)
            <div class="card my-4 {{$item->status!="Available"?"border-danger":""}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <a href="/item/{{$item->id}}">
                                <img class="img-fluid rounded" src="/storage/storage/items/{{$item->image}}" alt=""
                                     height="300" width="400">
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <h2 class="card-title">
                                <a style="color:black; text-decoration: none"
                                   href="/item/{{$item->id}}">{{$item->name}}</a>
                            </h2>

                            <hr>

                            <div>
                                <h5>SKU :  {{$item->sku}}</h5>
                                <h5>Category :  {{$item->category->name}}</h5>

                                <h5>Price : <span style="color:blue"> {{$item->price}} JD</span></h5>
                                <h5>Discount : <span style="color:red"> {{$item->discount}} %</span></h5>
                                @if($item->discount!=0)
                                    <h5>Total Price : <span style="color:blue">  {{$item->price-$item->price*$item->discount/100}} JD</span>
                                    </h5>
                                @endif
                                <h5>Status :  {{$item->status}}</h5>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <a href="/item/{{$item->id}}" class="btn btn-secondary btn-lg btn-block my-1"><i
                                    class="far fa-eye"></i> View
                            </a>
                            <form class=" " method='post' action='{{route('item.destroy',['id' => $item->id])}}'>
                                @method('delete')
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete {{$item->name}} category ?')"
                                        class="float-right btn btn-danger btn-lg btn-block my-1"><i
                                        class="far fa-trash-alt"></i> Delete
                                </button>
                                <a href="/item/{{$item->id}}/edit"
                                   class="float-right btn btn-warning btn-lg btn-block my-1 "><i
                                        class="far fa-edit"></i>Edit</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    Posted on {{$item->created_at}} - Update on {{$item->updated_at}} </div>
            </div>
        @empty
            <h1 class="col text-center">There is no items</h1>
        @endforelse
    </div>
@endsection
