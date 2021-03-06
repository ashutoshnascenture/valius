<!DOCTYPE html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      @if(isset($title))
      <title>{{$title}} - {{ config('app.name') }}</title>
      @else
      <title>{{ config('app.name') }}</title>
      @endif
      <!-- Scripts -->
      <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('images/favicon.ico')}}">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
      <!-- Fonts -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
      <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
      <link rel="dns-prefetch" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <link href="{{ asset('css/style.css') }}" rel="stylesheet">
      <script  src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
   </head>
   <body>
      <div id="app">
         <nav class="navbar navbar-expand-md navbar-light fixed-top bg-ligh navbar-laravel main-nav">
            <div class="container">
               <a class="navbar-brand" href="{{ url('/') }}">
               <img src="{{ asset('images/ON_WHITE.svg') }}" alt="" title="" />
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
                     <li class="nav-item"><a  href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a></li>
                     @else
                     <li class="nav-item"><a  href="{{ url('/admin-dashboard') }}" class="nav-link">Dashboard</a></li>
                     @endif
                     <li class="nav-item"><a href="#" class="nav-link btn btn-contact">Contact Support</a></li>
                     <li class="nav-item dropdown user-drop">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle drop" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                           <div class="name-box">{{ ucfirst(Auth::user()->first_name[0])}}</div>
                           {{ Auth::user()->first_name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                           @if(!\Auth::user()->hasRole('admin'))
                           <li><a  href="{{ url('/dashboard') }}" class="dropdown-item"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>
                           @else
                           <li ><a  href="{{ url('/admin-dashboard') }}" class="dropdown-item"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>
                           @endif
                           <div class="dropdown-divider"></div>
                           @if(\Auth::user()->hasRole('admin'))
                           <li>
                              <a href="{{url('users/get-users')}}" class="dropdown-item">
                              <i class="fa fa-user" aria-hidden="true"></i> User Management</a>
                           </li>
                           <div class="dropdown-divider"></div>
                           <li>
                              <a href="{{url('plans/get-plans')}}" class="dropdown-item">
                              <i class="fa fa-leaf" aria-hidden="true"></i>
                              Plan Management</a>
                           </li>
                           <div class="dropdown-divider"></div>
                           <li><a href="{{url('addons')}}" class="dropdown-item">
                              <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                              Addon Management</a>
                           </li>
                            <div class="dropdown-divider"></div>
                           <li><a href="{{url('sites')}}" class="dropdown-item">
                              <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                              Site Management</a>
                           </li>
                           <div class="dropdown-divider"></div>
                           <li><a class="dropdown-item" href="{{ url('users/change-password') }}"><i class="fa fa-btn fa-key"></i>Change Password</a></li>
                           @else  
                             @if(Session::has('totalSite'))
                             
                               @if(Session::get('totalSite') != 0)
                                 <!-- <li>
                                    <a href="{{url('/add-site')}}" class="dropdown-item">
                                    <i class="fa fa-globe" aria-hidden="true"></i> Sites</a>
                                 </li> -->
                                <!--  <div class="dropdown-divider"></div> -->
                              <!--                             
                                 -->                           <!--  <a href="#" class="list-group-item list-group-item-action disabled">DNS</a> -->
                                 <li><a href="#" class="dropdown-item"><i class="fa fa-exchange" aria-hidden="true"></i>Migrations</a></li>
                                 <div class="dropdown-divider"></div>
                              <!-- <a href="#" class="list-group-item list-group-item-action disabled">Analytics</a> -->
                              <!--                            <a href="#" class="list-group-item list-group-item-action disabled">Billing</a>
                                 -->                           
                                 <li> <a href="{{url('plans')}}" class="dropdown-item">
                                    <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Billing</a>
                                 </li>
                             
                                 <div class="dropdown-divider"></div>
                                  <li> <a href="{{url('plans/update-payment')}}" class="dropdown-item">
                                    <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Update your payment method</a>
                                 </li>
                                 <div class="dropdown-divider"></div>
                                 <li> <a href="{{url('users/account-details/')}}" class="dropdown-item">
                                    <i class="fa fa-user" aria-hidden="true"></i>Account Details</a>
                                 </li>
                                 <div class="dropdown-divider"></div>
                                 <li> <a href="#" class="dropdown-item"> <i class="fa fa-comments-o" aria-hidden="true"></i> Conversations</a></li>
                             @endif
                            @endif
                           @endif
                          <!--  <div class="dropdown-divider"></div> -->
                           <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                              <i class="fa fa-btn fa-sign-out"></i>{{ __('Logout') }}
                              </a>
                           </li>
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
         <main class="mt-5 pt-5">
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

