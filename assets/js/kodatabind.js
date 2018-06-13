function getNotification(status,log_id,title,log_type,time){
    return {
        classe : ko.computed(function(){
            if(status == 0 ){
                return 'unread_notify'
            }else{
                return ''
            }
        }),
        url : 'agent/read_notification/'+log_id,
        title : ko.observable(title),
        log_type : ko.computed(function(){ 
            return feed_status(log_type);
        }),
        time : ko.computed(function(){
            return time_ago(time);
        }),
    }
}

function getUserStatus(data){
    return {
        uavatar : ko.computed(function(){
            if(data.profile_image){
                return 'uploads/agents/'+data.profile_image;
            }
            return 'uploads/agents/users.jpg';
        }),
        uname : ko.computed(function(){
            return data.fname+' '+data.lname;
        }),
        mediaagentid : data.id,
        mediaclass : ko.computed(function(){
            if(data.status == 'READY' ){
                return 'media-online'
            }else if(data.status == 'INCALL' || data.status == 'PAUSED' || data.status == 'DISPO' || data.status == 'BUSY'){
                return 'media-busy'
            }else if(data.status == 'AWAY'){
                return 'media-away'
            }else if(data.status == 'LUNCH'){
                return 'media-lunch'
            }
            return 'media-offline'
        }),
        agenttype : ko.computed(function(){
            if(data.agent_type == 1){
                return 'Sales Agent';
            }else if(data.agent_type == 2){
                return 'Verification Agent';
            }
            return 'Processing Agent';
        }),
    }
}

function getUserChat(data){
    return {
        chat_msg : data.text,
        inbound : ko.computed(function(){
            if(data.sms_status == 'inbound'){
                return 'inbound';
            }
            return null;
        }),
        outbound : ko.computed(function(){
            if(data.sms_status == 'outbound'){
                return 'outbound';
            }
            return null;
        }),
        chat_image : ko.computed(function(){
            if(data.sms_status == 'inbound'){
                if(data.lead_image){
                    return 'assets/images/'+data.lead_image;
                }
            }else{
                if(data.agent_image){
                    return 'uploads/agents/'+data.agent_image;
                }
            }
            return 'assets/images/Avatar.png';
        }),
    }
}