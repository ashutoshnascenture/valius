@extends('layouts.app',['title'=> $title])
@section('content')

<section class="top-section">
	<div class="container">
		<div class="row site-pro">
			<div class="col-md-2 img-box">
			    @if (isset($siteDetail->site_image)) 
					<img src="{{url('/').'/public/upload/sites/'.$siteDetail->site_image}}" alt="" title="" />
				   @else 
                   <img src="{{ asset('images/default.jpg') }}" alt="" title="" />
				   @endif
			</div>
			<div class="col-md-10 site-pro">
				<h4>{{$siteDetail->name}}</h4>
				<a href="#"> {{$siteDetail->url}} </a>
			</div>
		</div>
		<div class="row nav-box">
			<div class="col-md-9 left-nav">
				<nav class="navbar navbar-expand-lg">
					<ul class="navbar-nav">
						<li class="nav-item active">
							<a class="nav-link" href="#">Overview <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Billing</a>
						</li>
					</ul>
				</nav>
			</div>
			<div class="col-md-3 right-nav">
				<div class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-cog" aria-hidden="true"></i>
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Link 1</a>
						<a class="dropdown-item" href="#">Link 2</a>
						<a class="dropdown-item" href="#">Link 3</a>
					</div>
				</div>
				<a href="#" class="btn btn-admin"> wp admin </a>
			</div>
		</div>
	</div>
</section> 
<section class="section mt-4">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<div class="card custome-card">
				<div class="card-header">
					Client Billing History
				</div>
				<div class="card-body">
					<p class="date-active"> Active since Octpber 2018 </p>
					<div class="row paid-box align-items-center">
						<div class="col-md-2 paid-btn-box">
							<a href="#" class="btn btn-success btn-paid"> Paid </a>
						</div>
						<div class="col-md-2 invoice-box">
							<a href="#">View Invoice</a>
						</div>
						<div class="col-md-2 date-box">
							10/16/18
						</div>
						<div class="col-md-6 text-right price-box">
							<b>$100</b>
						</div>
					</div>
					<div class="row paid-box mt-1 align-items-center">
						<div class="col-md-2 paid-btn-box">
							<a href="#" class="btn btn-success btn-paid"> Paid </a>
						</div>
						<div class="col-md-2 invoice-box">
							<a href="#">View Invoice</a>
						</div>
						<div class="col-md-2 date-box">
							10/16/18
						</div>
						<div class="col-md-6 text-right price-box">
							<b>$100</b>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</section>




<section class="site-section mt-5">
	<div class="container">
		<div class="row">
          @if(!empty($siteDetail->subscription->parent['children']))
		  @foreach($siteDetail->subscription->parent['children'] as $service)
			<div class="col-md-6">
				<div class="box-container">
					<div class="box-header mb-2">
						<div class="head-caption">
							<h2>{{ $service->plan_name}}</h2>
						</div>
					</div>
					<div class="box-body">
						<div class="col-md-6">
							Price:-${{ $service->plan_amount/100}}
						</div>
					</div>
				</div>
			</div>
			@endforeach
			@else
            <span> No services added</span>
			@endif
			<!-- <div class="col-md-6">
				<div class="box-container">
					<div class="box-header mb-2">
						<div class="head-caption">
							<h2>Collaborators</h2>
						</div>
					</div>
					<div class="box-body">
						<div class="col-md-6">
							dfdfdf
						</div>
					</div>
				</div>
			</div>
		</div> -->
	</div>
</section>






@endsection