@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('Nerds') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<div class="col-md-12">
		<h1>Display</h1>
		<p><a href="{{ URL::to('nerds/create') }}">Create Link</a></p>

		<!-- will be used to show any messages -->
		@if (Session::has('message'))
		<div class="alert alert-info">{{ Session::get('message') }}</div>
		@endif

		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<td>ID</td>
					<td>Name</td>
					<td>Email</td>
					<td>Nerd Level</td>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
				@foreach($nerds as $key => $value)
				<tr>
					<td>{{ $value->id }}</td>
					<td>{{ $value->name }}</td>
					<td>{{ $value->email }}</td>
					<td>{{ $value->nerd_level }}</td>

					<!-- we will also add show, edit, and delete buttons -->
					<td>

						<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
						<!-- we will add this later since its a little more complicated than the first two buttons -->
						{{ Form::open(array('url' => 'nerds/' . $value->id, 'class' => 'pull-right')) }}
						{{ Form::hidden('_method', 'DELETE') }}
						{{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
						{{ Form::close() }}

						<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
						<a class="btn btn-small btn-success" href="{{ URL::to('nerds/' . $value->id) }}">Show</a>

						<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
						<a class="btn btn-small btn-info" href="{{ URL::to('nerds/' . $value->id . '/edit') }}">Edit</a>

					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop
