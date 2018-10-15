@extends('layouts.app') @section('content')

<div class="container">
    <div class="row">
	<div class="col-md-12">
    <div class="card">
         <div class="card-header">Addon Management
			  <div class="pull-right" >
				<a href="{{url('addons/create')}}" class="btn btn-success">Add Addon</a>
			   </div>
			  </div>
        <div class="card-body">
               <div class="col-lg-12">
	            @if(Session::has('flash_message'))
		        <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                 {{ Session::get('flash_message') }} 
                </div>
		       @endif 
              <table id="example" class="display table table-hover table-condensed" >
                <thead>
                    <tr>
						<th>Id</th>
                   	 	<th>Name</th>
                   	    <th>Description</th>
						<th>price($)</th>
						<th>Action</th>
				     </tr>
			    </thead>
           <tbody>
    
		<?php 
				$i = (Request::input('page')) ?  (Request::input('page') -1) * $addons->perPage() + 1 : 1; 
				?>
				@if(count($addons))
					@foreach($addons as $key => $value)
						<tr>
						<td>{{ $i }}</td>
						<td>{{$value->name}}</td>
					    <td>{{$value->description}}</td>
					    <td>{{$value->price }}</td>
						
						
						<td>
				     <form method="POST" action="{{URL::to('addons')}}/{{$value->id}}" id="delete_{{ $value->id}}" accept-charset="UTF-8">
						
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="_method" value="DELETE">
						
						<a  class="btn btn-primary" href="{{URL('addons')}}/{{$value->id}}/edit" role="button" title="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        @if ($value->is_delete == 1)
						<input type="hidden" name="is_delete" value="0">
						<a class="btn my-btn btn-warning"   data-delete="{{$value->name}}" data-active="{{$value->is_delete}}" data-href="{{$value->id}}" data-toggle="modal" data-target="#confirm-delete" href="#" title="Deactive"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>
						@else
						<input type="hidden" name="is_delete" value="1">
						<a class="btn my-btn btn-warning"   data-delete="{{$value->name}}" data-active="{{$value->is_delete}}" data-href="{{$value->id}}" data-toggle="modal" data-target="#confirm-delete" href="#" title="Active"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>
						@endif
						
					</form>
			      </td>
						</tr>
						<?php $i++; ?>
					@endforeach
					
				@else
					<tr>
						<td colspan="4">No Addon yet</td>
					</tr>
				@endif
				</tbody>	
			 </table> 
			 <div align="center" style="margin-left: 293px;" >{{$addons->links()}}</div>	
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                <h4 class="modal-title" id="myModalLabel">Delete Addon</h4>
            </div>
            <div class="modal-body"> Are you sure want to  <span class='delete-item'></span>? </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger" id="danger">Delete</a> 
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script>

	$(document).ready(function() {
	$('#confirm-delete').on('show.bs.modal', function (e) { 
            var form = $(e.relatedTarget).data('href');
			var data = $(e.relatedTarget).data('delete');
			var active = $(e.relatedTarget).data('active');
			if (active==0) {
              $("#danger").text('Active');
              $("#myModalLabel").text("Active Addon");
              data = "Active"+data;
			} else {
			   data = "Deactive"+data;
			   $("#myModalLabel").text("Deactive Addon");
               $("#danger").text('Deactive');
			}
			$('.delete-item').text(data);
            $('#danger').click(function () { 
			 //alert(data);
			    $('#delete_' + form).submit();
            });
        });
	});
</script>
@endsection