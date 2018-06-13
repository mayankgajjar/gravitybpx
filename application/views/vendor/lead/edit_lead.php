<style>
    #lead_form{padding: 0px 100px;}
    #lead_form .col-md-6{padding: 0px 30px;
    margin-bottom: 10px;
    }
    .help-block-error {
    position: absolute;
}
</style>
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
<?php if (validation_errors() != ''): ?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>
<!-- BEGIN SAMPLE FORM PORTLET-->
<div class="portlet light bordered" id="form_wizard_1">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
    </div>

    <div class="portlet-body form">
        <form class="form-horizontal" action="" id="lead_form" method="POST">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Select Lead Category
                            </label>
                            <div>
                                <select name="category" id="cat_lead" class="form-control">
                                    <option value="">Select Lead Category</option>
                                    <option value="raw" <?php echo($lead->category == 'raw') ? 'selected' : ''; ?>>Raw Lead</option>
                                    <option value="aged" <?php echo($lead->category == 'aged') ? 'selected' : ''; ?>>Aged Lead</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Select Insurance Category
                                <span class="required"> * </span>
                            </label>
                            <div>
                                <select name="lead_category" id="lead_cate" class="form-control">
                                    <option value="">Select Insurance Category</option>
                                    <option value="health" <?php echo($lead->category == 'health') ? 'selected' : ''; ?>>Health Insurance</option>
                                    <option value="life" <?php echo($lead->category == 'life') ? 'selected' : ''; ?>>Life Insurance</option>
                                    <option value="medicare" <?php echo($lead->category == 'medicare') ? 'selected' : ''; ?>>Medicare Insurance</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">First Name
                                <span class="required"> * </span>
                            </label>
                            <div>
                                <input type="text" class="form-control" name="first_name" value="<?php echo $lead->first_name; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Last Name
                                <span class="required"> * </span>
                            </label>
                            <div>
                                <input type="text" class="form-control" name="last_name" value="<?php echo $lead->last_name; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Address
                            </label>
                            <div>
                                <input type="text" class="form-control" name="address" placeholder="Address" value="<?php echo $lead->address; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Country
                                <span class="required"> * </span>
                            </label>
                            <div>
                                <select name="country" id="country_id" class="form-control">
                                    <option value="">Select Country</option>
                                    <?php
                                    foreach ($country as $value) {
                                        ?>
                                        <option value="<?php echo $value['id'] ?>" selected>
                                            <?php echo $value['name'] ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">State
                                <span class="required"> * </span>
                            </label>
                            <div>
                                <select name="state" id="state_list" class="form-control">
                                    <option value="">Select State</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">City
                                <span class="required"> * </span>
                            </label>
                            <div>
                                <select name="city" id="city_list" class="form-control">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Zip Code
                                <span class="required"> * </span>
                            </label>
                            <div>
                                <input type="text" class="form-control" name="zip" value="<?php echo $lead->zip; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Email Address
                                <span class="required"> * </span>
                            </label>
                            <div>
                                <input type="text" class="form-control" name="email" value="<?php echo $lead->email; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Phone Number
                                <span class="required"> * </span>
                            </label>
                            <div>
                                <input type="text" class="form-control" name="phone" value="<?php echo $lead->phone; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Alternative phone
                            </label>
                            <div>
                                <input type="text" class="form-control" name="alt_phone" value="<?php echo $lead->alt_phone; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Best Time To Call
                            </label>
                            <div>
                                <select name="best_time_to_Call" id="best_time_to_Call" class="form-control">
                                    <option value="">Select Best Time</option>
                                    <option value="morning" <?php echo($lead->best_time_to_call == 'morning') ? 'selected' : ''; ?>>Morning</option>
                                    <option value="afternoon" <?php echo($lead->best_time_to_call == 'afternoon') ? 'selected' : ''; ?>>Afternoon</option>
                                    <option value="evening" <?php echo($lead->best_time_to_call == 'evening') ? 'selected' : ''; ?>>Evening</option>
                                    <option value="anytime" <?php echo($lead->best_time_to_call == 'anytime') ? 'selected' : ''; ?>>Anytime</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Existing Condition
                            </label>
                            <div>
                                <select name="existing_condition" id="existing_condition" class="form-control">
                                    <option value="">Select Existing Condition</option>
                                    <option value="positive">Positive</option>
                                    <option value="negative">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Expectant Parent
                            </label>
                            <div>
                                <input type="text" class="form-control" name="expectant_parent" value="<?php echo $lead->expectant_parent; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Source URL
                            </label>
                            <div>
                                <input type="text" class="form-control" name="source_url" value="<?php echo $lead->source_url; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Current Coverage
                            </label>
                            <div>
                                <select name="current_coverage" id="current_coverage" class="form-control">
                                    <option value="">Select Current Coverage</option>
                                    <option value="positive">Positive</option>
                                    <option value="negative">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Date of Birth
                            </label>
                            <div>
                                <input class="form-control form-control-inline input-medium date-picker" name='date_of_birth' size="16" type="text" value="<?php
                                if ($lead->date_of_birth != '') {
                                    echo date("m/d/Y", strtotime($lead->date_of_birth));
                                }
                                ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">OPT In
                            </label>
                            <div>
                                <select name="opt_in" id="opt_in" class="form-control">
                                    <option value="">Select OPT In</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Social Security Number
                            </label>
                            <div>
                                <input type="text" class="form-control" name="ssn" value="<?php echo $lead->ssn; ?>" />
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Height
                            </label>
                            <div>
                                <input type="text" class="form-control" name="height" value="<?php echo $lead->height; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Weight
                            </label>
                            <div>
                                <input type="text" class="form-control" name="weight" value="<?php echo $lead->weight; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Driver Status
                            </label>
                            <div>
                                <select name="driver_status" id="driver_status" class="form-control">
                                    <option value="">Select Driver Status</option>
                                    <option value="positive">Positive</option>
                                    <option value="negative">Negative</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Gender
                            </label>
                            <div>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Own/Rent
                            </label>
                            <div>
                                <select name="own_rent" id="own_rent" class="form-control">
                                    <option value="">Select Own/Rent</option>
                                    <option value="own">Own</option>
                                    <option value="rent">Rent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Military
                            </label>
                            <div>
                                <select name="military" id="military" class="form-control">
                                    <option value="">Select Military</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">US Citizen
                            </label>
                            <div>
                                <select name="us_citizen" id="us_citizen" class="form-control">
                                    <option value="">Select US Citizen</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Income Type
                            </label>
                            <div>
                                <input type="text" class="form-control" name="income_type" value="<?php echo $lead->income_type; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Net Monthly Income
                            </label>
                            <div>
                                <input type="text" class="form-control" name="net_monthly_income" value="<?php echo $lead->net_monthly_income; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Opt In 2
                            </label>
                            <div>
                                <select name="opt_in_2" id="opt_in_2" class="form-control">
                                    <option value="">Select Opt In 2</option>
                                    <option value="positive">Positive</option>
                                    <option value="negative">Negative</option>
                                </select>
                            </div>
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

<script type="text/javascript">
    $('document').ready(function () {
        jQuery('#vendor').addClass('open');
        jQuery('.add_vendor').addClass('active');
        $(".date-picker").datepicker({endDate: new Date()});
        $('input[name=phone]').mask('9999999999');
        $('input[name=alt_phone]').mask('9999999999');
        $('[name="country"]').change(function () {
            var cid = $(this).val();
            $.ajax({
                url: 'ven/lead/manage_state/getByCountryId/' + cid,
                method: 'get',
                success: function (str) {
                    $('#state_list').html(str);
                    $('#city_list').html('');
                }
            });
        });

        $('[name="state"]').change(function () {
            //var sid = $(this).val();
//            var sid = $(this).prop('data-custom');
            var sid = $(this).find(':selected').attr('data-custom');
            $.ajax({
                url: 'ven/lead/manage_city/getByStateId/' + sid,
                method: 'get',
                success: function (str) {
                    $('#city_list').html(str);
                }
            });
        });
        $('[name="country"]').trigger('change');
        $('#lead_cate').val('<?php echo $lead->lead_category; ?>');
        $('#existing_condition').val('<?php echo $lead->existing_condition; ?>');
        $('#opt_in').val('<?php echo $lead->opt_in; ?>');
        $('#existing_condition').val('<?php echo $lead->existing_condition; ?>');
        $('#driver_status').val('<?php echo $lead->driver_status; ?>');
        $('#gender').val('<?php echo $lead->gender; ?>');
        $('#own_rent').val('<?php echo $lead->own_rent; ?>');
        $('#military').val('<?php echo $lead->military; ?>');
        $('#us_citizen').val('<?php echo $lead->us_citizen; ?>');
        $('#opt_in_2').val('<?php echo $lead->opt_in_2; ?>');
        setTimeout(function () {
            $('[name="state"]').val('<?php echo $lead->state; ?>');
            $('[name="state"]').trigger('change');
            $('[name="city"]').val('<?php echo $lead->city; ?>');
        }, 2000);

    });


    jQuery('#lead_form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            //account
            lead_category: {
                required: true
            },
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email: {
                required: true,
                email: true,
            },
            phone: {
                required: true,
                minlength: 7
            },
            country: {
                required: true
            },
            state: {
                required: true
            },
            city: {
                required: true
            },
            zip: {
                required: true
            },
        },
        highlight: function (element) { // hightlight error inputs
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        errorPlacement: function (error, element) { // render error placement for each input type
            error.insertAfter(element); // for other inputs, just perform default behavior
        },
    });
    $('#leads').parents('li').addClass('open');
    $('#leads').siblings('.arrow').addClass('open');
    $('#leads').parents('li').addClass('active');
    $('#add_lead').parents('li').addClass('active');
</script>

