<div class="dialer">
    <?php $this->load->view('dialer/webrtc/agent') ?>
    <div id="slidebottom" class="slide">
        <div class="inner">
            <a id="menu-phone-icon1"><i class="fa fa-th fa-2" aria-hidden="true"></i></a>
            <form id="callcontainer" onsubmit="javascript:return false;">
                <input type="text" name="to" value="" class="form-control" id="to" placeholder="Phone number" autocomplete="off">
                <a id="make_call" data-attr-call="call" onclick="call('call-audio');"><i class="fa fa-phone"></i></a>
                <!--a id="make_call" data-attr-call="call" onclick="call('call-audiovideo');"><i class="fa fa-camera-retro"></i></a-->
            </form>
        </div>
    </div>
    <div class="main_menu-phone-icon" style="display:block">
        <div class="menu-phone-icon">
            <a id="menu-phone-icon">
<!--                <i class="icon-call-out" aria-hidden="true"></i>-->
                <img src="<?php echo site_url() ?>assets/css/image/phone.png" />
            </a>
        </div>
    </div>
    <div id="btn_phone" class="btn_phone" style="display: none">
        <div id="btn-container">
            <div class="toggle_call"><a href="javascript:;" class="btn">Expand</a></div>
            <div class="expand toggle-form"><a href="javascript:;" class="btn">Expand</a></div>
            <div class="phone_dialer">
                <div class="bg-white">
                <div class="caller_detail">
                    <div class="name_image" style="display: none;">
                        <img src="<?php echo site_url() ?>assets/theam_assets/layouts/layout/img/avatar3_small.jpg" class="img-circle" alt="">
                        <div class="caller_name">Test Test</div>
                    </div>
                    <!--div class="caller_number">
                        <input class="form-control caller-number" type="text" id="callnumber" name="call_number" autocomplete="off" />
                    </div-->
                </div><!-- .caller_detail -->
                <div class="countdownright">
                    <!--p class="call-status page-logo" id="MainStatuSSpan" style="font-weight:bold;color:#ED6B75;"></p-->
                    <h2 class="user-name">&nbsp;</h2>
                    <p id="callnumber" class="user-number"></p>

                    <a class="btn btn-info" href="javascript:void(0)" onclick="sipSendDTMF('1');">1</a>
                    <a class="btn btn-info" href="javascript:void(0)" onclick="sipSendDTMF('2');">2</a>
                    <a class="btn btn-info" href="javascript:void(0)" onclick="sipSendDTMF('3');">3</a>
                    <br/>
                    <a class="btn btn-info" href="javascript:void(0)" onclick="sipSendDTMF('4');">4</a>
                    <a class=" btn btn-info" href="javascript:void(0)" onclick="sipSendDTMF('5');">5</a>
                    <a class="btn btn-info" href="javascript:void(0)" onclick="sipSendDTMF('6');">6</a>
                    <br/>
                    <a class="btn btn-info" href="javascript:void(0)" onclick="sipSendDTMF('7');">7</a>
                    <a class="btn btn-info" href="javascript:void(0)" onclick="sipSendDTMF('8');">8</a>
                    <a class="btn btn-info" href="javascript:void(0)" onclick="sipSendDTMF('9');">9</a>
                    <br/>
                    <a class="btn btn-info astrik" href="javascript:void(0)" onclick="sipSendDTMF('*');">*</a>
                    <a class="btn btn-info zero" href="javascript:void(0)" onclick="sipSendDTMF('0');">0</a>
                    <a class="btn btn-info has" href="javascript:void(0)" onclick="sipSendDTMF('#');"> #</a>
                    <br/>
                    <div class="incoming" style="display: none">
                        <a onclick="answer()" class="btn main-btn btn-success" href="javascript:void(0)">Answer</a>
                        <a onclick="reject()" class="btn main-btn btn-danger" href="javascript:void(0)">Reject</a>
                    </div>
                    <div class="outbound">
                        <a href="javascript:void(0)" class="btn btn-info transfer-btn" data-click="0" onclick="transferAction();"><div class="main-btn btn-danger"><i class="fa fa-plus" aria-hidden="true"></i></div></a>
                        <a href="javascript:void(0)" id="linkMute" class="btn btn-info" onclick="muteMicrophone(true);"><i class="fa fa-microphone-slash"></i><span class="phone_char">Mute</span></a>
                        <a href="javascript:void(0)" id="linkUnmute" class="btn btn-info" onclick="muteMicrophone(false);" style="display: none"><i class="fa fa-microphone"></i><span class="phone_char">Unmute</span></a>
                        <a href="javascript:void(0)" id="hangup_call" class="btn btn-info" onclick="hangup();"><div class="main-btn btn-danger"><i class="fa fa-phone" style="color: red;" aria-hidden="true"></i></div> <span class="phone_char">Hang Up</span></a>
                        <?php /*<a href="javascript:void(0)" id="record" class="btn btn-info" onclick="recordAction('START')"><div class="main-btn btn-danger"><i class="fa fa-play-circle"></i></div> <!--span class="phone_char">Record</span--><span class="phone_char" id="time"></span></a>
                        <a href="javascript:void(0)" id="hangup_call" class="btn btn-info" onclick="hangup();"><div class="main-btn btn-danger"><i class="fa fa-phone"></i></div> <span class="phone_char">Hangup</span></a>
                        */ ?>
                        <div class="transfer_call btn green">
                            <a href="javascript:;" id="record" class="btn" onclick="recordAction('START')">
                                <p class="phone_char" id="time"><span></span>00:00:00</p>
                                <!--img src="<?php echo site_url() ?>assets/images/phone-receiver.png"-->
                            </a>
                        </div>
                        <div class="call-record-time">
                            <p><i class="fa fa-cog" aria-hidden="true"></i>
                                <span id="calltimer">00:00:00</span>
                            </p>
<!--                            <div id="countdown"></div>-->
                        </div>
                    </div>
                </div><!-- .countdownright -->
                <!-- btn-container1 -->
                <div id="btn-container1" class="lead-form dialer-form" style="display:none;" >
                    <div class="phone_dialer1">
                        <div class="minimize-btn toggle-form"><a href="javascript:;" class="btn">Minimize</a></div>
                        <div class="bg-white">
                        <div class="dialer-icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                        <div class="dial-name">
                            <span id="lastlbl"></span>&nbsp;<span id="firstlbl"></span>
                        </div>
                        <form class="form-horizontal" method="post" onsubmit="return false;" name="leadform" id="leadform">
                            <input type="hidden" name="lead_id" id="lead_id" />
                            <input type="hidden" name="list_id" id="list_id"/>
                            <input type="hidden" name="called_count" id="called_count"/>
                            <input type="hidden" name="phone_code" value="1" id="phone_code"/>
                            <input type="hidden" name="state" id="state"/>
                            <input type="hidden" name="callserverip" id="callserverip"/>
                            <input type="hidden" name="dispo" id="dispo"/>
                            <input type="hidden" name="filename" id="filename" />
                            <input type="hidden" id="RecorDingFilename" name="RecorDingFilename" />
                            <input type="hidden" id="RecorDID" name="RecorDID"/>
                            <input type="hidden" id="uniqueid" name="uniqueid" />
                            <input type="hidden" id="callchannel" name="callchannel" />
                            <input type="hidden" id="SecondS" name="SecondS" />
                            <input type="hidden" id="uniqueid" name="uniqueid" />

                            <div class="form-body">
                                <div class="form-group mobile">
                                    <label class="col-md-2"><?php echo "Mobile" ?></label>
                                    <div class="col-md-6">
                                        <input type="text" name="phone_number" id="phone_number" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <div class="btn-group">
                                            <button id="leadstatus" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" id="btnGroupVerticalDrop1" aria-expanded="true">
                                                <?php echo 'Status' ?>
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul aria-labelledby="btnGroupVerticalDrop1" role="menu" class="dropdown-menu status-dropdown">
                                                <li>
                                                    <a href="javascript:;" id="lead" onClick="checkLeadStatus('Lead')"> Lead </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" id="client" onClick="checkLeadStatus('Client')"> Client </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group " style="display:none;">
                                    <label class="col-md-2"><?php echo "First Name" ?></label>
                                    <div class="col-md-6">
                                        <input type="text" name="first_name" id="first_name" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <label class="col-md-2"><?php echo "Last Name" ?></label>
                                    <div class="col-md-6">
                                        <input type="text" name="last_name" id="last_name" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group email">
                                    <label class="col-md-2"><?php echo "Email" ?></label>
                                    <div class="col-md-6">
                                        <input type="text" name="email" id="email" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group address">
                                    <label class="col-md-2"><?php echo "Address" ?></label>
                                    <div class="col-md-6">
                                        <input name="address1" class="form-control" id="address1" />
                                        <input name="address2" class="form-control" id="address2" />
                                    </div>
                                </div>
                                <div class="form-group zip">
                                    <label class="col-md-2"><?php echo "zip" ?></label>
                                    <div class="col-md-6">
                                        <input type="text" name="postal_code" class="form-control" id="postal_code"/>
<!--                                            <label class="col-md-2"><?php echo "City" ?></label>-->
                                        <input type="text" name="city" class="form-control" id="city"/>
                                    </div>
                                </div>
                                <div class="form-group notes">
                                    <label class="col-md-2"></label>
                                    <div class="col-md-6">
                                        <span>Quick Notes</span>
                                        <textarea name="comments" class="form-control" id="comments" rows="3"></textarea>
                                        <button type="button" class="save-btn">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                <!-- btn-container1 -->
            </div><!-- .bg-white -->
            </div>
        </div>

    </div>
    <div id="divVideo" class='div-video'>
        <div id="divVideoRemote" style="display: none;" style='border:1px solid #000; height:100%; width:100%'>
            <video class="video" width="100%" height="100%" id="video_remote" autoplay="autoplay" style="opacity: 0;
                   background-color: #000000; -webkit-transition-property: opacity; -webkit-transition-duration: 2s;">
            </video>
        </div>
        <div id="divVideoLocal" style="display: none;" style='border:0px solid #000'>
            <video class="video" width="88px" height="72px" id="video_local" autoplay="autoplay" muted="true" style="opacity: 0;
                   margin-top: -80px; margin-left: 5px; background-color: #000000; -webkit-transition-property: opacity;
                   -webkit-transition-duration: 2s;">
            </video>
        </div>
    </div>
    <audio autoplay="autoplay" id="audio_remote1"> </audio>
    <audio autoplay="autoplay" id="audio_local"> </audio>
    <audio autoplay="autoplay" id="audio_remote"> </audio>
    <audio id="ringtone" loop src="<?php echo site_url() ?>assets/phone/sounds/ringtone.wav"></audio>
    <audio id="ringbacktone" loop src="<?php echo site_url() ?>assets/phone/sounds/ringbacktone.wav"></audio>
    <audio id="dtmfTone" src="<?php echo site_url() ?>assets/phone/sounds/dtmf.wav"></audio>
    <script type="text/javascript">
        /* clickoff jquery */
        $.fn.clickOff = function (callback, selfDestroy) {
            var clicked = false;
            var parent = this;
            var destroy = selfDestroy || true;

            parent.click(function () {
                clicked = true;
            });

            $(document).click(function (event) {
                if (!clicked) {
                    callback(parent, event);
                }
                if (destroy) {
                    //parent.clickOff = function() {};
                    //parent.off("click");
                    //$(document).off("click");
                    //parent.off("clickOff");
                }
                ;
                clicked = false;
            });
        };
        jQuery(function () {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            jQuery('.main_menu-phone-icon').hover(function () {
                jQuery("#slidebottom").show();
                jQuery(".main_menu-phone-icon").hide();
            }); //jQuery('.main_menu-phone-icon').hover(function(){
            jQuery("#slidebottom").clickOff(function () {
                jQuery("#slidebottom").hide();
                jQuery(".main_menu-phone-icon").show();
            }); //jQuery("#slidebottom").clickOff(function() {
            jQuery(".toggle_call a").click(function () {
                jQuery(".phone_dialer").slideToggle();
                jQuery('.expand').toggle();
                if(jQuery('.phone_dialer').css('display') == 'none' && jQuery('#btn-container1').css('display') == 'block'){
                    jQuery('.expand').hide();
                }
                if(jQuery('#btn-container1').css('display') == 'block'){
                    jQuery('.expand').hide();
                }
            });


            jQuery('.page-quick-sidebar-wrapper').find('.page-quick-sidebar-chat-users .media-list > .media').click(function () {
                var attr = jQuery('#transfer_call').attr('data-click');
                if (parseInt(attr) == 1) {
                    if (jQuery(this).hasClass('media-offline') === true) {
                        swal("Oops...", "<?php echo ("Agent is offline."); ?>", "error");
                    } else {
                        var extension = jQuery(this).attr('data-extension');
                        transfer_call(extension);
                    }
                }
            });

            var boxWidth = 500;
            $(".expand").click(function(){
                $("#btn-container1").show('slow');
                jQuery('.expand').hide();
            });
            $(".minimize-btn ").click(function(){
                $("#btn-container1").hide('slow');
                jQuery('.expand').show();
        });

        });
    </script>
    <script type="text/javascript">
        //variables
        var mySipStack;
        var mycallSession;
        var connectCallSession;
        var mychatSession;
        var myregisterSession;
        var flag = '0';
        var timer = null;
        var recStatus;
        var hour = 0;
        var min = 0;
        var sec = 0;
        //Register Variables sipml5
        var myrealm = '173.254.218.90:9680';
        // var myusn = 'cc120';
        var myusn = '<?php echo $this->session->userdata('vicidata') ? $this->session->userdata('vicidata')['phoneObj']->extension : "cc120" ?>';
        var mysipuri = 'sip:<?php echo $this->session->userdata('vicidata') ? $this->session->userdata('vicidata')['phoneObj']->extension : "cc120" ?>@173.254.218.90:9680';
        //var mysipuri = 'sip:cc120@173.254.218.90:9680';
        var mycid = '<?php echo $this->session->userdata('vicidata') ? $this->session->userdata('vicidata')['phoneObj']->extension : "cc120" ?>';
        var mywebsocket = 'wss://173.254.218.90:8089/asterisk/ws';
        var mybreaker = false;
        //var mypwd = 'abc120';
        var mypwd = '<?php echo $this->session->userdata('vicidata') ? $this->session->userdata('vicidata')['phoneObj']->conf_secret : "abc120"; ?>';

        var oConfigCall = {
            audio_remote: document.getElementById('audio_remote'),
            video_local: document.getElementById('video_local'),
            video_remote: document.getElementById('video_remote'),
            events_listener: {events: '*', listener: calllistener}, // optional: '*' means all events
            bandwidth: {audio: undefined, video: undefined},
            video_size: {minWidth: undefined, minHeight: undefined, maxWidth: undefined, maxHeight: undefined},
            sip_caps: [
                {name: '+g.oma.sip-im'},
                {name: '+sip.ice'},
                {name: 'language', value: '\"en,fr\"'}
            ]
        };

        videoLocal = document.getElementById("video_local");
        videoRemote = document.getElementById("video_remote");
        audioRemote = document.getElementById("audio_remote");

        // readyCallback for INIT
        var readyCallback = function (e) {
            console.log('engine is ready');
            //(window.localStorage && window.localStorage.getItem('org.doubango.expert.disable_debug') == "true") ? "error" : "info"
            SIPml.setDebugLevel("error");

            if (SIPml.isInitialized() == 1) {
                console.log('Done to intialize engine.');
                startSipStack();
            } else {
                console.log("Failed to intialized engine.")
            }
        };

        //errorCallback for init
        var errorCallback = function (e) {
            console.log('Failed to intialize the engine: ' + e.message);
        };

        // INIT SIPML5 API
        SIPml.init(readyCallback, errorCallback);


    //Function to Listen the call session events
        function calllistener(e) {
            //Log all events
            tsk_utils_log_info('****call event**** = ' + e.type);
            switch (e.type) {
                //Display in the web page that the call is connecting
                case 'connected':
                case 'connecting':
                {
                    var bConnected = (e.type == 'connected');
                    if (e.session == myregisterSession) {
                        Command: toastr['success'](e.description);
                    } else if (e.type == 'connecting') {
                        Command: toastr['success'](e.description);
                    } else if (e.session == mycallSession) {
                        if (bConnected) {
                            stopRingbackTone();
                            stopRingTone();
                        }
                    }

                    //jQuery('#btn_phone').show();
                    var display = jQuery(".phone_dialer").css('display');
                    if (display == 'none') {
                        jQuery(".phone_dialer").toggle();
                    }
                    changeStatus('incall');
                    break;
                }
                //Display in the browser heh call is finished
                case 'terminated':
                case 'terminating':
                {
                    console.log('***********Ending the CALL!!!!');
                    //jQuery('#countdown').detach();
                    //jQuery('.call-record-time').append('<div id="countdown"></div>');
                    flag = '0';
                    //edited 2014-03-30
                    //if (e.session == mycallSession) {
                    if (e.session == myregisterSession) {
                        console.log('***********Session DUMMY 1 onREG Terminating');
                        // commented on 13 feb 2017
                        //mycallSession = null;
                        //myregisterSession = null;
                        //$("#mycallstatus").html("<i>" + e.description + "</i>");
                       // stopRingbackTone();
                       // stopRingTone();
                        // $("#btnHangup").text('Hangup');
                        //hangup();
                    } else if (e.session == mycallSession) {
                        console.log('*****Session DUMMY 2 OnCALL Terminating');
                        //$("#mycallstatus").html("<i>" + e.description + "</i>");
                        //Not found Toster
                        //Command: toastr['error'](e.description);
                        console.log(e.description);
                        // commented on 13 feb 2017
                       /* mycallSession = null;
                        stopRingbackTone();
                        stopRingTone();
                        hangup();*/
                        connectCall();
                    }
                    jQuery('.main_menu-phone-icon').show();
                    break;
                }
                // future use with video
                case 'm_stream_video_local_added':
                {
                    if (e.session == mycallSession) {
                        console.log('m_stream_video_local_added');
                        //uiVideoDisplayEvent(true, true);
                    }
                    break;
                }
                //future use with video
                case 'm_stream_video_local_removed':
                {
                    if (e.session == mycallSession) {
                        console.log('m_stream_video_local_removed');
                        // uiVideoDisplayEvent(true, false);
                    }
                    break;
                }
                //future use with video
                case 'm_stream_video_remote_added':
                {
                    if (e.session == mycallSession) {
                        console.log('m_stream_video_remote_added');
                        // uiVideoDisplayEvent(false, true);
                    }
                    break;
                }
                //future use with video
                case 'm_stream_video_remote_removed':
                {
                    if (e.session == mycallSession) {
                        console.log('m_stream_video_remote_removed');
                        //uiVideoDisplayEvent(false, false);
                    }
                    break;
                }
                //added media audio todo messaging
                case 'm_stream_audio_local_added':
                case 'm_stream_audio_local_removed':
                case 'm_stream_audio_remote_added':
                case 'm_stream_audio_remote_removed':
                {
                    //stopRingTone();
                    //stopRingbackTone();
                    console.log('m_stream_audio_local_added+m_stream_audio_local_removed+m_stream_audio_remote_added+m_stream_audio_remote_removed');
                    break;
                }
                //If the remote end send us a request with SIPresponse 18X start to ringing
                case 'i_ao_request':
                {
                    var iSipResponseCode = e.getSipResponseCode();
                    console.log('************RESPONSE CODE: iSipResponseCode');
                    if (iSipResponseCode == 180 || iSipResponseCode == 183) {
                        startRingbackTone(); //function to start the ring tone
                        Command: toastr['success']('<i>Remote ringing...</i>');
                    }
                    break;
                }
                // If the remote send early media stop the sounds
                case 'm_early_media':
                {
                    if (e.session == mycallSession) {
                        //jQuery('#countdown').countup();
                        stopRingTone();
                        stopRingbackTone();
                        Command: toastr['success']('<i>Call Answered</i>');
                        if (agentCall == 'YES') {
                            clearView();
                        }
                    }
                    break;
                }
                default:
                {
                    console.log('++++++++++++++++WTF with this received type' + e.type);
                    break;
                }
            }
        }
    //Here we listen stack messages
        function listenerFunc(e) {
            //Log incoming messages
            tsk_utils_log_info('==stack event = ' + e.type);
            switch (e.type) {
                //If failed msg or error Log in console & Web Page
                case 'failed_to_start':
                case 'failed_to_stop':
                case 'stopping':
                case 'stopped':
                {
                    console.log("Failed to connect to SIP SERVER")
                    //Command: toastr['error']("Failed to connect to SIP SERVER.");
                    mycallSession = null;
                    mySipStack = null;
                    myregisterSession = null;
                    //Command: toastr['error']('<i>Disconnected: </i>' + e.description)
                    break;
                }
                //If the msg is 'started' now try to Login to Sip server
                case 'started':
                {
                    console.log("Trying to Login");
                    //Command: toastr['info']("Trying to Login");
                    login();//function to login in sip server
                    break;
                }
                //If the msg 'connected' display the register OK in the web page
                case 'connected':
                {
                    console.log("Registered with Sip Server");
                    //Command: toastr['info']("Registered with Sip Server");
                    connectCall();
                    break;
                }
                //If the msg 'Sent request' display that in the web page---Pattience
                case 'sent_request':
                {
                    console.log(e.description);
                    //Command: toastr['info'](e.description);
                    break;
                }
                //If the msg 'terminated' display that on the web---error maybe?
                case 'terminated':
                {
                    //jQuery("#btnCall").text('Call');
                    //jQuery("#btnHangUp").text('Hangup');
                    jQuery("#incoming_callbox").show();
                    //added
                    //stopRingbackTone();
                    //stopRingTone();
                    //mycallSession = null;
                    console.log('terminated');
                    break;
                }
                //If the msg 'i_new_call' the browser has an incoming call
                case 'i_new_call':
                {
                    //if (mycallSession) {
                    // do not accept the incoming call if we're already 'in call'
                    // e.newSession.hangup(); // comment this line for multi-line support
                    //    console.log("*********************** not accepted");
                    //    Command: toastr['info']("*********************** not accepted")
                    //}else{
                    if (typeof connectCallSession == 'undefined') {
                        mycallSession = e.newSession;
                        mycallSession.setConfiguration(oConfigCall);
                        var sRemoteNumber = (mycallSession.getRemoteFriendlyName() || 'unknown');
                        //Accept the session call
                        mycallSession.accept({
                            audio_remote: document.getElementById('audio_remote'),
                            video_local: document.getElementById('video_local'),
                            video_remote: document.getElementById('video_remote'),
                            events_listener: {events: '*', listener: calllistener}, // optional: '*' means all events
                            bandwidth: {audio: undefined, video: undefined},
                            video_size: {minWidth: undefined, minHeight: undefined, maxWidth: undefined, maxHeight: undefined},
                            sip_caps: [
                                {name: '+g.oma.sip-im'},
                                {name: '+sip.ice'},
                                {name: 'language', value: '\"en,fr\"'}
                            ]
                        });
                        //console.log(connectCallSession);
                        clearView();
                        return true;
                    } else {
                        agentCall = 'NO';
                    }
                    //Change buttons values
                    //jQuery("#btnCall").text('Answer');
                    //jQuery("#btnHangUp").text('Reject');
                    jQuery('#btn_phone').show();
                    //jQuery("#incoming_callbox").show();
                    jQuery('.outbound').hide();
                    jQuery('.incoming').show();
                    //console.log("***********************incoming call");
                    //Command: toastr['info']("***********************incoming call");
                    console.log("***********************incoming call");
                    flag = '1';
                    //mycallSession = e.newSession;
                    //console.log("***********************Start Ringing");
                    /// Command: toastr['info']("***********************Start Ringing");
                    //Start ringing in the browser
                    startRingTone();
                    mycallSession.setConfiguration(oConfigCall);
                    //Display in the web page who is calling
                    var sRemoteNumber = (mycallSession.getRemoteFriendlyName() || 'unknown');
                    jQuery('#callnumber').val(sRemoteNumber);
                    jQuery('#to').val(sRemoteNumber);
                    callLog(sRemoteNumber, 'INCOMING');
                    //$("#mycallstatus").html("<i>Incoming call from [<b>" + sRemoteNumber + "</b>]</i>");
                    Command: toastr['info']("<i>Incoming call from [<b>" + sRemoteNumber + "</b>]</i>");
                    showNotifICall(sRemoteNumber);
                    jQuery('.incoming').show();
                    changeStatus('incall');
                    formManualDial();
                    // }
                    break;
                }
                case 'i_new_message':
                {
                    console.info('++++++++ Receiving SIP SMS +++++++++++++');
                    /*mychatSession = e.newSession;
                     mychatSession.accept();

                     console.info('IMmsg = '+e.getContentString()+' IMtype = '+e.getContentType());
                     //$("#recchat").html($("#recchat").text()+e.getContentString()+"\n");
                     //$('#recchat').scrollTop($('#recchat')[0].scrollHeight);

                     jQuery("#chatarea").html($("#chatarea").html()+"<b>"+e.getContentString()+"</b>");
                     jQuery('#chatarea').scrollTop($('#chatarea')[0].scrollHeight);

                     newmessageTone();
                     //destroy the call session
                     mychatSession.hangup
                     mychatSession = null;*/
                    break;
                }
                case 'm_permission_requested':
                {
                    console.log("m_permission_requested")
                    break;
                }
                case 'm_permission_accepted':
                case 'm_permission_refused':
                {
                    console.log("m_permission_accepted+m_permission_refused")

                    if (agentCall == 'YES') {
                        jQuery('#btn_phone').hide();
                    }
                    if (e.type == 'm_permission_refused') {
                        jQuery('#btn_phone').hide();
                        //jQuery("#btnCall").text('Call');
                        //jQuery("#btnHangUp").text('Hangup');
                        mycallSession = null;
                        stopRingbackTone();
                        stopRingTone();
                        //jQuery("#mysipstatus").html("<i>" + s_description + "</i>");
                        Command: toastr['info']("<i>" + e.description + "</i>");
                    }
                    break;
                }
                case 'starting':
                default:
                    break;
            }
        }
    //function to send the SIP Register
        function login() {
            //Show in the console that the browser is trying to register
            console.log("Registering");

            //create the session
            myregisterSession = mySipStack.newSession('register', {
                events_listener: {events: '*', listener: listenerFunc} // optional: '*' means all events
            });

            //send the register
            myregisterSession.register();
        }
    // function to create the sip stack
        function startSipStack() {
            //show in the console that th browser is trying to create the sip stack
            console.log("attempting to start the SIP STACK with: " + mysipuri + " " + mywebsocket);
            //stack options
            mySipStack = new SIPml.Stack({
                realm: myrealm,
                impi: myusn,
                impu: mysipuri,
                password: mypwd, //optional
                display_name: mycid, //optional
                websocket_proxy_url: mywebsocket, //optional
                //outbound_proxy_url: '', //optional
                ice_servers: [{url: 'stun:stun.l.google.com:19302'}], //optional
                enable_rtcweb_breaker: mybreaker, //optional
                events_listener: {events: '*', listener: listenerFunc}, //optional
                sip_headers: [//optional
                    {name: 'User-Agent', value: 'DM_SIPWEB-UA'},
                    {name: 'Organization', value: 'Digital-Merge'}
                ]
            });
            //If the stack failed show errors in console
            if (mySipStack.start() != 0) {
                //Command: toastr['error']("Failed to start Sip stack.");
                console.log("Failed to start Sip stack.");
            } else {
                //Command: toastr['success']("Started Sip stack.");
                console.log("Started Sip stack.");

            }
        }
        function loginAgent(){
            jQuery.ajax({
                url : '<?php echo site_url('viciagent/login') ?>',
                method : 'post',
                dataType : 'json',
                success : function(result){
                    console.log(result);
                    jQuery('.dialer').prepend(result.content);
                }
            });
        }
        /**
         *
         * @return {[type]} [description]
         */
        function call(calltype) {
            if (typeof calltype == undefined) {
                calltype = 'call-audio';
            }

            jQuery('#slidebottom').hide();
            if (flag == '0' && mySipStack && jQuery("#to").val() != '') {
                clearForm();
                var $number = jQuery('#to').val();
                jQuery('#callnumber').val($number);
                //create the session to call
                <?php if ($this->session->userdata('vicidata')): ?>
                   checkPhoneNumber($number);
                    if (phoneError == false) {
                        return false;
                    }
                   formManualDial();
                    if (phoneError == false) {
                        return false;
                    }
                <?php endif; ?>
                /*mycallSession = mySipStack.newSession(calltype, {
                    audio_remote: document.getElementById('audio_remote'),
                    video_local: document.getElementById('video_local'),
                    video_remote: document.getElementById('video_remote'),
                    events_listener: {events: '*', listener: calllistener}, // optional: '*' means all events
                    bandwidth: {audio: undefined, video: undefined},
                    video_size: {minWidth: undefined, minHeight: undefined, maxWidth: undefined, maxHeight: undefined},
                    sip_caps: [
                        {name: '+g.oma.sip-im'},
                        {name: '+sip.ice'},
                        {name: 'language', value: '\"en,fr\"'}
                    ]
                });
               mycallSession.call(jQuery("#to").val());*/

                jQuery('#btn_phone').show();
                jQuery('.outbound').show();
    //        jQuery('.inbound').show();
                callLog(jQuery("#to").val(), 'OUTBOUND');
            } else if (flag == '0' && mySipStack && jQuery("#to").val() == '') {
                var str = 'Please Digit the destination Number';
                swal("Oops...", str, "error");
                jQuery('.main_menu-phone-icon').show();
            }
            if (flag == '1' && mySipStack && mycallSession) {
                //jQuery("#btnHangup").text('Hangup');
                jQuery('.incoming').show();
                jQuery('.outbound').hide();
                stopRingbackTone();
                stopRingTone();
                //Accept the session call
                mycallSession.accept({
                    audio_remote: document.getElementById('audio_remote'),
                    video_local: document.getElementById('video_local'),
                    video_remote: document.getElementById('video_remote'),
                    events_listener: {events: '*', listener: calllistener}, // optional: '*' means all events
                    bandwidth: {audio: undefined, video: undefined},
                    video_size: {minWidth: undefined, minHeight: undefined, maxWidth: undefined, maxHeight: undefined},
                    sip_caps: [
                        {name: '+g.oma.sip-im'},
                        {name: '+sip.ice'},
                        {name: 'language', value: '\"en,fr\"'}
                    ]
                });
                //jQuery('#countdown').countup();
                jQuery('.outbound').show();
                jQuery('.incoming').hide();
            }
            //jQuery('#slidebottom').hide();
        }
    //function to hangup the call
        function hangup() {
            //jQuery('#btn_phone').hide();
            updateLead();
            dialedcall_send_hangup('','','','','YES');
            if (recStatus == 'START') {
                recordAction('STOP');
            }
           /* if (mycallSession) {
                //txtCallStatus.innerHTML = '<i>Terminating the call...</i>';
                Command: toastr['info']("Call Terminated.");

                //jQuery('#btn_phone').hide();
                //jQuery('#to').val('');
                //jQuery('#callnumber').val('');
                //mycallSession.hangup({events_listener: {events: '*', listener: calllistener}});
            }*/
        }

    //Fucntion to send DTMF frames
        function sipSendDTMF(c) {
            if (mycallSession && c) {
                if (mycallSession.dtmf(c) == 0) {
                    var lastn = jQuery("#callnumber").html();
                    $("#callnumber").html(lastn + c);
                    try {
                        dtmfTone.play();
                    } catch (e) {
                    }
                }
            } else {
                var lastn = $("#callnumber").html();
                jQuery("#callnumber").html(lastn + c);
                try {
                    dtmfTone.play();
                } catch (e) {
                }
            }
        }

        function transferAction() {
            jQuery('#responsive2').modal({
                backdrop: 'static',
                keyboard: false
            });
            return;
            var c = jQuery('#transfer_call').attr('data-click');
            if (parseInt(c) === 0) {
                jQuery('#transfer_call').attr('data-click', '1');
            } else {
                jQuery('#transfer_call').attr('data-click', '0');
            }
            jQuery('.dropdown-toggle').trigger('click');
            if (jQuery('.page-quick-sidebar-wrapper').find('.page-quick-sidebar-chat-users .media-list').hasClass('tcall') == true) {
                jQuery('.page-quick-sidebar-wrapper').find('.page-quick-sidebar-chat-users .media-list').removeClass('tcall');
            } else {
                jQuery('.page-quick-sidebar-wrapper').find('.page-quick-sidebar-chat-users .media-list').addClass('tcall');
            }

            if (jQuery('body').hasClass('page-quick-sidebar-open') == true) {
                Command: toastr['info']("Select agent to transfer.");
            }
        }

        function transfer_call(extension) {
            if (mycallSession) {
                //var s_destination = prompt('Enter destination number', '');
                var s_destination = extension;
                if (!tsk_string_is_null_or_empty(s_destination)) {
                    //btnTransfer.disabled = true;
                    if (mycallSession.transfer(s_destination) != 0) {
                        //Command: toastr['error']("Call transfer failed.")
                        //btnTransfer.disabled = false;
                        return;
                    }
                    //txtCallStatus.innerHTML = '<i>Transfering the call...</i>';
                    //Command: toastr['error']("Transfering the call...");
                    jQuery('.page-quick-sidebar-wrapper').find('.page-quick-sidebar-chat-users .media-list').removeClass('tcall');
                }
            }
        }

        function showNotifICall(s_number) {
            // permission already asked when we registered
            // if (!("Notification" in window)) {
            //        alert("This browser does not support desktop notification");
            //  }
            if (Notification.permission === "granted") {
                /*if (mycallSession) {
                 mycallSession.cancel();
                 }*/
                var notification = new Notification('Incoming call from ' + s_number);
                //mycallSession.onclose = function () { mycallSession = null; };
                //mycallSession.show();
            }else if (Notification.permission !== 'denied') {
                Notification.requestPermission(function (permission) {
                    // If the user accepts, let's create a notification
                    if (permission === "granted") {
                        var notification = new Notification("Incoming call from " + s_number);
                    }
                });
            }
        }
        function answer() {
            call();
        }
        function reject() {
            hangup();
            jQuery('.incoming').hide();
        }
        function recordAction(action) {
            var rAction;
            if (action == 'START') {
                jQuery('#record').attr('onclick', "recordAction('STOP')");
                jQuery('#record i').attr('class', 'fa fa-pause');
                //jQuery('#record .phone_char').html('Pause');
                timer = setInterval(recordTimer, 1000);
                recStatus = 'START';
                rAction = 'MonitorConf';
            } else if (action == 'STOP') {
                jQuery('#record').attr('onclick', "recordAction('START')");
                jQuery('#record i').attr('class', 'fa fa-play');
                //jQuery('#record .phone_char').html('Record');
                clearInterval(timer);
                var time = checkTime('0') + ':' + checkTime('0') + ':' + checkTime('0');
                document.getElementById('time').innerHTML = '<span class="stop"></span>'+time;
                sec = 0;
                min = 0;
                hour = 0;
                recStatus = 'STOP';
                rAction = 'StopMonitorConf';
            }
            recordingApi(rAction);
        }

        function recordTimer() {
            if (sec == 60) {
                sec = 0;
                min++;
            }
            if (min == 59) {
                hour++;
                min = 0;
            }
            var time = checkTime(hour) + ':' + checkTime(min) + ':' + checkTime(sec);
            sec++;
            document.getElementById('time').innerHTML = '<span class="start"></span>' + time;
        }
        var csec = 0;
        var cmin = 0;
        var chour = 0;
        function callTimer() {
            if (csec == 60) {
                csec = 0;
                cmin++;
            }
            if (cmin == 59) {
                chour++;
                cmin = 0;
            }
            var time = checkTime(chour) + ':' + checkTime(cmin) + ':' + checkTime(csec);
            csec++;
            document.getElementById('calltimer').innerHTML = time;
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }
            ;  // add zero in front of numbers < 10
            return i;
        }
        function muteMicrophone(bEnabled) {
            var invbEnabled;
            if (bEnabled) {
                invbEnabled = false;
            } else {
                invbEnabled = true;
            }
            console.log("-->>>> muteMicrophone=" + invbEnabled);
            if (mycallSession != null) {
                console.log("-->>>> muteMicrophone-> mycallSession is valid");
                if (mycallSession.o_session != null) {
                    console.log("-->>>> muteMicrophone-> mycallSession.o_session is valid");
                    if (mycallSession.o_session.o_stream_local != null) {
                        console.log("-->>>> muteMicrophone-> mycallSession.o_session.o_stream_local is valid");
                        if (mycallSession.o_session.o_stream_local.getAudioTracks().length > 0) {
                            console.log("-->>>> muteMicrophone-> mycallSession.o_session.o_stream_local->Audio Tracks Greater than 0");
                            for (var nTrack = 0; nTrack < mycallSession.o_session.o_stream_local.getAudioTracks().length; nTrack++) {
                                console.log("-->>>> muteMicrophone-> Setting Audio Tracks [" + nTrack + "] to state = " + invbEnabled);
                                mycallSession.o_session.o_stream_local.getAudioTracks()[nTrack].enabled = invbEnabled;
                            }
                        } else {
                            console.log("-->>>> muteMicrophone-> mycallSession.o_session.o_stream_local-> NO AUDIO TRACKS");
                        }
                    } else {
                        console.log("-->>>> muteMicrophone-> mycallSession.o_session.o_stream_local is NULL");
                    }
                } else {
                    console.log("-->>>> muteMicrophone-> mycallSession.o_session is NULL");
                }
            } else {
                console.log("-->>>> muteMicrophone-> mycallSession  is NULL");
            }
        }
        /**************** fucntion to play sounds ***************rca****/
        function startRingTone() {
            try {
                ringtone.play();
            } catch (e) {
            }
        }
        function stopRingTone() {
            try {
                ringtone.pause();
            } catch (e) {
            }
        }
        function startRingbackTone() {
            try {
                ringbacktone.play();
            } catch (e) {
            }
        }
        function stopRingbackTone() {
            try {
                ringbacktone.pause();
            } catch (e) {
            }
        }
        function newmessageTone() {
            try {
                newmsg.play();
            } catch (e) {
            }
        }
        function handleKeyPress(e) {
            var key = e.keyCode || e.which;
            if (key == 13) {
                sendIM();
            }
        }
        /* call log */
        function callLog(number, status) {
            jQuery.ajax({
                url: '<?php echo site_url('dialer/phonel/addlog') ?>',
                method: 'POST',
                dataType: 'json',
                data: {'phone_number': number, 'type': status, extension: '<?php echo 'SIP/' . isset($this->session->userdata('vicidata')['phoneObj']) ? $this->session->userdata('vicidata')['phoneObj']->extension : '' ?>', agent_id: '<?php echo $this->session->userdata('agent')->id ?>', vicidial_user: '<?php echo $this->session->userdata('vicidata')['user'] ?>', 'ajax': true},
                success: function (result) {
                    console.log(result);
                }
            });
        }
        function uiVideoDisplayEvent(b_local, b_added) {
            var o_elt_video = b_local ? videoLocal : videoRemote;

            if (b_added) {
                if (SIPml.isWebRtc4AllSupported()) {
                    if (b_local) {
                        if (window.__o_display_local)
                            window.__o_display_local.style.visibility = "visible";
                    } else {
                        if (window.__o_display_remote)
                            window.__o_display_remote.style.visibility = "visible";
                    }

                } else {
                    o_elt_video.style.opacity = 1;
                }
                uiVideoDisplayShowHide(true);
            } else {
                if (SIPml.isWebRtc4AllSupported()) {
                    if (b_local) {
                        if (window.__o_display_local)
                            window.__o_display_local.style.visibility = "hidden";
                    } else {
                        if (window.__o_display_remote)
                            window.__o_display_remote.style.visibility = "hidden";
                    }
                } else {
                    o_elt_video.style.opacity = 0;
                }
                fullScreen(false);
            }
        }

        function showDiv(classname){
            jQuery('.'+classname).show();
        }
        function hideDiv(classname){
            jQuery('.'+classname).hide();
        }
    </script>
</div>