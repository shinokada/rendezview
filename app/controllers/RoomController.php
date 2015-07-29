<?php

class RoomController extends BaseController {

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
		// get all the rooms
		$rooms = Room::all();

		// load the view and pass the rooms
		return View::make('rooms.index')
		->with('rooms', $rooms);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// load the create form (app/views/rooms/create.blade.php)
		return View::make('rooms.create');
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
			'room_admin'       => 'required',
			'room_name'       => 'required',
			'room_location'      => 'required',
			'room_capacity' => 'required|numeric',
			'room_type'
			);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('rooms/create')
			->withErrors($validator)
			->withInput(Input::except('password'));
		} else {
			// store
			$room = new Room;
			$room->room_admin       = Input::get('room_admin');
			$room->room_name       = Input::get('room_name');
			$room->room_location      = Input::get('room_location');
			$room->room_capacity = Input::get('room_capacity');
			$room->room_type = Input::get('room_type');
			$room->save();

			// redirect
			Session::flash('message', 'Successfully created room!');
			return Redirect::to('rooms');
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
		// get the room
		$room = Room::find($id);

		// show the view and pass the room to it
		return View::make('rooms.show')
		->with('room', $room);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// get the room
		$room = Room::find($id);

		// show the edit form and pass the room
		return View::make('rooms.edit')
		->with('room', $room);
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
			'room_admin'       => 'required',
			'room_name'       => 'required',
			'room_location'      => 'required',
			'room_capacity' => 'required|numeric',
			'room_type'
			);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('rooms/' . $id . '/edit')
			->withErrors($validator)
			->withInput(Input::except('password'));
		} else {
			// store
			$room = Room::find($id);
			$room->room_admin       = Input::get('room_admin');
			$room->room_name       = Input::get('room_name');
			$room->room_location      = Input::get('room_location');
			$room->room_capacity = Input::get('room_capacity');
			$room->room_type = Input::get('room_type');
			$room->save();

			// redirect
			Session::flash('message', 'Successfully updated room!');
			return Redirect::to('rooms');
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
		$room = Room::find($id);
		$room->delete();

		// redirect
		Session::flash('message', 'Successfully deleted the room!');
		return Redirect::to('rooms');
	}
}