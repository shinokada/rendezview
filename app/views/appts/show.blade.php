@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('Show Appts') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<div class="col-md-12">
		<h1>Showing {{ $appt->title }}
			@if (Auth::check())
			@if (Auth::user()->hasRole('admin'))
			<small>
				<a href="{{ URL::to('appts/' . $appt->id . '/edit') }}">Edit</a>
			</small>
			@endif
			@endif
		</h1>
		<div class="jumbotron text-center">
			<h2>{{ $appt->title }}</h2>
			<p>
				<strong>Created By:</strong> {{ $appt->created_by }}<br>
				<strong>Title:</strong> {{ $appt->title }}<br>
				<strong>start:</strong> {{ $appt->start }}<br>
				<strong>end:</strong> {{ $appt->end }}<br>
				<strong>status:</strong> {{ $appt->status }}
			</p>
		</div>
	</div>
</div>
@stop
