<?php namespace Acme\Mailers;

use User;

class CalendarMailer extends Mailer {

	public function newAppointment(User $user)
	{
		$view = 'emails.appointmentCreated';
		$data = [];
		$subject = 'New Appointment Created';

		return $this->sendTo($user, $subject, $view, $data);
	}
}