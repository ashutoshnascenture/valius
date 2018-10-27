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
					<div class="col-md-4 text-center step-text active">
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
<script type="text/javascript" src="http://js.stripe.com/v3/"></script>
<section class="plan-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 plan-box">
				<div class="row">
					<div class="col-md-5 plan">
						<h2> {{ $plan->nickname }}</h2>
						<span> ${{ $plan->amount }} / @if ($plan->interval==1) month  @endif</span>
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
  <form action="{{ url('/subscribe-plan') }}" method="POST" id="payment-form">
						{{ csrf_field() }}
	<div class="container">
		<div class="row">
			<div class="col-md-12 info-box">
				<h2> Billing Information </h2>
				<div class="row">
					<div class="col-md-12 account-form mt-5">
					
						<div class="row">
							<div class="form-group col-md-12">
								<div class="row">
									<div class="radio radio-primary col-md-2">
										<input type="radio" name="user_type" id="radio5" value="1">
										<label for="radio5"> Company </label>
									</div>
									<div class="radio radio-primary col-md-2">
										<input type="radio" name="user_type" id="radio6" value="2" checked>
										<label for="radio6">Individual</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-6 counrty-box">
								<label> Country </label>
								<select name="country_id" class="form-control countrySelect">
								 <option value="">Select Country</option>
								@foreach($allCountry as $Country)
                                 <option value="{{$Country->id}}">{{$Country->name}}</option>
                                 @endforeach
								</select>
								<i class="fa fa-angle-down" aria-hidden="true"></i>

								
							</div>
							<div class="form-group col-md-6 counrty-box">
								<label> STATE </label>
								<select name="state_id" class="form-control stateSelect">
                                 <option>Select State</option>
								</select>
								<i class="fa fa-angle-down" aria-hidden="true"></i>
								
							</div>
						
							<div class="form-group col-md-6">
								<label> CITY </label>
								<input type="text" name="city" class="form-control" />
							</div>
							<div class="form-group col-md-6">
								<label> ZIP CODE </label>
								<input type="text" name="zipcode" class="form-control"  />
							</div>
							<div class="form-group col-md-12">
								<label> Address </label>
								<input type="text" name="address" class="form-control" />
							</div>
							<div class="form-group col-md-6">
								<label> COMPANY </label>
								<input type="text" name="company_name" class="form-control" />
							</div>
							
						</div>
					</form>
					</div>
				</div>
				<h2 class="mt-5 mb-5">Credit card details</h2>
				<span class="payment-errors label label-danger" style="color:red;"></span>
				<div class="row">
					<div class="col-md-6 pr-5">
						<div class="form-group">
							<label>CARD HOLDER NAME</label>
							<input data-stripe="name" size='20' type='text'  class="form-control cardname" required />
						</div>

					
						
						
						    <label for="card-element">
						      Card Detail
						    </label>
						    <div id="card-element" class="card-cvc-detail">
						      <!-- A Stripe Element will be inserted here. -->
						    </div>

						    <!-- Used to display form errors. -->
						    <div id="card-errors" role="alert"></div>
						  </div>
							<!-- <input autocomplete='off'  data-stripe="number" size='20' type='text'   class="card-no card-number" placeholder="Card Number " />
							<input data-stripe="exp" size='2' type='text'   class="date-year"  placeholder="MM/YY"  />
							<input type="text"  autocomplete='off' class="cvc-no card-cvc" placeholder="CVC"  data-stripe="cvc" size='4' type='text'  /> -->
						

				
					    <input id="planlocalid" type="hidden" name="planlocalid" value="{{$plan->id}}">
						<input id="planId" type="hidden" name="plan" value="{{$plan->plan_id}}">
						<input id="planName" type="hidden" name="plan_name" value="{{$plan->nickname}}">
						<input id="planAmout" type="hidden" name="plan_amount" value="{{$plan->amount}}">
					<div class="col-md-6 payment-summery pl-5">
						<div class="form-group">
							<label> PAYMENT SUMMARY </label>
						</div>
						<div class="form-group">
							<label> {{ $plan->nickname }} <span class="float-right">${{ $plan->amount  }} / @if ($plan->interval==1) month  @endif</span></label><br />
							<label> TOTAL <span class="float-right">${{ $plan->amount }} / @if ($plan->interval==1) month  @endif</span></label>
						</div>
					</div>
					<div class="col-md-12">
						<button  type="submit" class=" submit btn btn-cont"> Check out </button>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
</section>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
   <!-- <script type="text/javascript" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script> -->
 
<script type="text/javascript">
	    $(document).ready(function () {
	    	//$(".date-year").inputmask({"mask": "99/99"});
            $('.countrySelect').change(function(){
            	var countryID = $(this).val();
            	getState(countryID);
            	
            });
           function getState(countryID) 
           {
                var siteUrl= '<?php  echo url('/'); ?>';
	            $.ajax({
	            url:  siteUrl+'/get-states/'+countryID,
	            type: 'GET',
	            success : function(res){
	            	$('.stateSelect').html(res);
	            }	
	            });
           }
	   

	});
</script>
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
/*var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();
  stripe.createToken(card).then(function(result) {
    if (result.error) {
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      stripeTokenHandler(result.token);
    }
  });
});*/
    
     $(document).ready(function () {
    $('#payment-form').validate({ // initialize the plugin 
	        rules: {
	            country_id: {
	                required: true
	            },
	            state_id: {
	                required: true
	            }
	            ,
	            last_name: {
	                required: true
	            }
	            ,
	            city: {
	                required: true 
	               
	            }
	            ,
	            zipcode: {
	                required: true,
	                number:true
	            }
	            ,
	            address: {
	                required: true,
	            }
	            ,
	            company_name: {
	                required: true,
	            }
	           
	        },
	        messages:
	            {
	            country_id: "<font color='red'>Please select country<font>",
	            state_id: "<font color='red'>Please select state<font>",
	            city: {required:"<font color='red'>Please Enter city name<font>"},
	            zipcode: {required:"<font color='red'>Please Enter zipcode<font>",number:"<font color='red'>Please Enter valid number<font>"},
	            address: {required:"<font color='red'>Please Enter address<font>"},
	            company_name: {required:"<font color='red'>Please enter company name<font>"}
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
                     // submit from callback

                }
	    });
	});
	/*$(function() {
		var $form = $('#payment-form');
		$form.submit(function(event) {
			// Disable the submit button to prevent repeated clicks:
			$form.find('.submit').prop('disabled', true);
			  var timearray= $('.date-year').val().split('/'); 
              console.log(timearray[0]);
			// Request a token from Stripe:
			Stripe.card.createToken($form, stripeResponseHandler);

			// Prevent the form from being submitted:
			return false;
		});
	});*/
	function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
	  var form = document.getElementById('payment-form');
	  var hiddenInput = document.createElement('input');
	  hiddenInput.setAttribute('type', 'hidden');
	  hiddenInput.setAttribute('name', 'stripeToken');
	  hiddenInput.setAttribute('value', token.id);
	  form.appendChild(hiddenInput);
      form.submit();
     }
	/*function stripeResponseHandler(status, response) {
		var $form = $('#payment-form');
		if (response.error) { 
			$form.find('.payment-errors').text(response.error.message);
			$form.find('.submit').prop('disabled', false); // Re-enable submission
		} else { 
			var token = response.id;
			$form.append($('<input type="hidden" name="stripeToken">').val(token));
			$form.get(0).submit();
		}
	}*/
</script>
@endsection