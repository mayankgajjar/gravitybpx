<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $title; ?></span>
        </li>
    </ul>
    <div class="tool-box"></div>
</div>
<h3 class="page-title"><?php echo $title; ?> </h3>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
</div>
<?php endif; ?>
<?php if(validation_errors() != ''): ?>
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<?php
    $campaignList = '<select multiple class="col-md-12 form-control" name="campaign_id[]">';
    $campaignList .= '<option selected value="ALL-ACTIVE">ALL-ACTIVE -</option>';
    foreach($campaigns as $campaign){
        $campaignList .= '<option value="'.$campaign->campaign_id.'">'.$campaign->campaign_id.' - '.$campaign->campaign_name.'</option>';
    }
    $campaignList .= '<select>';
?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark col-md-3">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"><?php echo $listtitle; ?> </span>
        </div>
        <div class="col-md-3">
            <a class="btn blue" data-toggle="modal" href="#responsive"><?php echo 'Choose Report Display Options' ?></a>
        </div>
        <div class="col-md-2">
            <a class="btn blue" href="javascript:update_variables('','');"><?php echo 'Reload Now' ?></a>
        </div>
        <div class="caption font-dark col-md-offset-2 col-md-2" style="display: none;">
            <div id="refresh_countdown_text"><?php echo 'Refresh' ?>:<span id="refresh_countdown"></span></div>
        </div>
    </div>
    <div class="portlet-body">
        <form id="groupForm" name="groupForm" id="groupForm" action="" method="post" class="form-horizontal" >
            <div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Report Display Settings</h4>
                        </div>
                        <div class="modal-body">
                            <!-- <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1"> -->
                                <div class="row">
                                    <div class="col-md-6">
<!--                                        <h4>Select Agency</h4>
                                        <?php  $tree = buildTree($agencies,0); ?>
                                        <p>
                                            <select name="agency_id" class="col-md-12 form-control" class="agency_id" onchange="javascript:selectUsers(this.value)">
                                                <option value=""><?php echo "All"; ?></option>
                                                <?php echo printTreeWithEncrypt($tree,0, null, isset($postData['agency_id']) ? decode_url($postData['agency_id']) :''); ?>
                                            </select>
                                        </p>-->
                                        <h4>
                                            <?php echo 'Monitor' ?>
                                        </h4>
                                        <p>
                                            <select name="monitor_active" id="monitor_active" class="form-control">
                                                <option value=""><?php echo 'NONE' ?></option>
                                                <option value="MONITOR"><?php echo 'MONITOR' ?></option>
                                                <option value="BARGE"><?php echo 'BARGE' ?></option>
                                            </select>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Select Campaign</h4>
                                        <p>
                                            <?php echo $campaignList ?>
                                        </p>
                                        <h4>
                                            <?php echo 'Phone'; ?>
                                        </h4>
                                        <p>
                                            <input type="text" name="monitor_phone" id="monitor_phone" class="form-control"/>
                                        </p>
                                    </div>
                                    <input type="hidden" name="RR" id="RR" value="40"/>
                                    <input type="hidden" name="with_inbound" id="with_inbound" value="Y"/>
                                    <input type="hidden" name="NOLEADSalert" id="NOLEADSalert" value=""/>
                                    <input type="hidden" name="DROPINGROUPstats" id="DROPINGROUPstats" value="0"/>
                                    <input type="hidden" name="DROPINGROUPstats" id="CARRIERstats" value="0"/>
                                    <input type="hidden" name="PRESETstats" id="PRESETstats" value="0" />
                                    <input type="hidden" name="AGENTtimeSTATS" id="AGENTtimeSTATS" value="0" />
                                    <input type="hidden" name="droppedOFtotal" id="droppedOFtotal" value="" />
                                    <input type="hidden" name="adastats" id="adastats" value="1"/>
                                    <input type="hidden" name="ALLINGROUPstats" id="ALLINGROUPstats" value="0" />
                                    <input type="hidden" name="PHONEdisplay" id="PHONEdisplay" value="0"/>
                                    <input type="hidden" name="SERVdisplay" id="SERVdisplay" value="0"/>
                                    <input type="hidden" name="UGdisplay" id="UGdisplay" value="0" />
                                    <input type="hidden" name="CUSTPHONEdisplay" id="CUSTPHONEdisplay" value="0" />
                                    <input type="hidden" name="CALLSdisplay" id="CALLSdisplay" value="1" />
                                </div>
                            <!-- </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                            <button type="submit" class="btn green">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-2 col-xs-2">
                   <ul class="nav nav-tabs tabs-left">
                        <li><a href="javascript:update_variables('adastats','');" id="text_adastats"><?php echo 'View More'; ?></a></li>
                        <li><a href="javascript:update_variables('UGdisplay','');" id="text_UGdisplay"><?php echo 'View User Group'; ?></a></li>
                        <li><a href="javascript:update_variables('SERVdisplay','');" id="text_SERVdisplay"><?php echo 'Show Server Info'; ?></a></li>
                        <li><a href="javascript:update_variables('CALLSdisplay','');" id="text_CALLSdisplay"><?php echo 'Hide Waiting Calls'; ?></a></li>
                        <li><a href="javascript:update_variables('ALLINGROUPstats','');" id="text_ALLINGROUPstats"><?php echo 'Show In-Groups Stats'; ?></a></li>
                        <li><a href="javascript:update_variables('PHONEdisplay','');" id="text_PHONEdisplay"><?php echo 'Show Phones'; ?></a></li>
                        <li><a href="javascript:update_variables('CUSTPHONEdisplay','');" id="text_CUSTPHONEdisplay"><?php echo 'Show Customphones'; ?></a></li>
                    </ul>
                </div>
                <div class="col-md-10 col-sm-10 col-xs-10">
                    <div id="realtime_content"></div>
                </div>
            </div>

            <!--div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </div>
            </div>-->
        </form>
    </div>
</div>
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
        }else{
            jQuery('#adastats').val('1');
            jQuery('#text_adastats').html('View More');
        }
    } //if (task_option == 'adastats'){

    if(task_option == 'ALLINGROUPstats'){
        var ALLINGROUPstats = parseInt(jQuery('#ALLINGROUPstats').val());
        if(ALLINGROUPstats == 0){
            jQuery('#ALLINGROUPstats').val('1');
            jQuery('#text_ALLINGROUPstats').html('<?php echo "Hide In-Group Stats" ?>')
        }else{
            jQuery('#ALLINGROUPstats').val('0');
            jQuery('#text_ALLINGROUPstats').html('<?php echo "Show In-Group Stats" ?>')
        }
    } //if(task_option == 'ALLINGROUPstats')
    if (task_option == 'PHONEdisplay'){
        var PHONEdisplay = parseInt(jQuery('#PHONEdisplay').val());
        if(PHONEdisplay == 0){
            jQuery('#PHONEdisplay').val('1');
            jQuery('#text_PHONEdisplay').html('<?php echo "Hide Phone" ?>');
        }else{
            jQuery('#PHONEdisplay').val('0');
            jQuery('#text_PHONEdisplay').html('<?php echo "Show Phone" ?>');
        }
    }
    if (task_option == 'SERVdisplay'){
        var SERVdisplay = parseInt(jQuery('#SERVdisplay').val());
        if(SERVdisplay == 0){
            jQuery('#SERVdisplay').val('1');
            jQuery('#text_SERVdisplay').html('<?php echo "Hide Server Info" ?>');
        }else{
            jQuery('#SERVdisplay').val('0');
            jQuery('#text_SERVdisplay').html('<?php echo "Show Server Info" ?>');
        }
    }
    if (task_option == 'UGdisplay'){
        var UGdisplay = parseInt(jQuery('#UGdisplay').val());
        if(UGdisplay == 0){
            jQuery('#UGdisplay').val('1');
            jQuery('#text_UGdisplay').html('<?php echo "Hide User Group" ?>');
        }else{
            jQuery('#UGdisplay').val('0');
            jQuery('#text_UGdisplay').html('<?php echo "Show User Group" ?>');
        }
    }
    if(task_option == 'CUSTPHONEdisplay'){
        var CUSTPHONEdisplay = parseInt(jQuery('#CUSTPHONEdisplay').val());
        if(CUSTPHONEdisplay == 0){
            jQuery('#CUSTPHONEdisplay').val('1');
            jQuery('#text_CUSTPHONEdisplay').html('<?php echo "Hide Customphone" ?>');
        }else{
            jQuery('#CUSTPHONEdisplay').val('0');
            jQuery('#text_CUSTPHONEdisplay').html('<?php echo "Show Customphone" ?>');
        }
    }
    if(task_option == 'CALLSdisplay'){
        var CALLSdisplay = parseInt(jQuery('#CALLSdisplay').val());
        if(CALLSdisplay == 0){
            jQuery('#CALLSdisplay').val('1');
            jQuery('#text_CALLSdisplay').html('<?php echo "Hide Waiting Calls" ?>');
        }else{
            jQuery('#CALLSdisplay').val('0');
            jQuery('#text_CALLSdisplay').html('<?php echo "Show Waiting Calls" ?>');
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