<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/** ------------------------------------------
*  Route model binding
*  ------------------------------------------
*/
Route::model('users', 'User');
Route::model('roles', 'Role');
//Route model binding makes controller testing hard with Mockery.
//Route::model('widgets', 'Widget');

// Home route

// TEST AREA
Route::get('ajaxzone',                         'LoginController@ajaxtest');
// Route::get('ajaxzone',                         'LoginController@userList');
// Route::post('login/check_email', 		   'LoginController@checkEmail');
// Route::post('login/check_email', 		   'LoginController@userList');

// Route::get("chat", function()
// {
//     return View::make("index/index");
// });

// Route::get('emails/send', 'ChatController@store');
// Route::resource('emails', 'ChatController');

// Route::get('ajaxzone', function()
// {
// $appts = DB::table('appts')->get();
// $appts = DB::table('appts')->where('title', '!=', 'INFO 426')->get();

// DB::select('select * from users');
// DB::insert('select * from users');
// $appts = DB::table('appts')->find(244);

// return Appt::orderBy('title', 'asc')->get();
// return $appts;
// return $appts->title;
// dd($appts);
// });

// Confide routes

Route::get('user',                         'UserController@index');
Route::post('user/{user}/update',		   'UserController@update')->where('user', '[0-9]+');
Route::get( 'user/create',                 'UserController@create');
Route::post('user',                        'UserController@store');
Route::get( 'user/login',                  'UserController@login');
Route::post('user/login',                  'UserController@do_login');
Route::get( 'user/confirm/{code}',         'UserController@confirm');
Route::get( 'user/forgot_password',        'UserController@forgot_password');
Route::post('user/forgot_password',        'UserController@do_forgot_password');
Route::get( 'user/reset_password/{token}', 'UserController@reset_password');
Route::post('user/reset_password',         'UserController@do_reset_password');
Route::get( 'user/logout',                 'UserController@logout');

// Route::post('login/check_email', function()
// {
// 	return Response::json(array('message' => 'test'));
// });

// Route::get('api/rooms', array('as'=>'api.rooms', 'uses'=>'RoomController@getDatatable'));

// Secure-Routes Widgets
Route::group(array('before' => 'auth'), function()
{

	Route::get('/', 'HomeController@showWelcome');
	/** ------------------------------------------
	*  Widgets
	*  ------------------------------------------
	*/

	// Datatables Ajax route.
	// NOTE: We must define this route first as it is more specific than
	// the default show resource route for /widgets/{widgets}
	Route::get('widgets/data', 'WidgetController@data');

	// Pre-baked resource controller actions for index, create, store,
	// show, edit, update, destroy
	Route::resource('widgets', 'WidgetController');

	// Our special delete confirmation route - uses the show/details view.
	// NOTE: For model biding above to work - the plural paramameter {widgets} needs
	// to be used.
	Route::get('widgets/{widgets}/delete', 	'WidgetController@delete');


	/** ------------------------------------------
	*  Rooms & Appts
	*  ------------------------------------------
	*/

	// Pre-baked resource controller actions for index, create, store,
	// show, edit, update, destroy
	// Route::resource('nerds', 'NerdController');
	Route::resource('appts', 'ApptController');
	Route::resource('rooms', 'RoomController');
	// Route::resource('appts/editmodal', 'ApptController');
	Route::get('cal/approved/{id}', 'CalendarController@approved');
	Route::get('cal/pending/{id}', 'CalendarController@pending');
	Route::get('cal/add', 'CalendarController@add_event');
	Route::get('cal/update', 'CalendarController@update_event');
	Route::post('appointment/finder', 'ApptController@appointmentFinder');
	Route::get('appointment/finder', 'ApptController@appointmentFinder');
	// Route::get('attendee/add', 'ApptController@join');
	Route::post('attendee/add', 'ApptController@join');
	Route::post('attendee/remove', 'ApptController@leave');
	Route::post('attendee/delegate', 'ApptController@delegate');
	// Route::delete('cal/delete', 'CalendarController@delete_event');

});


/** ------------------------------------------
*  Admin routes
*  See filters.php for Entrust filters that restrict admin routes to admin users.
*  ------------------------------------------
*/
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{
	/** ------------------------------------------
	*  Users
	*  ------------------------------------------
	*/

	// Datatables Ajax route.
	// NOTE: We must define this route first as it is more specific than
	// the default show resource route for /users/{user_id}
	Route::get('users/data', 'AdminUserController@data');

	// Pre-baked resource controller actions for index, create, store,
	// show, edit, update, destroy
	Route::resource('users', 'AdminUserController');

	//Our special delete confirmation route - uses the show/details view.
	// NOTE: For model biding above to work - the plural paramameter {users} needs
	// to be used.
	Route::get('users/{users}/delete', 'AdminUserController@delete');

	/** ------------------------------------------
	*  Roles
	*  ------------------------------------------
	*/

	// Datatables Ajax route.
	// NOTE: We must define this route first as it is more specific than
	// the default show resource route for /users/{role_id}
	Route::get('roles/data',	 'AdminRolesController@data');

	// Pre-baked resource controller actions for index, create, store,
	// show, edit, update, destroy
	Route::resource('roles',	 'AdminRolesController');

	//Our special delete confirmation route - uses the show/details view
	// NOTE: For model biding above to work - the plural paramameter {roles} needs
	// to be used.
	Route::get('roles/{roles}/delete', 'AdminRolesController@delete');

});

// Route::get('events/update', 'CalendarController@update');
// Route::get('events/delete', 'CalendarController@delete');

// Route::post('events/add', function()
// {
// 	if(Request::ajax())
// 	{
// 		return 'hello';
// 		// return Response::json(['data' => 'json']);
// 	}
// });
