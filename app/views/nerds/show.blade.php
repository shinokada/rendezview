@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('Show Nerds') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<div class="col-md-12">
		<h1>Showing {{ $nerd->name }}</h1>
		<div class="jumbotron text-center">
			<h2>{{ $nerd->name }}</h2>
			<p>
				<strong>Email:</strong> {{ $nerd->email }}<br>
				<strong>Level:</strong> {{ $nerd->nerd_level }}
			</p>
		</div>
	</div>
</div>
@stop
