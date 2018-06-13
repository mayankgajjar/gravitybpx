<style>
.sweet-alert{top:60% !important;}
</style>
<?php
$profile = $this->session->userdata('agency')->profile_image;
if (empty($profile) || is_null($profile)) {
    $profile = 'uploads/agents/no-photo-available.jpg';
} else {
    $profile = 'uploads/agencies/' . $profile;
}
$r = rand(12501, 48525);
$profile .= "?" . $r;

if (empty($agency->parent_name) || is_null($agency->parent_name)) {
    $agency->parent_name = 'No Parent Agency';
}
if ($flag) {
    // $agency->fname = set_value('fname');
    // $agency->mname = set_value('mname');
    // $agency->lname = set_value('lname');
    // $agency->fax_number = set_value('fax');
    // $agency->phone_number = set_value('phone');
    // $agency->date_of_birth = set_value('dob');
    // $agency->address_line_1 = set_value('address1');
    // $agency->address_line_2 = set_value('address2');
    // $agency->zip_code = set_value('zip');
}
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
                                                <a href="#tab_1_2" data-toggle="tab">License Information</a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_3" data-toggle="tab">Bank Information</a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_4" data-toggle="tab">Change Password</a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_5" data-toggle="tab">Dialer User</a>
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
                                                <?php elseif($this->session->flashdata()) : ?>
                                                    <div class='alert alert-success'>
                                                        <?php echo $this->session->flashdata('msg'); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <form name="agency_personal" role="form" action="Agency/profile/personal" method='post' id="agency_personal">
                                                    <div class='col-sm-12 col-md-6'>
                                                        <div class="form-group">
                                                            <label class="control-label">Agency Name</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name='name' placeholder="Enter Agency Name" class="form-control" value='<?php echo $agency->name ?>' required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">First Name</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name='fname' placeholder="Enter Your First Name" class="form-control" value='<?php echo $agency->fname ?>' required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Last Name</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" name='lname' placeholder="Enter Your Last Name" value='<?php echo $agency->lname ?>' class="form-control" required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Upline Agency</label>
                                                            <input type="text" readonly class="form-control" value='<?php echo $agency->parent_name ?>'/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Email Address</label>
                                                            <span class="required"> * </span>
                                                            <input type="email" value='<?php echo $agency->email_id ?>' class="form-control" readonly required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Address</label>
                                                            <span class="required"> * </span>
                                                            <input type="text" class="form-control" name="address1" placeholder="Street Address" value='<?php echo $agency->address_line_1 ?>' required />
                                                            <input type="text" class="form-control" name="address2" placeholder="Street Address Cont.." value='<?php echo $agency->address_line_2 ?>' style='margin-top:5px;'/>
                                                        </div>
                                                    </div>
                                                    <div class='col-sm-12 col-md-6'>
                                                        <div class="form-group">
                                                            <label class="control-label">Phone Number</label>
                                                            <span class="required"> * </span>
                                                            <input id='phone' name='phone' type="text" value='<?php echo $agency->phone_number ?>' class="form-control" placeholder='Enter Phone Number' required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Fax Number</label>
                                                            <input type="text" name='fax' id='fax' value='<?php echo $agency->fax_number ?>' class="form-control" placeholder='Enter Fax number'/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Country</label>
                                                            <span class="required"> * </span>
                                                            <select name="country" id="" class="form-control" required>
                                                                <option value="0">Select Country</option>
                                                                <?php foreach ($country as $value) : ?>
                                                                    <?php
                                                                        $selected = '';
                                                                        if ($value['id'] == $agency->country_id) {
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
                                                            <select name="state" id="state_list" class="form-control" required>
                                                                <option value="0">Select State</option>
                                                                <?php foreach ($state as $value): ?>                                                                    
                                                                    <?php 
                                                                        $selected = '';
                                                                        if ($value['id'] == $agency->state_id) {
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
                                                            <select name="city" id="city_list" class="form-control" required>
                                                                    <?php foreach ($city as $value): ?>
                                                                        <?php
                                                                            $selected = '';
                                                                            if ($value['id'] == $agency->city_id) {
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
                                                            <input type="text" name='zip' placeholder="Enter Zip code" class="form-control" value='<?php echo $agency->zipcode; ?>' required />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo 'Domain' ?></label>                                                            
                                                            <label class="form-control"><?php echo $this->config->item('http').$agency->domain.'.'.$this->config->item('main_url') ?></label>
                                                        </div>                                                         
                                                    </div>
                                                    <div class="margiv-top-20">
                                                        <button type='submit' class="btn green"> Save Changes </button>
                                                        <a href="javascript:;" class="btn default"> Cancel </a>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END PERSONAL INFO TAB -->
                                            <!-- LICENSE INFORMATION TAB -->
                                            <div class="tab-pane" id="tab_1_2">
                                                <form name="agency_license" id="agency_license" role="form" action="Agency/profile/license" method='post'>
                                                    <div class="form-group">
                                                        <label class="control-label">Service Phone Number</label>
                                                        <span class="required"> * </span>
                                                        <input type="text" name='service_phone' id='service_phone' placeholder="Enter Service Phone Number" class="form-control" value='<?php echo $agency->service_phone_number ?>' required/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Service Fax Number</label>
                                                        <input type="text" name='service_fax' id='service_fax' placeholder="Enter Service Fax Number" class="form-control" value='<?php echo $agency->service_fax_number ?>' />
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Service Email</label>
                                                        <span class="required"> * </span>
                                                        <input type="email" name='service_email' placeholder="Enter Service Email" class="form-control" value='<?php echo $agency->service_email ?>' required/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Resident License Number</label>
                                                        <span class="required"> * </span>
                                                        <input type="text" name='license_number' placeholder="Enter Resident License Number" class="form-control" value='<?php echo $agency->resident_license_number ?>' required/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Resident License State</label>
                                                        <span class="required"> * </span>
                                                        <select name='resident_license_state' class='form-control'>
                                                        <?php foreach ($allState as $value): ?>
                                                            <?php 
                                                                $selected = '';
                                                                if ($value['id'] == $agency->resident_license_state_id) {
                                                                    $selected = 'selected';
                                                                }
                                                            ?>
                                                                <option value='<?php echo $value['id'] ?>' <?php echo $selected; ?>>
                                                                    <?php echo $value['name'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
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
                                                                <?php foreach ($allState as $state) : ?>
                                                                    <?php
                                                                        $checked = '';
                                                                        if (in_array($state['id'], $agency->non_resident_state)) {
                                                                            $checked = 'checked';
                                                                        }
                                                                    ?>
                                                                            <div class='col-sm-6 col-md-4 col-lg-3'>
                                                                                <label>
                                                                                    <input class='states' type="checkbox" name="nonresident_license_state[]" value="<?php echo $state['id'] ?>" data-title="<?php echo $state['name'] ?>" <?php echo $checked ?>/><?php echo $state['name'] ?>
                                                                                </label>
                                                                            </div>
                                                                <?php endforeach; ?>
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
                                            <!-- END LICENSE INFORMATION TAB -->
                                            <!-- BANK INFORMATION TAB -->
                                            <div class="tab-pane" id="tab_1_3">
                                                <form name="agency_bank" id="agency_bank" role="form" action="Agency/profile/bank" method='post'>
<?php /*
  <div class="form-group">
  <label class="control-label">Payment Option</label>
  <span class="required"> * </span>
  <select name="payment" id="payment" class="form-control">
  <option <?php if(isset($agency->full_name) && $agency->full_name != ""){ echo "selected"; }else{ echo ""; } ?> value='1'>Bank Draft</option>
  <option <?php if(isset($agency->full_name) && $agency->full_name != ""){ echo ""; }else{ echo "selected"; } ?> value='2'>Credit Card</option>
  </select>
  </div> */ ?>
<?php
if (isset($agency->full_name) && $agency->full_name != "") {
    ?>
                                                        <div id='bank_container' class='show_up'>
                                                            <div class="form-group">
                                                                <label class="control-label">Full Name
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <input type="text" class="form-control" name="bank_name" value="<?php echo $agency->full_name; ?>" required />
                                                                <span class="help-block"> Provide your full name</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Bank Account Number
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <input type="text" class="form-control" name="bank_number" value="<?php echo $agency->bank_account_number; ?>" required />
                                                                <span class="help-block"> Provide bank account number</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Bank Routing Number
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <input type="text" class="form-control" name="routing_number" value="<?php echo $agency->bank_routing_number; ?>" required />
                                                                <span class="help-block"> Provide your bank routing number</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Address
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <textarea required class="form-control" rows="3" name="bank_address"><?php echo $agency->street_address; ?></textarea>
                                                                <span class="help-block"> Provide address of bank</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Country
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <select name="bank_country" id="" class="form-control" required>
                                                                    <option value="0">Select Country</option>
                                                                    <?php foreach ($country as $value) : ?>
                                                                        <?php
                                                                            $selected = '';
                                                                            if ($value['id'] == $bank_country[0]['id']) {
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
                                                                <label class="control-label">State
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <select name="bank_state" id="bank_state_list" class="form-control" required>
                                                                    <option value="0">Select State</option>
                                                                    <?php
                                                                    foreach ($bank_all_state as $key => $value) {
                                                                        $selected = '';
                                                                        if ($value['id'] == $bank_state[0]['state_id']) {
                                                                            $selected = 'selected';
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $value['id']; ?>" <?php echo $selected ?>>
                                                                            <?php echo $value['name']; ?>
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">City
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <select name="bank_city" id="bank_city_list" class="form-control" required>
                                                                    <?php
                                                                    foreach ($bank_all_city as $key => $value) {
                                                                        $selected = '';
                                                                        if ($value['id'] == $agency->bank_city_id) {
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
                                                                <label class="control-label">Zip Code
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <input type="text" class="form-control" name="bank_zip" value="<?php echo $agency->bank_zip_code; ?>" required />
                                                                <span class="help-block"> Provide your zip code </span>
                                                            </div>
                                                        </div>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                        <div id='card_container' class='hide_it'>
                                                            <div class="form-group">
                                                                <label class="control-label">Name on Credit Card
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <input type="text" class="form-control" name="card_name" value="<?php echo $agency->card_name; ?>" required />
                                                                <span class="help-block"> Provide your name on credit card</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Card Type
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <select class='form-control' name='card_type' required >
                                                                    <option <?php if ($agency->card_type == "visa") {
                                                                    echo "selected";
                                                                } else {
                                                                    echo "";
                                                                } ?> value='visa'>Visa</option>
                                                                    <option <?php if ($agency->card_type == "master_card") {
                                                                    echo "selected";
                                                                } else {
                                                                    echo "";
                                                                } ?> value='master_card'>Master Card</option>
                                                                    <option <?php if ($agency->card_type == "american_express") {
                                                        echo "selected";
                                                    } else {
                                                        echo "";
                                                    } ?> value='american_express'>American Express</option>
                                                                </select>
                                                                <span class="help-block"> Select your card type</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Credit Card Number
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <input type="text" class="form-control" name="card_number" value="<?php echo $agency->card_number; ?>" required />
                                                                <span class="help-block"> Provide your credit card number</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Expiration Date
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <input type="text" id="expiration_date" class="form-control" placeholder='MM/YYYY' name="expiration_date" value="<?php echo $agency->expiration_date; ?>" required />
                                                                <span class="help-block"> Provide Expiration Date (MM/YYYY)</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">CCV Number
                                                                    <span class="required"> * </span>
                                                                </label>
                                                                <input type="text" class="form-control" name="ccv_number" value="<?php echo $agency->ccv_number; ?>" required />
                                                                <span class="help-block"> Provide your CCV number (Back of credit card)</span>
                                                            </div>
                                                        </diV>
    <?php
}
?>
                                                    <div class="margiv-top-10">
                                                        <button type='submit' class="btn green"> Save Changes </button>
                                                        <a href="javascript:;" class="btn default"> Cancel </a>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END BANK INFORMATION TAB -->
                                            <!-- CHANGE PASSWORD TAB -->
                                            <div class="tab-pane" id="tab_1_4">
                                                <form action="Agency/profile/change" method='post' role="form">
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
                                            <!-- start of the vicidial user tab -->
                                            <div class="tab-pane" id="tab_1_5" style="height: 500px;">
                                            <?php
                                            $this->load->library('vicidialdb');
                                            $this->load->model('vicidial/vusers_m', 'vusers_m');
                                            $this->load->model('vicidial/vphones_m', 'vphones_m');
                                            $this->db->where(array('id' => $this->session->userdata('agency')->id));
                                            $agnecy = $this->db->get('agencies')->row();
                                            $user = $this->vusers_m->get_by(array('user_id' => $agnecy->vicidial_user_id), TRUE);                                                                                        
                                            ?>
                                            <?php if ($user): ?>
                                                    <?php ?>
                                                    <form role="form" name="form" method="post" action="<?php echo site_url('dialer/ausers/profileedit/' . encode_url($user->user_id)) ?>">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo 'User Id' ?><span class="required">*</span></label>
                                                                <label class="form-control"><b><?php echo $user->user; ?></b></label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo 'Email' ?><span class="required">*</span></label>
                                                                <input type="text" class="form-control" name="email" value="<?php echo $user->email; ?>" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo 'Password' ?>
                                                                <?php if ($user->user_id == ''): ?>
                                                                        <span class="required">*</span>
                                                                <?php endif; ?>
                                                                </label>
                                                                <input type="password" name="pass" maxlength="20" class="form-control" id="pass" value="<?php echo $user->pass ?>"/><br /><button type="button" class="pass-btn btn">Show Password</button>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo 'Name' ?><span class="required">*</span></label>
                                                                <input type="text" name="full_name" value="<?php echo $user->full_name; ?>" class="form-control" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo 'Active'; ?><span class="required">*</span></label>
                                                                <select class="form-control" name="active">
                                                                    <option value="Y" <?php echo optionSetValue('Y', $user->active) ?>><?php echo 'Yes'; ?></option>
                                                                    <option value="N" <?php echo optionSetValue('N', $user->active) ?>><?php echo 'No'; ?></option>
                                                                </select>
                                                            </div>
                                                            <div class="margin-top-10">
                                                                <button class="btn green" type="submit"> Save Changes </button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php 
                                                                $stmt = "SELECT * FROM users_phones WHERE vicidial_user_id = {$agnecy->vicidial_user_id}";
                                                                $query = $this->db->query($stmt);
                                                                $phone = $query->row_array();
                                                                $stmtB = "SELECT * FROM phones WHERE id = {$agnecy->vicidial_user_id}";
                                                                $query = $this->vicidialdb->db->query($stmtB);
                                                                $phone = $query->row();                                                                
                                                            ?>
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo 'Phone Extension' ?></label>
                                                                <label class="form-control"><b><?php echo $phone->extension; ?></b></label>
                                                            </div>                                                            
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo 'Dial Plan Number' ?></label>
                                                                <label class="form-control"><b><?php echo $phone->dialplan_number; ?></b></label>
                                                            </div>                                                            
                                                            <div class="form-group">
                                                                <label class="control-label"><?php echo 'Registration Password' ?></label>
                                                                <label class="form-control"><b><?php echo $phone->conf_secret; ?></b></label>
                                                            </div>                                                              
                                                        </div>
                                                    </form>
                                                    <?php else: ?>
                                                    <a href="<?php echo site_url('dialer/ausers/createagency/' . encode_url($agnecy->id)) ?>"><?php echo 'Create Dialer User' ?></a>
                                                    <?php endif; ?>
                                            </div>
                                            <!-- end of the vicidial user tab -->
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
        //$('body').addClass('page-sidebar-closed');
        //$('.page-sidebar-menu').addClass('page-sidebar-menu-closed');

        $('#dashboard').parents('li').addClass('open');
        $('#dashboard').siblings('.arrow').addClass('open');
        $('#dashboard').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#dashboard'));

        $('#phone').mask('(999) 999-9999');
        $('#expiration_date').mask('99/9999');
        $('#fax').mask('(999) 999-9999');
        $('#service_phone').mask('(999) 999-9999');
        $('#service_fax').mask('(999) 999-9999');
        $('[name="country"]').change(function () {
            var cid = $(this).val();
            $.ajax({
                url: 'Agency/manage_state/getByCountryId/' + cid,
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
                url: 'Agency/manage_city/getByStateId/' + sid,
                method: 'get',
                success: function (str) {
                    $('#city_list').html(str);
                }
            });
        });

        $('[name="bank_country"]').change(function () {
            var cid = $(this).val();
            $.ajax({
                url: 'Agency/manage_state/getByCountryId/' + cid,
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
                url: 'Agency/manage_city/getByStateId/' + sid,
                method: 'get',
                success: function (str) {
                    $('#bank_city_list').html(str);
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

        $('#payment').change(function () {
            if ($(this).val() == 1)
            {
                $('#bank_container').show();
                $('#card_container').hide();
            } else
            {
                $('#card_container').show();
                $('#bank_container').hide();
            }
        });
        $("#payment").trigger("change");
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
                                url: 'Agency/profile/change',
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

        $("#agency_personal").validate({
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


        $("#agency_license").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            rules: {
                "license_number": {
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

        $("#agency_bank").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            rules: {
                "bank_name": {
                    required: true,
                    lettersonly: true
                },
                "card_name": {
                    required: true,
                    lettersonly: true
                },
                "bank_number": {
                    required: true,
                    digits: true
                },
                "routing_number": {
                    required: true,
                    digits: true
                },
                "bank_zip": {
                    required: true,
                    digits: true
                },
                "card_number": {
                    required: true,
                    digits: true
                },
                "ccv_number": {
                    required: true,
                    digits: true
                },
                "expiration_date": {
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
