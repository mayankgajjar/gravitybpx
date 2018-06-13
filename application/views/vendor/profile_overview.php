<?php

    $profile = 'uploads/agents/no-photo-available.jpg';

$r = rand(12501, 48525);
$profile .= "?" . $r;
?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo site_url('assets/theam_assets/pages/css/profile.min.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="index.html">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Dashboard</span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Dashboard
    <small>dashboard & statistics</small>
</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <img src="<?php echo $profile; ?>" class="img-responsive" alt=""> </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"><?php echo $this->session->userdata('vendor')->fname.' '.$this->session->userdata('vendor')->lname; ?></div>
                    <div class="profile-usertitle-job">

                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li class="active">
                            <a href="javascript:;">
                                <i class="icon-home"></i> Overview </a>
                        </li>
                        <li>
                            <a href="vendor/profile">
                                <i class="icon-settings"></i> Account Settings </a>
                        </li>
                    </ul>
                </div>
                <!-- END MENU -->
            </div>
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo site_url('assets/theam_assets/global/scripts/app.min.js'); ?>" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.sparkline.min.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/profile.min.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type='text/javascript'>
    $('document').ready(function () {
        $('#dashboard').parents('li').addClass('open');
        $('#dashboard').siblings('.arrow').addClass('open');
        $('#dashboard').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#dashboard'));
    });
</script>
<script type="text/javascript">
window.onload = startup;
function startup(){
    realtime_refresh_display();
}
var ar_refresh = <?php echo 1; ?>;
var ar_seconds = <?php echo 1; ?>;
var $start_count=0;
function realtime_refresh_display(){
    if ($start_count < 1){
        gather_realtime_content();
    }
    $start_count++;
    if (ar_seconds > 0){
        document.getElementById("refresh_countdown").innerHTML = "" + ar_seconds + "";
        ar_seconds = (ar_seconds - 1);
        setTimeout("realtime_refresh_display()",1000);
    }else{
        document.getElementById("refresh_countdown").innerHTML = "0";
        ar_seconds = ar_refresh;
        //window.location.reload();
        gather_realtime_content();
        setTimeout("realtime_refresh_display()",1000);
    }
}
function gather_realtime_content(){
   //jQuery('#loading').modal('show');
   var postData = jQuery('#groupForm').serialize();
   jQuery.ajax({
        url : '<?php echo site_url('dialer/report/realtimeajax') ?>',
        method : 'post',
        dataType : 'JSON',
        data : postData,
        success : function(result){
            var flag = Boolean(result.success);
            jQuery('#realtime_content').html(result.html);
            //jQuery('#loading').modal('hide');
        }
   });
}
function update_variables(task_option,task_choice,force_reload){
    if (task_option == 'adastats'){
        var adastats = parseInt(jQuery('#adastats').val());
        if (adastats == 1){
            jQuery('#adastats').val('2');
            jQuery('#text_adastats').html('View Less');
            jQuery('#text_adastats').parent('li').addClass('active');
        }else{
            jQuery('#adastats').val('1');
            jQuery('#text_adastats').html('View More');
            jQuery('#text_adastats').parent('li').removeClass('active');
        }
    } //if (task_option == 'adastats'){

    if(task_option == 'ALLINGROUPstats'){
        var ALLINGROUPstats = parseInt(jQuery('#ALLINGROUPstats').val());
        if(ALLINGROUPstats == 0){
            jQuery('#ALLINGROUPstats').val('1');
            jQuery('#text_ALLINGROUPstats').html('<?php echo "Hide In-Group Stats" ?>');
            jQuery('#text_ALLINGROUPstats').parent('li').addClass('active');
        }else{
            jQuery('#ALLINGROUPstats').val('0');
            jQuery('#text_ALLINGROUPstats').html('<?php echo "Show In-Group Stats" ?>')
            jQuery('#text_ALLINGROUPstats').parent('li').removeClass('active');
        }
    } //if(task_option == 'ALLINGROUPstats')
    if (task_option == 'PHONEdisplay'){
        var PHONEdisplay = parseInt(jQuery('#PHONEdisplay').val());
        if(PHONEdisplay == 0){
            jQuery('#PHONEdisplay').val('1');
            jQuery('#text_PHONEdisplay').html('<?php echo "Hide Phone" ?>');
            jQuery('#text_PHONEdisplay').parent('li').addClass('active');
        }else{
            jQuery('#PHONEdisplay').val('0');
            jQuery('#text_PHONEdisplay').html('<?php echo "Show Phone" ?>');
            jQuery('#text_PHONEdisplay').parent('li').removeClass('active');
        }
    }
    if (task_option == 'SERVdisplay'){
        var SERVdisplay = parseInt(jQuery('#SERVdisplay').val());
        if(SERVdisplay == 0){
            jQuery('#SERVdisplay').val('1');
            jQuery('#text_SERVdisplay').html('<?php echo "Hide Server Info" ?>');
            jQuery('#text_SERVdisplay').parent('li').addClass('active');
        }else{
            jQuery('#SERVdisplay').val('0');
            jQuery('#text_SERVdisplay').html('<?php echo "Show Server Info" ?>');
            jQuery('#text_SERVdisplay').parent('li').removeClass('active');
        }
    }
    if (task_option == 'UGdisplay'){
        var UGdisplay = parseInt(jQuery('#UGdisplay').val());
        if(UGdisplay == 0){
            jQuery('#UGdisplay').val('1');
            jQuery('#text_UGdisplay').html('<?php echo "Hide User Group" ?>');
            jQuery('#text_UGdisplay').parent('li').addClass('active');
        }else{
            jQuery('#UGdisplay').val('0');
            jQuery('#text_UGdisplay').html('<?php echo "Show User Group" ?>');
            jQuery('#text_UGdisplay').parent('li').removeClass('active');
        }
    }
    if(task_option == 'CUSTPHONEdisplay'){
        var CUSTPHONEdisplay = parseInt(jQuery('#CUSTPHONEdisplay').val());
        if(CUSTPHONEdisplay == 0){
            jQuery('#CUSTPHONEdisplay').val('1');
            jQuery('#text_CUSTPHONEdisplay').html('<?php echo "Hide Customphone" ?>');
            jQuery('#text_CUSTPHONEdisplay').parent('li').addClass('active');
        }else{
            jQuery('#CUSTPHONEdisplay').val('0');
            jQuery('#text_CUSTPHONEdisplay').html('<?php echo "Show Customphone" ?>');
            jQuery('#text_CUSTPHONEdisplay').parent('li').removeClass('active');
        }
    }
    if(task_option == 'CALLSdisplay'){
        var CALLSdisplay = parseInt(jQuery('#CALLSdisplay').val());
        if(CALLSdisplay == 0){
            jQuery('#CALLSdisplay').val('1');
            jQuery('#text_CALLSdisplay').html('<?php echo "Hide Waiting Calls" ?>');
            jQuery('#text_CALLSdisplay').parent('li').removeClass('active');
        }else{
            jQuery('#CALLSdisplay').val('0');
            jQuery('#text_CALLSdisplay').html('<?php echo "Show Waiting Calls" ?>');
            jQuery('#text_CALLSdisplay').parent('li').addClass('active');
        }
    }
    gather_realtime_content();
}
function send_monitor(session_id,server_ip,stage){
    var monitor_phone = jQuery('#monitor_phone').val();
    var postData = {
          phone_login : monitor_phone,
          session_id : session_id,
          server_ip: server_ip,
          stage : stage
    };
    jQuery.ajax({
        url : '<?php echo site_url('dialer/report/monitor') ?>',
        method : 'POST',
        dataType : 'json',
        data : postData,
        success : function(result){
            var flag = Boolean(result.success);
            var msg = result.html;
            var regXFerr = new RegExp("ERROR","g");
            var regXFscs = new RegExp("SUCCESS","g");
            if (msg.match(regXFerr)){
                    alert(msg);
            }
            if (msg.match(regXFscs)){
                alert("<?php echo "SUCCESS: calling"; ?> " + monitor_phone);
            }
        }
    });
}
function jsonpcallback(data) {
    //do stuff with JSON
    //console.log(data.statusText);
}

jQuery(document).on('submit','#groupForm',function(event){
    event.preventDefault();
    jQuery('#responsive').modal("hide");
    gather_realtime_content();
});
</script>