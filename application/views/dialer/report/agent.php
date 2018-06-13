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
        <form id="groupForm" name="groupForm" id="groupForm" action="" method="post">
            <input type="hidden" name="file_download" value="0" id="file_download"/>
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?php echo 'Dates' ?>: </label>
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control" name="query_date" value="<?php echo isset($postData['query_date']) ? $postData['query_date'] :  date('m/d/Y') ?>">
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" name="end_date" value="<?php echo isset($postData['end_date']) ? $postData['end_date'] : date('m/d/Y') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo 'Agency' ?>:</label>
                            <?php if ($this->session->userdata ( 'user' )->group_name == 'Agency'): ?>
                                <?php $tree = buildTree($agencies,0); ?>
                                <select name="agency_id" class="form-control" id="agency_id" onchange="javascript:selectOther(this.value)">
                                    <option value=""><?php echo "Please Select Agency"; ?></option>
                                <?php echo printTreeWithEncrypt($tree,0, null, isset($postData['agency_id']) ? decode_url($postData['agency_id']) : ''  ); ?>
                            </select>
                            <?php else: ?>
                                <?php $tree = buildTree($agencies,0); ?>
                                <select name="agency_id" class="form-control" id="agency_id" onchange="javascript:selectOther(this.value)">
                                    <option value=""><?php echo "Please Select Agency"; ?></option>
                                <?php echo printTreeWithEncrypt($tree,0, null, isset($postData['agency_id']) ? decode_url($postData['agency_id']) : ''  ); ?>
                            </select>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?php echo "Campaigns" ?>: </label>
                            <?php
                                $groups = isset($postData['group']) && count($postData['group']) > 0 ? $postData['group'] : array();
                                $selected = '';
                                if(in_array('--ALL--', $groups)){
                                    $selected = 'selected = "selected"';
                                }
                            ?>
                            <?php if ($this->session->userdata ( 'user' )->group_name == 'Agency'): ?>
                            <select multiple="" name="group[]" class="form-control" id="groupcam">
                                <?php foreach($campaigns as $campaign): ?>
                                    <?php
                                        $selected = '';
                                        if(in_array($campaign->campaign_id, $groups)){
                                            $selected = 'selected="selected"';
                                        }
                                    ?>
                                    <option value="<?php echo $campaign->campaign_id ?>" <?php echo $selected; ?> <?php if(!isset($postData['group'])) { echo 'selected="selected"'; } ?>><?php echo $campaign->campaign_id.' - '.$campaign->campaign_name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php else: ?>
                            <select multiple="" name="group[]" class="form-control" id="groupcam">
                                <option value="--ALL--" <?php echo $selected ?>><?php echo '-- ALL CAMPAIGNS --' ?></option>
                                <?php foreach($campaigns as $campaign): ?>
                                    <?php
                                        $selected = '';
                                        if(in_array($campaign->campaign_id, $groups)){
                                            $selected = 'selected="selected"';
                                        }
                                    ?>
                                    <option value="<?php echo $campaign->campaign_id ?>" <?php echo $selected; ?>><?php echo $campaign->campaign_id.' - '.$campaign->campaign_name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                             <label><?php echo "Users Group" ?>: </label>
                             <?php $postuGroups = isset($postData['user_group']) ? $postData['user_group'] : array() ?>
                             <?php if ($this->session->userdata ( 'user' )->group_name == 'Agency'): ?>
                             <select multiple="" name="user_group[]" id="user_group" class="form-control">
                                 <?php foreach($user_groups as $usergroup): ?>
                                    <?php $selected = '' ?>
                                    <?php if(in_array($usergroup['user_group'], $postuGroups)): ?>
                                        <?php $selected = 'selected="selected"'; ?>
                                    <?php endif; ?>
                                    <option <?php echo (count($postuGroups)) == 0 ? 'selected="selected"' : ''; ?> value="<?php echo $usergroup['user_group'] ?>" <?php echo $selected; ?>><?php echo $usergroup['user_group'] ?></option>
                                 <?php endforeach; ?>
                             </select>
                             <?php else: ?>
                             <select multiple="" name="user_group[]" id="user_group" class="form-control">
                                 <option value="<?php echo "--ALL--" ?>"><?php echo "-- ALL USER GROUPS --" ?></option>
                                 <?php foreach($user_groups as $usergroup): ?>
                                    <?php $selected = '' ?>
                                    <?php if(in_array($usergroup->user_group, $postuGroups)): ?>
                                        <?php $selected = 'selected="selected"'; ?>
                                    <?php endif; ?>
                                    <option value="<?php echo $usergroup->user_group ?>" <?php echo $selected; ?>><?php echo $usergroup->user_group ?></option>
                                 <?php endforeach; ?>
                             </select>
                             <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><?php echo 'Users' ?>:</label>
                            <?php $postUsers = isset($postData['users']) ? $postData['users'] : array() ?>
                            <?php if ($this->session->userdata ( 'user' )->group_name == 'Agency'): ?>
                                <select multiple="" name="users[]" id="usersc" class="form-control">
                                 <optgroup label="Agency">
                                <?php foreach($agencyUsers as $agency) :?>
                                    <?php $selected = '' ?>
                                    <?php if(in_array($agency->user, $postUsers)): ?>
                                        <?php $selected = 'selected="selected"'; ?>
                                    <?php endif; ?>
                                    <option <?php echo (count($postUsers) == 0) ? 'selected="selected"':''; ?> value="<?php echo $agency->user ?>" <?php echo $selected ?>><?php echo $agency->user.'-'.$agency->full_name ?></option>
                                </optgroup>
                                <?php endforeach; ?>
                                 <optgroup label="Agents">
                                <?php foreach($agentUsers as $agent) :?>
                                    <?php $selected = '' ?>
                                    <?php if(in_array($agent->user, $postUsers)): ?>
                                        <?php $selected = 'selected="selected"'; ?>
                                    <?php endif; ?>
                                    <option <?php echo (count($postUsers) == 0) ? 'selected="selected"':''; ?> value="<?php echo $agent->user ?>" <?php echo $selected; ?>><?php echo $agent->user.'-'.$agent->full_name ?></option>
                                <?php endforeach; ?>
                                </optgroup>
                                </select>
                            <?php else: ?>
                            <select multiple="" name="users[]" id="usersc" class="form-control">
                                <option value="<?php echo "--ALL--" ?>"><?php echo "-- ALL USERS --" ?></option>
                                <?php foreach($users as $user): ?>
                                    <?php $selected = '' ?>
                                    <?php if(in_array($user->user, $postUsers)): ?>
                                        <?php $selected = 'selected="selected"'; ?>
                                    <?php endif; ?>
                                <option value="<?php echo $user->user ?>"><?php echo $user->user.' - '.$user->full_name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="checkbox-list">
                            <label>
                                <input type="checkbox" name="show_percentages" value="checked" <?php if(isset($postData['show_percentages']) && $postData['show_percentages'] == 'checked'){ echo 'checked="checked"'; } ?> /><?php echo "Show %s" ?>
                            </label>
                            <label>
                                <input type="checkbox" name="time_in_sec" value="checked" <?php if(isset($postData['time_in_sec']) && $postData['time_in_sec'] == 'checked'){ echo 'checked="checked"'; } ?> /><?php echo 'Time in seconds' ?>
                            </label>
                            <label>
                                <input type="checkbox" name="breakdown_by_date" value="checked" <?php if(isset($postData['breakdown_by_date']) && $postData['breakdown_by_date'] == 'checked'){ echo 'checked="checked"'; } ?> /><?php echo 'Show date breakdown' ?>
                            </label>
                            <label>
                                <input type="checkbox" name="search_archived_data" value="checked" <?php if(isset($postData['search_archived_data']) && $postData['search_archived_data'] == 'checked'){ echo 'checked="checked"'; } ?> /><?php echo 'Search archived data' ?>
                            </label>
                            <label>
                                <input type="checkbox" name="show_defunct_users" value="checked" <?php if(isset($postData['show_defunct_users']) && $postData['show_defunct_users'] == 'checked'){ echo 'checked="checked"'; } ?> /><?php echo 'Show defunct users' ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label><?php echo 'Shift' ?>:</label>
                        <select name="shift" class="form-control">
                            <option value="<?php echo 'AM' ?>" <?php echo optionSetValue('AM', isset($postData['shift']) ? $postData['shift'] : '' ) ?>><?php echo 'AM' ?></option>
                            <option value="<?php echo 'PM' ?>" <?php echo optionSetValue('PM', isset($postData['shift']) ? $postData['shift'] : '' ) ?>><?php echo 'PM' ?></option>
                            <option selected="" value="<?php echo 'ALL' ?>" <?php echo optionSetValue('ALL', isset($postData['shift']) ? $postData['shift'] : '' ) ?>><?php echo 'ALL' ?></option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><?php echo 'Display as' ?>:</label>
                            <select name="report_display_type" id="report_display_type" class="form-control">
                                <option value="<?php echo 'TEXT' ?>" <?php echo optionSetValue('TEXT', isset($postData['report_display_type']) ? $postData['report_display_type'] : '' ) ?>><?php echo 'TEXT' ?></option>
                                <option value="<?php echo 'HTML' ?>" <?php echo optionSetValue('HTML', isset($postData['report_display_type']) ? $postData['report_display_type'] : '' ) ?>><?php echo 'HTML' ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-9">
                        <button class="btn blue" type="button" onClick="checkDownload(0)">Submit</button>
                        <!--button type="button" class="btn btn-circle grey-salsa btn-outline">Cancel</button-->
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function checkDownload(value){
    jQuery("#file_download").val(value);
    jQuery("#groupForm").submit();
}
jQuery(function(){
    jQuery('.input-daterange').datepicker({
        orientation: "bottom",
    });
});
function selectOther(agency){
    jQuery('#loading').modal("show");
    var uGroups =  '<?php echo isset($postData['user_group']) ? json_encode($postData['user_group']) : ''; ?>';
    var uUsers = '<?php echo isset($postData['users']) ? json_encode($postData['users']) : ''; ?>';
    jQuery.ajax({
        url: '<?php echo site_url('dialer/report/getother') ?>',
        method: 'POST',
        data: { id : agency, usergroup: uGroups, users: uUsers},
        dataType:'JSON',
        success: function(result){
             var flag = Boolean(result.success);
             if(flag == true){
                jQuery('#groupcam').replaceWith(result.campaign);
                jQuery('#user_group').replaceWith(result.groups);
                jQuery('#usersc').replaceWith(result.users);
            }
            jQuery('#loading').modal("hide");
        }
    });
}
</script>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"><?php echo "Result"; ?> </span>
        </div>
    </div>
	<div class="portlet-body">
		<?php if(isset($result)) : ?>
			<?php echo $result; ?>
            <script type="text/javascript">
                jQuery(function(){
                    <?php if(isset($postData['agency_id'])): ?>
                        selectOther('<?php echo $postData['agency_id'] ?>');
                    <?php endif; ?>
                });
            </script>
		<?php endif; ?>
	</div>
</div>