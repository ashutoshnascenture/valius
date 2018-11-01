@extends('layouts.app',['title'=> $title])
@section('content')
<section class="search-section">
	<div class="container">
		<div class="search-box">
			<i class="fa fa-search" aria-hidden="true"></i>
		    <input type="text" name="search" placeholder="search your site"  class="form-control search-site" /> 
		</div>
	</div>
</section>

<div class="container">	
	<div class="pagination-response">
		<div class="total-search">
	    	All Sites<span>({{$totalSite}})</span>
		</div>

	@if(count($all_sites) >0)
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
					<h4>$1864.12/mo <span>4 Serveices</span></h4>
				</div>
				<div class="col-md-1 action-box">
					<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
				</div>
			</div>
		</div>
	</div>
@endforeach
	<div class="col-md-12 pagination-box clearfix mt-4"> {{ $all_sites->links() }}</div>
@endif
</div>
	</div>



<script type="text/javascript">
	var siteURl = '<?php  echo url('/'); ?>';
</script>
<script src="{{ asset('js/site.js') }}" defer></script>
@endsection
