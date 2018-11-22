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
				      @php $totalAmount=$all_site->parent['plan_amount']; @endphp
				    @if(!empty($all_site->parent['children']))
				    @php $total_services = count($all_site->parent['children']); @endphp
				    @foreach($all_site->parent['children'] as $serviceAmount)
                    @php $totalAmount = $totalAmount+$serviceAmount->plan_amount; @endphp
				    @endforeach
                    @else 
                     @php $total_services = 0; @endphp
                     @endif

					<h4>${{ $totalAmount/100}}/mo <span>{{$total_services}} Serveices</span></h4>
					
				</div>
                  <div class="col-md-1 action-box">
                   <a href="#" class="addservice" siteid="{{base64_encode($all_site->parent['id'])}}"  id="addservice" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a>
				   <!-- <div class="dropdown">
					  <a class="dropdown-toggle" data-toggle="dropdown">
					   <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
					  </a>
					  <div class="dropdown-menu">
					   <a class="dropdown-item" href="{{URL('/add-services')}}/{{base64_encode($all_site->parent['id'])}}">Add Services</a>
					  </div>
					</div>  -->
					
				</div>
			</div>
		</div>
	</div>
@endforeach
<div class="col-md-12 pagination-box clearfix mt-4"> {{ $all_sites->links() }}</div>
@else
<p style="color:red;" class="not-found">No Site Found </p>
@endif

		 
		   