$('document').ready(function () {

});
$('.Numbers').keyup(function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});
// setInterval(function () {
//     if ($('.dialer-chatbox-wrapper').css('display') != 'none') {
//         chatUI();
//     }
//     check_new_message();
// }, 6000);
// function chatUI() {
//     var phonenumber = jQuery('#phone_num').val();
//     var postData = {
//         is_ajax: true,
//         phone: '1' + phonenumber,
//         agent: agentId
//     };
//     $.ajax({
//         url: siteUrl + 'smshelp/chat_text',
//         method: 'post',
//         data: postData,
//         success: function (data) {
//             //console.log(data);
//             $('#chat-box-listing').html(data);
//         },
//     });
// }
function minimizeChat(div, id) {
    jQuery('.' + div).slideToggle('slow');
    jQuery('.dialer-chatbox-wrapper').css('display','none');
    var phone_no = $('#chatbox_phonenumber').val();
    var leadname = ($('.lead_name').val()).trim();
    $.ajax({
        type: 'POST',
        url: siteUrl + 'smshelp/fetch_chat_head',
        data: {phone_no: phone_no, leadname: leadname},
        success: function (data) {
            $(".chat-bubble").append(data);
            $("#phone_num").val('');
        }
    });

}
// display chat message window
function chatwindow(x) {
    var status = jQuery('#dialer-chatbox').css('display');
    var phonenumber = jQuery('#phone_num').val();
    if ($('.chat-head').hasClass('phone-' + phonenumber)) {
        $('.phone-' + phonenumber).remove();
        reposition_bubble();
    }
    if (isNotEmpty(phonenumber) && phonenumber.length === 10) {
        phonenumber = '1' + phonenumber;
        if (status == 'none') {
            jQuery('#dialer-chatbox').css('display', 'block');
            $('#dialer-chatbox').removeClass(x).removeClass('animated').addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass(x);
                $(this).removeClass('animated');
            });
            searchLeadSMS(phonenumber)
        } else {
            x = 'zoomOut';
            $('#dialer-chatbox').removeClass(x).removeClass('animated').addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass(x);
                $(this).removeClass('animated');
                jQuery('#dialer-chatbox').css('display', 'none');
            });
        }
    } else {
        Command: toastr['error']('<i>Invalid Destination.</i>');
    }
}
function searchLeadSMS(phone) {
    var postData = {
        is_ajax: true,
        phone: phone,
        agent: agentId
    };

    jQuery.ajax({
        url: siteUrl + 'smshelp/searchHistory',
        method: 'post',
        data: postData,
        success: function (result) {
            jQuery('#chating_view').html(result);
            ko.applyBindings(chatModel, document.getElementById('chat_ul')); 
            fetch_chat_data();
        }
    });
}
function send_chatbox() {
    var phonenumber = jQuery('#phone_num').val();
    var text = jQuery('#chat_text').val();

    if (isNotEmpty(phonenumber) && phonenumber.length === 10 && isNotEmpty(text)) {
        phonenumber = '1' + phonenumber;
        var postData = {
            is_ajax: true,
            to: phonenumber,
            smstext: text
        };
        var fewSeconds = 10;
        jQuery("#chatbtn").css('pointer-events', 'none');
        jQuery("#chatbtn").css('background', '#dedede');
        jQuery.ajax({
            url: siteUrl + 'lead/smspost',
            method: 'post',
            data: postData,
            success: function (result) {
                if (result === 'sms_limt') {
                    Command: toastr['error']("You Can't Send More Then 200 SMS Per Day", 'SMS LIMIT OVER');
                } else if (result === 'SMS Sent Successfully') {
                    Command: toastr['info'](result);
                    searchLeadSMS(phonenumber);
                } else {
                    Command: toastr['error']("Something Went Wrong", "SMS ISSUE!");
                }
                setTimeout(function () {
                    jQuery("#chatbtn").css('pointer-events', 'auto');
                    jQuery("#chatbtn").css('background', '#e5c7f2');
                }, fewSeconds * 1000);
            }
        });
        fetch_chat_data();
    }
}
function charater_limition(classname) {
    var valueText = $('.' + classname).val();
    var maxCount = 159;
    if (valueText.length > maxCount) {
        $('.' + classname).attr('maxlength', '12');
        Command: toastr['error']("<i>You Can't Send Long Text Message !</i>", 'SMS Charecter Limit');

    }
}
// function check_new_message() {
//     var phoneArray = [];
//     $(".chat-head").each(function (key, index) {
//         var phone_no = $(this).data('phone');
//         phoneArray.push('1' + phone_no);
//     });
//     $.ajax({
//         method: 'POST',
//         dataType: 'json',
//         url: siteUrl + 'smshelp/check_new_message',
//         data: {postData: phoneArray},
//         success: function (data) {
//             if (data != '') {
//                 $.each(data, function (key, val) {
//                     $('.phone-' + val).addClass('unseen_msg');
//                 });
//             }
//         }
//     });
// }
