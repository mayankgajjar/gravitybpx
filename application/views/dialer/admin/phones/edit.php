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
        <form name="calltimeform" id="calltimeform" method="post" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Phone Extension"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="extension" maxlength="100" class="form-control" value="<?php echo $phone->extension; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Dial Plan Number"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="dialplan_number" maxlength="20" class="form-control" value="<?php echo $phone->dialplan_number; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Voicemail Box"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="voicemail_id" maxlength="10" class="form-control" value="<?php echo $phone->voicemail_id; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Screen Login' ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="login" maxlength="15" class="form-control" value="<?php echo $phone->login; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Login Password' ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="pass" maxlength="10" class="form-control" value="<?php echo $phone->pass; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Full Name' ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="fullname" maxlength="50" class="form-control" value="<?php echo $phone->fullname; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Active' ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-3">
                        <select class="form-control" name="active">
                            <option value="Y" <?php echo optionSetValue('Y', $phone->active) ?>><?php echo 'Yes' ?></option>
                            <option value="N" <?php echo optionSetValue('N', $phone->active) ?>><?php echo 'No' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Registration Password' ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="conf_secret" maxlength="20" class="form-control" value="<?php echo $phone->conf_secret; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Template ID" ?></label>
                    <div class="col-md-4">
                        <select name="template_id" class="form-control">
                            <option <?php echo $phone->template_id == '' ? 'selected="selected"':'' ?>><?php echo 'NONE' ?></option>
                            <?php foreach($templates as $template): ?>
                                <option value="<?php echo $template->template_id ?>" <?php echo optionSetValue($template->template_id, $phone->template_id) ?>><?php echo $template->template_id ?></option>
                            <?php endforeach; ?>
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
            jQuery(function(){
                jQuery("#call-time").select2();
                jQuery("#holiday").select2();
                jQuery('#calltimeform').validate({
                    rules: {
                        extension : "required",
                        dialplan_number : "required",
                        voicemail_id : "required",
                        login : "required",
                        pass : "required",
                        fullname : "required",
                        active : "required",
                        conf_secret : "required",
                    }
                });
            });
        </script>
    </div>
</div>