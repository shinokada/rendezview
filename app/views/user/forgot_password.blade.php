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
			<h3>Forgot Password</h3>
		</div>

		<!-- Notifications -->
		@include('notifications')
		<!-- ./ notifications -->

		<form method="POST" action="{{ (Confide::checkAction('UserController@do_forgot_password')) ?: URL::to('/user/forgot') }}" accept-charset="UTF-8">
			<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
			<div class="form-group">
				<label for="email">{{{ Lang::get('confide::confide.e_mail') }}}</label>
				<input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6">
						<section class="progress-demo">
							<button class="ladda-button" data-color="blue" data-style="expand-right">{{{ Lang::get('confide::confide.forgot.submit') }}}</button>
						</section>
					</div>
				</div>
			</div>
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
