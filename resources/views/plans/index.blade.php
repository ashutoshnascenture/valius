@extends('layouts.app') @section('content')
<div class="container">
<div class="col-md-12 plan-page">

	<h2>Hosting Plans</h2>
       
            @if (session('status'))
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session('status') }}
                </div>
            @endif
          
                @if( !empty($plans) ) @if($is_subscribed)
                <p class="lead">You can always change your plan.</p>
                @else
                <p class="lead">Please choose any of given plan to activate your hosting.</p>
                @endif
                
                <div class="row">
                
                    @foreach($plans as $plan)
  
                    <?php //echo '<pre>'; print_r($plan); ?>
                        <div class="col-md-4 mb-4">
                        <div class="card plan">
                            <div class="card-header">
                               <h4>{{ $plan->nickname }}</h4>
                               <h3 class="pricing-card-title">${{ $plan->amount / 100 }} /<span> @if ($plan->interval==1) month  @endif</span></h3>
                            </div>
                            <div class="card-body">
                                
                                <ul class="list-unstyled">
                                    <li>10 GB of storage</li>
                                    <li>Priority email support</li>
                                </ul>
                                @if( $is_subscribed && ( $subscription->stripe_plan == $plan->plan_id ) )
                                <button class="btn btn-curant">Current Plan</button>
							@else
                                <button plan_name="{{ $plan->nickname }}" plan_id="{{ $plan->id }}" plan_amount="{{ $plan->amount / 100 }}" class="btn btn-choose">Choose</button> @endif

                            </div>
                            </div>
                        </div>
                        @endforeach
                      

                </div>
                @else
                <div class="alert alert-warning">
                    <strong>No Plan found on Stripe Account!</strong>
                    <br>
                    <p>It could be Network error or you don't have plans defined in Stripe Panel.</p>
                </div>
                @endif

                <?php //echo '<pre>'; print_r($plans); ?>
                <div class="card custome-card mb-4">
                	<div class="card-header">Make Payment</div>
                	<div class="card-body">
                		
                	<div class="row">
				<div class="col-md-8">
					<form action="{{ url('subscribe') }}" method="POST" id="payment-form">
						{{ csrf_field() }}
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
							<div class="col-md-12 form-group">
								<input id="planId" type="hidden" name="plan" value="">
								<input id="planName" type="hidden" name="plan_name" value="">
								<input type="submit" class="submit btn btn-success btn-lg btn-block" value="Make Payment">
							</div>
					</form>
					</div>
			</div>
			</div>
                </div>
          
 
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
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

			// Insert the token ID into the form so it gets submitted to the server:
			$form.append($('<input type="hidden" name="stripeToken">').val(token));

			// Submit the form:
			$form.get(0).submit();
		}
	};
	$('.btn-choose').click(function(){       
		
		var plan_id = $(this).attr('plan_id');
		var plan_name = $(this).attr('plan_name');
		
		$('#planId').val(plan_id);
		$('#planName').val(plan_name);
		
		$('.btn-choose').text('Choose');
		$('.btn-choose').removeClass('btn-success');
		$('.btn-choose').addClass('btn-primary');
		$(this).text('Seleted!');
		$(this).removeClass('btn-primary');
		$(this).addClass('btn-success');

	});
</script>

@endsection