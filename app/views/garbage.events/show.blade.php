@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get($event->title) }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<!-- <link href='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.css' rel='stylesheet' />
<link href='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.js'></script> -->
<div class="col-md-12">
	<div class="page-header">
		<h1>{{ $event->title }}</h1>
	</div>
	@if (Auth::check())
	@if (Auth::user()->hasRole('admin'))
	<div class="alert-message alert-message-info">
		<h4>Room Administrator</h4>
		<p>{{ $room->room_admin }}</p>
	</div>
	@endif
	@endif
	<!-- <div class="alert-message alert-message-success">
		<h4>Status</h4>
		<p>{{ $room->status }}</p>
	</div> -->
	<div class="alert-message alert-message-default">
		<h4>Info</h4>
		<p><strong>Location:</strong> {{ $room->room_location }}</p>
		<p><strong>Capacity:</strong> {{ $room->room_capacity }}</p>
	</div>
	<!-- <div class="jumbotron text-center">
</div> -->
<div id='calendar'></div>
</div>
@stop
