@extends('layouts.master-login')

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
			<h3>Log in</h3>
		</div>

		<!-- Notifications -->
		@include('notifications')
		<!-- ./ notifications -->

		<form method="POST" action="{{{ Auth::check('UserController@do_login') ?: URL::to('/user/login') }}}" accept-charset="UTF-8">
			<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
			<fieldset>
				<div class="form-group">
					<label for="email">{{{ Lang::get('confide::confide.username_e_mail') }}}</label>
					<input class="form-control" tabindex="1" placeholder="{{{ Lang::get('confide::confide.username_e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
				</div>
				<div class="form-group">
					<label for="password">
						{{{ Lang::get('confide::confide.password') }}}
						<small>
							<a href="{{{ (Confide::checkAction('UserController@forgot_password')) ?: 'forgot' }}}">{{{ Lang::get('confide::confide.login.forgot_password') }}}</a>
						</small>
					</label>
					<input class="form-control" tabindex="2" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
				</div>
				<div class="form-group">
					<label for="remember" class="checkbox">{{{ Lang::get('confide::confide.login.remember') }}}
						<input type="hidden" name="remember" value="0">
						<input tabindex="4" type="checkbox" name="remember" id="remember" value="1">
					</label>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<section class="progress-demo">
								<button class="ladda-button" data-color="blue" data-style="expand-right">{{{ Lang::get('confide::confide.login.submit') }}}</button>
							</section>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<a class="btn btn-primary" href="{{{ URL::to('user/create') }}}">Sign Up</a>
						</div>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<script>
Ladda.bind( '.button-demo button', { timeout: 2000 } );
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
