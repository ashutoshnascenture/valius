@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      @if(Session::has('flash_message'))
      <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×
        </a>
        {{ Session::get('flash_message') }} 
      </div>
      @endif 
      @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
      @endif
      <div class="col-md-12">
        <div class="container-box">
          @if($totalSite == 0)
          <div class="form-group">
            <a href="{{ url('/add-site') }}" class="btn btn-start "> Get Started 
            </a>
          </div>  
          @else
          @foreach( $all_sites as $all_site)
          <div class="site-list">
            <div class="row align-items-center">
              <div class="img-box col-md-2">
                @if (isset($all_site->site_image)) 
                <img src="{{url('/').'/public/upload/sites/'.$all_site->site_image}}" alt="" title="" />
                @else 
                <img src="{{ asset('images/default.jpg') }}" alt="" title="" />
                @endif
              </div>   
              <div class="col-md-6 name-box">
                <h3>
                  <a href="{{URL('/single-site-detail')}}/{{base64_encode($all_site->id)}} ">{{$all_site->name}} </a>
                </h3>
                <a href="{{URL('/single-site-detail')}}/{{base64_encode($all_site->id)}}">
                  {{$all_site->url}} 
                </a>
              </div>
              <div class="col-md-4 text-right">

                <a href="{{$all_site->url}}/wp-admin" class="btn btn-admin"> Wp-admin 
                </a>
                <a class="" href="{{URL('sites')}}/{{base64_encode($all_site->id)}}/edit">
                      <i class="fa fa-cog" aria-hidden="true"></i>
                </a>  
              </div>
            </div>
          </div>    
          @endforeach                 
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
