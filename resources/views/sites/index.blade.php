@extends('layouts.app',['title'=> $title])
@section('content')
 <div class="container">
    <div class="row">
	   <div class="col-md-12">
           <div class="col-lg-12">
	            @if(Session::has('flash_message'))
		        <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                 {{ Session::get('flash_message') }} 
                </div>
		       @endif 
			     
			 <div align="center" style="margin-left: 293px;" ></div>	
         </div>
		   <div class="card">
		     <div class="col-md-6 pull-left searach-box">
			   <div class="form-group ">
				<div class="input-group col-md-8">
			        <input type="text" name="search" placeholder="search your site"  class="form-control search-site"  > 
			 </div>
			 </div>
				
		        <div class="pull-right" >
			     <a href="{{url('sites/create')}}" class="btn btn-success">Add Site</a>
			  </div>
			<div class="card-header pagination-response" >All Sites({{$totalSite}})
			 
			   <ul class="list-group" id="load">
			   @if(count($all_sites) >0)
			   @foreach( $all_sites as $all_site)
			  <li class="card"><div><a href="{{$all_site->url}}"><img src="{{url('/').'/public/upload/sites/'.$all_site->site_image}}"></img></a><a href="{{$all_site->url}}"><h2>{{$all_site->name}}</h2></a><a href="{{$all_site->url}}"><h2>{{$all_site->url}}</h2></a></div></li>
			  @endforeach
			  @else
			  <li class="card">No Site Added</li>
			  @endif
			</ul>
			 {{ $all_sites->links() }}
		   
		 
		   </div>
       </div>	
   </div>
</div>
<script type="text/javascript">
	
	var siteURl = '<?php  echo url('/'); ?>';

</script>
<script src="{{ asset('js/site.js') }}" defer></script>
@endsection
