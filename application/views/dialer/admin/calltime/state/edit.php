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
                    <label class="col-md-3 control-label"><?php echo "State Call Time ID"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="state_call_time_id" class="form-control" value="<?php echo $calltime->state_call_time_id; ?>" />
                        <span class="help-block"> <?php echo "no spaces or punctuation"; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "State Call Time Name"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="state_call_time_name" class="form-control" value="<?php echo $calltime->state_call_time_name; ?>" />
                        <span class="help-block"> <?php echo "short description of the call time"; ?>  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "State Call Time State"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <select name="state_call_time_state" class="form-control">
                            <option value=""><?php echo "Please Select"; ?></option>
                            <?php foreach($states as $key => $state): ?>
                                <option value="<?php echo $state['abbreviation'] ?>" <?php echo optionSetValue($state['abbreviation'],$calltime->state_call_time_state); ?>><?php echo $state['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "State Call Time Comments" ?></label>
                    <div class="col-md-4">
                    <input name="state_call_time_comments" class="form-control" value="<?php echo $calltime->state_call_time_comments; ?>" />
                        <span class="help-block"> <?php echo "short description of the call time"; ?>  </span>
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
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_default_start" value="<?php echo $calltime->sct_default_start ?>" />
                                        </div>
                                    </td>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Default Stop"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" maxlength="4" size="5" name="sct_default_stop" value="<?php echo $calltime->sct_default_stop ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Sunday Start"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" maxlength="4" size="5" name="sct_sunday_start" value="<?php echo $calltime->sct_sunday_start ?>" />
                                        </div>
                                    </td>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Sunday Stop"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" maxlength="4" size="5" name="sct_sunday_stop" value="<?php echo $calltime->sct_sunday_stop ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Monday Start"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_monday_start" value="<?php echo $calltime->sct_sunday_start ?>" />
                                        </div>
                                    </td>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Monday Stop"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_monday_stop" value="<?php echo $calltime->sct_monday_stop ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Tuesday Start"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_tuesday_start" value="<?php echo $calltime->sct_tuesday_start ?>" />
                                        </div>
                                    </td>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Tuesday Stop"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_tuesday_stop" value="<?php echo $calltime->sct_tuesday_stop ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Wednesday Start"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_wednesday_start" value="<?php echo $calltime->sct_wednesday_start ?>" />
                                        </div>
                                    </td>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Wednesday Stop"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_wednesday_stop" value="<?php echo $calltime->sct_wednesday_stop ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Thursday Start"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_thursday_start" value="<?php echo $calltime->sct_thursday_start ?>" />
                                        </div>
                                    </td>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Thursday Stop"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_thursday_stop" value="<?php echo $calltime->sct_thursday_stop ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Friday Start"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_friday_start" value="<?php echo $calltime->sct_friday_start ?>" />
                                        </div>
                                    </td>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Friday Stop"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_friday_stop" value="<?php echo $calltime->sct_friday_stop ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Saturday Start"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_saturday_start" value="<?php echo $calltime->sct_saturday_start ?>" />
                                        </div>
                                    </td>
                                    <td>
                                        <label class="col-md-6 control-label"><?php echo "Saturday Stop"; ?>:</label>
                                        <div class="col-md-6">
                                            <input type="text" maxlength="4" size="5" class="form-control" name="sct_saturday_stop" value="<?php echo $calltime->sct_saturday_stop ?>" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo "Holiday rule"; ?></label>
                        <div class="col-md-4">
                            <?php $holidayTimes = explode(',', $calltime->ct_holidays) ?>
                            <select name="ct_holidays[]" class="form-control" id="holiday" multiple="">
                                <?php foreach ($holidayRules as $key => $holidayRule) : ?>
                                    <option value="<?php echo $holidayRule->id; ?>" <?php echo in_array($holidayRule->id, $holidayTimes) ? 'selected="selected"':'' ?>><?php echo $holidayRule->holiday_id.'-'.$holidayRule->holiday_name ?></option>
                                <?php endforeach; ?>
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
                jQuery("#holiday").select2();
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