@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('Create Rooms') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

@if (Auth::check())
@if (Auth::user()->hasRole('admin'))

<div class="row">
	<div class="col-md-12">

		<h1>Create a Room</h1>

		<!-- if there are creation errors, they will show here -->
		{{ HTML::ul($errors->all() )}}

		{{ Form::open(array('url' => 'rooms')) }}

		<div class="form-group">
			{{ Form::label('room_admin', 'Room Admin') }}
			{{ Form::text('room_admin', Input::old('room_admin'), array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('room_name', 'Room Name') }}
			{{ Form::text('room_name', Input::old('room_name'), array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('room_location', 'Location') }}
			{{ Form::text('room_location', Input::old('room_location'), array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('room_capacity', 'Capacity') }}
			{{ Form::text('room_capacity', Input::old('room_capacity'), array('class' => 'form-control')) }}
		</div>

		{{ Form::submit('Create the Room!', array('class' => 'btn btn-primary')) }}

		{{ Form::close() }}
	</div>
</div>

@endif
@endif
@stop
