var socket = require('socket.io');
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = socket.listen(server);
var port = process.env.PORT || 3000;
var db = require('./db');

server.listen(port, function () {
    console.log('Server listening at port %d', port);
});

io.on('connection', function (socket) {
    socket.on('getData', function (data) {
        db.getNotification(data.userid, function (data) {
            socket.emit('new_notification', JSON.stringify(data));
        });
        db.getCountNotification(data.userid, function (data) {
            socket.emit('count_notification', data);
        });
        db.getAgentStatus(data.userid, data.agencyid, function (data) {
            socket.emit('get_agent_status', JSON.stringify(data));
        });
    });

    /*----------- For Fetch Chat Message Data -------------*/
    socket.on('getChatData', function (data) {
        db.getChatData(data, function (ChatData) {
            socket.emit('chat_text', JSON.stringify(ChatData));
        });
    });

    /*----------- For Fetch New Message Data for bubble-------------*/
    socket.on('getNewMsg', function (data) {
        db.getNewMsg(data, function (NewMsg) {
            socket.emit('new_message', JSON.stringify(NewMsg));
        });
    });
    socket.on('getPushNotification', function (data) {
        db.getTaskPushNotification(data, function (data) {
            socket.emit('get_task_notification', JSON.stringify(data));
        });
        db.getEventPushNotification(function (data) {
            socket.emit('get_event_notification', JSON.stringify(data));
        });

    });
});