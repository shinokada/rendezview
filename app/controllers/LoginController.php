<?php

class LoginController extends BaseController {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function checkEmail()
	{

	   $input_data = array('email' => trim(Input::get('email')));

	   if( ! $this->user->isValid($input_data, 'login'))
		return Response::json(array('is_valid' => false, 'message' => $this->user->validation_errors->first('email')));

	if($this->user->where('email', $input_data['email'])->count() > 0)
		return Response::json(array('is_valid' => true, 'is_found' => true));
	else
	   return Response::json(array('is_valid' => true, 'is_found' => false));

}

public function userList(){

	date_default_timezone_set('America/New_York');
	$today = date("Y-m-d H:i:s");
	$user_id_find = Auth::user()->id;

	$myMeetings=DB::table('attendees')
	->join('users','users.id','=','attendees.user_id')
	->join('appts','appts.id','=','attendees.appt_id')
	->where('users.id','=',$user_id_find)
	->where('start','>',$today)
	->orderBy('appts.start','asc')
	->select('attendees.id','appts.start as appt_start','appts.id as appt_id','users.id as user_id','username','title','description','approval','room','appts.updated_at as last_update','appts.status as status')
	->get();

	$myMeetingsCount = DB::table('attendees')
	->join('users','users.id','=','attendees.user_id')
	->join('appts','appts.id','=','attendees.appt_id')
	->where('users.id','=',$user_id_find)
	->where('start','>',$today)
	->orderBy('appts.start','asc')
	->select('attendees.id','appts.start as appt_start','appts.id as appt_id','users.id as user_id','username','title','description','approval','room','appts.updated_at as last_update','appts.status as status')
	->count();

	$pending = DB::table('appts')
	->where('approval', 0)
	->where('start', '>', $today)
	->get();

	$pendingApprovalCount = DB::table('appts')
	->where('approval', 0)
	->where('start', '>', $today)
	->count();

	$currentMeetings=DB::table('attendees')
	->join('users','users.id','=','attendees.user_id')
	->join('appts','appts.id','=','attendees.appt_id')
	->where('users.id','=',$user_id_find)
	->where('start','<',$today)
	->where('end','>',$today)
	->orderBy('appts.start','asc')
	->select('attendees.id','appts.start as appt_start','appts.end as appt_end','appts.id as appt_id','users.id as user_id','username','title','description','approval','room','appts.updated_at as last_update','appts.status as status')
	->get();

	$currentMeetingsCount=DB::table('attendees')
	->join('users','users.id','=','attendees.user_id')
	->join('appts','appts.id','=','attendees.appt_id')
	->where('users.id','=',$user_id_find)
	->where('start','<',$today)
	->where('end','>',$today)
	->orderBy('appts.start','asc')
	->select('attendees.id','appts.start as appt_start','appts.end as appt_end','appts.id as appt_id','users.id as user_id','username','title','description','approval','room','appts.updated_at as last_update','appts.status as status')
	->count();

	$approvalList=DB::table('rooms')
	->join('appts','appts.room','=','rooms.id')
	->where('approval', 0)
	->where('start','>',$today)
	->orderBy('appts.start','asc')
	->get();

	$approvalListCount=DB::table('rooms')
	->join('appts','appts.room','=','rooms.id')
	->where('approval', 0)
	->where('start','>',$today)
	->orderBy('appts.start','asc')
	->count();


	// $json = array();
	// $id = '495';
	// // Query that retrieves events
	// $query = "SELECT id, title, start, end, description FROM rv_appts WHERE room = $id AND approval = 1 ORDER BY id";

	// // connection to the database
	// try {
	// 	$db = new PDO('mysql:host=localhost;dbname=sullivi2_rendezview', 'sullivi2_evan', '3v0lve2oo9!');
	// } catch(Exception $e) {
	// 	exit('Unable to connect to database. CalendarController@approved');
	// }

	// // Execute the query
	// $result = $db->query($query) or die(print_r($db->errorInfo()));

	// // sending the encoded result to success page
	// echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));

	$approvedCal = DB::table('appts')
	->where('room', '495')
	->where('approval', 1)
	->get();

	$personalConflict = DB::table('attendees')
	->join('users', 'users.id', '=', 'attendees.user_id')
	->join('appts', 'appts.id', '=', 'attendees.appt_id')
	->where('users.id', '=', 1)
	->where('start', '<', '2014-05-23 11:30:00')
	->where('end', '>', '2014-05-23 10:00:00')
	->count();

	// try {
	// 	$db = new PDO('mysql:host=localhost;dbname=sullivi2_rendezview', 'sullivi2_evan', '3v0lve2oo9!');
	// } catch(Exception $e) {
	// 	exit('Unable to connect to database. edit.blade');
	// }
	// // Attendee List
	// $getAttendees = $db->prepare("SELECT
	// 	rv_attendees.id AS 'attendees_id',
	// 	rv_appts.start AS 'appt_start',
	// 	rv_appts.id AS 'appt_id',
	// 	rv_users.id AS 'user_id',
	// 	username, email, title, description
	// 	FROM rv_appts, rv_users, rv_attendees
	// 	WHERE rv_users.id=rv_attendees.user_id
	// 	AND rv_appts.id=rv_attendees.appt_id
	// 	AND rv_appts.id='$appt_id'
	// 	ORDER BY rv_attendees.id ASC;");

	// $getAttendees->execute();
	// $getAttendeesCount = $getAttendees->rowCount();

	$getAttendees = DB::table('attendees')
	->join('users', 'users.id', '=', 'attendees.user_id')
	->join('appts', 'appts.id', '=', 'attendees.appt_id')
	->where('appts.id', '=', 277)
	->orderBy('appts.start','asc')
	->select('attendees.id as attendees_id','appts.start as appt_start','appts.end as appt_end','appts.id as appt_id','users.id as user_id','username','title','description','email')
	->get();

	$getAttendeesCount = DB::table('attendees')
	->join('users', 'users.id', '=', 'attendees.user_id')
	->join('appts', 'appts.id', '=', 'attendees.appt_id')
	->where('appts.id', '=', 277)
	->orderBy('appts.start','asc')
	->select('attendees.id as attendees_id','appts.start as appt_start','appts.end as appt_end','appts.id as appt_id','users.id as user_id','username','title','description','email')
	->count();

	// $personalConflict = DB::table('attendees')
	// ->join('users', 'users.id', '=', 'attendees.user_id')
	// ->join('appts', 'appts.id', '=', 'attendees.appt_id')
	// ->where('users.id', '=', $user_id)
	// ->where('start', '<', $end)
	// ->where('end', '>', $start)
	// ->count();

	// $conflictCounter = "SELECT COUNT(*) FROM rv_attendees, rv_users, rv_appts WHERE rv_attendees.user_id = rv_users.id AND rv_attendees.appt_id = rv_appts.id AND rv_users.id='$user_id_find' AND start < '$appt->end' AND end > '$appt->start';";
	// $conflictCounterQuery = mysqli_query($mysqli, $conflictCounter) or die (mysqli_error());
	// $conflictTotal = mysqli_fetch_row($conflictCounterQuery);


	// $appt_id=$appt->id;
	// $user_id_find = Auth::user()->id;
	// try {
	// 	$db = new PDO('mysql:host=localhost;dbname=sullivi2_rendezview', 'sullivi2_evan', '3v0lve2oo9!');
	// } catch(Exception $e) {
	// 	exit('Unable to connect to database.');
	// }


	// $getDelegateID = $db->prepare(
	// 	"SELECT rv_attendees.id AS 'attendees_id',
	// 	rv_attendees.user_id AS 'attendees_user_id',
	// 	rv_appts.start AS 'appt_start',
	// 	rv_appts.id AS 'appt_id',
	// 	rv_users.id 'user_id',
	// 	username, email, title, description
	// 	FROM rv_appts, rv_users, rv_attendees

	// 	WHERE rv_users.id=rv_attendees.user_id
	// 	AND rv_appts.id=rv_attendees.appt_id
	// 	AND rv_appts.id='277'
	// 	ORDER BY rv_attendees.id DESC;");

	// $getDelegateID->execute();

	$getDelegateID = DB::table('attendees')
	->join('users', 'users.id', '=', 'attendees.user_id')
	->join('appts', 'appts.id', '=', 'attendees.appt_id')
	->where('appts.id', '=', 277)
	->orderBy('attendees.id','desc')
	->select('attendees.id as attendees_id', 'attendees.id as attendees_id', 'appts.start as appt_start', 'appts.id as appt_id', 'users.id as attendees_user_id', 'username', 'title', 'description', 'email')
	->get();

	// return Response::json($getDelegateID);
	return $getDelegateID;
	// return View::make('index')
	// ->with('myMeetings', $myMeetings);

}


public function ajaxtest()
{
   {
	  return View::make('user.login2');
  }
}

}
