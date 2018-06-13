<style>
	.sweet-alert
	{
		top:60% !important;
	}
</style>
<?php
	 $admin = $this->session->userdata();
?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/swal/sweet-alert.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="assets/theam_assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE HEADER-->   
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="<?php echo site_url(); ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Profile</span>
            </li>
        </ul>
        <div class="page-toolbar">           
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Profile </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PROFILE SIDEBAR -->
<?php /*		<div class="profile-sidebar">
			<!-- PORTLET MAIN -->
			<div class="portlet light profile-sidebar-portlet ">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<a id='profile' title='Change Image' data-toggle="modal" href="#upload">
						<img id='profile_image' src="<?php echo $profile; ?>" class="img-responsive" alt="">
					</a>
				</div>
				
				<!-- Profile Image Upload Model -->
				<div id="upload" class="modal fade" style='top:0px;left:40%;width:60%;' tabindex="-1" data-width="760">
					<form method='post' action='Agency/profile/upload' enctype="multipart/form-data">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Upload Your Profile Image</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class='col-sm-12 col-md-6'>
									<div class="profile-userpic">
										<img src="<?php echo $profile; ?>" class="img-responsive" alt="">
									</div>
								</div>
								<div class='col-sm-12 col-md-6'>
									<div class="form-group ">
										<div class="col-md-12">
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
												<div>
													<span class="btn red btn-outline btn-file">
														<span class="fileinput-new">Upload New Image</span>
														<span class="fileinput-exists">Change Image</span>
														<input type="file" name="image">
													</span>
													<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" id='new_image' class="btn btn-outline" disabled>Upload</button>
							<button type="button" data-dismiss='modal' class="btn btn-outline">Cancel</button>
						</div>
					</form>
				</div>
				
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name"><?php echo $this->session->userdata('agency')->name ?></div>
					<div class="profile-usertitle-job">
						
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li>
							<a href="Agency">
								<i class="icon-home"></i> Overview </a>
						</li>
						<li class="active">
							<a href="javascript:;">
								<i class="icon-settings"></i> Account Settings </a>
						</li>
						<li>
							<a href="page_user_profile_1_help.html">
								<i class="icon-info"></i> Help </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
			<!-- END PORTLET MAIN -->
			<!-- PORTLET MAIN -->
			<div class="portlet light ">
				<!-- STAT -->
				<div class="row list-separated profile-stat">
					<div class="col-md-4 col-sm-4 col-xs-6">
						<div class="uppercase profile-stat-title"> 37 </div>
						<div class="uppercase profile-stat-text"> Projects </div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<div class="uppercase profile-stat-title"> 51 </div>
						<div class="uppercase profile-stat-text"> Tasks </div>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-6">
						<div class="uppercase profile-stat-title"> 61 </div>
						<div class="uppercase profile-stat-text"> Uploads </div>
					</div>
				</div>
				<!-- END STAT -->
				<div>
					<h4 class="profile-desc-title">About Marcus Doe</h4>
					<span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
					<div class="margin-top-20 profile-desc-link">
						<i class="fa fa-globe"></i>
						<a href="http://www.keenthemes.com">www.keenthemes.com</a>
					</div>
					<div class="margin-top-20 profile-desc-link">
						<i class="fa fa-twitter"></i>
						<a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
					</div>
					<div class="margin-top-20 profile-desc-link">
						<i class="fa fa-facebook"></i>
						<a href="http://www.facebook.com/keenthemes/">keenthemes</a>
					</div>
				</div>
			</div>
			<!-- END PORTLET MAIN -->
		</div> */ ?>
		<!-- END BEGIN PROFILE SIDEBAR -->
		<!-- BEGIN PROFILE CONTENT -->
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
								<div class="portlet light ">
									<div class="portlet-title tabbable-line">
										<div class="caption caption-md">
											<i class="icon-globe theme-font hide"></i>
											<span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
										</div>
									</div>
									<div class="portlet-body">
										
											<!-- PERSONAL INFO TAB -->
											 
												<?php
													if($flag)
													{
														?>
														<div class='alert alert-danger'>
															Please fill all the required field.
														</div>
														<?php
													}
													else if($this->session->flashdata())
													{
														?>
														<div class='alert alert-success'>
															<?php echo $this->session->flashdata('msg'); ?>
														</div>
														<?php
													}
												?>
												<?php $admin = $this->admin_model->getAdminInfo($this->session->userdata('admin')->user_id) ?>
												<?php $user  = $this->admin_model->getAdminEmailInfo($this->session->userdata('admin')->user_id)  ?>
												<form class="form-horizontal"   action="" method='post' id="form_sample_1">
													<div class="form-body">
														<div class="form-group">
															<label class="col-md-3 control-label">Name <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-4">
																<input type="text" value="<?php echo $admin->name; ?>" name="name" class="form-control">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Email <span class="required" aria-required="true"> * </span></label>
															<div class="col-md-4">
																<input type="text" value="<?php echo $user->email_id; ?>" name="email" class="form-control">
															</div>
														</div>														
														<div class="form-group">
															<label class="col-md-3 control-label">Address </label>
															<div class="col-md-4">
																<textarea name="address" class="form-control"><?php echo $admin->address ?></textarea>																
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Phone No </label>
															<div class="col-md-4">
																<input type="text" name="phone_number" class="form-control" value="<?php echo $admin->phone_number ?>" />
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">New Password </label>
															<div class="col-md-4">
																<input type="password" name="password" class="form-control" id="password" value="" />
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Confirm Password </label>
															<div class="col-md-4">
															<input type="password" name="confirm_password" id="confirm_password" class="form-control" value="" />
															</div>
														</div>																													
													</div>
													<div class="form-actions">
                                            			<div class="row">
                                                			<div class="col-md-offset-3 col-md-9">
                                                    		<button class="btn green" type="submit">Submit</button>
                                                    		<button class="btn grey-salsa btn-outline" type="button">Cancel</button>
                                                		</div>
                                            		</div>
                                        </div>													
												</form>
											<!-- END CHANGE PASSWORD TAB -->
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- END PROFILE CONTENT -->
	</div>
</div>
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="assets/theam_assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/theam_assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/swal/sweet-alert.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/theam_assets/pages/scripts/jquery.maskedinput.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/pages/scripts/form-wizard_agent.js" type="text/javascript"></script>
<script src="assets/theam_assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
<script src="assets/theam_assets/pages/scripts/profile.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/pages/scripts/ui-bootbox.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type='text/javascript'>
var FormValidation = function() {
    var e = function() {
            var e = $("#form_sample_1"),
                r = $(".alert-danger", e),
                i = $(".alert-success", e);
            e.validate({
                errorElement: "span",
                errorClass: "help-block help-block-error",
                focusInvalid: !1,
                ignore: "",
                messages: {
                    
                },
                rules: {
                    name: {                        
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
					password: {					
						//minlength: 5
					},
					confirm_password: {					
						//minlength: 5,
						equalTo: "#password"
					},                    
                },
                invalidHandler: function(e, t) {
                    //i.hide(), r.show(), App.scrollTo(r, -200)
                },
                highlight: function(e) {
                    $(e).closest(".form-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    $(e).closest(".form-group").removeClass("has-error")
                },
                success: function(e) {                	
                    e.closest(".form-group").removeClass("has-error")
                    jQuery('#form_sample_1').submit();
                },
                submitHandler: function(e) {
                    //i.show(), r.hide()
                }
            })
        },   

        t = function() {
            jQuery().wysihtml5 && $(".wysihtml5").size() > 0 && $(".wysihtml5").wysihtml5({
                stylesheets: ["../assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
            })
        };
    return {
        init: function() {
            t(), e()
        }
    }
}();
jQuery(document).ready(function() {
    FormValidation.init()
});
</script>
