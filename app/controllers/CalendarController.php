<?php

use Acme\Mailers\CalendarMailer as Mailer;

class CalendarController extends BaseController {

	protected $mailer;

	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function approved($id)
	{
		//  // List of events
		// $json = array();

		// // Query that retrieves events
		// $query = "SELECT id, title, start, end, description FROM rv_appts WHERE room = $id AND approval = 1 ORDER BY id";

		// // Execute the query
		// $result = $db->query($query) or die(print_r($db->errorInfo()));

		// // sending the encoded result to success page
		// echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));

		$approvedCal = DB::table('appts')
		->where('room', $id)
		->where('approval', 1)
		->get();
		return $approvedCal;
	}

	public function pending($id)
	{
		//  // List of events
		// $json = array();

		// // Query that retrieves events
		// $query = "SELECT id, title, start, end, description FROM rv_appts WHERE room = $id AND approval = 0 ORDER BY id";

		// // Execute the query
		// $result = $db->query($query) or die(print_r($db->errorInfo()));

		// // sending the encoded result to success page
		// echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));

		$pendingCal = DB::table('appts')
		->where('room', $id)
		->where('approval', 0)
		->get();
		return $pendingCal;

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	public function add_event()
	{
		if(Request::ajax())
		{

			$title = Input::get('title');
			$start = Input::get('start');
			$end = Input::get('end');
			$room_id = Input::get('room');
			$room_id = Input::get('room');
			$user_id = Auth::user()->id;
			$created_by = Auth::user()->username;
			$updated_by = Auth::user()->username;

			$dater = date($start);

			$datetime1 = strtotime($start);
			$datetime2 = strtotime($end);
			$secs = $datetime2 - $datetime1;// == <seconds between the two times>
			$hours = $secs / 3601;

			if ($hours >= 1)
			{
				Session::flash('message', 'You must a room administrator for appointments over 1 hour.');
			}
			else
			{
				// $sqlCommand = "SELECT COUNT(*) FROM rv_appts WHERE room=$room_id AND start < '$end' AND end > '$start'";
				// $query = mysqli_query($mysqli, $sqlCommand) or die (mysqli_error());
				// $row = mysqli_fetch_row($query);

				// $conflictCounter = "SELECT COUNT(*) FROM rv_attendees, rv_users, rv_appts WHERE rv_attendees.user_id = rv_users.id AND rv_attendees.appt_id = rv_appts.id AND rv_users.id='$user_id' AND start < '$end' AND end > '$start';";
				// $conflictCounterQuery = mysqli_query($mysqli, $conflictCounter) or die (mysqli_error());
				// $conflictTotal = mysqli_fetch_row($conflictCounterQuery);

				$slotConflict = DB::table('appts')
				->where('room', $room_id)
				->where('start', '<', $end)
				->where('end', '>', $start)
				->count();

				$personalConflict = DB::table('attendees')
				->join('users', 'users.id', '=', 'attendees.user_id')
				->join('appts', 'appts.id', '=', 'attendees.appt_id')
				->where('users.id', '=', $user_id)
				->where('start', '<', $end)
				->where('end', '>', $start)
				->count();

				if($slotConflict != 0)
				{
					Session::flash('message', 'Something is already scheduled for this time slot!');
				}
				else
				{
					if($personalConflict != 0)
					{
						Session::flash('message', 'You already have an appointment for this time elsewhere!');
					}
					else
					{
						// $sql = "INSERT INTO rv_appts (title, start, end, room, user_id, created_by, updated_by) VALUES (:title, :start, :end, :room, :user_id, :created_by, :updated_by)";
						// $q = $db->prepare($sql);
						// $q->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end, ':room' => $room_id, ':user_id' => $user_id, ':created_by' => $created_by, ':updated_by' => $updated_by));

						DB::table('appts')
						->insert(array('title' => $title, 'start' => $start, 'end' => $end, 'room' => $room_id, 'user_id' => $user_id, 'created_by' => $created_by, 'updated_by' => $updated_by));

						// $user = User::find(1);
						// $user = $created_by;
						// $this->mailer->newAppointment->sendTo($user);

						Session::flash('message', 'Appointment Added! A room administrator will review your request shortly!');
					}
				}
			}
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */


	public function update_event()
	{
		if(Request::ajax())
		{

			$id = Input::get('id');
			$title = Input::get('title');
			$start = Input::get('start');
			$end = Input::get('end');

			// // update the records
			// $sql = "UPDATE rv_events SET title=?, start=?, end=? WHERE id=?";
			// $q = $db->prepare($sql);
			// $q->execute(array($title,$start,$end,$id));

			DB::table('events')
			->where('id', $id)
			->update(array('title' => $title, 'start' => $start, 'end' => $end));
		}
	}

	//
	// /**
	//  * Remove the specified resource from storage.
	//  *
	//  * @param  int  $id
	//  * @return Response
	//  */
	// public function delete()
	// {
	// 	if(Request::ajax())
	// 	{
	// 		$id = Input::get('id');
	// 		$sql = "DELETE from rv_events WHERE id=".$id;
	// 		$q = $db->prepare($sql);
	// 		$q->execute();
	// 	}
	// }
}
