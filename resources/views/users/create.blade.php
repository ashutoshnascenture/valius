@extends('layouts.app')
@section('content')

	<div class="col-md-9">
		<div class="card">
			<div class="card-header">Add Users</div>

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

				<form method="POST" action="{{ url('users') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					<div class="row">
					<div class="form-group col-md-8">
						<label >Name</label>
						<input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
					</div>
					<div class="form-group col-md-8">
						<label >Email<span style="color:red;">*</span></label>
						<input type="text" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
					</div>
					<div class="form-group col-md-8">
						<label >Password<span style="color:red;">*</span></label>
						<input  type="password"  class="form-control"  name="password" placeholder="Password" value="{{ old('password') }}">
					 </div>
					 <div class="form-group col-md-8">
						<label >Confirm Password<span style="color:red;">*</span></label>
						<input  type="password"  class="form-control"  name="confirm_password" placeholder="Password" value="{{ old('confirm_password') }}">
					 </div>
					<div class="form-group col-md-8">
						<label >Phone</label>
						<input  type="text"  class="form-control"  name="phone" placeholder="Phone" value="{{ old('password') }}">
					</div>
					
					 <input  type="hidden"   name="role_id"  value="2">
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
	
@endsection
