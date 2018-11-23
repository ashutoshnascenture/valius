@extends('layouts.app-plan')
@section('content')
<style type="text/css">
#-error{
	color: red;
}
</style>
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
						<span> ${{ $plan->amount/100 }} / @if ($plan->interval==1) month  @endif</span>
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
	 <div class="alert alert-danger print-error-msg" style="display:none"> <ul></ul></div>
		<div class="row">
			<div class="col-md-12 info-box">
				<h2> Billing Information </h2>
				<div class="row">
					<div class="col-md-12 account-form mt-5">
					
						<div class="row">
							<div class="form-group col-md-12">
								<div class="row">
									<div class="radio radio-primary col-md-2">
										<input type="radio" name="user_type" id="radio5" value="1" class="check-comp">
										<label for="radio5"> Company </label>
									</div>
									<div class="radio radio-primary col-md-2">
										<input type="radio" name="user_type" id="radio6" value="2" checked class="check-comp">
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
							<div class="form-group col-md-6 comp-na" style="display: none;">
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
							<input data-stripe="name"  size='20' type='text'  class="form-control cardname" required />
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
					    <input id="planlocalid" type="hidden" name="planlocalid" value="{{$plan->id}}">
						<input id="planId" type="hidden" name="plan" value="{{$plan->plan_id}}">
						<input id="planName" type="hidden" name="plan_name" value="{{$plan->nickname}}">
						<input id="planAmout" type="hidden" name="plan_amount" value="{{$plan->amount}}">
					<div class="col-md-6 payment-summery pl-5">
						<div class="form-group">
							<label> PAYMENT SUMMARY </label>
						</div>
						<div class="form-group">
							<label> {{ $plan->nickname }} <span class="float-right">${{ $plan->amount/100  }} / @if ($plan->interval==1) month  @endif</span></label><br />
							<label> TOTAL <span class="float-right">${{ $plan->amount/100 }} / @if ($plan->interval==1) month  @endif</span></label>
						</div>
					</div>
					<div class="col-md-12">
						<button  type="submit" class=" submit btn btn-cont checkout"> Check out </button>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
</section>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
  <script src="http://malsup.github.com/jquery.form.js"></script> 
 <script type="text/javascript">
	var siteURl = '<?php  echo url('/'); ?>';
</script>
<script type="text/javascript">
	    $(document).ready(function () {
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
     $(document).ready(function () {
     	 $('.check-comp').click(function(){
            var checked = $(this).prop('checked');
            var chackedVal = $(this).val();
            if(checked && chackedVal==1) {
            	$('.comp-na').show();
            } else {
            	$('.comp-na').hide();
            }
     	 });
     	function  checkCompany(){
     		return $('#payment-form').find("input[name=user_type]:checked").val();
     	}
    $('#payment-form').validate({ // initialize the plugin 
	        rules: {
	            country_id: {
	                required: true
	            },
	            state_id: {
	                required: true
	            }
	            ,
	            city: {
	                required: true 
	               
	            }
	            ,
	            zipcode: {
	                required: true,
	                alphanumeric:true
	            }
	            ,
	            address: {
	                required: true,
	            }
	            ,
	            company_name: {
                    required: function(element) {
                        return (checkCompany() == 1);
                    }
	             }
	        },
	        messages:
	            {
	            country_id: "<font color='red'>Please select country<font>",
	            state_id: "<font color='red'>Please select state<font>",
	            city: {required:"<font color='red'>Please Enter city name<font>"},
	            zipcode: {required:"<font color='red'>Please Enter zipcode<font>"},
	            address: {required:"<font color='red'>Please Enter address<font>"},
	            company_name: {required:"<font color='red'>Please enter company name<font>"}
	            },
                submitHandler: function(form) {
                    $('.checkout').attr('disabled',true);
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
       jQuery.validator.addMethod("alphanumeric", function(value, element) {
		    return this.optional(element) || /^[\w.]+$/i.test(value);
		}, "<font color='red'>please enter valid zipcode</font>");
	});
	function stripeTokenHandler(token) {
	  var form = document.getElementById('payment-form');
	  var hiddenInput = document.createElement('input');
	  hiddenInput.setAttribute('type', 'hidden');
	  hiddenInput.setAttribute('name', 'stripeToken');
	  hiddenInput.setAttribute('value', token.id);
	  form.appendChild(hiddenInput);
      var queryString = $('#payment-form').formSerialize(); 
                        $.ajax({
                            url : siteURl+ "/plan-billing", 
                            type: "POST",             
                            data: queryString,
                            cache: false,             
                            processData: false,      
                            success: function(data) {  
                            if($.isEmptyObject(data.error)){
                                   form.submit();
                                }else{
                                	$('.checkout').removeAttr('disabled');
                                    printErrorMsg(data.error);

                                }
                            }
                        });
      
     }
     function printErrorMsg (msg) {

            $(".print-error-msg").find("ul").html('');

            $(".print-error-msg").css('display','block');

            $.each( msg, function( key, value ) {

                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');

            });
        }
</script>
@endsection