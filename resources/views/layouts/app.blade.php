<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VALIUS') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
 
    <!-- Fonts -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
	<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	
	
	<script  src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'VALIUS') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                             
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
							@if(empty(\Auth::user()->id == 1))
							<li class="nav-item">
                                <a class="btn btn-success" href="{{ url('ticket') }}">{{ __('Submit a Request') }}</a>
                            </li>
							@endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
								
								<ul class="dropdown-menu dropdown-menu-right" role="menu">

                                    <li><a class="dropdown-item" href="{{ url('users/change-password') }}"><i class="fa fa-btn fa-key"></i>Change Password</a></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-btn fa-sign-out"></i>{{ __('Logout') }}
                                    </a></li>
                                </ul>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
                                
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4"> 
		<div class="container">
			<div class="row">
			    <div class="col-md-3 sidebar">
					<div class="sidenav">
					<div class="user-profile text-center">
						<img src="{{url('/images/user.png')}}" alt="" title="" />
						<h4>@if(Auth::user() ) {{ Auth::user()->name }} @endif </h4>
					</div>
						
						<div class="list-group">
							@if(Auth::user() )
							@if(\Auth::user()->id == 1)
							
							<a href="{{url('users/get-users')}}" class="list-group-item list-group-item-action">
							User Management</a>
							<a href="{{url('plans/get-plans')}}" class="list-group-item list-group-item-action">
							Plan Managementjhjghjghjg</a>
                            <a href="{{url('addons')}}" class="list-group-item list-group-item-action">
                            Addon Management</a>
							@else  
							<a href="{{url('/')}}" class="list-group-item list-group-item-action">Dashboard</a>
                            <a href="{{url('sites')}}" class="list-group-item list-group-item-action active">Sites</a>
                            <a href="#" class="list-group-item list-group-item-action disabled">DNS</a>
							<a href="#" class="list-group-item list-group-item-action disabled">Migrations</a>
							<a href="#" class="list-group-item list-group-item-action disabled">Analytics</a>
<!-- 							<a href="#" class="list-group-item list-group-item-action disabled">Billing</a>
 -->						    <a href="{{url('plans')}}" class="list-group-item list-group-item-action">Billing</a>	
							<a href="{{url('users/account-details/')}}" class="list-group-item list-group-item-action disabled">Account Details</a>
							<a href="#" class="list-group-item list-group-item-action">Conversations</a>
							@endif
							@endif
						</div>
						
					</div>
				</div>
				@yield('content')
			</div>
		</div>
        </main>
    </div>
</body>
</html>
