"use strict";
function folderData(name, fullname, unseen, namesis) {
    return {
        name: ko.observable(name),
        activeClass: ko.computed(function () {
            if (name == MyAgentViewModel.oMailBox()) {
                return 'active';
            }
            return '';
        }),
        fullname: ko.observable(fullname),
        unseen: ko.computed(function () {
            if (unseen > 0) {
                return unseen;
            }
            return null;
        }),
        namesis: ko.observable(namesis),
        getMessages: function () {
            jQuery('#email-content').html();
            jQuery('#email-list-table').show();
            MyAgentViewModel.oMailBox(name);
            MyAgentViewModel.oMailBoxActual(fullname);
            getMessageListJson(fullname);
        }
    }
}

function messageList(value) {
    return {
        Uid: value.Uid,
        attachment: ko.computed(function () {
            if (value.attachment) {
                return 'fa fa-paperclip';
            } else {
                return '';
            }
        }),
        subject: value.subject,
        fromname: value.fromname,
        fromEmailList: value.fromEmailList,
        date: value.date,
        flags: ko.computed(function () {
            if (value.flags) {
                return '';
            }
            return 'unread';
        }),
        messageEvent: function (data, event) {
            event.stopPropagation();
            if(jQuery(event.target).hasClass('group-checkable')){
                var tr = jQuery(event.target).parent('td').parent('tr');
                tr.find('input').trigger('click');
            }else{
                $('#loading').modal('show');
                getFolderJson();
                var uid = value.Uid;
                $.ajax({
                    url: siteUrl + 'email/openEmail',
                    method: 'POST',
                    data: {id: uid, folder: MyAgentViewModel.oMailBoxActual()},
                    success: function (data) {
                        $('#loading').modal('hide');
                        $('#email-content').show();
                        $('#email-list-table').hide();
                        $('#email-content').html(data);
                    }
                });
            }
        }
    };
}

function getFolderJson() {
    jQuery.getJSON(siteUrl + "email/getFolderJson", function (data) {
        var cnt = 0;
        var len = MyAgentViewModel.oFolders().length;
        jQuery.map(data.oFolders, function (value) {
            if(len == 0){
                MyAgentViewModel.oFolders.push(folderData(value.name, value.fullname, value.unseen, value.namesis));
            }else{
                MyAgentViewModel.oFolders.replace(MyAgentViewModel.oFolders()[cnt],folderData(value.name, value.fullname, value.unseen, value.namesis));
            }
            cnt++;
        });
        jQuery('.template-loader').remove();
    });
}
function getMessageListJson(folder) {
    var url = encodeURI("email/getMessageJson?folder="+folder);
    jQuery('#email-content').hide();
    jQuery('#email-list').html(MyAgentViewModel.spinner);
    jQuery.getJSON(url, function (data) {
        jQuery('#email-list').html('');
        jQuery('#email-list-table').show();
        MyAgentViewModel.totalMessage(data.total);
        MyAgentViewModel.index(data.count);
        jQuery.map(data.messages, function (value) {
            MyAgentViewModel.oMessageList.push(new messageList(value));
        });

    });
}

jQuery(function(){
   getFolderJson();
   getMessageListJson(MyAgentViewModel.oMailBoxActual());
});