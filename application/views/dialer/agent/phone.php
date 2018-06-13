<div class="breadcrumbs">
    <h1 class="page-title"> <?php echo $title; ?> </h1>     
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo $title; ?>
        </li>
    </ol>        
</div>
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
                    <label class="col-md-3 control-label"><?php echo "Outbound CID"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="outbound_cid" maxlength="20" class="form-control" value="<?php echo $phone->outbound_cid; ?>" />
                    </div>
                </div>
<!--                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Voicemail Box"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="voicemail_id" maxlength="10" class="form-control" value="<?php echo $phone->voicemail_id; ?>" />
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agent Screen Login' ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="login" maxlength="15" class="form-control" value="<?php echo $phone->login; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Login Password' ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="password" name="pass" id="pass" maxlength="10" class="form-control" value="<?php echo $phone->pass; ?>" />
                        <br /><button type="button" class="pass-btn btn">Show Password</button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Full Name' ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="fullname" maxlength="50" class="form-control" value="<?php echo $phone->fullname; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Registration Password' ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="password" name="conf_secret" id="conf_secret" maxlength="20" class="form-control" value="<?php echo $phone->conf_secret; ?>" />
                        <br /><button type="button" class="conf-btn btn">Show Password</button>
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
    //jQuery("#call-time").select2();
   // jQuery("#holiday").select2();
    jQuery('#calltimeform').validate({
    rules: {
        extension : "required",
        dialplan_number : "required",
        voicemail_id : "required",
        login : "required",
        pass : "required",
        fullname : "required",
        conf_secret : "required",
        }
    });
    jQuery(document).on('click', '.pass-btn', function(){
        var type = jQuery('#pass').attr('type');
        if(type == 'password'){
            jQuery('#pass').attr('type','text');
            jQuery(this).html('Hide Password');
        }else{
            jQuery('#pass').attr('type','password');
            jQuery(this).html('Show Password');
        }
    });
    jQuery(document).on('click', '.conf-btn', function(){
        var type = jQuery('#conf_secret').attr('type');
        if(type == 'password'){
            jQuery('#conf_secret').attr('type','text');
            jQuery(this).html('Hide Password');
        }else{
            jQuery('#conf_secret').attr('type','password');
            jQuery(this).html('Show Password');
        }
    });
});
</script>
    </div>
</div>