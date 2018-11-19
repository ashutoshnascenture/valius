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
					<ul class="navbar-nav nav-pills">
						<li class="nav-item active">
							<a  data-toggle="pill" class="nav-link"  href="#menu1">Overview <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a data-toggle="pill"  class="nav-link"  href="#menu2">Billing</a>
						</li>
					</ul>
				</nav>
			</div>
			<div class="col-md-3 right-nav">
				<!-- <div class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-cog" aria-hidden="true"></i>
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Link 1</a>
						<a class="dropdown-item" href="#">Link 2</a>
						<a class="dropdown-item" href="#">Link 3</a>
					</div>
				</div> -->
				<a href="#" class="btn btn-admin"> wp admin </a>
			</div>
		</div>
	</div>
</section> 
<!-- <section class="section mt-4">
	<div class="container tab-pane fade" id="menu1">
		<div class="row " >
			<div class="col-md-12">
			<div class="card custome-card">
				<div class="card-header">
					Overview
				</div>
				<div class="card-body">
					Overview
				</div>
			</div>
		</div>
		</div>
	</div>
</section> -->
<section class="section mt-4">
	<div class="container tab-pane" id="menu2">
		<div class="row " >
			<div class="col-md-12">
			<div class="card custome-card">
				<div class="card-header">
					Client Billing History
				</div>
				<div class="card-body">
					<p class="date-active"> Active since {{ Auth::user()->created_at->format('F Y') }}  </p>
				     @if(!empty($siteDetail->parent->invoicelist))
					@foreach($siteDetail->parent->invoicelist as $invoicelist)
					<div class="row paid-box align-items-center">
						<div class="col-md-2 paid-btn-box">
							<a href="#" class="btn btn-success btn-paid"> {{$invoicelist['status'] }} </a>
						</div>
						<div class="col-md-2 invoice-box">
							<a href="{{URL('/view-invoice-pdf')}}/{{{base64_encode($invoicelist['id'])}}}" target="_blank">View Invoice</a>
						</div>
						<div class="col-md-2 date-box">
							{{$invoicelist['created_at']->format('m/d/y') }}
						</div>
						<div class="col-md-6 text-right price-box">
							<b>${{$invoicelist['amount']['plan_amount']/100 }}</b>
						</div>
					</div>
					@endforeach
					@endif
				</div>
			</div>
		</div>
		</div>
	</div>
</section>
	</div>
</section>
@endsection