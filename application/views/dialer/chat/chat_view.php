<div class="chatbox-screen">
    <div class="dialer_header">
        <div class="profile">
            <div class="profile-image">
                <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image" class="lead_img">
            </div>
        </div>
        <div class="profile-content">
            <input type='hidden' class="lead_name" value="<?= $header['lead_name']; ?>">
            <h4 class="leadname"><?php echo $header['lead_name']; ?></h4>
            <p class="leadtype"><?php echo $header['lead_status']; ?></p>
        </div>
        <div class="btn-min">
            <a href="javascript:;" class="min-div" onclick="minimizeChat('chatbox-screen', this)"><img src="<?php echo site_url(); ?>assets/images/min.png"/></a>
            <a href="javascript:;" onclick="chatwindow('zoomOut')"><img src="<?php echo site_url(); ?>assets/images/close-icon.png"/></a>
        </div>
    </div>
    <div class="dialer_body">
        <div class="chat-box">
            <div id="chat-box-listing" class="chat-box-listing">
                <ul id="chat_ul" class="chat_ul scroller" data-bind="foreach: chat"> 
                    <li class="left-msg" data-bind="if:inbound">
                        <div class="chat-profile-img">
                            <div class="profile-image">
                                <img src="" alt="user_image" data-bind="attr:{ src : chat_image}">
                            </div>
                        </div>
                        <div class="chat-content">
                            <p data-bind="text:chat_msg"></p>
                        </div>
                    </li>
                    <li class="right-msg" data-bind="if:outbound">
                        <div class="chat-content">
                            <p data-bind="text:chat_msg"></p>
                        </div>
                        <div class="chat-profile-img">
                            <div class="profile-image">
                                <img src="" alt="user_image" data-bind="attr:{ src : chat_image}">
                            </div>
                        </div>
                    </li>
                </ul>    
            </div>
            <div class="msg_type_input">
                <input type="text" id="chat_text" class="form-control text-value" placeholder="Type text here to be sent to client" onkeyup="charater_limition('text-value')" style="padding-right: :50px;"/>
                <a href="javascript:;" id="chatbtn" class="send-btn" onclick="send_chatbox()"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <div class="dialer_footer">
        <div class="call-ui-wrapper">
            <div class="call-ui-footer phone-dialer dialer3">
                <div class="call-out">
                    <div class="call-out-icon">
                        <a href="javascript:;">
                            <img src="<?php echo site_url() ?>assets/images/call-out.svg" alt="dialer_icon">
                        </a>
                    </div>
                </div>
                <div class="dialer-input-div">
                    <input id="chatbox_phonenumber" type="text" class="form-control" placeholder="Phone Number..." value="<?php echo $lead_number; ?>">
                </div>
                <div class="msg-bubbles">
                    <div class="msg-bubbles-icon">
                        <a href="javascript:;">
                            <img src="<?php echo site_url() ?>assets/images/bubbles.svg" alt="dialer_icon">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('.chat_ul.scroller').slimScroll({
   height: '300px',
   start: 'bottom',
});
</script>

