@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('Events') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')


<div class="col-md-12">
	<div class="page-header">
		<h1>Events</h1>
	</div>
	<!-- will be used to show any messages -->
	@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif
</div>

@stop
