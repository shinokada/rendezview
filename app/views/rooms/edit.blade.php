@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('Edit Rooms') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<div class="col-md-12">

		<h1>Edit {{ $room->room_name }}</h1>

		<!-- if there are creation errors, they will show here -->
		{{ HTML::ul($errors->all()) }}

		{{ Form::model($room, array('route' => array('rooms.update', $room->id), 'method' => 'PUT')) }}

		@if (Auth::check())
		@if (Auth::user()->hasRole('admin'))
		
		<div class="form-group">
			{{ Form::label('room_admin', 'Room Admin') }}
			{{ Form::text('room_admin', null, array('class' => 'form-control')) }}
		</div>

		@endif
		@endif

		<div class="form-group">
			{{ Form::label('room_name', 'Room Name') }}
			{{ Form::text('room_name', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('room_location', 'Location') }}
			{{ Form::text('room_location', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('room_capacity', 'Capacity') }}
			{{ Form::text('room_capacity', null, array('class' => 'form-control')) }}
		</div>

		{{ Form::submit('Submit Changes', array('class' => 'btn btn-primary')) }}
		
		<!-- Button trigger modal -->
		<button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
			Delete Room
		</button>

		{{ Form::close() }}

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Are you sure you want to delete {{ $room->room_name }}?</h4>
					</div>
					<div class="modal-body">
						{{ Form::open(array('url' => 'rooms/' . $room->id)) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>
@stop
