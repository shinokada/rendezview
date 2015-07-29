<?php namespace Acme\Mailers;

use User;

class ChatMailer extends Mailer {

	public function welcome(User $user)
	{
		$view = 'emails.chat';
		$data = [];
		$subject = 'Chat Mailer Test Method';

		return $this->sendTo($user, $subject, $view, $data);
	}
}