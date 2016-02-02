<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    // // Force SSL
    // if( ! Request::secure())
    // {
    //     return Redirect::secure(Request::path());
    // }

		// Global Variables
    App::singleton('myApp', function(){
        $app = new stdClass;
        if (Auth::check())
				{
					$app->user = Auth::user()->id;
					$pdo = DB::connection()->getPdo();

					// master.blade.php
					// Room list
					$roomQuery = $pdo->prepare("SELECT room_location, room_name, id FROM rv_rooms ORDER BY room_location, room_name ASC;");
					$roomQuery->execute();
					$app->rooms = $roomQuery->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

					// edit.blade.php
					// if (isset($appt))
					// {
					// 	// Attendee List
					// 	$getAttendees = $pdo->prepare("SELECT rv_attendees.id AS 'attendees_id', rv_appts.start AS 'appt_start', rv_appts.id AS 'appt_id', rv_users.id AS 'user_id', username, email, title, description FROM rv_appts, rv_users, rv_attendees WHERE rv_users.id=rv_attendees.user_id AND rv_appts.id=rv_attendees.appt_id AND rv_appts.id='$appt->id' ORDER BY rv_attendees.id ASC;");
					// 	$getAttendees->execute();
					// 	$app->getAttendeesCount = $getAttendees->rowCount();
					//
					// 	//DelegateID
					// 	$getDelegateID = $pdo->prepare("SELECT rv_attendees.id AS 'attendees_id', rv_attendees.user_id AS 'attendees_user_id', rv_appts.start AS 'appt_start', rv_appts.id AS 'appt_id', rv_users.id 'user_id', username, email, title, description FROM rv_appts, rv_users, rv_attendees WHERE rv_users.id=rv_attendees.user_id AND rv_appts.id=rv_attendees.appt_id AND rv_appts.id='$appt->id' ORDER BY rv_attendees.id ASC;");
					// 	$getDelegateID->execute();
					// 	$app->$getDelegateCount = $getDelegateID->rowCount();
					//
					// 	//conflict calculator
					// 	$conflictCounter = $pdo->prepare("SELECT COUNT(*) FROM rv_attendees, rv_users, rv_appts WHERE rv_attendees.user_id = rv_users.id AND rv_attendees.appt_id = rv_appts.id AND rv_users.id='$app->user' AND start < '$appt->end' AND end > '$appt->start';");
					// 	$conflictCounter->execute();
					// 	$app->conflictTotal = $conflictCounter->rowCount();
					// }

					$app->approvalCount = Appt::where('approval', '=', '0')->count();
        }
        return $app;
    });
    $app = App::make('myApp');
    View::share('myApp', $app);
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) {
        Session::put('loginRedirect', Request::url());
        return Redirect::to('user/login/');
    }
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('user/login/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
|
| Detect the browser language.
|
*/

Route::filter('detectLang',  function($route, $request, $lang = 'auto')
{

    if($lang != "auto" && in_array($lang , Config::get('app.available_language')))
    {
        Config::set('app.locale', $lang);
    }else{
        $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
        $browser_lang = substr($browser_lang, 0,2);
        $userLang = (in_array($browser_lang, Config::get('app.available_language'))) ? $browser_lang : Config::get('app.locale');
        Config::set('app.locale', $userLang);
        App::setLocale($userLang);
    }
});
