@extends('layouts.app',['title'=> $title])
@section('content')	
<section class="site-section mt-5">
	<div class="container">
	  <div class="total-search">
	    	<span>All Services</span>
	  </div>

	    @if($errors->any())
		<h4 style="color:red;">{{$errors->first()}}</h4>
		@endif
       
	   @if (!$service_data->isEmpty())
	   <form method="post" action="{{ URL('/save-services')}}" id="addservice">
	   @csrf
	   <input type="hidden"  value="{{$id}}" name="subscription_id">
		<div class="row">
		  @foreach($service_data as $data)
			<div class="col-md-6">
				<div class="box-container">
					<div class="box-header mb-2">
						<div class="head-caption">
							<h2>{{ $data->nickname}}</h2>
						</div>
					</div>
					<div class="box-body">
						<div class="col-md-6">
							{{ $data->description}}
						</div>
						<div class="col-md-6">
						Price:-	${{ $data->amount/100}}
						</div>
						<div class="col-md-6">
						<label>Check if add service
						<input type="checkbox" class="services" name="services[]" value="{{$data->plan_id}}"></label>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<button style="margin-top: 20px;" type="submit" class="btn btn-update float-right"> Add Service </button> 
		</form>
		<a href="{{ url('sites') }}" class="btn btn-link btn-cancel"> Cancel </a>
		@else 
         <p>All Services added. </p>
         <a href="{{ url('sites') }}" class="btn btn-link btn-cancel"> Back </a>
		@endif
	</div>
</section>
<script type="text/javascript">
	jQuery(function ($) {
    $('#addservice').submit(function (e) {
        if (!$('.services').is(':checked')) {
            e.preventDefault();
            alert("please check at least one service");
        }
    })
})

</script>
@endsection