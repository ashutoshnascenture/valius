@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 text-center pt-4 pb-4 plan-heading">
			<h3> Update your profile</h3> 
			<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-9">
			<div class="box-container">
				
			<div class="col-md-10 offset-1">
				<h2 class="profile-info mt-5 mb-5"> Your Information </h2>
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

				<form method="POST" action="{{URL::to('users/userUpdate')}}/{{$user->id}}">
					<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					<input type="hidden" name="_method" value="PUT">

					<div class="form-group">
						<label> Email </label>
						<input type="text" class="form-control" />
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label> First Name </label>
							<input type="text" class="form-control" />
						</div>	
						<div class="form-group  col-md-6">
							<label> Last Name </label>
							<input type="text" class="form-control" />
						</div>
					</div>	
					<div class="form-group">
						<label> Company Name </label>
						<input type="text" class="form-control" />
					</div>	
					<div class="row">
						<div class="form-group col-md-6">
							<label> Password </label>
							<input type="password" class="form-control" />
						</div>	
						<div class="form-group col-md-6">
							<label> Confirm Password </label>
							<input type="password" class="form-control" />
						</div>	
					</div>	
					<!-- <div class="form-group">
						<label >Name</label>
						<input type="text" class="form-control" name="name" placeholder="Name" value="{{ $user->name }}">
					</div> -->
					<!-- div class="row">
						<div class="form-group col-md-6">
							<label >Email<span style="color:red;">*</span></label>
							<input type="test" class="form-control" name="email" placeholder="Email" value="{{ $user->email }}">
						</div>
						<div class="form-group col-md-6">
							<label for="password">Password<span style="color:red;">*</span></label>
							<input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<label> Company Name</label>
						<input type="text" name="" class="form-control" />
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="confirm_password">Confirm Password<span style="color:red;">*</span></label>
							<input type="password" class="form-control" name="confirm_password" value="{{ old('confirm_password') }}" placeholder="Confirm Password">
						</div>
					    <div class="form-group col-md-6">
							<label for="phone">Phone</label>
							<input type="text" class="form-control" name="phone" value="{{ $user->phone }}" placeholder="Phone">
						</div>
					</div> -->
					<div class="form-group mb-5">
						<a href="{{ url('users/get-users') }}" class="btn btn-link btn-cancel"> Cancel </a>
						<button type="submit" class="btn btn-update float-right"> Update Profile </button> 
					</div>
				</form>
			</div>
			</div>
		</div>
	</div>
</div>

 
@endsection
