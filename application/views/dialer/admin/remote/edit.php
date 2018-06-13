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
        <div class="actions">
        </div>
    </div>

    <div class="portlet-body">
        <form name="calltimeform" id="calltimeform" method="post" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agency' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <?php  $tree = buildTree($agencies,0); ?>
                        <select name="agency_id" class="form-control" class="agency_id" onchange="javascript:selectUsers(this.value)">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <?php echo printTreeWithEncrypt($tree,0, null, $ragent->agency_id ); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'User ID Start' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="user_start" class="form-control" id="user_start" value="<?php echo $ragent->user_start ?>" maxlength="9"/>
                        <span class="help-content"><?php echo 'numbers only, incremented, must be an existing vicidial user' ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Number of Lines' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="number_of_lines" class="form-control" id="number_of_lines" value="<?php echo $ragent->number_of_lines ?>" maxlength="3"/>
                        <span class="help-content"><?php echo 'numbers only' ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'External Extension' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="conf_exten" class="form-control" id="conf_exten" value="<?php echo $ragent->conf_exten ?>" maxlength="20"/>
                        <span class="help-content"><?php echo 'dial plan number dialed to reach agents' ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Extension Group' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="extension_group" id="extension_group">
                            <option value='NONE' <?php echo optionSetValue('NONE', $ragent->extension_group) ?>><?php echo "NONE" ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Status' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="status">
                            <option value="ACTIVE" <?php echo optionSetValue('ACTIVE', $ragent->extension_group) ?>><?php echo 'ACTIVE' ?></option>
                            <option value="INACTIVE" <?php echo optionSetValue('INACTIVE', $ragent->extension_group) ?>><?php echo 'INACTIVE' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Campaign' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="campaign_id" id="campaign_id">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'On-Hook Agent' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="on_hook_agent">
                            <option value="Y"><?php echo 'Yes' ?></option>
                            <option value="N" selected=""><?php echo 'No' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'On-Hook Ring Time' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="on_hook_ring_time" id="on_hook_ring_time" class="form-control" value="<?php echo $ragent->on_hook_ring_time ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Inbound Groups' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="closer_campaigns[]" multiple="" id="group_id">
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn blue">Submit</button>
                        <!--button type="button" class="btn btn-circle grey-salsa btn-outline">Cancel</button-->
                    </div>
                </div>
            </div>
        </form>
<script type="text/javascript">
function selectUsers(agencyId){
   jQuery('#loading').modal('show');
   jQuery.ajax({
       url : '<?php echo site_url('dialer/ajax/getUser/') ?>',
       method : 'POST',
       async : false,
       dataType : 'json',
       data : {id : agencyId, user : '<?php echo isset($ragent->user_start) ? $ragent->user_start : "" ?>'},
       success: function(result){
           var flag = Boolean(result.success);
           jQuery('#user_start').replaceWith(result.html);
           jQuery('#loading').modal('hide');
       }
   });
   selectCampaign(agencyId, false);
   selectIngroup(agencyId, false);
   selectExtensionGroup(agencyId, false);
}
function selectCampaign(value, loader){
   if(loader == true){
       jQuery('#loading').modal('show');
   }
   jQuery.ajax({
       url : '<?php echo site_url('dialer/ajax/getCampaigns/') ?>',
       method : 'POST',
       async : false,
       dataType : 'json',
       data : {id : value, campaign : '<?php echo isset($ragent->campaign_id) ? $ragent->campaign_id : "" ?>'},
       success: function(result){
           var flag = Boolean(result.success);
           jQuery('#campaign_id').replaceWith(result.html);
            if(loader == true){
                jQuery('#loading').modal('show');
            }
       }
   });
}
function selectIngroup(value, loader){
   if(loader == true){
       jQuery('#loading').modal('show');
   }
   <?php
       $ingroups = preg_replace("/ -$/","",$ragent->closer_campaigns);
       $ingroups = explode(" ",$ingroups);
   ?>
   jQuery.ajax({
       url : '<?php echo site_url('dialer/ajax/getringroups/') ?>',
       method : 'POST',
       async : false,
       dataType : 'json',
       data : {id : value, ingroup : '<?php echo json_encode($ingroups) ?>'},
       success: function(result){
           var flag = Boolean(result.success);
           jQuery('#group_id').replaceWith(result.html);
            if(loader == true){
                jQuery('#loading').modal('show');
            }
       }
   });
}
function selectExtensionGroup(value, loader){
   if(loader == true){
       jQuery('#loading').modal('show');
   }
   jQuery.ajax({
       url : '<?php echo site_url('dialer/ajax/getexgroup/') ?>',
       method : 'POST',
       async : false,
       dataType : 'json',
       data : {id : value, group : '<?php echo isset($ragent->extension_group) ? $ragent->extension_group : "" ?>'},
       success: function(result){
           var flag = Boolean(result.success);
           jQuery('#extension_group').replaceWith(result.html);
            if(loader == true){
                jQuery('#loading').modal('hide');
            }
       }
   });
}
jQuery(function(){
    <?php if($ragent->remote_agent_id > 0): ?>
            selectUsers('<?php echo encode_url($ragent->agency_id) ?>');
    <?php endif; ?>
    jQuery('#calltimeform').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            user_start : {
                required: true,
            },
            number_of_lines :{
                required: true,
                number : true,
            }
        },
        highlight: function (element) { // hightlight error inputs
             $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
});
</script>
    </div>
</div>