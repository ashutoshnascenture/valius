@extends('layouts.app')
@section('content')
		<div class="col-md-9">
		   <div class="card">
			<div class="card-header">Site Detail
			  <div class="pull-right" >
			  <a href="{{url('sites/create')}}" class="btn btn-success">Add Site</a>
			  </div>
			  </div>

                <div class="col-lg-12">
	            @if(Session::has('flash_message'))
		        <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                 {{ Session::get('flash_message') }} 
                </div>
		       @endif 
			      <div class="table-responsive">
	              <table class="table table-bordered">
	              	<thead>
	              		<tr>
	              			<th>
	              				Name
	              			</th>
	              			<th>
	              				Value
	              			</th>
	              		</tr>
	              	</thead>
	              	<tbody>
	                  <tr>
	                  	<td>
	                  		sdfdsfdsf
	                  	</td>
	                  	<td>
	                  		sdfsdfs
	                  	</td>
	                  </tr>             		
	 
	              	</tbody>
	              </table>
	            </div>
			 <div align="center" style="margin-left: 293px;" ></div>	
         </div>
       </div>	
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                <h4 class="modal-title" id="myModalLabel">Delete Plan</h4>
            </div>
            <div class="modal-body"> Are you sure want to  <span class='delete-item'></span>? </div>
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
			var active = $(e.relatedTarget).data('active');
			if (active==0) {
              $("#danger").text('Active');
              $("#myModalLabel").text("Active Plan");
              data = "Active"+data;
			} else {
			   data = "Deactive"+data;
			   $("#myModalLabel").text("Deactive Plan");
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
