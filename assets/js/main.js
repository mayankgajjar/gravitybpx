$('document').ready(function ()
{
    $.ajax({
        type: 'POST',
        url: siteUrl + 'Checker/statuscheker',
        dataType: "json",
        async: false,
        success: function (result) {
            if (result.message = true) {
                changeStatus(result.status.toLowerCase(), false)
            } else if (result.message = false) {
                console.log('Status Update ERROR!');
                jQuery('.plivo-status').html('Pause');
                jQuery('.plivo-status-icon').html('<i class="fa fa-square status-busy"></i>');
            } else {
                swal('Something Went Wrong In Status Change!');
            }
        }

    });
    $('[data-toggle="tooltip"]').tooltip();
    $('.a-tooltip').tooltip();
    if (typeof Notification.requestPermission() != 'undefined') {
        Notification.requestPermission().then(function (result) {
            if (result === 'denied') {
                console.log('Permission wasn\'t granted. Allow a retry.');
                return;
            }
            if (result === 'default') {
                console.log('The permission request was dismissed.');
                return;
            }
            // Do something with the granted permission.
        });
    }
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        var width = $(window).width();
        if (!(width <= 980)) {
            if (scroll > 50) {
                jQuery('.nav-logo').show();
                //jQuery('.page-header .navbar .fixed .navbar-nav > li.open').find('ul.dropdown-menu').addClass('fixed-open');
                $(".nav-collapse").addClass("fixed");
                $(".nav-collapse").removeClass("static");
            } else {
                jQuery('.nav-logo').hide();
                //jQuery('.page-header .navbar .fixed .navbar-nav > li.open').find('ul.dropdown-menu').removeClass('fixed-open');
                $(".nav-collapse").removeClass("fixed");
                $(".nav-collapse").addClass("static");
            }
        }
    });

    // $('.notifications1,.notifications2,.notifications3').html('');
    // $('span.badge.badge-default.alert_notification1,span.badge.badge-default.alert_notification2,span.badge.badge-default.alert_notification3').html();
    // $('span.pending_notifications1,span.pending_notifications2,span.pending_notifications3').html("0 pending");
    // if (agent_type == 2)
    // {
    //     var url = siteUrl + "notifications/verification_agent_customer_notifications";
    //     $.ajax({
    //         url: url,
    //         success: function (status)
    //         {
    //             var data = $.parseJSON(status);
    //             if (data != "")
    //             {
    //                 $('.notifications2').html('');
    //                 $('.notifications2').html(data.return_string);
    //                 $('span.badge.alert_notification2').html(data.count_customers_notification);
    //                 $('span.pending_notifications2').html(data.count_customers_notification + " pending");
    //             }
    //         }
    //     });
    //     $(document).on('click', '.verification_success', function (event)
    //     {
    //         var id = $(this).attr('id');
    //         var url = siteUrl + "notifications/verification_agent_customer_notifications_read" + '/' + id;
    //         $.ajax({
    //             url: url,
    //             success: function (status)
    //             {
    //                 var data = $.parseJSON(status);
    //                 if (data != "")
    //                 {
    //                     $('.notifications2').html('');
    //                     $('.notifications2').html(data.return_string);
    //                     $('span.badge.alert_notification2').html(data.count_customers_notification);
    //                     $('span.pending_notifications2').html(data.count_customers_notification + " pending");
    //                 }
    //             }
    //         });
    //     });
    //     setInterval(function ()
    //     {
    //         var url = siteUrl + "notifications/verification_agent_customer_notifications";
    //         $.ajax({
    //             url: url,
    //             success: function (status)
    //             {
    //                 var data = $.parseJSON(status);
    //                 if (data.count_customers_notification != 0)
    //                 {
    //                     $('.notifications2').html('');
    //                     $('.notifications2').html(data.return_string);
    //                     $('span.badge.alert_notification2').html(data.count_customers_notification);
    //                     $('span.pending_notifications2').html(data.count_customers_notification + " pending");
    //                     var customer_ids = [];
    //                     $(".notifications2 li a").each(function (index)
    //                     {
    //                         if ($(this).attr('display') != "displayed")
    //                         {
    //                             customer_ids.push($(this).attr('id'));
    //                             var name = $(this).find('.details').text();
    //                             var str = data.notifications_message_content;
    //                             var notifications_message_content = str.replace("%name%", name);
    //                             Command: toastr["info"](notifications_message_content, data.notifications_message_title);
    //                         }
    //                     });
    //                     if (customer_ids.length != 0)
    //                     {
    //                         var url1 = siteUrl + "notifications/verification_agent_customer_notifications_display";
    //                         $.ajax({
    //                             url: url1,
    //                             method: 'post',
    //                             data: {customer_ids: customer_ids},
    //                             success: function (status)
    //                             {

    //                             }
    //                         });
    //                     }
    //                 }
    //             }
    //         });
    //     }, 30000);
    // } else if (agent_type == 1)
    // {
    //     var url = siteUrl + "notifications/sales_agent_customer_notifications";
    //     $.ajax({
    //         url: url,
    //         success: function (status)
    //         {
    //             var data = $.parseJSON(status);
    //             if (data != "")
    //             {
    //                 $('.notifications1').html('');
    //                 $('.notifications1').html(data.return_string);
    //                 $('span.alert_notification1').html(data.count_customers_notification);
    //                 $('span.pending_notifications1').html(data.count_customers_notification + " pending");
    //             }
    //         }
    //     });
    //     $(document).on('click', '.sales_success', function (event)
    //     {
    //         var id = $(this).attr('id');
    //         var url = siteUrl + "notifications/sales_agent_customer_notifications_read" + '/' + id;
    //         $.ajax({
    //             url: url,
    //             success: function (status)
    //             {
    //                 var data = $.parseJSON(status);
    //                 if (data != "")
    //                 {
    //                     $('.notifications1').html('');
    //                     $('.notifications1').html(data.return_string);
    //                     $('span.alert_notification1').html(data.count_customers_notification);
    //                     $('span.pending_notifications1').html(data.count_customers_notification + " pending");
    //                 }
    //             }
    //         });
    //     });
    //     setInterval(function ()
    //     {
    //         var url = siteUrl + "notifications/sales_agent_customer_notifications";
    //         $.ajax({
    //             url: url,
    //             success: function (status)
    //             {
    //                 var data = $.parseJSON(status);
    //                 if (data.count_customers_notification != 0)
    //                 {
    //                     $('.notifications1').html('');
    //                     $('.notifications1').html(data.return_string);
    //                     $('span.alert_notification1').html(data.count_customers_notification);
    //                     $('span.pending_notifications1').html(data.count_customers_notification + " pending");
    //                     var customer_ids = [];
    //                     $(".notifications1 li a").each(function (index)
    //                     {
    //                         if ($(this).attr('display') != "displayed")
    //                         {
    //                             customer_ids.push($(this).attr('id'));
    //                             var name = $(this).find('.details').text();
    //                             var str = data.notifications_message_content;
    //                             var notifications_message_content = str.replace("%name%", name);
    //                             Command: toastr["info"](notifications_message_content, data.notifications_message_title);
    //                         }
    //                     });
    //                     if (customer_ids.length != 0)
    //                     {
    //                         var url1 = siteUrl + "notifications/sales_agent_customer_notifications_display";
    //                         $.ajax({
    //                             url: url1,
    //                             method: 'post',
    //                             data: {customer_ids: customer_ids},
    //                             success: function (status)
    //                             {

    //                             }
    //                         });
    //                     }
    //                 }
    //             }
    //         });
    //     }, 30000);
    // }
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
    }

//     fetch_notification();
});


/*---------------- Desktop Notification --------------- */

//setInterval(function () {
//    var msg = "";
//    $.ajax({
//        url: siteUrl + 'agent/check_notification',
//        datatype: 'json',
//        success: function (data) {
//            $.each(JSON.parse(data), function (key, val) {
//                if (data != "") {
//                    notifyme(val.event_desc);
//                }
//            });
//        },
//    });
//}, 60000);


function notifyme(msg) {
    if (Notification.permission === "granted") {
        var notification = new Notification('Event Reminder', {
            icon: 'http://gravitybpx.com/home/wp-content/uploads/2017/03/logo.png',
            body: msg,
        });
        //mycallSession.onclose = function () { mycallSession = null; };
        //mycallSession.show();
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                var notification = new Notification("Incoming call from 1234");
            }
        });
    }
}
/*---------------- End Desktop Notification --------------- */
/*---------------- Desktop Notification For task --------------- */

//setInterval(function () {
//    var msg = "";
//    $.ajax({
//        url: siteUrl + 'agent/check_task_notification',
//        datatype: 'json',
//        success: function (data) {
//            //console.log(data);
//            $.each(JSON.parse(data), function (key, val) {
//                if (data != "") {
//                    notifymetask(val.task_description);
//                }
//            });
//        },
//    });
//}, 60000);


function notifymetask(msg) {
    if (Notification.permission === "granted") {

        ///var notification = new Notification(msg);
        var notification = new Notification('Task Reminder', {
            icon: siteUrl + 'assets/images/color_logo.png',
            body: msg,
        });
        //mycallSession.onclose = function () { mycallSession = null; };
        //mycallSession.show();
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                var notification = new Notification("Incoming call from 1234");
            }
        });
    }
}
/*---------------- End Desktop Notification For task --------------- */
function changeStatus(status, ajaxIS = true) {
    var actual = '';
    switch (status) {
        case 'ready':
            actual = 'READY'
            jQuery('.plivo-status').html('ONLINE');
            jQuery('.plivo-status-icon').html('<i class="fa fa-check-circle status-online"></i>');
            break;
        case 'incall':
            actual = 'INCALL'
            jQuery('.plivo-status').html('BUSY');
            jQuery('.plivo-status-icon').html('<i class="fa fa-minus-circle status-busy"></i>');
            break;
        case 'dispo':
            actual = 'DISPO'
            jQuery('.plivo-status').html('BUSY');
            jQuery('.plivo-status-icon').html('<i class="fa fa-minus-circle status-busy"></i>');
            break;
        case 'paused':
            actual = 'PAUSED';
            jQuery('.plivo-status').html(actual);
            jQuery('.plivo-status-icon').html('<i class="fa fa-minus-circle status-busy"></i>');
            break;
        case 'away':
            actual = 'AWAY'
            jQuery('.plivo-status').html(actual);
            jQuery('.plivo-status-icon').html('<i class="fa fa-clock-o status-online"></i>');
            break;
        case 'lunch':
            actual = 'LUNCH'
            jQuery('.plivo-status').html(actual);
            jQuery('.plivo-status-icon').html('<i class="fa fa-square status-online"></i>');
            break;
        case 'busy':
            actual = 'BUSY'
            jQuery('.plivo-status').html(actual);
            jQuery('.plivo-status-icon').html('<i class="fa fa-minus-circle status-busy"></i>');
            break;
    }
    var postData = {
        is_ajax: true,
        status: actual,
    }
    if (ajaxIS === true) {
        jQuery.ajax({
            url: siteUrl + 'Checker/changestatus',
            method: 'post',
            dataType: 'json',
            data: postData,
            success: function (result) {
                if (result.message = true) {
                    console.log('Okay');
                } else if (result.message = false) {
                    console.log('Status Update ERROR!');
                    jQuery('.plivo-status').html('Pause');
                    jQuery('.plivo-status-icon').html('<i class="fa fa-square status-busy"></i>');
                } else {
                    swal('Something Went Wrong In Status Change!');
                }
            }
        });
}
}