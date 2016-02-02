<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>
		@section('title')
			RendezView
		@show
	</title>

	<!--  Mobile Viewport Fix -->
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />
	<link rel="shortcut icon" href="{{{ asset('favicon.ico') }}}">

	<!-- CSS -->
	{{ HTML::style('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css') }}
	{{ HTML::style('css/datatables.css') }}
	{{ HTML::style('css/footable.core.css') }}
	{{ HTML::style('css/plugins/morris/morris-0.4.3.min.css') }}
	{{ HTML::style('css/plugins/timeline/timeline.css') }}
	{{ HTML::style('css/jquery.mmenu.all.css') }}
	{{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css') }}
	{{ HTML::style('css/style.css') }}

	@yield('styles')

	<!-- Javascripts -->
	{{ HTML::script('//code.jquery.com/jquery-1.11.0.min.js') }}
	{{ HTML::script('js/jquery.modernizr.js') }}
	{{ HTML::script('js/jquery.cookie.js') }}
	{{ HTML::script('js/bootstrap.min.js') }}
	{{ HTML::script('js/jquery.dataTables.min.js') }}
	{{ HTML::script('js/datatables.fnReloadAjax.js') }}
	{{ HTML::script('js/datatables.js') }}
	{{ HTML::script('js/footable.js') }}
	{{ HTML::script('js/footable.filter.js') }}
	{{ HTML::script('js/footable.paginate.js') }}
	{{ HTML::script('js/footable.sort.js') }}
	{{ HTML::script('js/main.js') }}
	{{ HTML::script('js/jquery.mmenu.min.all.js') }}
	<!-- {{ HTML::script('js/pace.min.js') }} -->
	{{ HTML::script('js/plugins/metisMenu/jquery.metisMenu.js') }}
	{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js') }}
	{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/hammer.js/1.0.10/hammer.min.js') }}

	@yield('scripts')

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<style type="text/css">
	.mm-menu li.img a
	{
		font-size: 16px;
	}
	.mm-menu li.img a img
	{
		float: left;
		margin: -5px 10px -5px 0;
	}
	.mm-menu li.img a small
	{
		font-size: 12px;
	}
	</style>
	<script type="text/javascript">

	//	The menu on the left
	$(function() {
		$('nav#menu-left').mmenu();
	});


	//	The menu on the right
	$(function() {

		var $menu = $('nav#menu-right');

		$menu.mmenu({
			position	: 'right',
			// zposition	: 'front',
			classes		: 'mm-light',
			dragOpen	: true,
			counters	: true,
			searchfield	: true,
			labels		: {
				fixed	: !$.mmenu.support.touch
			},
			header		: {
				add	: true,
				update	: true,
				title	: 'Buildings'

			}
		});

		//	Click a menu-item
		var $confirm = $('#confirmation');
		$menu.find( 'li a' ).not( '.mm-subopen' ).not( '.mm-subclose' ).bind(
			'click.example',
			function( e )
			{
				// e.preventDefault();
				$confirm.show().text( 'You clicked "' + $.trim( $(this).text() ) + '"' );
				$('#menu-right').trigger( 'close' );
			}
		);
	});
	</script>
</head>
<body class="rv-login">
	<div id="page">
		<div id="header">
			<a href="#menu-left" class="menu menu-left fa fa-bars fa-fw fa-2x"></a>
			<div class="title">RendezView :: Drexel</div>
			@if (Auth::check())
				<a href="#menu-right" class="menu-right right fa fa-building-o fa-fw fa-2x"></a>
			@endif
		</div>
		<div id="content">
			<!-- <p id="confirmation"></p> -->
			@yield('content')
		</div>
		<nav id="menu-left">
			<div>
				@if (Auth::check())
					<p>Welcome, {{{ Auth::user()->username }}}</p>
					@if (Auth::user()->hasRole('admin'))
						<ul class="List">
							<li {{ (Request::is('admin/user*') ? ' class="selected"' : '') }}>
								<a href="{{{ URL::to('admin/users') }}}"><i class="fa fa-user fa-fw"></i> User Management</a>
							</li>
							<li {{ (Request::is('role*') ? ' class="selected"' : '') }}>
								<a href="{{{ URL::to('admin/roles') }}}"><i class="fa fa-pencil fa-fw"></i> Permissions</a>
							</li>
							<li {{ (Request::is('rooms') ? ' class="active"' : '') }}>
								<a href="{{{ URL::to('rooms') }}}"><i class="fa fa-building-o fa-fw"></i> Rooms</a>
							</li>
							<!-- <a href=""></a> -->
							<!-- <li>
							<em class="Counter">{{ $approvalcount }}</em>
							<a href="#"><i class="fa fa-book fa-fw"></i> Meetings Pending Approval</a>
						</li> -->
					</ul>
				@endif
				<ul class="List">
					<li class="{{ (Request::is('/') ? ' active' : '') }}"><a href="{{{ URL::to('') }}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
					<!-- <li class="{{ (Request::is('/widgets') ? ' active' : '') }}"><a href="{{{ URL::to('widgets') }}}">Widgets</a></li> -->
					<li {{ (Request::is('user*') ? ' class="active"' : '') }}>
						<a href="{{{ URL::to('user') }}}"><i class="fa fa-gear fa-fw"></i> Settings</a>
					</li>
					<li>
						<a href="{{{ URL::to('user/logout') }}}"><i class="fa fa-sign-out fa-fw"></i> Log Out</a>
					</li>
				</ul>
			@else
				<ul class="List">

					<li {{ (Request::is('user/login') ? ' class="active"' : '') }}>
						<a href="{{{ URL::to('user/login') }}}">Login</a>
					</li>
					<li {{ (Request::is('user/register') ? ' class="active"' : '') }}>
						<a href="{{{ URL::to('user/create') }}}">Sign Up</a>
					</li>
				</ul>
			@endif
		</div>
	</nav>
	@if (Auth::check())
		<nav id="menu-right">
			<ul>
				<?php
				$url = $_SERVER['HTTP_HOST'];
				$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
				foreach($myApp->rooms as $k => $v)
				{
					echo "<li>
					<span>$k</span>
					<ul>";
					foreach($v as $v)
					{
						echo "<li>
						<a href=\"$protocol$url/rooms/$v[id]\">
						$v[room_name]<br />
						</a>
						</li>";
					}
					echo "</ul></li>";
				}
				?>
			</ul>
		</nav>
	@endif
</div>
</div>
</body>
</html>
