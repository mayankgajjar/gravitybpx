<style>
    .sweet-alert{top:60% !important;}
</style>
<?php
$profile = 'uploads/agents/no-photo-available.jpg';
$r = rand(12501, 48525);
$profile .= "?" . $r;
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
            <a href="index.html">Home</a>
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
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet ">
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li>
                            <a href="vendor">
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
                                            <li>
                                                <a href="#tab_1_4" data-toggle="tab">Change Password</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
                                            <div class="tab-pane active" id="tab_1_1">
                                                <?php if ($flag): ?>
                                                    <div class='alert alert-danger'>
                                                        Please fill all the required field.
                                                    </div>
                                                <?php elseif ($this->session->flashdata()) : ?>
                                                    <div class='alert alert-success'>
                                                        <?php echo $this->session->flashdata('msg'); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <form name="vendor_personal" role="form" action="vendor/profile/personal" method='post' id="vendor_personal">
                                                    <div class='col-sm-12 col-md-6'>
                                                        <div class="form-group">
                                                            <label class="control-label">First Name</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name='fname' placeholder="Enter Your First Name" class="form-control" value='<?php echo $vendor['fname']; ?>' required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Middle Name</label>
                                                            <input type="text" name='mname' placeholder="Enter Your Middle Name" class="form-control" value='<?php echo $vendor['mname']; ?>'/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Last Name</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name='lname' placeholder="Enter Your Last Name" value='<?php echo $vendor['lname']; ?>' class="form-control" required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Email Address</label>
                                                            <span class="required"> * </span>
                                                            <input type="email" value='<?php echo $vendor['email_id']; ?>' class="form-control" readonly required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Date of Birth</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name="date_of_birth" class="form-control form-control-inline input-medium date-picker" value="<?php if ($vendor['date_of_birth'] != '') { echo date("m/d/Y", strtotime($vendor['date_of_birth'])); } ?>" required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Address</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" class="form-control" name="address_line_1" placeholder="Street Address" value='<?php echo $vendor['address_line_1'] ?>' required />
                                                            <input type="text" class="form-control" name="address_line_2" placeholder="Street Address Cont.." value='<?php echo $vendor['address_line_2']; ?>' style='margin-top:5px;'/>
                                                        </div>
                                                    </div>
                                                    <div class='col-sm-12 col-md-6'>
                                                        <div class="form-group">
                                                            <label class="control-label">Phone Number</label>
                                                            <span class="required"> * </span>
                                                            <input id='phone' name='phone' type="text" value='<?php echo $vendor['phone_number']; ?>' class="form-control" placeholder='Enter Phone Number' required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Fax Number</label>
                                                            <input type="text" name='fax' id='fax' value='<?php echo $vendor['fax_number'] ?>' class="form-control" placeholder='Enter Fax number'/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Country</label>
                                                            <span class="required"> * </span>
                                                            <select name="country_id" id="" class="form-control" required>
                                                                <option value="0">Select Country</option>
                                                                <?php foreach ($country as $value) : ?>
                                                                    <?php
                                                                    $selected = '';
                                                                    if ($value['id'] == $vendor['country_id']) {
                                                                        $selected = 'selected';
                                                                    }
                                                                    ?>
                                                                    <option value="<?php echo $value['id'] ?>" <?php echo $selected ?>>
                                                                        <?php echo $value['name'] ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">State</label>
                                                            <span class="required"> * </span>
                                                            <select name="state_id" id="state_list" class="form-control" required>
                                                                <option value="0">Select State</option>
                                                                <?php foreach ($state as $value): ?>
                                                                    <?php
                                                                    $selected = '';
                                                                    if ($value['id'] == $vendor['state_id']) {
                                                                        $selected = 'selected';
                                                                    }
                                                                    ?>
                                                                    <option value="<?php echo $value['id'] ?>" <?php echo $selected ?>>
                                                                        <?php echo $value['name'] ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">City</label>
                                                            <span class="required"> * </span>
                                                            <select name="city_id" id="city_list" class="form-control" required>
                                                                <?php foreach ($city as $value): ?>
                                                                    <?php
                                                                    $selected = '';
                                                                    if ($value['id'] == $vendor['city_id']) {
                                                                        $selected = 'selected';
                                                                    }
                                                                    ?>
                                                                    <option value="<?php echo $value['id'] ?>" <?php echo $selected ?>>
                                                                        <?php echo $value['name'] ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Zip Code</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name='zip' placeholder="Enter Zip code" class="form-control" value='<?php echo $vendor['zip_code']; ?>' required />
                                                        </div>
                                                    </div>
                                                    <div class="margiv-top-20">
                                                        <button type='submit' class="btn green"> Save Changes </button>
                                                        <a href="javascript:;" class="btn default"> Cancel </a>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END PERSONAL INFO TAB -->
                                            <!-- CHANGE PASSWORD TAB -->
                                            <div class="tab-pane" id="tab_1_4">
                                                <form action="vendor/profile/change" method='post' role="form" id="vendor_change">
                                                    <div class="form-group">
                                                        <label class="control-label">Current Password
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <input type="password" name='old_password' class="form-control" required /> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">New Password
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <input type="password" name='new_password' class="form-control" required /> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Re-type New Password
                                                            <span class="required"> * </span>
                                                        </label>
                                                        <input type="password" name='re_password' class="form-control" required /> </div>
                                                    <div class="margin-top-10">
                                                        <button type='button' class="btn green" id='change'> Change Password </button>
                                                        <button type='reset' class="btn default"> Cancel </button>
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

<script type='text/javascript'>
    $('document').ready(function () {
        //$('body').addClass('page-sidebar-closed');
        //$('.page-sidebar-menu').addClass('page-sidebar-menu-closed');

        $('#dashboard').parents('li').addClass('open');
        $('#dashboard').siblings('.arrow').addClass('open');
        $('#dashboard').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#dashboard'));
        $(".date-picker").datepicker({endDate: new Date()});
        $('#phone').mask('(999) 999-9999');
        $('#fax').mask('(999) 999-9999');
        $('[name="country"]').change(function () {
            var cid = $(this).val();
            $.ajax({
                url: 'vendor/manage_state/getByCountryId/' + cid,
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
                url: 'vendor/manage_city/getByStateId/' + sid,
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
                                url: 'vendor/profile/change',
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

        $("#vendor_personal").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            rules: {
                "fname": {
                    required: true,
                    lettersonly: true
                },
                "lname": {
                    required: true,
                    lettersonly: true
                },
                "zip": {
                    required: true,
                    digits: true
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit

            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function (form) {
                form.submit();
            }
        });
        jQuery(document).on('click', '.pass-btn', function () {
            var type = jQuery('#pass').attr('type');
            if (type == 'password') {
                jQuery('#pass').attr('type', 'text');
                jQuery(this).html('Hide Password');
            } else {
                jQuery('#pass').attr('type', 'password');
                jQuery(this).html('Show Password');
            }
        });
    });
</script>
