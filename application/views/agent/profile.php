<style>
    .sweet-alert
    {
        top:60% !important;
    }
</style>
<?php
$profile = $this->session->userdata('agent')->profile_image;
if (empty($profile) || is_null($profile)) {
    $profile = 'uploads/agents/no-photo-available.jpg';
} else {
    $profile = 'uploads/agents/' . $profile;
}
$r = rand(12501, 48525);
$profile .= "?" . $r;
if ($flag) {
    $agent->fname = set_value('fname');
    $agent->mname = set_value('mname');
    $agent->lname = set_value('lname');
    $agent->fax_number = set_value('fax');
    $agent->phone_number = set_value('phone');
    $agent->date_of_birth = set_value('dob');
    $agent->address_line_1 = set_value('address1');
    $agent->address_line_2 = set_value('address2');
    $agent->zip_code = set_value('zip');
}
?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/select2/css/select2-bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo site_url('assets/theam_assets/pages/css/profile.min.css'); ?>" rel="stylesheet" type="text/css" />
<div class="breadcrumbs">
    <h1 class="page-title"> <?php echo 'Profile'; ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo 'Profile'; ?>
        </li>
    </ol>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
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
                    <form method='post' action='Agent/profile/upload' enctype="multipart/form-data">
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
                    <div class="profile-usertitle-name"><?php echo $this->session->userdata('agent')->fname . ' ' . $this->session->userdata('agent')->lname ?></div>
                    <div class="profile-usertitle-job">
                        <?php
                        switch ($this->session->userdata('agent')->agent_type) {
                            case 1: {
                                    echo 'Sales Agent';
                                    break;
                                }
                            case 2: {
                                    echo 'Verification Agent';
                                    break;
                                }
                            case 3: {
                                    echo 'Processing Agent';
                                    break;
                                }
                        }
                        ?>
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li>
                            <a href="Agent">
                                <i class="icon-home"></i> Overview </a>
                        </li>
                        <li class="active">
                            <a href="javascript:;">
                                <i class="icon-settings"></i> Account Settings </a>
                        </li>
                    </ul>
                </div>
                <!-- END MENU -->
            </div>
            <!-- END PORTLET MAIN -->
            <!-- PORTLET MAIN -->
            <div class="portlet light ">
                <!-- STAT -->
                <!--div class="row list-separated profile-stat">
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
                </div-->
                <!-- END STAT -->
                <!--div>
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
                </div-->
            </div>
            <!-- END PORTLET MAIN -->
        </div>
        <!-- END BEGIN PROFILE SIDEBAR -->
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
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
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                            </li>
                                            <?php
                                            if ($agent->agent_type == 1) {
                                                ?>
                                                <li>
                                                    <a href="#tab_1_2" data-toggle="tab">License Information</a>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                            <li>
                                                <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
                                            <div class="tab-pane active" id="tab_1_1">
                                                <?php
                                                if ($flag) {
                                                    ?>
                                                    <div class='alert alert-danger'>
                                                        Please fill all the required field.
                                                    </div>
                                                    <?php
                                                } else if ($this->session->flashdata()) {
                                                    ?>
                                                    <div class='alert alert-success'>
                                                        <?php echo $this->session->flashdata('msg'); ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <form role="form" action="Agent/profile/personal" method='post'>
                                                    <div class='col-sm-12 col-md-6'>
                                                        <div class="form-group">
                                                            <label class="control-label">First Name</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name='fname' placeholder="Enter Your First Name" class="form-control" value='<?php echo $agent->fname ?>' required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Middle Name</label>
                                                            <input type="text" name='mname' placeholder="Enter Your Middle Name" class="form-control" value='<?php echo $agent->mname ?>'/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Last Name</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name='lname' placeholder="Enter Your Last Name" value='<?php echo $agent->lname ?>' class="form-control" required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Upline Agency</label>
                                                            <input type="text" readonly class="form-control" value='<?php echo $agent->parent_name ?>'/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Email Address</label>
                                                            <input type="text" value='<?php echo $agent->email_id ?>' class="form-control" readonly/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Address</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" class="form-control" name="address1" placeholder="Street Address" value='<?php echo $agent->address_line_1 ?>' required/>
                                                            <input type="text" class="form-control" name="address2" placeholder="Street Address Cont.." value='<?php echo $agent->address_line_2 ?>' style='margin-top:5px;'/>
                                                        </div>
                                                    </div>
                                                    <div class='col-sm-12 col-md-6'>
                                                        <div class="form-group">
                                                            <label class="control-label">Phone Number</label>
                                                            <span class="required"> * </span>
                                                            <input id='phone' name='phone' type="text" value='<?php echo $agent->phone_number ?>' class="form-control" placeholder='Enter Phone Number' required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Plivo Number</label>
                                                            <span class="required"> * </span>
                                                            <input id='plivo_phone' name='plivo_phone' type="text" value='<?php echo $agent->plivo_phone ?>' class="form-control" placeholder='Enter Plivo Number' required disabled/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Fax Number</label>
                                                            <input type="text" name='fax' id='fax' value='<?php echo $agent->fax_number ?>' class="form-control" placeholder='Enter Fax number'/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Date of Birth</label>
                                                            <span class="required"> * </span>
                                                            <input class="form-control form-control-inline input-medium date-picker" name='dob' size="16" style='width:100% !important' type="text" value='<?php echo  date('m/d/Y', strtotime($agent->date_of_birth)); ?>' required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Country</label>
                                                            <select name="country" id="" class="form-control">
                                                                <option value="0">Select Country</option>
                                                                <?php
                                                                foreach ($country as $value) {
                                                                    $selected = '';
                                                                    if ($value['id'] == $agent->country_id) {
                                                                        $selected = 'selected';
                                                                    }
                                                                    ?>
                                                                    <option value="<?php echo $value['id'] ?>" <?php echo $selected ?>>
                                                                        <?php echo $value['name'] ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">State</label>
                                                            <select name="state" id="state_list" class="form-control">
                                                                <option value="0">Select State</option>
                                                                <?php
                                                                foreach ($state as $value) {
                                                                    $selected = '';
                                                                    if ($value['id'] == $agent->state_id) {
                                                                        $selected = 'selected';
                                                                    }
                                                                    ?>
                                                                    <option value="<?php echo $value['id'] ?>" <?php echo $selected ?>>
                                                                        <?php echo $value['name'] ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">City</label>
                                                            <span class="required"> * </span>
                                                            <select name="city" id="city_list" class="form-control" required>
                                                                <?php
                                                                foreach ($city as $value) {
                                                                    $selected = '';
                                                                    if ($value['id'] == $agent->city_id) {
                                                                        $selected = 'selected';
                                                                    }
                                                                    ?>
                                                                    <option value="<?php echo $value['id'] ?>" <?php echo $selected ?>>
                                                                        <?php echo $value['name'] ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Zip Code</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name='zip' placeholder="Enter Zip code" class="form-control" value='<?php echo $agent->zip_code ?>' required/>
                                                        </div>
                                                    </div>
                                                    <div class="margiv-top-10">
                                                        <button type='submit' class="btn green"> Save Changes </button>
                                                        <a href="javascript:;" class="btn default"> Cancel </a>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END PERSONAL INFO TAB -->
                                            <!-- CHANGE AVATAR TAB -->
                                            <?php
                                            if ($agent->agent_type == 1) {
                                                ?>
                                                <div class="tab-pane" id="tab_1_2">
                                                    <form role="form" action="Agent/profile/license" method='post'>
                                                        <div class="form-group">
                                                            <label class="control-label">National Producer Number</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name='npn' placeholder="Enter National Producer Number" class="form-control" value='<?php echo $agent->national_producer_number ?>' required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Resident License Number</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name='license_number' placeholder="Enter Resident License Number" class="form-control" value='<?php echo $agent->resident_license_number ?>' required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Resident License State</label>
                                                            <span class="required"> * </span>
                                                            <select name='resident_state' class='form-control'>
                                                                <?php
                                                                foreach ($allState as $value) {
                                                                    $selected = '';
                                                                    if ($value['id'] == $agent->resident_license_state_id) {
                                                                        $selected = 'selected';
                                                                    }
                                                                    ?>
                                                                    <option value='<?php echo $value['id'] ?>' <?php echo $selected; ?>>
                                                                        <?php echo $value['name'] ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label class="control-label">Non-Resident License State</label>
                                                            <a class="btn btn-outline dark" data-toggle="modal" href="#responsive"> Choose State </a>
                                                            <!-- Non-resident state model -->
                                                            <div id="responsive" class="modal fade" style='top:0px;left:30%;width:70%;' tabindex="-1" data-width="760">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                                    <h4 class="modal-title">Select Non-Resident License State</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="checkbox-list">
                                                                            <?php
                                                                            foreach ($allState as $state) {
                                                                                $checked = '';
                                                                                if (in_array($state['id'], $agent->non_resident_state)) {
                                                                                    $checked = 'checked';
                                                                                }
                                                                                ?>
                                                                                <div class='col-sm-6 col-md-4 col-lg-3'>
                                                                                    <label>
                                                                                        <input class='states' type="checkbox" name="nonresident_license_state[]" value="<?php echo $state['id'] ?>" data-title="<?php echo $state['name'] ?>" <?php echo $checked ?>/><?php echo $state['name'] ?>
                                                                                    </label>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer col-sm-12" style='float:left'>
                                                                    <div class='col-sm-9'>
                                                                        <button type="button" style='float:left' id='select_all' class="btn btn-outline">Select All</button>
                                                                        <button type="button" style='float:left' id='deselect_all' class="btn btn-outline">Deselect All</button>
                                                                    </div>
                                                                    <div class='col-sm-3'>
                                                                        <button type="button" data-dismiss='modal' class="btn btn-outline">Save & Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="margiv-top-10">
                                                            <button type='submit' class="btn green"> Save Changes </button>
                                                            <a href="javascript:;" class="btn default"> Cancel </a>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- END CHANGE AVATAR TAB -->
                                                <?php
                                            }
                                            ?>
                                            <!-- CHANGE PASSWORD TAB -->
                                            <div class="tab-pane" id="tab_1_3">
                                                <form action="#" method='post'>
                                                    <div class="form-group">
                                                        <label class="control-label">Current Password</label>
                                                        <input type="password" name='old_password' class="form-control" required/> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">New Password</label>
                                                        <input type="password" name='new_password' class="form-control" required/> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Re-type New Password</label>
                                                        <input type="password" name='re_password' class="form-control" required/> </div>
                                                    <div class="margin-top-10">
                                                        <button type='button' class="btn green" id='change'> Change Password </button>
                                                        <a href="javascript:;" class="btn default"> Cancel </a>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END CHANGE PASSWORD TAB -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
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
    $('document').ready(function () {
        $('#dashboard').parents('li').addClass('open');
        $('#dashboard').siblings('.arrow').addClass('open');
        $('#dashboard').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#dashboard'));
        $('#phone').mask('(999) 999-9999');
        $('#plivo_phone').mask('(999) 999-9999');
        $('#fax').mask('(999) 999-9999');

        $('[name="country"]').change(function () {
            var cid = $(this).val();
            $.ajax({
                url: 'Agent/manage_state/getByCountryId/' + cid,
                method: 'get',
                success: function (str) {
                    $('#state_list').html(str);
                    $('#city_list').html('');
                }
            });
        });

        $('[name="state"]').change(function () {
            var sid = $(this).val();
            $.ajax({
                url: 'Agent/manage_city/getByStateId/' + sid,
                method: 'get',
                success: function (str) {
                    $('#city_list').html(str);
                }
            });
        });

        $('#select_all').click(function () {
            $('.states').closest('span').addClass('checked');
            $('.states').prop('checked', true);
            $.uniform.update();
        });

        $('#deselect_all').click(function () {
            $('.states').closest('span').removeClass('checked');
            ;
            $('.states').prop('checked', false);
        });

        $('#change').click(function () {
            var re_password = $('[name="re_password"]').val();
            var new_password = $('[name="new_password"]').val();
            var old_password = $('[name="old_password"]').val();
            if (old_password != '')
            {
                if (new_password != '')
                {
                    if (re_password != '')
                    {
                        if (re_password == new_password)
                        {

                            $.ajax({
                                url: 'Agent/profile/change',
                                data: 'old=' + old_password + "&new=" + new_password,
                                method: 'post',
                                success: function (str) {
                                    if (str == '0')
                                    {
                                        swal('Current password is wrong.');
                                    } else if (str == '2')
                                    {
                                        swal('Current Password and New Password is same');
                                    } else if (str == '1')
                                    {
                                        swal('Password is updated');
                                        $('[name="re_password"]').val('');
                                        $('[name="new_password"]').val('');
                                        $('[name="old_password"]').val('');
                                    }
                                }
                            });
                            return false;
                        } else
                        {
                            swal('New Password and Re-enter Password must be same');
                            return false;
                        }
                    } else
                    {
                        swal('please Re-Enter New Password');
                        return false;
                    }
                } else
                {
                    swal('Please Enter New Password');
                    return false;
                }
            } else
            {
                swal('Please Enter Current Password');
                return false;
            }
        });
    });
</script>