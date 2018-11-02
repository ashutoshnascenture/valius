@if(count($all_sites) >0)
<div class="total-search">
	    	All Sites<span>({{$totalSite}})</span>
</div>

@foreach( $all_sites as $all_site)
 <div class="container-box">

		<div class="site-list">
			<div class="row"> 
				<div class="img-box col-md-1">
				   @if (isset($all_site->site_image)) 
					<img src="{{url('/').'/public/upload/sites/'.$all_site->site_image}}" alt="" title="" />
				   @else 
                   <img src="{{ asset('images/default.jpg') }}" alt="" title="" />
				   @endif
				</div>
				<div class="col-md-8 name-box">
					<h3><a href="{{URL('/site-detail')}}/{{base64_encode($all_site->id)}} ">{{$all_site->name}} </a></h3>
					<a href="{{$all_site->url}}">
					{{$all_site->url}} </a>
				</div>
				<div class="col-md-2 price-box">
				    @php $totalAmount=$all_site->plan_amount; @endphp
				    @if(!empty($all_site->subscription->parent['children']))
				    @foreach($all_site->subscription->parent['children'] as $serviceAmount)
                     @php $totalAmount = $totalAmount+$serviceAmount->plan_amount; @endphp
				    @endforeach
				    @endif
					<h4>${{ $totalAmount/100}}/mo <span>{{count($all_site->subscription->parent['children'])}} Serveices</span></h4>
				</div>
                  <div class="col-md-1 action-box">
				   <div class="dropdown">
					  <a class="dropdown-toggle" data-toggle="dropdown">
					   <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
					  </a>
					  <div class="dropdown-menu">
					   <a class="dropdown-item" href="{{URL('/add-services')}}/{{base64_encode($all_site->subscription['id'])}}">Add Services</a>
					  </div>
					</div> 
					
				</div>
			</div>
		</div>
	</div>
@endforeach
<div class="col-md-12 pagination-box clearfix mt-4"> {{ $all_sites->links() }}</div>
@else
<p style="color:red;" class="not-found">No Site Found </p>
@endif

		 
		   