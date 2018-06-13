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
            <input type="hidden" name="min_sec" value="0" />
            <input type="hidden" name="max_sec" value="0" />
            <div class="form-body">
              <div class="form-group">
                  <label class="col-md-3 control-label"><?php echo "Status"; ?><span class="required">*</span></label>
                  <div class="col-md-4">
                      <input type="text" maxlength="6" name="status" class="form-control" value="<?php echo $sData->status ?>" />
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-3 control-label"><?php echo "Description"; ?><span class="required">*</span></label>
                  <div class="col-md-4">
                      <input type="text" maxlength="30" name="status_name" class="form-control" value="<?php echo $sData->status_name ?>" />
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-3 control-label"><?php echo 'Category' ?></label>
                  <div class="col-md-4">
                      <select name="category" class="form-control">
                          <option value="UNDEFINED" <?php echo optionSetValue('UNDEFINED', $sData->category) ?>><?php echo 'UNDEFINED - Default Category' ?></option>
                      </select>
                  </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Agent Selectable' ?></label>
                <div class="col-md-4">
                    <select class="form-control" name="selectable">
                        <option value="<?php echo 'Y' ?>" <?php echo optionSetValue('Y', $sData->selectable) ?>><?php echo 'Y' ?></option>
                        <option value="<?php echo 'N' ?>" <?php echo optionSetValue('N', $sData->selectable) ?>><?php echo 'N' ?></option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Human Answer' ?></label>
                <div class="col-md-4">
                    <select class="form-control" name="human_answered">
                        <option value="<?php echo 'Y' ?>" <?php echo optionSetValue('N', $sData->human_answered) ?>><?php echo 'Y' ?></option>
                        <option value="<?php echo 'N' ?>" <?php echo optionSetValue('N', $sData->human_answered) ?>><?php echo 'N' ?></option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Sale' ?></label>
                <div class="col-md-4">
                    <select class="form-control" name="sale">
                        <option value="<?php echo 'Y' ?>" <?php echo optionSetValue('N', $sData->sale) ?>><?php echo 'Y' ?></option>
                        <option value="<?php echo 'N' ?>" <?php echo optionSetValue('N', $sData->sale) ?>><?php echo 'N' ?></option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'DNC' ?></label>
                <div class="col-md-4">
                    <select class="form-control" name="dnc">
                        <option value="<?php echo 'Y' ?>" <?php echo optionSetValue('N', $sData->dnc) ?>><?php echo 'Y' ?></option>
                        <option value="<?php echo 'N' ?>" <?php echo optionSetValue('N', $sData->dnc) ?>><?php echo 'N' ?></option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Customer Contact' ?></label>
                <div class="col-md-4">
                    <select class="form-control" name="customer_contact">
                        <option value="<?php echo 'Y' ?>" <?php echo optionSetValue('N', $sData->customer_contact) ?>><?php echo 'Y' ?></option>
                        <option value="<?php echo 'N' ?>" <?php echo optionSetValue('N', $sData->customer_contact) ?>><?php echo 'N' ?></option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Not Intrested' ?></label>
                <div class="col-md-4">
                    <select class="form-control" name="not_interested">
                        <option value="<?php echo 'Y' ?>" <?php echo optionSetValue('N', $sData->not_interested) ?>><?php echo 'Y' ?></option>
                        <option value="<?php echo 'N' ?>" <?php echo optionSetValue('N', $sData->not_interested) ?>><?php echo 'N' ?></option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Unworkable' ?></label>
                <div class="col-md-4">
                    <select class="form-control" name="unworkable">
                        <option value="<?php echo 'Y' ?>" <?php echo optionSetValue('N', $sData->unworkable) ?>><?php echo 'Y' ?></option>
                        <option value="<?php echo 'N' ?>" <?php echo optionSetValue('N', $sData->unworkable) ?>><?php echo 'N' ?></option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Scheduled Callbacks' ?></label>
                <div class="col-md-4">
                    <select class="form-control" name="scheduled_callbacks">
                        <option value="<?php echo 'Y' ?>" <?php echo optionSetValue('N', $sData->scheduled_callback) ?>><?php echo 'Y' ?></option>
                        <option value="<?php echo 'N' ?>" <?php echo optionSetValue('N', $sData->scheduled_callback) ?>><?php echo 'N' ?></option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Completed' ?></label>
                <div class="col-md-4">
                    <select class="form-control" name="completed">
                        <option value="<?php echo 'Y' ?>" <?php echo optionSetValue('N', $sData->completed) ?>><?php echo 'Y' ?></option>
                        <option value="<?php echo 'N' ?>" <?php echo optionSetValue('N', $sData->completed) ?>><?php echo 'N' ?></option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Answering Machine' ?></label>
                <div class="col-md-4">
                    <select class="form-control" name="answering_machine">
                        <option value="<?php echo 'Y' ?>" <?php echo optionSetValue('N', $sData->answering_machine) ?>><?php echo 'Y' ?></option>
                        <option value="<?php echo 'N' ?>" <?php echo optionSetValue('N', $sData->answering_machine) ?>><?php echo 'N' ?></option>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Transfer to CRM' ?></label>
                <div class="col-md-4">
                    <select class="form-control" name="transfer_crm">
                        <option value="<?php echo 'Y' ?>" <?php echo optionSetValue('N', $sData->transfer_crm) ?>><?php echo 'Y' ?></option>
                        <option value="<?php echo 'N' ?>" <?php echo optionSetValue('N', $sData->transfer_crm) ?>><?php echo 'N' ?></option>
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
    </div>
</div>
<script type="text/javascript">
  jQuery(function(){
    jQuery('#calltimeform').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules:{
           status :{
               required: true,
           },
           status_name:{
               required: true,
           }
       },
        highlight: function (element) { // hightlight error inputs
             $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
  });
</script>