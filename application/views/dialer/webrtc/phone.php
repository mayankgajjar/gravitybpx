 <!DOCTYPE html>
<html>
<head>
	<title>Video Chat</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
        <!-- favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo site_url() ?>uploads/logo/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo site_url() ?>uploads/logo/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?php echo site_url('assets/theam_assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo site_url('assets/theam_assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?php echo site_url('assets/theam_assets/global/css/components-md.min.css'); ?>" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo site_url('assets/theam_assets/global/css/plugins-md.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?php echo site_url('assets/theam_assets/layouts/layout/css/layout.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo site_url('assets/theam_assets/layouts/layout/css/themes/grey.min.css'); ?>" rel="stylesheet" type="text/css" id="style_color" />
    <link href="<?php echo site_url('assets/theam_assets/layouts/layout/css/custom.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo site_url('assets/theam_assets/pages/css/customcss.css'); ?>" rel="stylesheet" type="text/css" />
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
<div class="page-header navbar navbar-fixed-top">
	<div class="page-header-inner">
		<div class="page-logo">
			<a href="#">
				<img src="https://agencyvue.com/uploads/logo/logo.png" alt="logo" class="logo-default">
			</a>
		</div>
	</div>
</div>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content" style="margin-left: 0px;">
			<div class="portlet" style="box-shadow: none;">
				<div class="text-center portlet-body">
					<form name="loginForm" id="login" action="#" onsubmit="return login(this);" class="form-inline">
						<div class="form-group form-md-line-input has-success">
					    	<input class="form-control" type="text" name="username" id="username" placeholder="Pick a username!" />
					    </div>
				    	<input class="btn btn-primary" type="submit" name="login_submit" value="Log In">
					</form>
				</div>
			</div>
			<div class="portlet" style="box-shadow: none;">
				<div class="text-center portlet-body">
					<form name="callForm" id="call" action="#" onsubmit="return makeCall(this);" class="form-inline">
						<div class="form-group form-md-line-input has-success">
							<input class="form-control" type="text" name="number" placeholder="Enter user to dial!" />
						</div>
						<input class="btn btn-primary" type="submit" value="Call"/>
					</form>
				</div>
			</div>
    		<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
    			<div class="modal-dialog">
    				<div class="modal-content">
	                    <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Video Box</h4>
                        </div>
                        <div class="modal-body">
                        	<div id="vid-box" class=""></div>
                        </div>
                        <div class="modal-footer">
                         	<button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                        </div>
    				</div>
    			</div>
    		</div>
			<!-- <div id="vid-box" class=""></div> -->
		</div>
	</div>
	<div class="page-footer">
		<div class="page-footer-inner">&copy;<?php echo date('Y') ?>&nbsp;<a href="https://agencyvue.com" style="color:white;"><?php echo "agencyvue.com" ?></a></div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.pubnub.com/pubnub.min.js"></script>
<script src="https://cdn.pubnub.com/webrtc/webrtc.js"></script>
<script type="text/javascript">
	var video_out = document.getElementById("vid-box");
	function login(form) {
		var phone = window.phone = PHONE({
		    number        : form.username.value || "Anonymous", // listen on username line else Anonymous
		    publish_key   : 'pub-c-aaa668da-7522-4fc2-8d04-cb0cef095dfa',
		    subscribe_key : 'sub-c-64ca482e-d71d-11e6-bd29-0619f8945a4f',
		    ssl : (('https:' == document.location.protocol) ? true : false)
		});
		phone.ready(function(){
			//form.username.style.background="#55ff5b";
			jQuery("#username").css("background", "#55ff5b")
		});
		phone.receive(function(session){
			console.log(session);
		    session.connected(function(session) {
		    	video_out.appendChild(session.video);
		    	showModal();
		    });
		    session.ended(function(session) { video_out.innerHTML=''; });
		});
		return false; 	// So the form does not submit.
	}
	function makeCall(form){
		if (!window.phone) alert("Login First!");
		else phone.dial(form.number.value);
		return false;
	}
	function hangup(){
		phone.hangup();
	}
	function showModal(){
    	//jQuery("#showModal").click();
    	jQuery('#responsive').modal("show");
	}
</script>
</body>
</html>