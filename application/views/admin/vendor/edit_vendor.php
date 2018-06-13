<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->

<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $label; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title"><?php echo $pagetitle; ?> </h3>

<!-- BEGIN SAMPLE FORM PORTLET-->
<div class="portlet light bordered" id="form_wizard_1">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
    </div>

    <div class="portlet-body form">
        <form class="form-horizontal" action="" id="vendor_form" method="POST">
            <div class="form-body">
                <div class="form-group">
                    <input type="hidden" name="user_id" value="<?php echo $vendor->user_id; ?>" />
                    <label class="control-label col-md-3">First Name
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="fname" value="<?php echo $vendor->fname; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Middle Name
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="mname" value="<?php echo $vendor->mname; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Last Name
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="lname" value="<?php echo $vendor->lname; ?>" />
                    </div>
                </div>
                <?php if ($type != 'edit'): ?>
                    <div class="form-group">
                        <label class="control-label col-md-3">Email
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="email_id" id="emailid" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Password
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-4">
                            <input type="password" class="form-control" name="password" id="password" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Confirm Password
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-4">
                            <input type="password" class="form-control" name="cpassword" id="cpassword" value="" />
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label class="control-label col-md-3">Phone Number
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input type="text" id='phone' class="form-control" name="phone_number" value="<?php echo $vendor->phone_number; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Fax Number
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id='fax' name="fax_number" value="<?php echo $vendor->fax_number; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Date of Birth
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input class="form-control form-control-inline input-medium date-picker" name='date_of_birth' size="16" type="text" value="<?php
                        if ($vendor->date_of_birth != '') {
                            echo date("m/d/Y", strtotime($vendor->date_of_birth));
                        }
                        ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Address
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="address_line_1" placeholder="Street Address" value="<?php echo $vendor->address_line_1; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="address_line_2" placeholder="Street Address Cont.." value="<?php echo $vendor->address_line_2; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Country
                        <span class="required"> * </span>
                    </label>

                    <div class="col-md-4">
                        <select name="country_id" id="country_id" class="form-control">
                            <option value="">Select Country</option>
                            <?php
                            foreach ($country as $value) {
                                ?>
                                <option value="<?php echo $value['id'] ?>" <?php echo $value['id'] == $vendor->country_id ? 'selected="selected"' : ''; ?>>
                                    <?php echo $value['name'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">State
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <select name="state_id" id="state_list" class="form-control">
                            <option value="0">Select State</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">City
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <select name="city_id" id="city_list" class="form-control">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Zip Code
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="zip_code" value="<?php echo $vendor->zip_code; ?>" />
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-4 col-md-8">
                        <button class="btn green" type="submit">Submit</button>
                        <a class="btn" href="<?= base_url('adm/vendor') ?>">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- END SAMPLE FORM PORTLET-->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="assets/theam_assets/pages/scripts/jquery.maskedinput.js" type="text/javascript"></script>
<script type="text/javascript">
    $('document').ready(function () {
        jQuery('#vendor').addClass('open');
        jQuery('.add_vendor').addClass('active');

        $(".date-picker").datepicker({endDate: new Date()});

        $('#phone').mask('(999) 999-9999');
        $('#fax').mask('(999) 999-9999');

        $('[name="country_id"]').change(function () {
            var cid = $(this).val();
            $.ajax({
                url: 'adm/vendor/manage_state/getByCountryId/' + cid + '/<?php echo $vendor->state_id ?>',
                method: 'get',
                async: false,
                success: function (str) {
                    $('#state_list').html(str);
                    $('#city_list').html('');
                }
            });
        });

        $('[name="state_id"]').change(function () {
            var sid = $(this).val();
            $.ajax({
                url: 'adm/vendor/manage_city/getByStateId/' + sid + '/<?php echo $vendor->city_id ?>',
                method: 'get',
                async: false,
                success: function (str) {
                    $('#city_list').html(str);
                }
            });
        });

        $('[name="country_id"]').trigger('change');
        $('[name="state_id"]').trigger('change');
    });


    jQuery('#vendor_form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            //account
            agent_id: {
                required: true
            },
            fname: {
                required: true
            },
            lname: {
                required: true
            },
            email_id: {
                required: true,
                email: true,
                remote: {
                    url: "<?php echo base_url('adm/vendor/check_user_exists/' . (isset($record->user_id) ? $record->user_id : '0')); ?>",
                    type: "post",
                    data: {
                        email_id: function () {
                            return $("#emailid").val();
                        }
                    }
                }
            },
            password: {
                required: true
            },
            cpassword: {
                required: true,
                equalTo: "#password"
            },
            date_of_birth: {
                required: true
            },
            phone_number: {
                required: true,
                minlength: 7
            },
            address_line_1: {
                required: true
            },
            country_id: {
                required: true
            },
            state_id: {
                required: true
            },
            city_id: {
                required: true
            },
            zip_code: {
                required: true
            },
        },
        messages: {
            email_id: {
                required: "Please provide a Email ID",
                remote: "Email ID is already exist, please choose diffrent EmailId"
            },
        },
        highlight: function (element) { // hightlight error inputs
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        errorPlacement: function (error, element) { // render error placement for each input type
            error.insertAfter(element); // for other inputs, just perform default behavior
        },
    });
</script>
