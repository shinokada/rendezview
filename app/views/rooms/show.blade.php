@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get($room->room_name) }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<link href='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.css' rel='stylesheet' />
<link href='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/1.6.4/fullcalendar.min.js'></script>

<style>
#calendar {
	margin: 0 auto;
	padding-bottom: 40px;
	min-height: 500px;
}
</style>
<div class="col-md-12">
	<!-- will be used to show any messages -->
	@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif
	<div class="page-header">
		<h1>{{ $room->room_name }}</h1>
	</div>
	<div id='calendar'></div>
	<!-- Edit Modal -->
	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {

	var source = new Array();
	source[0] = '<?php echo URL::to('cal/approved/' . $room->id) ?>';
	source[1] = '<?php echo URL::to('cal/pending/' . $room->id) ?>';
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	var view = 'agendaWeek';

	//Set  dashToCal if exist
	if (typeof $.cookie('dashToCal') !== 'undefined'){
		date = $.cookie('dashToCal').split(',');
	}
	//init day view on mobile
	if (Modernizr.mq('only screen  and (max-width: 768px)')) {
		var view = 'agendaDay';
	}

	var calendar = $('#calendar').fullCalendar({
		// year: 2012,
		// month: 4,
		// date, 25,
		editable: true,
		header:
		{
			left: 'prev,next today',
			// center: 'title',
			right: ',agendaWeek,agendaDay',
		},
		eventSources: [
			{
				//Approved Appointments
				url: source[0],
				color: '#0074D9',
				textColor: 'black'
			},
			{
				//Pending Approval
				url: source[1],
				color: '#FFDC00',
				textColor: 'black'
			}
		],
		height: 800,
		defaultView: view,
		allDayDefault: false,
		timeFormat: '',
		titleFormat:
		{
			month: 'MMMM yyyy',					// September 2009
			week: "MMM d[ yyyy]{ '&#8212;'[ MMM] d, yyyy}",	// Sep 7 - 13, 2009
			day: 'dddd, MMM d, yyyy'				// Tuesday, Sep 8, 2009
		},
		minTime: 7,
		maxTime: 22,
		allDaySlot: false,
		slotEventOverlap: false,

		eventRender: function(event, element, view) {
			if (event.allDay === 'true') {
				event.allDay = true;
			} else {
				event.allDay = false;
			}
		},
		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			var check = $.fullCalendar.formatDate(start,'yyyy-MM-dd HH:mm:ss');
			var today = $.fullCalendar.formatDate(new Date(),'yyyy-MM-dd HH:mm');
			if(check < today) {
				alert('You cannot add an event to a past date!');
			} else {
				// alert(document.URL);
				var title = prompt('Event Title:');
				if (title) {
				var start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
				var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
				var room_id = <?php echo $room->id ?>;
				$.ajax({
					url: "<?php echo URL::to('cal/add') ?>",
					type: "GET",
					data: { title: title, start: start, end: end, room:  room_id },
					success: function(json) {
						location.reload();
					}
				});
				calendar.fullCalendar('renderEvent',
				{
					title: title,
					start: start,
					end: end,
					allDay: allDay
				},
				true
				);
				}
			}
			calendar.fullCalendar('unselect');
		},
		loading: function (isLoading, view) {
			// alert(isLoading);
			if(!isLoading && $.cookie('dashToCal') ){
				console.log('loading cookie date');
				calendar.fullCalendar( 'changeView', 'agendaDay' );
				calendar.fullCalendar( 'gotoDate', date[0], date[1]-1, date[2] );
				console.log('delete cookie');
				// $.cookie('dashToCal', '');
				$.removeCookie('dashToCal', {path: '/'});
			}
		},
		editable: false,
			eventClick: function(calEvent, jsEvent, view)
			{
				var apptID = calEvent.id,
					// _eventUrl = '//drexel.evan.so/appts/'+apptID+'/edit';
					_eventUrl = '{{ URL::to('appts/') }}/'+apptID+'/edit';

				//modal load content
				$('#edit').empty().load(_eventUrl, function (e) {
					$(this).modal('show');
				});

				$('.modal-backdrop').on('click', function (e) {
					alert(this);
				});
			}
		});
	// $.removeCookie('dashToCal');
});
</script>
@stop
