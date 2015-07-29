function hide_pfs()
{
	if($(".login-signup-btn").is(":visible")) $(".login-signup-btn").fadeOut("fast");

	if($(".password-cfrm-field-container").is(":visible")) $(".password-cfrm-field-container").fadeOut("fast");

	if($(".password-field-container").is(":visible")) $(".password-field-container").fadeOut("fast");
}

function validate_email(email) {
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	if( ! emailReg.test( email ) ) {
		return false;
	} else {
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
		url: "<?php echo URL::to('user/check_email') ?>",
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
			$(this).attr("action", "{{ URL::to('login/create_user') }}");
			return true;
		}

	}

});