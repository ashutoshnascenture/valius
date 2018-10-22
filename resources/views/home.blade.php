@extends('layouts.login')
@section('content')
<div class="container">
    <div class="row">
        @foreach($plans as $plan)
          <div class="col-md-3">
            <div class="card" style="margin-bottom: 10px;">
                <div class="card-body">
                   <div class="card-deck mb-3 text-center">
                    <?php //echo '<pre>'; print_r($plan); ?>
                        <div class="card mb-4 shadow-sm plan">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">{{ $plan->nickname }}</h4>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title pricing-card-title">${{ $plan->amount / 100 }} / @if ($plan->interval==1) month  @endif</small></h4>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>10 GB of storage</li>
                                    <li>Priority email support</li>
                                    <li>support</li>
                                </ul>
                                <a href="{{ url('/plan-select')}}/{{base64_encode($plan->id)}}" plan_name="{{ $plan->nickname }}" plan_id="{{ $plan->id }}" plan_amount="{{ $plan->amount / 100 }}" class="btn btn-primary btn-choose btn-block">Choose</a> 

                            </div>
                        </div>
                       
 
                </div>

                    
                </div>
            </div>
             </div>
             @endforeach
       
    </div>
</div>
@endsection
