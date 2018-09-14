@extends('layouts.app')
@section('content')

	<div class="col-md-9">
		<div class="card">
			<div class="card-header">Submit a Request</div>

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

				<form method="POST" action="{{ url('ticket') }}">
					{{ csrf_field() }}
					<div class="row">
					<div class="form-group col-md-8">
						<label for="name">Name <span style="color:red;">*</span></label>
						<input id="name" type="text" class="form-control" name="name" placeholder="Name">
					</div>

				   <div class="form-group col-md-8">
						<label for="email">Email<span style="color:red;">*</span></label>
						<input id="email" type="text" class="form-control" name="email" placeholder="Email">
					</div>

					<div class="form-group col-md-8">
						<label for="phone">Phone</label>
						<input id="phone" type="text" class="form-control" name="phone" placeholder="Phone">
					</div>
					<div class="form-group col-md-8">
						<label for="subject">Subject</label>
						<input id="subject" type="text" class="form-control" name="subject" placeholder="Subject">
					</div>
					<input  type="hidden"  name="users_id" value="{{$user->id}}">
					<input  type="hidden"  name="user_id" value="{{$user->id}}">
					
					<div class="form-group col-md-8">
						<label for="message">Message<span style="color:red;">*</span></label>
						<textarea class="form-control" name="message" cols="50" rows="6" id="message"></textarea>
					</div>
					
					<div class="col-md-9">
						<a href="#" class="btn btn-danger"> Cancel </a>
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
