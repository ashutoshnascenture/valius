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
	       @if(Session::has('flash_message'))
		        <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                 {{ Session::get('flash_message') }} 
                </div>
		       @endif 
		<div class="total-search">
	    	All Sites<span>({{$totalSite}})</span>
		</div>

	@if(count($all_sites) >0)
	@foreach( $all_sites as $all_site)

 	<div class="container-box">
		<div class="site-list">
			<div class="row"> 
				<div class="img-box col-md-1">
				   @if (isset($all_site->site_image) && file_exists(public_path('/upload/sites').'/'.$all_site->site_image)) 
					<img src="{{url('/').'/public/upload/sites/'.$all_site->site_image}}" alt="" title="" />
				   @else 
                   <img src="{{ asset('images/default.jpg') }}" alt="" title="" />
				   @endif
				</div>
				<div class="col-md-8 name-box">
					<h3><a href="{{URL('/site-detail')}}/{{base64_encode($all_site->id)}} ">{{$all_site->name}} </a></h3>
					<a href="{{URL('/site-detail')}}/{{base64_encode($all_site->id)}}">
					{{$all_site->url}} </a>
				</div>
				<div class="col-md-2 price-box">
				    @php $totalAmount=$all_site->parent['plan_amount']; @endphp
				    @if(!empty($all_site->parent['children']))
				    @php $total_services = 1; @endphp
				    @php $total_services = $total_services+count($all_site->parent['children']); @endphp
				    @foreach($all_site->parent['children'] as $serviceAmount)
                    @php $totalAmount = $totalAmount+$serviceAmount->plan_amount; @endphp
				    @endforeach
                    @else 
                     @php $total_services = 1; @endphp
                     @endif

					<h4>${{ $totalAmount/100}}/mo <span>{{$total_services}} Serveices</span></h4>
					
				</div>
				<div class="col-md-1 action-box">

				 <a href="#" class="addservice btn-block" siteid="{{base64_encode($all_site->parent['id'])}}"  id="addservice" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a>
					
				</div>
			</div>
		</div>
	</div>
@endforeach
	<div class="col-md-12 pagination-box clearfix mt-4"> {{ $all_sites->links() }}</div>
@endif
</div>
	</div>

		<div id="myModal" class="modal fade services-modal" role="dialog">
			<div class="modal-dialog">
			<div class="modal-content ">
				<form method="post" action="{{ URL('/save-services')}}" id="addserviceform">
				@csrf
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="suscrip"></div>
					<div class="modal-body">  

						<h4>Add a Services to your client's subscription for VaroLocal?</h4>
						<div class="row service-div">
							<div class="col-md-6 ser-list active">
								<h5>Yes,add services  to client's subscription</h5>
							</div>
							<div class="col-md-6 ser-list">
								<h5>No, Create  immediate  one time charge.</h5>
							</div>
						</div>
						<hr />
						<p class="date-p">Once you create a service,we will let the client know that the charges will take effect on their <b>November 16,2018</b> invoice.</p> 
						<div class="select-service-box col-md-12">	
							<select class="service service-popup form-control" name="services[]">
								<option value="">Select service from template</option>
							</select> 
							<p class="or"> OR </p>
							<button type="button" class="btn btn-add-ser" data-toggle="modal" data-target="#myModal2"> <i class="fa fa-plus" aria-hidden="true"></i> Add New Service</button>	
						</div>
					</div>
					<div class="modal-footer text-center">
						<button type="submit" class="btn btn-cre-ser check-data"> create New Serveice </button> 
						<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
					</div>
				</form>
			</div>
			</div>
		</div>

 <div id="myModal" class="modal fade" role="dialog">
				  <div class="modal-dialog">
				    <div class="modal-content ">
				    <form method="post" action="{{ URL('/save-services')}}" id="addserviceform">
                        @csrf
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Add a Services to your client's subscription for VaroLocal? </h4>
				      </div>
				      <div class="suscrip">
				      
                      </div>
				      <div class="modal-body">
				        <p>Yes,add services  to client's subscription</p>
				         <p>No, Create  immediate  one time charge.</p>
				         <p>Once you create a service,we will let the client know that the charges will take effect on their November 16,2018 invoice.</p> 	
				             <select class="service service-popup" name="services[]">
							  <option value="">Select service from template</option>

							 </select> 
							<p> OR </p>
							<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal2">Add Service</button>	
				       </div>
				      <div class="modal-footer">
				       <button type="submit" class="btn btn-primary check-data">
						create Serveice
						</button> 
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				      </div>
				      </form>
				   </div>
				  </div>
				</div>

				<div class="modal fade rotate" id="myModal2">
					
	<form method="POST" action="{{ url('addons') }}" id="add-service">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Add Services</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

            </div>
            <div class="container"></div>
            <div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
            <div class="modal-body">
                
					{{ csrf_field() }}
					<div class="row">

					<div class="form-group col-md-12">

						<label for="name">Name <span style="color:red;">*</span></label>
						<input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" >
					</div>
                   <input id="subscription_id" type="hidden" class="form-control subscription_id " name="subscription_id"  value="">

				   <div class="form-group col-md-12">

						<label for="email">Description<span style="color:red;">*</span></label>
						<textarea id="email" type="text" class="form-control" name="description" placeholder="Description">{{ old('description') }}</textarea>
					</div>


					<div class="form-group col-md-12">

						<label for="phone">Price<span style="color:red;">*</span></label>
						<input id="price" type="number"  value="{{ old('price') }}" class="form-control" name="price" placeholder="Price">
						<input type="hidden"   name="status"  value="1">
					</div>
					

					<div class="form-group col-md-12">

						<!-- <a href="{{ url('addons')}}" class="btn btn-danger"> Cancel </a> -->
						<!-- <button type="submit" class="btn btn-primary">
						Submit
						</button>  -->
					</div>
				</div>
				

            </div>

            <div class="modal-footer">	
            	<a href="#" data-dismiss="modal" class="btn btn-outline-secondary"">Close</a>
				<button type="submit" class="btn btn-primary add-service">Submit </button> 

           
            </div>
        </div>
    </div>
    </form>
</div>


<script type="text/javascript">
	var siteURl = '<?php  echo url('/'); ?>';
</script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
 <script src="http://malsup.github.com/jquery.form.js"></script> 
<script src="{{ asset('js/site.js') }}" defer></script>
@endsection
