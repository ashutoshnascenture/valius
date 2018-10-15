@extends('layouts.login')
@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-4 login-form">
               <!-- <h2> {{ __('Login') }}</h2> -->
                <h2 class="text-center mt-4"> Sign in to your account </h2>
                <div class="login-box mt-4">
                    <img src="{{ asset('images/varo.png') }}" class="login-logo" alt="" title="" />
                    <form method="POST" action="{{ route('login') }}"> 
                       @if (count($errors) > 0)
                        <div class="alert alert-pink">
                            <strong>Error!</strong> Login Detail incorrect
                        </div>
                        @endif
                        @csrf
                        <div class="form-group">
                          <!--   <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label> -->
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-Mail Addres" required autofocus>
                            <!-- @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif -->
                        </div>
 
                        <div class="form-group">
                            <!-- <label for="password" class="col-form-label">{{ __('Password') }}</label> -->
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                           <!--  @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif -->
                        </div>

                        <!-- <div class="form-group">
                           <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div> -->

                        <div class="text-center">
                        <button type="submit" class="btn btn-submit btn-block">{{ __('Login') }}</button>
                        <a class="btn btn-link mt-4" href="{{ route('password.request') }}" >{{ __('Forgot Your Password?') }}</a>
                        </div>
                    </form>
                </div>
            <p class="text-center mt-4"> Click here to <a href=""> Create account </a></p>
        </div>
    </div>
</div>
@endsection
