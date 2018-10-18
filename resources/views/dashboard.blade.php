@extends('layouts.app')
@section('content')

<div class="dashboard-home">
	<div class="container">
		<div class="row">
			<div class="col-md-2 d-img-box">
				 <img src="{{ asset('images/default.jpg') }}" alt="" title="" />
			</div>
			<div class="col-md-9 detail-box">
				<h4> VaroLocal </h4>
				<a href="#" class="">varolocal.com</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 dash-nav">
				<ul class="mr-auto list-inline">
					<li> <a href="#"> Overview </a></li>
					<li> <a href="#"> Billing </a></li>
				</ul>
				<a href="#" class="ml-auto btn btn-sm btn-login">Wp admin </a>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-9 ">
			<div class="box-container">
				<div class="box-header">
					<div class="head-caption">
						<h2>Services</h2>
					</div>
				</div>
				
				<div class="box-body"> 
					<div class="col-md-12 services-box">
						<div class="row">
							<div class="dash-detail col-md-10">
								<h4>SCO <span>Auto Reviews</span></h4>	
								<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
							</div>
							<div class="col-md-2 amount-box">
								<h5><b>$10.00</b></h5>
							</div>
						</div>
					</div>
					<div class="col-md-12 services-box">
						<div class="row">
							<div class="dash-detail col-md-10">
								<h4>Maintenance <span>Auto Reviews</span></h4>	
								<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
							</div>
							<div class="col-md-2 amount-box">
								<h5><b>$10.00</b></h5>
							</div>
						</div>
					</div>
					<div class="col-md-12 services-box">
						<div class="row">
							<div class="dash-detail col-md-10">
								<h4>Hosting <span>Auto Reviews</span></h4>	
								<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
							</div>
							<div class="col-md-2 amount-box">
								<h5><b>$10.00</b></h5>
							</div>
						</div>
					</div>
					<div class="col-md-12 services-box">
						<div class="row">
							<div class="dash-detail col-md-10">
								<h4>Design <span>Auto Reviews</span></h4>	
								<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
							</div>
							<div class="col-md-2 amount-box">
								<h5><b>$10.00</b></h5>
							</div>
						</div>
					</div>
					<div class="col-md-12 total-box">
						<div class="row">
							<div class="dash-detail col-md-10">
								<h4>Total</h4>	
							</div>
							<div class="col-md-2 full-total">
								<h5><b>$40.00</b></h5>
							</div>
						</div>
					</div>
				</div>
				


				<!-- <div class="card">
					<div class="card-header">Dashboard</div>
					<div class="card-body">
						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif
						You are logged in!
					</div>
				</div> -->
			</div>
		</div>
			<div class="col-md-3">
				<div class="box-container">
					<div class="box-header mb-3">
					<div class="head-caption">
						<h2>Contact</h2>
					</div>
				</div>
				<div class="box-body "> 
					<div class="col-md-12">
						<b>Email</b>
						<p>demo@gmail.com</p>
					</div>	
					<div class="col-md-12">
						<b> Phone No. </b>
						<p>12457912366</p>
					</div>	
					<div class="col-md-12">
						<b> Mailing address </b>
						<p> demo address</p>
					</div>	
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
@endsection
