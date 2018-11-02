@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
	<div class="col-md-12">
<form method="POST" action="{{ url('/save-site') }}">
       {{ csrf_field() }}
		<div class="card">
		<div class="card-header">Add site</div>
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
				<div class="form-group col-6">
					<label>Site Url</label>
					<input type="text" name="url" class="form-control" value="{{ old('url') }}">
				</div>
				<div class="form-group col-6">
					<label>Site name</label>
					<input type="text" name="name" class="form-control" value="{{ old('name') }}">
				</div>
		</div>
		</div>
		<div class="card">
		<div class="card-header">Ftp Detail(Optional)</div>
		<div class="card-body">
			
				<div class="form-group col-6">
					<label>Host</label>
					<input type="text" name="ftp_host" class="form-control" value="{{ old('ftp_host') }}">
				</div>
				<div class="form-group col-6">
					<label>User name</label>
					<input type="text" name="ftp_username" class="form-control" value="{{ old('ftp_username') }}">
				</div>
				<div class="form-group col-6">
					<label>Password</label>
					<input type="password" name="ftp_password" class="form-control" value="{{ old('ftp_password') }}">
				</div>
			
		</div>
		</div>
		<div class="card">
		<div class="card-header">Sftp Detail(Optional)</div>
		<div class="card-body">
			
				<div class="form-group col-6">
					<label>Host</label>
					<input type="text" name="sftp_host" class="form-control" value="{{ old('sftp_host') }}">
				</div>
				<div class="form-group col-6">
					<label>User name</label>
					<input type="text" name="sftp_username" class="form-control" value="{{ old('sftp_username') }}">
				</div>
				<div class="form-group col-6">
					<label>Password</label>
					<input type="password" name="sftp_password" class="form-control" value="{{ old('sftp_password') }}">
				</div>
			
		</div>
		</div>
		<div class="card">
		<div class="card-header">Cpanel Detail(Optional)</div>
		<div class="card-body">
			
				<div class="form-group col-6">
					<label>Host</label>
					<input type="text" name="cpanel_host" class="form-control" value="{{ old('cpanel_host') }}">
				</div>
				<div class="form-group col-6">
					<label>User name</label>
					<input type="text" name="cpanel_username" class="form-control" value="{{ old('cpanel_username') }}">
				</div>
				<div class="form-group col-6">
					<label>Password</label>
					<input type="password" name="cpanel_password" class="form-control" value="{{ old('cpanel_password')}}">
				</div>
				 <div class="col-md-9">
						<a href="{{url('sites')}}" class="btn btn-danger"> Cancel </a>
						<button type="submit" class="btn btn-primary">
						Submit
						</button> 
				</div>
		 </div>
		            
		</div>
</form>
</div>
</div>
</div>


@endsection
