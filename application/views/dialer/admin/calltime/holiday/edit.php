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
            <a href="<?php echo site_url('dialer/calltime/index'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Show Call Times"; ?></span>
            </a>
            <a href="<?php echo site_url('dialer/calltime/edit'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Add New Call Time"; ?></span>
            </a>
            <a href="<?php echo site_url('dialer/calltime/stateindex'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Show State Call Time"; ?></span>
            </a>
            <a href="<?php echo site_url('dialer/calltime/stateedit'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Add New State Call Time"; ?></span>
            </a>
            <a href="<?php echo site_url('dialer/calltime/holidayindex'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Holidays"; ?></span>
            </a>
            <a href="<?php echo site_url('dialer/calltime/holidayedit'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Add Holidays"; ?></span>
            </a>
        </div>
    </div>

    <div class="portlet-body">
        <form name="calltimeform" id="calltimeform" method="post" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Holiday ID"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="holiday_id" class="form-control" value="<?php echo $calltime->holiday_id; ?>" />
                        <span class="help-block"> <?php echo "no spaces or punctuation"; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Holiday Name"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="holiday_name" class="form-control" value="<?php echo $calltime->holiday_name; ?>" />
                        <span class="help-block"> <?php echo "short description of the call time"; ?>  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Holiday Comments" ?></label>
                    <div class="col-md-4">
                    <input name="holiday_comments" class="form-control" value="<?php echo $calltime->holiday_comments; ?>" />
                        <span class="help-block"> <?php echo "short description of the call time"; ?>  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Holiday Date" ?></label>
                    <div class="col-md-4">
                    <input name="holiday_date" class="form-control" value="<?php echo $calltime->holiday_date; ?>" />
                    </div>
                </div>
                <?php if( $calltime->id != '' ): ?>
                    <div class="form-group">
                        <label class="col-md-1"></label>
                        <div class="col-md-9">
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Default Start"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="ct_default_start" value="<?php echo $calltime->ct_default_start ?>" />
                                        </div>
                                    </td>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Default Stop"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" maxlength="4" size="5" name="ct_default_stop" value="<?php echo $calltime->ct_default_stop ?>" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo "AH Override"; ?></label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="default_afterhours_filename_override" value="<?php echo $calltime->default_afterhours_filename_override ?>">
                        </div>
                        <div class="col-md-3">
                            <a href="javascript:void(0)"><?php echo "Audio Chooser"; ?></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo "Holiday Status"; ?></label>
                        <div class="col-md-6">
                            <select class="form-control" name="holiday_status">
                                <option value="<?php echo "ACTIVE"; ?>" <?php echo optionSetValue("ACTIVE",$calltime->holiday_status) ?>><?php echo "ACTIVE"; ?></option>
                                <option value="<?php echo "INACTIVE"; ?>" <?php echo optionSetValue("INACTIVE",$calltime->holiday_status) ?>><?php echo "INACTIVE"; ?></option>
                                <option value="<?php echo "EXPIRED"; ?>" <?php echo optionSetValue("EXPIRED",$calltime->holiday_status) ?>><?php echo "EXPIRED"; ?></option>
                            </select>
                        </div>
                    </div>
            <?php else: ?>
                <p><?php echo "Day and time options will appear once you have created the Call Time Definition"; ?></p>
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
                jQuery('[name="holiday_date"]').datepicker({
                    format: 'yyyy-mm-dd'
                });
                jQuery('#calltimeform').validate({
                    rules: {
                        state_call_time_id : "required",
                        state_call_time_name : "required",
                        <?php if($calltime->id != ''  ): ?>
                        sct_default_start : {
                            maxlength : 4
                        },
                        sct_default_stop : {
                            maxlength : 4
                        },
                        sct_sunday_start : {
                            maxlength : 4
                        },
                        sct_sunday_stop : {
                            maxlength : 4
                        },
                        sct_monday_start : {
                            maxlength : 4
                        },
                        sct_monday_stop : {
                            maxlength : 4
                        },
                        sct_tuesday_start : {
                            maxlength : 4
                        },
                        sct_tuesday_stop : {
                            maxlength : 4
                        },
                        sct_wednesday_start : {
                            maxlength : 4
                        },
                        sct_wednesday_stop : {
                            maxlength : 4
                        },
                        sct_thursday_start : {
                            maxlength : 4
                        },
                        sct_thursday_stop : {
                            maxlength : 4
                        },
                        sct_friday_start : {
                            maxlength : 4
                        },
                        sct_friday_stop : {
                            maxlength : 4
                        },
                        sct_saturday_start : {
                            maxlength : 4
                        },
                        sct_saturday_stop : {
                            maxlength : 4
                        },
                        <?php endif; ?>
                    }
                });
            });
        </script>
    </div>
</div>