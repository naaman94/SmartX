@extends('layouts.app')

@section('content')

    <div class="container">
        @if(session("message"))
            <div class="alert alert-success">
                <p class="text-monospace text-center">{{session("message")}}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <p class="text-monospace text-center">{{session("error")}}</p>
            </div>
        @endif


        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white bg-info">
                        <h4 class="text-center mt-2">{{ __('Change Password') }}</h4></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('changePassword') }}">
                            @csrf

                            <div class="row form-group">
                                <label for="current_password" class="col-md-4 control-label">Current Password</label>
                                <div class="col-md-6">
                                    <input id="current_password" type="password"
                                           class="form-control @error('current_password') is-invalid @enderror"
                                           name="current_password" required>
                                    @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror


                                </div>
                            </div>

                            <div class="row form-group ">
                                <label for="new_password" class="col-md-4 control-label">New Password</label>

                                <div class="col-md-6">
                                    <input id="new_password" type="password"
                                           class="form-control @error('new_password') is-invalid @enderror"
                                           name="new_password"
                                           required>
                                    @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>

                            <div class=" row form-group">
                                <label for="new_password_confirm" class="col-md-4 control-label">Confirm New
                                    Password</label>

                                <div class="col-md-6">
                                    <input id="new_password_confirm" type="password" class="form-control"
                                           name="new_password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary float-right">
                                        Change Password
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>






















@endsection
