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
                    <label class="col-md-3 control-label"><?php echo 'DID Extension' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="did_pattern" maxlength="50" class="form-control" value="<?php echo $did->did_pattern ?>"/>
                        <span class="help-content"><?php echo 'no spaces or dashes' ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'DID Description' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="did_description" maxlength="50" class="form-control" value="<?php echo $did->did_description ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agency' ?></label>
                    <div class="col-md-4">
                        <?php  $tree = buildTree($agencies,0); ?>
                        <select name="agency_id" class="form-control" class="agency_id" onchange="javascript:selectGroup(this.value)">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <?php echo printTree($tree,0, null, $did->agency_id ); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Admin User Group' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <select class="form-control" name="user_group" id="user_group">
                            <option value="---ALL---" <?php echo optionSetValue($did->user_group,'---ALL---') ?>><?php echo 'All Admin User Groups' ?></option>
                            <?php foreach($groups as $group) : ?>
                            <option value="<?php echo $group->user_group; ?>" <?php echo optionSetValue($did->user_group, $group->user_group) ?>><?php echo $group->user_group.' - '.$group->group_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Active' ?></label>
                    <div class="col-md-4">
                        <select name="did_active" class="form-control">
                            <option value="N" <?php echo optionSetValue($did->did_active, 'N') ?>><?php echo 'No' ?></option>
                            <option value="Y" <?php echo optionSetValue($did->did_active, 'Y') ?>><?php echo 'Yes' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'DID Route' ?></label>
                    <div class="col-md-4">
                        <select name="did_route" class="form-control">
                            <option value="AGENT" <?php echo optionSetValue($did->did_route, 'AGENT') ?>><?php echo 'AGENT' ?></option>
                            <option value="EXTEN" <?php echo optionSetValue($did->did_route, 'EXTEN') ?>><?php echo 'EXTEN' ?></option>
                            <option value="VOICEMAIL" <?php echo optionSetValue($did->did_route, 'VOICEMAIL') ?>><?php echo 'VOICEMAIL' ?></option>
                            <option value="VMAIL_NO_INST" <?php echo optionSetValue($did->did_route, 'VMAIL_NO_INST') ?>><?php echo 'VMAIL_NO_INST' ?></option>
                            <option value="PHONE" <?php echo optionSetValue($did->did_route, 'PHONE') ?>><?php echo 'PHONE' ?></option>
                            <option value="IN_GROUP" <?php echo optionSetValue($did->did_route, 'IN_GROUP') ?>><?php echo 'IN_GROUP' ?></option>
                            <option value="CALLMENU" <?php echo optionSetValue($did->did_route, 'CALLMENU') ?>><?php echo 'CALLMENU' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Extension' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="extension" maxlength="50" class="form-control" value="<?php echo $did->extension ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Voicemail Box' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="voicemail_ext" id="voicemail_ext" class="form-control" maxlength="10" value="<?php echo $did->voicemail_ext ?>">
                    </div>
                    <div class="col-md-3">
                        <a href="<?php echo site_url('dialer/ajax/getvoicemaillist') ?>" data-toggle="modal" data-target="#ajax"><?php echo 'voicemail chooser' ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Phone Extension' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="phone" maxlength="100" class="form-control" value="<?php echo $did->phone ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Call Menu' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="menu_id" id="menu_id">
                            <option value="" <?php echo optionSetValue($did->menu_id, '') ?>><?php echo '' ?></option>
                            <?php foreach($callmenues as $callmenu): ?>
                            <option value="<?php echo $callmenu->menu_id ?>" <?php echo optionSetValue($did->menu_id, $callmenu->menu_id) ?>><?php echo $callmenu->menu_id.' - '.$callmenu->menu_name.' - '.$callmenu->menu_prompt ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class='form-group'>
                    <label class='col-md-3 control-label'><?php echo 'User agent' ?></label>
                    <div class='col-md-4'>
                        <input type="text" name="user" class="form-control" maxlength="20" value="<?php echo $did->user ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'User Unavailable Action' ?></label>
                    <div class="col-md-4">
                        <select name="user_unavailable_action" class="form-control">
                            <option value="EXTEN" <?php echo optionSetValue($did->user_unavailable_action, 'EXTEN') ?>><?php echo 'EXTEN' ?></option>
                            <option value="VOICEMAIL" <?php echo optionSetValue($did->user_unavailable_action, 'VOICEMAIL') ?>><?php echo 'VOICEMAIL' ?></option>
                            <option value="VMAIL_NO_INST" <?php echo optionSetValue($did->user_unavailable_action, 'VMAIL_NO_INST') ?>><?php echo 'VMAIL_NO_INST' ?></option>
                            <option value="PHONE" <?php echo optionSetValue($did->user_unavailable_action, 'PHONE') ?>><?php echo 'PHONE' ?></option>
                            <option value="IN_GROUP" <?php echo optionSetValue($did->user_unavailable_action, 'IN_GROUP') ?>><?php echo 'IN_GROUP' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'User Route Settings In-Group' ?></label>
                    <div class="col-md-4">
                        <select name="user_route_settings_ingroup" id="user_route_settings_ingroup" class="form-control">

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'In-Group IDs' ?></label>
                    <div class="col-md-4">
                        <select name="group_id" id="group_id" class="form-control">

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
jQuery(function(){
    jQuery('.did-edit').addClass('active');
    selectUserIngroup('<?php echo isset($did->agency_id) ? $did->agency_id : '' ?>','<?php echo $did->group_id ?>');
    selectRouteIngroup('<?php echo isset($did->agency_id) ? $did->agency_id : '' ?>','<?php echo $did->user_route_settings_ingroup ?>');
    selectCallmenu('<?php echo isset($did->agency_id) ? $did->agency_id : '' ?>', '<?php echo $did->menu_id ?>');
    jQuery('#did').addClass('active');
    jQuery('#groupForm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules:{
           did_pattern :{
               required: true,
               minlenght: 2,
               maxlenght: 50,

           },
           did_description:{
               required: true,
               maxlenght: 50,
           }
       },
        highlight: function (element) { // hightlight error inputs
             $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
});
function selectGroup(agency_id, groupId){
    groupId = '<?php echo $did->user_group ?>';
    jQuery.ajax({
        url : '<?php echo site_url('dialer/voicemail/getAgencyGroup/') ?>',
        method : 'POST',
        dataType : 'json',
        data : {id : agency_id,group: groupId},
        success: function(result){
            var flag = Boolean(result.success);
            jQuery('#user_group').replaceWith(result.html);
        }
    });
    var ingroup = '<?php echo $did->group_id ?>';
    selectUserIngroup(agency_id,ingroup);
    routeingroup = '<?php echo $did->user_route_settings_ingroup  ?>';
    selectRouteIngroup(agency_id,routeingroup);
    var menu_id = '<?php echo $did->menu_id ?>';
    selectCallmenu(agency_id,menu_id);
}
function selectVoicemail(voicemail){
    jQuery('#voicemail_ext').val(voicemail);
    jQuery('#ajax').modal('hide');
}
function selectUserIngroup(agency_id, ingroup){
    jQuery.ajax({
        url : '<?php echo site_url('dialer/ajax/getingroups') ?>',
        method : 'POST',
        dataType : 'json',
        data : {id : agency_id, ingroup : ingroup },
        success : function(result){
            var flag = Boolean(result.success);
            jQuery('#group_id').replaceWith(result.html);
        }
    });
}
function selectRouteIngroup(agency_id, routeingroup){
    jQuery.ajax({
        url : '<?php echo site_url('dialer/ajax/getrouteingroup') ?>',
        method : 'POST',
        dataType : 'json',
        data : {id : agency_id, ingroup : routeingroup },
        success : function(result){
            var flag = Boolean(result.success);
            jQuery('#user_route_settings_ingroup').replaceWith(result.html);
        }
    });
}
function selectCallmenu(agency_id, callmenu){
    jQuery.ajax({
        url : '<?php echo site_url('dialer/ajax/getcallmenu') ?>',
        method : 'POST',
        dataType : 'json',
        data : {id : agency_id, menu : callmenu },
        success : function(result){
            var flag = Boolean(result.success);
            jQuery('#menu_id').replaceWith(result.html);
        }
    });
}
</script>
<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo site_url() ?>/assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>