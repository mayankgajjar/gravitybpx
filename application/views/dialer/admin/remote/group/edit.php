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
                    <label class="col-md-3 control-label"><?php echo 'Agency' ?></label>
                    <div class="col-md-4">
                        <?php  $tree = buildTree($agencies,0); ?>
                        <select name="agency_id" class="form-control" class="agency_id">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <?php echo printTreeWithEncrypt($tree,0, null, $rgroup->agency_id); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Extension Group' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="extension_group_id" id="extension_group_id" class="form-control" value="<?php echo $rgroup->extension_group_id ?>" maxlength="20"/>
                        <span class="help-content"><?php echo 'no spaces' ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Extension' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="extension" id="extension" class="form-control" value="<?php echo $rgroup->extension ?>" maxlength="18"/>
                        <span class="help-content"><?php echo 'numbers only' ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Rank' ?></label>
                    <div class="col-md-1">
                        <select class="form-control" name="rank">
                            <?php $n = 99; $rank = isset($rgroup->extension) && $rgroup->extension != '' ? $rgroup->extension : 0 ; ?>
                            <?php while($n>=-99): ?>
                                <option value="<?php echo $n ?>" <?php if($n == $rank){ echo 'selected="selected"'; } ?>><?php echo $n ?></option>
                                <?php $n--; ?>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Extension Group' ?></label>
                    <div class="col-md-7">
                        <input type="text" name="campaign_groups" id="campaign_groups" class="form-control" value="<?php echo $rgroup->campaign_groups  ?>" maxlength="255"/>
                        <span class="help-content"><?php echo 'pipe-delimited list' ?></span>
                    </div>
                </div>
                <?php if($rgroup->extension_id > 0): ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Call Count Today' ?></label>
                    <div class="col-md-4">
                        <label class="control-label"><?php echo $rgroup->call_count_today ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Last Call Time' ?></label>
                    <div class="col-md-4">
                        <label class="control-label"><?php echo $rgroup->last_call_time ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Last Call ID' ?></label>
                    <div class="col-md-4">
                        <label class="control-label"><?php echo $rgroup->last_callerid ?></label>
                    </div>
                </div>
                <?php endif; ?>
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
    jQuery('#calltimeform').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            extension_group_id : {
                required: true,
            },
            extension :{
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