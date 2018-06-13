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
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <form id="groupForm" name="groupForm" id="groupForm" action="" method="post" class="form-horizontal" >
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Group' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="user_group" maxlength="20" class="form-control" value="<?php echo $group->user_group; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Description' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="group_name" maxlength="40" class="form-control" value="<?php echo $group->group_name; ?>"/>
                    </div>
                </div>
                <?php /*
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Force Timeclock Login'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="forced_timeclock_login">
                            <option value="Y" <?php echo optionSetValue('Y',$group->forced_timeclock_login); ?>><?php echo 'Yes'; ?></option>
                            <option selected="" value="N" <?php echo optionSetValue('N',$group->forced_timeclock_login); ?>><?php echo 'No'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Shift Enforcement'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="shift_enforcement">
                            <option value="OFF" selected="" <?php echo optionSetValue('OFF',$group->shift_enforcement); ?>><?php echo 'OFF'; ?></option>
                            <option  value="ALL" <?php echo optionSetValue('ALL',$group->shift_enforcement); ?>><?php echo 'ALL'; ?></option>
                            <option  value="ADMIN_EXEMPT" <?php echo optionSetValue('ADMIN_EXEMPT',$group->shift_enforcement); ?>><?php echo 'ADMIN_EXEMPT'; ?></option>
                        </select>
                    </div>
                </div>
                 */ ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Allowed Campaigns'; ?></label>
                    <div class="col-md-4">
                        <?php $allowed_campaigns = preg_replace("/ -$/","",trim($group->allowed_campaigns)); ?>
                        <?php $allCampaigns = explode(" ", $allowed_campaigns); ?>
                        <select name="campaigns[]" class="form-control" multiple="">
                            <option value="-ALL-CAMPAIGNS-" <?php echo in_array('-ALL-CAMPAIGNS-' ,$allCampaigns) ? 'selected="selected"': '' ; ?>><?php echo '-ALL-CAMPAIGNS-' ?></option>
                            <?php foreach($campaigns as $campaign): ?>
                                <option value="<?php echo $campaign->campaign_id; ?>" <?php echo in_array($campaign->campaign_id ,$allCampaigns) ? 'selected="selected"': '' ; ?>><?php echo $campaign->campaign_id.' - '.$campaign->campaign_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?php /*
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Group Shifts'; ?></label>
                    <div class="col-md-4">
                        <select name="group_shifts[]" class="form-control">

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Status Viewable Groups'; ?></label>
                    <div class="col-md-4">
                        <select name="agent_status_viewable_groups[]" class="form-control">

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Status View Time'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="agent_status_view_time">
                            <option value="Y"><?php echo 'Yes'; ?></option>
                            <option selected="" value="N"><?php echo 'No'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Call Log View'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="agent_call_log_view">
                            <option value="Y"><?php echo 'Yes'; ?></option>
                            <option selected="" value="N"><?php echo 'No'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Allow Consultative Xfer'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="agent_xfer_consultative">
                            <option value="Y"><?php echo 'Yes'; ?></option>
                            <option selected="" value="N"><?php echo 'No'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Allow Dial Override Xfer'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="agent_xfer_dial_override">
                            <option value="Y"><?php echo 'Yes'; ?></option>
                            <option selected="" value="N"><?php echo 'No'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Allow Voicemail Message Xfer'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="agent_xfer_vm_transfer">
                            <option value="Y"><?php echo 'Yes'; ?></option>
                            <option selected="" value="N"><?php echo 'No'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Allow Blind Xfer'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="agent_xfer_blind_transfer">
                            <option value="Y"><?php echo 'Yes'; ?></option>
                            <option selected="" value="N"><?php echo 'No'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Allow Dial With Customer Xfer'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="agent_xfer_dial_with_customer">
                            <option value="Y"><?php echo 'Yes'; ?></option>
                            <option selected="" value="N"><?php echo 'No'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Allow Park Customer Dial Xfer'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="agent_xfer_park_customer_dial">
                            <option value="Y"><?php echo 'Yes'; ?></option>
                            <option selected="" value="N"><?php echo 'No'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Fullscreen'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="agent_fullscreen">
                            <option value="Y"><?php echo 'Yes'; ?></option>
                            <option selected="" value="N"><?php echo 'No'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Allowed Reports'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="allowed_reports[]">
                            <?php foreach(explode(',', $UGreports) as $key => $val): ?>
                                <option value="<?php echo trim($val); ?>" <?php echo $field_selected; ?>><?php echo trim($val); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Allowed User Groups'; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="admin_viewable_groups[]">

                        </select>
                    </div>
                </div>
                 */ ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Allowed Call Times'; ?></label>

                    <div class="col-md-4">
                        <?php $viewable_call_times = explode(' ', $group->admin_viewable_call_times) ?>
                        <div class="checkbox-list">
                            <label>
                                <input type="checkbox" name="admin_viewable_call_times[]" value="---ALL---" <?php echo in_array('---ALL---', $viewable_call_times) ? 'checked="checked"':'' ?>/>
                                <?php echo 'ALL-CALLTIMES - All call times in the system'; ?>
                            </label>
                            <?php foreach($calltimes as $calltime ): ?>
                            <label>
                                <input type="checkbox" name="admin_viewable_call_times[]" value="<?php echo $calltime->call_time_id; ?>" <?php echo in_array($calltime->call_time_id, $viewable_call_times) ? 'checked="checked"':'' ?>/>
                                <span><?php echo $calltime->call_time_id ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
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
jQuery(function(){
    jQuery('#groupForm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules:{
           user_group :{
               required: true,
               minlenght: 2,
               maxlenght: 20,

           },
           group_name:{
               required: true,
               maxlenght: 40,
           }
       },
        highlight: function (element) { // hightlight error inputs
             $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
});
</script>