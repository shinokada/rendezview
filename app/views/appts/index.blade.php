@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('Appointments') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<div class="col-md-12">
		<h1>
			<script>
			var time = moment().calendar();
			document.write(time);
			</script>
		</h1>
		<p><a href="{{ URL::to('appts/create') }}">Create Appointment</a></p>

		<!-- will be used to show any messages -->
		@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
		@endif

		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<!-- <td>ID</td> -->
					<td>Title</td>
					<td>Start</td>
					<td>End</td>
					<td>Created By</td>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
				@foreach($appts as $key => $value)
				<tr>
					<!-- <td>{{ $value->id }}</td> -->
					<td>{{ $value->title }}</td>
					<td>
						<script>
						var time = moment("{{$value->start}}").format("ddd [] LT");
						document.write(time);
						</script>
					</td>
					<td>
						<script>
						var time = moment("{{$value->end}}").format("ddd [] LT");
						document.write(time);
						</script>
					</td>
					<td>{{ $value->created_by }}</td>
					<td>
						{{ Form::open(array('url' => 'appts/' . $value->id, 'class' => 'pull-right')) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
						{{ Form::close() }}
						<a class="btn btn-small btn-success" href="{{ URL::to('appts/' . $value->id) }}">Show</a>
						<a class="btn btn-small btn-info" href="{{ URL::to('appts/' . $value->id . '/edit') }}">Edit</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop
