@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone"
                                       class="col-md-4 col-form-label text-md-right">{{ __('phone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control " name="phone"
                                           value="{{ old('phone') }}" required autocomplete="phone">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="country"
                                       class="col-md-4 col-form-label text-md-right">{{ __('country') }}</label>

                                <div class="col-md-6">
                                    <input id="country" type="text" class="form-control " name="country"
                                           value="{{ old('country') }}" required autocomplete="country">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="state"
                                       class="col-md-4 col-form-label text-md-right">{{ __('state') }}</label>
                                <div class="col-md-6">
                                    <select name="state" class="custom-select" id="state">
                                        <option selected value="'Amman">'Amman</option>
                                        <option value="Ajlun">Ajlun</option>
                                        <option value="Al 'Aqabah">Al 'Aqabah</option>
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
                                       class="col-md-4 col-form-label text-md-right">{{ __('city') }}</label>

                                <div class="col-md-6">
                                    <input id="city" type="text" class="form-control " name="city"
                                           value="{{ old('city') }}" required autocomplete="city">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address"
                                       class="col-md-4 col-form-label text-md-right">{{ __('address') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control " name="address"
                                           value="{{ old('address') }}" required autocomplete="address">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="image"
                                       class="col-md-4 col-form-label text-md-right">{{ __('image') }}</label>

                                <div class="col-md-6">
                                    <div class="custom-file">
                                        <input type="file" name="image"  class="custom-file-input" id="image" >
                                        <label class="custom-file-label" for="image">Choose file</label>

                                    </div>
                                </div>
                            </div>

{{--                            <div class="form-group col-md-12">--}}
{{--                                <label>Firmenlogo</label>--}}
{{--                                <div class="custom-file">--}}
{{--                                    <input type="file" name="image" class="custom-file-input" id="validatedCustomFile"--}}
{{--                                           required>--}}
{{--                                    <input type="hidden" name="_token" value="{{csrf_token()}}">--}}
{{--                                    <label class="custom-file-label" for="validatedCustomFile">Datei--}}
{{--                                        auswählen...</label>--}}
{{--                                    <div class="invalid-feedback">Bitte laden Sie hier Ihr Firmenlogo hoch.</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
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
