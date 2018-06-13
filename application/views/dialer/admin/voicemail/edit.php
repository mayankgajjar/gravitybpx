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
                    <label class="col-md-3 control-label"><?php echo 'Voicemail ID' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="voicemail_id" maxlength="10" class="form-control" value="<?php echo $voicemail->voicemail_id ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Password' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="pass" maxlength="10" class="form-control" value="<?php echo $voicemail->pass ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Name' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="fullname" maxlength="100" class="form-control" value="<?php echo $voicemail->fullname ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Active' ?></label>
                    <div class="col-md-4">
                        <select name="active" class="form-control">
                            <option value="N" <?php echo optionSetValue($voicemail->active, "N") ?>>N</option>
                            <option value="Y" <?php echo optionSetValue($voicemail->active, "Y") ?>>Y</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Email' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="email" maxlength="100" class="form-control" value="<?php echo $voicemail->email ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agency' ?></label>
                    <div class="col-md-4">
                        <?php  $tree = buildTree($agencies,0); ?>
                        <select name="agency_id"  class="form-control" class="agency_id" onchange="javascript:selectGroup(this.value)">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <?php echo printTree($tree,0, null, $voicemail->agency_id ); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Admin User Group' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="user_group" id="user_group">
                            <option value="---ALL---" <?php echo optionSetValue($voicemail->user_group,'---ALL---') ?>><?php echo 'All Admin User Groups' ?></option>
                            <?php foreach($groups as $group) : ?>
                            <option value="<?php echo $group->user_group; ?>" <?php echo optionSetValue($voicemail->user_group, $group->user_group) ?>><?php echo $group->user_group.' - '.$group->group_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?php if($voicemail->voicemail_id != ''): ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Delete Voicemail After Email' ?></label>
                    <div class="col-md-4">
                        <select name="delete_vm_after_email" class="form-control">
                            <option value="N" <?php echo optionSetValue($voicemail->delete_vm_after_email, "N") ?>>N</option>
                            <option value="Y" <?php echo optionSetValue($voicemail->delete_vm_after_email, "Y") ?>>Y</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Show VM on Summary Screen' ?></label>
                    <div class="col-md-4">
                        <select name="on_login_report" class="form-control">
                            <option value="N" <?php echo optionSetValue($voicemail->on_login_report, "N") ?>>N</option>
                            <option value="Y" <?php echo optionSetValue($voicemail->on_login_report, "Y") ?>>Y</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Voicemail Greeting' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="voicemail_greeting" id="voicemail_greeting" class="form-control" value="<?php echo $voicemail->voicemail_greeting ?>"/>
                    </div>
                    <div class="col-ms-2">
                        <a href="<?php echo site_url('dialer/voicemail/sound') ?>" data-toggle="modal" data-target="#ajax"><?php echo 'Audio Chooser' ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Voicemail Zone' ?></label>
                    <div class="col-md-4">

                        <?php $vm_zones = explode("\n",$zones); ?>
                        <?php $z = 0 ?>
                        <?php $vm_zones_ct = count($vm_zones); ?>
                        <select name="voicemail_timezone" class="form-control">
                            <?php while($vm_zones_ct > $z) : ?>
                                <?php if (strlen($vm_zones[$z]) > 5) : ?>
                                    <?php
                                        $vm_specs = explode("=",$vm_zones[$z]);
                                        $vm_abb = $vm_specs[0];
                                        $vm_details = explode('|',$vm_specs[1]);
                                        $vm_location = 	$vm_details[0];
                                    ?>
                                    <option value="<?php echo $vm_abb ?>" <?php echo optionSetValue($voicemail->voicemail_timezone, $vm_abb) ?>><?php echo $vm_abb .'-'. $vm_location ?></option>
                                <?php endif; ?>
                                <?php $z++; ?>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Voicemail Options' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="voicemail_options" maxlength="100" class="form-control" value="<?php echo $voicemail->voicemail_options ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'New Messages' ?></label>
                    <div class="col-md-4">
                        <label class="form-control"><?php echo $voicemail->messages ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Old Messages' ?></label>
                    <div class="col-md-4">
                        <label class="form-control"><?php echo $voicemail->old_messages ?></label>
                    </div>
                </div>
                <?php endif; ?>
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
    jQuery('.voicemail').addClass('active');
    jQuery('#groupForm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules:{
           voicemail_id :{
               required: true,
               minlenght: 2,
               maxlenght: 20,

           },
           pass:{
               required: true,
               minlenght: 4,
               maxlenght: 10,
           },
           fullname:{
               required: true,
           }
       },
        highlight: function (element) { // hightlight error inputs
             $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
});
function chooseFile(file){
    jQuery('#voicemail_greeting').val(file);
    jQuery('#ajax').modal('hide');
}
function selectGroup(agency_id, groupId){
               groupId = '<?php echo $voicemail->user_group ?>';
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
}
</script>
<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo site_url() ?>/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>