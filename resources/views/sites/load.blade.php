All Sites({{$totalSite}})
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

		 
		   