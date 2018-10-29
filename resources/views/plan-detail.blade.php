@extends('layouts.app-plan')
@section('content')
<section class="plan-deatil-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-9 step-box">
				<div class="connecting-line"></div>
				<div class="row">
					<div class="col-md-4 text-center step-text active">
						<a href="#" class="">
							<span></span>
							Choose A Plan
						</a>
					</div>
					<div class="col-md-4 text-center step-text">
						<a href="#" class="">
							<span></span>
							Account Information
						</a>
					</div>
					<div class="col-md-4 text-center step-text">
						<a href="#" class="">
							<span></span>
							Payment
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="plan-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 plan-box">
				<div class="row">
					<div class="col-md-5 plan">
						<h2> {{ $plan->nickname }}</h2>
						<span> ${{ $plan->amount  }} / @if ($plan->interval==1) month  @endif</span>
						<div class="change-btn-box mt-4">
							<a href="https://getvaro.com/" class="btn plan-btn"> Change Plan </a>
						</div>
					</div>
					<div class="col-md-7 plan-detail">
						<div class="row">
							<div class="col-md-12 detail-list">
							    @php $planDescriptions = explode(',',$plan->description); @endphp 
								<ul>
									 @foreach($planDescriptions as $planDescription)
                                    <li>{{ $planDescription }}</li>
                                    @endforeach
								</ul>
							</div>
							<!-- <div class="col-md-6 detail-list">
								<ul>
									<li>Unlimited Content edits</li>
									<li>4 development Points/mo</li>
									<li>Weekly wordpress speed optimization</li>
								</ul>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="account-info-section">
	<div class="container">
	  @if (session('status'))
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session('status') }}
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
		<div class="row">
			<div class="col-md-12 info-box">
				<h2> Add Your Account Information </h2>
				<p> Please fill out all the fields to continue </p>
				<div class="row ">
					<div class="col-md-12 account-form mt-5">
					<form method="post" action="{{ url('/plan-payment')}}" id="userform">
					   {{ csrf_field() }}
						<div class="row">
							<div class="form-group col-md-6">
								<label> Email </label>
								<input type="email"  class="form-control"  name="email"  value="{{old('email')}}" />
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-6">
								<label> First Name </label>
								<input type="text"   class="form-control" name="first_name"  value="{{old('first_name')}}"/>
							</div>
							<div class="form-group col-md-6">
								<label> Last Name </label>
								<input type="text"   class="form-control" name="last_name"  value="{{old('last_name')}}" />
							</div>
						
							<div class="form-group col-md-6">
								<label> Password </label>
								<input type="password"   class="form-control" name="password" id="password" value="{{old('last_name')}}"/>
							</div>
							<div class="form-group col-md-6">
								<label> Repeat Password </label>
								<input type="password"   class="form-control"  name="confirm_pass"  value="{{old('confirm_pass')}}" />
							</div>
							<input type="hidden" name="palnID" value="{{ $plan->id}}">
							<div class="form-group col-md-12">
								<h5> Password must contain a min. of 6 characters, at least one lowercase and capital letter, and a number.</h5>
							</div>
							<div class="form-group">
								<div class="checkbox">
								    <input id="checkbox5" type="checkbox" name="accept">
								    <label for="checkbox5">I agree to the terms and Conditions and Privacy Policy</label>
								    
								</div>
								<span class="trmerror" style="display: none; color:red; margin-left: 47px;">please accept terms and conditions</span>
							</div>
							<div class="col-md-12">
							  <button type="submit" class="btn btn-cont">Continue</button>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
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
	            }
	            ,
	            password: {
	                required: true ,
	                passwordvalidate: true
	            }
	            ,
	            confirm_pass: {
	                required: true,
	                equalTo : "#password"
	            }
	            
	        },
	        messages:
	            {
	            email: "<font color='red'>Please Enter email<font>",
	            first_name: "<font color='red'>Please Enter  first name<font>",
	            last_name: {required:"<font color='red'>Please Enter last name<font>"},
	            password: {required:"<font color='red'>Please Enter password<font>"},
	            confirm_pass: {required:"<font color='red'>Please Enter confirm  password<font>",equalTo:"<font color='red'>repeat password  same as  password<font>"},
	            
	            },
	            submitHandler: function(form) {
                     if($('#checkbox5').prop("checked")) {
                     	$('.trmerror').hide();
                     	return true;
                     } else {

                     	$('.trmerror').show();
                     	return false;
                     }
                     // submit from callback

                }
	    });
	      jQuery.validator.addMethod("passwordvalidate", function(value, element){
	      	var checkPassword =  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,50}$/.test(value);
		    return checkPassword;
		    }, "<font color='red'>Password must contain a min. of 6 characters, at least one lowercase and capital letter, and a number<font>"); 
	});

</script>
@endsection