@extends('layouts.login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center pt-4 pb-4 plan-heading">
            <h3> Simple pricing that works at any scale </h3>
            <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
        </div>
    </div>
	<div class="row">
		<div class="col-md-12 plan-detail-box">
				<div class="row">
					<!-- <div class="col-md-4 plan-detail">
						<div class="plan enterprise">
							<div class="plan-head"> 
								<h4 class="plan-name">Enterprise</h4> 
								<h2 class="plan-ammount">$30</h2>
								<h3 class="plan-month">Per Month</h3>
							</div>
							<div class="plan-body">
								<ul>
									<li> <i class="fa fa-check" aria-hidden="true"></i> 10 GB of storage</li>
									<li> <i class="fa fa-check" aria-hidden="true"></i> Priority email support</li>
									<li> <i class="fa fa-check" aria-hidden="true"></i> Support</li>
								</ul>
							</div>
						</div>
					</div> -->
					<div class="col-md-3 plan-box">
						<div class="plan enterprise">
					    	<div class="plan-head"> 
					            <h4 class="plan-name">Enterprise</h4> 
					            <h2 class="plan-ammount">$30</h2>
					            <h3 class="plan-month">Per Month</h3>
					        </div>
					        <div class="plan-body">
					            <ul>
					                <li> <i class="fa fa-check" aria-hidden="true"></i> 10 GB of storage</li>
					                <li> <i class="fa fa-check" aria-hidden="true"></i> Priority email support</li>
					                <li> <i class="fa fa-check" aria-hidden="true"></i> Support</li>
					            </ul>
					        </div>
					    </div>
					</div>

					<div class="col-md-9 plan-payment">
						<div class="box-container">
						<div class="payment-box">
							<div class="box-header mb-3">
								<div class="head-caption">
									<h2>Add your account information</h2>
								</div>
							</div>
							<div class="box-body">
								<div class="col-md-12">
									<form>
										<div class="form-group">
											<label> Email</label>
											<input type="email" name="" class="form-control" />
										</div>
										<div class="row">
											<div class="form-group col-md-6">
												<label> First name</label>
												<input type="text" name="" class="form-control" />
											</div>
											<div class="form-group col-md-6">
												<label> Last name</label>
												<input type="text" name="" class="form-control" />
											</div>
											<div class="form-group col-md-6">
												<label> Password</label>
												<input type="password" name="" class="form-control" />
											</div>
											<div class="form-group col-md-6">
												<label> Repeat password</label>
												<input type="password" name="" class="form-control" />
											</div>
										</div>
										<div class="form-group">
											<div class="checkbox-inline">
												<label class="checkbox-inline">
												<input type="checkbox" name="accept"> I agree to the Terms and Conditions and Privacy Policy</label>
											</div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-block btn-lg">Continue</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					</div>

				</div>

		</div>
	</div>
</div>











<div class="container">
    <div class="row justify-content-center">
       <div class="col-md-12">
        <div class="card">
			  <div class="card-header">
			    Plan Detail
			  </div>
			  <div class="card-body">
			    <div class="card mb-4 shadow-sm plan">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">{{ $plan->nickname }}</h4>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title pricing-card-title">${{ $plan->amount / 100 }} / @if ($plan->interval==1) month  @endif</h4>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>10 GB of storage</li>
                                    <li>Priority email support</li>
                                    <li>support</li>
                                </ul>
                            </div>
                        </div>
			  </div>
			</div>
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
			<div class="card mt-4">
				<div class="card-header">
					<h3>Add your account information</h3>
					<small>Please fill out all fields to continue </small>
				</div>
				<form method="post" action="{{ url('/plan-payment')}}" id="userform">
				 {{ csrf_field() }}
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label> Email </label>
								<input type="text"  class="form-control"  name="email"  value="{{old('email')}}" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label> First name </label>
								<input type="text"   class="form-control" name="first_name"  value="{{old('first_name')}}"/>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label> Last name </label>
								<input type="text"   class="form-control" name="last_name"  value="{{old('last_name')}}" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label> Password </label>
								<input type="password"   class="form-control" name="password" id="password" value="{{old('last_name')}}"/>
								<!-- <small>Password must contain a min. of 6 characters, at least one lowercase and capital letter, and a number</small> -->
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label> Repeat password </label>
								<input type="password"   class="form-control"  name="confirm_pass"  value="{{old('confirm_pass')}}" />
							</div>
						</div>
						<input type="hidden" name="palnID" value="{{ $plan->id}}">
						<div class="col-md-12 form-group">
							<div class="checkbox">
								<label class="checkbox-inline"> <input type="checkbox" name="accept"> I agree to the Terms and Conditions and Privacy Policy</label>
							</div>
						</div>
						<div class="form-group col-md-12">
							<button type="submit" class="btn btn-primary">Continue</button>
						</div>

					</div>
				</div>
				</form>
			</div>
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
	            }
	            ,
	            password: {
	                required: true 
	            }
	            ,
	            confirm_pass: {
	                required: true,
	                equalTo : "#password"
	            }
	            ,
	            accept: {
	                required: true,
	            }
	        },
	        messages:
	            {
	            email: "<font color='red'>Please Enter email<font>",
	            first_name: "<font color='red'>Please Enter  first name<font>",
	            last_name: {required:"<font color='red'>Please Enter last name<font>"},
	            password: {required:"<font color='red'>Please Enter password<font>"},
	            confirm_pass: {required:"<font color='red'>Please Enter password<font>",equalTo:"<font color='red'>repeat password  same as  password<font>"},
	            accept: {required:"<font color='red'>Please  accept term and conditions<font>"}
	            }
	    });

	});

</script>
@endsection