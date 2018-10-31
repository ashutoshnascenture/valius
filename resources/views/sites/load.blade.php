@if(count($all_sites) >0)
All Sites({{$totalSite}})

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
					<h3>{{$all_site->name}}</h3>
					<a href="{{$all_site->url}}">{{$all_site->url}}</a>
				</div>
				<div class="col-md-2 price-box">
					<h4>$1864.12/mo <span>4 Serveices</span></h4>
				</div>
				<div class="col-md-1 action-box">
					<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
				</div>
			</div>
		</div>
	</div>
@endforeach
{{ $all_sites->links() }}
@else
<p style="color:red;">No Site Found </p>
@endif

		 
		   