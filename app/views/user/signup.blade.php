@extends('layouts.master-create')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('user/user.login') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="page-header">
			<div class="rv-logo">
				<img src="{{{ asset('img/rendzeview_logo.png') }}}" alt="RendezView">
			</div>
			<h3>Sign Up</h3>
		</div>

		<!-- Notifications -->
		@include('notifications')
		<!-- ./ notifications -->

		<form method="POST" action="{{{ (Confide::checkAction('UserController@store')) ?: URL::to('user')  }}}" accept-charset="UTF-8">
			<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
			<fieldset>
				<div class="form-group">
					<label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
					<input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
				</div>
				<div class="form-group">
					<label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
					<input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
				</div>
				<div class="form-group">
					<label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
					<input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
				</div>
				<div class="form-group">
					<label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
					<input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
				</div>
				<div class="form-actions form-group">
					<section class="progress-demo">
						<button class="ladda-button" data-color="blue" data-style="expand-right">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
					</section>

					<!-- <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button> -->
				</div>
			</fieldset>
		</form>
	</div>
</div>
<script>

// Bind normal buttons
Ladda.bind( '.button-demo button', { timeout: 2000 } );

// Bind progress buttons and simulate loading progress
Ladda.bind( '.progress-demo button', {
	callback: function( instance ) {
		var progress = 0;
		var interval = setInterval( function() {
			progress = Math.min( progress + Math.random() * 0.1, 1 );
			instance.setProgress( progress );

			if( progress === 1 ) {
				instance.stop();
				clearInterval( interval );
			}
		}, 200 );
	}
} );

</script>
@stop
