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
        <div class="col-md-3 plan-box">
            <div class="plan personal">
                <div class="plan-head"> 
                    <h4 class="plan-name">Personal</h4> 
                    <h2 class="plan-ammount">$10</h2>
                    <h3 class="plan-month">Per Month</h3>
                </div>
                <div class="plan-body">
                    <ul>
                        <li> <i class="fa fa-check" aria-hidden="true"></i> 20 GB of storage</li>
                        <li> <i class="fa fa-check" aria-hidden="true"></i> Priority email support</li>
                        <li> <i class="fa fa-check" aria-hidden="true"></i> Support</li>
                    </ul>
                </div>
                <div class="plan-footer">
                    <a href="#" class="btn btn-choose">Choose Plan</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 plan-box">
            <div class="plan pro">
                <div class="plan-head"> 
                    <h4 class="plan-name">Professional</h4> 
                    <h2 class="plan-ammount">$20</h2>
                    <h3 class="plan-month">Per Month</h3>
                </div>
                <div class="plan-body">
                    <ul>
                        <li> <i class="fa fa-check" aria-hidden="true"></i> 10 GB of storage</li>
                        <li> <i class="fa fa-check" aria-hidden="true"></i> Priority email support</li>
                        <li> <i class="fa fa-check" aria-hidden="true"></i> Support</li>
                    </ul>
                </div>
                <div class="plan-footer">
                    <a href="#" class="btn btn-choose">Choose Plan</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 plan-box">
            <div class="plan business">
                <div class="plan-head "> 
                    <h4 class="plan-name">Business</h4> 
                    <h2 class="plan-ammount">$25</h2>
                    <h3 class="plan-month">Per Month</h3>
                </div>
                <div class="plan-body">
                    <ul>
                        <li> <i class="fa fa-check" aria-hidden="true"></i> 30 GB of storage</li>
                        <li> <i class="fa fa-check" aria-hidden="true"></i> Priority email support</li>
                        <li> <i class="fa fa-check" aria-hidden="true"></i> Support</li>
                    </ul>
                </div>
                <div class="plan-footer">
                    <a href="#" class="btn btn-choose">Choose Plan</a>
                </div>
            </div>
        </div>
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
                <div class="plan-footer">
                    <a href="#" class="btn btn-choose">Choose Plan</a>
                </div>
            </div>
        </div>



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
