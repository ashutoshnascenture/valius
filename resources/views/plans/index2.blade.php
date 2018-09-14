@extends('layouts.app')

@section('content')

<div class="col-md-9">
	<div class="card">
		<div class="card-header">Plans</div>

		<div class="card-body">
			 @if(Session::has('flash_message'))
			<div class="alert {{ Session::get('alert-class') }}">
				<a href="#" class="close" data-dismiss="alert">&times;</a> 
				{{Session::get('flash_message')}}
			</div>
			@endif

			<div class="row">
				<div class="col-xs-12">
				
					<table class="table table-bordered table-striped datatable">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Description</th>
								<th>Price</th>
								<th>Action</th>
							</tr>
						</thead>
						
    <!--<tr>
    <td><input type="checkbox" class="checkthis" /></td>
    <td>Mohsin</td>
    <td>Irshad</td>
    <td>CB 106/107 Street # 11 Wah Cantt Islamabad Pakistan</td>
    <td>isometric.mohsin@gmail.com</td>
    <td>+923335586757</td>
    <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="fa fa-pencil-square-o"></span></button></p></td>
    <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="fa fa-trash"></span></button></p></td>
    </tr>-->
					</table>

				</div>
			</div>
			
		</div>
		
	</div>
</div>
<style type="text/css">#DataTables_Table_0_filter{display: none;}</style>
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
			bFilter: true,
			bInfo: false,
			searchable: true,
	    	//serverSide: true,
	    	ajax: "{{URL('plans/getPlans') }}",
	        columns: [
	        	{data: 'id', name: 'id'},
	            {data: 'name', name: 'name'},
	            {data: 'description', name: 'description'},
	            {data: 'price', name: 'price'},
	            {data: 'actions', name: 'actions', orderable: false, searchable: false },
	        ],
	        initComplete: function( settings, json ) {
			    //$('#DataTables_Table_0_length').appendTo('#pageResult');
			}
	    });			
	}


    $('#btn-search').click(function(){       
    	$('.datatable').DataTable().search($('#search').val()).draw(true);	
    });	

 	$('.datatable').on('click', '.delete', function (e) { 
 		rowID = $(this).attr('data-id');
		$('#confirm-delete').modal('toggle');
	});

	$('#danger').click(function () { 
		$.ajax({
			url: "{{URL('admin/users')}}/"+rowID,
			type: 'POST',
			dataType: 'json',
			data: {_method: 'DELETE', _token : '{{ csrf_token() }}', id : rowID},
			success : function(res){
				$('#confirm-delete').modal('toggle'); 
				if(res.status){
					$('#confirm-delete').hide();
					//alert(res.message);
				}
			}
		}).always(function (data) {
		    get_users();
			//$('.datatable').DataTable().draw();
		});
		
	});	
});
</script>
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Delete User</h4>
				</div>
				<div class="modal-body"> Are you sure want to delete <span class='delete-item'></span>? </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<a href="JavaScript:void(0);" class="btn btn-danger" id="danger">Delete</a> 
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
