@extends('layouts.app-plan')
@section('content')
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
			      <div class="card mt-4">
			        <div class="card-header">
					<h3>Please fill stripe card detail</h3>
					<!-- <small>Please fill out all fields to continue </small> -->
				</div>
				@if (session('status'))
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session('status') }}
                </div>
             @endif
					<form action="{{ url('/subscribe-plan') }}" method="POST" id="payment-form">
						{{ csrf_field() }}
						<div class="card-body">
						<h5 class="text-center alert-danger">
							<span class="payment-errors label label-danger"></span>
						</h5>

						<div class="row">
						    <div class="col-md-12 form-group">
								<label class='control-label'>Card Name</label>
								<input autocomplete='off' value="" class='form-control card-name' data-stripe="name" size='20' type='text' placeholder='Name' required>
							</div>
							<div class="col-md-12 form-group">
								<label class='control-label'>Card Number</label>
								<input autocomplete='off' value="4242 4242 4242 4242" class='form-control card-number' data-stripe="number" size='20' type='text' required>
							</div>
							<div class="col-md-4 form-group">
								<label class='control-label'>CVC</label>
								<input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' data-stripe="cvc" size='4' type='text' required>
							</div>
							<div class="col-md-4 form-group">
								<label class='control-label'>Expiration Month</label>
								<input class='form-control card-expiry-month' placeholder='MM' value="{{ date('d') }}" data-stripe="exp_month" size='2' type='text' required>
							</div>
							<div class="col-md-4 form-group">
								<label class='control-label'> Year</label>
								<input class='form-control card-expiry-year' placeholder='YY' data-stripe="exp_year" size='2' value="{{ date( 'y', strtotime('+ 4 year')) }}" type='text' required>
							</div>
							<div class="col-md-6 form-group">
							    <input id="planlocalid" type="hidden" name="planlocalid" value="{{$plan->id}}">
								<input id="planId" type="hidden" name="plan" value="{{$plan->plan_id}}">
								<input id="planName" type="hidden" name="plan_name" value="{{$plan->nickname}}">
								<input id="userEmail" type="hidden" name="email" value="{{$userDetail['email']}}">
								<input id="userFirstname" type="hidden" name="first_name" value="{{$userDetail['first_name']}}">
								<input id="userLastname" type="hidden" name="last_name" value="{{$userDetail['last_name']}}">
								<input id="userPassword" type="hidden" name="password" value="{{$userDetail['password']}}">
								<input type="submit" class="submit btn btn-success btn-lg btn-block" value="Make Payment">
							</div>
					  </div>
					</form>
				</div>
		</div>
		</div>
   </div>
</div>
</div>
 <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">

	Stripe.setPublishableKey("{{ config('services.stripe.key') }}");

	$(function() {
		var $form = $('#payment-form');
		$form.submit(function(event) {
			// Disable the submit button to prevent repeated clicks:
			$form.find('.submit').prop('disabled', true);

			// Request a token from Stripe:
			Stripe.card.createToken($form, stripeResponseHandler);

			// Prevent the form from being submitted:
			return false;
		});
	});

	function stripeResponseHandler(status, response) {
		// Grab the form:
		var $form = $('#payment-form');

		if (response.error) { // Problem!

			// Show the errors on the form:
			$form.find('.payment-errors').text(response.error.message);
			$form.find('.submit').prop('disabled', false); // Re-enable submission

		} else { // Token was created!

			// Get the token ID:
			var token = response.id;
             console.log(token);
			// Insert the token ID into the form so it gets submitted to the server:
			$form.append($('<input type="hidden" name="stripeToken">').val(token));

			// Submit the form:
			$form.get(0).submit();
		}
	}
</script>
@endsection