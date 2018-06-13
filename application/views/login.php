<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Login Page</title>
        <base href="<?php echo base_url(); ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo site_url() ?>uploads/logo/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php echo site_url() ?>uploads/logo/favicon/manifest.json">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/uniform/css/uniform.default.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/select2/css/select2-bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo site_url('assets/theam_assets/global/css/components-md.min.css'); ?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/css/plugins-md.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo site_url('assets/theam_assets/pages/css/login.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/dropzone/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/dropzone/basic.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <link rel="shortcut icon" href="favicon.ico" />
        <style>
            .show_up{
                display:block;
                visibility:visible;
            }
            .hide_it{
                display:none;
                visibility:hidden;
            }
            .invoice-table ul li {
                list-style: none;
                display: inline-block;
            }
            #errmsg
            {
                color: red;
            }
        </style>
        <script type="text/javascript">
            var error_show_agency = 0;
            var error_show_agent = 0;
        </script>
        <?php
        if ($this->session->flashdata('error_server_register_agency') != "") {
            ?>
            <script type="text/javascript">
                var error_show_agency = 1;
            </script>
            <?php
        }
        ?>
        <?php
        if ($this->session->flashdata('error_server_register_agent') != "") {
            ?>
            <script type="text/javascript">
                var error_show_agent = 1;
            </script>
            <?php
        }
        ?>
    </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="<?php echo site_url(''); ?>">
                <?php
                $path = "assets/theam_assets/layouts/layout/img/logo.png";
                $image_name = get_option('site_logo');
                if ($image_name != "") {
                    $path = "uploads/logo/$image_name";
                }
                ?>
                <img src="<?php echo site_url($path); ?>" alt="logo" class="logo-default" />
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <?php
            if ($this->session->flashdata('expire')) {
                ?>
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span><?php echo $this->session->flashdata('expire'); ?></span>
                </div>
                <?php
            }
            ?>
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="<?php echo site_url('login/userlogin/chk') ?>" method="post">
                <h3 class="form-title font-green">Sign In</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any email address and password. </span>
                </div>
                <?php
                if ($this->session->flashdata('msg')) {
                    ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span><?php echo $this->session->flashdata('msg'); ?></span>
                    </div>
                    <?php
                }
                ?>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email Id</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="email" autocomplete="off" placeholder="Email Address" name="email" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">Login</button>
                    <label class="rememberme check">
                        <input type="checkbox" name="remember" value="1" />Remember </label>
                    <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
                </div>
                <div class="create-account">
                    <p>
                        <a href="javascript:;" id="register-btn" class="uppercase">Create an account</a>
                    </p>
                </div>
            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="index.html" method="post">
                <h3 class="font-green">Forget Password ?</h3>
                <p> Enter your e-mail address below to reset your password. </p>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn btn-default">Back</button>
                    <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
                </div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->
            <?php
            if (isset($param['agency']) && $param['agency'] != "") {
                $agency_id_get = $param['agency'];
            }
            if (isset($param['agent']) && $param['agent'] != "") {
                $agent_id_get = $param['agent'];
            }
            ?>

            <form class="form-horizontal register-form">
                <?php if ($this->session->flashdata('error_server_register_agency')) : ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span><?php echo $this->session->flashdata('error_server_register_agency'); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error_server_register_agent')) : ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span><?php echo $this->session->flashdata('error_server_register_agent'); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('msg')): ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span><?php echo $this->session->flashdata('msg'); ?></span>
                    </div>
                <?php endif; ?>
                <div class="portlet light bordered">
                    <h3 class="font-green">Sign Up</h3>
                    <?php $register_type = unserialize(REGISTER_TYPE); ?>
                    <div class="select_type_of_register form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-4">Sign Up Type</label>
                            <div class="col-md-5">
                                <select name="select_register_type" class="select_register_type form-control">
                                    <option value="">Select Sign Up Type</option>
                                    <?php
                                    if (!empty($register_type)) :
                                        if (set_value('agencyname') != "") {
                                            $field_value = "agency";
                                        } else if (set_value('parent_agency') != "") {
                                            $field_value = "agent";
                                        } else {
                                            $field_value = "";
                                        }
                                        foreach ($register_type as $key => $value) :
                                            ?>
                                            <option <?php
                                            if ($field_value == $key) {
                                                echo "selected ";
                                            } else {
                                                echo "";
                                            }
                                            ?>value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div id="agency_form" class="register-form">
                <div class="portlet light bordered" id="form_wizard_1">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-red"></i>
                            <span class="caption-subject font-red bold uppercase"> Agency Registration -
                                <span class="step-title"> Step 1 of 5 </span>
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form class="form-horizontal" action="<?php echo site_url('register/manage_agency/add'); ?>" id="submit_form" method="POST" enctype='multipart/form-data'>
                            <input type="hidden" name="parent_id" value="<?php echo isset($param['agency']) ? $param['agency'] : ''; ?>" />
                            <input type="hidden" name="token" value="<?php echo isset($param['token']) ? $param['token'] : ''; ?>" />
                            <div class="form-wizard">
                                <div class="form-body">
                                    <ul class="nav nav-pills nav-justified steps">
                                        <li>
                                            <a href="#tab1" data-toggle="tab" class="step">
                                                <span class="number"> 1 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Account Setup </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab2" data-toggle="tab" class="step">
                                                <span class="number"> 2 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Profile Setup </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab3" data-toggle="tab" class="step active">
                                                <span class="number"> 3 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i>Others Information</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab4" data-toggle="tab" class="step">
                                                <span class="number"> 4 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Bank Details </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab5" data-toggle="tab" class="step">
                                                <span class="number"> 5 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Payment </span>
                                            </a>
                                        </li>
                                    </ul>

                                    <div id="bar" class="progress progress-striped" role="progressbar">
                                        <div class="progress-bar progress-bar-success"> </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="alert alert-danger display-none">
                                            <button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
                                        <div class="alert alert-success display-none">
                                            <button class="close" data-dismiss="alert"></button>
                                            Agency has been Registered successfully.
                                        </div>
                                        <div class="tab-pane active" id="tab1">
                                            <h3 class="block">Provide your account details</h3>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Agency Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="agencyname" value="<?php echo set_value('agencyname'); ?>"/>
                                                    <span class="help-block"> Provide name of an agency</span>
                                                </div>
                                            </div>
                                            <div style='display:none'>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form action="assets/theam_assets/global/plugins/dropzone/upload.php" class="dropzone dropzone-file-area" id="my-dropzone" style="width: 500px; margin-top: 50px;">
                                                            <h3 class="sbold">Drop files here or click to upload</h3>
                                                            <p> This is just a demo dropzone. Selected files are not actually uploaded. </p>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Profile Picture
                                                </label>
                                                <div class="col-md-5">
                                                    <a class="btn btn-outline dark upload_profile_image" data-toggle="modal" href="#upload"> Upload Profile Image </a>
                                                </div>
                                                <input type='hidden' id='profile' name='profile' value="<?php echo set_value('profile'); ?>">
                                                <!-- Image upload model -->
                                                <div id="upload" class="modal fade" style='top:0px;left:40%;width:60%;' tabindex="-1" data-width="760">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">Drop Your image here</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <form action="assets/theam_assets/global/plugins/dropzone/upload.php" class="dropzone dropzone-file-area" id="my-dropzone" style="width: 500px; margin-top: 50px;">
                                                                    <h3 class="sbold">Drop files here or click to upload</h3>
                                                                    <p>Upload Profile Image or Logo by clicking here or Drop image here</p>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id='select_all' class="btn btn-outline" data-dismiss='modal'>Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group parent_agency_class">
                                                <label class="control-label col-md-4">Parent Agency</label>
                                                <div class="col-md-5">
                                                    <select name="parent_agency" id="" class="form-control">
                                                        <option value="0">No Parent Agency</option>
                                                        <?php foreach ($agency as $value) : ?>
                                                            <option <?php
                                                            if (set_value('parent_agency') == $value['id']) {
                                                                echo "selected ";
                                                            } else {
                                                                echo "";
                                                            }
                                                            ?> value="<?php echo $value['id'] ?>">
                                                                    <?php echo $value['name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <span class="help-block">Select parent agency</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Email
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="email" id="emailid" value="<?php echo set_value('email'); ?>"/>
                                                    <span class="help-block"> Provide your email address </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Password
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="password" class="form-control" name="password" id="submit_form_password" value="" />
                                                    <span class="help-block"> Provide your password </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Confirm Password
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="password" class="form-control" name="rpassword" value=""/>
                                                    <span class="help-block"> Confirm your password </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4"><?php echo "Domain Name" ?><span class="required"> * </span></label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="domain" value=""/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            <h3 class="block">Provide your profile details</h3>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">First Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="fname" placeholder="" value="<?php echo set_value('fname'); ?>"/>
                                                    <span class="help-block"> Provide your first name </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Middle Name
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="mname" placeholder="" value="<?php echo set_value('mname'); ?>"/>
                                                    <span class="help-block"> Provide your middle name </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Last Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="lname" placeholder="" value="<?php echo set_value('lname'); ?>"/>
                                                    <span class="help-block"> Provide your last name </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Phone Number
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control mask_phone phone" id='service_phone' name="phone" value="<?php echo set_value('phone'); ?>" />
                                                    <span class="help-block">Provide your phone number (XXX) XXX-XXXX</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Fax Number

                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control mask_phone fax" id='fax' name="fax" value="<?php echo set_value('fax'); ?>"/>
                                                    <span class="help-block"> Provide your fax number (XXX) XXX-XXXX</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Address
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="address1" placeholder="Street Address" value="<?php echo set_value('address1'); ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="address2" placeholder="Street Address Cont.." value="<?php echo set_value('address2'); ?>"/>
                                                    <span class="help-block"> Provide your street address </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Country
                                                    <span class="required"> * </span>
                                                </label>

                                                <div class="col-md-5 profile">
                                                    <select name="country" id="" class="form-control">
                                                        <option value="">Select Country</option>
                                                        <?php foreach ($country as $value) : ?>
                                                            <option <?php
                                                            if (set_value('country') == $value['id']) {
                                                                echo "selected ";
                                                            } else {
                                                                echo "";
                                                            }
                                                            ?> value="<?php echo $value['id'] ?>">
                                                                    <?php echo $value['name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <span class="help-block"> Provide your country</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">State
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <select name="state" id="state_list" class="form-control state_list">
                                                        <option value="">Select State</option>
                                                    </select>
                                                    <span class="help-block"> Provide your state</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">City
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <select name="city" id="city_list" class="form-control city_list">
                                                        <option value="">Select City</option>
                                                    </select>
                                                    <span class="help-block"> Provide your city</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Zip Code
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="zip" value="<?php echo set_value('zip'); ?>" />
                                                    <span class="help-block"> Provide your zip code </span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane" id="tab3">
                                            <h3 class="block">Provide your customer service details and license information</h3>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Service Phone Number
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control mask_phone phone" id='phone' name="service_phone" value="<?php echo set_value('service_phone'); ?>"/>
                                                    <span class="help-block"> Provide your service phone number (XXX) XXX-XXXX</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Service Fax Number
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" id='service_fax' class="form-control mask_phone fax" name="service_fax" value="<?php echo set_value('service_fax'); ?>"/>
                                                    <span class="help-block"> Provide your service fax number (XXX) XXX-XXXX</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Service Email
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" placeholder="" class="form-control" name="service_email" value="<?php echo set_value('service_email'); ?>"/>
                                                    <span class="help-block"> Provide your service email address</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Resident License Number
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="license_number" value="<?php echo set_value('license_number'); ?>"/>
                                                    <span class="help-block">Provide your resident license number</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Resident License State
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <select class='form-control' name='resident_license_state'>
                                                        <option value=""> Select State </option>
                                                        <?php foreach ($states as $state) : ?>
                                                            <option <?php
                                                            if (set_value('resident_license_state') == $state['id']) {
                                                                echo "selected ";
                                                            }
                                                            ?> value='<?php echo $state['id']; ?>'>
                                                                    <?php echo $state['name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <span class="help-block">Provide your resident license state</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Non-Resident License State
                                                </label>
                                                <div class="col-md-5">
                                                    <a class="btn btn-outline dark" data-toggle="modal" href="#responsive"> Choose State </a>
                                                </div>
                                                <!-- Non-resident state model -->
                                                <div id="responsive" class="modal fade" style='left:40%;width:60%;' tabindex="-1" data-width="760">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Select Non-Resident License State</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="checkbox-list">
                                                                <?php foreach ($states as $state) : ?>
                                                                    <div class='col-sm-6 col-md-4 col-lg-4'>
                                                                        <label>
                                                                            <input class='states' type="checkbox" name="nonresident_license_state[]" value="<?php echo $state['id'] ?>" data-title="<?php echo $state['name'] ?>" /><?php echo $state['name'] ?>
                                                                        </label>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer col-md-12" >
                                                        <div class='col-sm-9'>
                                                            <button type="button" style='float:left' id='select_all1' class="btn btn-outline">Select All</button>
                                                            <button type="button" style='float:left' id='deselect_all1' class="btn btn-outline">Deselect All</button>
                                                        </div>
                                                        <div class='col-sm-3'>
                                                            <button type="button" data-dismiss='modal' class="btn btn-outline">Save & Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab4">
                                            <h3 class="block">Provide Bank details</h3>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Payment Option
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <?php
                                                    $payment_option = unserialize(PAYMENT_OPTION);
                                                    ?>
                                                    <select name="payment" id="payment" class="form-control">
                                                        <option value="">Select Payment Option</option>
                                                        <?php if (!empty($payment_option)) : ?>
                                                            <?php foreach ($payment_option as $key => $value) : ?>
                                                                <option <?php
                                                                if (set_value('payment') == $key) {
                                                                    echo "selected ";
                                                                }
                                                                ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                    </select>
                                                    <span class="help-block">Select payment option</span>
                                                </div>
                                            </div>
                                            <div id='bank_container' class='show_up'>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Bank Name
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" name="bank_name" value="<?php echo set_value('bank_name'); ?>"/>
                                                        <span class="help-block"> Provide your bank name</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Address
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <textarea class="form-control" rows="3" name="bank_address"><?php echo set_value('bank_address'); ?></textarea>
                                                        <span class="help-block"> Provide your bank address</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Country
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <select name="bank_country" id="" class="form-control">
                                                            <option value="">Select Country</option>
                                                            <?php foreach ($country as $value) : ?>
                                                                <option <?php
                                                                if (set_value('bank_country') == $value['id']) {
                                                                    echo "selected ";
                                                                }
                                                                ?> value="<?php echo $value['id'] ?>">
                                                                        <?php echo $value['name'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <span class="help-block"> Provide your bank country</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">State
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <select name="bank_state" id="bank_state_list" class="form-control bank_state_list">
                                                            <option value="">Select State</option>
                                                        </select>
                                                        <span class="help-block"> Provide your bank state</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">City
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <select name="bank_city" id="bank_city_list" class="form-control bank_city_list">
                                                            <option value="">Select City</option>
                                                        </select>
                                                        <span class="help-block"> Provide your bank city</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Zip Code
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" name="bank_zip" value="<?php echo set_value('bank_zip'); ?>"/>
                                                        <span class="help-block"> Provide your bank zip code </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Bank Routing (ABA) Number
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" name="routing_number" value="<?php echo set_value('routing_number'); ?>" />
                                                        <span class="help-block"> Provide your bank routing number</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Bank Account Number
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" name="bank_number" value="<?php echo set_value('bank_number'); ?>"/>
                                                        <span class="help-block"> Provide bank account number</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id='card_container' class='hide_it'>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Name on Credit Card
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" name="card_name" value="<?php echo set_value('card_name'); ?>"/>
                                                        <span class="help-block"> Provide your name on credit card</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Card Type
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <?php
                                                        $card_type = unserialize(CREDIT_CARD_TYPE);
                                                        ?>
                                                        <select class='form-control' name='card_type' value="<?php echo set_value('card_type'); ?>">
                                                            <option value="">Select Card Type</option>
                                                            <?php if (!empty($card_type)) : ?>
                                                                <?php foreach ($card_type as $key => $value) : ?>
                                                                    <option <?php
                                                                    if (set_value('card_type') == $key) {
                                                                        echo "selected ";
                                                                    }
                                                                    ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                        </select>
                                                        <span class="help-block">Select your card type</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Credit Card Number
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" name="card_number" value="<?php echo set_value('card_number'); ?>"/>
                                                        <span class="help-block"> Provide your credit card number</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">Expiration Date
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <input type="text" id="expiration_date" class="form-control cvv_expiration_date" placeholder='MM/YYYY' name="expiration_date" value="<?php echo set_value('expiration_date'); ?>"/>
                                                        <span class="help-block"> Provide your expiration date (MM/YYYY)</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4">CVV Number
                                                        <span class="required"> * </span>
                                                    </label>
                                                    <div class="col-md-5">
                                                        <input type="text" class="form-control" name="ccv_number" value="<?php echo set_value('ccv_number'); ?>" />
                                                        <span class="help-block"> Provide your CVV number</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div  id="tab5" class="tab-pane">
                                            <h3 class="block">Registration Fee And Membership Per Agent</h3>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="col-md-12">
                                                        <strong>With Registration you get 1 Agent Account and some mints</strong>
                                                        <p>
                                                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                                            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                                            It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially
                                                            unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                                                            and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Buy Agent Accounts 1 account / $99.95 PM
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" id='acounter' class="form-control" name="agent_account" class="agent_account OnlyNumbers" value="<?php echo set_value('agent_account'); ?>" /><span id="errmsg"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div id="invoice-wapper" class="invoice-wapper" style="display: none">
                                                        <div class="title">
                                                            <strong>Invoice</strong>
                                                        </div>
                                                        <div class="invoice-table">
                                                            <table class="invoice-table-custom">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Registration Fee</th>
                                                                        <th>Additional Agents/Users Account</th>
                                                                        <th>Total Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <span class="price-d"><b> $99.95 </b></span>
                                                                        </td>
                                                                        <td>
                                                                            <label>$99.95 Per Account <i class="fa fa-times"></i></label><span class="member_count"></span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="total_payble"><b> $499.75/month </b></span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                    <div id="default-wapper" class="default-wapper">
                                                        <ul>
                                                            <li>
                                                                <span class="default_payble"><span class="single_title">Registration Fee:</span>$99.95/month </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <a href="javascript:;" id="register-back-btn1" class="btn btn-outline green">
                                                <i class="fa fa-angle-left"></i> Back to login
                                            </a>
                                            <a href="javascript:;" class="btn default button-previous">
                                                <i class="fa fa-angle-left"></i> Back </a>
                                            <a href="javascript:;" class="btn btn-outline green button-next"> Continue
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                            <button id='agency-submit' type="submit" class="btn green button-submit"> Submit
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="agent_form" class="register-form">
                <div class="portlet light bordered" id="form_wizard_2">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-red"></i>
                            <span class="caption-subject font-red bold uppercase"> Agent Registration -
                                <span class="step-title"> Step 1 of 3 </span>
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form class="form-horizontal" action="<?php echo site_url('register/manage_agent/add'); ?>" id="submit_form1" method="POST">
                            <input type="hidden" name="parent_id" value="<?php echo isset($param['agency']) ? $param['agency'] : ''; ?>" />
                            <input type="hidden" name="agent_type_id" value="<?php echo isset($param['agent']) ? $param['agent'] : ''; ?>" />
                            <input type="hidden" name="token" value="<?php echo isset($param['token']) ? $param['token'] : ''; ?>" />
                            <div class="form-wizard">
                                <div class="form-body">
                                    <ul class="nav nav-pills nav-justified steps">
                                        <li>
                                            <a href="#tab6" data-toggle="tab" class="step">
                                                <span class="number"> 1 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Account Setup </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab7" data-toggle="tab" class="step">
                                                <span class="number"> 2 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i> Profile Setup </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tab8" data-toggle="tab" class="step active">
                                                <span class="number"> 3 </span>
                                                <span class="desc">
                                                    <i class="fa fa-check"></i>License Information</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div id="bar" class="progress progress-striped" role="progressbar">
                                        <div class="progress-bar progress-bar-success"> </div>
                                    </div>
                                    <div class="tab-content">
                                        <div class="alert alert-danger display-none">
                                            <button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
                                        <div class="alert alert-success display-none">
                                            <button class="close" data-dismiss="alert"></button>
                                            Agent has been Registered successfully.
                                        </div>
                                        <div class="tab-pane active" id="tab6">
                                            <h3 class="block">Provide your account details</h3>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">First Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="fname" value="<?php echo isset($agent->fname) ? $agent->fname : ''; ?>"/>
                                                    <span class="help-block"> Provide your first name</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Middle Name
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="mname" value="<?php echo isset($agent->mname) ? $agent->mname : ''; ?>"/>
                                                    <span class="help-block"> Provide your middle name</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Last Name
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="lname" value="<?php echo isset($agent->lname) ? $agent->lname : ''; ?>"/>
                                                    <span class="help-block"> Provide your last name</span>
                                                </div>
                                            </div>
                                            <div class="form-group parent_agency_class">
                                                <label class="control-label col-md-4">Parent Agency
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <select name="parent_agency" id="" class="form-control">
                                                        <option value="">Select Parent Agency</option>
                                                        <?php foreach ($agency as $value): ?>
                                                            <option <?php
                                                            if (isset($agent->agency_id) && $agent->agency_id == $value['id']) {
                                                                echo "selected ";
                                                            }
                                                            ?> value="<?php echo $value['id'] ?>">
                                                                    <?php echo $value['name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <span class="help-block">Select parent agency</span>
                                                </div>
                                            </div>
                                            <div class="form-group agent_type_class">
                                                <label class="control-label col-md-4">Agent Category
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <?php
                                                    $agent_type = unserialize(AGENT_TYPE);
                                                    ?>
                                                    <select name="agent_type" class="form-control">
                                                        <option value="">Select Agent Category</option>
                                                        <?php if (!empty($agent_type)) : ?>
                                                            <?php foreach ($agent_type as $key => $value) : ?>
                                                                <option <?php
                                                                if (isset($agent->agent_type) && $agent->agent_type == $key) {
                                                                    echo "selected ";
                                                                }
                                                                ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                    </select>
                                                    <span class="help-block">Select agent category</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Email
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="email" id="emailid1" value="<?php echo isset($agent->email_id) ? $agent->email_id : ''; ?>"/>
                                                    <span class="help-block"> Provide your email address </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Password
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="password" class="form-control" name="password" id="submit_form_password1" value=""/>
                                                    <span class="help-block"> Provide your password </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Confirm Password
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="password" class="form-control" name="rpassword" value=""/>
                                                    <span class="help-block"> Confirm your password </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab7">
                                            <h3 class="block">Provide your profile details</h3>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Phone Number
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" id='phone' class="form-control mask_phone phone" name="phone" value="<?php echo isset($agent->phone_number) ? $agent->phone_number : ''; ?>"/>
                                                    <span class="help-block"> Provide your phone number (999)999-9999</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Fax Number
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control mask_phone fax" id='fax' name="fax" value="<?php echo isset($agent->fax_number) ? $agent->fax_number : ''; ?>"/>
                                                    <span class="help-block"> Provide your fax number (999)999-9999</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Date of Birth
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input class="form-control mask_date2 form-control-inline date-picker" name="dob" type="text" value="<?php
                                                    if (isset($agent->date_of_birth) && $agent->date_of_birth != "" && $agent->date_of_birth != 0000 - 00 - 00) {
                                                        echo date('m-d-Y', strtotime($agent->date_of_birth));
                                                    }
                                                    ?>"/>
                                                    <span class="help-block"> Provide your date of birth (MM/DD/YYYY)</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Address
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="address1" placeholder="Street Address" value="<?php echo isset($agent->address_line_1) ? $agent->address_line_1 : ''; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="address2" placeholder="Street Address Cont.." value="<?php echo isset($agent->address_line_2) ? $agent->address_line_2 : ''; ?>"/>
                                                    <span class="help-block"> Provide your street address </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Country
                                                    <span class="required"> * </span>
                                                </label>

                                                <div class="col-md-5">
                                                    <select name="country" id="" class="form-control">
                                                        <option value="">Select Country</option>
                                                        <?php foreach ($country as $value) : ?>
                                                            <option <?php
                                                            if (isset($agent->country_id) && $agent->country_id == $value['id']) {
                                                                echo "selected ";
                                                            }
                                                            ?> value="<?php echo $value['id'] ?>">
                                                                    <?php echo $value['name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <span class="help-block"> Provide your country</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">State
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <select name="state" id="state_list" class="form-control state_list">
                                                        <option value="">Select State</option>
                                                    </select>
                                                    <span class="help-block"> Provide your state</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">City
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <select name="city" id="city_list" class="form-control city_list">
                                                        <option value="">Select city</option>
                                                    </select>
                                                    <span class="help-block"> Provide your city</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Zip Code
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="zip" value="<?php echo isset($agent->zip_code) ? $agent->zip_code : ''; ?>"/>
                                                    <span class="help-block"> Provide your zip code </span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane" id="tab8">
                                            <h3 class="block">Provide your license information</h3>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">National Producer Number
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="npn" value="<?php echo isset($agent->national_producer_number) ? $agent->national_producer_number : ''; ?>"/>
                                                    <span class="help-block"> Provide your NPN(National Producer Number)</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Resident License Number
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="license_number" value="<?php echo isset($agent->resident_license_number) ? $agent->resident_license_number : ''; ?>"/>
                                                    <span class="help-block">Provide your resident license number</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Resident License State
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-5">
                                                    <select class='form-control' name='resident_license_state'>
                                                        <option value="">Select State</option>
                                                        <?php foreach ($states as $state) : ?>
                                                            <option <?php
                                                            if (isset($agent->resident_license_state_ids) && $agent->resident_license_state_id == $state['id']) {
                                                                echo "selected ";
                                                            }
                                                            ?> value='<?php echo $state['id']; ?>'>
                                                                    <?php echo $state['name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <span class="help-block">Select resident license state</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Non-Resident License State
                                                </label>
                                                <div class="col-md-5">
                                                    <a class="btn btn-outline dark" data-toggle="modal" href="#responsive1"> Choose State </a>
                                                </div>
                                                <!-- Non-resident state model -->
                                                <div id="responsive1" class="modal fade" style='top:0px;left:40%;width:60%;' tabindex="-1" data-width="760">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                        <h4 class="modal-title">Select Non-Resident License State</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="checkbox-list">
                                                                <?php
                                                                $arr = array();
                                                                if (isset($agent) && $agent) {
                                                                    foreach ($agent->non_resident_state as $key => $value) {
                                                                        $arr[] = $value[state_id];
                                                                    }
                                                                }
                                                                foreach ($states as $state) :
                                                                    ?>
                                                                    <div class='col-sm-6 col-md-4 col-lg-4'>
                                                                        <label>
                                                                            <input class='states1' type="checkbox" name="nonresident_license_state[]" value="<?php echo $state['id'] ?>" data-title="<?php echo $state['name'] ?>" <?php
                                                                            if (in_array($state['id'], $arr) == true) {
                                                                                echo 'checked="checked"';
                                                                            } else {
                                                                                echo '';
                                                                            }
                                                                            ?>/><?php echo $state['name'] ?>
                                                                        </label>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer col-md-12" style='float:left'>
                                                        <div class='col-sm-9'>
                                                            <button type="button" style='float:left' id='select_all2' class="btn btn-outline">Select All</button>
                                                            <button type="button" style='float:left' id='deselect_all2' class="btn btn-outline">Deselect All</button>
                                                        </div>
                                                        <div class='col-sm-3'>
                                                            <button type="button" data-dismiss='modal' class="btn btn-outline">Save & Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <a href="javascript:;" id="register-back-btn" class="btn btn-outline green">
                                                <i class="fa fa-angle-left"></i> Back to login
                                            </a>
                                            <a href="javascript:;" class="btn default button-previous">
                                                <i class="fa fa-angle-left"></i> Back </a>
                                            <a href="javascript:;" class="btn btn-outline green button-next"> Continue
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                            <button type="submit" class="btn green button-submit"> Submit
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END REGISTRATION FORM -->
        </div>
        <div class="copyright"> <?php echo date('Y') ?> &copy; <a style="color:white;" href="javascript:;">Gravity BPX</a>. </div>
        <!--[if lt IE 9]>
<script src="assets/theam_assets/global/plugins/respond.min.js"></script>
<script src="assets/theam_assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/dropzone/dropzone.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/js.cookie.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.blockui.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/uniform/jquery.uniform.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/select2/js/select2.full.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/pages/scripts/jquery.maskedinput.js'); ?>" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo site_url('assets/theam_assets/global/scripts/app.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-wizard.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-wizard_agent_front.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/pages/scripts/components-select2.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/pages/scripts/components-date-time-pickers.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-dropzone.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.input-ip-address-control-1.0.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-input-mask.js'); ?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo site_url('assets/theam_assets/pages/scripts/login.js'); ?>" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script type="text/javascript">
                $('document').ready(function ()
                {
                    $('.select_register_type').change(function () {
                        if ($(this).val() == "agency")
                        {
                            $('#agent_form #submit_form1').trigger("reset");
                            $('#agency_form').attr("style", "display:block !important");
                            $('#select_type_of_register,#agent_form').attr("style", "display:none !important");
                        } else if ($(this).val() == "agent")
                        {
                            $('#agency_form #submit_form').trigger("reset");
                            $('#agent_form').attr("style", "display:block !important");
                            $('#select_type_of_register,#agency_form').attr("style", "display:none !important");
                        } else
                        {
                            $('#agent_form #submit_form1,#agency_form #submit_form').trigger("reset");
                            $('#select_type_of_register').attr("style", "display:block !important");
                            $('#agency_form,#agent_form').attr("style", "display:none !important");
                        }
                    });
                    $('#register-back-btn1').click(function () {
                        $('.login-form').show();
                        $('.register-form').hide();
                    });
                    $('.content').removeClass('content1');
                    $('.create-account #register-btn').click(function () {
                        $('.login .content').addClass('content1');
                    });
                    $('#register-back-btn,#register-back-btn1').click(function () {
                        $('.select_register_type').val('');
                        $('.login .content').removeClass('content1');
                    });
                    $('[name="country"],[name="bank_country"]').change(function ()
                    {
                        var cid = $(this).val();
                        var country_nm = $(this).attr('name');
                        var url_link = '<?php echo site_url("others/manage_state/getByCountryId") ?>' + '/' + cid;
                        $.ajax({
                            url: url_link,
                            method: 'get',
                            async: false,
                            success: function (str)
                            {
                                if (country_nm == "country")
                                {
                                    $('.state_list').html(str);
                                    $('.city_list').html('<option value="">Select City</option>');
                                }
                                if (country_nm == "bank_country")
                                {
                                    $('.bank_state_list').html(str);
                                    $('.bank_city_list').html('<option value="">Select City</option>');
                                }
                            }
                        });
                    });

                    $('[name="state"],[name="bank_state"]').change(function ()
                    {
                        var cid = $(this).val();
                        var country_nm = $(this).attr('name');
                        var url_link = '<?php echo site_url("others/manage_city/getByStateId") ?>' + '/' + cid;
                        $.ajax({
                            url: url_link,
                            method: 'get',
                            async: false,
                            success: function (str)
                            {
                                if (country_nm == "state")
                                {
                                    $('.city_list').html(str);
                                }
                                if (country_nm == "bank_state")
                                {
                                    $('.bank_city_list').html(str);
                                }
                            }
                        });
                    });

                    $('#select_all2').click(function ()
                    {
                        $('.states1').closest('span').addClass('checked');
                        $('.states1').prop('checked', true);
                        $.uniform.update();
                    });

                    $('#deselect_all2').click(function () {
                        $('.states1').closest('span').removeClass('checked');
                        ;
                        $('.states1').prop('checked', false);
                    });
                    $('#select_all1').click(function ()
                    {
                        $('.states').closest('span').addClass('checked');
                        $('.states').prop('checked', true);
                        $.uniform.update();
                    });

                    $('#deselect_all1').click(function () {
                        $('.states').closest('span').removeClass('checked');
                        ;
                        $('.states').prop('checked', false);
                    });
                    $('#card_container,#bank_container').addClass('hide_it');
                    $('#payment').change(function ()
                    {
                        if ($(this).val() == 1)
                        {
                            $('#card_container input[type=text],#card_container textarea,#card_container select').val('');
                            $('#bank_container').removeClass('hide_it');
                            $('#bank_container').addClass('show_up');
                            $('#card_container').addClass('hide_it');
                        } else
                        {
                            $('#bank_container input[type=text],#bank_container textarea,#bank_container select').val('');
                            $('#card_container').removeClass('hide_it');
                            $('#card_container').addClass('show_up');
                            $('#bank_container').addClass('hide_it');
                        }
                    });

                    $('[name="agent_type"]').change(function () {
                        if ($(this).val() == '1')
                        {
                            $('[href="#tab3"]').parent().removeClass('disabled');
                            $('.progress-bar').css('width', '33.3333%');
                        } else
                        {
                            $('[href="#tab3"]').parent().addClass('disabled');
                            $('.progress-bar').css('width', '50%');
                        }
                    });

                    $("#emailid,#emailid1").change(function (event)
                    {
                        var email_id = $(this).val();
                        var url_link1 = "<?php echo site_url('others/check_email') ?>";
                        $.ajax({
                            type: 'post',
                            url: url_link1,
                            data: {
                                email_id: email_id
                            },
                            success: function (response)
                            {
                                if (response == "yes")
                                {
                                    $(".email-error").remove();
                                    $("#emailid,#emailid1").after('<span class="email-error" id="email-error" style="color:#f3565d !important" class="help-block">Email id already exists.</span>');
                                    $(".button-next").css("pointer-events", "none");
                                } else
                                {
                                    $(".email-error").remove();
                                    $(".button-next").css("pointer-events", "unset");
                                }
                            }
                        });
                    });

                    if (error_show_agency == 1)
                    {
                        $('.create-account #register-btn').trigger('click');
                        $('.select_register_type,#payment,#agency_form [name="country"] :selected,#agency_form [name="bank_country"] :selected').trigger('change');
                        var agency_profile_state = "<?php echo set_value('state') ?>";
                        $("#agency_form #state_list option").each(function (index)
                        {
                            if ($(this).val() == agency_profile_state)
                            {
                                $(this).attr('selected', 'true');
                                $(this).trigger('change');
                            }
                        });
                        var agency_profile_city = "<?php echo set_value('city') ?>";
                        $("#agency_form #city_list option").each(function (index)
                        {
                            if ($(this).val() == agency_profile_city)
                            {
                                $(this).attr('selected', 'true');
                                $(this).trigger('change');
                            }
                        });
                        var agency_profile_bank_state = "<?php echo set_value('bank_state') ?>";
                        $("#agency_form #bank_state_list option").each(function (index)
                        {
                            if ($(this).val() == agency_profile_bank_state)
                            {
                                $(this).attr('selected', 'true');
                                $(this).trigger('change');
                            }
                        });
                        var agency_profile_bank_city = "<?php echo set_value('bank_city') ?>";
                        $("#agency_form #bank_city_list option").each(function (index)
                        {
                            if ($(this).val() == agency_profile_bank_city)
                            {
                                $(this).attr('selected', 'true');
                                $(this).trigger('change');
                            }
                        });
                        var arrayFromPHP = <?php echo json_encode(set_value("nonresident_license_state")) ?>;
                        $("#agency_form .checkbox-list .states").each(function (index)
                        {
                            if ($.inArray($(this).val(), arrayFromPHP) != -1)
                            {
                                $(this).attr('checked', 'true');
                                $(this).trigger('click');
                            }
                        });
                    }
                    if (error_show_agent == 1)
                    {
                        $('.create-account #register-btn').trigger('click');
                        $('.select_register_type,#agent_form [name="country"] :selected,#agent_form [name="bank_country"] :selected').trigger('change');
                        var agent_profile_state = "<?php echo set_value('state') ?>";
                        $("#agent_form #state_list option").each(function (index)
                        {
                            if ($(this).val() == agent_profile_state)
                            {
                                $(this).attr('selected', 'true');
                                $(this).trigger('change');
                            }
                        });
                        var agent_profile_city = "<?php echo set_value('city') ?>";
                        $("#agent_form #city_list option").each(function (index)
                        {
                            if ($(this).val() == agent_profile_city)
                            {
                                $(this).attr('selected', 'true');
                                $(this).trigger('change');
                            }
                        });
                        var arrayFromPHP = <?php echo json_encode(set_value("nonresident_license_state")) ?>;
                        $("#agent_form .checkbox-list .states").each(function (index)
                        {
                            if ($.inArray($(this).val(), arrayFromPHP) != -1)
                            {
                                $(this).attr('checked', 'true');
                                $(this).trigger('click');
                            }
                        });
                    }
                    var error = "<?php echo $this->session->flashdata('expire'); ?>";
                    if (error == "")
                    {
                        var agency_id_get = "<?php echo isset($agency_id_get) ? $agency_id_get : '' ?>";
                        var agent_id_get = "<?php echo isset($agent_id_get) ? $agent_id_get : '' ?>";
                        if (agency_id_get != "" && agent_id_get != "")
                        {
                            $('.create-account #register-btn').trigger('click');
                            $('.select_register_type').val('agent');
                            $('.select_register_type').trigger('change');
                            $('.select_type_of_register').hide();
                            $('[name="parent_agency"] option').each(function (index)
                            {
                                if ($(this).val() == agency_id_get)
                                {
                                    $(this).attr('selected', 'true');
                                }
                            });
                            $('[name="agent_type"] option').each(function (index)
                            {
                                if ($(this).val() == agent_id_get)
                                {
                                    $(this).attr('selected', 'true');
                                }
                            });
                            $('.parent_agency_class').hide();
                            $('.agent_type_class').hide();
                        } else if (agency_id_get != "")
                        {
                            $('.create-account #register-btn').trigger('click');
                            $('.select_register_type').val('agency');
                            $('.select_register_type').trigger('change');
                            $('.select_type_of_register').hide();
                            $('[name="parent_agency"] option').each(function (index)
                            {
                                if ($(this).val() == agency_id_get)
                                {
                                    $(this).attr('selected', 'true');
                                }
                            });
                            $('.parent_agency_class').hide();
                        }
                        $(".create-account #register-btn").removeAttr("style");
                    } else
                    {
                        $(".create-account #register-btn").attr("style", "pointer-events:none");
                    }
                    var response;
                    jQuery.validator.addMethod(
                            "uniquedomainName",
                            function (value, element) {
                                var agency = '';
                                jQuery.ajax({
                                    url: '<?php echo site_url("others/checkdomain") ?>',
                                    method: 'post',
                                    async: false,
                                    dataType: 'json',
                                    data: {agency_id: agency, domain: value},
                                    success: function (result) {
                                        var flag = Boolean(result.success);
                                        response = (flag == true) ? true : false;
                                    }
                                });
                                return response;
                            },
                            "Domain name is Already Taken"
                            );
                    // Membership calcution
                    $('#acounter').on("keydown keyup", function (e) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                        var count = '';
                        var price = 0;
                        var payable = 99.95;
                        count = $(this).val();
                        price = count * 99.95;
                        payable = payable + price;
                        payable = payable.toFixed(2);
                        if (count !== '') {
                            $('#default-wapper').hide();
                            $("#invoice-wapper").show();
                            $('.member_count').html(count);
                            $('.total_payble').html(payable);
                            $('.pop-up-payable').html(payable);
//                            console.log(price);
                        } else {
                            $('#invoice-wapper').hide();
                            $('#default-wapper').show();
                        }
                    });

                    $('#card_cvc').on("keydown keyup", function (e) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });
                    $("#card_number").mask("9999-9999-9999-9999");
                });

                $("#agency-submit").click(function (event) {
                    $('#panel-modal').modal('show');
                    return false;
                });
                $("#agency-submit").click(function (event) {
                    $('#panel-modal').modal('show');
                    return false;
                });
        </script>
        <div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Stripe payment</h4>
                    </div>
                    <div class="modal-body"> Modal body goes here </div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                        <button type="button" class="btn green">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!--Payment Pop-up-->
        <div id="panel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content p-0 b-0">
                    <div class="panel panel-color panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Make A Payment For Registering Agency </h3>
                        </div>
                        <div class="panel-body">
                            <div class="card-box">
                                <div class="row">
                                    <form method="post" id="payment_info" novalidate="" class="payment_info">
                                        <div class="">
                                            <div class="tab-content">
                                                <div id="home" class="tab-pane fade in active">
                                                    <div class="credit-card-details">
                                                        <div class="m-b-20">
                                                            <h5>Enter Card Details And Make Payment Of <span class="pop-up-payable">$99.95</span> As Registration Fee</h5>
                                                        </div>
                                                        <div class="form-group col-md-8 pad-zero">
                                                            <label>CARD NUMBER</label>
                                                            <div class="detail-box card-valid">
                                                                <input type="text" placeholder="1234-1234-1234-1234" autocomplete="off" data-parsley-type='number' data-parsley-maxlength="16" class="form-control required" name="card_number" id="card_number" value="">
                                                                <p><i class="fa fa-credit-card" aria-hidden="true"></i></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 pad-zero">
                                                            <label>CARD CVC NUMBER</label>
                                                            <div class="detail-box card-valid">
                                                                <input id="card_cvc" type="text" placeholder="1234" autocomplete="off" class="form-control required" data-parsley-type='number' name="card_cvc" maxlength="4" minlength="3">
                                                                <p><i class="fa fa-credit-card" aria-hidden="true"></i></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-6 pad-zero">
                                                            <label>EXPIRATION MONTH</label>
                                                            <div class="detail-box month-valid">
                                                                <select class="form-control required" name="exp_month">
                                                                    <option value="">Select Expiration Month</option>
                                                                    <option value="01">01</option>
                                                                    <option value="02">02</option>
                                                                    <option value="03">03</option>
                                                                    <option value="04">04</option>
                                                                    <option value="05">05</option>
                                                                    <option value="06">06</option>
                                                                    <option value="07">07</option>
                                                                    <option value="08">08</option>
                                                                    <option value="09">09</option>
                                                                    <option value="10">10</option>
                                                                    <option value="11">11</option>
                                                                    <option value="12">12</option>
                                                                </select>
                                                                <p><i class="fa fa-clock-o" aria-hidden="true"></i></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-6 pad-zero">
                                                            <label>EXPIRATION YEAR</label>
                                                            <div class="detail-box year-valid">
                                                                <select class="form-control required" name="exp_year">
                                                                    <option value="">Select Expiration Year</option>
                                                                    <option value="2017">2017</option>
                                                                    <option value="2018">2018</option>
                                                                    <option value="2019">2019</option>
                                                                    <option value="2020">2020</option>
                                                                    <option value="2021">2021</option>
                                                                    <option value="2022">2022</option>
                                                                    <option value="2023">2023</option>
                                                                    <option value="2024">2024</option>
                                                                </select>
                                                                <p><i class="fa fa-clock-o" aria-hidden="true"></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="proceed-button">
                                                <button type="submit" name="stripe" id="payment" value="check_my">PROCEED TO SECURE PAYMENT<span><i class="fa fa-lock" aria-hidden="true"></i></span></button>
                                            </div>
                                            <div class="payment-content">
                                                <div class="test-mode"><a href="#">Test Mode</a></div>
                                                <ul class="payment-method">
                                                    <li><a href=""><img src="<?php echo base_url(); ?>assets/images/payment/payment-01.jpg" alt=""></a></li>
                                                    <li><a href=""><img src="<?php echo base_url(); ?>assets/images/payment/payment-02.jpg" alt=""></a></li>
                                                    <li><a href=""><img src="<?php echo base_url(); ?>assets/images/payment/payment-03.jpg" alt=""></a></li>
                                                    <li><a href=""><img src="<?php echo base_url(); ?>assets/images/payment/payment-04.jpg" alt=""></a></li>
                                                </ul>
                                            </div>
                                            <p class="powered-by">Powered By <i class="fa fa-cc-stripe"></i></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <style>
            /*Payment From || Stripe */
            .payment-wrapper{padding-top: 80px !important;}
            .form-group.col-md-8.pad-zero {
                padding-left: 0;
            }
            .parsley-required {
                position: absolute;
                bottom: -22px;
            }
            .payment_info{padding: 0px 100px;}
            .payment_info ul {
                padding-left: 0px;
                list-style: none;
                text-align: left;
            }
            .payment_info ul li {
                display: inline-block;
                width: 31%;
                margin-right: 3%;
                float: none;
            }
            .payment_info ul li:last-child {
                margin-right: 0px;
            }
            .payment_info ul.nav li.active a {
                background: #50d667 !important;
                border: 1px solid #4ca764;
            }
            .payment_info ul.nav li a {
                background: transparent !important;
                text-align: center;
                padding: 15px;
                color: #545454;
                font-size: 18px;
                font-weight: bold;
                border: 1px solid #d9d9d9;
            }
            .payment_info ul.nav li a p {
                position: absolute;
                top: 30px;
                left: 30px;
            }
            .payment_info ul.nav li a p input {
                height: 25px;
                width: 25px;
            }
            .payment_info input {
                background-color: #36404a;
                border: 2px solid rgba(238, 238, 238, 0.1);
                font-size: 18px;
                padding-left: 45px;
            }
            .payment_info ul.nav li a span {
                display: block;
                line-height: normal;
            }
            .payment_info h3 {
                color: rgb(45,196,185);
                font-weight: 400;
                font-size: 18px;
            }
            .payment_info h5 {
                color: rgb(45,196,185);
                font-weight: 400;
                font-size: 16px;
            }
            .payment_info label {
                color: #98a6ad;
                font-weight: 400;
                font-size: 13px;
                font-weight: bold;
            }
            .payment_info .detail-box {
                position: relative;
            }
            .payment_info input {
                background-color: #36404a;
                border: 2px solid rgba(238, 238, 238, 0.1);
                font-size: 12px;
                padding-left: 45px;
            }
            .modal-dialog .parsley-errors-list {
                margin-top: 8px;
            }
            .payment_info .detail-box p {
                position: absolute;
                top: 0;
                height: auto;
                width: 40px;
                text-align: center;
                line-height: 36px;
                background: #33373b none repeat scroll 0 0;
                border: 0px solid #2dc4b9;
                margin: 0;
            }
            .payment_info .detail-box p i {
                color: #fff;
                font-size: 16px;
            }
            .payment_info ul {
                padding-left: 0px;
                list-style: none;
                text-align: left;
            }
            .payment_info ul li {
                display: inline-block;
                width: 100%;
                margin-right: 1%;
                float: none;
            }
            .payment_info ul li select{padding-left: 40px;}
            .proceed-button {
                text-align: left;
                margin-top: 30px;
                margin-left: 10px;
            }
            .proceed-button button {
                background: #5db75d;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-bottom: 2px solid #3e8d3e;
            }
            .payment-method {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            .payment-method li {
                float: left;
                padding: 0 20px 20px 0;
            }
            .payment-method {
                float: right !important;
                margin: 0;
                width: 30%;
            }
            .payment-method li {
                width: auto !important;
                margin-right: 0 !important;
                padding:0;
            }
            .payment-content{margin: 30px 0px 0 10px;overflow: hidden;}
            .test-mode{display: inline-block;
                       float: left;
                       width: 70%;
            }
            .test-mode a{background: #fff000;
                         color: #484848;
                         padding: 10px 20px;
                         font-weight: bold;
                         text-decoration: none;
                         line-height: 35px;
            }
            .powered-by{
                font-weight: 400;
                text-align: center;
                margin: 30px 0px;
                font-size: 13px;
                clear: both;
                background: #36404a;
                padding: 10px;
                color: #fff;
                margin-left: 10px;
                margin-top: 20px !important;
            }
            .powered-by i{font-size: 24px;
                          vertical-align: middle;}
            #payment_info .detail-box.card-valid {
                margin: 5px 0 30px;
            }
            .month-valid select,.year-valid select {
                color: #fff;
                font-size: 13px;
                padding-left: 40px;
            }
            .credit-card-details{overflow: hidden;padding-bottom: 10px;
            }
            .pre-loader-custom{
                background: rgba(255, 255, 255, 0.2) none repeat scroll 0 0;
                bottom: 0;
                display: block;
                left: 0;
                position: fixed !important;
                right: 0;
                top: 0;
                width: 100%;
                z-index: 9999;
            }
            #panel-modal{
                left: 50%;
                top:50% !important;
                margin-left: 0;
                transform: translate(-50%,-50%);
                width: 850px;
                padding-right: 0 !important;
            }
            #panel-modal .modal-dialog {
                width: 100%;
                margin: 0;
            }
            #panel-modal .detail-box.card-valid input,
            #panel-modal .detail-box select{
                height: 36px;
                padding-left: 45px;
                border: 1px solid #c2cad8;
                background: transparent;
                box-shadow: none !important;
                color: #b29999;
            }
            #panel-modal .detail-box.card-valid p{
                margin: 0;
                background: #33373b none repeat scroll 0 0;
            }
            #panel-modal .panel {
                margin-bottom: 0;
            }
            #panel-modal .powered-by{
                background: transparent;
                color: #33373b;
            }
            #panel-modal .pad-zero {
                padding: 0;
                padding-right: 15px;
            }
            #panel-modal .proceed-button{
                text-align: center;
            }
            #panel-modal .proceed-button,
            #panel-modal .payment-content{
                margin-left: 0;
            }
            #panel-modal .payment-content .test-mode,
            #panel-modal .payment-content .payment-method{
                width: 50%;
            }
            #tab5 h3{
                padding-left: 15px;
                font-weight: bold !important;
                text-align: center;
                font-size: 20px;
            }
            #tab5 p{
                font-size: 13px;
                color: #888;
                padding-top: 5px;
            }
            #tab5 .form-horizontal .control-label{
                padding-left: 32px;
                text-align: left;
            }
            #tab5 .invoice-wapper{
                padding-left: 20px;
            }
            #tab5 .invoice-wapper .title strong {
                font-weight: 500;
                text-transform: uppercase;
                font-size: 24px;
                text-align: left;
                margin-bottom: 10px;
            }
            .invoice-table table.invoice-table-custom {
                width: 100%;
            }
            .invoice-table table.invoice-table-custom th {
                color: #e7505a;
                text-align: center;
                font-size: 15px;
                font-weight: 600;
                border-bottom: 1px solid #e1e5ec;
                padding-bottom: 10px;
            }
            .invoice-table table.invoice-table-custom td {
                text-align: center;
                padding: 10px;
                color: #6b6b6b;
                font-size: 14px;
            }
            span.single_title {
                color: #e7505a;
                text-align: center;
                font-size: 15px;
                font-weight: 600;
                padding-bottom: 10px;
                padding-right: 30px;
                vertical-align: middle;
            }
            span.member_count {
                padding-left: 5px;
            }
        </style>
    </body>
</html>