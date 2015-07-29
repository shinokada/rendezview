@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('Rooms') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')


<div class="col-md-12">
	<div class="page-header">
		<h1>Rooms</h1>
	</div>
	<!-- will be used to show any messages -->
	@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif

	<div class="row">
		<div class="col-md-6">
			@if (Auth::check())
			@if (Auth::user()->hasRole('admin'))
			<a href="{{{ URL::to('rooms/create') }}}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create New Room</a>
			@endif
			@endif
		</div>
		<div class="col-md-3 col-md-offset-3">
			<div class="col-lg-12 input-group">
				<div class="input-group custom-search-form">
					<input type="text" aria-controls="users" class="form-control inline-control" id="filter" placeholder="Search...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">
							<i class="fa fa-search"></i>
						</button>
					</span>
				</div>
			</div>
		</div>
	</div>
	<table class="footable table table-hover" data-page-size="10" data-filter="#filter">
		<thead>
			<tr>
				<!-- <th>ID</th> -->
				<th>Room Name</th>
				<th data-hide="phone,tablet">Location</th>
				<th data-hide="phone" data-type="numeric" data-sort-initial="true">Capacity</th>
				<th data-hide="all">Actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($rooms as $key => $value)
			<tr>
				<!-- <td>{{ $value->id }}</td> -->
				<td>{{ $value->room_name }}</td>
				<td>{{ $value->room_location }}</td>
				<td>{{ $value->room_capacity }}</td>
				<td>
					<ul class="pager">
						<li>
							<a href="{{ URL::to('rooms/' . $value->id) }}">Show</a>
						</li>
						@if (Auth::check())
						@if (Auth::user()->hasRole('admin'))
						<li>
							<a href="{{ URL::to('rooms/' . $value->id . '/edit') }}">Edit</a>
						</li>
						@endif
						@endif
					</ul>

				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td colspan="5">
					<div class="pagination pull-right"></div>
				</td>
			</tr>
		</tfoot>
	</table>
</div>

@stop

{{-- Scripts --}}
@section('scripts')
<script type="text/javascript">
$(function () {
	$('.footable').footable();
	// $( "ul:last" ).addClass( "pagination" );
});
</script>
@stop
