<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE HEADER-->   
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="<?php echo site_url(); ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Notification Setting</span>
            </li>
        </ul>
        <div class="page-toolbar">           
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Notification Setting </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">    
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="icon-bubble font-dark"></i>
            <span class="caption-subject bold uppercase">Notification Setting</span>
        </div>        
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <?php 
            if($this->session->flashdata())
            {
                if($this->session->flashdata('error') != "")
                {
                ?>
                    <div class='alert alert-danger'>
                        <i class="fa-lg fa fa-warning"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php    
                }
                else
                {                    
                ?>
                    <div class='alert alert-success'>
                        <?php echo $this->session->flashdata('msg'); ?>
                    </div>
                <?php
                }
            }
        ?> 
        <form class="form-horizontal form-row-seperated" action="<?php echo site_url('others/theme_options/add/notifications_setting') ?>" name="notifications_setting_form" method="post" id="notifications_setting_form">            
            <div class="tabbable-bordered">                               
                        <div class="form-body">
                            <?php                                
                                if(!empty($notifications_setting_data))
                                {
                                    $notifications_setting_result = unserialize($notifications_setting_data['theme_options_values']);
                                    $id = $notifications_setting_data['id'];
                                    $sales_agent_customer_submitted_notification = $notifications_setting_result['sales_agent_customer_submitted_notification'];
                                    $verification_agent_customer_not_verified_notification = $notifications_setting_result['verification_agent_customer_not_verified_notification'];
                                }
                                else
                                {
                                    $id = $notifications_setting_data['id'];
                                    $sales_agent_customer_submitted_notification = "";
                                    $verification_agent_customer_not_verified_notification = "";
                                }                                
                            ?>
                            <input type="hidden" name="theme_options_notification_setting_id" value="<?php echo $id; ?>" />                           
                            <div class="form-group">
                                <label class="col-md-3 control-label">Sales Agent Customer Submitted Notification:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <select name="sales_agent_customer_submitted_notification" id="sales_agent_customer_submitted_notification" class="form-control">
                                        <option value="">Select Notification Type</option>
                                        <?php                                                        
                                            foreach ($notifications_type as $value) 
                                            {
                                            ?>
                                                <option <?php if(isset($notifications_type) && $value['notifications_type_id'] == $sales_agent_customer_submitted_notification){ echo "selected"; }else{ echo ""; } ?> value="<?php echo $value['notifications_type_id'] ?>">
                                                    <?php echo $value['notifications_type_name'] ?>
                                                </option>
                                            <?php
                                            }
                                       
                                        ?>
                                    </select>
                                    <span class="help-block"> Select notification type </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Verification Agent Customer Not Verified Notification:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <select name="verification_agent_customer_not_verified_notification" id="verification_agent_customer_not_verified_notification" class="form-control">
                                        <option value="">Select Notification Type</option>
                                        <?php                                                        
                                            foreach ($notifications_type as $value) 
                                            {
                                            ?>
                                                <option <?php if(isset($notifications_type) && $value['notifications_type_id'] == $verification_agent_customer_not_verified_notification){ echo "selected"; }else{ echo ""; } ?> value="<?php echo $value['notifications_type_id'] ?>">
                                                    <?php echo $value['notifications_type_name'] ?>
                                                </option>
                                            <?php
                                            }
                                       
                                        ?>
                                    </select>
                                    <span class="help-block"> Select notification type </span>
                                </div>
                            </div>                                                                                                                                                                                                                                       
                        </div>
                                            
                     <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="actions btn-set">                                                                    
                                <button type="reset" class="btn btn-secondary-outline">
                                    <i class="fa fa-reply"></i> Reset
                                </button>                                
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> Save
                                </button>                                
                            </div>  
                        </div>
                    </div>                                                                            
                
            </div>            
        </form>
    </div>    
</div>
<!-- END EXAMPLE TABLE PORTLET-->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->        
<script type="text/javascript">
    $('document').ready(function(){       
        $('#setting').addClass('open');
        $('#setting').addClass('active');
        $('#setting').siblings('.arrow').addClass('open');
        $('<span class="selected"></span>').insertAfter($('#setting'));
        $('#setting_notifications').parents('li').addClass('active');
        $("#notifications_setting_form").validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            rules: {
                "sales_agent_customer_submitted_notification": {
                    required: true                            
                },
                "verification_agent_customer_not_verified_notification": {
                    required: true                            
                }
            },          
            invalidHandler: function(event, validator) 
            {             
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function (element)
            {                 
                $(element).closest('.form-group').removeClass('has-error');             
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element)
            { 
               error.insertAfter(element); // for other inputs, just perform default behavior              
            },
            submitHandler: function(form) {
                success.show();
                error.hide();
                form.submit();
            }
        });        
    });
</script>  