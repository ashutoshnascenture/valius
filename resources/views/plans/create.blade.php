@extends('layouts.app')
@section('content')

	<div class="container">
    <div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">Add Plans</div>

			<div class="card-body">
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a> 
					<strong>Whoops!</strong> There were some problems with your input.<br><br>
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			@if(session()->has('error'))
				<div class="alert alert-error">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					 {{ session()->get('error') }}
				</div>
			@endif

				<form method="POST" action="{{ url('plans') }}">
					{{ csrf_field() }}
					<div class="row">
					<div class="form-group col-md-8">
						<label for="name">Name <span style="color:red;">*</span></label>
						<input id="name" type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" >
					</div>

				   <div class="form-group col-md-8">
						<label for="email">Description<span style="color:red;">*</span></label>
						<textarea id="email" type="text" class="form-control" name="description" placeholder="Description">{{ old('description') }}</textarea>
					</div>

					<div class="form-group col-md-8">
						<label for="phone">Price<span style="color:red;">*</span></label>
						<input id="price" type="number"  value="{{ old('price') }}" class="form-control" name="price" placeholder="Price">
						<input type="hidden"   name="status"  value="1">
					</div>
					
					<div class="col-md-9">
						<a href="{{url('plans/get-plans')}}" class="btn btn-danger"> Cancel </a>
						<button type="submit" class="btn btn-primary">
						Submit
						</button> 
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
  </div>
  </div>
@endsection
