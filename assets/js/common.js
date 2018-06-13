function feed_status(type) {
    var status = '';
    if(type == 'inbound'){
        status = '<i class="icon-call-in"></i>';
    }else if(type == 'outbound'){
        status = '<i class="icon-call-out"></i>';
    }else if(type == 'voice_mail'){
        status = '<i class="fa fa-bullhorn"></i>';
    }else if(type == 'send_sms'){
        status = '<i class="fa fa-envelope-o"></i>';
    }else if(type == 'receive_sms'){
        status = '<i class="icon-envelope-letter"></i>';
    }else if(type == 'profile'){
        status = '<i class="fa fa-user"></i>';
    }else if(type == 'file_upload'){
        status = '<i class="fa fa-upload"></i>';
    }else if(type == 'task'){
        status = '<i class="fa fa-tasks"></i>';
    }else if(type == 'calendar'){
        status = '<i class="fa fa-calendar"></i>';
    }else if(type == 'commission'){
        status = '<i class="fa fa-money"></i>';
    }else{
        status = '<i class="fa fa-bell-o"></i>';
    }
    return status;
}    


function time_ago(date_str) {
    if (!date_str) {return;}
    date_str = $.trim(date_str);
    date_str = date_str.replace(/\.\d\d\d+/,""); // remove the milliseconds
    date_str = date_str.replace(/-/,"/").replace(/-/,"/"); //substitute - with /
    date_str = date_str.replace(/T/," ").replace(/Z/," UTC"); //remove T and substitute Z with UTC
    date_str = date_str.replace(/([\+\-]\d\d)\:?(\d\d)/," $1$2"); // +08:00 -> +0800
    var parsed_date = new Date(date_str);
    var relative_to = (arguments.length > 1) ? arguments[1] : new Date(); //defines relative to what ..default is now
    var delta = parseInt((relative_to.getTime()-parsed_date)/1000);
    delta=(delta<2)?2:delta;
    var r = '';
    if (delta < 60) {
    r = delta + ' seconds ago';
    } else if(delta < 120) {
    r = 'a minute ago';
    } else if(delta < (45*60)) {
    r = (parseInt(delta / 60, 10)).toString() + ' minutes ago';
    } else if(delta < (2*60*60)) {
    r = 'an hour ago';
    } else if(delta < (24*60*60)) {
    r = '' + (parseInt(delta / 3600, 10)).toString() + ' hours ago';
    } else if(delta < (48*60*60)) {
    r = 'a day ago';
    } else {
    r = (parseInt(delta / 86400, 10)).toString() + ' days ago';
    }
    // return 'about ' + r;
    return r;
}