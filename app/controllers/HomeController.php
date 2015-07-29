<?php

class HomeController extends BaseController
{
	public function showWelcome()
	{
		date_default_timezone_set('America/New_York');
		$today = date("Y-m-d H:i:s");
		$user_id_find = Auth::user()->id;

		$myMeetings=DB::table('attendees')
		->join('users','users.id','=','attendees.user_id')
		->join('appts','appts.id','=','attendees.appt_id')
		->join('rooms','rooms.id','=','appts.room')
		->where('users.id','=',$user_id_find)
		->where('start','>',$today)
		->orderBy('appts.start','asc')
		->select('attendees.id','appts.start as appt_start','appts.id as appt_id','users.id as user_id','username','title','description','approval','room','appts.updated_at as last_update','appts.status as status', 'rooms.room_name')
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
		->join('rooms','rooms.id','=','appts.room')
		->where('users.id','=',$user_id_find)
		->where('start','<',$today)
		->where('end','>',$today)
		->orderBy('appts.start','asc')
		->select('attendees.id','appts.start as appt_start','appts.end as appt_end','appts.id as appt_id','users.id as user_id','username','title','description','approval','room','appts.updated_at as last_update','appts.status as status', 'rooms.room_name')
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
		->select('room_name')
		->orderBy('appts.start','asc')
		->select('approval', 'appts.room', 'appts.start', 'appts.title', 'appts.status', 'appts.description', 'rooms.room_name', 'appts.id as appt_id')
		->get();

		$approvalListCount=DB::table('rooms')
		->join('appts','appts.room','=','rooms.id')
		->where('approval', 0)
		->where('start','>',$today)
		->orderBy('appts.start','asc')
		->count();

		return View::make('home')
		->with('myMeetings', $myMeetings)
		->with('myMeetingsCount', $myMeetingsCount)
		->with('pending', $pending)
		->with('pendingApprovalCount', $pendingApprovalCount)
		->with('currentMeetings', $currentMeetings)
		->with('currentMeetingsCount', $currentMeetingsCount)
		->with('approvalList', $approvalList)
		->with('approvalListCount', $approvalListCount);
	}

	public function showSecret()
	{
		return View::make('secret');
	}

}
