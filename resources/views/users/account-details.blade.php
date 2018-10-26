@extends('layouts.app')
@section('content')
<div class="container">
     @if(Session::has('flash_message'))
		        <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                 {{ Session::get('flash_message') }} 
                </div>
		       @endif 
	<div class="row justify-content-center">
		<div class="col-md-8 text-center pt-4 pb-4 plan-heading">
			<h3> Update your profile</h3> 
			<p> If you would like to change your profile, simply change the information below  and click the update button to update.</p>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-9">
			<div class="box-container">
				
			<div class="col-md-10 offset-1">
				<h2 class="profile-info mt-5 mb-5"> Your  Information </h2>
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

				<form  id="userform" action ="{{URL::to('users/')}}/{{$user->id}}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<input type="hidden" name="_method" value="PUT">	

					<div class="form-group">
						<label> Email </label>
						<input type="text" name="email" value="{{ $user->email}}" class="form-control"  placeholder="Email">
					</div>
					<div class="row">
						<div class="form-group  col-md-6">
							<label> First Name </label>
							<input type="text" name="first_name" value="{{ $user->first_name}}" class="form-control"  placeholder="First Name">
						</div>	
						<div class="form-group  col-md-6">
							<label> Last Name </label>
							<input type="text" name="last_name" value="{{ $user->last_name}}" class="form-control"  placeholder="Last Name">
						</div>
					</div>	
					<div class="form-group">
						<label> Company Name </label>
						<input type="text" class="form-control" name="company_name" value="{{ $user->company_name}}" />
					</div>	
					<div class="row">
						<div class="form-group col-md-6">
							<label> Password </label>
							<input type="password" class="form-control" name="password" value="{{ old('password') }}"  id="password">
						</div>	
						<div class="form-group col-md-6">
							<label> Confirm Password </label>
							<input type="password" class="form-control" name="confirm_pass" />
						</div>	
					</div>	
					<div class="form-group mb-5">
						<a href="{{ url('/dashboard') }}" class="btn btn-link btn-cancel"> Cancel </a>
						<button type="submit" class="btn btn-update float-right"> Update Profile </button> 
					</div>
				</form>
			</div>
			</div>
		</div>
	</div>
</div>

 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript">
	    $(document).ready(function () {
	    $('#userform').validate({ // initialize the plugin
	        rules: {
	            email: {
	                required: true,
	                email:true   
	            },
	            first_name: {
	                required: true
	            }
	            ,
	            last_name: {
	                required: true
	            },
	            company_name: {
	            	required: true
	            }
	        },
	        messages:
	            {
	            email: "<font color='red'>Please Enter email<font>",
	            first_name: "<font color='red'>Please Enter  first name<font>",
	            last_name: {required:"<font color='red'>Please Enter last name<font>"},
	            company_name: {required:"<font color='red'>Please Enter company name<font>"}
	        }
	    });

	});

</script>
@endsection
