@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('Create Appointment') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<div class="col-md-12">

		<h1>Create an Appointment</h1>

		<!-- if there are creation errors, they will show here -->
		{{ HTML::ul($errors->all() )}}

		<h2>Test Zone 1</h2>
		<div id="registration-form">
			<form>
			<label for="test1">Post Ajax Test:
				<input name="username" type="text" id="test1" maxlength="15">
				<span id="user-result"></span>
			</label>
			</form>
		</div>
		<h2>Test Zone 2</h2>
		<div id="registration-form">
			<form>
			<label for="test2">Post Ajax Test:
				<input name="username" type="text" id="test2" maxlength="15">
				<span id="user-result"></span>
			</label>
			</form>
		</div>
		<hr>

		{{ Form::open(array('url' => 'appts')) }}
		<div class="form-group">
			{{ Form::label('title', 'Title') }}
			{{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('start', 'Start') }}
			{{ Form::text('start', Input::old('start'), array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('end', 'End') }}
			{{ Form::text('end', Input::old('end'), array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('status', 'Status') }}
			{{ Form::text('status', Input::old('status'), array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('description', 'Description') }}
			{{ Form::text('description', Input::old('description'), array('class' => 'form-control')) }}
		</div>

		{{ Form::submit('Submit!', array('class' => 'btn btn-primary')) }}

		{{ Form::close() }}
	</div>
</div>

<script type="text/javascript">

// test 1
$("#test1").keyup(function (e) { //user types username on inputfiled
   var username = $(this).val(); //get the string typed by user
   $.post('<?php echo URL::to('appointment/finder') ?>', {'username':username}, function(data) { //ajax
   $("#user-result").html(data); //dump the data received from PHP page
   });
});

// test 2
$('#test2').ajax({
	url: "<?php echo URL::to('appointment/finder') ?>",
	type: "GET",
	data: { username: username },
	success: function(data){
		console.log(data);
	}
});
</script>

@stop
