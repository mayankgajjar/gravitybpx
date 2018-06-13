hideDiv('call-field');
hideDiv('dialer-box');
hideDiv('dialer-chatbox');
//hideDiv('lead-view');
// to hide any div with specify ID in argument
function hideDiv(divId){
	jQuery('#'+divId).hide();
}
// display call fields
function diaplayCallDiv(x){
    jQuery('#call-field').toggle();
}

function showCallDiv(){
    x = 'zommIn';
    jQuery('#call-field').css('display', 'block');
    $('#call-field').removeClass(x).removeClass('animated').addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass(x);
        $(this).removeClass('animated');
    });
}

function hideCalldiv(){
    x = 'zoomOut';
    $('#call-field').removeClass(x).removeClass('animated').addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass(x);
      $(this).removeClass('animated');
      jQuery('#call-field').css('display', 'none');
    });
}
// display chat message window
function diaplayTextDiv(x){
    var status = jQuery('#dialer-chatbox').css('display');
    if(status == 'none'){
        jQuery('#dialer-chatbox').css('display', 'block');
        $('#dialer-chatbox').removeClass(x).removeClass('animated').addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass(x);
          $(this).removeClass('animated');
        });
    }else{
        x = 'zoomOut';
        $('#dialer-chatbox').removeClass(x).removeClass('animated').addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass(x);
          $(this).removeClass('animated');
          jQuery('#dialer-chatbox').css('display', 'none');
        });
    }
}

function webrtcNotSupportedAlert() {
    $('#txtStatus').text("");
    console.log("Your browser doesn't support WebRTC. You need Chrome 25 to use this demo");
}

function isNotEmpty(n) {
    return n.length > 0;
}

function formatUSNumber(n) {
    var dest = n.replace(/-/g, '');
    dest = dest.replace(/ /g, '');
    dest = dest.replace(/\+/g, '');
    dest = dest.replace(/\(/g, '');
    dest = dest.replace(/\)/g, '');
    if (!isNaN(dest)) {
        n = dest
        if (n.length == 10 && n.substr(0, 1) != "1") {
            n = "1" + n;
        }
    }
    return n;
}

function replaceAll(txt, replace, with_this) {
    return txt.replace(new RegExp(replace, 'g'),with_this);
}

function initUI() {
    //callbox
    $('#callcontainer').hide();
    $('#btn-container').hide();
    $('#status_txt').text('Waiting login');
    $('#login_box').show();
    $('#logout_box').hide();
}

function callUI() {
    //show outbound call UI
    dialpadHide();
    clearField();
    hideCalldiv();
    jQuery('.dialer-icon').show();
    //$('#incoming_callbox').hide('slow');
    //$('#callcontainer').show();
    //$('#status_txt').text('Ready');
    //$('#make_call').text('Call');
}

function IncomingCallUI() {
    //show incoming call UI
    $('#status_txt').text('Incoming Call');
    $('#callcontainer').hide();
    $('#incoming_callbox').show('slow');
}

function callAnsweredUI() {
    //$('#incoming_callbox').hide('slow');
    //$('#callcontainer').hide();
    dialpadShow();
}

function onReady() {
    console.log("onReady...");
   // $('#status_txt').text('Login');
  //  $('#login_box').show();
  login(plivoUsername, plivoPassword);
}

function login(username, password) {
    var conn = Plivo.conn.login(username, password);
}

function logout() {
    Plivo.conn.logout();
}

function onLogin() {
    console.log('Logged In');
    jQuery('.dialer-icon').removeClass('dialer-dis');
    jQuery('.dialer-icon').addClass('dialer-ena');
    // $('#status_txt').text('Logged in');
    // $('#login_box').hide();
    // $('#logout_box').show();
    // $('#callcontainer').show();
}

function onLoginFailed() {
    console.log('Login Failed');
    //$('#status_txt').text("Login Failed");
}

function onLogout() {
    initUI();
}

function onCalling() {
    console.log("onCalling");
    //$('#status_txt').text('Connecting....');
}

function onCallRemoteRinging() {
    console.log('Ringing...')
    Command: toastr['success']('<i>Ringing</i>');
    //$('#status_txt').text('Ringing..');
}

function onCallAnswered() {
    console.log('onCallAnswered');
    callAnsweredUI();
    searchLead(jQuery('#phone_num').val());
    //$('#status_txt').text('Call Answered');
}

function onCallTerminated() {
    console.log("onCallTerminated");
    Command: toastr['error']('<i>Call Terminated:</i>');
    //hangup();
}

function onCallFailed(cause) {
    console.log("onCallFailed:"+cause);
    Command: toastr['error']('<i>Call Failed:'+cause+'</i>');
    callUI();
    //$('#status_txt').text("Call Failed:"+cause);
}

//function call() {
//    var dest = jQuery('#phone_num').val();
//    if (isNotEmpty(dest) && dest.length >= 10) {
//        var phoneNum = phone_number_format(dest);
//        dest = '1' + dest;
//        //console.log('Calling...');
//        Command: toastr['success']('<i>Calling..</i>');
//        var extraHeaders = {
//           'X-PH-Number': dest,
//           'X-PH-Agent': agentId,
//           'X-PH-Caller' : formatUSNumber(phoneNumber),
//        }
//        jQuery('#dpad-phone').val(phoneNum);
//        Plivo.conn.call(dest, extraHeaders);
//    }else{
//        Command: toastr['error']('<i>Invalid Destination.</i>');
//    }
//}
function call() {
    var dest = jQuery('#phone_num').val();
    var rawDest = dest;
    if (isNotEmpty(dest) && dest.length === 10) {
        var phoneNum = phone_number_format(dest);
        dest = '1' + dest;
        console.log('Calling...');
        console.log(dest);
        Command: toastr['success']('<i>Calling..</i>');
        var extraHeaders = {
            'X-PH-Number': dest,
            'X-PH-Agent': agentId,
            'X-PH-Caller': formatUSNumber(phoneNumber),
            'X-PH-Type': 'outbound',
            'X-PH-Live': liveAgentId,            
        }
        jQuery('#dpad-phone').val(phoneNum);
        Plivo.conn.call(dest, extraHeaders);

    } else if (isNotEmpty(dest) && dest.length === 12) {
        var phoneNum = phone_number_format(dest);
        console.log(dest);
        Command: toastr['success']('<i>Calling..</i>');
        var extraHeaders = {
            'X-PH-Number': dest,
            'X-PH-Agent': agentId,
            'X-PH-Caller': formatUSNumber(phoneNumber),
            'X-PH-Type': 'outbound',
            'X-PH-Live': liveAgentId,
        }
        jQuery('#dpad-phone').val(phoneNum);
        Plivo.conn.call(dest, extraHeaders);

    } else {
        Command: toastr['error']('<i>Invalid Destination.</i>');
    }
}

function hangup() {
    console.log('Hanging up..');
    Command: toastr['success']('<i>Hanging up.</i>');
    Plivo.conn.hangup();
    callUI()
}

function dtmf(digit) {
    console.log("send dtmf="+digit);
    Plivo.conn.send_dtmf(digit);
}

function dialpadShow() {
    x = 'zommIn';
    jQuery('#dialer-box').css('display', 'block');
    $('#dialer-box').removeClass(x).removeClass('animated').addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass(x);
      $(this).removeClass('animated');
    });
}

function dialpadHide() {
    //$('#btn-container').hide();
    x = 'zoomOut';
    $('#dialer-box').removeClass(x).removeClass('animated').addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass(x);
      $(this).removeClass('animated');
      jQuery('#dialer-box').css('display', 'none');
    });
}

function mute() {
    Plivo.conn.mute();
    $('#linkUnmute').show('slow');
    $('#linkMute').hide('slow');
}

function unmute() {
    Plivo.conn.unmute();
    $('#linkUnmute').hide('slow');
    $('#linkMute').show('slow');
}

function onIncomingCall(account_name, extraHeaders) {
    console.log("onIncomingCall:"+account_name);
    console.log("extraHeaders=");
    for (var key in extraHeaders) {
        console.log("key="+key+".val="+extraHeaders[key]);
    }
    IncomingCallUI();
}

function onIncomingCallCanceled() {
    callUI();
}

function  onMediaPermission (result) {
    if (result) {
        console.log("get media permission");
    } else {
        console.log("you don't allow media permission, you will can't make a call until you allow it");
    }
}

function answer() {
    console.log("answering")
    $('#status_txt').text('Answering....');
    Plivo.conn.answer();
    callAnsweredUI()
}

function reject() {
    callUI()
    Plivo.conn.reject();
}

disable_alter_custphone = 'SHOW';
vdc_header_phone_format = 'US_DASH 000-000-0000';
function phone_number_format(formatphone) {
    // customer_local_time, status date display 9999999999
    //  vdc_header_phone_format
    //  US_DASH 000-000-0000 - USA dash separated phone number<br />
    //  US_PARN (000)000-0000 - USA dash separated number with area code in parenthesis<br />
    //  UK_DASH 00 0000-0000 - UK dash separated phone number with space after city code<br />
    //  AU_SPAC 000 000 000 - Australia space separated phone number<br />
    //  IT_DASH 0000-000-000 - Italy dash separated phone number<br />
    //  FR_SPAC 00 00 00 00 00 - France space separated phone number<br />
    var regUS_DASHphone = new RegExp("US_DASH", "g");
    var regUS_PARNphone = new RegExp("US_PARN", "g");
    var regUK_DASHphone = new RegExp("UK_DASH", "g");
    var regAU_SPACphone = new RegExp("AU_SPAC", "g");
    var regIT_DASHphone = new RegExp("IT_DASH", "g");
    var regFR_SPACphone = new RegExp("FR_SPAC", "g");
    var status_display_number = formatphone;
    var dispnum = formatphone;
    if (disable_alter_custphone == 'HIDE') {
        var status_display_number = 'XXXXXXXXXX';
        var dispnum = 'XXXXXXXXXX';
    }
    if (vdc_header_phone_format.match(regUS_DASHphone)) {
        var status_display_number = dispnum.substring(0, 3) + '-' + dispnum.substring(3, 6) + '-' + dispnum.substring(6, 10);
    }
    if (vdc_header_phone_format.match(regUS_PARNphone)) {
        var status_display_number = '(' + dispnum.substring(0, 3) + ')' + dispnum.substring(3, 6) + '-' + dispnum.substring(6, 10);
    }
    if (vdc_header_phone_format.match(regUK_DASHphone)) {
        var status_display_number = dispnum.substring(0, 2) + ' ' + dispnum.substring(2, 6) + '-' + dispnum.substring(6, 10);
    }
    if (vdc_header_phone_format.match(regAU_SPACphone)) {
        var status_display_number = dispnum.substring(0, 3) + ' ' + dispnum.substring(3, 6) + ' ' + dispnum.substring(6, 9);
    }
    if (vdc_header_phone_format.match(regIT_DASHphone)) {
        var status_display_number = dispnum.substring(0, 4) + '-' + dispnum.substring(4, 7) + '-' + dispnum.substring(8, 10);
    }
    if (vdc_header_phone_format.match(regFR_SPACphone)) {
        var status_display_number = dispnum.substring(0, 2) + ' ' + dispnum.substring(2, 4) + ' ' + dispnum.substring(4, 6) + ' ' + dispnum.substring(6, 8) + ' ' + dispnum.substring(8, 10);
    }

    return status_display_number;
}

function minimizeDiv(div, id){
    jQuery('.'+div).slideToggle('slow');
    jQuery('#'+id +' > .toggle-icon-bar > a > img').toggleClass('toggle-icon');
}

function searchLead(phone){
    var postData = {
        is_ajax : true,
        phone : phone,
        agent : agentId
    };

    jQuery.ajax({
        url : siteUrl + 'dialhelp/searchLead',
        method : 'post',
        dataType : 'json',
        data : postData,
        success : function(result){
            pushFields(result.lead);
        }
    });
}
function pushFields(lead){
    if(lead != null){
        var firstName = lead.first_name;
        jQuery('[name="lead_id"]').val(lead.lead_id);
        jQuery('[name="cellno"]').val((lead.phone));
        jQuery('[name="email"]').val(lead.email);
        jQuery('[name="address"]').val(lead.address);
        jQuery('[name="address"]').val(lead.address);
        jQuery('[name="city"]').val(lead.city);
        jQuery('#state').val(lead.state);
        jQuery('[name="zip"]').val(lead.postal_code);
        jQuery('[name="notes"]').val(lead.notes);
        jQuery('[name="called_count"]').val(lead.called_count);
        if(firstName.length <= 0){
            jQuery('.leadname1').html('<input class="form-control" type="text" name="name" placeholder="Firstname Lastname" id="name"/>');
            jQuery('.leadname').html('N/A');
        }else{
            jQuery('.leadname').html(lead.first_name + ' ' +lead.last_name);
            jQuery('.leadname1').html(lead.first_name + ' ' +lead.last_name);
        }
        jQuery('.leadtype').html(lead.status);
    }
}
function clearField(){
    jQuery('[name="lead_id"]').val('');
    jQuery('[name="cellno"]').val();
    jQuery('[name="email"]').val();
    jQuery('[name="address"]').val('');
    jQuery('[name="city"]').val('');
    jQuery('[name="zip"]').val('');
    jQuery('[name="notes"]').val();
    jQuery('.leadname').html('NA');
    jQuery('.leadtype').html('Client');
    jQuery('#phone_num').val('');
}

function leadPop(){
    jQuery('#lead-view').toggle();
}

function closeDialPad(){
    swal({
      title: "Are you sure you want to end this call?",
      text: "",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, hangup it!",
      closeOnConfirm: true
    },
    function(){
      hangup();
    });
}

function saveLead(event){
    event.preventDefault();
    var data = jQuery('#lead-pop-form').serialize();
    data = data + '&is_ajax='+true;

    jQuery.ajax({
        url : siteUrl + 'dialhelp/saveLead',
        method : 'post',
        dataType : 'json',
        data : data,
        success : function(){

        }
    });
}
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


jQuery(function(){
    jQuery(document).on('mouseover','.dialer-ena',function (event) {        
        jQuery('#call-field').hide();
        diaplayCallDiv('zoomIn');
        jQuery(".dialer-icon").hide();
    });
    jQuery("#call-field").clickOff(function () {
        if(jQuery('#call-field').css('display') == 'block'){
            diaplayCallDiv('zoomOut');
            jQuery(".dialer-icon").show();
        }
    });
    jQuery('.call-out-icon').hover( function(){
        jQuery('.dialer1').addClass("light_blue");
      },function(){
        jQuery('.dialer1').removeClass("light_blue");
    });
    jQuery('.msg-bubbles-icon').hover( function(){
      jQuery('.dialer1').addClass("purple");
    },function(){
      jQuery('.dialer1').removeClass("purple");
    });

    /* */
    Plivo.onWebrtcNotSupported = webrtcNotSupportedAlert;
    Plivo.onReady = onReady;
    Plivo.onLogin = onLogin;
    Plivo.onLoginFailed = onLoginFailed;
    Plivo.onLogout = onLogout;
    Plivo.onCalling = onCalling;
    Plivo.onCallRemoteRinging = onCallRemoteRinging;
    Plivo.onCallAnswered = onCallAnswered;
    Plivo.onCallTerminated = onCallTerminated;
    Plivo.onCallFailed = onCallFailed;
    Plivo.onMediaPermission = onMediaPermission;
    Plivo.onIncomingCall = onIncomingCall;
    Plivo.onIncomingCallCanceled = onIncomingCallCanceled;
    Plivo.init();
});

