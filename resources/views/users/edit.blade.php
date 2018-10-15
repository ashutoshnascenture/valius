@extends('layouts.app')
@section('content')
<div class="container">
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">Edit Users</div>

			<div class="card-body">
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
					<div class="row">
					<div class="form-group col-md-8">
						<label >Name</label>
						<input type="text" class="form-control" name="name" placeholder="Name" value="{{ $user->name }}">
					</div>
					
					<div class="form-group col-md-8">
						<label >Email<span style="color:red;">*</span></label>
						<input type="test" class="form-control" name="email" placeholder="Email" value="{{ $user->email }}">
					</div>
					<div class="form-group col-md-8">
						<label for="password">Password<span style="color:red;">*</span></label>
						<input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password">
					</div>
					<div class="form-group col-md-8">
						<label for="confirm_password">Confirm Password<span style="color:red;">*</span></label>
						<input type="password" class="form-control" name="confirm_password" value="{{ old('confirm_password') }}" placeholder="Confirm Password">
					</div>
				    <div class="form-group col-md-8">
						<label for="phone">Phone</label>
						<input type="text" class="form-control" name="phone" value="{{ $user->phone }}" placeholder="Phone">
					</div>
					
					
					<div class="col-md-9">
						<a href="{{ url('users/get-users') }}" class="btn btn-danger"> Cancel </a>
						<button type="submit" class="btn btn-primary">
						Submit
						</button> 
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
 </div>
 </div>
 
@endsection
