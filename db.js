var mysql = require('mysql');
var async = require('async');
var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: 'crm_new',
});


con.connect(function (err) {
    if (err)
        throw err;
    console.log("Connected!");
});

module.exports.connection = con;

module.exports.getNotification = function (id, callback) {
    var q = 'Select * From user_log Where to_id =' + id + ' AND (log_type = "calendar" OR log_type = "voice_mail") Order by log_id Desc';
    con.query(q, function (err, res, fields) {
        if (err)
            throw err;
        callback(res);
    });
};

module.exports.getCountNotification = function (id, callback) {
    var q = 'Select count(*) as total_notification From user_log Where to_id =' + id + ' AND (log_type = "calendar" OR log_type = "voice_mail") AND status = 0';
    con.query(q, function (err, res, fields) {
        if (err)
            throw err;
        callback(res);
    });
};

module.exports.getAgentStatus = function (id, agencyid, callback) {
    var q = 'SELECT * FROM agents LEFT JOIN live_agents as live on agents.user_id=live.user WHERE agency_id = ' + agencyid + ' AND user_id !=' + id;
    con.query(q, function (err, res, fields) {
        if (err)
            throw err;
        callback(res);
    });
    // con.end();
};

module.exports.getChatData = function (data, callback) {
    var agentid = data.post_Data.agent;
    var pnoneNum1 = data.post_Data.phone;
    var pnoneNum = pnoneNum1.substring(1, pnoneNum1.length);
    var headerOption = {};
    var lead = 'SELECT * FROM lead_store_mst WHERE phone = ' + pnoneNum + ' AND user = ' + agentid + ' LIMIT 1';
    con.query(lead, function (err1, lead_data, fields1) {
        if (err1)
            throw err1;
        var agent = 'SELECT * FROM agents WHERE id=' + agentid;
        con.query(agent, function (err2, agent_data, fields2) {
            if (err2)
                throw err2;
            var agentPlivo = '1' + agent_data[0].plivo_phone;
            var leadname = '';
            var leadstatus = '';
            if (lead_data.length > 0) {
                leadname = lead_data[0].first_name + ' ' + lead_data[0].last_name;
                leadstatus = lead_data[0].status;
            }
            headerOption.lead_name = leadname;
            headerOption.lead_status = leadstatus;
            headerOption.lead_image = 'Avatar.png';
            headerOption.agent_image = agent_data[0].profile_image;

            var smslog = 'SELECT * FROM lead_sms_log WHERE (sender_number=' + agentPlivo + ' OR receiver_number=' + agentPlivo + ') AND (sender_number=' + pnoneNum1 + ' OR receiver_number=' + pnoneNum1 + ') ORDER BY created ASC';
            con.query(smslog, function (err3, sms_data, fields3) {
                if (err3)
                    throw err3;
                headerOption.sms_data = sms_data;
                callback(headerOption);
            });
        });
    });
};


module.exports.getNewMsg = function (data, callback) {
    var phone_data = data.phone_Data;
    var agent = 'SELECT * FROM agents WHERE id=' + data.agentid;
    con.query(agent, function (err1, agent_data, fields1) {
        if (err1)
            throw err1;
        var agentPlivo = '1' + agent_data[0].plivo_phone;
        var newMsg = [];
        if (phone_data.length > 0) {
            /* For Forloop data */
            async.each(phone_data, function (phone, callback1) {
                var new_msg = 'SELECT * FROM lead_sms_log WHERE receiver_number="' + agentPlivo + '" AND sender_number="' + phone + '" AND sms_status="inbound" AND msg_status="unseen" ORDER BY created ASC';
                con.query(new_msg, function (err2, new_msg_data, fields2) {
                    if (err2)
                        throw err2;
                    if (new_msg_data.length > 0) {
                        newMsg.push(new_msg_data[0].sender_number.toString().substr(1));
                    }
                    callback1();
                });
            }, function (err) {
                callback(newMsg);
            });
        }
    });
};

module.exports.getTaskPushNotification = function (data, callback) {
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth() + 1;
    var date = d.getDate();
    var qDate = year + '-' + month + '-' + date;
    var hours = ("0" + d.getHours()).slice(-2);
    var mints = ("0" + d.getMinutes()).slice(-2);
    var qTime = hours + ':' + mints;
    var query = 'SELECT * FROM `tasks` WHERE `task_date` = "' + qDate + '" AND `task_start_time` = "' + qTime + '" AND (assign_agent_id = ' + data.agentid + ' OR user_id = ' + data.userid + ' )';
    con.query(query, function (err, res, fields) {
        if (err)
            throw err;
        callback(res);
    });
}

module.exports.getEventPushNotification = function (callback) {
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth() + 1;
    var date = d.getDate();
    var qDate = year + '-' + month + '-' + date;
    var hours = ("0" + d.getHours()).slice(-2);
    var mints = ("0" + d.getMinutes()).slice(-2);
    var qTime = hours + ':' + mints;
    var query = 'SELECT * FROM `calendar` WHERE `event_start_date` = "' + qDate + '" AND `event_start_time` = "' + qTime + '"';
    con.query(query, function (err, res, fields) {
        if (err)
            throw err;
        callback(res);
    });
}