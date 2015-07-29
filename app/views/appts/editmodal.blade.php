<!-- @extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('Edit Appts') }}} ::
@parent
@stop -->

{{-- Content --}}
@section('content')

<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<h2>Edit {{ $appt->title }} <small>1 Hour Maximum.</small></h2>
		<hr>
		<!-- if there are creation errors, they will show here -->
		{{ HTML::ul($errors->all()) }}

		{{ Form::model($appt, array('route' => array('appts.update', $appt->id), 'method' => 'PUT')) }}

		@if (Auth::check())
		@if (Auth::user()->hasRole('admin'))

		@endif
		@endif

		<div class="form-group">
			{{ Form::label('title', 'Appointment Title') }}
			{{ Form::text('title', null, array('class' => 'form-control input-lg')) }}
		</div>

		<div class="form-group">
			{{ Form::label('status', 'Status') }}
			{{ Form::text('status', null, array('class' => 'form-control input-lg')) }}
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group">
					{{ Form::label('start', 'Start') }}
					{{ Form::text('start', null, array('class' => 'form-control input-lg')) }}
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group">
					{{ Form::label('end', 'End') }}
					{{ Form::text('end', null, array('class' => 'form-control input-lg')) }}
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 col-md-6">
				{{ Form::submit('Submit Changes', array('class' => 'btn btn-primary btn-block btn-lg')) }}
			</div>
			<div class="col-xs-12 col-md-6">
				<a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-danger btn-block btn-lg">Delete Appt</a>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>

<!-- Button trigger modal -->
<!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
	Delete Appt
</button> -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Are you sure you want to delete {{ $appt->title }}?</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(array('url' => 'appts/' . $appt->id)) }}
				{{ Form::hidden('_method', 'DELETE') }}
				{{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
{{ Form::close() }}
@stop
