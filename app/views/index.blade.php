<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>TEST</title>
</head>
<body>
<h1>$myMeetings</h1>
@foreach ($myMeetings as $myMeeting)
<ul>
    <li>{{ $myMeeting->id }}</li>
    <li>{{ $myMeeting->appt_start }}</li>
</ul>
@endforeach

<h1>$personalConflict</h1>
{{{$personalConflict}}}

</body>
</html>
