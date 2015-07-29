@extends('layouts.master')

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
			<h3>Ajax Tester</h3>
		</div>

		<!-- Notifications -->
		@include('notifications')
		<!-- ./ notifications -->

<div class="row">

	@if(Session::get('message') !== null)
 	<p class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ Session::get('message') }}
	</p>
	@endif

	<div class="col-md-offset-3 col-md-6">
		{{ Form::open(array('url' => 'user/login', 'role' => 'form', 'class' => 'ls-form')) }}

		<div class="form-group">
			{{ Form::label('email', 'Enter your email address') }}
			{{ Form::text('email', null, array('class' => 'form-control email-field',
						  'placeholder' => 'Email address', 'autocomplete' => 'off')) }}
		</div>

		<div class="form-group username-field-container ls-hidden">
			{{ Form::label('username', 'Username') }}
			{{ Form::text('username', null, array('class' => 'form-control username-field',
						  'autofocus' => true, 'placeholder' => 'Username')) }}
		</div>

		<div class="form-group password-group">
			<div class="ls-hidden password-field-container">
				{{ Form::label('password', 'Password') }}
				{{ Form::password('password', array('class' => 'form-control password-field', 'placeholder' => 'Password')) }}
			</div>

			<div class="ls-hidden password-cfrm-field-container">
				{{ Form::label('password_confirmation', 'Password Confirmation', array('class' => 'sr-only')) }}
				{{ Form::password('password_confirmation', array('class' => 'form-control password-confirm-field',
								  'placeholder' => 'Confirm password')) }}
			</div>
		</div>
		<p class="alert alert-danger hidden password-error"></p>

		<button type="submit" class="login-signup-btn ls-hidden btn btn-default pull-right">Login or Sign up</button>

		{{ Form::close() }}
	</div>
</div>

<script type="text/javascript">
function hide_pfs()
{
	if($(".login-signup-btn").is(":visible")) $(".login-signup-btn").fadeOut("fast");

	if($(".password-cfrm-field-container").is(":visible")) $(".password-cfrm-field-container").fadeOut("fast");

	if($(".password-field-container").is(":visible")) $(".password-field-container").fadeOut("fast");

	if($(".username-field-container").is(":visible")) $(".username-field-container").fadeOut("fast");
}

function validate_email(email) {
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if( ! emailReg.test( email ) )
	{
		return false;
	}
	else
	{
		return true;
	}
}

$(document).ready(function() {

	// This snippet prevents the ability to paste text into the password_confirmation field
	var input = document.getElementsByClassName("password-confirm-field");
	input[0].onpaste = function(e) { e.preventDefault() }

	/*
	The following is used to put a small gap between the
	password and the password confirmation fields
	*/
	$(".password-cfrm-field-container").css("margin-top", "5px");
	
});

var form_mode = null;

$(".email-field").keyup(function() {

	var email_value = $.trim($(this).val());

	$(".password_error").text("").fadeOut("fast");

	if(email_value.length < 1 || ( ! validate_email(email_value)))
	{
		hide_pfs();
		return;
	}

	$.ajax({
		url: "{{ URL::to('login/check_email') }}",
		type: "POST",
		data: { email: email_value }
	}).done(function(data) {

	/* begin response function */

		if(data.is_valid && data.is_found)
		{
			/*
			// Executed when a valid email address has been entered
			// and when the email IS found in the database.
			*/
			// console.log("Email is valid and IS found in the database.");

			form_mode = 'login';

			if($(".password-cfrm-field-container").is(":visible"))
			{
				$(".password-cfrm-field-container").fadeOut("fast", function() {

					$(".username-field-container").fadeOut("fast");
					$(".login-signup-btn").text("Login");

					if( ! $(".login-signup-btn").is(":visible"))
					{
						$(".login-signup-btn").fadeIn("fast");
					}
				});
			}
			else
			{
				$(".password-field-container").fadeIn("fast");
				$(".login-signup-btn").text("Login");
				if( ! $(".login-signup-btn").is(":visible"))
				{
					$(".login-signup-btn").fadeIn("fast");
				}
			}

		} // end VALID and FOUND code
		else if(data.is_valid && ( ! data.is_found))
		{
			/*
			// Executed when a valid email address has been entered
			// and the email IS NOT found in the database.
			*/
			// console.log("Email is valid and IS NOT found in the database.");

			if(form_mode === 'login')
			{
				if($(".password-field-container").is(":visible") && $(".login-signup-btn").is(":visible"))
				{
					$(".login-signup-btn").fadeOut("fast", function() {
						$(".password-field-container").fadeOut("fast", function() {
							$(".login-signup-btn").text("Sign up").fadeIn("fast");
						});
					});
				}
			}
			else
			{
				$(".login-signup-btn").text("Sign up").fadeIn("fast");
			}

			form_mode = 'signup';

		} // end VALID but NOT FOUND code
		else
		{
			/*
			// Executed when the email address entered IS NOT valid
			// and therefore IS NOT found in the database.
			*/
			form_mode = null;

			hide_pfs();

		} // end NOT VALID and NOT FOUND code

	/* end response function */

	});
});

$(".ls-form").submit(function() {

	if(typeof(form_mode) == 'undefined' || form_mode == null) return false;

	if(	form_mode === 'signup'
		&& ! $(".password-field-container").is(":visible")
		&& ! $(".password-cfrm-field-container").is(":visible")
	) {

		$(".password-field-container").fadeIn("fast");
		$(".password-cfrm-field-container").fadeIn("fast");
		$(".username-field-container").fadeIn("fast");
		$(".password-field-container input").focus();

		return false; // cancel form submission

	}
	else if( form_mode === 'signup'
			 && $(".password-field-container").is(":visible")
			 && $(".password-cfrm-field-container").is(":visible")
	) {

		if($(".password-field").val() !== $(".password-confirm-field").val())
		{
			$(".password_error").text("Passwords do not match!").removeClass("hidden");
			return false;
		}
		else
		{
			$(this).attr("action", "{{ URL::to('user') }}");
			return true;
		}

	}

});
</script>

@stop