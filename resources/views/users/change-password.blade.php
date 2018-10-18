@extends('layouts.app')
@section('content')
<div class="container">
	<div class="box-container">
		<div class="box-header">
			<div class="head-caption">
				<h2>Change Password</h2>
			</div>
		</div>
		<div class="box-body">
			<div class="col-md-8">
				@if(Session::has('flash_message'))
					<div class="alert {{ Session::get('alert-class') }}">
						<a href="#" class="close" data-dismiss="alert">&times;</a> 
						{{Session::get('flash_message')}}
					</div>
					@endif
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<a href="#" class="close" data-dismiss="alert">&times;</a> 
						<strong>Whoops!</strong> There were some problems with your input.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				@if(session()->has('error'))
					<div class="alert alert-error">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						 {{ session()->get('error') }}
					</div>
				@endif

				<form method="POST" action="{{ url('users/reset-password') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="password">Current Password <span style="color:red;">*</span></label>
						<input id="password" type="password" class="form-control" name="current_password" placeholder="Current Password">
					</div>

				   <div class="form-group">
						<label for="password">New Password <span style="color:red;">*</span></label>
						<input id="password" type="password" class="form-control" name="password" placeholder="New Password">
					</div>

					<div class="form-group">
						<label for="password-confirm">Confirm Password <span style="color:red;">*</span></label>
						<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
					</div>
					<div class="form-group">
						<a href="#" class="btn btn-danger"> Cancel </a>
						<button type="submit" class="btn btn-primary">Change Password</button> 
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
    
@endsection
