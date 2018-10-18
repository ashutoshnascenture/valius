@extends('layouts.login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 login-form">
            <h2 class="text-center mt-4"> {{ __('Reset Password') }} </h2>
            <div class="login-box mt-4">
                <img src="{{ asset('images/varo.png') }}" class="login-logo" alt="" title="" />
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <!-- <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label> -->
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                           <button type="submit" class="btn btn-block btn-submit">{{ __('Send Password Reset Link') }}</button> 
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

@endsection
