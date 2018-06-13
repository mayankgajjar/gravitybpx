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
    <div class="portlet-body">
        <div class="tabbable-line">
            <?php $this->load->view('dialer/admin/campaign/tabs') ?>
            <div class="tab-content">
                 <div class="tab-pane active" id="tab_15_1">
                    <form name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-body">
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
                    <label class="col-md-3 control-label"><?php echo "Campaign ID"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="campaign_id" class="form-control" maxlength="8" size="10" value="<?php echo $campaign->campaign_id ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign Name"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="campaign_name" class="form-control" maxlength="30" size="30" value="<?php echo $campaign->campaign_name ?>"/>
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
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'List Orders' ?></label>
                    <div class="col-md-4">
                        <select name="lead_order" class="form-control">
            				<option value='DOWN' selected="" <?php echo optionSetValue($campaign->lead_order,'DOWN') ?>><?php echo "DOWN" ?></option>
            				<option value='UP'  <?php echo optionSetValue($campaign->lead_order,'up') ?>><?php echo "UP" ?></option>
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
                    <label class="col-md-3 control-label"><?php echo 'Lead Filter' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="lead_filter_id">
                            <?php echo getFilterList($campaign->lead_filter_id)?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Dial Method' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="dial_method">
                            <option value="MANUAL" <?php echo optionSetValue($campaign->dial_method,'MANUAL') ?>><?php echo 'MANUAL'; ?></option>
                            <option value="RATIO" <?php echo optionSetValue($campaign->dial_method,'RATIO') ?> ><?php echo 'RATIO'; ?></option>
                            <option value="ADAPT_HARD_LIMIT" <?php echo optionSetValue($campaign->dial_method,'ADAPT_HARD_LIMIT') ?> ><?php echo 'ADAPT_HARD_LIMIT'; ?></option>
                            <option value="ADAPT_TAPERED" <?php echo optionSetValue($campaign->dial_method,'ADAPT_TAPERED') ?>><?php echo 'ADAPT_TAPERED'; ?></option>
                            <option value="ADAPT_AVERAGE" <?php echo optionSetValue($campaign->dial_method,'ADAPT_AVERAGE') ?> ><?php echo 'ADAPT_AVERAGE'; ?></option>
                            <option value="INBOUND_MAN" <?php echo optionSetValue($campaign->dial_method,'INBOUND_MAN') ?>><?php echo 'INBOUND_MAN'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Auto Dial Level"; ?></label>
                    <div class="col-md-4">
                        <?php $limit = 20 ?>
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
                    <label class="col-md-3 control-label"><?php echo 'Answer Mchine Detection' ?></label>
                    <div class="col-md-4">
                        <div class="radio-list">
                            <label class="radio-inline">
                                <input type="radio" name="campaign_vdad_exten" value="8369" <?php echo $campaign->campaign_vdad_exten == '8369' ? 'checked="checked"':''; ?> />
                                On
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="campaign_vdad_exten" value="8368" <?php echo $campaign->campaign_vdad_exten == '8368' ? 'checked="checked"':''; ?> />
                                Off
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Campaign CallerID' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="campaign_cid" class="form-control" value="<?php echo $campaign->campaign_cid ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Use Internal DNC List' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="use_internal_dnc">
                            <option value="Y" <?php echo optionSetValue($campaign->use_internal_dnc,'Y') ?>><?php echo 'Yes' ?></option>
                            <option value="N" <?php echo optionSetValue($campaign->use_internal_dnc,'N') ?>><?php echo 'No' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Allow Closers" ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="allow_closers" onchange="javascript:selectCloser(this.value)">
                            <option value="Y" <?php echo optionSetValue($campaign->allow_closers,'Y') ?>><?php echo 'Yes' ?></option>
                            <option value="N" <?php echo optionSetValue($campaign->allow_closers,'N') ?>><?php echo 'No' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Allow Inbound and Blended" ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="campaign_allow_inbound">
                            <option value="Y" <?php echo optionSetValue($campaign->campaign_allow_inbound,'Y') ?>><?php echo 'Yes' ?></option>
                            <option value="N" <?php echo optionSetValue($campaign->campaign_allow_inbound,'N') ?>><?php echo 'No' ?></option>
                        </select>
                    </div>
                </div>
                <?php 
                    if($campaign->allow_closers == 'Y'){
                        $style = 'style="display:block"';
                    }else{
                        $style = 'style="display:none"';
                    }
                ?>
                <div class="form-group" id="groups-div" <?php echo $style; ?>>
                    <label class="col-md-3 control-label"><?php echo "Allowed Inbound Groups" ?></label>
                    <div class="col-md-4">
                        <?php $Mcloser_campaigns = preg_replace("/ -$/","",$campaign->closer_campaigns);?>
                        <?php $iGroups = array(); ?>
                        <?php if(strlen($Mcloser_campaigns) > 0): ?>
                            <?php $iGroups = explode(' ', $Mcloser_campaigns); ?>
                        <?php endif; ?>
                        <select name="groups[]" class="form-control" id="groups" multiple="">
                            <?php foreach($ingroups as $ingroup): ?>
                                <?php $selected = '' ?>
                                <?php if(in_array($ingroup->group_id, $iGroups)): ?>
                                    <?php $selected = 'selected="selected"'; ?>
                                <?php endif; ?>
                                <option value="<?php echo $ingroup->group_id ?>" <?php echo $selected; ?>><?php echo $ingroup->group_id.' - '.$ingroup->group_name ?></option>
                            <?php endforeach; ?>
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
    function selectCloser(option){
        if(option == 'Y'){
            jQuery('#groups-div').show();
        }else{
            jQuery('#groups-div').hide();
        }
    }
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
                campaign_id: {
                    required: true,
                    maxlength: 6
                },

            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });
    });
</script>
