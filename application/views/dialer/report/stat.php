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
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"><?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <form id="groupForm" name="groupForm" id="groupForm" action="" method="post" class="form-horizontal" >
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'From Date' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                       <input type="text" name="formdate" class="form-control" id="formdate" value="<?php echo isset($postData['formdate']) ? $postData['formdate'] : date('m/d/Y') ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'To Date' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="todate" class="form-control" id="todate" value="<?php echo isset($postData['todate']) ? $postData['todate'] : date('m/d/Y') ?>"/>
                    </div>
                </div>
                <?php if($this->session->userdata('user')->group_name == 'Agency'): ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo 'Agency' ?><span class="required">*</span></label>
                        <div class="col-md-4">
                            <?php  $tree = buildTree($agencies,$this->session->userdata('agency')->id); ?>
                            <select name="agency_id" class="form-control" class="agency_id" onchange="javascript:selectUsers(this.value)">
                                <option value=""><?php echo "Please Select Agency"; ?></option>
                                <option value="<?php echo encode_url($this->session->userdata('agency')->id) ?>" <?php echo isset($postData['agency_id']) && decode_url($postData['agency_id']) == $this->session->userdata('agency')->id ? 'selected="selected"':''  ?>><?php echo $this->session->userdata('agency')->name; ?></option>
                                <?php echo printTreeWithEncrypt($tree,0, null, isset($postData['agency_id']) ? decode_url($postData['agency_id']) :''); ?>
                            </select>
<!--                            <span class="help-content"><?php echo 'select blank for current agency.' ?></span>-->
                        </div>
                    </div>
                <?php else: ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agency' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <?php  $tree = buildTree($agencies,0); ?>
                        <select name="agency_id" class="form-control" class="agency_id" onchange="javascript:selectUsers(this.value)">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <?php echo printTreeWithEncrypt($tree,0, null, isset($postData['agency_id']) ? decode_url($postData['agency_id']) :''); ?>
                        </select>
                    </div>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agents' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <select name="user_start" class="form-control" id="user_start">

                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function selectUsers(agencyId){
    jQuery('#loading').modal("show");
    jQuery.ajax({
        url:'<?php echo site_url('dialer/ajax/getUser') ?>',
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{id: agencyId, user:'<?php echo isset($postData['user_start']) ? $postData['user_start'] : "" ?>'},
        success: function(result){
            var flag = Boolean(result.success);
            jQuery('#user_start').replaceWith(result.html);
            jQuery('#loading').modal("hide");
        }
    });
}
jQuery(function(){
    <?php if(isset($postData) && count($postData) > 0) : ?>
        selectUsers('<?php echo $postData['agency_id'] ?>')
    <?php endif; ?>
    jQuery("#formdate").datepicker();
    jQuery("#todate").datepicker();
    jQuery('#groupForm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules:{
           formdate :{
               required: true,
           },
           todate:{
               required: true,
           },
           agency_id:{
                required: true,
           },
           user_start:{
               required: true,
           }
       },
        highlight: function (element) { // hightlight error inputs
             $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
});
</script>
<?php if($result): ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"><?php echo 'Search Result' ?></span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="agent-talk-time">
            <?php extract($talktime) ?>
            <?php $o = 0; $total_sec = 0; ?>
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4 class="table-title"><strong><?php echo 'AGENT TALK TIME AND STATUS' ?></strong></h4>
                </div>
                <div class="col-md-6 text-right"><a class="btn btn-primary" href="<?php echo site_url('dialer/report/download?begin_date='.$postData['formdate'].'&end_date='.$postData['todate'].'&user='.$postData['user_start'].'&report=talktime&agency='.$postData['agency_id']) ?>"><?php echo 'Download' ?></a></div>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th><?php echo 'Status' ?></th>
                    <th><?php echo 'Count' ?></th>
                    <th><?php echo 'HOURS:MM:SS' ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if($o < $p): ?>
                    <?php while($o < $p): ?>
                        <?php $call_hours_minutes = sec_convert($call_sec[$o],'H'); ?>
                    <tr>
                        <td><?php echo $status[$o] ?></td>
                        <td class="text-right"><?php echo $counts[$o] ?></td>
                        <td class="text-right"><?php echo $call_hours_minutes ?></td>
                        <?php
                            $total_calls = ($total_calls + $counts[$o]);
                            $total_sec = ($total_sec + $call_sec[$o]);
                            $call_seconds=0;
                        ?>
                    </tr>
                    <?php $o++ ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center"><strong><?php echo 'No records found.' ?></strong></td>
                    </tr>
                <?php endif; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td><?php echo 'Total Calls' ?></td>
                    <td class="text-right"><?php echo $total_calls ?></td>
                    <td class="text-right"><?php echo sec_convert($total_sec,'H') ?></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="agent-login-time">
            <div class="col-md-12">
                <div class="col-md-6"><h4 class="table-title"><strong><?php echo 'AGENT LOGIN/LOGOUT TIME' ?></strong></h4></div>
                <div class="col-md-6 text-right"><a class="btn btn-primary" href="<?php echo site_url('dialer/report/download?begin_date='.$postData['formdate'].'&end_date='.$postData['todate'].'&user='.$postData['user_start'].'&report=events&agency='.$postData['agency_id']) ?>"><?php echo 'Download' ?></a></div>
            </div>
            <?php $total_calls = 0; $event_start_seconds = ''; $event_stop_seconds='';$total_login_time = 0;?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th><?php echo 'Event' ?></th>
                    <th><?php echo 'Date' ?></th>
                    <th><?php echo 'Campaign' ?></th>
                    <th><?php echo 'Group' ?></th>
                    <th><?php echo 'Session' ?><br/><?php echo 'HOURS:MM:SS' ?></th>
                    <th><?php echo 'Server' ?></th>
                    <th><?php echo 'Phone' ?></th>
                    <th><?php echo 'Computer' ?></th>
                    <th><?php echo 'Phone Login' ?></th>
                    <th><?php echo 'Phone IP' ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php if($events): ?>
                    <?php foreach($events as $event): ?>
                        <?php if (preg_match('/LOGIN/', $event->event)): ?>
                            <?php if ($event->phone_ip == 'LOOKUP'): ?>
                                <?php $event->phone_ip = ''; ?>
                            <?php endif; ?>
                            <?php $event_start_seconds = $event->event_epoch ?>
                            <tr>
                                <td><?php echo $event->event ?></td>
                                <td><?php echo $event->event_date ?></td>
                                <td class="text-right"><?php echo $event->campaign_id ?></td>
                                <td><?php echo $event->user_group ?></td>
                                <td class="text-right"><?php echo $event->session_id ?></td>
                                <td><?php echo $event->server_ip ?></td>
                                <td><?php echo $event->extension ?></td>
                                <td class="text-right"><?php echo $event->computer_ip ?></td>
                                <td ><?php echo $event->phone_login ?></td>
                                <td><?php echo $event->phone_ip ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (preg_match('/LOGOUT/', $event->event)): ?>
                            <?php if ($event_start_seconds) : ?>
                                <?php
                                    $event_stop_seconds = $event->event_epoch;
                                    $event_seconds = ($event_stop_seconds - $event_start_seconds);
                                    $total_login_time = ($total_login_time + $event_seconds);
                                    $event_hours_minutes = sec_convert($event_seconds,'H');
                                ?>
                                <tr>
                                    <td><?php echo $event->event ?></td>
                                    <td><?php echo $event->event_date ?></td>
                                    <td class="text-right"><?php echo $event->campaign_id ?></td>
                                    <td><?php echo $event->user_group ?></td>
                                    <td class="text-right"><?php echo $event_hours_minutes ?></td>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                                <?php
                                    $event_start_seconds='';
                                    $event_stop_seconds='';
                                ?>
                            <?php else: ?>
                                <?php /*<tr>
                                    <td><?php $event->event ?></td>
                                    <td><?php $event->event_date ?></td>
                                    <td class="text-right"><?php $event->campaign_id ?></td>
                                    <td></td>
                                    <td colspan="5">&nbsp;</td>
                                </tr> */ ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="10"><strong><?php echo "No records found." ?></strong></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <?php $total_login_hours_minutes =	sec_convert($total_login_time,'H'); ?>
                    <tr>
                        <td><?php echo 'Total' ?></td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td class="text-right"><?php echo $total_login_hours_minutes; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="closer-in-group">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4 class="table-title"><strong><?php echo 'CLOSER IN-GROUP SELECTION LOGS' ?></strong></h4>
                </div>
                <div class="col-md-6 text-right"><a class="btn btn-primary" href="<?php echo site_url('dialer/report/download?begin_date='.$postData['formdate'].'&end_date='.$postData['todate'].'&user='.$postData['user_start'].'&report=closers&agency='.$postData['agency_id']) ?>"><?php echo 'Download' ?></a></div>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th><?php echo '#' ?></th>
                    <th><?php echo 'Date/Time' ?></th>
                    <th><?php echo 'Campaign' ?></th>
                    <th><?php echo 'Blend' ?></th>
                    <th><?php echo 'Groups' ?></th>
                    <th><?php echo 'Manager' ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php if($closers): ?>
                        <?php $i = 0; ?>
                        <?php foreach($closers as $closer): $i++; ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $closer->event_date ?></td>
                            <td><?php echo $closer->campaign_id ?></td>
                            <td><?php echo $closer->blended ?></td>
                            <td><?php echo $closer->closer_campaigns ?></td>
                            <td><?php echo $closer->manager_change ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center"><strong><?php echo 'No records found'; ?></strong></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
        <div class="outbound-calls">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4 class="table-title"><strong><?php echo 'OUTBOUND CALLS FOR THIS TIME PERIOD: (10000 record limit)' ?></strong></h4>
                </div>
                <div class="col-md-6 text-right"><a class="btn btn-primary" href="<?php echo site_url('dialer/report/download?begin_date='.$postData['formdate'].'&end_date='.$postData['todate'].'&user='.$postData['user_start'].'&report=outbounds&agency='.$postData['agency_id']) ?>"><?php echo 'Download' ?></a></div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo '#' ?></th>
                        <th><?php echo 'Date/Time' ?></th>
                        <th><?php echo 'Length' ?></th>
                        <th><?php echo 'Status' ?></th>
                        <th><?php echo 'Phone' ?></th>
                        <th><?php echo 'Campaign' ?></th>
                        <th><?php echo 'Group' ?></th>
                        <th><?php echo 'List' ?></th>
                        <th><?php echo 'Lead' ?></th>
                        <th><?php echo 'Hangup Reason' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($outbounds): ?>
                        <?php $u = 0; ?>
                        <?php foreach($outbounds as $outbound):$u++; ?>
                        <tr>
                            <td><?php echo $u; ?></td>
                            <td><?php echo $outbound->call_date ?></td>
                            <td><?php echo $outbound->length_in_sec ?></td>
                            <td><?php echo $outbound->status ?></td>
                            <td><?php echo $outbound->phone_number ?></td>
                            <td><?php echo $outbound->campaign_id ?></td>
                            <td><?php echo $outbound->user_group ?></td>
                            <td><?php echo $outbound->list_id ?></td>
                           <td><?php echo $outbound->lead_id ?></td>
                            <td><?php echo $outbound->term_reason ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="10"><strong><?php echo 'No records found.' ?></strong></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="inbound-calls">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4 class="table-title"><strong><?php echo 'INBOUND/CLOSER CALLS FOR THIS TIME PERIOD: (10000 record limit) ' ?></strong></h4>
                </div>
                <div class="col-md-6 text-right"><a class="btn btn-primary" href="<?php echo site_url('dialer/report/download?begin_date='.$postData['formdate'].'&end_date='.$postData['todate'].'&user='.$postData['user_start'].'&report=inbounds&agency='.$postData['agency_id']) ?>"><?php echo 'Download' ?></a></div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo '#' ?></th>
                        <th><?php echo 'Date/Time' ?></th>
                        <th><?php echo 'Length' ?></th>
                        <th><?php echo 'Status' ?></th>
                        <th><?php echo 'Phone' ?></th>
                        <th><?php echo 'Campaign' ?></th>
                        <th><?php echo 'Wait(s)' ?></th>
                        <th><?php echo 'Agent(s)' ?></th>
                        <th><?php echo 'List' ?></th>
                        <th><?php echo 'Lead' ?></th>
                        <th><?php echo 'Hangup Reason' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $TOTALinSECONDS=0; $TOTALagentSECONDS=0; ?>
                    <?php if($inbounds): ?>
                        <?php $u = 0; ?>
                        <?php foreach($inbounds as $inbound): $u++;?>
                            <?php
                                $TOTALinSECONDS = ($TOTALinSECONDS + $inbound->length_in_sec);
                                $AGENTseconds = ($inbound->length_in_sec - $inbound->queue_seconds);
                                if ($AGENTseconds < 0){
                                    $AGENTseconds=0;
                                }
                                $TOTALagentSECONDS = ($TOTALagentSECONDS + $AGENTseconds);
                            ?>
                            <tr>
                                <td><?php echo $u; ?></td>
                                <td><?php echo $inbound->call_date ?></td>
                                <td><?php echo $inbound->length_in_sec ?></td>
                                <td><?php echo $inbound->status ?></td>
                                <td><?php echo $inbound->phone_number ?></td>
                                <td><?php echo $inbound->campaign_id ?></td>
                                <td><?php echo $inbound->queue_seconds ?></td>
                                <td><?php echo $AGENTseconds; ?></td>
                                <td><?php echo $inbound->list_id ?></td>
                                <td><?php echo $inbound->lead_id ?></td>
                                <td><?php echo $inbound->term_reason ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td class="text-center" colspan="11"><strong><?php echo 'No records found.' ?></strong></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><?php echo 'Totals' ?></td>
                        <td><?php echo $TOTALinSECONDS ?></td>
                        <td colspan="4">&nbsp;</td>
                        <td><?php echo $TOTALagentSECONDS ?></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="agent-activity">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4 class="table-title"><strong><?php echo 'AGENT ACTIVITY FOR THIS TIME PERIOD: (10000 record limit)' ?></strong></h4>
                </div>
                <div class="col-md-6 text-right"><a class="btn btn-primary" href="<?php echo site_url('dialer/report/download?begin_date='.$postData['formdate'].'&end_date='.$postData['todate'].'&user='.$postData['user_start'].'&report=activities&agency='.$postData['agency_id']) ?>"><?php echo 'Download' ?></a></div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo '#' ?></th>
                        <th><?php echo 'Date/Time' ?></th>
                        <th><?php echo 'Pause' ?></th>
                        <th><?php echo 'Wait' ?></th>
                        <th><?php echo 'Talk' ?></th>
                        <th><?php echo 'Dispo' ?></th>
                        <th><?php echo 'Dead' ?></th>
                        <th><?php echo 'Customer' ?></th>
                        <th><?php echo 'Status' ?></th>
                        <th><?php echo 'Lead' ?></th>
                        <th><?php echo 'Campaign' ?></th>
                        <th><?php echo 'Pause Code' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $u=0;
                        $TOTALpauseSECONDS=0;
                        $TOTALwaitSECONDS=0;
                        $TOTALtalkSECONDS=0;
                        $TOTALdispoSECONDS=0;
                        $TOTALdeadSECONDS=0;
                        $TOTALcustomerSECONDS=0;
                    ?>
                    <?php if($activities): ?>
                    <?php foreach($activities as $activity): $u++; ?>
                    <?php
			$event_time = $activity->event_time;
			$lead_id = $activity->lead_id;
			$campaign_id = $activity->campaign_id;
			$pause_sec = $activity->pause_sec;
			$wait_sec = $activity->wait_sec;
			$talk_sec = $activity->talk_sec;
			$dispo_sec = $activity->dispo_sec;
			$dead_sec = $activity->dead_sec;
			$status = $activity->status;
			$pause_code = $activity->sub_status;
			$user_group = $activity->user_group;
                        $customer_sec = ($talk_sec - $dead_sec);
                        if ($customer_sec < 0){
                            $customer_sec=0;
                        }
			$TOTALpauseSECONDS = ($TOTALpauseSECONDS + $pause_sec);
			$TOTALwaitSECONDS = ($TOTALwaitSECONDS + $wait_sec);
			$TOTALtalkSECONDS = ($TOTALtalkSECONDS + $talk_sec);
			$TOTALdispoSECONDS = ($TOTALdispoSECONDS + $dispo_sec);
			$TOTALdeadSECONDS = ($TOTALdeadSECONDS + $dead_sec);
			$TOTALcustomerSECONDS = ($TOTALcustomerSECONDS + $customer_sec);
                    ?>
                    <tr>
                        <td><?php echo $u; ?></td>
                        <td><?php echo $event_time; ?></td>
                        <td class="text-right"><?php echo $pause_sec; ?></td>
                        <td class="text-right"><?php echo $wait_sec; ?></td>
                        <td class="text-right"><?php echo $talk_sec; ?></td>
                        <td class="text-right"><?php echo $dispo_sec; ?></td>
                        <td class="text-right"><?php echo $dead_sec; ?></td>
                        <td class="text-right"><?php echo $customer_sec; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><?php echo $lead_id; ?></td>
                        <td class="text-right"><?php echo $campaign_id; ?></td>
                        <td><?php echo $pause_code; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td class="text-center" colspan="12"><?php echo 'No records found.' ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><?php echo 'Totals' ?></td>
                        <td class="text-right"><?php echo $TOTALpauseSECONDS ?></td>
                        <td class="text-right"><?php echo $TOTALwaitSECONDS ?></td>
                        <td class="text-right"><?php echo $TOTALtalkSECONDS ?></td>
                        <td class="text-right"><?php echo $TOTALdispoSECONDS ?></td>
                        <td class="text-right"><?php echo $TOTALdeadSECONDS ?></td>
                        <td class="text-right"><?php echo $TOTALcustomerSECONDS ?></td>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <?php
                        $TOTALpauseSECONDShh =	sec_convert($TOTALpauseSECONDS,'H');
                        $TOTALwaitSECONDShh =	sec_convert($TOTALwaitSECONDS,'H');
                        $TOTALtalkSECONDShh =	sec_convert($TOTALtalkSECONDS,'H');
                        $TOTALdispoSECONDShh =	sec_convert($TOTALdispoSECONDS,'H');
                        $TOTALdeadSECONDShh =	sec_convert($TOTALdeadSECONDS,'H');
                        $TOTALcustomerSECONDShh =	sec_convert($TOTALcustomerSECONDS,'H');
                    ?>
                    <tr>
                        <td colspan="2"><?php echo '(in HH:MM:SS)' ?></td>
                        <td class="text-right"><?php echo $TOTALpauseSECONDShh ?></td>
                        <td class="text-right"><?php echo $TOTALwaitSECONDShh ?></td>
                        <td class="text-right"><?php echo $TOTALtalkSECONDShh ?></td>
                        <td class="text-right"><?php echo $TOTALdispoSECONDShh ?></td>
                        <td class="text-right"><?php echo $TOTALdeadSECONDShh ?></td>
                        <td class="text-right"><?php echo $TOTALcustomerSECONDShh ?></td>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="record-activity">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4 class="table-title"><strong><?php echo 'RECORDINGS FOR THIS TIME PERIOD: (10000 record limit) ' ?></strong></h4>
                </div>
                <div class="col-md-6 text-right"><a class="btn btn-primary" href="<?php echo site_url('dialer/report/download?begin_date='.$postData['formdate'].'&end_date='.$postData['todate'].'&user='.$postData['user_start'].'&report=recordings&agency='.$postData['agency_id']) ?>"><?php echo 'Download' ?></a></div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo '#' ?></th>
                        <th><?php echo 'Lead' ?></th>
                        <th><?php echo 'Date/Time' ?></th>
                        <th><?php echo 'Seconds' ?></th>
                        <th><?php echo 'RecID' ?></th>
                        <th><?php echo 'Filename' ?></th>
                        <th><?php echo 'Location' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $u = 0; ?>
                    <?php if($recordings): ?>
                        <?php foreach($recordings as $record): $u++; ?>
                            <?php
                                $location = $record->location;
                                if (strlen($location)>2){
                                    $URLserver_ip = $location;
                                    $URLserver_ip = preg_replace('/http:\/\//i', '',$URLserver_ip);
                                    $URLserver_ip = preg_replace('/https:\/\//i', '',$URLserver_ip);
                                    $URLserver_ip = preg_replace('/\/.*/i', '',$URLserver_ip);
                                    $stmt = "select count(*) as count from servers where server_ip='$URLserver_ip';";
                                    $query = $this->vicidialdb->db->query($stmt);
                                    $row = $query->row();
                                    if ($row->count > 0){
                                        $stmt = "select recording_web_link,alt_server_ip,external_server_ip from servers where server_ip='$URLserver_ip';";
                                        $query = $this->vicidialdb->db->query($stmt);
                                        $row = $query->row();
                                        if (preg_match("/ALT_IP/i",$row->recording_web_link)){
                                            $location = preg_replace("/$URLserver_ip/i", "$row->alt_server_ip", $location);
                                        }
                                        if (preg_match("/EXTERNAL_IP/i",$row->recording_web_link)){
                                            $location = preg_replace("/$URLserver_ip/i", "$row->alt_server_ip", $location);
                                        }
                                    }
                                }
                                /*if (strlen($location)>30){
                                    $locat = substr($location,0,27);  $locat = "$locat...";
                                }else{
                                    $locat = $location;
                                }*/
                                /*if ( (preg_match('/ftp/i',$location)) or (preg_match('/http/i',$location)) ){
                                    $location = "<a href=\"$location\">$locat</a>";
                                }else{
                                    $location = $locat;
                                }*/
                            ?>
                        <tr>
                            <td><?php echo $u; ?></td>
                            <td><?php echo $record->lead_id; ?></td>
                            <td><?php echo $record->start_time; ?></td>
                            <td><?php echo $record->length_in_sec; ?></td>
                            <td><?php echo $record->recording_id; ?></td>
                            <td><?php echo $record->filename; ?></td>
                            <td><audio src="<?php echo $location ?>"></audio></td>
                        </tr>
                        <?php endforeach; ?>
                        <script type="text/javascript">
                            audiojs.events.ready(function() {
                                var as = audiojs.createAll();
                            });                                                        
                        </script>                
                    <?php else: ?>
                    <tr>
                        <td class="text-center" colspan="7"><strong><?php echo 'No records found.' ?></strong></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="manual-activity">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4 class="table-title"><strong><?php echo 'MANUAL OUTBOUND CALLS FOR THIS TIME PERIOD: (10000 record limit)' ?></strong></h4>
                </div>
                <div class="col-md-6 text-right"><a class="btn btn-primary" href="<?php echo site_url('dialer/report/download?begin_date='.$postData['formdate'].'&end_date='.$postData['todate'].'&user='.$postData['user_start'].'&report=manuals&agency='.$postData['agency_id']) ?>"><?php echo 'Download' ?></a></div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo '#' ?></th>
                        <th><?php echo 'Date/Time' ?></th>
                        <th><?php echo 'Call Type' ?></th>
                        <th><?php echo 'Server' ?></th>
                        <th><?php echo 'Phone' ?></th>
                        <th><?php echo 'Dialed' ?></th>
                        <th><?php echo 'Lead' ?></th>
                        <th><?php echo 'CallerId' ?></th>
                        <th><?php echo 'Alias' ?></th>
                        <th><?php echo 'Preset' ?></th>
                        <th><?php echo 'C3HU' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($manuals): ?>
                        <?php $u = 0; ?>
                        <?php foreach($manuals as $manual): $u++; ?>
                            <?php
                                $C3HU='';
                                if ($manual->customer_hungup == 'BEFORE_CALL') {$manual->customer_hungup = 'BC';}
                                if ($manual->customer_hungup) {$manual->customer_hungup = 'DC';}
                                if (strlen($manual->customer_hungup) > 1){
                                    $C3HU = "$manual->customer_hungup $manual->customer_hungup_seconds";
                                }
                            ?>
                            <tr>
                                <td class="text-right"><?php echo $u ?></td>
                                <td><?php echo $manual->call_date ?></td>
                                <td><?php echo $manual->call_type ?></td>
                                <td><?php echo $manual->server_ip ?></td>
                                <td class="text-right"><?php echo $manual->phone_number ?></td>
                                <td class="text-right"><?php echo $manual->number_dialed ?></td>
                                <td class="text-right"><?php echo $manual->lead_id ?></td>
                                <td class="text-right"><?php echo $manual->callerid ?></td>
                                <td><?php echo $manual->group_alias_id ?></td>
                                <td><?php echo $manual->preset_name ?></td>
                                <td><?php echo $C3HU ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td class="text-center" colspan="12"><strong><?php echo 'No records found.' ?></strong></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
        <div class="lead-activity">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4 class="table-title"><strong><?php echo 'LEAD SEARCHES FOR THIS TIME PERIOD: (10000 record limit)' ?></strong></h4>
                </div>
                <div class="col-md-6 text-right"><a class="btn btn-primary" href="<?php echo site_url('dialer/report/download?begin_date='.$postData['formdate'].'&end_date='.$postData['todate'].'&user='.$postData['user_start'].'&report=searches&agency='.$postData['agency_id']) ?>"><?php echo 'Download' ?></a></div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo '#' ?></th>
                        <th><?php echo 'Lead' ?></th>
                        <th><?php echo 'Date/Time' ?></th>
                        <th><?php echo 'Type' ?></th>
                        <th><?php echo 'Results' ?></th>
                        <th><?php echo 'Sec' ?></th>
                        <th><?php echo 'Query' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($searches): ?>
                        <?php $u = 0;  ?>
                        <?php foreach($searches as $search): $u++;?>
                            <?php $search->search_query = preg_replace('/select count\(\*\) from vicidial_list where/','',$search->search_query); ?>
                            <?php $search->search_query = preg_replace('/SELECT lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner from vicidial_list where /','',$search->search_query); ?>
                            <tr>
                                <td><?php echo $u; ?></td>
                                <td><?php echo $search->event_date ?></td>
                                <td><?php echo $search->source ?></td>
                                <td><?php echo $search->results ?></td>
                                <td><?php echo $search->seconds ?></td>
                                <td><?php echo $search->search_query ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td class="text-center" colspan="7"><strong><?php echo 'No records found.' ?></strong></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="preview-activity">
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4 class="table-title"><strong><?php echo 'PREVIEW LEAD SKIPS FOR THIS TIME PERIOD: (10000 record limit)' ?></strong></h4>
                </div>
                <div class="col-md-6 text-right"><a class="btn btn-primary" href="<?php echo site_url('dialer/report/download?begin_date='.$postData['formdate'].'&end_date='.$postData['todate'].'&user='.$postData['user_start'].'&report=skips&agency='.$postData['agency_id']) ?>"><?php echo 'Download' ?></a></div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?php echo '#' ?></th>
                        <th><?php echo 'Date/Time' ?></th>
                        <th><?php echo 'Lead ID' ?></th>
                        <th><?php echo 'Status' ?></th>
                        <th><?php echo 'Count' ?></th>
                        <th><?php echo 'Campaign' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($skips): ?>
                        <?php $u = 0; ?>
                        <?php foreach($skips as $skip): $u++;?>
                            <tr>
                                <td><?php echo $u ?></td>
                                <td><?php echo $skip->event_date ?></td>
                                <td><?php echo $skip->lead_id ?></td>
                                <td><?php echo $skip->previous_status ?></td>
                                <td><?php echo $skip->previous_called_count ?></td>
                                <td><?php echo $skip->campaign_id ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td class="text-center" colspan="6"><strong><?php echo 'No records found.' ?></strong></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>
<style>
.dropdown-menu{z-index: 10000!important;}
</style>