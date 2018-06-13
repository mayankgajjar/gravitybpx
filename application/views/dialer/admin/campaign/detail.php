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
    <div class="page-toolbar">
    </div>
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
    <div class="portlet-body form">
       <div class="tabbable-line">
           <?php $this->load->view('dialer/admin/campaign/tabs') ?>
          <div class="tab-content">
              <div class="tab-pane active" id="tab_15_1">
        <form name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign ID"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <label class="control-label"><strong><?php echo $campaign->campaign_id ?></strong></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Agency"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <?php  $tree = buildTree($agencies,0); ?>
                        <select name="agency_id" class="form-control" class="agency_id">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <?php echo printTree($tree,0, null, $campaign->agency_id ); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign Name"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="campaign_name" class="form-control" maxlength="30" size="30" value="<?php echo $campaign->campaign_name ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign Description"; ?></label>
                    <div class="col-md-4">
                        <textarea name="campaign_description" class="form-control"><?php echo $campaign->campaign_description ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign Change Date" ?></label>
                    <div class="col-md-4">
                        <label class="control-label"><strong><?php echo $campaign->modified ?></strong></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Campaign Login Date' ?></label>
                    <div class="col-md-4">
                        <?php if (strtotime($campaign->campaign_logindate)) : ?>
                            <label class="control-label"><strong><?php echo $campaign->campaign_logindate ?></strong></label>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Campaign Call Date' ?></label>
                    <div class="col-md-4">
                        <?php if (strtotime($campaign->campaign_calldate)) : ?>
                            <label class="control-label"><strong><?php echo $campaign->campaign_calldate ?></strong></label>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Active"; ?></label>
                    <div class="col-md-4">
                        <select name="active" id="active" class="form-control">
                            <option value="<?php echo "Y"; ?>" <?php echo optionSetValue($campaign->active,'Y') ?>><?php echo "Yes"; ?></option>
                            <option value="<?php echo "N"; ?>" <?php echo optionSetValue($campaign->active,'N') ?>><?php echo "No"; ?></option>
                        </select>
                    </div>
                </div>
<!--                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Park Music-on-Hold"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="park_file_name" class="form-control" value="<?php echo $campaign->park_file_name ?>">
                    </div>
                    <div class="col-md-3">
                        <a href="#"><?php echo "moh chooser"; ?></a>
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Web Form"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="web_form_address" class="form-control" value="<?php echo $campaign->web_form_address ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Web Form Target' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="web_form_target" class="form-control" value="<?php echo $campaign->web_form_target ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Allow Closers"; ?></label>
                    <div class="col-md-4">
                        <select name="allow_closers" id="allow_closers" class="form-control">
                            <option value="<?php echo "Y"; ?>" <?php echo optionSetValue($campaign->allow_closers,'Y') ?>><?php echo "Yes"; ?></option>
                            <option value="<?php echo "N"; ?>" <?php echo optionSetValue($campaign->allow_closers,'N') ?>><?php echo "No"; ?></option>
                        </select>
                    </div>
                </div>
                <?php if( (bool)get_dialer_option('outbound_autodial_active') == TRUE ) : ?>
                <h4 class="form-section"></h4>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Allow Inbound and Blended' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="campaign_allow_inbound">
                            <option value="<?php echo "Y"; ?>" <?php echo optionSetValue($campaign->campaign_allow_inbound,'Y') ?>><?php echo "Yes"; ?></option>
                            <option value="<?php echo "N"; ?>" <?php echo optionSetValue($campaign->campaign_allow_inbound,'N') ?>><?php echo "No"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Add A Dial Status to Call: '; ?></label>
                    <div class="col-md-4">
                        <select name="dial_statuses" class="form-control">
                            <?php echo getDialStatuses(NULL,$campaign->id); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'List Orders' ?></label>
                    <div class="col-md-4">
                        <select name="lead_order" class="form-control">
            				<option value='DOWN' <?php echo optionSetValue($campaign->lead_order,'DOWN') ?>><?php echo "DOWN" ?></option>
            				<option value='UP' selected="" <?php echo optionSetValue($campaign->lead_order,'up') ?>><?php echo "UP" ?></option>
            				<option value='DOWN PHONE' <?php echo optionSetValue($campaign->lead_order,'DOWN PHONE') ?>><?php echo "DOWN PHONE" ?></option>
            				<option value='UP PHONE' <?php echo optionSetValue($campaign->lead_order,'UP PHONE') ?>><?php echo "UP PHONE" ?></option>
            				<option value='DOWN LAST NAME' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST NAME') ?>><?php echo "DOWN LAST NAME" ?></option>
            				<option value='UP LAST NAME' <?php echo optionSetValue($campaign->lead_order,'UP LAST NAME') ?>><?php echo "UP LAST NAME" ?></option>
            				<option value='DOWN COUNT' <?php echo optionSetValue($campaign->lead_order,'DOWN COUNT') ?>><?php echo "DOWN COUNT" ?></option>
            				<option value='UP COUNT' <?php echo optionSetValue($campaign->lead_order,'UP COUNT') ?>><?php echo "UP COUNT" ?></option>
            				<option value='RANDOM' <?php echo optionSetValue($campaign->lead_order,'RANDOM') ?>><?php echo "RANDOM" ?></option>
            				<option value='DOWN LAST CALL TIME' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST CALL TIME') ?>><?php echo "DOWN LAST CALL TIME" ?></option>
            				<option value='UP LAST CALL TIME' <?php echo optionSetValue($campaign->lead_order,'UP LAST CALL TIME') ?>><?php echo "UP LAST CALL TIME" ?></option>
            				<option value='DOWN RANK' <?php echo optionSetValue($campaign->lead_order,'DOWN RANK') ?>><?php echo "DOWN RANK" ?></option>
            				<option value='UP RANK' <?php echo optionSetValue($campaign->lead_order,'UP RANK') ?>><?php echo "UP RANK" ?></option>
            				<option value='DOWN OWNER' <?php echo optionSetValue($campaign->lead_order,'DOWN OWNER') ?>><?php echo "DOWN OWNER" ?></option>
            				<option value='UP OWNER' <?php echo optionSetValue($campaign->lead_order,'UP OWNER') ?>><?php echo "UP OWNER" ?></option>
            				<option value='DOWN TIMEZONE' <?php echo optionSetValue($campaign->lead_order,'DOWN TIMEZONE') ?>><?php echo "DOWN TIMEZONE" ?></option>
            				<option value='UP TIMEZONE' <?php echo optionSetValue($campaign->lead_order,'UP TIMEZONE') ?>>UP TIMEZONE</option>
            				<option value='DOWN 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN 2nd NEW') ?>>DOWN 2nd NEW</option>
            				<option value='DOWN 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN 3rd NEW') ?>>DOWN 3rd NEW</option>
            				<option value='DOWN 4th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN 4th NEW') ?>>DOWN 4th NEW</option>
            				<option value='DOWN 5th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN 5th NEW') ?>>DOWN 5th NEW</option>
            				<option value='DOWN 6th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN 6th NEW') ?>>DOWN 6th NEW</option>
            				<option value='UP 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'UP 2nd NEW') ?>>UP 2nd NEW</option>
            				<option value='UP 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'UP 3rd NEW') ?>>UP 3rd NEW</option>
            				<option value='UP 4th NEW' <?php echo optionSetValue($campaign->lead_order,'UP 4th NEW') ?>>UP 4th NEW</option>
            				<option value='UP 5th NEW' <?php echo optionSetValue($campaign->lead_order,'UP 5th NEW') ?>>UP 5th NEW</option>
            				<option value='UP 6th NEW' <?php echo optionSetValue($campaign->lead_order,'UP 6th NEW') ?>>UP 6th NEW</option>
            				<option value='DOWN PHONE 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN PHONE 2nd NEW') ?>>DOWN PHONE 2nd NEW</option>
            				<option value='DOWN PHONE 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN PHONE 3rd NEW') ?>>DOWN PHONE 3rd NEW</option>
            				<option value='DOWN PHONE 4th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN PHONE 4th NEW') ?>>DOWN PHONE 4th NEW</option>
            				<option value='DOWN PHONE 5th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN PHONE 5th NEW') ?>>DOWN PHONE 5th NEW</option>
            				<option value='DOWN PHONE 6th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN PHONE 6th NEW') ?>>DOWN PHONE 6th NEW</option>
            				<option value='UP PHONE 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'UP PHONE 2nd NEW') ?>>UP PHONE 2nd NEW</option>
            				<option value='UP PHONE 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'UP PHONE 3rd NEW') ?>>UP PHONE 3rd NEW</option>
            				<option value='UP PHONE 4th NEW' <?php echo optionSetValue($campaign->lead_order,'UP PHONE 4th NEW') ?>>UP PHONE 4th NEW</option>
            				<option value='UP PHONE 5th NEW' <?php echo optionSetValue($campaign->lead_order,'UP PHONE 5th NEW') ?>>UP PHONE 5th NEW</option>
            				<option value='UP PHONE 6th NEW' <?php echo optionSetValue($campaign->lead_order,'UP PHONE 6th NEW') ?>>UP PHONE 6th NEW</option>
            				<option value='DOWN LAST NAME 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST NAME 2nd NEW') ?>>DOWN LAST NAME 2nd NEW</option>
            				<option value='DOWN LAST NAME 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST NAME 3rd NEW') ?>>DOWN LAST NAME 3rd NEW</option>
            				<option value='DOWN LAST NAME 4th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST NAME 4th NEW') ?>>DOWN LAST NAME 4th NEW</option>
            				<option value='DOWN LAST NAME 5th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST NAME 5th NEW') ?>>DOWN LAST NAME 5th NEW</option>
            				<option value='DOWN LAST NAME 6th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST NAME 6th NEW') ?>>DOWN LAST NAME 6th NEW</option>
            				<option value='UP LAST NAME 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'UP LAST NAME 2nd NEW') ?>>UP LAST NAME 2nd NEW</option>
            				<option value='UP LAST NAME 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'UP LAST NAME 3rd NEW') ?>>UP LAST NAME 3rd NEW</option>
            				<option value='UP LAST NAME 4th NEW' <?php echo optionSetValue($campaign->lead_order,'UP LAST NAME 4th NEW') ?>>UP LAST NAME 4th NEW</option>
            				<option value='UP LAST NAME 5th NEW' <?php echo optionSetValue($campaign->lead_order,'UP LAST NAME 5th NEW') ?>>UP LAST NAME 5th NEW</option>
            				<option value='UP LAST NAME 6th NEW' <?php echo optionSetValue($campaign->lead_order,'UP LAST NAME 6th NEW') ?>>UP LAST NAME 6th NEW</option>
            				<option value='DOWN COUNT 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN COUNT 2nd NEW') ?>>DOWN COUNT 2nd NEW</option>
            				<option value='DOWN COUNT 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN COUNT 3rd NEW') ?>>DOWN COUNT 3rd NEW</option>
            				<option value='DOWN COUNT 4th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN COUNT 4th NEW') ?>>DOWN COUNT 4th NEW</option>
            				<option value='DOWN COUNT 5th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN COUNT 5th NEW') ?>>DOWN COUNT 5th NEW</option>
            				<option value='DOWN COUNT 6th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN COUNT 6th NEW') ?>>DOWN COUNT 6th NEW</option>
            				<option value='UP COUNT 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'UP COUNT 2nd NEW') ?>>UP COUNT 2nd NEW</option>
            				<option value='UP COUNT 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'UP COUNT 3rd NEW') ?>>UP COUNT 3rd NEW</option>
            				<option value='UP COUNT 4th NEW' <?php echo optionSetValue($campaign->lead_order,'UP COUNT 4th NEW') ?>>UP COUNT 4th NEW</option>
            				<option value='UP COUNT 5th NEW' <?php echo optionSetValue($campaign->lead_order,'UP COUNT 5th NEW') ?>>UP COUNT 5th NEW</option>
            				<option value='UP COUNT 6th NEW' <?php echo optionSetValue($campaign->lead_order,'UP COUNT 6th NEW') ?>>UP COUNT 6th NEW</option>
            				<option value='RANDOM 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'RANDOM 2nd NEW') ?>>RANDOM 2nd NEW</option>
            				<option value='RANDOM 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'RANDOM 3rd NEW') ?>>RANDOM 3rd NEW</option>
            				<option value='RANDOM 4th NEW' <?php echo optionSetValue($campaign->lead_order,'RANDOM 4th NEW') ?>>RANDOM 4th NEW</option>
            				<option value='RANDOM 5th NEW' <?php echo optionSetValue($campaign->lead_order,'RANDOM 5th NEW') ?>>RANDOM 5th NEW</option>
            				<option value='RANDOM 6th NEW' <?php echo optionSetValue($campaign->lead_order,'RANDOM 6th NEW') ?>>RANDOM 6th NEW</option>
            			     <option value='DOWN LAST CALL TIME 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST CALL TIME 2nd NEW') ?>>DOWN LAST CALL TIME 2nd NEW</option>
            			     <option value='DOWN LAST CALL TIME 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST CALL TIME 3rd NEW') ?>>DOWN LAST CALL TIME 3rd NEW</option>
            			     <option value='DOWN LAST CALL TIME 4th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST CALL TIME 4th NEW') ?>>DOWN LAST CALL TIME 4th NEW</option>
            			     <option value='DOWN LAST CALL TIME 5th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST CALL TIME 5th NEW') ?>>DOWN LAST CALL TIME 5th NEW</option>
            			     <option value='DOWN LAST CALL TIME 6th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN LAST CALL TIME 6th NEW') ?>>DOWN LAST CALL TIME 6th NEW</option>
            			     <option value='UP LAST CALL TIME 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'UP LAST CALL TIME 2nd NEW') ?>>UP LAST CALL TIME 2nd NEW</option>
            			     <option value='UP LAST CALL TIME 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'UP LAST CALL TIME 3rd NEW') ?>>UP LAST CALL TIME 3rd NEW</option>
            			     <option value='UP LAST CALL TIME 4th NEW' <?php echo optionSetValue($campaign->lead_order,'UP LAST CALL TIME 4th NEW') ?>>UP LAST CALL TIME 4th NEW</option>
            			     <option value='UP LAST CALL TIME 5th NEW' <?php echo optionSetValue($campaign->lead_order,'UP LAST CALL TIME 5th NEW') ?>>UP LAST CALL TIME 5th NEW</option>
            			     <option value='UP LAST CALL TIME 6th NEW' <?php echo optionSetValue($campaign->lead_order,'UP LAST CALL TIME 6th NEW') ?>>UP LAST CALL TIME 6th NEW</option>
            				<option value='DOWN RANK 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN RANK 2nd NEW') ?>>DOWN RANK 2nd NEW</option>
            				<option value='DOWN RANK 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN RANK 3rd NEW') ?>>DOWN RANK 3rd NEW</option>
            				<option value='DOWN RANK 4th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN RANK 4th NEW') ?>>DOWN RANK 4th NEW</option>
            				<option value='DOWN RANK 5th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN RANK 5th NEW') ?>>DOWN RANK 5th NEW</option>
            				<option value='DOWN RANK 6th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN RANK 6th NEW') ?>>DOWN RANK 6th NEW</option>
            				<option value='UP RANK 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'UP RANK 2nd NEW') ?>>UP RANK 2nd NEW</option>
            				<option value='UP RANK 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'UP RANK 3rd NEW') ?>>UP RANK 3rd NEW</option>
            				<option value='UP RANK 4th NEW' <?php echo optionSetValue($campaign->lead_order,'UP RANK 4th NEW') ?>>UP RANK 4th NEW</option>
            				<option value='UP RANK 5th NEW' <?php echo optionSetValue($campaign->lead_order,'UP RANK 5th NEW') ?>>UP RANK 5th NEW</option>
            				<option value='UP RANK 6th NEW' <?php echo optionSetValue($campaign->lead_order,'UP RANK 6th NEW') ?>>UP RANK 6th NEW</option>
            				<option value='DOWN OWNER 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN OWNER 2nd NEW') ?>>DOWN OWNER 2nd NEW</option>
            				<option value='DOWN OWNER 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN OWNER 3rd NEW') ?>>DOWN OWNER 3rd NEW</option>
            				<option value='DOWN OWNER 4th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN OWNER 4th NEW') ?>>DOWN OWNER 4th NEW</option>
            				<option value='DOWN OWNER 5th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN OWNER 5th NEW') ?>>DOWN OWNER 5th NEW</option>
            				<option value='DOWN OWNER 6th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN OWNER 6th NEW') ?>>DOWN OWNER 6th NEW</option>
            				<option value='UP OWNER 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'UP OWNER 2nd NEW') ?>>UP OWNER 2nd NEW</option>
            				<option value='UP OWNER 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'UP OWNER 3rd NEW') ?>>UP OWNER 3rd NEW</option>
            				<option value='UP OWNER 4th NEW' <?php echo optionSetValue($campaign->lead_order,'UP OWNER 4th NEW') ?>>UP OWNER 4th NEW</option>
            				<option value='UP OWNER 5th NEW' <?php echo optionSetValue($campaign->lead_order,'UP OWNER 5th NEW') ?>>UP OWNER 5th NEW</option>
            				<option value='UP OWNER 6th NEW' <?php echo optionSetValue($campaign->lead_order,'UP OWNER 6th NEW') ?>>UP OWNER 6th NEW</option>
            				<option value='DOWN TIMEZONE 2nd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN TIMEZONE 2nd NEW') ?>>DOWN TIMEZONE 2nd NEW</option>
            				<option value='DOWN TIMEZONE 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN TIMEZONE 3rd NEW') ?>>DOWN TIMEZONE 3rd NEW</option>
            				<option value='DOWN TIMEZONE 4th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN TIMEZONE 4th NEW') ?>>DOWN TIMEZONE 4th NEW</option>
            				<option value='DOWN TIMEZONE 5th NEW' <?php echo optionSetValue($campaign->lead_order,'DOWN TIMEZONE 5th NEW') ?>>DOWN TIMEZONE 5th NEW</option>
            				<option value='DOWN TIMEZONE 6th NEW' <?php echo optionSetValue($campaign->lead_order,'UP TIMEZONE 6th NEW') ?>>DOWN TIMEZONE 6th NEW</option>
            				<option value='DOWN TIMEZONE 6th NEW' <?php echo optionSetValue($campaign->lead_order,'UP TIMEZONE 2nd NEW') ?>>UP TIMEZONE 2nd NEW</option>
            				<option value='UP TIMEZONE 3rd NEW' <?php echo optionSetValue($campaign->lead_order,'UP TIMEZONE 3rd NEW') ?>>UP TIMEZONE 3rd NEW</option>
            				<option value='UP TIMEZONE 4th NEW' <?php echo optionSetValue($campaign->lead_order,'UP TIMEZONE 4th NEW') ?>>UP TIMEZONE 4th NEW</option>
            				<option value='UP TIMEZONE 5th NEW' <?php echo optionSetValue($campaign->lead_order,'UP TIMEZONE 5th NEW') ?>>UP TIMEZONE 5th NEW</option>
            				<option value='UP TIMEZONE 6th NEW' <?php echo optionSetValue($campaign->lead_order,'UP TIMEZONE 6th NEW') ?>>UP TIMEZONE 6th NEW</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'List Order Randomize' ?></label>
                    <div class="col-md-4">
                        <select name="lead_order_randomize" class="form-control">
                            <option value="Y" <?php echo optionSetValue($campaign->lead_order_randomize,'Y') ?>><?php  echo "YES"; ?></option>
                            <option value="N" <?php echo optionSetValue($campaign->lead_order_randomize,'N') ?>><?php  echo "NO"; ?></option>
                        <select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "List Order Randomize"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="lead_order_secondary">
                            <option value='LEAD_ASCEND' <?php echo optionSetValue($campaign->lead_order_secondary,'LEAD_ASCEND') ?>>LEAD_ASCEND</option>
                            <option value='LEAD_DESCEND' <?php echo optionSetValue($campaign->lead_order_secondary,'LEAD_DESCEND') ?>>LEAD_DESCEND</option>
                            <option value='CALLTIME_ASCEND' <?php echo optionSetValue($campaign->lead_order_secondary,'CALLTIME_ASCEND') ?>>CALLTIME_ASCEND</option>
                            <option value='CALLTIME_DESCEND' <?php echo optionSetValue($campaign->lead_order_secondary,'CALLTIME_DESCEND') ?>>CALLTIME_DESCEND</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Lead Filter' ?></label>
                    <div class="col-md-3">
                        <select class="form-control" name="lead_order_secondary">
                            <option value=""><?php echo "None"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Drop Lockout Time"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="drop_lockout_time" value="<?php $campaign->drop_lockout_time ?>" maxlenght="6" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Call Count Limit"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="call_count_limit" value="<?php $campaign->call_count_limit ?>" maxlenght="5" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Call Count Target"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="call_count_target" value="<?php $campaign->call_count_target ?>" maxlenght="5" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Minimum Hopper Level"; ?></label>
                    <div class="col-md-4">
                        <select name="hopper_level" id="hopper_level" class="form-control">
                            <option value="<?php echo 1; ?>"  <?php echo optionSetValue($campaign->hopper_level,'1') ?>><?php echo 1; ?></option>
                            <option value="<?php echo 5; ?>"  <?php echo optionSetValue($campaign->hopper_level,'5') ?>><?php echo 5; ?></option>
                            <option value="<?php echo 10; ?>" <?php echo optionSetValue($campaign->hopper_level,'10') ?>><?php echo 10; ?></option>
                            <option value="<?php echo 20; ?>" <?php echo optionSetValue($campaign->hopper_level,'20') ?>><?php echo 20; ?></option>
                            <option value="<?php echo 50; ?>" <?php echo optionSetValue($campaign->hopper_level,'50') ?>><?php echo 50; ?></option>
                            <option value="<?php echo 100; ?>" <?php echo optionSetValue($campaign->hopper_level,'100') ?>><?php echo 100; ?></option>
                            <option value="<?php echo 200; ?>" <?php echo optionSetValue($campaign->hopper_level,'200') ?>><?php echo 200; ?></option>
                            <option value="<?php echo 500; ?>"  <?php echo optionSetValue($campaign->hopper_level,'500') ?>><?php echo 500; ?></option>
                            <option value="<?php echo 1000; ?>" <?php echo optionSetValue($campaign->hopper_level,'1000') ?>><?php echo 1000; ?></option>
                            <option value="<?php echo 2000; ?>" <?php echo optionSetValue($campaign->hopper_level,'2000') ?>><?php echo 2000; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Automatic Hopper Level' ?></label>
                    <div class="col-md-4">
                        <select name="use_auto_hopper" class="form-control">
                            <option value="Y" <?php echo optionSetValue($campaign->use_auto_hopper,'Y') ?>><?php  echo "YES"; ?></option>
                            <option value="N" <?php echo optionSetValue($campaign->use_auto_hopper,'N') ?>><?php  echo "NO"; ?></option>
                        <select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Automatic Hopper Multiplier"; ?></label>
                    <div class="col-md-4">
                        <select name="auto_hopper_multi" class="form-control">
                            <option value="0.1" <?php echo optionSetValue($campaign->auto_hopper_multi,0.1) ?>>0.1</option>
                            <option value="0.2" <?php echo optionSetValue($campaign->auto_hopper_multi,0.2) ?>>0.2</option>
                            <option value="0.3" <?php echo optionSetValue($campaign->auto_hopper_multi,0.3) ?>>0.3</option>
                            <option value="0.4" <?php echo optionSetValue($campaign->auto_hopper_multi,0.4) ?>>0.4</option>
                            <option value="0.5" <?php echo optionSetValue($campaign->auto_hopper_multi,0.5) ?>>0.5</option>
                            <option value="0.6" <?php echo optionSetValue($campaign->auto_hopper_multi,0.6) ?>>0.6</option>
                            <option value="0.7" <?php echo optionSetValue($campaign->auto_hopper_multi,0.7) ?>>0.7</option>
                            <option value="0.8" <?php echo optionSetValue($campaign->auto_hopper_multi,0.8) ?>>0.8</option>
                            <option value="0.9" <?php echo optionSetValue($campaign->auto_hopper_multi,0.9) ?>>0.9</option>
                            <option value="1.0" <?php echo optionSetValue($campaign->auto_hopper_multi,1.0) ?>>1.0</option>
                            <option value="1.1" <?php echo optionSetValue($campaign->auto_hopper_multi,1.1) ?>>1.1</option>
                            <option value="1.2" <?php echo optionSetValue($campaign->auto_hopper_multi,1.2) ?>>1.2</option>
                            <option value="1.3" <?php echo optionSetValue($campaign->auto_hopper_multi,1.3) ?>>1.3</option>
                            <option value="1.4" <?php echo optionSetValue($campaign->auto_hopper_multi,1.4) ?>>1.4</option>
                            <option value="1.5" <?php echo optionSetValue($campaign->auto_hopper_multi,1.5) ?>>1.5</option>
                            <option value="1.6" <?php echo optionSetValue($campaign->auto_hopper_multi,1.6) ?>>1.6</option>
                            <option value="1.7" <?php echo optionSetValue($campaign->auto_hopper_multi,1.7) ?>>1.7</option>
                            <option value="1.8" <?php echo optionSetValue($campaign->auto_hopper_multi,1.8) ?>>1.8</option>
                            <option value="1.9" <?php echo optionSetValue($campaign->auto_hopper_multi,1.9) ?>>1.9</option>
                            <option value="2.0" <?php echo optionSetValue($campaign->auto_hopper_multi,2.0) ?>>2.0</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Auto Trim Hopper' ?></label>
                    <div class="col-md-4">
                        <select name="auto_trim_hopper" class="form-control">
                            <option value="Y" <?php echo optionSetValue($campaign->auto_trim_hopper,'Y') ?>><?php  echo "YES"; ?></option>
                            <option value="N" <?php echo optionSetValue($campaign->auto_trim_hopper,'N') ?>><?php  echo "NO"; ?></option>
                        <select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Hopper VLC Dup Check' ?></label>
                    <div class="col-md-4">
                        <select name="hopper_vlc_dup_check" class="form-control">
                            <option value="Y" <?php echo optionSetValue($campaign->hopper_vlc_dup_check,'Y') ?>><?php  echo "YES"; ?></option>
                            <option value="N" <?php echo optionSetValue($campaign->hopper_vlc_dup_check,'N') ?>><?php  echo "NO"; ?></option>
                        <select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Force Reset of Hopper' ?></label>
                    <div class="col-md-4">
                        <select name="reset_hopper" class="form-control">
                            <option value="Y" <?php echo optionSetValue($campaign->reset_hopper,'Y') ?>><?php  echo "YES"; ?></option>
                            <option value="N" <?php echo optionSetValue($campaign->reset_hopper,'N') ?>><?php  echo "NO"; ?></option>
                        <select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Dial Method"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="dial_method">
                            <option value='MANUAL' <?php echo optionSetValue($campaign->dial_method,'MANUAL'); ?>>MANUAL</option>
                            <option value='RATIO' <?php echo optionSetValue($campaign->dial_method,'RATIO'); ?>>RATIO</option>
                            <option value='ADAPT_HARD_LIMIT' <?php echo optionSetValue($campaign->dial_method,'ADAPT_HARD_LIMIT'); ?>>ADAPT_HARD_LIMIT</option>
                            <option value='ADAPT_TAPERED' <?php echo optionSetValue($campaign->dial_method,'ADAPT_TAPERED'); ?>>ADAPT_TAPERED</option>
                            <option value='ADAPT_AVERAGE' <?php echo optionSetValue($campaign->dial_method,'ADAPT_AVERAGE'); ?>>ADAPT_AVERAGE</option>
                            <option value='INBOUND_MAN' <?php echo optionSetValue($campaign->dial_method,'INBOUND_MAN'); ?>>INBOUND_MAN</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Auto Dial Level"; ?></label>
                    <div class="col-md-4">
                        <?php $limit = get_dialer_option('auto_dial_limit'); ?>
                        <select name="auto_dial_level" id="auto_dial_level" class="form-control">
                            <?php $adl = 0; ?>
                            <?php while( $adl <= $limit ): ?>
                            <option value="<?php echo $adl ?>" <?php echo optionSetValue($campaign->auto_dial_level,$adl) ?>><?php echo $adl ?></option>
                            <?php
                            if ($adl < 1)
                                {$adl = ($adl + 1);}
                            else
                                {
                                if ($adl < 3)
                                    {$adl = ($adl + 0.1);}
                                else
                                    {
                                    if ($adl < 4)
                                        {$adl = ($adl + 0.25);}
                                    else
                                        {
                                        if ($adl < 5)
                                            {$adl = ($adl + 0.5);}
                                        else
                                            {
                                            if ($adl < 10)
                                                {$adl = ($adl + 1);}
                                            else
                                                {
                                                if ($adl < 20)
                                                    {$adl = ($adl + 2);}
                                                else
                                                    {
                                                    if ($adl < 40)
                                                        {$adl = ($adl + 5);}
                                                    else
                                                        {
                                                        if ($adl < 200)
                                                            {$adl = ($adl + 10);}
                                                        else
                                                            {
                                                            if ($adl < 400)
                                                                {$adl = ($adl + 50);}
                                                            else
                                                                {
                                                                if ($adl < 1000)
                                                                    {$adl = ($adl + 100);}
                                                                else
                                                                    {$adl = ($adl + 1);}
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                            ?>
                            <?php endwhile; ?>
                        </select>
                        <span class="help-block"> <?php echo '(0 = off)' ?>  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Auto Dial Level Threshold' ?></label>
                    <div class="col-md-4">
                        <select name="dial_level_threshold" class="form-control">
                            <option value='DISABLED' <?php echo optionSetValue($campaign->dial_level_threshold,'DISABLED'); ?>>DISABLED</option>
                            <option value='LOGGED-IN_AGENTS' <?php echo optionSetValue($campaign->dial_level_threshold,'LOGGED-IN_AGENTS'); ?>>LOGGED-IN_AGENTS</option>
                            <option value='NON-PAUSED_AGENTS' <?php echo optionSetValue($campaign->dial_level_threshold,'NON-PAUSED_AGENTS'); ?>>NON-PAUSED_AGENTS</option>
                            <option value='WAITING_AGENTS' <?php echo optionSetValue($campaign->dial_level_threshold,'WAITING_AGENTS'); ?>>WAITING_AGENTS</option>
                        </select>
                    </div>
                    <label class="col-md-1 control-label"><?php echo "agents"; ?></label>
                    <div class="col-md-2">
                        <select name="dial_level_threshold_agents" class="form-control">
                            <?php $i = 0 ?>
                            <?php while( $i <= 50 ): ?>
                                <option value="<?php echo $i; ?>" <?php echo optionSetValue($campaign->dial_level_threshold_agents,$i); ?>><?php echo $i;?></option>
                                <?php if( $i >= 40 ): ?>
                                    <?php $i = $i+10; ?>
                                <?php elseif($i >= 20): ?>
                                    <?php $i = $i+5; ?>
                                <?php else: ?>
                                    <?php $i++; ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Dial Level Difference Target' ?></label>
                    <div class="col-md-4">
                        <select name="adaptive_dl_diff_target" class="form-control">
                            <?php $n = 40; ?>
                            <?php while( $n >= -40): ?>
                                <?php
                                    $nabs = abs($n);
                                    $str = 'Balanced';
                                    if ($n<0) {$str = "Agents Waiting for Calls";}
                                    if ($n>0) {$str = "Calls Waiting for Agents";}
                                ?>
                                <option value="<?php echo $n; ?>" <?php echo optionSetValue($campaign->adaptive_dl_diff_target,$n); ?>><?php echo $n.' --- '.$nabs.' '.$str ?></option>
                                <?php $n-- ?>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Dial Level Difference Target Method"; ?></label>
                    <div class="col-md-4">
                        <select name="dl_diff_target_method" class="form-control">
                            <option value="<?php echo 'ADAPT_CALC_ONLY'; ?>" <?php echo optionSetValue($campaign->dl_diff_target_method,'ADAPT_CALC_ONLY'); ?>><?php echo "ADAPT_CALC_ONLY"; ?></option>
                            <option value="<?php echo 'CALLS_PLACED'; ?>" <?php echo optionSetValue($campaign->dl_diff_target_method,'CALLS_PLACED'); ?>><?php echo "CALLS_PLACED"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Concurrent Transfers"; ?></label>
                    <div class="col-md-4">
                        <select name="concurrent_transfers" class="form-control">
                            <option class="<?php echo "AUTO"; ?>"><?php echo "AUTO"; ?></option>
                            <?php $i = 0 ?>
                            <?php while( $i <= 100 ): ?>
                                <option value="<?php echo $i; ?>" <?php echo optionSetValue($campaign->concurrent_transfers,$i); ?>><?php echo $i;?></option>
                                <?php if( $i >= 60 ): ?>
                                    <?php $i = $i+20; ?>
                                <?php elseif( $i >= 40 ): ?>
                                    <?php $i = $i+10; ?>
                                <?php elseif($i >= 20): ?>
                                    <?php $i = $i+5; ?>
                                <?php else: ?>
                                    <?php $i++; ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Queue Priority"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="queue_priority">
                            <?php $n = 99;  ?>
                            <?php while($n >= -99): ?>
                                <?php
                                    if ($n<0) {$str = "Lower";}
                                    if ($n>0) {$str = "Higher";}
                                ?>
                                <option value="<?php echo $n; ?>"><?php echo $n .'-'. $str; ?></option>
                            <?php $n--; ?>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="drop_rate_group" value="DISABLED" />
                <input type="hidden" name="inbound_queue_no_dial" value="DISABLED" />
                <input type="hidden" name="auto_alt_dial" value="NONE" />
            <?php endif; ?>
                <h4 class="form-section"></h4>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Next Agent Call"; ?></label>
                    <div class="col-md-4">
                        <select name="next_agent_call" id="next_agent_call" class="form-control">
                            <option value="<?php echo "random"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'random') ?>><?php echo "random"; ?></option>
                            <option value="<?php echo "oldest_call_start"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'oldest_call_start') ?>><?php echo "oldest_call_start"; ?></option>
                            <option value="<?php echo "oldest_call_finish"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'oldest_call_finish') ?>><?php echo "oldest_call_finish"; ?></option>
                            <option value="<?php echo "campaign_rank"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'campaign_rank') ?>><?php echo "campaign_rank"; ?></option>
                            <option value="<?php echo "overall_user_level"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'overall_user_level') ?>><?php echo "overall_user_level"; ?></option>
                            <option value="<?php echo "fewest_calls"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'fewest_calls') ?>><?php echo "fewest_calls"; ?></option>
                            <option value="<?php echo "longest_wait_time"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'longest_wait_time') ?>><?php echo "longest_wait_time"; ?></option>
                            <option value="<?php echo "campaign_grade_random"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'campaign_grade_random') ?>><?php echo "campaign_grade_random"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Local Call Time"; ?></label>
                    <div class="col-md-4">
                        <select name="local_call_time" id="local_call_time" class="form-control">
                            <?php echo get_local_call_times($campaign->local_call_time); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Dial Timeout"; ?></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="dial_timeout" maxlength="3" value="<?php echo $campaign->dial_timeout; ?>" />
                        <span class="help-content"><?php echo "in seconds"; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Dial Prefix"; ?></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="dial_prefix" value="<?php echo $campaign->dial_prefix; ?>" maxlenght="20" />
                        <span class="help-content"><?php echo "91NXXNXXXXXX value would be 9, for no dial prefix use X"; ?></span>
                    </div>
                </div>

                <input type="hidden" class="form-control" name="manual_dial_prefix" value="<?php echo $campaign->manual_dial_prefix; ?>" maxlenght="20" />
                <input type="hidden" name="omit_phone_code" value="N" />
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign CallerID"; ?></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="campaign_cid" value="<?php echo $campaign->campaign_cid; ?>" maxlenght="20" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Custom CallerID"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="use_custom_cid">
                            <option value="N" <?php echo optionSetValue($campaign->use_custom_cid,'N'); ?>>NO</option>
                            <option value="AREACODE" <?php echo optionSetValue($campaign->use_custom_cid,'AREACODE'); ?>>AREACODE</option>
                        </select>
                    </div>
                </div>
                <?php if( (bool)get_dialer_option('outbound_autodial_active') == TRUE ) : ?>
                    <input type="hidden" name="campaign_vdad_exten" value="8368">
                <?php endif; ?>
                <input type="hidden" name="campaign_rec_exten" value="8309">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign Recording"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="campaign_recording">
                            <option value='NEVER' <?php echo optionSetValue($campaign->campaign_recording,'NEVER'); ?>>NEVER</option>
                            <option value='ONDEMAND' <?php echo optionSetValue($campaign->campaign_recording,'ONDEMAND'); ?>>ONDEMAND</option>
                            <option value='ALLCALLS' <?php echo optionSetValue($campaign->campaign_recording,'ALLCALLS'); ?>>ALLCALLS</option>
                            <option value='ALLFORCE' <?php echo optionSetValue($campaign->campaign_recording,'ALLFORCE'); ?>>ALLFORCE</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign Rec Filename"; ?></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="campaign_rec_filename" value="<?php echo $campaign->campaign_rec_filename; ?>" maxlenght="50" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Recording Delay"; ?></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="allcalls_delay" value="<?php echo $campaign->allcalls_delay; ?>" maxlenght="3" />
                        <span class="help-content"><?php echo "in seconds"; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Call Notes Per Call"; ?></label>
                    <div class="col-md-4">
                        <select name="per_call_notes" class="form-control">
                            <option value="ENABLED" <?php echo optionSetValue($campaign->per_call_notes,'ENABLED'); ?>><?php echo "ENABLED"; ?></option>
                            <option value="DISABLED" <?php echo optionSetValue($campaign->per_call_notes,'DISABLED'); ?>><?php echo "DISABLED";  ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Comments All Tabs"; ?></label>
                    <div class="col-md-4">
                        <select name="comments_all_tabs" class="form-control">
                            <option value="ENABLED" <?php echo optionSetValue($campaign->comments_all_tabs,'ENABLED'); ?>><?php echo "ENABLED"; ?></option>
                            <option value="DISABLED" <?php echo optionSetValue($campaign->comments_all_tabs,'DISABLED'); ?>><?php echo "DISABLED";  ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Comments Dispo Screen"; ?></label>
                    <div class="col-md-4">
                        <select name="comments_dispo_screen" class="form-control">
                            <option value="ENABLED" <?php echo optionSetValue($campaign->comments_dispo_screen,'ENABLED'); ?>><?php echo "ENABLED"; ?></option>
                            <option value="DISABLED" <?php echo optionSetValue($campaign->comments_dispo_screen,'DISABLED'); ?>><?php echo "DISABLED";  ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Comments Callback Screen"; ?></label>
                    <div class="col-md-4">
                        <select name="comments_callback_screen" class="form-control">
                            <option value="ENABLED" <?php echo optionSetValue($campaign->comments_callback_screen,'ENABLED'); ?>><?php echo "ENABLED"; ?></option>
                            <option value="DISABLED" <?php echo optionSetValue($campaign->comments_callback_screen,'DISABLED'); ?>><?php echo "DISABLED";  ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "QC Comments History"; ?></label>
                    <div class="col-md-4">
                        <select name="qc_comment_history" class="form-control">
                            <option value="CLICK" <?php echo optionSetValue($campaign->qc_comment_history,'CLICK'); ?>><?php echo "CLICK"; ?></option>
                            <option value="AUTO_OPEN" <?php echo optionSetValue($campaign->qc_comment_history,'AUTO_OPEN'); ?>><?php echo "AUTO_OPEN";  ?></option>
                            <option value="AUTO_OPEN_ALLOW_MINIMIZE" <?php echo optionSetValue($campaign->qc_comment_history,'AUTO_OPEN_ALLOW_MINIMIZE'); ?>><?php echo "AUTO_OPEN_ALLOW_MINIMIZE";  ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Hide Call Log Info"; ?></label>
                    <div class="col-md-4">
                        <select name="hide_call_log_info" class="form-control">
                            <option value="Y" <?php echo optionSetValue($campaign->hide_call_log_info,'Y'); ?>><?php echo "YES"; ?></option>
                            <option value="N" <?php echo optionSetValue($campaign->hide_call_log_info,'N'); ?>><?php echo "NO";  ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Agent Lead Search"; ?></label>
                    <div class="col-md-4">
                        <select name="agent_lead_search" class="form-control">
                            <option value="ENABLED" <?php echo optionSetValue($campaign->agent_lead_search,'ENABLED'); ?>><?php echo "ENABLED"; ?></option>
                            <option value="DISABLED" <?php echo optionSetValue($campaign->agent_lead_search,'DISABLED'); ?>><?php echo "DISABLED";  ?></option>
                            <option value="LIVE_CALL_INBOUND" <?php echo optionSetValue($campaign->agent_lead_search,'LIVE_CALL_INBOUND'); ?>><?php echo "LIVE_CALL_INBOUND";  ?></option>
                            <option value="LIVE_CALL_INBOUND_AND_MANUAL" <?php echo optionSetValue($campaign->agent_lead_search,'LIVE_CALL_INBOUND_AND_MANUAL'); ?>><?php echo "LIVE_CALL_INBOUND_AND_MANUAL";  ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Agent Lead Search Method"; ?></label>
                    <div class="col-md-4">
                        <select name="agent_lead_search_method" class="form-control">
                            <option value="SYSTEM" <?php echo optionSetValue($campaign->agent_lead_search_method,'SYSTEM'); ?>><?php echo "SYSTEM"; ?></option>
                            <option value="CAMPAIGNLISTS" <?php echo optionSetValue($campaign->agent_lead_search_method,'CAMPAIGNLISTS'); ?>><?php echo "CAMPAIGNLISTS";  ?></option>
                            <option value="CAMPLISTS_ALL" <?php echo optionSetValue($campaign->agent_lead_search_method,'CAMPLISTS_ALL'); ?>><?php echo "CAMPLISTS_ALL";  ?></option>
                            <option value="LIST" <?php echo optionSetValue($campaign->agent_lead_search_method,'LIST'); ?>><?php echo "LIST";  ?></option>
                           <option value="USER_CAMPAIGNLISTS" <?php echo optionSetValue($campaign->agent_lead_search_method,'USER_CAMPAIGNLISTS'); ?>><?php echo "USER_CAMPAIGNLISTS";  ?></option>
                           <option value="USER_CAMPLISTS_ALL" <?php echo optionSetValue($campaign->agent_lead_search_method,'USER_CAMPLISTS_ALL'); ?>><?php echo "USER_CAMPLISTS_ALL";  ?></option>
                           <option value="USER_LIST" <?php echo optionSetValue($campaign->agent_lead_search_method,'USER_LIST'); ?>><?php echo "USER_LIST";  ?></option>
                           <option value="GROUP_SYSTEM" <?php echo optionSetValue($campaign->agent_lead_search_method,'GROUP_SYSTEM'); ?>><?php echo "GROUP_SYSTEM";  ?></option>
                           <option value="GROUP_CAMPAIGNLISTS" <?php echo optionSetValue($campaign->agent_lead_search_method,'GROUP_CAMPAIGNLISTS'); ?>><?php echo "GROUP_CAMPAIGNLISTS";  ?></option>
                           <option value="GROUP_CAMPLISTS_ALL" <?php echo optionSetValue($campaign->agent_lead_search_method,'GROUP_CAMPLISTS_ALL'); ?>><?php echo "GROUP_CAMPLISTS_ALL";  ?></option>
                           <option value="GROUP_LIST" <?php echo optionSetValue($campaign->agent_lead_search_method,'GROUP_LIST'); ?>><?php echo "GROUP_LIST";  ?></option>
                           <option value="TERRITORY_SYSTEM" <?php echo optionSetValue($campaign->agent_lead_search_method,'TERRITORY_SYSTEM'); ?>><?php echo "TERRITORY_SYSTEM";  ?></option>
                           <option value="TERRITORY_CAMPAIGNLISTS" <?php echo optionSetValue($campaign->agent_lead_search_method,'TERRITORY_CAMPAIGNLISTS'); ?>><?php echo "TERRITORY_CAMPAIGNLISTS";  ?></option>
                           <option value="TERRITORY_CAMPLISTS_ALL" <?php echo optionSetValue($campaign->agent_lead_search_method,'TERRITORY_CAMPLISTS_ALL'); ?>><?php echo "TERRITORY_CAMPLISTS_ALL";  ?></option>
                           <option value="TERRITORY_LIST" <?php echo optionSetValue($campaign->agent_lead_search_method,'TERRITORY_LIST'); ?>><?php echo "TERRITORY_LIST";  ?></option>
                        </select>
                    </div>
                </div>
               <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Script"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="campaign_script">
                            <?php echo get_scripts_options($campaign->campaign_script); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Clear Script"; ?></label>
                    <div class="col-md-4">
                        <select name="clear_script" class="form-control">
                            <option value="ENABLED" <?php echo optionSetValue($campaign->clear_script,'ENABLED'); ?>><?php echo "ENABLED"; ?></option>
                            <option value="DISABLED" <?php echo optionSetValue($campaign->clear_script,'DISABLED'); ?>><?php echo "DISABLED";  ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Get Call Launch"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="get_call_launch">
                            <option value="None" <?php echo optionSetValue($campaign->get_call_launch,'None') ?>><?php echo "None"; ?></option>
                            <option value="SCRIPT" <?php echo optionSetValue($campaign->get_call_launch,'SCRIPT') ?>><?php echo "SCRIPT"; ?></option>
                            <option value="WEBFORM" <?php echo optionSetValue($campaign->get_call_launch,'WEBFORM') ?>><?php echo "WEBFORM"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="disply:none;">
                    <label class="col-md-3 control-label"><?php echo "Answering Machine Message"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="am_message_exten" class="form-control" maxlength="10" value="<?php echo $campaign->am_message_exten; ?>" maxlength=100 />
                    </div>
                </div>
                <div class="form-group" style="disply:none;">
                    <label class="col-md-3 control-label"><?php echo "WaitForSilence Options"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="waitforsilence_options" class="form-control" maxlength="10" value="<?php echo $campaign->waitforsilence_options; ?>" maxlength=25 />
                    </div>
                </div>
            <?php if( (bool)get_dialer_option('outbound_autodial_active') == TRUE ) : ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo "AMD send to Action"; ?></label>
                        <div class="col-md-4">
                            <select name="amd_send_to_vmx" class="form-control">
                                <option value="Y" <?php echo optionSetValue($campaign->amd_send_to_vmx,'Y'); ?>><?php echo "YES"; ?></option>
                                <option value="N" <?php echo optionSetValue($campaign->amd_send_to_vmx,'N'); ?>><?php echo "NO";  ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo "CPD Unknown Action"; ?></label>
                        <div class="col-md-4">
                            <select name="cpd_unknown_action" class="form-control">
                                <option value="DISABLED" <?php echo optionSetValue($campaign->cpd_unknown_action,'DISABLED'); ?>><?php echo "DISABLED"; ?></option>
                                <option value="DISPO" <?php echo optionSetValue($campaign->cpd_unknown_action,'DISPO'); ?>><?php echo "DISPO";  ?></option>
                                <option value="MESSAGE" <?php echo optionSetValue($campaign->cpd_unknown_action,'MESSAGE'); ?>><?php echo "MESSAGE";  ?></option>
                                <option value="INGROUP" <?php echo optionSetValue($campaign->cpd_unknown_action,'INGROUP'); ?>><?php echo "INGROUP";  ?></option>
                                <option value="CALLMENU" <?php echo optionSetValue($campaign->cpd_unknown_action,'CALLMENU'); ?>><?php echo "CALLMENU";  ?></option>
                            </select>
                        </div>
                    </div>
                <div class="form-group" style="disply: none;">
                    <label class="col-md-3 control-label"><?php echo "AMD Inbound Group"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="amd_inbound_group">
                            <option value="">---NONE---</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="disply: none;">
                    <label class="col-md-3 control-label"><?php echo "AMD Call Menu"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="amd_callmenu">
                            <option value="">---NONE---</option>
                        </select>
                    </div>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf DTMF 1"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_a_dtmf" class="form-control" maxlength="50" value="<?php echo $campaign->xferconf_a_dtmf; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf Number 1"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_a_number" class="form-control" maxlength="50" value="<?php echo $campaign->xferconf_a_number; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf DTMF 2"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_b_dtmf" class="form-control" maxlength="50" value="<?php echo $campaign->xferconf_b_dtmf; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf Number 2"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_b_number" class="form-control" maxlength="50" value="<?php echo $campaign->xferconf_b_number; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf Number 3"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_c_number" class="form-control" maxlength="50" value="<?php echo $campaign->xferconf_c_number; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf Number 4"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_d_number" class="form-control" maxlength="50" value="<?php echo $campaign->xferconf_d_number; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf Number 5"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_e_number" class="form-control" maxlength="50" value="<?php echo $campaign->xferconf_e_number; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Enable Transfer Presets"; ?></label>
                    <div class="col-md-4">
                        <select name="enable_xfer_presets" class="form-control">
                            <option value="DISABLED" <?php echo optionSetValue($campaign->enable_xfer_presets,'DISABLED'); ?>><?php echo "DISABLED"; ?></option>
                            <option value="ENABLED" <?php echo optionSetValue($campaign->enable_xfer_presets,'ENABLED'); ?>><?php echo "ENABLED";  ?></option>
                            <option value="CONTACTS" <?php echo optionSetValue($campaign->enable_xfer_presets,'CONTACTS'); ?>><?php echo "CONTACTS";  ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo "Hide Transfer Number to Dial"; ?></label>
                    <div class="col-md-4">
                        <select name="hide_xfer_number_to_dial" class="form-control">
                            <option value="DISABLED" <?php echo optionSetValue($campaign->hide_xfer_number_to_dial,'DISABLED'); ?>><?php echo "DISABLED"; ?></option>
                            <option value="ENABLED" <?php echo optionSetValue($campaign->hide_xfer_number_to_dial,'ENABLED'); ?>><?php echo "ENABLED";  ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo "Quick Transfer Button"; ?></label>
                    <div class="col-md-4">
                        <select name="quick_transfer_button" class="form-control">
                            <option value="N" <?php echo optionSetValue($campaign->quick_transfer_button,'N'); ?>><?php echo "N"; ?></option>
                            <option value="IN_GROUP" <?php echo optionSetValue($campaign->quick_transfer_button,'IN_GROUP'); ?>><?php echo "IN_GROUP";  ?></option>
                            <option value="PRESET_1" <?php echo optionSetValue($campaign->quick_transfer_button,'PRESET_1'); ?>><?php echo "PRESET_1";  ?></option>
                            <option value="PRESET_2" <?php echo optionSetValue($campaign->quick_transfer_button,'PRESET_2'); ?>><?php echo "PRESET_2";  ?></option>
                            <option value="PRESET_3" <?php echo optionSetValue($campaign->quick_transfer_button,'PRESET_3'); ?>><?php echo "PRESET_3";  ?></option>
                            <option value="PRESET_4" <?php echo optionSetValue($campaign->quick_transfer_button,'PRESET_4'); ?>><?php echo "PRESET_4";  ?></option>
                            <option value="PRESET_4" <?php echo optionSetValue($campaign->quick_transfer_button,'PRESET_4'); ?>><?php echo "PRESET_4";  ?></option>
                            <option value="PRESET_5" <?php echo optionSetValue($campaign->quick_transfer_button,'PRESET_5'); ?>><?php echo "PRESET_5";  ?></option>
                            <option value="LOCKED_IN_GROUP" <?php echo optionSetValue($campaign->quick_transfer_button,'LOCKED_IN_GROUP'); ?>><?php echo "LOCKED_IN_GROUP";  ?></option>
                            <option value="LOCKED_PRESET_1" <?php echo optionSetValue($campaign->quick_transfer_button,'LOCKED_PRESET_1'); ?>><?php echo "LOCKED_PRESET_1";  ?></option>
                            <option value="LOCKED_PRESET_2" <?php echo optionSetValue($campaign->quick_transfer_button,'LOCKED_PRESET_2'); ?>><?php echo "LOCKED_PRESET_2";  ?></option>
                            <option value="LOCKED_PRESET_3" <?php echo optionSetValue($campaign->quick_transfer_button,'LOCKED_PRESET_3'); ?>><?php echo "LOCKED_PRESET_3";  ?></option>
                            <option value="LOCKED_PRESET_4" <?php echo optionSetValue($campaign->quick_transfer_button,'LOCKED_PRESET_4'); ?>><?php echo "LOCKED_PRESET_4";  ?></option>
                            <option value="LOCKED_PRESET_5" <?php echo optionSetValue($campaign->quick_transfer_button,'LOCKED_PRESET_5'); ?>><?php echo "LOCKED_PRESET_5";  ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo "Custom 3-Way Button Transfer"; ?></label>
                    <div class="col-md-4">
                    <select name="custom_3way_button_transfer" class="form-control">
                        <option value="DISABLED" <?php echo optionSetValue($campaign->custom_3way_button_transfer,'DISABLED'); ?>>DISABLED</option>
                    </select>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo "PrePopulate Transfer Preset"; ?></label>
                    <div class="col-md-4">
                    <select name="prepopulate_transfer_preset" class="form-control">
                        <option value="N" <?php echo optionSetValue($campaign->prepopulate_transfer_preset,'N'); ?>>N</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Park Call IVR"; ?></label>
                    <div class="col-md-4">
                    <select name="ivr_park_call" class="form-control">
                        <option value="DISABLED" <?php echo optionSetValue($campaign->ivr_park_call,'DISABLED'); ?>>DISABLED</option>
                        <option value="ENABLED" <?php echo optionSetValue($campaign->ivr_park_call,'ENABLED'); ?>>ENABLED</option>
                        <option value="ENABLED_PARK_ONLY" <?php echo optionSetValue($campaign->ivr_park_call,'ENABLED_PARK_ONLY'); ?>>ENABLED_PARK_ONLY</option>
                        <option value="ENABLED_BUTTON_HIDDEN" <?php echo optionSetValue($campaign->ivr_park_call,'ENABLED_BUTTON_HIDDEN'); ?>>ENABLED_BUTTON_HIDDEN</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Park Call IVR AGI"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="ivr_park_call_agi" class="form-control" maxlength="1000" value="<?php echo $campaign->ivr_park_call_agi; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Timer Action"; ?></label>
                    <div class="col-md-4">
                    <select name="timer_action" class="form-control">
                        <option value="NONE" selected="" <?php echo optionSetValue($campaign->timer_action,'NONE'); ?>>NONE</option>
                        <option value="D1_DIAL" <?php echo optionSetValue($campaign->timer_action,'D1_DIAL'); ?>>ENABLED</option>
                        <option value="D2_DIAL" <?php echo optionSetValue($campaign->timer_action,'D2_DIAL'); ?>>D2_DIAL</option>
                        <option value="D3_DIAL" <?php echo optionSetValue($campaign->timer_action,'D3_DIAL'); ?>>D3_DIAL</option>
                        <option value="D4_DIAL" <?php echo optionSetValue($campaign->timer_action,'D4_DIAL'); ?>>D4_DIAL</option>
                        <option value="D1_DIAL_QUIET" <?php echo optionSetValue($campaign->timer_action,'D1_DIAL_QUIET'); ?>>D1_DIAL_QUIET</option>
                        <option value="D2_DIAL_QUIET" <?php echo optionSetValue($campaign->timer_action,'D2_DIAL_QUIET'); ?>>D2_DIAL_QUIET</option>
                        <option value="D3_DIAL_QUIET" <?php echo optionSetValue($campaign->timer_action,'D3_DIAL_QUIET'); ?>>D3_DIAL_QUIET</option>
                        <option value="D4_DIAL_QUIET" <?php echo optionSetValue($campaign->timer_action,'D4_DIAL_QUIET'); ?>>D4_DIAL_QUIET</option>
                        <option value="D5_DIAL_QUIET" <?php echo optionSetValue($campaign->timer_action,'D5_DIAL_QUIET'); ?>>D5_DIAL_QUIET</option>
                        <option value="MESSAGE_ONLY" <?php echo optionSetValue($campaign->timer_action,'MESSAGE_ONLY'); ?>>MESSAGE_ONLY</option>
                        <option value="WEBFORM" <?php echo optionSetValue($campaign->timer_action,'WEBFORM'); ?>>WEBFORM</option>
                        <option value="HANGUP" <?php echo optionSetValue($campaign->timer_action,'HANGUP'); ?>>HANGUP</option>
                        <option value="CALLMENU" <?php echo optionSetValue($campaign->timer_action,'CALLMENU'); ?>>CALLMENU</option>
                        <option value="EXTENSION" <?php echo optionSetValue($campaign->timer_action,'EXTENSION'); ?>>EXTENSION</option>
                        <option value="IN_GROUP" <?php echo optionSetValue($campaign->timer_action,'IN_GROUP'); ?>>IN_GROUP</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Timer Action Message"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="timer_action_message" class="form-control" maxlength="255" value="<?php echo $campaign->timer_action_message; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Timer Action Seconds"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="timer_action_seconds" class="form-control" maxlength="10" value="<?php echo $campaign->timer_action_seconds; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Timer Action Destination"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="timer_action_destination" class="form-control" maxlength="30" value="<?php echo $campaign->timer_action_destination; ?>" />
                    </div>
                </div>
                <?php if( (bool)get_dialer_option('outbound_autodial_active') == TRUE ) : ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo "Manual Alt Num Dialing"; ?></label>
                        <div class="col-md-4">
                            <select class="form-control" name="alt_number_dialing">
                                <option value="Y" <?php echo optionSetValue($campaign->alt_number_dialing,'Y'); ?>>Y</option>
                                <option value="N" <?php echo optionSetValue($campaign->alt_number_dialing,'N'); ?>>N</option>
                                <option value="SELECTED" <?php echo optionSetValue($campaign->alt_number_dialing,'SELECTED'); ?>>SELECTED</option>
                                <option value="SELECTED_TIMER_ALT" <?php echo optionSetValue($campaign->alt_number_dialing,'SELECTED_TIMER_ALT'); ?>>SELECTED_TIMER_ALT</option>
                                <option value="SELECTED_TIMER_ADDR3" <?php echo optionSetValue($campaign->alt_number_dialing,'SELECTED_TIMER_ADDR3'); ?>>SELECTED_TIMER_ADDR3</option>
                            </select>
                        </div>
                    </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Timer Alt Seconds"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="timer_alt_seconds" class="form-control" maxlength="4" value="<?php echo $campaign->timer_alt_seconds; ?>" />
                    </div>
                </div>
                <?php endif ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Scheduled Callbacks"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="alt_number_dialing">
                            <option value="Y" <?php echo optionSetValue($campaign->scheduled_callbacks,'Y'); ?>>Y</option>
                            <option value="N" <?php echo optionSetValue($campaign->scheduled_callbacks,'N'); ?>>N</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Scheduled Callbacks Alert"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="scheduled_callbacks_alert">
                            <option value="NONE" <?php echo optionSetValue($campaign->scheduled_callbacks_alert,'NONE'); ?>>NONE</option>
                            <option value="BLINK" <?php echo optionSetValue($campaign->scheduled_callbacks_alert,'BLINK'); ?>>BLINK</option>
                            <option value="RED" <?php echo optionSetValue($campaign->scheduled_callbacks_alert,'RED'); ?>>RED</option>
                            <option value="BLINK_RED" <?php echo optionSetValue($campaign->scheduled_callbacks_alert,'BLINK_RED'); ?>>BLINK_RED</option>
                            <option value="BLINK_RED" <?php echo optionSetValue($campaign->scheduled_callbacks_alert,'BLINK_RED'); ?>>BLINK_RED</option>
                            <option value="BLINK_DEFER" <?php echo optionSetValue($campaign->scheduled_callbacks_alert,'BLINK_DEFER'); ?>>BLINK_DEFER</option>
                            <option value="RED_DEFER" <?php echo optionSetValue($campaign->scheduled_callbacks_alert,'RED_DEFER'); ?>>RED_DEFER</option>
                            <option value="BLINK_RED_DEFER" <?php echo optionSetValue($campaign->scheduled_callbacks_alert,'BLINK_RED_DEFER'); ?>>BLINK_RED_DEFER</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Scheduled Callbacks Count"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="scheduled_callbacks_count">
                            <option value="LIVE" <?php echo optionSetValue($campaign->scheduled_callbacks_alert,'LIVE'); ?>>LIVE</option>
                            <option value="ALL_ACTIVE" <?php echo optionSetValue($campaign->scheduled_callbacks_alert,'ALL_ACTIVE'); ?>>ALL_ACTIVE</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Scheduled Callbacks Days Limit"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="callback_days_limit" class="form-control" maxlength="3" value="<?php echo $campaign->callback_days_limit; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Scheduled Callbacks Hours Block"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="callback_hours_block" class="form-control" maxlength="2" value="<?php echo $campaign->callback_hours_block; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Scheduled Callbacks Calltime Block"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="callback_list_calltime">
                            <option value="ENABLED" <?php echo optionSetValue($campaign->callback_list_calltime,'ENABLED'); ?>>ENABLED</option>
                            <option value="DISABLED" <?php echo optionSetValue($campaign->callback_list_calltime,'DISABLED'); ?>>DISABLED</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Scheduled Callbacks Active Limit Override"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="callback_active_limit_override">
                            <option value="Y" <?php echo optionSetValue($campaign->callback_active_limit_override,'Y'); ?>>Y</option>
                            <option value="N" <?php echo optionSetValue($campaign->callback_active_limit_override,'N'); ?>>N</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Scheduled Callbacks Active Limit"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="callback_active_limit" class="form-control" maxlength="5" value="<?php echo $campaign->callback_active_limit; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "My Callbacks Checkbox Default"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="my_callback_option">
                            <option value="CHECKED" <?php echo optionSetValue($campaign->my_callback_option,'CHECKED'); ?>>CHECKED</option>
                            <option value="UNCHECKED" <?php echo optionSetValue($campaign->my_callback_option,'UNCHECKED'); ?>>UNCHECKED</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Show Previous Callback"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="show_previous_callback">
                            <option value="DISABLED" <?php echo optionSetValue($campaign->my_callback_option,'DISABLED'); ?>>DISABLED</option>
                            <option value="ENABLED" <?php echo optionSetValue($campaign->my_callback_option,'ENABLED'); ?>>ENABLED</option>
                        </select>
                    </div>
                </div>
                <?php if( (bool)get_dialer_option('outbound_autodial_active') == TRUE ) : ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo "Drop Call Seconds"; ?></label>
                        <div class="col-md-4">
                            <input type="text" name="drop_call_seconds" class="form-control" maxlength="2" value="<?php echo $campaign->drop_call_seconds; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo "Drop Action"; ?></label>
                        <div class="col-md-4">
                            <select class="form-control" name="drop_action">
                                <option value="AUDIO" <?php echo optionSetValue($campaign->drop_action,'AUDIO'); ?>>AUDIO</option>
                                <option value="HANGUP" <?php echo optionSetValue($campaign->drop_action,'HANGUP'); ?>>HANGUP</option>
                                <option value="MESSAGE" <?php echo optionSetValue($campaign->drop_action,'MESSAGE'); ?>>MESSAGE</option>
                                <option value="VOICEMAIL" <?php echo optionSetValue($campaign->drop_action,'VOICEMAIL'); ?>>VOICEMAIL</option>
                                <option value="IN_GROUP" <?php echo optionSetValue($campaign->drop_action,'IN_GROUP'); ?>>IN_GROUP</option>
                                <option value="CALLMENU" <?php echo optionSetValue($campaign->drop_action,'CALLMENU'); ?>>CALLMENU</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="col-md-3 control-label"><?php echo "Safe Harbor Exten"; ?></label>
                        <div class="col-md-4">
                            <input type="text" name="safe_harbor_exten" class="form-control" maxlength="20" value="<?php echo $campaign->safe_harbor_exten; ?>" />
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="col-md-3 control-label"><?php echo "Safe Harbor Audio"; ?></label>
                        <div class="col-md-4">
                            <input type="text" name="safe_harbor_audio" class="form-control" maxlength="100" value="<?php echo $campaign->safe_harbor_audio; ?>" />
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="col-md-3 control-label"><?php echo "Safe Harbor Audio Field"; ?></label>
                        <div class="col-md-4">
                            <select class="form-control" name="safe_harbor_audio_field">
                                <option value="DISABLED" <?php echo optionSetValue($campaign->safe_harbor_audio_field,'DISABLED'); ?>>DISABLED</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="col-md-3 control-label"><?php echo "Safe Harbor Call Menu"; ?></label>
                        <div class="col-md-4">
                            <select class="form-control" name="safe_harbor_menu_id">    
                                <option value="" selected=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo "Voicemail"; ?></label>
                        <div class="col-md-4">
                            <input type="text" name="voicemail_ext" class="form-control" maxlength="10" value="<?php echo $campaign->voicemail_ext; ?>" />
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="col-md-3 control-label"><?php echo "Drop Transfer Group"; ?></label>
                        <div class="col-md-4">
                            <select class="form-control" name="drop_inbound_group">    
                                <option value="" selected=""></option>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-group" style="display:none;">
                    <label class="col-md-3 control-label"><?php echo "Disable Dispo Screen"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="disable_dispo_screen">
                          <option value="DISPO_ENABLED" <?php echo optionSetValue($campaign->disable_dispo_screen,'DISPO_ENABLED'); ?>>DISPO_ENABLED</option>
                          <option value="DISPO_DISABLED" <?php echo optionSetValue($campaign->disable_dispo_screen,'DISPO_DISABLED'); ?>>DISPO_DISABLED</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display:none;">
                    <label class="col-md-3 control-label"><?php echo "Disable Dispo Status"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="disable_dispo_status" class="form-control" maxlength="6" value="<?php echo $campaign->disable_dispo_status; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Wrap Up Seconds"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="wrapup_seconds" class="form-control" maxlength="3" value="<?php echo $campaign->wrapup_seconds; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Wrap Up Message"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="wrapup_message" class="form-control" maxlength="255" value="<?php echo $campaign->wrapup_message; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Wrap Up Bypass"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="wrapup_bypass">
                            <option value="ENABLED" <?php echo optionSetValue($campaign->wrapup_bypass,'ENABLED'); ?>>ENABLED</option>
                            <option value="DISABLED" <?php echo optionSetValue($campaign->wrapup_bypass,'DISABLED'); ?>>DISABLED</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Wrap Up After Hotkey"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="wrapup_after_hotkey">
                            <option value="ENABLED" <?php echo optionSetValue($campaign->wrapup_after_hotkey,'ENABLED'); ?>>ENABLED</option>
                            <option value="DISABLED" <?php echo optionSetValue($campaign->wrapup_after_hotkey,'DISABLED'); ?>>DISABLED</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Dead Call Max Seconds"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="dead_max" class="form-control" maxlength="4" value="<?php echo $campaign->dead_max; ?>" />
                    </div>
                </div>
                <div class="form-group" style="display:none;">
                    <label class="col-md-3 control-label"><?php echo "Dispo Call Max Seconds"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="dispo_max" class="form-control" maxlength="4" value="<?php echo $campaign->dispo_max; ?>" />
                    </div>
                </div>
                <div class="form-group" style="display:none;">
                    <label class="col-md-3 control-label"><?php echo "Dispo Call Max Status"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="dispo_max_dispo" class="form-control" maxlength="6" value="<?php echo $campaign->dispo_max_dispo; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Agent Pause Max Seconds"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="pause_max" class="form-control" maxlength="4" value="<?php echo $campaign->pause_max; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Use Internal DNC List"; ?></label>
                    <div class="col-md-4">
                        <select name="use_internal_dnc" class="form-control">
                            <option value="Y" <?php echo optionSetValue($campaign->use_internal_dnc,'Y'); ?>>Y</option>
                            <option value="N" <?php echo optionSetValue($campaign->use_internal_dnc,'N'); ?>>N</option>
                            <option value="AREACODE" <?php echo optionSetValue($campaign->use_internal_dnc,'AREACODE'); ?>>AREACODE</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Use Campaign DNC List"; ?></label>
                    <div class="col-md-4">
                        <select name="use_campaign_dnc" class="form-control">
                            <option value="Y" <?php echo optionSetValue($campaign->use_campaign_dnc,'Y'); ?>>Y</option>
                            <option value="N" <?php echo optionSetValue($campaign->use_campaign_dnc,'N'); ?>>N</option>
                            <option value="AREACODE" <?php echo optionSetValue($campaign->use_campaign_dnc,'AREACODE'); ?>>AREACODE</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Agent Pause Codes Active"; ?></label>
                    <div class="col-md-4">
                        <select name="agent_pause_codes_active" class="form-control">
                            <option value="FORCE" <?php echo optionSetValue($campaign->agent_pause_codes_active,'FORCE'); ?>>FORCE</option>
                            <option value="N" <?php echo optionSetValue($campaign->agent_pause_codes_active,'N'); ?>>No</option>
                            <option value="Y" <?php echo optionSetValue($campaign->use_internal_dnc,'Y'); ?>>Yes</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn blue" type="submit"><?php echo 'Submit' ?></button>
                        <button class="btn btn-circle grey-salsa btn-outline" type="button" onclick="location.href='<?php site_url('dialer/campaign/index') ?>'">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
              </div>
          </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function(){
     jQuery('.campaign').addClass('active');
     jQuery("#form").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                agency_id: "required",
                campaign_name: "required",
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });
    });
</script>
