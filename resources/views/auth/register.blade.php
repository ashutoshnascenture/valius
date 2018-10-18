@extends('layouts.login')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 login-form">
           <h2 class="text-center mt-4"> {{ __('Register') }} </h2>
            <div class="login-box mt-4">
                <img src="{{ asset('images/varo.png') }}" class="login-logo" alt="" title="" />
                <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <!-- <label for="name" class="col-form-label">{{ __('Name') }}</label> -->
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <!-- <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label> -->
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"  placeholder="E-Mail Address" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                   <!--  <label for="password" class="col-form-label">{{ __('Password') }}</label> -->
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                </div>

                <div class="form-group ">
                <!-- <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label> -->
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                placeholder="Confirm Password" required>
                </div>

                <div class="form-group mb-0">
                <button type="submit" class="btn btn-submit btn-block">{{ __('Register') }}</button>
                    
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
