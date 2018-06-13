<div class="dialer">
    <style>
        #leadform .form-body .form-group {
          margin-bottom: 27px;
        }
    </style>
    <div id="slidebottom" class="slide">
        <div class="inner">
            <a id="menu-phone-icon1"><i class="fa fa-th fa-2" aria-hidden="true"></i></a>
            <form id="callcontainer" onsubmit="javascript:return false;">
                <input type="text" name="to" value="" class="form-control" id="to" placeholder="Phone number" autocomplete="off">
                <a id="make_call" data-attr-call="call" onclick="call();"><i class="fa fa-phone"></i></a>
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
            <div class="toggle_call"><a href="javascript:;" class="btn">Minimize</a></div>
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
                        <h2 class="user-name">Doe, John</h2>
                        <p id="callnumber" class="user-number">555-555-5555</p>

                        <a class="btn btn-info" href="javascript:void(0)">1</a>
                        <a class="btn btn-info" href="javascript:void(0)">2</a>
                        <a class="btn btn-info" href="javascript:void(0)">3</a>
                        <br/>
                        <a class="btn btn-info" href="javascript:void(0)">4</a>
                        <a class=" btn btn-info" href="javascript:void(0)">5</a>
                        <a class="btn btn-info" href="javascript:void(0)">6</a>
                        <br/>
                        <a class="btn btn-info" href="javascript:void(0)">7</a>
                        <a class="btn btn-info" href="javascript:void(0)">8</a>
                        <a class="btn btn-info" href="javascript:void(0)">9</a>
                        <br/>
                        <a class="btn btn-info astrik" href="javascript:void(0)" onclick="sipSendDTMF('*');">*</a>
                        <a class="btn btn-info zero" href="javascript:void(0)" onclick="sipSendDTMF('0');">0</a>
                        <a class="btn btn-info has" href="javascript:void(0)" onclick="sipSendDTMF('#');"> #</a>
                        <br/>
                        <div class="incoming" style="display: none">
                            <a  class="btn main-btn btn-success" href="javascript:void(0)">Answer</a>
                            <a  class="btn main-btn btn-danger" href="javascript:void(0)">Reject</a>
                        </div>
                        <div class="outbound">
                            <a href="javascript:void(0)" class="btn btn-info transfer-btn" data-click="0" onclick="transferAction();"><div class="main-btn btn-danger"><i class="fa fa-plus" aria-hidden="true"></i></div></a>
                            <a href="javascript:void(0)" id="linkMute" class="btn btn-info" onclick="muteMicrophone(true);"><i class="fa fa-microphone-slash"></i><span class="phone_char">Mute</span></a>
                            <a href="javascript:void(0)" id="linkUnmute" class="btn btn-info" onclick="muteMicrophone(false);" style="display: none"><i class="fa fa-microphone"></i><span class="phone_char">Unmute</span></a>
                            <a href="javascript:void(0)" id="hangup_call" class="btn btn-info" onclick="hangup();"><div class="main-btn btn-danger"><i class="fa fa-phone" style="color: red;" aria-hidden="true"></i></div> <span class="phone_char">Hang Up</span></a>
                            <?php /* <a href="javascript:void(0)" id="record" class="btn btn-info" onclick="recordAction('START')"><div class="main-btn btn-danger"><i class="fa fa-play-circle"></i></div> <!--span class="phone_char">Record</span--><span class="phone_char" id="time"></span></a>
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
                                    <span id="lastlbl">Doe</span>&nbsp;<span id="firstlbl">John</span>
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
                if (jQuery('.phone_dialer').css('display') == 'none' && jQuery('#btn-container1').css('display') == 'block') {
                    jQuery('.expand').hide();
                }
                if (jQuery('#btn-container1').css('display') == 'block') {
                    jQuery('.expand').hide();
                }
            });

            var boxWidth = 500;
            $(".expand").click(function () {
                $("#btn-container1").show('slow');
                jQuery('.expand').hide();
            });
            $(".minimize-btn ").click(function () {
                $("#btn-container1").hide('slow');
                jQuery('.expand').show();
            });

        });
        function call() {
            jQuery('.btn_phone').show();
        }
    </script>
</div>