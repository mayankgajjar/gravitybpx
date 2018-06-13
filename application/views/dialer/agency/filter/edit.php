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
                    <label class="col-md-3 control-label"><?php echo 'Filter ID' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="lead_filter_id" maxlength="20" class="form-control" value="<?php echo $filter->lead_filter_id ?>"/>
                        <span class="help-content"><?php echo '(no spaces or punctuation) ' ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Filter Name' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="lead_filter_name" maxlength="30" class="form-control" value="<?php echo $filter->lead_filter_name ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Filter Comments' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="lead_filter_comments" class="form-control" value="<?php echo $filter->lead_filter_comments ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Admin User Group' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="user_group">
                            <?php foreach($groups as $group) : ?>
                            <option value="<?php echo $group['user_group']; ?>" <?php echo optionSetValue($filter->user_group, $group['user_group']) ?>><?php echo $group['user_group'].' - '.$group['group_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Select Filter' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <select name="filter_options" id="filter_options" class="form-control">
                            <option value=""><?php echo '---Select Options---' ?></option>
                            <option value="area_code" <?php echo optionSetValue($filter->filter_options, 'area_code') ?>><?php echo 'Area Code' ?></option>
                            <option value="postel_code" <?php echo optionSetValue($filter->filter_options, 'postel_code') ?>><?php echo 'Postel Code' ?></option>
                            <option value="state" <?php echo optionSetValue($filter->filter_options, 'state') ?>><?php echo 'State' ?></option>
                            <option value="custom" <?php echo optionSetValue($filter->filter_options, 'custom') ?>><?php echo 'Custom Query' ?></option>
                        </select>
                    </div>
                </div>
                <div id="type" class="form-group" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo 'Filter Type' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="filter_type">
                            <option value=""><?php echo 'Please Select' ?></option>
                            <option value="in" <?php echo optionSetValue($filter->filter_type, 'IN') ?>><?php echo 'In' ?></option>
                            <option value="not-in" <?php echo optionSetValue($filter->filter_type, 'NOT IN') ?>><?php echo 'Not In' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="values" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo 'Filter Value' ?></label>
                    <div class="col-md-4">
                        <textarea name="filter_values" class="form-control" style="height: 200px;"><?php echo $filter->filter_values ?></textarea>
                        <span id="help" class="help-content"></span>
                    </div>
                </div>
                <div class="form-group" style="display: none;" id="sql">
                    <label class="col-md-3 control-label"><?php echo 'Filter SQL' ?></label>
                    <div class="col-md-4">
                        <textarea name="lead_filter_sql" class="form-control" style="height: 200px;"><?php echo $filter->lead_filter_sql ?></textarea>

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
    jQuery('.add-filter').addClass('active');
    jQuery(document).on('change','#filter_options',function(){
       var val = jQuery(this).val();
       if(val.length > 0){
           switch(val){
               case 'area_code':
                   jQuery('#help').html('<?php echo 'Add cooma separated list of area codes.' ?>');
                   jQuery('#type').show();
                   jQuery('#values').show();
                   jQuery('#sql').hide();
                   break;
               case 'postel_code':
                   jQuery('#help').html('<?php echo 'Add cooma separated list of postel codes.' ?>');
                   jQuery('#type').show();
                   jQuery('#values').show();
                   jQuery('#sql').hide();
                   break;
               case 'state':
                   jQuery('#help').html('<?php echo 'Add cooma separated list of states.' ?>');
                   jQuery('#type').show();
                   jQuery('#values').show();
                   jQuery('#sql').hide();
                   break;
               case 'custom':
                   jQuery('#help').html('');
                   jQuery('#type').hide();
                   jQuery('#sql').show();
                   jQuery('#values').hide();
                   break;
           }
       }else{
           jQuery('#help').html('');
           jQuery('#type, #values', '#sql').hide();
       }

    });
    jQuery('#filter_options').trigger('change');
    jQuery('#groupForm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules:{
           lead_filter_id :{
               required: true,
               minlenght: 2,
               maxlenght: 20,

           },
           lead_filter_name:{
               required: true,
               minlenght: 4,
               maxlenght: 40,
           }
       },
        highlight: function (element) { // hightlight error inputs
             $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
});
</script>