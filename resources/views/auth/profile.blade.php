@extends('layouts.app')
@section('content')
    <div class="container">
        @if(\Illuminate\Support\Facades\Auth::user()->id==$user->id)
            <h1 class="mt-4 mb-3"><i class="far fa-user"></i> My Profile</h1>
            @else
            <h1 class="mt-4 mb-3"><i class="far fa-user"></i> User Profile</h1>

        @endif

        <div class="row">
            <div class="col-lg-6 mb-4">
                <img class="img-fluid hvr-round-corners" src="/storage/storage/users/{{$user->image}}"
                     alt="">
            </div>
            <div class="col-lg-4 mb-4">
                <h3 class="text-capitalize">{{$user->name}}</h3>
                <p><span class="font-weight-bold">E-Mail Address : </span>{{$user->email}} <i
                        data-toggle="tooltip" data-placement="bottom" title="Email Validation"
                        class='{{$user->email_verified_at!=null?"text-success fas fa-check":"text-danger fas fa-times"}}'></i>
                </p>
                <p class="text-capitalize"><span class="font-weight-bold">Phone : </span>{{$user->phone}}</p>
                <p class="text-capitalize"><span class="font-weight-bold">Country : </span>{{$user->country}}</p>
                <p class="text-capitalize"><span class="font-weight-bold">City : </span>{{$user->city}}</p>
                <p class="text-capitalize"><span class="font-weight-bold">State : </span>{{$user->state}}</p>
                <p class="text-capitalize"><span class="font-weight-bold">Address : </span>{{$user->address}}</p>
                <p class="text-capitalize"><span class="font-weight-bold">Created at : </span>{{$user->created_at}}</p>
                @if(\Illuminate\Support\Facades\Auth::user()->id==$user->id)
                    <div class="row">
                        <a class="col" href="{{ route('changePassword') }}">
                            <i class="fas fa-key"></i> Change Password
                        </a>
                        <a class="col" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-edit"></i> Edit Profile
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection
