@extends('layouts.master')

@section('title')
@parent
:: Home
@stop

@section('content')
<script type="text/javascript">
$(function() {
	var options = {
		classes			: 'mm-light',
		modal			: true
	};

	options.position = 'left';
	options.zposition = 'next';
	$('#tooltip-1').mmenu( options );

	options.position = 'right';
	options.zposition = 'next';
	$('#tooltip-2').mmenu( options );

	options.position = 'bottom';
	options.zposition = 'front';
	$('#popup-1').mmenu( options );

	options.position = 'top';
	options.zposition = 'front';
	$('#popup-2').mmenu( options );

	$('a.close').click(function() {
		$(this).closest( '.mm-menu' ).trigger( 'close' );
	});
});
</script>
@if (Auth::check())

@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<!-- ADMIN -->
@if (Auth::user()->hasRole('admin'))

<!-- <div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-user fa-fw"></i> Account Info
					</div>
					<div class="panel-body">
						<div class="list-group">
							<a href="#" class="list-group-item">
								<i class="fa fa-book fa-fw"></i> Created: 
							<script>
							var time = moment("{{Auth::user()->created_at}}").fromNow();
							document.write(time);
							</script>
							</a>
							<a href="#" class="list-group-item">
								<i class="fa fa-cog fa-fw"></i> Username: {{{ Auth::user()->username }}}
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-bell fa-fw"></i> Basic Settings
					</div>
					<div class="panel-body">
						<div class="list-group">
							<a href="#" class="list-group-item">
								<i class="fa fa-book fa-fw"></i> Approvals Needed
								<span class="pull-right text-muted small"><em>{{ $pendingApprovalCount }}</em>
								</span>
							</a>
							<a href="#" class="list-group-item">
								<i class="fa fa-cog fa-fw"></i> Current Role: System Administrator
								<span class="pull-right text-muted small"><em></em>
								</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
		</div>
	</div>
</div>

<div id="popup-2" class="tip">
	<div>
		<a href="#" class="close">x</a>
		<h4>Popups and modal windows</h4>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
				</div>
			</div>
		</div>
	</div>
</div> -->

@endif
<!-- ATTENDEE -->
@if (Confide::user()->hasRole('attendee'))

<!-- <div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-user fa-fw"></i> Account Info
					</div>
					<div class="panel-body">
						<div class="list-group">
							<a href="#" class="list-group-item">
								<i class="fa fa-book fa-fw"></i> Created: 
							<script>
							var time = moment("{{Auth::user()->created_at}}").fromNow();
							document.write(time);
							</script>
							</a>
							<a href="#" class="list-group-item">
								<i class="fa fa-cog fa-fw"></i> Username: {{{ Auth::user()->username }}}
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-bell fa-fw"></i> Basic Settings
					</div>
					<div class="panel-body">
						<div class="list-group">
							<a href="#" class="list-group-item">
								<i class="fa fa-cog fa-fw"></i> Current Role: Attendee
								<span class="pull-right text-muted small"><em></em>
								</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
		</div>
	</div>
</div> -->

@endif
<!-- ORGANIZER -->
@if (Auth::user()->hasRole('organizer'))

<div class="jumbotron hero-spacer">
	<h1>Hello {{{ Auth::user()->username }}}</h1>
	<p>This page is only visable to organizers.</p>
</div>

@endif
<!-- ROOM ADMIN -->
@if (Auth::user()->hasRole('r-admin'))

<div class="jumbotron hero-spacer">
	<h1>Hello {{{ Auth::user()->username }}}</h1>
	<p>This page is only visable to room administrators.</p>
</div>

@endif
<!-- TERMINAL -->
@if (Auth::user()->hasRole('terminal'))

<div class="jumbotron hero-spacer">
	<h1>Hello Terminal!</h1>
	<p>This page is only visable to a terminal.</p>
</div>

@endif
<!-- GUEST -->
@else

<div class="jumbotron hero-spacer">
	<h1>Welcome to RendezView!</h1>
</div>

@endif

<!-- <h1 class="page-header" id='clock'></h1> -->
@if (Auth::check())
<!-- CURRENTLY HAPPENING -->


@if ($currentMeetingsCount === 0)
@else
<h3>Currently Happening</h3>
<ul class="timeline">
	<?php $i = 0; ?>
	@foreach($currentMeetings as $value)
		@if ($value->approval==0)
		<li class="timeline-inverted">
		<div class="timeline-badge warning"><i class="fa fa-spinner fa-spin fa-fw"></i></div>
		<!-- <div class="timeline-badge warning"><i class="fa fa-question fa-fw"></i></div> -->
		@else
		<li>
		<div class="timeline-badge info"><i class="fa fa-bell fa-fw"></i></div>
		@endif
		<div class="timeline-panel">
			<div class="timeline-heading">
				<a class="roomhref" href="{{{ URL::to('rooms/'.$value->room) }}} " data-time="{{{ $value->appt_start }}}">
					@if ($value->approval==0)
					<h4 class="timeline-title">{{{ $value->title }}} <small><em>Pending Approval</em></small></h4>
					@else
					<h4 class="timeline-title">{{ $value->title }} </small></h4>
					@endif
				</a>
			</div>
			<div class="timeline-body">
				<p>
					@if ($value->status != null)
					<strong>{{{ $value->status }}}</strong>
					@endif
				</p>
				<p>{{{ $value->description }}}</p>
				<p>
					<small class="text-muted">
						{{{ $value->room_name }}}</p>
					</small>
				<p>
					<small class="text-muted"><i class="fa fa-clock-o fa-fw"></i> Ending 
						<script type="text/javascript">
						var time = moment("{{ $value->appt_end }}").fromNow();
						document.write(time);
						</script>
					</small>
				</p>
			</div>
			<a href="edithref" class="fa fa-edit fa-fw fa-2x edit-btn" data-apptID="{{ $value->appt_id }}" title="Edit Meeting"><div class="hide-text">Edit Meeting</div></a>
			<!-- <div class="edit-btn" style="display: block; background: red; width: 50px; height: 50px;"></div> -->
		</div>
	</li>
	<?php $i++; ?>
	@endforeach
</ul>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

@endif

@endif


@if (Auth::check())
<!-- UPCOMING APPOINTMENTS -->
<h3>Upcoming Meetings</h3>
@if ($myMeetingsCount === 1)
@elseif ($myMeetingsCount > 1)
@else

<div class="row">
	<div class="col-md-12">
		<div class="alert alert-info alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			You have no plans!  Why don't you make some?
		</div>
	</div>
</div>

@endif

@if ($myMeetings === 0)
<div class="create-meeting">
	<button class="action-btn create-meeting-btn btn">Create New Meeting</button>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
@else
<ul class="timeline">
	<?php $i = 0; ?>
	@foreach($myMeetings as $value)
		@if ($value->approval==0)
		<li class="timeline-inverted">
		<div class="timeline-badge warning"><i class="fa fa-spinner fa-spin fa-fw"></i></div>
		<!-- <div class="timeline-badge warning"><i class="fa fa-question fa-fw"></i></div> -->
		@else
		<li>
		<div class="timeline-badge info"><i class="fa fa-bell fa-fw"></i></div>
		@endif
		<div class="timeline-panel">
			<div class="timeline-heading">
				<a class="roomhref" href="{{{ URL::to('rooms/'.$value->room) }}} " data-time="{{{ $value->appt_start }}}">
					@if ($value->approval==0)
					<h4 class="timeline-title">{{{ $value->title }}} <small><em>Pending Approval</em></small></h4>
					@else
					<h4 class="timeline-title">{{ $value->title }} </small></h4>
					@endif
				</a>
			</div>
			<div class="timeline-body">
				<p>
					@if ($value->status != null)
					<strong>{{{ $value->status }}}</strong>
					@endif
				</p>
				<p>{{{ $value->description }}}</p>
				<p>
					<small class="text-muted">
						{{{ $value->room_name }}}</p>
					</small>
				<p>
					<small class="text-muted"><i class="fa fa-clock-o fa-fw"></i> Starting 
						<script type="text/javascript">
						var time = moment("{{ $value->appt_start }}").fromNow();
						document.write(time);
						</script>
					</small>
				</p>
			</div>
			<a href="edithref" class="fa fa-edit fa-fw fa-2x edit-btn" data-apptID="{{ $value->appt_id }}" title="Edit Meeting"><div class="hide-text">Edit Meeting</div></a>
			<!-- <div class="edit-btn" style="display: block; background: red; width: 50px; height: 50px;"></div> -->
		</div>
	</li>
	<?php $i++; ?>
	@endforeach
</ul>
<div class="create-meeting">
	<a href="#menu-right"><button class="action-btn create-meeting-btn btn">Create New Meeting</button></a>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

@endif

@endif


<!-- Approval list -->
@if (Auth::check())
@if (Auth::user()->hasRole('admin'))

@if ($approvalListCount > 0)
<h3>Pending Approval ({{{$approvalListCount}}})</h3>

<ul class="timeline">
	<?php $i = 0; ?>
	@foreach($approvalList as $value)
		@if ($value->approval==0)
		<li class="timeline-inverted">
		<div class="timeline-badge warning"><i class="fa fa-spinner fa-spin fa-fw"></i></div>
		<!-- <div class="timeline-badge warning"><i class="fa fa-question fa-fw"></i></div> -->
		@else
		<li>
		<div class="timeline-badge info"><i class="fa fa-bell fa-fw"></i></div>
		@endif
		<div class="timeline-panel">
			<div class="timeline-heading">
				<a class="roomhref" href="{{{ URL::to('rooms/'.$value->room) }}} " data-time="{{{ $value->start }}}">
					@if ($value->approval==0)
					<h4 class="timeline-title">{{{ $value->title }}} <small><em>Pending Approval</em></small></h4>
					@else
					<h4 class="timeline-title">{{ $value->title }} </small></h4>
					@endif
				</a>
			</div>
			<div class="timeline-body">
				<p>
					@if ($value->status != null)
					<strong>{{{ $value->status }}}</strong>
					@endif
				</p>
				<p>{{{ $value->description }}}</p>
				<p>
					<small class="text-muted">
						{{{ $value->room_name }}}</p>
					</small>
				<p>
					<small class="text-muted"><i class="fa fa-clock-o fa-fw"></i> Starting 
						<script type="text/javascript">
						var time = moment("{{ $value->start }}").fromNow();
						document.write(time);
						</script>
					</small>
				</p>
			</div>
			<a href="edithref" class="fa fa-edit fa-fw fa-2x edit-btn" data-apptID="{{ $value->appt_id }}" title="Edit Meeting"><div class="hide-text">Edit Meeting</div></a>
			<!-- <div class="edit-btn" style="display: block; background: red; width: 50px; height: 50px;"></div> -->
		</div>
	</li>
	<?php $i++; ?>
	@endforeach
</ul>
@else
@endif
@endif
@endif

<script type="text/javascript">
	function displayTime() {
    // var time = moment().format('HH:mm:ss');
    // var time = moment().format('HH:mm');
    var time = moment().calendar();
    $('#clock').html(time);
    setTimeout(displayTime, 1000);
}
 
$(document).ready(function() {
    displayTime();
});
</script>

@stop
