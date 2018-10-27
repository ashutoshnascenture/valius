@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 text-center pt-4 pb-4 plan-heading">
			<h3> Update  Your Payment method</h3> 
			<p> If you would like to update your payment method, simply change the information below  and click the update button to update.</p>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-9">
			<div class="box-container">
				
			<div class="col-md-10 offset-1">
				<h2 class="profile-info mt-5 mb-5"> Your Card </h2>
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
     <script type="text/javascript" src="http://js.stripe.com/v3/"></script>
				<form  id="payment-form" action ="{{URL::to('plans/update-card')}}" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					

					<div class="form-group">
						<label> Cardholder's Name </label>
						<input type="text" name="name" value="" class="form-control">
					</div>
					<div class="form-group">
				 <label for="card-element">
						      Card  number
						    </label>
						    <div id="card-element" class="form-control card-update">
						      <!-- A Stripe Element will be inserted here. -->
						    </div>

						    <!-- Used to display form errors. -->
						    <div id="card-errors" role="alert"></div>
						    </div>
						<div class="form-group form-select">
							<label> Country </label>
							<select class="form-control" name="country_id">
								<option value="">Select Country</option>
								@foreach($allCountry as $Country)
                                 <option  @if($user->country_id == $Country->id) selected @endif value="{{$Country->id}}">{{$Country->name}}</option>
                                 @endforeach
							</select>
							<i class="fa fa-angle-down" aria-hidden="true"></i>

						</div>
						<div class="form-group">
							<label> Account Discription </label>
							<input type="text"  class="form-control" name="acdescription">
						</div>

						 
					<div class="form-group mb-5">
						<a href="{{ url('/dasboard') }}" class="btn btn-link btn-cancel"> Cancel </a>
						<button type="submit" class="btn btn-update float-right"> Update  Card </button> 
					</div>
					 </div>
				</form>
			</div>
			</div>
		</div>
	</div>
</div>

 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript">
   var stripe = Stripe("{{ config('services.stripe.key') }}");
   var elements = stripe.elements();
	var style = {
	  base: {
	    color: '#32325d',
	    lineHeight: '18px',
	    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
	    fontSmoothing: 'antialiased',
	    fontSize: '16px',
	    '::placeholder': {
	      color: '#aab7c4'
	    }
	  },
	  invalid: {
	    color: '#fa755a',
	    iconColor: '#fa755a'
	  }
	};
var card = elements.create('card', {style: style});
card.mount('#card-element');
card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
	  if (event.error) {
	    displayError.textContent = event.error.message;
	  } else {
	    displayError.textContent = '';
	  }
	 });
  $(document).ready(function () {
    $('#payment-form').validate({ // initialize the plugin 
	        rules: {
	            country_id: {
	                required: true
	            },
	            acdescription: {
	                required: true
	            }
	            ,
	            name: {
	                required: true
	            }
	        },
	        messages:
	            {
	            country_id: "<font color='red'>Please select country<font>",
	            acdescription: "<font color='red'>Please enter account description<font>",
	            name: {required:"<font color='red'>Please Enter card holder name name<font>"}
	            },
                submitHandler: function(form) {
                	stripe.createToken(card).then(function(result) {
					    if (result.error) {
					      var errorElement = document.getElementById('card-errors');
					      errorElement.textContent = result.error.message;
					    } else {
					      stripeTokenHandler(result.token);
					    }
					  });
                	return false;
                }

	    });
        function stripeTokenHandler(token) {
		  var form = document.getElementById('payment-form');
		  var hiddenInput = document.createElement('input');
		  hiddenInput.setAttribute('type', 'hidden');
		  hiddenInput.setAttribute('name', 'stripeToken');
		  hiddenInput.setAttribute('value', token.id);
		  form.appendChild(hiddenInput);
	      form.submit();
        }
	});
</script>
@endsection
