<style>
    .show_up{
        display:block;
        visibility:visible;
    }
    .hide_it{
        display:none;
        visibility:hidden;
    }
</style>
<script type="text/javascript">
    var error_show_agency = 0;
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
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/select2/css/select2-bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/dropzone/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/dropzone/basic.min.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/dropzone/dropzone.min.js'); ?>" type="text/javascript"></script>
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
            <span>Add Agency</span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Add Agency </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<!-- BEGIN SAMPLE FORM PORTLET-->
<div class="portlet light bordered" id="form_wizard_1">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-red"></i>
            <span class="caption-subject font-red bold uppercase"> Agency Registration -
                <span class="step-title"> Step 1 of 4 </span>
            </span>
        </div>
    </div>
    <div class="portlet-body form">
        <?php
        if ($this->session->flashdata('error_server_register_agency')) {
            ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <span><?php echo $this->session->flashdata('error_server_register_agency'); ?></span>
            </div>
    <?php
}
/* echo '<pre>';
  print_r($agency);
  echo '</pre>'; */
?>
        <form class="form-horizontal" action="" id="submit_form" method="POST" enctype='multipart/form-data'>
            <div class="form-wizard">
                <div class="form-body">
                    <ul class="nav nav-pills nav-justified steps">
                        <li>
                            <a href="#tab1" data-toggle="tab" class="step">
                                <span class="number"> 1 </span>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Account Detail </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab2" data-toggle="tab" class="step">
                                <span class="number"> 2 </span>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Profile Detail </span>
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
                        <div class="tab-pane active " id="tab1">
                            <h3 class="block">Provide your account details</h3>

                            <input name="user_id" type="hidden" value="<?php echo $agency->user_id; ?>" />

                            <div class="form-group">
                                <label class="control-label col-md-4">Agency Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="agencyname" value="<?php echo $agency->name; ?>" />
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
                                <div class="col-md-3">
                                    <a class="btn btn-outline dark" data-toggle="modal" href="#upload"> Upload Profile Image </a>
                                </div>
                                <div class="col-md-5">
                                    <?php if ($agency->profile_image): ?>
                                        <img src="<?php echo site_url() ?>/uploads/agencies/<?php echo $agency->profile_image; ?>"/>
                                    <?php endif; ?>
                                </div>
                                <input type='hidden' id='profile' name='profile' value='<?php echo $agency->profile_image; ?>'>
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
                            <div class="form-group">
                                <label class="control-label col-md-4">Parent Agency</label>
                                <div class="col-md-5">
                                    <select name="parent_agency" id="" class="form-control">
                                        <option value="0">No Parent Agency</option>
                                        <?php foreach ($parentagency as $value): ?>
                                            <option  value="<?php echo $value['id'] ?>" <?php echo $value['id'] == $agency->parent_agency ? 'selected="selected"' : ''; ?>>
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
                                    <input type="text" class="form-control" name="email" id="emailid" value="<?php echo $agency->email_id; ?>" />
                                    <span class="help-block"> Provide your email address </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Password
                                    <span class="required">  </span>
                                </label>
                                <div class="col-md-5">
                                    <input type="password" class="form-control" name="password" id="submit_form_password" />
                                    <span class="help-block"> Provide your password </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Confirm Password
                                    <span class="required">  </span>
                                </label>
                                <div class="col-md-5">
                                    <input type="password" class="form-control" name="rpassword" />
                                    <span class="help-block"> Confirm your password </span>
                                </div>
                            </div>
                            <div class="form-group domain-group">
                                <label class="control-label col-md-4"><?php echo "Domain Name" ?><span class="required"> * </span></label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="domain" value="<?php echo $agency->domain; ?>"/>
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
                                    <input type="text" class="form-control" name="fname" placeholder="" value="<?php echo $agency->fname; ?>"/>
                                    <span class="help-block"> Provide your first name </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Middle Name
                                </label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="mname" placeholder="" value="<?php echo $agency->mname; ?>"/>
                                    <span class="help-block"> Provide your middle name </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Last Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="lname" placeholder="" value="<?php echo $agency->lname; ?>"/>
                                    <span class="help-block"> Provide your last name </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Phone Number
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control mask_phone phone" id='service_phone' name="phone" value="<?php echo $agency->phone_number; ?>" />
                                    <span class="help-block">Provide your phone number (XXX) XXX-XXXX</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Fax Number

                                </label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control mask_phone phone" id='fax' name="fax" value="<?php echo $agency->fax_number ?>" />
                                    <span class="help-block"> Provide your fax number (XXX) XXX-XXXX </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Address
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="address1" placeholder="Street Address" value="<?php echo $agency->address_line_1; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">
                                </label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="address2" placeholder="Street Address Cont.." value="<?php echo $agency->address_line_2; ?>"/>
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
<?php
foreach ($country as $value) {
    ?>
                                            <option value="<?php echo $value['id'] ?>" <?php echo isset($agency->country_id) && ($value['id'] == $agency->country_id) ? 'selected="selected"' : '' ?>>
                                            <?php echo $value['name'] ?>
                                            </option>
                                                <?php
                                            }
                                            ?>
                                    </select>
                                    <span class="help-block"> Provide your country</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">State
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-5 profile">
                                    <select name="state" id="state_list" class="form-control">
                                        <option value="">Select State</option>
                                    </select>
                                    <span class="help-block"> Provide your state</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">City
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-5 profile">
                                    <select name="city" id="city_list" class="form-control">
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
                                    <input type="text" class="form-control" name="zip" value="<?php echo $agency->zipcode; ?>" />
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
                                    <input type="text" class="form-control mask_phone phone" id='phone' name="service_phone" value="<?php echo $agency->service_phone_number; ?>"/>
                                    <span class="help-block"> Provide your service phone number (XXX) XXX-XXXX </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Service Fax Number
                                </label>
                                <div class="col-md-5">
                                    <input type="text" id='service_fax' class="form-control mask_phone fax" name="service_fax" value="<?php echo $agency->service_fax_number; ?>" />
                                    <span class="help-block"> Provide your service fax number (XXX) XXX-XXXX </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Service Email
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <input type="text" placeholder="" class="form-control" name="service_email" value="<?php echo $agency->service_email; ?>" />
                                    <span class="help-block"> Provide your service email address</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Resident License Number
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="license_number"  value="<?php echo $agency->resident_license_number; ?>"/>
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
<?php
foreach ($states as $state) {
    ?>
                                            <option value='<?php echo $state['id']; ?>' <?php echo $state['id'] == $agency->resident_license_state_id ? 'selected="selected"' : ''; ?>>
                                            <?php echo $state['name'] ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
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
<?php
$arr = array();
foreach ($agency->non_resident_state as $key => $value) {
    $arr[] = $value[state_id];
}
foreach ($states as $state) {
    ?>
                                                    <div class='col-sm-6 col-md-4 col-lg-4'>
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
                                    <div class="modal-footer col-sm-12" >
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
                            <h3 class="block">Provide your Bank details</h3>
                            <div class="form-group">
                                <label class="control-label col-md-4">Payment Option
                                    <span class="required"> * </span>
                                </label>
                                <?php $payment_option = unserialize(PAYMENT_OPTION); ?>
                                <div class="col-md-5">
                                    <select name="payment" id="payment" class="form-control">
                                        <option value="">Select Payment Option</option>
                                <?php
                                    if ($agency->card_name != "") {
                                        $payment_type = 2;
                                    } else if ($agency->full_name != "") {
                                        $payment_type = 1;
                                    }
                                ?>    
                                    <?php if (!empty($payment_option)) : ?>
                                        <?php foreach ($payment_option as $key => $value) : ?>
                                            <option <?php if ($payment_type == $key) { echo "selected ";} ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                        <?php /* <option value='1' <?php echo $agency->card_name == '' ? 'selected="selected"':'' ?> >Bank Draft</option>
                                          <option value='2' <?php echo $agency->bank_account_number == '' ? 'selected="selected"':'' ?>>Credit Card</option> */ ?>
                                    </select>
                                </div>
                            </div>
                            <div id='bank_container' class='show_up'>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Bank Name
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="bank_name" value="<?php echo $agency->full_name ?>" />
                                        <span class="help-block"> Provide your bank name</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Bank Address
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-5">
                                        <textarea class="form-control" rows="3" name="bank_address"><?php echo $agency->street_address; ?></textarea>
                                        <span class="help-block"> Provide your bank address</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Country
                                        <span class="required"> * </span>
                                    </label>
                                    
                                    <?php $city = $this->City_model->getCity($agency->bank_city_id); ?>
                                    <?php $states = $this->State_model->getCountryByStateId($city->state_id) ?>                                    
                                    <?php
                                        $country_id = '';
                                        foreach ($states as $key => $state) {
                                            $country_id = $state['country_id'];
                                        }
                                    ?>
                                    <div class="col-md-5">
                                        <select name="bank_country" id="" class="form-control">
                                            <option value="">Select Country</option>
                                            <?php foreach ($country as $value) : ?>
                                                <option value="<?php echo $value['id'] ?>" <?php echo $value['id'] == $country_id ? 'selected="selected"' : '' ?>>
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
                                        <select name="bank_state" id="bank_state_list" class="form-control">
                                            <option value="">Select State</option>
                                            <?php foreach ($states as $state): ?>
                                                <option value="<?php echo $state['id'] ?>" <?php echo $state['id'] == $city->state_id ? 'selected="selected"' : '' ?>><?php echo $state['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="help-block"> Provide your bank state</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">City
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-5">

                                        <?php $cities = $this->City_model->getCityByStateId($city->state_id); ?>
                                        <select name="bank_city" id="bank_city_list" class="form-control">
                                            <option value="">Select City</option>
                                            <?php foreach ($cities as $c): ?>
                                                <option value="<?php echo $c['id']; ?>" <?php echo $c['id'] == $agency->bank_city_id ? 'selected=""selected' : '' ?>><?php echo $c['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="help-block"> Provide your bank city</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Zip Code
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="bank_zip" value="<?php echo $agency->bank_zip_code; ?>" />
                                        <span class="help-block"> Provide your bank zip code </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Bank Routing (ABA) Number
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="routing_number" value="<?php echo $agency->bank_routing_number ?>" />
                                        <span class="help-block"> Provide your bank routing number</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Bank Account Number
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="bank_number" value="<?php echo $agency->bank_account_number ?>"/>
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
                                        <input type="text" class="form-control" name="card_name" value="<?php echo $agency->card_name; ?>"/>
                                        <span class="help-block"> Provide your name on credit card</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Card Type
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-5">
                                        <?php $card_type = unserialize(CREDIT_CARD_TYPE); ?>
                                        <select class='form-control' name='card_type' value="<?php echo set_value('card_type'); ?>">
                                            <option value="">Select Card Type</option>
                                                <?php if (!empty($card_type)) : ?>
                                                    <?php foreach ($card_type as $key => $value) : ?>
                                                        <option <?php if ($agency->card_type == $key) {
                                                                echo "selected ";
                                        } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>                                                    
                                                <?php endforeach; ?>
                                            <?php endif; ?>                                                        
                                        </select>
                                        <span class="help-block">Select your card type</span>
                                            <?php /*
                                              <select class='form-control' name='card_type'>
                                              <option value='visa' <?php echo 'visa'== $agency->card_type ? 'selected="selected"':'' ?>>Visa</option>
                                              <option value='master_card' <?php echo 'master_card'== $agency->card_type ? 'selected="selected"':'' ?>>Master Card</option>
                                              <option value='american_express' <?php echo 'master_card'== $agency->card_type ? 'selected="selected"':'' ?>>American Express</option>
                                              </select>
                                              <span class="help-block"> Select your card type</span> */ ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Credit Card Number
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="card_number" value="<?php echo $agency->card_number; ?>" />
                                        <span class="help-block"> Provide your credit card number</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Expiration Date
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-5">
                                        <input type="text" id="expiration_date" class="form-control cvv_expiration_date" placeholder='MM/YYYY' name="expiration_date" value="<?php echo $agency->expiration_date; ?>" />
                                        <span class="help-block"> Provide your expiration date (MM/YYYY)</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">CVV Number
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="ccv_number" value="<?php echo $agency->ccv_number; ?>"  />
                                        <span class="help-block"> Provide your CVV number </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-4 col-md-8">
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
<?php
/* echo '<pre>';
  print_r($agency);
  echo '</pre>'; */
?>
<!-- END SAMPLE FORM PORTLET-->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/select2/js/select2.full.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/select2/js/select2.full.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/jquery.maskedinput.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/scripts/app.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-wizard-edit.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/components-select2.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/components-date-time-pickers.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-dropzone.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.input-ip-address-control-1.0.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-input-mask.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
        $('document').ready(function () {
            $('#agency').parents('li').addClass('open');
            $('#agency').siblings('.arrow').addClass('open');
            $('#agency').parents('li').addClass('active');
            $('#add_agency').parents('li').addClass('active');
            $('<span class="selected"></span>').insertAfter($('#agency'));

            /*$('#phone').mask('(999) 999-9999');
             $('#service_phone').mask('(999) 999-9999');
             $('#fax').mask('(999) 999-9999');
             $('#service_fax').mask('(999) 999-9999');*/

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
                            $('#state_list').html(str);
                            $('#city_list').html('');
                        }
                        if (country_nm == "bank_country")
                        {
                            $('#bank_state_list').html(str);
                            $('#bank_city_list').html('');
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
                            $('#city_list').html(str);
                        }
                        if (country_nm == "bank_state")
                        {
                            $('#bank_city_list').html(str);
                        }
                    }
                });
            });

            /*$('[name="country"]').change(function(){
             var cid = $(this).val();
             $.ajax({
             url : 'Admin/manage_state/getByCountryId/'+cid+'/<?php echo $agency->state_id ?>',
             method : 'get',
             async  : false,
             success : function(str){
             $('#state_list').html(str);
             $('#city_list').html('');
             }
             });
             });
             
             $('[name="state"]').change(function(){
             var sid = $(this).val();
             $.ajax({
             url : 'Admin/manage_city/getByStateId/'+'<?php echo $agency->state_id ?>'+'/<?php echo $agency->city_id ?>',
             method : 'get',
             async  : false,
             success : function(str){
             $('#city_list').html(str);
             }
             });
             });
             
             $('[name="bank_country"]').change(function(){
             var cid = $(this).val();
             $.ajax({
             url : 'Admin/manage_state/getByCountryId/'+cid,
             method : 'get',
             success : function(str){
             $('#bank_state_list').html(str);
             $('#bank_city_list').html('');
             }
             });
             });
             
             $('[name="bank_state"]').change(function(){
             var sid = $(this).val();
             $.ajax({
             url : 'Admin/manage_city/getByStateId/'+sid+'/<?php echo $agency->bank_city_id ?>',
             method : 'get',
             success : function(str){
             $('#bank_city_list').html(str);
             }
             });
             });*/
            $('#card_container,#bank_container').addClass('hide_it');
            $('#responsive').on('click', '#select_all1', function () {
                $('.states').closest('span').addClass('checked');
                $('.states').prop('checked', true);

                $.uniform.update();
            });

            $('#responsive').on('click', '#deselect_all1', function () {
                $('.states').closest('span').removeClass('checked');
                ;
                $('.states').prop('checked', false);
            });

            $('#payment').change(function () {
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

            $("#emailid").change(function ()
            {
                var email_id = $(this).val();
                var url = "<?php echo site_url('others/check_email') ?>";
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        email_id: email_id
                    },
                    success: function (response)
                    {
                        if (response == "yes")
                        {
                            $(".email-error").remove();
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
            $('[name="country"]').trigger('change');
            var state_id = "<?php echo $agency->state_id ?>";
            if (state_id != "")
            {
                $("#state_list option").each(function (index)
                {
                    if ($(this).val() == state_id)
                    {
                        $(this).attr("selected", "true");
                        $('[name="state"]').trigger('change');
                    }
                });
            }
            var city_id = "<?php echo $agency->city_id ?>";
            if (city_id != "")
            {
                $("#city_list option").each(function (index)
                {
                    if ($(this).val() == city_id)
                    {
                        $(this).attr("selected", "true");
                    }
                });
            }
            $('[name="bank_country"]').trigger('change');
            var bank_state_id = "<?php echo isset($city->state_id) ? $city->state_id : '' ?>";            
            if (bank_state_id != "")
            {
                $("#bank_state_list option").each(function (index)
                {                    
                    if ($(this).val() == bank_state_id)
                    {
                        $(this).attr("selected", "true");
                        $('[name="bank_state"]').trigger('change');
                    }
                });
            }
            var bank_city_id = "<?php echo $agency->bank_city_id ?>";
            if (bank_city_id != "")
            {
                $("#bank_city_list option").each(function (index)
                {
                    if ($(this).val() == bank_city_id)
                    {
                        $(this).attr("selected", "true");
                    }
                });
            }
            $('#payment').trigger('change');
        });
        var response;
      jQuery.validator.addMethod(
        "uniquedomainName", 
        function(value, element) {
            var agency = '<?php echo $agency->id ?>';
            jQuery.ajax({
                url : '<?php echo site_url("others/checkdomain") ?>',
                method : 'post',
                async : false,
                dataType : 'json',
                data : {agency_id : agency, domain : value},
                success : function(result){
                    var flag = Boolean(result.success);                    
                    response = ( flag == true ) ? true : false;                    
                }
            });           
            return response;
        },
        "Domain name is Already Taken"
    );           
</script>
