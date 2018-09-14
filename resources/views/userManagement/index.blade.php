@extends('layouts.app')
@section('content')
<section class="main-box col-md-9">

	<div class="card">
	    
		<div class="card-header"><span class="float-left">User Listing</span>
		<a href="{{url('users/create')}}" class="btn btn-success float-right">Add users</a>
	
		</div>
          <div class="card-body">
			 @if(Session::has('flash_message'))
			<div class="alert {{ Session::get('alert-class') }}">
				<a href="#" class="close" data-dismiss="alert">&times;</a> 
				{{Session::get('flash_message')}}
			</div>
			@endif

			<div class="row">
				<div class="col-md-12">
				
					<table class="table table-bordered table-striped datatable">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>

				</div>
			</div>
			
		</div>
		
	</div>

</section>
<style type="text/css">#DataTables_Table_0_filter{display: none !important;}</style>
<script type="text/javascript">
var rowID = 0;
$(document).ready(function () {	
	get_plans();
	function get_plans(){
		var table = $('.datatable').DataTable({
			order: [ [0, 'desc'] ],
	        processing: false,
	        destroy: true,
	       // bPaginate: false,
			bLengthChange: false,
			bFilter: false,
			bInfo: false,
			searchable: false,
	    	//serverSide: true,
	    	ajax: "{{URL('users/getUsers') }}",
	        columns: [
	        	{data: 'id', name: 'id'},
				{data: 'name', name: 'name'},
				{data: 'email', name: 'email'},
				{data: 'phone', name: 'phone'},
				{data: 'actions', name: 'actions', orderable: false, searchable: false },
	        ],
	        initComplete: function( settings, json ) {
			    $('#DataTables_Table_0_length').appendTo('#pageResult');
			}
	    });			
	}


    $('#btn-search').click(function(){       
    	$('.datatable').DataTable().search($('#search').val()).draw(true);	
    });	
	
    $('.datatable').on('click', '.delete', function (e) { 
 		rowID = $(this).attr('data-id');
		
		$('#confirm-delete').modal('show');
	});
        
		$('#danger').click(function () { 
			$('#danger').attr('disabled','disabled');
			 
			$.ajax({
	            url: "{{URL('users')}}/"+rowID,
	            type: 'POST',
	            dataType: 'json',
	            data: {_method: 'DELETE', _token : '{{ csrf_token() }}', id : rowID},
				success : function(res){
	            $('#confirm-delete').modal('hide');
					$('#danger').removeAttr('disabled','disabled');
	            	if(res.status){
	            		alert(res.message);
	            	}
	            }
	        }).always(function (data) {
	           //j('.datatable').DataTable().draw(false);
			   location.reload();
	        });
			
		});
});
</script>
<div class="modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Delete Data</h4>
			</div>
			<div class="modal-body"> Are you sure want to delete <span class='delete-item'></span>? </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a href="#" class="btn btn-danger" id="danger">Delete</a> 
			</div>
		</div>
	</div>
</div>


	<style>
.dataTables_length {
    position: absolute;
    top: -49px;
    right: 34px;
    font-weight: 700;
}</style>

@endsection
