<!DOCTYPE html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Varo') }}</title>

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
        <nav class="navbar navbar-expand-md navbar-dark navbar-laravel top-nav">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                   <img src="{{ asset('images/varo.png') }}" alt="" title="" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                   
                    <ul class="navbar-nav ml-auto">
                       
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                             
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
							@if(!\Auth::user()->hasRole('admin'))
							<!-- <li class="nav-item">
                                <a class="btn btn-success" href="{{ url('ticket') }}">{{ __('Submit a Request') }}</a>
                            </li> -->
							@endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
								
								<ul class="dropdown-menu dropdown-menu-right" role="menu">
                                 <li> <a href="{{url('/')}}" class="dropdown-item">Dashboard</a></li>
                                @if(\Auth::user()->hasRole('admin'))

                                            <li><a href="{{url('users/get-users')}}" class="dropdown-item">
                                    User Management</a></li>
                                    <li><a href="{{url('plans/get-plans')}}" class="dropdown-item">
                                    Plan Management</a></li>
                                    <li><a href="{{url('addons')}}" class="dropdown-item">
                                    Addon Management</a></li>
                            @else     
                            <li><a href="{{url('sites')}}" class="dropdown-item">Sites</a></li>
                           <!--  <a href="#" class="list-group-item list-group-item-action disabled">DNS</a> -->
                            <li><a href="#" class="dropdown-item">Migrations</a></li>
                            <!-- <a href="#" class="list-group-item list-group-item-action disabled">Analytics</a> -->
<!--                            <a href="#" class="list-group-item list-group-item-action disabled">Billing</a>
 -->                           <li> <a href="{{url('plans')}}" class="dropdown-item">Billing</a></li>   
                           <li> <a href="{{url('users/account-details/')}}" class="dropdown-item">Account Details</a></li>
                            <li> <a href="#" class="dropdown-item">Conversations</a></li>   
                            @endif

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
			    
						
					   
						
					</div>
				</div>
				@yield('content')
			</div>
		</div>
        </main>
    </div>
</body>
</html>
