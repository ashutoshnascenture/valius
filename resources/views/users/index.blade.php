@extends('layouts.app')
@section('content')
<div class="container">
	<div class="box-container clearfix">
		<div class="box-header clearfix mb-3">
			<div class="head-caption float-left">
				<h2>User Management</h2>
			</div>
			<div class="float-right">
				<a href="{{url('users/create')}}" class="btn btn-primary btn-sm"> <i class="fa fa-plus" aria-hidden="true"></i> Add User</a>
			</div>
		</div>
		<div class="box-body">
			<div class="col-md-12">
	            @if(Session::has('flash_message'))
		        <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                 {{ Session::get('flash_message') }} 
                </div>
		       @endif 
               <table id="example" class="display table table-bordered" >
                <thead>
                    <tr>
						<th>Id</th>
                   	 	<th>Name</th>
                   	    <th>Email</th>
						<th>Phone</th>
						<th>Action</th>
				     </tr>
			    </thead>
           <tbody>
    		<?php 
				$i = (Request::input('page')) ?  (Request::input('page') -1) * $users->perPage() + 1 : 1; 
				?>
				@if(count($users))
					@foreach($users as $key => $value)
						<tr>
						<td>{{ $i }}</td>
						<td>{{$value->name}}</td>
					    <td>{{$value->email}}</td>
					    <td>{{$value->phone }}</td>
						<td>
						     <form method="POST" action="{{URL::to('users')}}/{{$value->id}}" id="delete_{{ $value->id}}" accept-charset="UTF-8">
								
		                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="_method" value="DELETE">
								<a  class="btn btn-primary btn-sm" href="{{URL('users')}}/{{$value->id}}/edit" role="button" title="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>

								<a class="btn my-btn btn-delete btn-danger btn-sm" data-href="{{$value->id}}" data-toggle="modal" data-target="#confirm-delete" href="#" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</form>
			      		</td>
						</tr>
						<?php $i++; ?>
					@endforeach
					
				@else
					<tr>
						<td colspan="4">No User yet</td>
					</tr>
				@endif
				</tbody>	
			 </table> 
			 <div class="col-md-12 text-center pagination-box">{{$users->links()}}</div>	
			</div>
		</div>
	</div>
</div>


	
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                <h4 class="modal-title" id="myModalLabel">Delete User</h4>
            </div>
            <div class="modal-body"> Are you sure want to delete <span class='delete-item'></span>? </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger" id="danger">Delete</a> 
            </div>
        </div>
    </div>
</div>

<script>

	$(document).ready(function() {
	$('#confirm-delete').on('show.bs.modal', function (e) { 
            var form = $(e.relatedTarget).data('href');
			var data = $(e.relatedTarget).data('delete');
			$('.delete-item').text(data);
            $('#danger').click(function () { 
			 //alert(data);
			    $('#delete_' + form).submit();
            });
        });
	});
</script>		 

@endsection
