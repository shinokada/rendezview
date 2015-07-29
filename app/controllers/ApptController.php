<?php

class ApptController extends \BaseController {

	/**
	* Room Model
	* @var Room
	*/
	protected $room;

	/**
	* Inject the model.
	* @param Room $room
	*/
	public function __construct(Room $room)
	{
		parent::__construct();
		$this->room = $room;

	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// get all the appts
		$appts = Appt::all();

		// load the view and pass the appts
		// return View::make('appts.index')
		// ->with('appts', $appts);
		return Redirect::to('/');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// load the create form (app/views/appts/create.blade.php)
		return View::make('appts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'title'       => 'required',
			'start'      => 'required',
			'end' => 'required',
			'status',
			'description'
			);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('appts/create')
			->withErrors($validator)
			->withInput(Input::except('password'));
		} else {
			// store
			$appt = new Appt;
			$appt->title       = Input::get('title');
			$appt->start      = Input::get('start');
			$appt->end = Input::get('end');
			$appt->status = Input::get('status');
			$appt->description = Input::get('description');
			$appt->user_id = Confide::user()->id;
			$appt->created_by = Confide::user()->username;
			$appt->updated_by = Confide::user()->username;
			$appt->save();

			// redirect
			Session::flash('message', 'Successfully created appointment!');
			return Redirect::to('/');
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
		// get the appt
		$appt = Appt::find($id);

		// show the view and pass the appt to it
		return View::make('appts.show')
		->with('appt', $appt);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$appt = Appt::find($id);
		$appt_id=Appt::find($id);
		$user_id=Confide::user()->id;
		// $mysqli = new mysqli("localhost", "sullivi2_evan", "3v0lve2oo9!", "sullivi2_rendezview");
		// if (mysqli_connect_errno()) {
		// 	printf("Connect failed: %s\n", mysqli_connect_error());
		// 	exit();
		// }
		// $sqlCommand = "SELECT count(*) FROM rv_attendees WHERE appt_id = $appt_id AND user_id = $user_id";
		// $query = mysqli_query($mysqli, $sqlCommand) or die (mysqli_error());
		// $row = mysqli_fetch_row($query);
		// $attend=$row[0];

		$attend = DB::table('attendees')
		->where('appt_id', '=', $appt_id)
		->where('user_id', '=', $user_id)
		->count();

		// // Attendee List
		// $getAttendees = $db->prepare("SELECT rv_attendees.id AS 'attendees_id', rv_appts.start AS 'appt_start', rv_appts.id AS 'appt_id', rv_users.id AS 'user_id', username, email, title, description FROM rv_appts, rv_users, rv_attendees WHERE rv_users.id=rv_attendees.user_id AND rv_appts.id=rv_attendees.appt_id AND rv_appts.id='$appt_id' ORDER BY rv_attendees.id ASC;");
		// $getAttendees->execute();
		// $getAttendeesCount = $getAttendees->rowCount();

		$getAttendees = DB::table('attendees')
		->join('users', 'users.id', '=', 'attendees.user_id')
		->join('appts', 'appts.id', '=', 'attendees.appt_id')
		->where('appts.id', '=', $appt_id)
		->orderBy('appts.start','asc')
		->select('attendees.id as attendees_id','appts.start as appt_start','appts.end as appt_end','appts.id as appt_id','users.id as user_id','username','title','description','email')
		->get();

		$getAttendeesCount = DB::table('attendees')
		->join('users', 'users.id', '=', 'attendees.user_id')
		->join('appts', 'appts.id', '=', 'attendees.appt_id')
		->where('appts.id', '=', $appt_id)
		->orderBy('appts.start','asc')
		->select('attendees.id as attendees_id','appts.start as appt_start','appts.end as appt_end','appts.id as appt_id','users.id as user_id','username','title','description','email')
		->count();

		// $conflictCounter = "SELECT COUNT(*) FROM rv_attendees, rv_users, rv_appts WHERE rv_attendees.user_id = rv_users.id AND rv_attendees.appt_id = rv_appts.id AND rv_users.id='$user_id_find' AND start < '$appt->end' AND end > '$appt->start';";
		// $conflictCounterQuery = mysqli_query($mysqli, $conflictCounter) or die (mysqli_error());
		// $conflictTotal = mysqli_fetch_row($conflictCounterQuery);

		$conflictTotal = DB::table('attendees')
		->join('users', 'users.id', '=', 'attendees.user_id')
		->join('appts', 'appts.id', '=', 'attendees.appt_id')
		->where('users.id', '=', $user_id)
		->where('start', '<', 'appts.end')
		->where('end', '>', 'appts.start')
		->select('appts.end', 'appts.start')
		->count();

		// $getDelegateID = $db->prepare(
		// 	"SELECT rv_attendees.id AS 'attendees_id', 
		// 	rv_attendees.user_id AS 'attendees_user_id', rv_appts.start AS 'appt_start', rv_appts.id AS 'appt_id', rv_users.id AS 'user_id', username, email, title, description FROM rv_appts, rv_users, rv_attendees WHERE rv_users.id=rv_attendees.user_id AND rv_appts.id=rv_attendees.appt_id AND rv_appts.id='$appt_id' ORDER BY rv_attendees.id DESC;");

		$getDelegateID = DB::table('attendees')
		->join('users', 'users.id', '=', 'attendees.user_id')
		->join('appts', 'appts.id', '=', 'attendees.appt_id')
		->where('appts.id', '=', $appt_id)
		->orderBy('attendees.id','desc')
		->select('attendees.id as attendees_id', 'attendees.user_id as attendees_user_id', 'appts.start as appt_start', 'appts.id as appt_id', 'username', 'title', 'email')
		->get();

		// show the edit form and pass the appt
		return View::make('appts.edit')
		->with('appt', $appt_id);
		// ->with('attend', $attend)
		// ->with('conflictTotal', $conflictTotal)
		// ->with('getAttendees', $getAttendees)
		// ->with('getDelegateID', $getDelegateID)
		// ->with('getAttendeesCount', $getAttendeesCount);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'title'       => 'required',
			'start'      => 'required',
			'end' => 'required',
			'status',
			'description',
			);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('appts/' . $id . '/edit')
			->withErrors($validator)
			->withInput(Input::except('password'));
		} else {
			// store
			$appt = Appt::find($id);
			$appt->title       = Input::get('title');
			$appt->start      = Input::get('start');
			$appt->end = Input::get('end');
			$appt->status = Input::get('status');
			$appt->description = Input::get('description');
			$appt->approval = Input::get('approval');
			$appt->save();

			// redirect
			Session::flash('message', 'Successfully updated appointment!');
			// return Redirect::to('appts/' . $id);
			// Redirect::to('rooms/' . $appt->room);
			return Redirect::to('/');
			// return Redirect::refresh();
			// Redirect::back();
		}
	}


	public function join()
	{
		$appt_id = Input::get('appt_id');
		$user_id = Input::get('user_id');

		// try {
		// 	$db = new PDO('mysql:host=localhost;dbname=sullivi2_rendezview', 'sullivi2_evan', '3v0lve2oo9!');
		// } catch(Exception $e) {
		// 	exit('Unable to connect to database. ApptController@join');
		// }

		// $sql = "INSERT INTO rv_attendees (appt_id, user_id) VALUES (:appt_id, :user_id)";
		// $q = $db->prepare($sql);
		// $q->execute(array(':appt_id'=>$appt_id, ':user_id'=>$user_id));

		DB::table('attendees')
		->insert(array('appt_id' => $appt_id, 'user_id' => $user_id));

		Session::flash('message', 'You have joined the meeting.' );
		return Redirect::to('/');
	}

	public function leave()
	{
		$appt_id = Input::get('appt_id');
		$user_id = Input::get('user_id');

		// try {
		// 	$db = new PDO('mysql:host=localhost;dbname=sullivi2_rendezview', 'sullivi2_evan', '3v0lve2oo9!');
		// } catch(Exception $e) {
		// 	exit('Unable to connect to database. ApptController@leave');
		// }
		// $sql = "DELETE FROM rv_attendees WHERE appt_id = '$appt_id' AND user_id = '$user_id'";
		// $q = $db->prepare($sql);
		// $q->execute();

		DB::table('attendees')
		->where('appt_id', '=', $appt_id)
		->where('user_id', '=', $user_id)
		->delete();

		Session::flash('message', 'You have left the meeting.' );
		return Redirect::to('/');
	}

	public function delegate()
	{
		$appt_id = Input::get('appt_id');
		$result = $_POST['delegate'];
		$result_explode = explode('|', $result);

		// try {
		// 	$db = new PDO('mysql:host=localhost;dbname=sullivi2_rendezview', 'sullivi2_evan', '3v0lve2oo9!');
		// } catch(Exception $e) {
		// 	exit('Unable to connect to database. ApptController@delegate');
		// }
		// $sql = "UPDATE rv_appts SET user_id=?, created_by=?, updated_by=? WHERE id=?";
		// $q = $db->prepare($sql);
		// $q->execute(array($result_explode[1],$result_explode[0],$result_explode[0],$appt_id));

		DB::table('appts')
		->where('id', $appt_id)
		->update(array('user_id' => $result_explode[1], 'created_by' => $result_explode[0], 'updated_by' => $result_explode[0]));

		Session::flash('message', 'You have transfered ownership of this meeting.' );
		return Redirect::to('/');
	}

	public function appointmentFinder()
	{
		$this->filter('before', 'csrf')->on('post');
		if(Request::ajax())
		{

			//check we have username post var
			$username = Input::get('username');
			if(isset($_POST["username"]))
			{
			//check if its an ajax request, exit if not
				if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
					die();
				}
				$db_username = 'sullivi2_evan';
				$db_password = '3v0lve2oo9!';
				$db_name = 'sullivi2_rendezview';
				$db_host = 'localhost';
				################

				//try connect to db
				$connecDB = mysqli_connect($db_host, $db_username, $db_password,$db_name)or die('could not connect to database. ApptController@appointmentFinder');

				//trim and lowercase username
				$username =  strtolower(trim($_POST["username"])); 

				//sanitize username
				$username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);

				//check username in db
				$results = mysqli_query($connecDB,"SELECT id FROM rv_users WHERE username='$username'");

			//return total count
			$username_exist = mysqli_num_rows($results); //total records

			//if value is more than 0, username is not available
			if($username_exist) {
				echo '<img src="img/not-available.png" /> no dice, buddy';
			}else{
				echo '<img src="img/available.png" /> available';
			}

			//close db connection
			mysqli_close($connecDB);
		}
	}
}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
		$appt = Appt::find($id);
		$appt->delete();

		// redirect
		Session::flash('message', 'Successfully deleted the appointment!');
		return Redirect::to('/');
	}

}