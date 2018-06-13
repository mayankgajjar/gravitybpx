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
                <span>Email Setting</span>
            </li>
        </ul>
        <div class="page-toolbar">           
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Email Setting </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">    
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-envelope-o font-dark"></i>
            <span class="caption-subject bold uppercase">Email Setting</span>
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
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1_1" data-toggle="tab"> SMTP Configuration </a>
            </li>
            <li>
                <a href="#tab_1_2" data-toggle="tab"> Sender Email </a>
            </li>
        </ul>
		<form class="form-horizontal form-row-seperated" action="<?php echo site_url('others/theme_options/add/email_setting'); ?>" id="emailsetting_form" method="post">			
			<?php                                
                if(!empty($email_setting_data))
                {
                    $email_setting_result = unserialize($email_setting_data['theme_options_values']);
                    $id = $email_setting_data['id'];
                    $smtp_host = $email_setting_result['smtp_host'];
                    $smtp_user = $email_setting_result['smtp_user'];
                    $smtp_pass = $email_setting_result['smtp_pass'];
                    $smtp_port = $email_setting_result['smtp_port'];
                    $sender_email = $email_setting_result['sender_email']; 
                    $admin_email = $email_setting_result['admin_email'];
                }
                else
                {
                    $id = $email_setting_data['id'];
                    $smtp_host = "";
                    $smtp_user = "";
                    $smtp_pass = "";
                    $smtp_port = "";
                    $sender_email = "";
                    $admin_email = "";
                }
                ?>
            <input type="hidden" name="email_setting_id" value="<?php echo $id; ?>" />
	        <div class="tab-content">
	            <div class="tab-pane fade active in" id="tab_1_1">
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label">SMTP Host</label>
								<div class="col-md-5">
									<input class="form-control" type="text" name="smtp_host" value="<?php echo $smtp_host; ?>"/>
									<span class="help-block"> Provide smtp host </span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">SMTP User</label>
								<div class="col-md-5">
									<input class="form-control" type="text" name="smtp_user" value="<?php echo $smtp_user; ?>"/>
									<span class="help-block"> Provide smtp user </span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">SMTP Pssword</label>
								<div class="col-md-5">
									<input class="form-control" type="password" name="smtp_pass" value="<?php echo $smtp_pass; ?>"/>
									<span class="help-block"> Provide smtp password </span>
								</div>					
							</div>										      
							<div class="form-group">
								<label class="col-md-3 control-label">SMTP Port</label>
								<div class="col-md-5">
									<input class="form-control" type="text" name="smtp_port" value="<?php echo $smtp_port; ?>"/>
									<span class="help-block"> Provide smtp port </span>
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
	            </div>
	            <div class="tab-pane fade" id="tab_1_2">
	            	<div class="form-body">	
	            		<div class="form-group">
							<label class="col-md-3 control-label">Sender Email</label>
							<div class="col-md-5">
								<input class="form-control" type="text" name="sender_email" value="<?php echo $sender_email; ?>"/>
								<span class="help-block"> Provide sender email </span>
							</div>				
						</div>					
						<div class="form-group">
							<label class="col-md-3 control-label">Admin Email</label>
							<div class="col-md-5">
								<input class="form-control" type="text" name="admin_email" value="<?php echo $admin_email; ?>"/>
								<span class="help-block"> Provide admin email </span>
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
        $('#emailsetting').parents('li').addClass('active');            
    });
</script>