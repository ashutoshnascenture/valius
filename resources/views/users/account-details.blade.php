@extends('layouts.app')
@section('content')

    
	
	<div class="container">
    <div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">Account Details</div>

			<div class="card-body">
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

				<form action ="{{URL::to('users/')}}/{{$user->id}}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<input type="hidden" name="_method" value="PUT">			
					
					<!-- <div class="form-group col-md-8">
						<label>User Name<span style="color:red;">*</span></label>
						<input type="text" name="name" value="{{ $user->name}}" class="form-control"  placeholder="User Name">
					</div> -->
					
					<div class="form-group col-md-8">
						<label>Email<span style="color:red;">*</span></label>
						<input type="text" name="email" value="{{ $user->email}}" class="form-control"  placeholder="Email">
					</div>
					 
					<div class="form-group col-md-8">
						<label>Name</label>
						<input type="text" name="first_name" value="{{ $user->first_name}}" class="form-control"  placeholder="First Name">
					</div>
					<!-- <div class="form-group col-md-8">
						<label>Last Name</label>
						<input type="text" name="last_name" value="{{ $user->last_name}}" class="form-control"  placeholder="Last Name">
					</div> -->

					<div class="form-group col-md-8">
						<label>Mobile Phone</label>
						<input type="text" name="phone" value="{{ $user->phone}}" class="form-control"  placeholder="Phone" maxlength="15">
					</div>

					
					<div class="col-md-8">
						<a href="{{url('dashboard/')}}" class="btn btn-danger">
						Cancel</a>
						<button type="submit" class="btn btn-success">Update User</button>
						
					</div>
					<input type="hidden" id="deletefiles" name="deletefiles" value=""/>
				</form>
			</div>
		</div>
	</div>
	</div>
	</div>
@endsection
