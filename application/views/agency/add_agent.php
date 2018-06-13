<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN SAMPLE FORM PORTLET-->
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Add Agent</span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Add Agent </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="portlet light bordered" id="form_wizard_1">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-red"></i>
            <span class="caption-subject font-red bold uppercase"> Agent Registration -
                <span class="step-title"> Step 1 of 3 </span>
            </span>
        </div>
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" action="" id="submit_form" method="POST">
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
                        <?php if (validation_errors() != ''): ?>
                            <div class="alert alert-danger">
                                <button class="close" data-dismiss="alert"></button><?php echo validation_errors(); ?>
                            </div>
                        <?php endif; ?>
                        <div class="tab-pane active" id="tab1">
                            <h3 class="block">Provide your account details</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">First Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="fname" value="<?php echo $agent->fname; ?>" />
                                    <span class="help-block"> Provide First Name of an agent</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Middle Name
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="mname" value="<?php echo $agent->mname; ?>" />
                                    <span class="help-block"> Provide Middle Name of an agent</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Last Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="lname" value="<?php echo $agent->lname; ?>" />
                                    <span class="help-block"> Provide Last Name of an agent</span>
                                </div>
                            </div>
                            <div class="form-group" style="display: none;">
                                <label class="control-label col-md-3">Parent Agency
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select name="parent_agency" id="" class="form-control">
                                        <option value="<?php echo $parentAgency->id; ?>" selected="selected"><?php echo $parentAgency->name; ?></option>
                                    </select>
                                    <span class="help-block">Select Parent Agency</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Agent Category
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select name="agent_type" class="form-control">
                                        <option value='1' <?php echo '1' == $agent->agent_type ? 'selected="selected"' : ''; ?> >Sales Agent</option>
                                        <option value='2' <?php echo '2' == $agent->agent_type ? 'selected="selected"' : ''; ?>>Verification Agent</option>
                                        <option value='3' <?php echo '3' == $agent->agent_type ? 'selected="selected"' : ''; ?>>Processing Agent</option>
                                    </select>
                                    <span class="help-block">Select Category of Agent</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Email
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="email" id="emailid" value="<?php echo $agent->email_id; ?>" />
                                    <span class="help-block"> Provide your email address </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Password
                                    <?php if ($agent->id == ''): ?>
                                        <span class="required"> * </span>
                                    <?php endif; ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="password" class="form-control" name="password" id="submit_form_password" />
                                    <span class="help-block"> Provide your password. </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Confirm Password
                                    <?php if ($agent->id == ''): ?>
                                        <span class="required"> * </span>
                                    <?php endif; ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="password" class="form-control" name="rpassword" />
                                    <span class="help-block"> Confirm your password </span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <h3 class="block">Provide your profile details</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Phone Number
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" id='phone' class="form-control" name="phone" value="<?php echo $agent->phone_number; ?>" />
                                    <span class="help-block"> Provide your phone number (999)999-9999</span>
                                </div>
                            </div>
<!--                        <div class="form-group">
                                <label class="control-label col-md-3">Plivo Number
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" id='plivo_phone' class="form-control" name="plivo_phone" value="<?php echo $agent->plivo_phone; ?>" disabled/>
                                    <span class="help-block"> Provide your Plivo number (999)999-9999</span>
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label class="control-label col-md-3">Fax Number
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id='fax' name="fax" value="<?php echo $agent->fax_number; ?>" />
                                    <span class="help-block"> Provide your fax number (999)999-9999</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Date of Birth
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input class="form-control form-control-inline input-medium date-picker" id="dob" name='dob' size="16" type="text" value="<?php echo $agent->date_of_birth; ?>"/>
                                    <span class="help-block"> Provide your date of birth </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Address
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="address1" placeholder="Street Address" value="<?php echo $agent->address_line_1; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="address2" placeholder="Street Address Cont.." value="<?php echo $agent->address_line_2; ?>"/>
                                    <span class="help-block"> Provide your street address </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Country
                                    <span class="required"> * </span>
                                </label>

                                <div class="col-md-4">
                                    <select name="country" id="" class="form-control">
                                        <option value="0">Select Country</option>
                                        <?php
                                        foreach ($country as $value) {
                                            ?>
                                            <option value="<?php echo $value['id'] ?>" <?php echo $value['id'] == $agent->country_id ? 'selected="selected"' : ''; ?>>
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
                                    <select name="state" id="state_list" class="form-control">
                                        <option value="0">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">City
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select name="city" id="city_list" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Zip Code
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="zip" value="<?php echo $agent->zip_code; ?>"/>
                                    <span class="help-block"> Provide your zip code </span>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" id="tab3">
                            <h3 class="block">Provide your license information</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">National Producer Number
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="npn" value="<?php echo $agent->national_producer_number; ?>" />
                                    <span class="help-block"> Provide NPN(National Producer Number)</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Resident License Number
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="license_number" value="<?php echo $agent->resident_license_number; ?>" />
                                    <span class="help-block">Provide resident license number</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Resident License State
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class='form-control' name='resident_license_state'>
                                        <?php
                                        foreach ($states as $state) {
                                            ?>
                                            <option value='<?php echo $state['id']; ?>' <?php echo $state['id'] == $agent->resident_license_state_id ? 'selected="selected"' : ''; ?>>
                                                <?php echo $state['name'] ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="help-block">Provide resident license state</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Non-Resident License State
                                </label>
                                <div class="col-md-4">
                                    <a class="btn btn-outline dark" data-toggle="modal" href="#responsive"> Choose State </a>
                                </div>
                                <!-- Non-resident state model -->
                                <div id="responsive" class="modal fade" style='top:0px;left:40%;width:60%;' tabindex="-1" data-width="760">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Select Non-Resident License State</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="checkbox-list">
                                                <?php
                                                $nstates = $agent->non_resident_state;
                                                $arr = array();
                                                foreach ($nstates as $key => $value) {
                                                    $arr[] = $value['state_id'];
                                                }
                                                foreach ($states as $state) {
                                                    ?>
                                                    <div class='col-sm-6 col-md-4 col-lg-3'>
                                                        <label>
                                                            <input class='states' type="checkbox" name="nonresident_license_state[]" value="<?php echo $state['id'] ?>" data-title="<?php echo $state['name'] ?>" <?php echo in_array($state['id'], $arr) ? 'checked="checked"' : ''; ?> /><?php echo $state['name'] ?>
                                                        </label>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style='float:left'>
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
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
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

<!-- END SAMPLE FORM PORTLET-->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/theam_assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="assets/theam_assets/pages/scripts/jquery.maskedinput.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/scripts/app.min.js" type="text/javascript"></script>
<?php if ($agent->id == ''): ?>
    <script src="assets/theam_assets/pages/scripts/form-wizard_agent.js" type="text/javascript"></script>
<?php else: ?>
    <script src="assets/theam_assets/pages/scripts/form-wizard-edit-agent.js" type="text/javascript"></script>
<?php endif; ?>
<script src="assets/theam_assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
<script type="text/javascript">
    $('document').ready(function () {
        $('#agent').parents('li').addClass('open');
        $('#agent').siblings('.arrow').addClass('open');
        $('#agent').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#agent'));
        $('#add_agent').parents('li').addClass('active');
        $('#dob').mask('99/99/9999');
        $('#phone').mask('(999) 999-9999');
        $('#plivo_phone').mask('(999) 999-9999');
        $('#fax').mask('(999) 999-9999');

        $('[name="country"]').change(function () {
            var cid = $(this).val();
            $.ajax({
                url: 'agency/manage_state/getByCountryId/' + cid + '/<?php echo $agent->state_id != '' ? $agent->state_id : 0 ?>',
                method: 'get',
                success: function (str) {
                    $('#state_list').html(str);
                    async: false,
                            $('#city_list').html('');
                }
            });
        });

        $('[name="state"]').change(function () {
            var sid = $(this).val();

            if (parseInt(sid) == 0) {
                sid = '<?php echo $agent->state_id != '' ? $agent->state_id : 0 ?>';
            }

            $.ajax({
                url: 'agency/manage_city/getByStateId/' + sid + '/<?php echo $agent->city_id != '' ? $agent->city_id : 0; ?>',
                method: 'get',
                async: false,
                success: function (str) {
                    $('#city_list').html(str);
                }
            });
        });

        $('[name="bank_country"]').change(function () {
            var cid = $(this).val();
            $.ajax({
                url: 'agency/manage_state/getByCountryId/' + cid,
                method: 'get',
                success: function (str) {
                    $('#bank_state_list').html(str);
                    $('#bank_city_list').html('');
                }
            });
        });

        $('[name="bank_state"]').change(function () {
            var sid = $(this).val();
            $.ajax({
                url: 'agency/manage_city/getByStateId/' + sid,
                method: 'get',
                success: function (str) {
                    $('#bank_city_list').html(str);
                }
            });
        });

        $('#select_all').click(function () {
            // $('.states').each(function(){
            // $(this).closest('span').addClass('checked');
            // $(this).attr('checked',true);
            // $.uniform.update($(this));
            // });
            $('.states').closest('span').addClass('checked');
            $('.states').prop('checked', true);
            $.uniform.update();
        });

        $('#deselect_all').click(function () {
            $('.states').closest('span').removeClass('checked');
            ;
            $('.states').prop('checked', false);
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

        $("#emailid").change(function ()
        {
            var email_id = $(this).val();
            var url_link = "agency/check_email";
            $.ajax({
                type: 'post',
                url: url_link,
                data: {
                    email_id: email_id
                },
                success: function (response)
                {
                    if (response == "yes")
                    {
                        $("#emailid").after('<span id="email-error" style="color:#f3565d !important" class="help-block">Email id already exists.</span>');
                        $(".button-next").css("pointer-events", "none");
                    } else
                    {
                        $("#email-error").remove();
                        $(".button-next").css("pointer-events", "unset");
                    }
                }
            });
        });
<?php if ($agent->id != ''): ?>
            $('[name="country"]').trigger('change');
            $('[name="state"]').trigger('change');
<?php endif; ?>
    });
</script>
