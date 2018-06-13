<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css" /> -->
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
                <span>Stripe Setting</span>
            </li>
        </ul>
        <div class="page-toolbar">           
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Stripe Setting </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">    
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-cc-stripe font-dark"></i>
            <span class="caption-subject bold uppercase">Stripe Setting</span>
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
        
		<form class="form-horizontal form-row-seperated" action="<?php echo site_url('others/theme_options/add/stripe_setting'); ?>" id="stripesetting_form" method="post">			
			<?php                                
                if(!empty($stripe_setting_data))
                {
                    $stripe_setting_result = unserialize($stripe_setting_data['theme_options_values']);
                    $id = $stripe_setting_data['id'];
                    $stripe_mode = $stripe_setting_result['stripe_mode'];
                    $stripe_key_test_public = $stripe_setting_result['stripe_key_test_public'];
                    $stripe_key_test_secret = $stripe_setting_result['stripe_key_test_secret'];
                    $stripe_key_live_public = $stripe_setting_result['stripe_key_live_public'];
                    $stripe_key_live_secret = $stripe_setting_result['stripe_key_live_secret']; 
                }
                else
                {
                    $id = $stripe_setting_data['id'];
                    $stripe_mode = "";
                    $stripe_key_test_public = "";
                    $stripe_key_test_secret = "";
                    $stripe_key_live_public = "";
                    $stripe_key_live_secret = ""; 
                }
                ?>
            <input type="hidden" name="stripe_setting_id" value="<?php echo $id; ?>" />
            <div class="form-body">
				<div class="form-group">
					<label class="col-md-3 control-label">Stripe Mode<span class="required">*</span></label>
					<div class="col-md-5">
						<select name="stripe_mode" class="form-control" id="stripe_mode">
                            <option value="">Please Select Stripe Mode</option>
                            <option value="test">Test</option>
                            <option value="live">Live</option>
                        </select>    
                        <span class="help-block"> Please select stripe mode </span>
					</div>
                    <script>
                        $("#stripe_mode").val("<?=$stripe_mode?>");
                    </script>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Stripe Test Public Key<span class="required">*</span></label>
					<div class="col-md-5">
						<input class="form-control" type="text" name="stripe_key_test_public" value="<?php echo $stripe_key_test_public; ?>"/>
						<span class="help-block"> Provide stripe test public key </span>
					</div>
				</div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Stripe Test Secret Key<span class="required">*</span></label>
                    <div class="col-md-5">
                        <input class="form-control" type="text" name="stripe_key_test_secret" value="<?php echo $stripe_key_test_secret; ?>"/>
                        <span class="help-block"> Provide stripe test secret key </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Stripe Live Public Key<span class="required">*</span></label>
                    <div class="col-md-5">
                        <input class="form-control" type="text" name="stripe_key_live_public" value="<?php echo $stripe_key_live_public; ?>"/>
                        <span class="help-block"> Provide stripe live public key </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Stripe Live Secret Key<span class="required">*</span></label>
                    <div class="col-md-5">
                        <input class="form-control" type="text" name="stripe_key_live_secret" value="<?php echo $stripe_key_live_secret; ?>"/>
                        <span class="help-block"> Provide stripe live secret key </span>
                    </div>
                </div>
				
			</div>
			<div class="form-actions">
				<div class="row">
                    <div class="col-md-offset-3 col-md-9">
                    	<button type="reset" class="btn btn-secondary-outline">
                            <i class="fa fa-reply"></i> Reset
                        </button>
                        <button class="btn green" type="submit">Submit</button>
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
        $('#stripesetting').parents('li').addClass('active'); 

         $("#stripesetting_form").validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            rules: {
                "stripe_mode": {
                    required: true                            
                },
                "stripe_key_test_public": {
                    required: true                            
                },
                "stripe_key_test_secret": {
                    required: true                            
                },
                "stripe_key_live_public": {
                    required: true                            
                },
                "stripe_key_live_secret": {
                    required: true                            
                },
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