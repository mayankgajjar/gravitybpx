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
<?php if(isset($result) && strlen($result) > 0): ?>
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo $result; ?>
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
            <div class="form-body">
                <div class="row">
                    <div class="col-md-3">
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
                        <div class="form-group">
                            <label><?php echo 'Dates' ?>: </label>
                            <div class="input-group date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control" name="query_date" value="<?php echo isset($postData['query_date']) ? $postData['query_date'] :  date('m/d/Y') ?>">
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" name="end_date" value="<?php echo isset($postData['end_date']) ? $postData['end_date'] : date('m/d/Y') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo 'Header Row' ?>: </label>
                            <select name="header_row" id="header_row" class="form-control">
                                <option value="<?php echo 'YES' ?>"><?php echo 'YES' ?></option>
                                <option value="<?php echo 'NO' ?>"><?php echo 'NO' ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo ' Recording Fields' ?>: </label>
                            <select name="rec_fields" id="rec_fields" class="form-control">
                                <option value="<?php echo "ID" ?>"><?php echo "ID" ?></option>
                                <option value="<?php echo "FILENAME" ?>"><?php echo "FILENAME" ?></option>
                                <option value="<?php echo "LOCATION" ?>"><?php echo "LOCATION" ?></option>
                                <option value="<?php echo "ALL" ?>"><?php echo "ALL" ?></option>
                                <option selected="" value="<?php echo "NONE" ?>"><?php echo "NONE" ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo 'Per Call Notes' ?>: </label>
                            <select name="call_notes" id="call_notes" class="form-control">
                                <option value="<?php echo 'YES' ?>"><?php echo 'YES' ?></option>
                                <option selected="" value="<?php echo 'NO' ?>"><?php echo 'NO' ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo 'Export Fields' ?>: </label>
                            <select name="export_fields" id="export_fields" class="form-control">
                                <option selected="" value="<?php echo 'STANDARD' ?>"><?php echo 'STANDARD' ?></option>
                                <option value="<?php echo 'EXTENDED' ?>"><?php echo 'EXTENDED' ?></option>
                                <option value="<?php echo 'ALTERNATE_1' ?>"><?php echo 'ALTERNATE_1' ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo 'Campaigns' ?></label>
                                <select multiple="" name="campaign[]" id="campaigncall" class="form-control" style="min-height: 400px;">
                                    <option value="<?php echo '---NONE---' ?>"><?php echo '---NONE---' ?></option>
                                    <?php foreach($campaigns as $campaign): ?>
                                        <option value="<?php echo $campaign->campaign_id ?>"><?php echo $campaign->campaign_id.' - '.$campaign->campaign_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo 'Inbound Groups' ?></label>
                                <select multiple="" name="group[]" id="groupcall" class="form-control" style="min-height: 400px;">
                                    <option value="<?php echo '---NONE---' ?>"><?php echo '---NONE---' ?></option>
                                    <?php foreach($ingroups as $ingroup): ?>
                                    <option value="<?php echo $ingroup['group_id'] ?>"><?php echo $ingroup['group_id'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo 'Lists' ?></label>
                                <select multiple="" name="list_id[]" id="list_id" class="form-control" style="min-height: 400px;">
                                    <?php foreach($lists as $list): ?>
                                    <option value="<?php echo $list['list_id'] ?>"><?php echo $list['list_id'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo 'Statuses' ?></label>
                                <select multiple="" name="status[]" id="status" class="form-control" style="min-height: 400px;">
                                    <option value="<?php echo "--ALL--" ?>"><?php echo "--ALL--" ?></option>
                                    <?php foreach($statuses as $status): ?>
                                    <option value="<?php echo $status['status'] ?>"><?php echo $status['status'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo 'User Groups' ?></label>
                                <?php if ($this->session->userdata('user')->group_name == 'Agency'): ?>
                                    <select multiple="" name="user_group[]" id="user_group" class="form-control" style="min-height: 400px;">
                                     <?php foreach($user_groups as $usergroup): ?>
                                        <option value="<?php echo $usergroup['user_group'] ?>"><?php echo $usergroup['user_group'] ?></option>
                                     <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <select multiple="" name="user_group[]" id="user_group" class="form-control" style="min-height: 400px;">
                                        <option value="<?php echo "--ALL--" ?>"><?php echo "--ALL--" ?></option>
                                     <?php foreach($user_groups as $usergroup): ?>
                                        <option value="<?php echo $usergroup->user_group ?>"><?php echo $usergroup->user_group ?></option>
                                     <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-9">
                        <button class="btn blue" type="submit"><?php echo 'Submit' ?></button>
                        <!--button type="button" class="btn btn-circle grey-salsa btn-outline">Cancel</button-->
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function selectOther(agencyId){
    jQuery('#loading').modal('show');
    jQuery.ajax({
        url: '<?php echo site_url("dialer/sreport/updateField") ?>',
        method: 'POST',
        data: {id: agencyId},
        dataType: 'JSON',
        success: function(result){
            var flag = Boolean(result.success);
            jQuery('#campaigncall').replaceWith(result.campaign);
            jQuery('#user_group').replaceWith(result.groups);
            jQuery('#groupcall').replaceWith(result.ingroups);
            jQuery('#list_id').replaceWith(result.list);
            jQuery('#loading').modal('hide');
        }
    });
}
jQuery(function(){
    jQuery('.input-daterange').datepicker({
        orientation: "bottom",
    });
});
</script>