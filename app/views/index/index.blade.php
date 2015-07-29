<!DOCTYPE html>
<!--[if lt IE 7]>	  <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>		 <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>		 <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="stylesheet" href="css/bootstrap.css" type="text/css" media="screen"> -->
	<link rel="stylesheet" href="http://startbootstrap.com/templates/sb-admin-v2/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://startbootstrap.com/templates/sb-admin-v2/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="http://startbootstrap.com/templates/sb-admin-v2/css/sb-admin.css">
	<!-- <link rel="stylesheet" href="css/bootstrap-responsive.min.css" type="text/css" media="screen"> -->
	
</head>
<body>
	<div class="chat-panel panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-comments fa-fw"></i>
			Chat
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-chevron-down"></i>
				</button>
				<ul class="dropdown-menu slidedown">
					<li>
						<a href="#">
							<i class="fa fa-refresh fa-fw"></i> Refresh
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-check-circle fa-fw"></i> Available
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-times fa-fw"></i> Busy
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-clock-o fa-fw"></i> Away
						</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="#">
							<i class="fa fa-sign-out fa-fw"></i> Sign Out
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<ul class="chat">
				<div id="chat-log"></div>
			</ul>
		</div>
		<!-- /.panel-body -->
		<div class="panel-footer">
			<div class="input-group">
				<input id="chat-message" type="text" class="form-control input-sm" placeholder="Type your message here..." />
				<span class="input-group-btn">
					<button class="btn btn-warning btn-sm" id="btn-chat">
						Send
					</button>
				</span>
			</div>
		</div>
		<!-- /.panel-footer -->
	</div>
	<!-- /.panel .chat-panel -->

	<!--@scripts start-->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="js/brain-socket.min.js"></script>
	<script type="text/javascript" charset="utf-8">
	$(function()
	{

		var fake_user_id = Math.floor((Math.random()*1000)+1);

			//make sure to update the port number if your ws server is running on a different one.
			window.app = {};

			app.BrainSocket = new BrainSocket(
				new WebSocket('ws://localhost:8080'),
				new BrainSocketPubSub()
				);

			app.BrainSocket.Event.listen('generic.event',function(msg){
				console.log(msg);
				if(msg.client.data.user_id == fake_user_id)
				{
					$('#chat-log').append(
						'<li class="left clearfix">'+
							'<span class="chat-img pull-left">'+
								'<img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar" class="img-circle" />'+
							'</span>'+
							'<div class="chat-body clearfix">'+
								'<div class="header">'+
									'<strong class="primary-font">Me</strong> '+
									'<small class="pull-right text-muted">'+
									'<!-- <i class="fa fa-clock-o fa-fw"></i> 12 mins ago -->'+
									'</small>'+
								'</div>'+
								'<p>'+
									msg.client.data.message+
								'</p>'+
							'</div>'+
						'</li>'
						);
				}
				else
				{
					$('#chat-log').append(
						'<li class="left clearfix">'+
							'<span class="chat-img pull-left">'+
								'<img src="http://placehold.it/50/FA6F57/fff" alt="User Avatar" class="img-circle" />'+
							'</span>'+
							'<div class="chat-body clearfix">'+
								'<div class="header">'+
									'<strong class="primary-font">Them</strong> '+
									'<small class="pull-right text-muted">'+
									'<!-- <i class="fa fa-clock-o fa-fw"></i> 12 mins ago -->'+
									'</small>'+
								'</div>'+
								'<p>'+
									msg.client.data.message+
								'</p>'+
							'</div>'+
						'</li>'
						);
				}
			});

			app.BrainSocket.Event.listen('app.success',function(data){
				console.log('An app success message was sent from the ws server!');
				console.log(data);
			});

			app.BrainSocket.Event.listen('app.error',function(data){
				console.log('An app error message was sent from the ws server!');
				console.log(data);
			});

			$('#chat-message').keypress(function(event) {

				if(event.keyCode == 13){

					app.BrainSocket.message('generic.event',
					{
						'message':$(this).val(),
						'user_id':fake_user_id
					}
					);
					$(this).val('');

				}

				return event.keyCode != 13; }
				);
		});
</script>
</body>
</html>
