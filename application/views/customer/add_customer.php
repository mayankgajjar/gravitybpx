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

<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/select2/css/select2-bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/css/jquery.fancybox.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/jstree/dist/themes/default/style.min.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->

<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->

<script language="javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="breadcrumbs">
        <h1 class="page-title"> <?php echo 'Add Customer' ?> </h1>     
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo 'Home' ?></a></li>
            <li class="active">
                <?php echo 'Add Customer' ?>
            </li>
        </ol>        
    </div>    
<div class="portlet light bordered" id="form_wizard_1">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-red"></i>
            <span class="caption-subject font-red bold uppercase"> Customer Registration -
                <span class="step-title"> Step 1 of 6 </span>
            </span>
        </div>
        <div class="actions">
            <div class="cart_show">
                <a class="btn btn-default btn-sm add_to_cart_show" href="javascript:;"> <i class="fa fa-shopping-cart"></i> Cart <?php echo count($this->cart->contents()); ?> </a>
            </div>
        </div>
    </div>
    <div class="portlet-body form">
        <?php if( $this->session->userdata('agency') && $this->session->userdata('agency')->id != "") { ?>
                <form class="form-horizontal" action="<?php echo site_url('customer/manage_customer/add'); ?>" id="submit_form" method="POST" enctype="multipart/form-data">
        <?php
                if($this->session->userdata('agency')->id != ""){
                    if( isset($customer) && $customer != ""){
                        if($customer->customer_id != ""){
                            $customer_id = $customer->customer_id;
                        }else{
                            $customer_id = "";
                        }
                        if($customer->agent_id != ""){
                            $agent_id = $customer->agent_id;
                        }

                        if($customer->verification_agent_id != "" && $customer->verification_agent_id != 0){
                            $verification_agent_id = $customer->verification_agent_id;
                        }else{
                            $verification_agent_id = "";
                        }
                    }
                }
            }else { ?>
                <form class="form-horizontal" action="<?php echo site_url('customer/manage_customer/add'); ?>" id="submit_form" method="POST" enctype="multipart/form-data">
            <?php
                if($this->session->userdata('agent')->agent_type == 1){
                    if( isset($customer) && $customer != ""){
                        if($customer->customer_id != ""){
                            $customer_id = $customer->customer_id;
                        }else{
                            $customer_id = "";
                        }

                        if($customer->agent_id != ""){
                            $agent_id = $customer->agent_id;
                        }else{
                            $agent_id = $this->session->userdata('agent')->id;
                        }

                        if($customer->verification_agent_id != "" && $customer->verification_agent_id != 0){
                            $verification_agent_id = $customer->verification_agent_id;
                        }else{
                            $verification_agent_id = "";
                        }
                    }else{
                        $customer_id = "";
                        $agent_id = $this->session->userdata('agent')->id;
                        $verification_agent_id = "";
                    }
                }
                if($this->session->userdata('agent')->agent_type == 2){
                    if($customer != ""){
                        if($customer->customer_id != ""){
                            $customer_id = $customer->customer_id;
                        }
                        else{
                            $customer_id = "";
                        }

                        if($customer->agent_id != ""){
                            $agent_id = $customer->agent_id;
                        }

                        if( isset($customer->verifivation_agent_id) && $customer->verifivation_agent_id != "" && $customer->verification_agent_id != 0){
                            $verification_agent_id = $customer->verification_agent_id;
                        }else{
                            $verification_agent_id = $this->session->userdata('agent')->id;
                        }
                    }
                }
            }
        ?>
		    <input type="hidden" name="sales_agent_id" value="<?php echo $agent_id; ?>" />
            <input type="hidden" name="verification_agent_id" value="<?php echo $verification_agent_id; ?>" />
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
            <input type="hidden" name="remove_members_ids" value="" />
            <input type="hidden" name="remove_beneficiaries_ids" value="" />
            <div class="form-wizard">
                <div class="form-body">
                    <ul class="nav nav-pills nav-justified steps">
                        <li>
                            <a href="#tab1" data-toggle="tab" class="step">
                                <span class="number"> 1 </span>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Customer Details </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab2" data-toggle="tab" class="step step2">
                                <span class="number"> 2 </span>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Product </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab3" data-toggle="tab" class="step">
                                <span class="number"> 3 </span>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Application </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab4" data-toggle="tab" class="step">
                                <span class="number"> 4 </span>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Additional Members </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab5" data-toggle="tab" class="step">
                                <span class="number"> 5 </span>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Beneficiaries </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab6" data-toggle="tab" class="step">
                                <span class="number"> 6 </span>
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
							Customer has been Registered successfully.
						</div>
                        <div class="tab-pane active " id="tab1">
                            <h3 class="block">Provide your customer details</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">First Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="fname" id="fname" value="<?php echo isset($customer) ?  $customer->fname : ''; ?>" />
                                    <span class="help-block"> Provide first name of a customer</span>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="control-label col-md-3">Middle Name
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="mname" id="mname" value="<?php echo isset($customer) ?  $customer->mname : ''; ?>"/>
                                    <span class="help-block"> Provide middle name of a customer</span>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="control-label col-md-3">Last Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="lname" id="lname" value="<?php echo isset($customer) ?  $customer->lname : ''; ?>"/>
                                    <span class="help-block"> Provide last name of a customer</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Gender
									<span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
									<div class="md-radio-inline">
										<div class="md-radio">
											<input type="radio" class="md-radiobtn" value="male" name="gender" id="male" <?php echo isset($customer) && $customer->gender == 'male' ? 'checked="checked"' :''; ?>/>
											<label for="male">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span> Male </label>
										</div>
										<div class="md-radio">
											<input type="radio" class="md-radiobtn" value="female" name="gender" id="female" <?php echo isset($customer) && $customer->gender == 'female' ? 'checked="checked"':''; ?> />
											<label for="female">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span> Female </label>
										</div>
									</div>
                                    <span class="help-block">Select gender of a customer </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Date of Birth
									<span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <?php
                                        if(isset($customer) && $customer->date_of_birth != "" && $customer->date_of_birth != "0000-00-00"){
                                            $date_of_birth = date('m/d/Y',strtotime($customer->date_of_birth));
                                        }else{
                                            $date_of_birth = "";
                                        }
                                    ?>
                                <input class="form-control mask_date2 form-control-inline date-picker" name="dob" size="16" type="text" id="dob" value="<?php echo $date_of_birth; ?>"/>
                                    <span class="help-block"> Provide date of birth of a customer</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Age
                                </label>
                                <div class="col-md-4">
                                    <input class="form-control" name="age" type="text" id="age" value="<?php echo isset($customer) ? $customer->age : ''; ?>" readonly="true" />
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-md-3">Zip Code
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="zip" id="zip" value="<?php echo isset($customer) ? $customer->zipcode : ''; ?>"/>
                                    <span class="help-block"> Provide zip code of a customer</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">City
								</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="city" id="city" readonly="true" value="<?php echo isset($customer) ? $customer->city : ''; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">State
								</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="state" id="state" readonly="true" value="<?php echo isset($customer) ? $customer->state : ''; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Phone Number
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control phone_number mask_phone" name="phone_number" id="phone" value="<?php echo isset($customer) ? $customer->phone_number : ''; ?>" />
                                    <span class="help-block">Provide phone number of a customer (XXX) XXX-XXXX</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Email Address
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="email" class="form-control" name="email" id="email" value="<?php echo isset($customer) ? $customer->email : ''; ?>" />
                                    <span class="help-block"> Provide email address of customer </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Customer File:</label>
                                <div class="col-md-4">
                                    <?php if( isset($customer) && $customer->customer_file != "") : ?>
                                        <div class="edit_customer">
                                            <?php echo $customer->customer_file; ?>
                                        </div>
                                    <?php endif;  ?>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="input-group input-large">
                                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                <span class="fileinput-filename"> </span>
                                            </div>
                                            <span class="input-group-addon btn default btn-file">
                                                <span class="fileinput-new"> <?php if( isset($customer) && $customer->customer_file != ""){ echo "Select New file"; }else{ echo "Select file"; } ?> </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="customer_file"> </span>
                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        </div>
                                    </div>
                                    <span class="help-block"> Provide customer file </span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <h3 class="block">Provide your products information</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Pre-Existing Condition?
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input
                                            type="radio" class="md-radiobtn" id="pre_exist_condition_yes" name="pre_exist_condition" value="yes" >
                                            <label for="pre_exist_condition_yes">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Yes
                                            </label>
                                        </div>
                                        <div class="md-radio">
                                            <input
                                            type="radio" class="md-radiobtn" id="pre_exist_condition_no" name="pre_exist_condition" value="no" >
                                            <label for="pre_exist_condition_no">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Use Tobacco?
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input
                                            type="radio" class="md-radiobtn" id="use_tobacco_yes" name="use_tobacco" value="yes" >
                                            <label for="use_tobacco_yes">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Yes
                                            </label>
                                        </div>
                                        <div class="md-radio">
                                            <input
                                            type="radio" class="md-radiobtn" id="use_tobacco_no" name="use_tobacco" value="no" >
                                            <label for="use_tobacco_no">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label
                                col-md-3">Plan Type
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control" name="plan_type" id="plan_type">
                                        <option <?php if( isset($customer) && $customer->customer_plan->plan_type == ""){ echo "selected"; }else{ echo ""; } ?> value="">Select any one</option>
                                        <option <?php if(isset($customer) && $customer->customer_plan->plan_type == "single"){ echo "selected"; }else{ echo ""; } ?> value="single">Single</option>
                                        <option <?php if(isset($customer) && $customer->customer_plan->plan_type == "single_spouse"){ echo "selected"; }else{ echo ""; } ?> value="single_spouse">Single+Spouse</option>
                                        <option <?php if(isset($customer) && $customer->customer_plan->plan_type == "single_child"){ echo "selected"; }else{ echo ""; } ?> value="single_child">Single+Child</option>
                                        <option <?php if(isset($customer) && $customer->customer_plan->plan_type == "family"){ echo "selected"; }else{ echo ""; } ?> value="family">Family</option>
                                    </select>
                                    <span class="help-block">Select plan type</span>
                                </div>
                            </div>
                            <div class="form-group product_total" style="display:none">
                                <label class="control-label col-md-3">Prodcuts Total
                                    <!-- <span class="required"> * </span> -->
                                </label>
                                <div class="col-md-4">
                                    <input type="hidden" class="form-control product_total_input" name="product_total" readonly="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">First Payment
                                    <!-- <span class="required"> * </span> -->
                                </label>
                                <div class="col-md-4">
                                    <?php
                                        if(isset($customer) && $customer->customer_plan->first_payment !=""){
                                            $find_array = array("$",".");
                                            $replace_array = array("","");
                                            $first_payment = toMoney(str_replace($find_array,$replace_array,$customer->customer_plan->first_payment));
                                        }else{
                                            $first_payment = '$'.number_format(0, 2, '.', '');
                                        }
                                    ?>
                                    <input type="text" class="form-control first_payment" name="first_payment" readonly="true" value="<?php echo $first_payment; ?>" />
                                </div>
                            </div>
                            <h3 class="block">Products</h3>
                            <div class="product-list">

                            </div>
                            <div class="side" title="">
                                <div class="silde_content_title">Total Enrollment Fees: </div>
                                <div class="silde_content_desc" id="total_enrollment_fees"><?php echo '$'.number_format(0, 2, '.', ''); ?></div>
                                <div class="silde_content_title">Total Monthly Due: </div>
                                <div class="silde_content_desc" id="total_montly_due"><?php echo '$'.number_format(0, 2, '.', ''); ?></div>
                                <div class="silde_content_title">Total Due Today: </div>
                                <div class="silde_content_desc" id="total_due_today"><?php echo '$'.number_format(0, 2, '.', ''); ?></div>
                            </div>

                            <div class="side1" title="">
                                <div class="silde_content_title">Filter By: </div>
                                <div id="product_type_filter" class="tree-demo"> </div>
                                <div id="company_filter" class="tree-demo"> </div>
                                <div id="deductible_filter" class="tree-demo"> </div>
                                <div id="maxbenefits_filter" class="tree-demo"> </div>
                                <div id="coinsurance_filter" class="tree-demo"> </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <h3 class="block">Provide your appication details</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">First Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="app_fname" id="app_fname" value="<?php echo isset($customer) ? $customer->app_fname : ''; ?>"/>
                                    <span class="help-block"> Provide first name</span>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="control-label col-md-3">Middle Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="app_mname" id="app_mname" value="<?php echo isset($customer) ? $customer->app_mname : ''; ?>"/>
                                    <span class="help-block"> Provide middle name</span>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="control-label col-md-3">Last Name
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="app_lname" id="app_lname" value="<?php echo isset($customer) ? $customer->app_lname : ''; ?>"/>
                                    <span class="help-block"> Provide last name</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Marital Status
									<span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
									<div class="md-radio-inline">
										<div class="md-radio">
											<input type="radio" class="md-radiobtn" value="single" name="app_marital_status" id="app_single">
											<label for="app_single">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span> Single </label>
										</div>
										<div class="md-radio">
											<input type="radio" class="md-radiobtn" value="married" name="app_marital_status" id="app_married">
											<label for="app_married">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span> Married </label>
										</div>
									</div>
                                    <span class="help-block">Select marital status</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Gender
									<span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
									<div class="md-radio-inline">
										<div class="md-radio">
											<input type="radio" class="md-radiobtn" value="male" name="app_gender" id="app_male">
											<label for="app_male">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span> Male </label>
										</div>
										<div class="md-radio">
											<input type="radio" class="md-radiobtn" value="female" name="app_gender" id="app_female">
											<label for="app_female">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span> Female </label>
										</div>
									</div>
                                    <span class="help-block">Select Gender</span>
                                </div>
                            </div>
                            <div class="form-group height_main">
                                <label class="control-label col-md-3 height_class">Height
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control height-feet" name="app_height-feet" value="<?php echo isset($customer) ? $customer->app_height_feet : ''; ?>"/>
                                    <input type="text" class="form-control height-Inches" name="app_height-Inches" value="<?php echo isset($customer) ? $customer->app_height_inches:''; ?>"/>
                                    <span class="help-block height-feet"> Feet </span>
                                    <span class="help-block height-Inches"> Inches </span>
                                </div>
                            </div>
                            <div class="form-group weight_main">
                                <label class="control-label col-md-3 weight_class">Weight
                                   <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control app_weight" name="app_weight" value="<?php echo isset($customer) ? $customer->app_weight : ''; ?>"/>
                                    <span class="help-block weight-block"> Provide weight</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Primary Mailing Address
                                   <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" rows="3" name="app_primary_email" id="app_primary_email"><?php echo isset($customer) ? $customer->app_primary_email : ''; ?></textarea>
                                    <span class="help-block"> Provide primary mailing address </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Zip Code
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="app_zip" id="app_zip" value="<?php echo isset($customer) ? $customer->app_zipcode : ''; ?>"/>
                                    <span class="help-block"> Provide zip code</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">City
								</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="app_city" id="app_city" readonly="true" value="<?php echo isset($customer) ? $customer->app_city : ''; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">State
								</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="app_state" id="app_state" readonly="true" value="<?php echo isset($customer) ? $customer->app_state : ''; ?>"/>
                                </div>
                            </div>
							<div class="form-group">
									<label class="control-label col-md-3 current_address">How long at current address? </label>
									<div class="col-md-4">
                                        <?php
                                            if( isset($customer) && $customer->app_how_long_address == 0){
                                                $app_how_long_address = "";
                                            }else{
                                                $app_how_long_address = isset($customer) ? $customer->app_how_long_address : '';
                                            }
                                        ?>
										<input type="text" class="form-control app_how_to_long" name="app_how_to_long" id="app_how_to_long" value="<?php echo $app_how_long_address; ?>"/>
										<span class="help-block"> Provide year(s) (Example : 5)</span>
									</div>
								</div>
							<div class="another_address">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Address
                                       <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <textarea class="form-control" rows="3" name="app_another_address" id="app_another_address"><?php echo isset($customer) ? $customer->app_another_address : ''; ?></textarea>
                                        <span class="help-block"> Provide address </span>
                                    </div>
                                </div>
								<div class="form-group">
									<label class="control-label col-md-3">Zip Code
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="app_another_zip" id="app_another_zip" value="<?php echo isset($customer) ? $customer->app_another_zipcode : ''; ?>"/>
										<span class="help-block"> Provide zip code </span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">City
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="app_another_city" id="app_another_city" readonly="true" value="<?php echo isset($customemr) ? $customer->app_another_city : ''; ?>"/>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">State
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="app_another_state" id="app_another_state" readonly="true" value="<?php echo isset($customer) ? $customer->app_another_state : ''; ?>"/>
									</div>
								</div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Time at address
                                       <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-4">
                                        <textarea class="form-control" rows="3" name="app_another_time_at_address" id="app_another_time_at_address"><?php echo isset($customer) ? $customer->app_another_time_at_address : ''; ?></textarea>
                                        <span class="help-block"> Provide time at address </span>
                                    </div>
                                </div>
							</div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Phone Number
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control phone_number mask_phone" name="app_phone_number" id="app_phone_number" value="<?php echo isset($customer) ? $customer->app_phone_number : ''; ?>"/>
                                    <span class="help-block">Provide phone number (XXX) XXX-XXXX</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Email Address
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="email" class="form-control" name="app_email" id="app_email" value="<?php echo isset($customer) ? $customer->app_email : ''; ?>"/>
                                    <span class="help-block"> Provide email address </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Social Security Number
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control mask_ssn soc_sec_number_mask" name="app_soc_sec_number" id="app_soc_sec_number" value="<?php echo isset($customer) ? $customer->app_social_sec_number : ''; ?>"/>
                                    <span class="help-block"> Provide social security number </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Date of Birth
									<span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <?php
                                        if( isset($customer) && $customer->app_date_of_birth != "" && $customer->app_date_of_birth != "0000-00-00"){
                                            $app_date_of_birth = date('m/d/Y',strtotime($customer->app_date_of_birth));
                                        }else{
                                            $app_date_of_birth = '';
                                        }
                                    ?>
                                    <input class="form-control form-control-inline date-picker mask_date2" name="app_dob" size="16" type="text" id="app_dob" value="<?php echo $app_date_of_birth; ?>"/>
                                    <span class="help-block"> Provide date of birth</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Age
                                </label>
                                <div class="col-md-4">
                                    <input class="form-control" name="app_age" type="text" id="app_age" value="" readonly="true" value="<?php echo isset($customer) ? $customer->app_age : ''; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Birth Country
									<span class="required"> * </span>
								</label>

                                <div class="col-md-4">
                                    <select name="app_birth_country" id="app_birth_country" class="form-control">
                                        <option value="">Select Country</option>
                                        <?php
                                        foreach ($country as $value) {
                                            ?>
                                            <option <?php if( isset($customer) && $customer->birth_country_id == $value['id']){ echo "selected "; }else{ echo ""; } ?> value="<?php echo $value['id'] ?>">
                                                <?php echo $value['name'] ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="help-block"> Provide birth country</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Birth State
									<span class="required"> * </span>
								</label>
                                <div class="col-md-4">
                                    <select name="app_birth_state" id="app_birth_state_list" class="form-control">
                                        <option value="">Select State</option>
                                    </select>
                                    <span class="help-block"> Provide birth state</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 us_citizen">Is the Proposed Insured a U.S. Citizen?
                                <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
									<div class="md-radio-inline">
										<div class="md-radio">
											<input type="radio" class="md-radiobtn app_us_citizen" value="yes" name="app_us_citizen" id="app_us_citizen_yes">
											<label for="app_us_citizen_yes">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span> Yes </label>
										</div>
										<div class="md-radio">
											<input type="radio" class="md-radiobtn app_us_citizen" value="no" name="app_us_citizen" id="app_us_citizen_no">
											<label for="app_us_citizen_no">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span> No </label>
										</div>
									</div>
                                    <span class="help-block">Select Is the proposed insured a U.S. citizen?</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 currently_employed">Is The Proposed Insured currently employed?
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
									<div class="md-radio-inline">
										<div class="md-radio">
											<input type="radio" class="md-radiobtn app_employed" value="yes" name="app_employed" id="app_employed_yes">
											<label for="app_employed_yes">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span> Yes </label>
										</div>
										<div class="md-radio">
											<input type="radio" class="md-radiobtn app_employed" value="no" name="app_employed" id="app_employed_no">
											<label for="app_employed_no">
												<span class="inc"></span>
												<span class="check"></span>
												<span class="box"></span> No </label>
										</div>
									</div>
                                    <span class="help-block">Select Is the proposed insured currently employed?</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Employer
                                <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input class="form-control" name="app_employer" type="text" id="app_employer" value="<?php echo isset($customer) ? $customer->app_employer : ''; ?>"/>
                                    <span class="help-block"> Provide employer</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Occupation
                                <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input class="form-control" name="app_occupation" type="text" id="app_occupation" value="<?php echo isset($customer) ? $customer->app_occupation : ''; ?>"/>
                                    <span class="help-block"> Provide occupation</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Annual Salary
                                <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input class="form-control mask_currency2" name="app_annual_salary" type="text" id="app_annual_salary" value="<?php echo isset($customer) ? $customer->app_annual_salary : ''; ?>"/>
                                    <span class="help-block"> Provide annual salary	</span>
                                </div>
                            </div>
                            <div class="form-group">
								<label class="control-label col-md-3">Description of Job Duties
                                <span class="required"> * </span>
								</label>
								<div class="col-md-4">
									<textarea class="form-control" rows="3" name="app_des_of_job_duties" id="app_des_of_job_duties"><?php echo isset($customer) ? $customer->app_desc_of_job_duties : ''; ?></textarea>
									<span class="help-block"> Provide description of job duties</span>
								</div>
							</div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Driver’s License
                                <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input class="form-control" name="app_driver_license"  type="text" id="app_driver_license" value="<?php echo isset($customer) ? $customer->app_driver_license : ''; ?>"/>
                                    <span class="help-block"> Provide driver’s license </span>
                                </div>
                            </div>
                        </div>
						<div class="tab-pane" id="tab4">
                            <h3 class="block">Provide your additional members details</h3>
                            <div class="family-add">
                                <input type="hidden" name="amid[1]" value=""/>
                                <div class="form-group">
                                    <label class="control-label col-md-3 amfirstname">First Name
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control amfname" name="amfname[1]" />
                                        <span class="help-block"> Provide first name</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 ammiddlename">Middle Name
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control ammname" name="ammname[1]" />
                                        <span class="help-block"> Provide middle name</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 amlastname ">Last Name
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control amlname" name="amlname[1]" />
                                        <span class="help-block"> Provide last name</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 amssn">Social Security Number
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control mask_ssn soc_sec_number_mask amsoc_sec_number" name="amsoc_sec_number[1]" />
                                        <span class="help-block"> Provide social security number </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 amrela">Relationship
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control amrelationship" name="amrelationship[1]" />
                                        <span class="help-block"> Provide relationship </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 amdob">Date of Birth</label>
                                    <div class="col-md-4">
                                        <input class="form-control mask_date2 form-control-inline date-picker amdob" name="amdob[1]" size="16" type="text"/>
                                        <span class="help-block"> Provide date of birth</span>
                                    </div>
                                </div>
                            </div>
                            <div class="additional_members">
                                <input type="hidden" name="amid[0]" value=""/>
								<div class="form-group">
									<label class="control-label col-md-3 amfirstname">First Name
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control amfname" name="amfname[0]" />
										<span class="help-block"> Provide first name</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 ammiddlename">Middle Name
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control ammname" name="ammname[0]" />
										<span class="help-block"> Provide middle name</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 amlastname">Last Name
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control amlname" name="amlname[0]" />
										<span class="help-block"> Provide last name</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 amssn">Social Security Number
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control amsoc_sec_number mask_ssn soc_sec_number_mask" name="amsoc_sec_number[0]" />
										<span class="help-block"> Provide social security number </span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 amrela">Relationship
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control amrelationship" name="amrelationship[0]" />
										<span class="help-block"> Provide relationship </span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3 amdob">Date of Birth</label>
									<div class="col-md-4">
										<input class="form-control mask_date2 form-control-inline amdob date-picker" name="amdob[0]" size="16" type="text"/>
										<span class="help-block"> Provide date of birth</span>
									</div>
								</div>
								<div class="form-actions additonal_action">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<input id="btnAdd" class="btn btn-outline green additional_btn" type="button" value="Add" />
										</div>
									</div>
								</div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab5">
                            <h3 class="block">Provide your beneficiaries details</h3>
                            <div class="form-group">
								<label class="control-label col-md-3">Estate</label>
								<div class="col-md-9">
									<div class="md-radio-inline">
										<div class="md-radio">
											<input
											type="radio" class="md-radiobtn" id="estate" name="beneficiaries_type" value="estate" >
											<label for="estate">
												<span></span>
												<span class="check"></span>
												<span class="box"></span>
											</label>
										</div>
									</div>
								</div>
                                <label class="control-label col-md-3">Individual</label>
                                <div class="col-md-9">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input
                                            type="radio" class="md-radiobtn" id="individual" name="beneficiaries_type" value="individual" >
                                            <label for="individual">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
							</div>
							<div class="individual_type">
								<div class="form-group">
									<label for="form_control_1" class="col-md-3 control-label">Type <span class="required"> * </span></label>
									<div class="col-md-9">
										<div class="md-radio-inline">
											<div class="md-radio">
												<input type="radio" class="md-radiobtn" id="primary" value="primary" name="individual_type">
												<label for="primary">
													<span class="inc"></span>
													<span class="check"></span>
													<span class="box"></span> Primary </label>
											</div>
											<div class="md-radio">
												<input type="radio" class="md-radiobtn" id="contingent" value="contingent" name="individual_type">
												<label for="contingent">
													<span></span>
													<span class="check"></span>
													<span class="box"></span> Contingent </label>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <div class="beneficiaries">
                                <input type="hidden" name="beid[0]" value=""/>
								<div class="form-group">
									<label class="control-label col-md-3">First Name
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control"
										name="befname[0]" />
										<span class="help-block"> Provide first name</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Middle Name
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control"
										name="bemname[0]" />
										<span class="help-block"> Provide middle name</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Last Name
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control"
										name="belname[0]" />
										<span class="help-block"> Provide last name</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Social Security Number
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control mask_ssn soc_sec_number_mask" name="besoc_sec_number[0]" />
										<span class="help-block"> Provide social security number </span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Relationship
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control"
										name="berelationship[0]" />
										<span class="help-block"> Provide relationship </span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Date of Birth
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input class="form-control form-control-inline date-picker mask_date2" name="bedob[0]" size="16" type="text" />
										<span class="help-block"> Provide date of birth</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Phone Number
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control phone_number mask_phone" name="bephone_number[0]" />
										<span class="help-block">Provide phone number (XXX) XXX-XXXX</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Email Address
									</label>
									<div class="col-md-4">
										<input type="email" class="form-control" name="beemail[0]" />
										<span class="help-block"> Provide email address</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3"> % of Share
                                        <span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control percent" name="beper_of_share[0]" />
										<span class="help-block"> Provide % of Share</span>
									</div>
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-offset-3 col-md-9">
											<input id="bebtnAdd" class="btn btn-outline green" type="button" value="Add" />
										</div>
									</div>
								</div>
                            </div>
                        </div>
						<div class="tab-pane" id="tab6">
                            <h3 class="block">Provide bank details</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Payment Option
									<span class="required"> * </span>
								</label>
                                <div class="col-md-4">
                                    <select name="payment" id="payment" class="form-control">
										<option <?php if(isset($customer) && $customer->bank_name != ""){ echo "selected"; }else{ echo ""; } ?> value='1'>Bank Draft</option>
										<option <?php if(isset($customer) && $customer->bank_name == ""){ echo "selected"; }else{ echo ""; } ?> value='2'>Credit Card</option>
                                    </select>
                                </div>
                            </div>
							<div id='bank_container' class='show_up'>
								<div class="form-group">
									<label class="control-label col-md-3">Bank Name
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="bank_name" value="<?php echo isset($customer) ? $customer->bank_name : ''; ?>" />
										<span class="help-block"> Provide your bank name</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Bank Address
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<textarea class="form-control" rows="3" name="bank_address"><?php echo isset($customer) ? $customer->bank_address : ''; ?></textarea>
										<span class="help-block"> Provide address of bank</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Country
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<select name="bank_country" id="bank_country" class="form-control">
											<option value="">Select Country</option>
											<?php foreach ($country as $value) : ?>
												<option <?php if( isset($customer) && $customer->bank_country_id == $value['id']){ echo "selected"; }else{ echo ""; } ?> value="<?php echo $value['id'] ?>">
												<?php echo $value['name'] ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">State
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<select name="bank_state" id="bank_state_list" class="form-control">
											<option value="">Select State</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">City
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<select name="bank_city" id="bank_city_list" class="form-control">
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Zip Code
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="bank_zip" value="<?php echo isset($customer) ? $customer->bank_zipcode : ''; ?>" />
										<span class="help-block"> Provide your zip code </span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Bank Routing (ABA) Number
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="routing_number" value="<?php echo isset($customer) ? $customer->bank_routing_number : ''; ?>" />
										<span class="help-block"> Provide your bank routing number</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Bank Account Number
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="bank_number" value="<?php echo isset($customer) ? $customer->bank_account_number : ''; ?>" />
										<span class="help-block"> Provide bank account number</span>
									</div>
								</div>
							</div>
							<div id='card_container' class='hide_it'>
								<?php /*
                                <div class="form-group">
									<label class="control-label col-md-3">Credit Card First Name
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control"
										name="card_fname" />
										<span class="help-block"> Provide credit card first name</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Credit Card Middle Name
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control"
										name="card_mname" />
										<span class="help-block"> Provide credit card middle name</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Credit Card Last Name
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control"
										name="card_lname" />
										<span class="help-block"> Provide credit card last name</span>
									</div>
								</div> */ ?>
								<div class="form-group">
									<label class="control-label col-md-3">Card Type
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<select class="form-control" name="card_type">
											<option <?php if( isset($customer) && $customer->card_type == "visa"){ echo "selected"; }else{ echo ""; } ?> value='visa'>Visa</option>
											<option <?php if(isset($customer) && $customer->card_type == "master_card"){ echo "selected"; }else{ echo ""; } ?> value='master_card'>Master Card</option>
											<option <?php if( isset($customer) && $customer->card_type == "american_express"){ echo "selected"; }else{ echo ""; } ?> value='american_express'>American Express</option>
										</select>
										<span class="help-block"> Select your card type</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Credit Card Number
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="card_number" value="<?php echo isset($customer) ? $customer->card_number : ''; ?>" />
										<span class="help-block"> Provide your credit card number</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Expiration Date
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input id="expiration_date" type="text" class="form-control cvv_expiration_date" placeholder='MM/YYYY' name="expiration_date" value="<?php echo isset($customer) ? $customer->expiration_date : ''; ?>" />
										<span class="help-block"> Provide Expiration Date (MM/YYYY)</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">CVV Number
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="ccv_number" value="<?php echo isset($customer) ? $customer->ccv_number : ''; ?>" />
										<span class="help-block"> Provide your CVV number (Back of credit card)</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Billing Address Same as Resident Address?
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">

											<div class="md-checkbox-inline">
												<div class="md-checkbox">
													<input
													type="checkbox" class="md-check" value="1" id="checkbox8" name="billing_same" >
													<label for="checkbox8">
														<span></span>
														<span class="check"></span>
														<span class="box"></span>
														</label>
												</div>
											</div>

									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Billing Address
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<textarea class="form-control" rows="3" name="billing_address"><?php echo isset($customer) ? $customer->card_address : ''; ?></textarea>
										<span class="help-block"> Provide address of billing</span>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Country
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<select name="billing_country" id="billing_country" class="form-control">
											<option value="0">Select Country</option>
											<?php foreach ($country as $value) : ?>
												<option <?php if( isset($customer) && $customer->card_country_id == $value['id']){ echo "selected"; }else{ echo ""; } ?> value="<?php echo $value['id'] ?>">
												<?php echo $value['name'] ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">State
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<select name="billing_state" id="billing_state_list" class="form-control">
											<option value="0">Select State</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">City
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<select name="billing_city" id="billing_city_list" class="form-control">
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Zip Code
										<span class="required"> * </span>
									</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="billing_zip" value="<?php echo isset($customer) ? $customer->card_zipcode : ''; ?>" />
										<span class="help-block"> Provide your zip code </span>
									</div>
								</div>
							</div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Notes
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" rows="3" name="notes"><?php echo isset($customer) ? $customer->notes :''; ?></textarea>
                                </div>
                            </div>
                            <?php if($this->session->userdata('agent')->agent_type == 2) : ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Verification Status
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <div class="md-radio-inline">
                                                <div class="md-radio">
                                                    <input type="radio" class="md-radiobtn" value="1" name="verification_status" id="verification_status_verified">
                                                    <label for="verification_status_verified">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Verified </label>
                                                </div>
                                                <div class="md-radio">
                                                    <input type="radio" class="md-radiobtn" value="0" name="verification_status" id="verification_status_not_verified">
                                                    <label for="verification_status_not_verified">
                                                        <span class="inc"></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Not Verified </label>
                                                </div>
                                            </div>
                                            <span class="help-block">Select verification status</span>
                                        </div>
                                    </div>
                            <?php endif; ?>
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
        <div class="customer_model modal fade bs-example-modal-lg  modal-lg" aria-labelledby="myLargeModalLabel" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Product Information</h4>
                    </div>
                    <div class="modal-body">
                        <div class="add_new_form fancybox1">
                            <form class="form-horizontal" id="add_new_product_form" method="POST">
                            <?php if($this->session->userdata('agent')->id != "") : ?>
                                    <input type="hidden" name="add_sales_agent_id" value="<?php echo $this->session->userdata('agent')->id; ?>" />
                            <?php else : ?>
                                    <input type="hidden" name="add_sales_agent_id" value="<?php echo isset($customer) ? $customer->agent_id : ''; ?>" />
                            <?php endif; ?>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Product Category:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <select name="product_category" id="product_category" class="form-control">
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $value) : ?>
                                                    <option <?php if(isset($products) && $value['id'] == $products->category_id){ echo "selected"; }else{ echo ""; } ?> value="<?php echo $value['id'] ?>">
                                                        <?php echo $value['category_name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                        </select>
                                        <span class="help-block"> Select category </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Product Name:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="add_product_name" value="" placeholder="">
                                        <span class="help-block"> Provide product name </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Company:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <select name="add_underwriting_company" id="add_underwriting_company" class="form-control">
                                            <option value="">Select Company</option>
                                            <?php foreach ($company as $value) : ?>
                                                <option value="<?php echo $value['id'] ?>">
                                                    <?php echo $value['company_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="help-block"> Select company </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Product Levels:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="add_product_levels" value="" placeholder="">
                                        <span class="help-block"> Provide product levels </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Product Price:
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control mask_currency2" name="add_product_price" placeholder="" value="">
                                        <span class="help-block"> Provide product price </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Plan Type
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="add_plan_type" id="add_plan_type">
                                            <option <?php if(isset($customer) && $customer->customer_plan->plan_type == ""){ echo "selected"; }else{ echo ""; } ?> value="">Select any one</option>
                                            <option <?php if(isset($customer) && $customer->customer_plan->plan_type == "single"){ echo "selected"; }else{ echo ""; } ?> value="single">Single</option>
                                            <option <?php if(isset($customer) && $customer->customer_plan->plan_type == "single_spouse"){ echo "selected"; }else{ echo ""; } ?> value="single_spouse">Single+Spouse</option>
                                            <option <?php if(isset($customer) && $customer->customer_plan->plan_type == "single_child"){ echo "selected"; }else{ echo ""; } ?> value="single_child">Single+Child</option>
                                            <option <?php if(isset($customer) && $customer->customer_plan->plan_type == "family"){ echo "selected"; }else{ echo ""; } ?> value="family">Family</option>
                                        </select>
                                        <span class="help-block">Select plan type</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Enrollment Fee
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control mask_currency2" name="add_enrollment_fee" value="" />
                                        <span class="help-block"> Provide enrollment fee</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Monthly Payment
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control mask_currency2" name="add_monthly_payment" value="" />
                                        <span class="help-block"> Provide monthly payment</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Co-Pay
                                        <!-- <span class="required"> * </span> -->
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control mask_currency2" name="add_co_pays" value="" />
                                        <span class="help-block"> Provide co-pays</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Specialist Co-Pay
                                        <!-- <span class="required"> * </span> -->
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control mask_currency2" name="add_specialist_co_pay" value="" />
                                        <span class="help-block"> Provide specialist co-pay</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Coinsurance
                                        <!-- <span class="required"> * </span> -->
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control percentage" name="add_coinsurance" value="" />
                                        <span class="help-block"> Provide coinsurance </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Deductible Amount
                                        <!-- <span class="required"> * </span> -->
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control mask_currency2" name="add_deductible_amount" value="" />
                                        <span class="help-block"> Provide deductible amount</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Maximum Benefits
                                        <!-- <span class="required"> * </span> -->
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control mask_currency2" name="add_maximum_benefits" value="" />
                                        <span class="help-block"> Provide maximum benefits</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Maximum out of pocket
                                        <!-- <span class="required"> * </span> -->
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control mask_currency2" name="add_maximum_out_of_pocket" value="" />
                                        <span class="help-block">Provide maximum out of pocket</span>
                                    </div>
                                </div>
                                <?php /*
                                <div class="form-group">
                                    <label class="control-label col-md-3">Post Date
                                        <!-- <span class="required"> * </span> -->
                                    </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control form-control-inline mask_date2 input-medium date-picker" name="add_post_date" value=""  />
                                        <span class="help-block"> Provide post date</span>
                                    </div>
                                </div> */ ?>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-9">
                                        <div class="actions btn-set">
                                            <button type="reset" class="btn btn-secondary-outline">
                                                <i class="fa fa-reply"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-success submit-class">
                                                <i class="fa fa-check"></i> Save
                                            </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- END SAMPLE FORM PORTLET-->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/select2/js/select2.full.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/scripts/app.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/ui-tree.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-wizard_customer.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/components-select2.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/components-date-time-pickers.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/jquery.sidecontent.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/jquery.fancybox.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/jquery.mousewheel.pack.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jstree/dist/jstree.js'); ?>" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput-main.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.input-ip-address-control-1.0.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-input-mask.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->


<script type="text/javascript">
    $('document').ready(function()
    {
        $('#customer').parents('li').addClass('open');
        $('#customer').siblings('.arrow').addClass('open');
        $('#customer').parents('li').addClass('active');
        $('#add_customer').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#customer'));
        var ambirth_state_list_id = 1;
		var bebirth_state_list_id = 1;
		var increment_value = 1;
        var benifi_value = 0;
        $(document).on('click','.add_to_cart',function ()
        {
            var id = $(this).attr("data-id");
            var enrollment_fee = $(this).attr('enrollment_fee');
            var company_name = $(this).attr('company_name');
            if(id != "")
            {
                var remove_link = "";
                var url_link = '<?php echo site_url("add_to_cart/add_to_cart") ?>';
                $.ajax({
                    url : url_link,
                    method : 'post',
                    async : false,
                    data : {data : id,enrollment_fee_price : enrollment_fee,main_cart : 'main_product',company_name : company_name},
                    success : function(str)
                    {
                        var obj = $.parseJSON(str);
                        var americo_product = obj.Americo;
                        var id = obj.last_product_cart;
                        var remove_string = obj.last_product_cart_remove_link;
                        var cart_product_count = obj.count;
                        var products_total = obj.total;
                        var enrollment_fee_total = obj.enrollment_fee_total;
                        var application_fields_array = obj.application_fields_array;
                        RequiredFields(application_fields_array);
                        remove_link  = '<a class="btn btn-default btn-sm remove_to_cart" company_name="'+company_name+'" enrollment_fee="'+enrollment_fee+'" data-id="'+id+'" remove-id="'+remove_string+'" href="javascript:;"> Remove <i class="fa fa-remove"></i></a>';
                        var cart_show = '<a class="btn btn-default btn-sm add_to_cart_show" href="javascript:;"> <i class="fa fa-shopping-cart"></i> Cart '+cart_product_count+' </a>';
                        $('.cart_show').html(cart_show);
                        $('.product_total_input').val(products_total);
                        $('#total_montly_due').html(format2(products_total, "$"));
                        $('#total_enrollment_fees').html(format2(enrollment_fee_total, "$"));
                        var total_due_today = parseFloat(enrollment_fee_total) + parseFloat(products_total);
                        $('#total_due_today').html(format2(total_due_today, "$"));
                        $('.first_payment').val(format2(total_due_today, "$"));
                        $( ".actions .add_to_cart" ).each(function( index )
                        {
                          if($(this).attr("data-id") == id)
                          {
                             $(this).replaceWith(remove_link);
                          }
                        });

                        if(americo_product >= 1)
                        {
                           americo_required_fields();
                        }
                        else
                        {
                            americo_not_required_fields();
                        }
                    }
                });
            }
        });
        $(document).on('click','.remove_to_cart',function ()
        {
            var id = $(this).attr("remove-id");
            var product_id = $(this).attr("data-id");
            var enrollment_fee = $(this).attr('enrollment_fee');
            var company_name = $(this).attr('company_name');
            var url_link = '<?php echo site_url("add_to_cart/remove_cart") ?>';
            if(id != "")
            {
                $.ajax({
                    url : url_link,
                    method : 'post',
                    async : false,
                    data : {data : id,main_cart : 'main_product',company_name : company_name},
                    success : function(str)
                    {
                        var obj = $.parseJSON(str);
                        var cart_product_count = obj.count;
                        var americo_product = obj.Americo;
                        var enrollment_fee_total = obj.enrollment_fee_total;
                        var application_fields_array = obj.application_fields_array;
                        RequiredFields(application_fields_array);
                        add_to_cart_link  = '<a class="btn btn-default btn-sm add_to_cart" company_name="'+company_name+'" enrollment_fee="'+enrollment_fee+'" data-id="'+product_id+'" href="javascript:;"> Apply <i class="fa fa-shopping-cart"></i></a>';
                        //$(this).replaceWith(add_to_cart_link);
                        var cart_show = '<a class="btn btn-default btn-sm add_to_cart_show" href="javascript:;"> <i class="fa fa-shopping-cart"></i> Cart '+cart_product_count+' </a>';
                        var products_total = obj.total;
                        $('.cart_show').html(cart_show);
                        $('.product_total_input').val(products_total);
                        $('#total_montly_due').html(format2(products_total, "$"));
                        $('#total_enrollment_fees').html(format2(enrollment_fee_total, "$"));
                        var total_due_today = parseFloat(enrollment_fee_total) + parseFloat(products_total);
                        $('#total_due_today').html(format2(total_due_today, "$"));
                        $('.first_payment').val(format2(total_due_today, "$"));

                        $( ".actions .remove_to_cart" ).each(function( index )
                        {
                          if($(this).attr("data-id") == product_id)
                          {
                             $(this).replaceWith(add_to_cart_link);
                          }
                        });
                        if(americo_product >= 1)
                        {
                            americo_required_fields();
                        }
                        else
                        {
                            americo_not_required_fields();
                        }
                    }
                });
            }
        });

        $(document).on('click','.add_to_cart1',function ()
        {
            var id = $(this).attr("temp-id");
            var enrollment_fee = $(this).attr('enrollment_fee');
            var company_name = $(this).attr('company_name');
            var url_link = '<?php echo site_url("add_to_cart/add_to_cart") ?>';
            if(id != "")
            {
                var remove_link = "";
                $.ajax({
                    url : url_link,
                    method : 'post',
                    async : false,
                    data : {data : id,enrollment_fee_price : enrollment_fee,temp_cart : 'temp_product',company_name : company_name},
                    success : function(str)
                    {
                        var obj = $.parseJSON(str);
                        var americo_product = obj.Americo;
                        var id = obj.last_product_cart;
                        var remove_string = obj.last_product_cart_remove_link;
                        var cart_product_count = obj.count;
                        var products_total = obj.total;
                        var enrollment_fee_total = obj.enrollment_fee_total;
                        remove_link  = '<a class="btn btn-default btn-sm remove_to_cart1" company_name="'+company_name+'" enrollment_fee="'+enrollment_fee+'" temp-id="'+id+'" remove-temp-id="'+remove_string+'" href="javascript:;"> Remove <i class="fa fa-remove"></i></a>';
                        var cart_show = '<a class="btn btn-default btn-sm add_to_cart_show" href="javascript:;"> <i class="fa fa-shopping-cart"></i> Cart '+cart_product_count+' </a>';
                        $('.cart_show').html(cart_show);
                        $('.product_total_input').val(products_total);
                        $('#total_montly_due').html(format2(products_total, "$"));
                        $('#total_enrollment_fees').html(format2(enrollment_fee_total, "$"));
                        var total_due_today = parseFloat(enrollment_fee_total) + parseFloat(products_total);
                        $('#total_due_today').html(format2(total_due_today, "$"));
                        $('.first_payment').val(format2(total_due_today, "$"));

                        $( ".actions .add_to_cart1" ).each(function( index )
                        {
                          if($(this).attr("temp-id") == id)
                          {
                             $(this).replaceWith(remove_link);
                          }
                        });
                    }
                });
            }
        });
        $(document).on('click','.remove_to_cart1',function ()
        {
            var id = $(this).attr("remove-temp-id");
            var product_id = $(this).attr("temp-id");
            var enrollment_fee = $(this).attr('enrollment_fee');
            var company_name = $(this).attr('company_name');
            var url_link = '<?php echo site_url("add_to_cart/remove_cart") ?>';
            if(id != "")
            {
                $.ajax({
                    url : url_link,
                    method : 'post',
                    async : false,
                    data : {data : id,temp_cart : 'temp_product',company_name : company_name},
                    success : function(str)
                    {
                        var obj = $.parseJSON(str);
                        var cart_product_count = obj.count;
                        var americo_product = obj.Americo;
                        var enrollment_fee_total = obj.enrollment_fee_total;
                        add_to_cart_link  = '<a class="btn btn-default btn-sm add_to_cart1" company_name="'+company_name+'" enrollment_fee="'+enrollment_fee+'" temp-id="'+product_id+'" href="javascript:;"> Apply <i class="fa fa-shopping-cart"></i></a>';
                        //$(this).replaceWith(add_to_cart_link);
                        var cart_show = '<a class="btn btn-default btn-sm add_to_cart_show" href="javascript:;"> <i class="fa fa-shopping-cart"></i> Cart '+cart_product_count+' </a>';
                        var products_total = obj.total;
                        $('.cart_show').html(cart_show);
                        $('.product_total_input').val(products_total);
                        $('#total_montly_due').html(format2(products_total, "$"));
                        $('#total_enrollment_fees').html(format2(enrollment_fee_total, "$"));
                        var total_due_today = parseFloat(enrollment_fee_total) + parseFloat(products_total);
                        $('#total_due_today').html(format2(total_due_today, "$"));
                        $('.first_payment').val(format2(total_due_today, "$"));

                        $( ".actions .remove_to_cart1" ).each(function( index )
                        {
                          if($(this).attr("temp-id") == product_id)
                          {
                             $(this).replaceWith(add_to_cart_link);
                          }
                        });
                    }
                });
            }
        });

        $(document).on("change","#app_height-feet",function()
        {
            $('#app_height-Inches,#app_weight').val('');
            height_check();
        });

        $(document).on("change","#app_height-Inches",function()
        {
            $('#app_weight').val('');
            height_check();
        });

        $(document).on("change","#app_weight",function()
        {
            weight_check();
        });

        $('[name="bank_country"],[name="billing_country"],[name="app_birth_country"]').change(function()
        {
            var cid = $(this).val();
            var country_nm = $(this).attr('name');
            var url_link = '<?php echo site_url("customer/manage_state/getByCountryId") ?>'+'/'+cid;
            $.ajax({
                url : url_link,
                method : 'get',
                async : false,
                success : function(str)
                {
                    if(country_nm == "bank_country")
                    {
                        $('#bank_state_list').html(str);
                        $('#bank_city_list').html('');
                        var bank_state_id = '<?php echo isset($customer) ? $customer->bank_state_id : '' ?>';
                        if(bank_state_id != "" && bank_state_id !=0)
                        {
                            $("#bank_state_list option" ).each(function(index)
                            {
                               if($(this).val() == bank_state_id)
                               {
                                    $(this).attr('selected','selected');
                               }
                            });
                        }
                    }
                    if(country_nm == "billing_country")
                    {
                        $('#billing_state_list').html(str);
                        $('#billing_city_list').html('');
                        var card_state_id = '<?php echo isset($customer) ? $customer->card_state_id : '' ?>';
                        if(card_state_id != "" && card_state_id !=0)
                        {
                            $("#billing_state_list option" ).each(function(index)
                            {
                               if($(this).val() == card_state_id)
                               {
                                    $(this).attr('selected','selected');
                               }
                            });
                        }
                    }
                    if(country_nm == "app_birth_country")
                    {
                        $('#app_birth_state_list').html(str);
                        var birth_state_id = '<?php echo isset($customer) ? $customer->app_birth_state_id : '' ?>';
                        if(birth_state_id != "" && birth_state_id !=0)
                        {
                            $("#app_birth_state_list option" ).each(function(index)
                            {
                               if($(this).val() == birth_state_id)
                               {
                                    $(this).attr('selected','selected');
                               }
                            });
                        }
                    }
                }
            });
        });

        $('[name="bank_state"],[name="billing_state"]').change(function()
        {
            var sid = $(this).val();
            var state_nm = $(this).attr('name');
            var url_link = '<?php echo site_url("customer/manage_city/getByStateId") ?>'+'/'+sid;
            $.ajax({
                url : url_link,
                method : 'get',
                async : false,
                success : function(str)
                {
                    if(state_nm == "bank_state")
                    {
                        $('#bank_city_list').html(str);
                        var bank_city_id = '<?php echo isset($customer) ? $customer->bank_city_id : '' ?>';
                        if(bank_city_id != "" && bank_city_id !=0)
                        {
                            $("#bank_city_list option" ).each(function(index)
                            {
                               if($(this).val() == bank_city_id)
                               {
                                    $(this).attr('selected','selected');
                               }
                            });
                        }
                    }
                    if(state_nm == "billing_state")
                    {
                        $('#billing_city_list').html(str);
                        var card_city_id = '<?php echo isset($customer) ? $customer->card_city_id : '' ?>';
                        if(card_city_id != "" && card_city_id !=0)
                        {
                            $("#billing_city_list option" ).each(function(index)
                            {
                               if($(this).val() == card_city_id)
                               {
                                    $(this).attr('selected','selected');
                               }
                            });
                        }
                    }
                }
            });
        });

        $('[name="dob"]').focusout(function()
        {
            var cid = $(this).val();
            var url_link = '<?php echo site_url("others/getage") ?>';
            $.ajax({
                url : url_link,
                type : 'POST',
                async : false,
                data : { data : cid },
                success : function(str)
                {
                    if(parseInt(str) > 0)
                    {
                        $('#age').val(str);
                        $('#app_dob').val(cid);
                        $('#app_age').val(str);
                        callAllFilterValue();
                        /*var state = $('#state').val();
                        var age = $('#age').val();
                        if(state != "" && age != "" && parseInt(age) > 0)
                        {
                            var url_link1 = '<?php echo site_url("products/getProducts/getByStateAndAge/") ?>';
                            $.ajax({
                                url : url_link1,
                                method : 'post',
                                async : false,
                                data : {data : state,data1 : age},
                                success : function(str)
                                {
                                    $(".product-list").html(str);
                                    clearCart();
                                }
                            });
                        }
                        else
                        {
                            var url_link1 = '<?php echo site_url("products/getProducts/getByAge/") ?>';
                            if(parseInt(age) > 0)
                            {
                                $.ajax({
                                    url : url_link1,
                                    method : 'post',
                                    async : false,
                                    data : {data : age},
                                    success : function(str)
                                    {
                                        $(".product-list").html(str);
                                        clearCart();
                                    }
                                });
                            }
                        }*/
                    }
                    else
                    {
                        $('#age').val('');
                    }
                }
            });
        });

        $('[name="zip"]').focusout(function()
        {
            var explode = function()
            {
                callAllFilterValue();
                /*var state = $('#state').val();
                var age = $('#age').val();
                if(state != "" && age != "" && parseInt(age) > 0)
                {
                    var url_link = '<?php echo site_url("products/getProducts/getByStateAndAge/") ?>';
                    $.ajax({
                        url : url_link,
                        method : 'post',
                        async : false,
                        data : {data : state,data1 : age},
                        success : function(str)
                        {
                            $(".product-list").html(str);
                            clearCart();
                        }
                    });
                }
                else
                {
                    var url_link = '<?php echo site_url("products/getProducts/getByState/") ?>';
                    $.ajax({
                        url : url_link,
                        method : 'post',
                        async : false,
                        data : {data : state},
                        success : function(str)
                        {
                            $(".product-list").html(str);
                            clearCart();
                        }
                    });
                }*/
            };
            setTimeout(explode, 500);
        });

        $('[name="pre_exist_condition"]').change(function()
        {
            callAllFilterValue();
            /*var plan_type = $("#plan_type").val();
            var pre_exist_condition = $(this).val();
            var state = $('#state').val();
            var age = $('#age').val();

            if(plan_type != "" && pre_exist_condition != "" && state != "" && age != "" && parseInt(age) > 0)
            {
                getByPlantype(plan_type,pre_exist_condition,state,age);
            }
            else if(pre_exist_condition != "" && state != "" && age != "" && parseInt(age) > 0)
            {
                getByPreexistconditon(pre_exist_condition,state,age);
            }*/
        });

        $('[name="app_dob"]').focusout(function()
        {
            var cid = $(this).val();
            var url_link = '<?php echo site_url("others/getage") ?>';
            $.ajax({
                url : url_link,
                type : 'POST',
                async : false,
                data : { data : cid },
                success : function(str)
                {
                    $('#app_age').val(str);
                }
            });
        });

		$('#payment').change(function(){
			if($(this).val() == 1)
			{
				$('#bank_container').removeClass('hide_it');
				$('#bank_container').addClass('show_up');
				$('#card_container').addClass('hide_it');
			}
			else
			{
				$('#card_container').removeClass('hide_it');
				$('#card_container').addClass('show_up');
				$('#bank_container').addClass('hide_it');
			}
		});

	    /* start Add more additional members */
	    $("#btnAdd").bind("click", function ()
	    {
			/*if($('[name="amfname[]"]').val() != "" || $('[name="ammname[]"]').val() != "" || $('[name="amlname[]"]').val() != "")
			{*/
				ambirth_state_list_id = ambirth_state_list_id + 1;
                increment_value = increment_value + 1;
				var div = $("<div class='additional_mem'/>");
				div.html(GetDynamicTextBox(ambirth_state_list_id,increment_value));
				$(".additional_members").append(div);
                 $('.date-picker').datepicker({
                    rtl: App.isRTL(),
                    orientation: "left",
                    format: 'mm/dd/yyyy',
                    autoclose: true
                });
                $(".mask_date2").inputmask("m/d/y",{
                    "placeholder": "mm/dd/yyyy"
                });
                $(".mask_ssn").inputmask("999-99-9999",{
                    placeholder: " ",
                    clearMaskOnLostFocus: true
                });
			//}
		});

		$("body").on("click", ".remove", function ()
		{
			$(this).closest("div").remove();
		});

		/* end Add more additional members */

		$("#bebtnAdd").bind("click", function ()
	    {
			/*if($('[name="befname[]"]').val() != "" || $('[name="bemname[]"]').val() != "" || $('[name="belname[]"]').val() != "")
			{*/
				bebirth_state_list_id = bebirth_state_list_id + 1;
                benifi_value = benifi_value + 1;
				var div1 = $("<div class='additional_mem' />");
				div1.html(GetDynamicTextBox1(bebirth_state_list_id,benifi_value));
				$(".beneficiaries").append(div1);
                $('.date-picker').datepicker({
                    rtl: App.isRTL(),
                    orientation: "left",
                    format: 'mm/dd/yyyy',
                    autoclose: true
                });
                $(".mask_date2").inputmask("m/d/y",{
                    "placeholder": "mm/dd/yyyy"
                });
                $(".mask_ssn").inputmask("999-99-9999",{
                    placeholder: " ",
                    clearMaskOnLostFocus: true
                });
                $("[name^=befname]").each(function () {
                   $(this).rules("add", {
                       required: true,
                       lettersonly: true
                   });
                });
                $(".mask_phone").inputmask("mask", {
                    "mask": "(999) 999-9999"
                });
                $("[name^=bemname]").each(function () {
                   $(this).rules("add", {
                       lettersonly: true
                   });
                });

                $("[name^=belname]").each(function () {
                   $(this).rules("add", {
                       required: true,
                       lettersonly: true
                   });
                });

                 $("[name^=besoc_sec_number]").each(function () {
                   $(this).rules("add", {
                       required: false
                   });
                });

                  $("[name^=berelationship]").each(function () {
                   $(this).rules("add", {
                       required: true
                   });
                });

                $("[name^=bedob]").each(function () {
                   $(this).rules("add", {
                       required: true
                   });
                });

                $("[name^=bephone_number]").each(function () {
                   $(this).rules("add", {
                       required: false
                   });
                });

                $("[name^=beemail]").each(function () {
                   $(this).rules("add", {
                       required: false
                   });
                });

                $("[name^=beper_of_share]").each(function () {
                   $(this).rules("add", {
                       required: true
                   });
                });
			//}
		});

		$("body").on("click", ".remove1", function ()
		{
			$(this).closest("div").remove();
		});

		$('#estate').change(function()
		{
			if($(this).is(":checked"))
			{
				$(".beneficiaries").hide();
				$(".individual_type").hide();
                $('#primary:checked').removeAttr('checked');
                $('#contingent:checked').removeAttr('checked');
			}
			else
			{
				$(".individual_type").show();
			}

		});

		$('#individual').change(function()
		{
			if($(this).is(":checked"))
			{
				$(".individual_type").show();
			}
			else
			{
				$(".individual_type").hide();
			}

		});
		$(".beneficiaries").hide();
        $(".individual_type").hide();
	    $('#primary').change(function()
		{
			if($(this).is(":checked"))
			{
				$(".beneficiaries").show();
                //$(".beneficiaries .form-actions").hide();
			}
			else
			{
				$(".beneficiaries").hide();
                //$(".beneficiaries .form-actions").hide();
			}

		});

        $('#contingent').change(function()
        {
            if($(this).is(":checked"))
            {
                $(".beneficiaries").show();
                //$(".beneficiaries .form-actions").show();
            }
            else
            {
                $(".beneficiaries").hide();
                //$(".beneficiaries .form-actions").hide();
            }

        });

		function GetDynamicTextBox(ambirth_state_list_id,increment_value)
		{
			var country_list = "<?php echo $bith_country ?>";
			return '<input type="hidden" name="amid['+increment_value+']" value=""/>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3 amfirstname">First Name</label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control amfname" name="amfname['+increment_value+']" />'
                            +'<span class="help-block">Provide first name</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3 ammiddlename">Middle Name</label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control ammname" name="ammname['+increment_value+']" />'
                            +'<span class="help-block">Provide middle name</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3 amlastname">Last Name</label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control amlname" name="amlname['+increment_value+']" />'
                            +'<span class="help-block">Provide last name</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3 amssn">Social Security Number</label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control amsoc_sec_number mask_ssn soc_sec_number_mask" name="amsoc_sec_number['+increment_value+']" />'
                            +'<span class="help-block">Provide social security number</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3 amrela">Relationship</label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control amrelationship" name="amrelationship['+increment_value+']" />'
                            +'<span class="help-block">Provide relationship</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3 amdob">Date of Birth</label>'
                        +'<div class="col-md-4">'
                            +'<input class="form-control mask_date2 form-control-inline date-picker amdob" name="amdob['+increment_value+']" size="16" type="text" />'
                            +'<span class="help-block">Provide date of birth</span>'
                        +'</div>'
                    +'</div>'
                    +'<span class="form-actions">'
                        +'<span class="row">'
                            +'<span class="col-md-offset-3 col-md-9">'
                                +'<a href="javascript:;" name="remove-attr['+increment_value+']" remove-am-id="" class="remove-am-class remove btn btn-outline green"> Remove </a>'
                            +'</span>'
                        +'</span>'
                    +'</span>';
		}

		function GetDynamicTextBox1(bebirth_state_list_id,benifi_value)
		{
			var country_list = "<?php echo $bith_country ?>";
			return '<input type="hidden" name="beid['+benifi_value+']" value=""/>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3">First Name <span class="required"> * </span></label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control" name="befname['+benifi_value+']" />'
                            +'<span class="help-block">Provide first name</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3">Middle Name</label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control" name="bemname['+benifi_value+']" />'
                            +'<span class="help-block">Provide middle name</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3">Last Name <span class="required"> * </span></label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control" name="belname['+benifi_value+']" />'
                            +'<span class="help-block">Provide last name</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3">Social Security Number</label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control mask_ssn soc_sec_number_mask" name="besoc_sec_number['+benifi_value+']" />'
                            +'<span class="help-block">Provide social security number</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3">Relationship <span class="required"> * </span></label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control" name="berelationship['+benifi_value+']" />'
                            +'<span class="help-block">Provide relationship</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3">Date of Birth <span class="required"> * </span></label>'
                        +'<div class="col-md-4">'
                            +'<input class="form-control form-control-inline date-picker mask_date2" name="bedob['+benifi_value+']" size="16" type="text"/>'
                            +'<span class="help-block">Provide date of birth</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3">Phone Number</label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control phone_number mask_phone" name="bephone_number['+benifi_value+']" />'
                            +'<span class="help-block">Provide phone number (XXX) XXX-XXXX</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3">Email Address</label>'
                        +'<div class="col-md-4">'
                            +'<input type="email" class="form-control" name="beemail['+benifi_value+']" />'
                            +'<span class="help-block"> Provide email address</span>'
                        +'</div>'
                    +'</div>'
                    +'<div class="form-group">'
                        +'<label class="control-label col-md-3"> % of Share <span class="required"> * </span></label>'
                        +'<div class="col-md-4">'
                            +'<input type="text" class="form-control percent" name="beper_of_share['+benifi_value+']" />'
                            +'<span class="help-block"> Provide % of Share</span>'
                        +'</div>'
                    +'</div>'
                    +'<span class="form-actions">'
                        +'<span class="row">'
                            +'<span class="col-md-offset-3 col-md-9">'
                                +'<a href="javascript:;" name="remove-attr-be['+benifi_value+']" remove-be-id="" class="remove-be-class remove1 btn btn-outline green"> Remove </a>'
                            +'</span>'
                        +'</span>'
                    +'</span>';
		}

		$('[name="zip"],[name="app_zip"],[name="app_another_zip"]').change(function()
        {
			var change_name = $(this).attr('name');
            if(change_name == "zip")
            {
                var zipcode = $(this).val();
                var city_name = "#city";
                var state_name = "#state";
            }
            else if(change_name == "app_zip")
            {
                var zipcode = $(this).val();
                var city_name = "#app_city";
                var state_name = "#app_state";
            }
            else if(change_name == "app_another_zip")
            {
                var zipcode = $(this).val();
                var city_name = "#app_another_city";
                var state_name = "#app_another_state";
            }
			getAddressInfoByZip(zipcode,city_name,state_name);
        });

		function response(obj)
		{
		  console.log(obj);
		}

		function getAddressInfoByZip(zip,city_name,state_name)
		{
		  if(zip.length >= 5 && typeof google != 'undefined')
		  {
			var addr = {};
			var geocoder = new google.maps.Geocoder();
			geocoder.geocode({ 'address': zip }, function(results, status)
			{
			  if (status == google.maps.GeocoderStatus.OK)
			  {
				if (results.length >= 1)
				{
					for (var ii = 0; ii < results[0].address_components.length; ii++)
					{
						var street_number = route = street = city = state = zipcode = country = formatted_address = '';
						var types = results[0].address_components[ii].types.join(",");
						if (types == "street_number")
						{
							addr.street_number = results[0].address_components[ii].long_name;
						}
						if (types == "route" || types == "point_of_interest,establishment")
						{
							addr.route = results[0].address_components[ii].long_name;
						}
						if (types == "sublocality,political" || types == "locality,political" || types == "neighborhood,political" || types == "administrative_area_level_3,political")
						{
							addr.city = (city == '' || types == "locality,political") ? results[0].address_components[ii].long_name : city;
						}
						if (types == "administrative_area_level_1,political")
						{
							//addr.state = results[0].address_components[ii].short_name;
							addr.state = results[0].address_components[ii].long_name;
						}
						if (types == "postal_code" || types == "postal_code_prefix,postal_code")
						{
							addr.zipcode = results[0].address_components[ii].long_name;
						}
						if (types == "country,political")
						{
							addr.country = results[0].address_components[ii].long_name;
						}
					}
					addr.success = true;
					for (name in addr)
					{
						if(name == "city")
						{
							if(city_name == "#city")
                            {
                                $(city_name).val(addr[name]);
                            }
                            else if(city_name == "#app_city")
                            {
                                $(city_name).val(addr[name]);
                            }
                            else if(city_name == "#app_another_city")
                            {
                                $(city_name).val(addr[name]);
                            }
						}
						else if(name == "state")
						{

                            if(state_name == "#state")
                            {
                                $(state_name).val(addr[name]);
                            }
                            else if(state_name == "#app_state")
                            {
                                $(state_name).val(addr[name]);
                            }
                            else if(state_name == "#app_another_state")
                            {
                                $(state_name).val(addr[name]);
                            }
						}
					}
					//response(addr);
				}
				else
				{
				  response({success:false});
				}
			  }
			  else
			  {
				response({success:false});
			  }
			});
		  }
		  else
		  {
			response({success:false});
		  }
		}

		$('[name="fname"],[name="mname"],[name="lname"],[name="gender"],[name="zip"],[name="phone_number"],[name="email"],[name="app_how_to_long"]').change(function()
		{
            var change_name = $(this).attr('name');
            if(change_name == "fname")
            {
                var fname = $(this).val();
                $('#app_fname').val(fname);
            }
            else if(change_name == "mname")
            {
                var mname = $(this).val();
                $('#app_mname').val(mname);
            }
            else if(change_name == "lname")
            {
                var lname = $(this).val();
                $('#app_lname').val(lname);
            }
            else if(change_name == "gender")
            {
                var gender = $(this).val();
                if(gender == "male")
                {
                    $( '#app_male' ).trigger( "click" );
                }
                else
                {
                    $( '#app_female' ).trigger( "click" );
                }
            }
            else if(change_name == "zip")
            {
                var zip = $(this).val();
                $('#app_zip').val(zip);
                function explode()
                {
                    var city = $('#city').val();
                    var state = $('#state').val();
                    $('#app_city').val(city);
                    $('#app_state').val(state);
                }
                setTimeout(explode, 500);
            }
            else if(change_name == "phone_number")
            {
                var phone_number = $(this).val();
                $('#app_phone_number').val(phone_number);
            }
            else if(change_name == "email")
            {
                var email = $(this).val();
                $('#app_email').val(email);
            }
            else if(change_name == "app_how_to_long")
            {
                var app_how_to_long = $(this).val();

                if(app_how_to_long < 5 && app_how_to_long != "" && app_how_to_long > 0)
                {
                    $(".another_address").show();
                }
                else
                {
                    $(".another_address").hide();
                }
            }
		});

		$(".another_address").hide();

        $(".side").sidecontent();
        $(".side1").sidecontent();

        $('[name="plan_type"]').change(function()
        {
            var plan_type = $(this).val();
            if(plan_type == "single")
            {
                $('.family-add').hide();
                $('.additional_mem').remove();
                $('input[name="amfname[0]"],input[name="ammname[0]"],input[name="amlname[0]"],input[name="amsoc_sec_number[0]"],input[name="amrelationship[0]"],input[name="amdob[0]"]').attr("disabled","true");
                $('input[name="amfname[0]"],input[name="ammname[0]"],input[name="amlname[0]"],input[name="amsoc_sec_number[0]"],input[name="amrelationship[0]"],input[name="amdob[0]"]').val('');
                $('.additional_members .form-actions').hide();
                additional_members_remove_reuired_fields();
                clear_on_change_plan_type();
            }
            else if(plan_type == "single_spouse")
            {
                $('.family-add').hide();
                $('input[name="amfname[0]"],input[name="ammname[0]"],input[name="amlname[0]"],input[name="amsoc_sec_number[0]"],input[name="amrelationship[0]"],input[name="amdob[0]"]').removeAttr("disabled");
                $('.additional_members .form-actions').show();
                additional_members_add_reuired_fields();
                clear_on_change_plan_type();
            }
            else if(plan_type == "single_child")
            {
                $('.family-add').hide();
                $('.additonal_action').hide();
                $('.famlily_action').show();
                $('input[name="amfname[0]"],input[name="ammname[0]"],input[name="amlname[0]"],input[name="amsoc_sec_number[0]"],input[name="amrelationship[0]"],input[name="amdob[0]"]').removeAttr("disabled");
                $('.additional_members .form-actions').show();
                additional_members_add_reuired_fields();
                clear_on_change_plan_type();
            }
            else if(plan_type == "family")
            {
                $('.family-add').show();
                increment_value = increment_value =  + 1;
                $('input[name="amfname[0]"],input[name="ammname[0]"],input[name="amlname[0]"],input[name="amsoc_sec_number[0]"],input[name="amrelationship[0]"],input[name="amdob[0]"]').removeAttr("disabled");
                $('.additional_members .form-actions').show();
                additional_members_add_reuired_fields();
                clear_on_change_plan_type();
            }

            callAllFilterValue();

            /*var pre_exist_condition = $("[name='pre_exist_condition']:checked").val();
            var state = $('#state').val();
            var age = $('#age').val();

            if(plan_type != "" && pre_exist_condition != "" && state != "" && age != "" && parseInt(age) > 0)
            {
                getByPlantype(plan_type,pre_exist_condition,state,age);
            }
            else if(pre_exist_condition != "" && state != "" && age != "" && parseInt(age) > 0)
            {
                getByPreexistconditon(pre_exist_condition,state,age);
            }*/
        });

        $("[name^=befname],[name^=belname]").each(function () {
           $(this).rules("add", {
               required: true,
               lettersonly: true
           });
        });

        $("[name^=bemname]").each(function () {
           $(this).rules("add", {
               lettersonly: true
           });
        });

        $("[name^=besoc_sec_number],[name^=bephone_number],[name^=beemail]").each(function ()
         {
           $(this).rules("add", {
               required: false
           });
        });

        $("[name^=berelationship],[name^=bedob],[name^=beper_of_share]").each(function () {
           $(this).rules("add", {
               required: true
           });
        });

        $('.fancybox').fancybox();

        $(document).on('click','.products_details',function ()
        {
            var id = $(this).attr('data-id');
             $('.fancy_open_'+id).trigger("click");
        });

        $(".nav-justified.steps li a").click(function()
        {
            var current_tab = $('.tab-pane.active').attr('id').replace('tab', '');
            var move_tab = $(this).attr('href').replace('#tab', '');
            var click_number = current_tab - move_tab;
            for (i = 1; i <= click_number; i++)
              {
                $('.form-actions .button-previous').trigger('click');
              }
        });

        $('.click_new_product').click(function(){
            $('body').addClass('overh');
        });
        $('.modal-header .close').click(function(){
            $('body').removeClass('overh');
            $("#add_new_product_form .btn.btn-secondary-outline").trigger('click');
        });

        $.validator.addMethod("currency", function(value, element)
        {
           if(value == "US$ ")
           {
                return false;
           }
           else
           {
                return true;
           }
        }, "This field is required.");
        $.validator.addMethod("percentage", function(value, element)
        {
           if(value.replace("%", "") > 100)
           {
                return false;
           }
           else
           {
                return true;
           }
        }, "Please enter value less then or equal to 100.");

        $("#add_new_product_form").validate({
            doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false,
            rules: {
                "product_category":
                {
                    required: true,
                },
                "add_product_name":
                {
                    required : true
                },
                "add_product_levels":
                {
                    required : true
                },
                "add_underwriting_company":
                {
                    required : true
                },
                "add_plan_type":
                {
                    required : true
                },
                "add_product_price":
                {
                    required : true,
                    currency : true
                },
                "add_enrollment_fee":
                {
                    required : true,
                    currency : true
                },
                "add_monthly_payment":
                {
                    required : true,
                    currency : true
                },
                "add_coinsurance":{
                    percentage: true,
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            }
        });

        $( "#add_new_product_form" ).submit(function(event)
        {
               event.preventDefault();
               if($("[name^='add_product_name']").val() == "")
               {
                    return false;
               }
               if($("[name^='add_underwriting_company']").val() == "")
               {
                    return false;
               }
                if($("[name^='add_product_levels']").val() == "")
               {
                    return false;
               }

               if($("[name^='add_product_price']").val() == "US$ ")
               {
                    return false;
               }

               if($("[name^='add_plan_type']").val() == "")
               {
                    return false;
               }

               if($("[name^='add_enrollment_fee']").val() == "")
               {
                    return false;
               }

               if($("[name^='add_monthly_payment']").val() == "")
               {
                    return false;
               }
                var url_link = '<?php echo site_url("products/manage_agent_product/add") ?>';
                $.ajax({
                    url : url_link,
                    method : 'post',
                    async : false,
                    data : $("#add_new_product_form").serialize(),
                    success : function(str)
                    {
                        $('.product-list .row').append(str);
                        $('#myModal').modal('hide');
                        $("#add_new_product_form .btn.btn-secondary-outline").trigger('click');
                    }
                });

        });

        $(window).scroll(function()
        {
            if ($(this).scrollTop() > 1)
            {
                $('.sidecontentpullout').addClass("sticky");
                $('.sidecontent').addClass("sticky");
            }
            else
            {
                $('.sidecontentpullout').removeClass("sticky");
                $('.sidecontent').removeClass("sticky");
            }
        });

        /*  Edit Customer jQuery */
        var gender_value = '<?php echo isset($customer->gender) ? $customer->gender : '' ?>';
        if(gender_value != "")
        {
            if($('#male').val() == gender_value)
            {
                $('#male').trigger('click');
            }
            else
            {
                $('#female').trigger('click');
            }
        }
        var date_of_birth = '<?php echo isset($customer->date_of_birth) ? $customer->date_of_birth : '' ?>';
        if(date_of_birth != "" && date_of_birth != "0000-00-00")
        {
            $('#dob').trigger('focusout');
        }
        var pre_existing_condition = '<?php echo isset($customer->customer_plan->pre_existing_condition) ?  $customer->customer_plan->pre_existing_condition : '' ?>';
        if(pre_existing_condition != "")
        {
            if($('#pre_exist_condition_yes').val() == pre_existing_condition)
            {
                $('#pre_exist_condition_yes').trigger('click');
            }
            else
            {
                $('#pre_exist_condition_no').trigger('click');
            }
        }
        var use_tobacco = '<?php echo isset($customer) ? $customer->customer_plan->use_tobacco : '' ?>';
        if(use_tobacco != "")
        {
            if($('#use_tobacco_yes').val() == use_tobacco)
            {
                $('#use_tobacco_yes').trigger('click');
            }
            else
            {
                $('#use_tobacco_no').trigger('click');
            }
        }
        var plan_type = '<?php echo isset($customer) ? $customer->customer_plan->plan_type : '' ?>';
        if(plan_type != "")
        {
            $('#plan_type').trigger('change');
        }
        var app_marital_status = '<?php echo isset($customer) ? $customer->app_marital_status : '' ?>';
        if(app_marital_status != "")
        {
            if($('#app_single').val() == app_marital_status)
            {
                $('#app_single').trigger('click');
            }
            else
            {
                $('#app_married').trigger('click');
            }
        }
        var app_gender = '<?php echo isset($customer->app_gender) ?  $customer->app_gender : '' ?>';
        if(app_gender != "")
        {
            if($('#app_male').val() == app_gender)
            {
                $('#app_male').trigger('click');
            }
            else
            {
                $('#app_female').trigger('click');
            }
        }
        var app_how_long_address = '<?php echo isset($customer) ? $customer->app_how_long_address : '' ?>';
        if(app_how_long_address != "" && app_how_long_address != "NULL")
        {
            $('#app_how_to_long').trigger('change');
        }
        var app_date_of_birth = '<?php echo isset($customer) ? $customer->app_date_of_birth : '' ?>';
        if(app_date_of_birth != "")
        {
            $('#app_dob').trigger('focusout');
        }
        var birth_country = '<?php echo isset($customer) ? $customer->birth_country : '' ?>';
        if(birth_country != "" && birth_country != 0)
        {
            $('#app_birth_country').trigger('change');
        }
        var app_is_us_citizen = '<?php echo isset($customer) ? $customer->app_is_us_citizen : '' ?>';
        if(app_is_us_citizen != "")
        {
            if($('#app_us_citizen_yes').val() == app_is_us_citizen)
            {
                $('#app_us_citizen_yes').trigger('click');
            }
            else
            {
                $('#app_us_citizen_no').trigger('click');
            }
        }
        var app_is_employed = '<?php echo isset($customer) ? $customer->app_is_employed : '' ?>';
        if(app_is_employed != "")
        {
            if($('#app_employed_yes').val() == app_is_employed)
            {
                $('#app_employed_yes').trigger('click');
            }
            else
            {
                $('#app_employed_no').trigger('click');
            }
        }
        var additional_members = <?php echo json_encode( isset($customer) ? $customer->additional_members : '' ) ?>;
        var plan_type = '<?php echo isset($customer) ? $customer->customer_plan->plan_type : '' ?>';
        var ccid = '<?php echo isset($customer) ? $customer->customer_id : ''; ?>';
        if(plan_type == "single")
        {
            if(ccid != "")
            {
                var url_link = '<?php echo site_url("customer/remove_customer_additional_members") ?>'+'/'+ccid;
                $.ajax({
                    url : url_link,
                    method : 'post',
                    async : false,
                    success : function(str)
                    {

                    }
                });
            }
        }
        else if(plan_type == "single_spouse")
        {
            edit_customer_plan_single_spouse_and_single_child(additional_members);
        }
        else if(plan_type == "single_child")
        {
            edit_customer_plan_single_spouse_and_single_child(additional_members);
        }
        else if(plan_type == "family")
        {
            edit_customer_plan_family(additional_members);
        }
        var beneficiaries_type = '<?php echo isset($customer) ? $customer->beneficiaries_type : '' ?>';
        if(beneficiaries_type != "")
        {
            if($('#estate').val() == beneficiaries_type)
            {
                $('#estate').trigger('click');
            }
            else
            {
                $('#individual').trigger('click');
            }
        }
        var individual_type = '<?php echo isset($customer) ? $customer->individual_type : '' ?>';
        if(individual_type != "")
        {
            if($('#primary').val() == individual_type)
            {
                $('#primary').trigger('click');
            }
            else
            {
                $('#contingent').trigger('click');
            }
        }
        var customer_beneficiaries = <?php echo json_encode( isset($customer) ? $customer->customer_beneficiaries : '' ) ?>;
        if(customer_beneficiaries !="" && customer_beneficiaries != null)
        {
            for (i = 1; i < customer_beneficiaries.length; i++)
            {
                $('#bebtnAdd').trigger('click');
            }

            $.each( customer_beneficiaries, function( i, val )
            {
                $('[name="remove-attr-be['+i+']"]').attr('remove-be-id',val['id']);
                $('input[name="beid['+i+']"]').val(val['id']);
                $('input[name="befname['+i+']"]').val(val['be_fname']);
                $('input[name="bemname['+i+']"]').val(val['be_mname']);
                $('input[name="belname['+i+']"]').val(val['be_lname']);
                $('input[name="besoc_sec_number['+i+']"]').val(val['be_social_sec_number']);
                $('input[name="berelationship['+i+']"]').val(val['be_relationship']);
                var be_date_of_birth = val['be_date_of_birth'].split("-");
                $('input[name="bedob['+i+']"]').val(be_date_of_birth[2]+'/'+be_date_of_birth[1]+'/'+be_date_of_birth[0]);
                $('input[name="bephone_number['+i+']"]').val(val['be_phone_number']);
                $('input[name="beemail['+i+']"]').val(val['be_email']);
                $('input[name="beper_of_share['+i+']"]').val(val['be_per_of_share']);
            });
        }

        var bank_name = '<?php echo isset($customer) ? $customer->bank_name : '' ?>';
        if(bank_name != "")
        {
            $('#payment').trigger('change');
        }
        else
        {
            $('#payment').trigger('change');
        }
        var bank_country = '<?php echo isset($customer) ? $customer->bank_country : '' ?>';
        if(bank_country != "" && bank_country != 0)
        {
            $('#bank_country').trigger('change');
        }
        var bank_state = '<?php echo isset($customer) ? $customer->bank_state : '' ?>';
        if(bank_state != "" && bank_state != 0)
        {
            $('#bank_state_list').trigger('change');
        }

        var card_country = '<?php echo isset($customer) ? $customer->card_country :'' ?>';
        if(card_country != "" && card_country != 0)
        {
            $('#billing_country').trigger('change');
        }
        var card_state = '<?php echo isset($customer) ? $customer->card_state:'' ?>';
        if(card_state != "" && card_state != 0)
        {
            $('#billing_state_list').trigger('change');
        }
        var bill_add_same_resi_add = '<?php echo isset($customer) ? $customer->bill_add_same_resi_add : '' ?>';
        if(bill_add_same_resi_add != "" && bill_add_same_resi_add != 0)
        {
            $('#checkbox8').trigger('click');
        }

        var verification_status = '<?php echo isset($customer) ? $customer->verified_status:'' ?>';
        if(verification_status != "")
        {
            if(verification_status == 1)
            {
                $('#verification_status_verified').trigger('click');
            }
            else
            {
                $('#verification_status_not_verified').trigger('click');
            }
        }
        var customer_products = <?php echo json_encode( isset($customer) ? $customer->products : '' ) ?>;
        if(customer_products != "")
        {
            $.each( customer_products, function( i, val )
            {
                $( ".product-list .col-md-3 .add_to_cart" ).each(function(index)
                {
                    if($(this).attr('data-id') == val['product_id'])
                    {
                        $(this).trigger("click");
                    }
                });
                $( ".product-list .col-md-3 .add_to_cart1" ).each(function(index)
                {
                    if($(this).attr('temp-id') == val['temp_product_id'])
                    {
                        $(this).trigger("click");
                    }
                });
            });
        }
        var remove_ids = "";
        $(document).on('click','.remove-am-class',function()
        {
            var remove_id = $(this).attr('remove-am-id');
            if(remove_id != "")
            {
                if($('input[name="remove_members_ids"]').val() == "")
                {
                    $('input[name="remove_members_ids"]').val(remove_id);
                }
                else
                {
                    remove_ids = $('input[name="remove_members_ids"]').val();
                    $('input[name="remove_members_ids"]').val(remove_ids+','+remove_id);
                }
            }
        });

        var remove_be_ids = "";
        $(document).on('click','.remove-be-class',function()
        {
            var remove_id = $(this).attr('remove-be-id');
            if(remove_id != "")
            {
                if($('input[name="remove_beneficiaries_ids"]').val() == "")
                {
                    $('input[name="remove_beneficiaries_ids"]').val(remove_id);
                }
                else
                {
                    remove_be_ids = $('input[name="remove_beneficiaries_ids"]').val();
                    $('input[name="remove_beneficiaries_ids"]').val(remove_be_ids+','+remove_id);
                }
            }
        });
        var agency_value = '<?php echo $this->session->userdata('agency') ?  $this->session->userdata('agency')->id : '' ?>';
        if(agency_value != "")
        {
            $('.product-list .row .col-md-3').first().hide();
        }
        else
        {
            $('.product-list .row .col-md-3').first().show();
        }
        var customer_app_height_feet = "<?php echo isset($customer) ? $customer->app_height_feet : '' ?>";
        var customer_app_height_inches = "<?php echo isset($customer) ? $customer->app_height_inches :'' ?>";
        var customer_app_weight = "<?php echo isset($customer) ? $customer->app_weight : '' ?>";
        if(customer_app_height_feet != "")
        {
            $('[name="app_height-feet"]').val(customer_app_height_feet);
        }
        if(customer_app_height_inches != "")
        {
            $('[name="app_height-Inches"]').removeAttr('disabled');
            $('[name="app_height-Inches"]').val(customer_app_height_inches);

        }
        if(customer_app_weight != "")
        {
            $('[name="app_weight"]').removeAttr('disabled');
            $('[name="app_weight"]').val(customer_app_weight);
        }
        function explode4()
        {
            $(".jstree-node .jstree-anchor .jstree-icon").each(function()
            {
                $(this).hide();
            });
        }
        setTimeout(explode4, 500);

        $('.jstree-anchor').click(function() { return false; });
        $(document).on('click','.jstree .jstree-children .jstree-node.jstree-leaf',function()
        {
            callAllFilterValue();
        });
	});
    /*function getByPreexistconditon(pre_exist_condition,state,age)
    {
        var url_link = '<?php echo site_url("products/getProducts/getByPreexistconditon/") ?>';
        $.ajax({
            url : url_link,
            method : 'post',
            async : false,
            data : {data : pre_exist_condition,data1 : state,data2 : age},
            success : function(str)
            {
                $(".product-list").html(str);
                clearCart();
            }
        });
        var customer_id = '<?php echo isset($customer) ? $customer->customer_id  :'' ?>';
        var agent_id = '<?php echo isset($customer) ? $customer->agent_id : '' ?>';
        var verification_agent_id = '<?php echo isset($customer) ? $customer->verification_agent_id : '' ?>';
        var final_agent_id = "";
        if(agent_id != "" && verification_agent_id != "")
        {
            final_agent_id = agent_id+','+verification_agent_id;
        }
        else if(agent_id != "")
        {
            final_agent_id = agent_id;
        }
        else if(verification_agent_id != "")
        {
            final_agent_id = verification_agent_id;
        }

        if(customer_id != "")
        {
            var url_link1 = '<?php echo site_url("products/manage_agent_product/getAll/") ?>';
            $.ajax({
                url : url_link1,
                method : 'post',
                data : {data : final_agent_id},
                async : false,
                success : function(str)
                {
                    $('.product-list .row').append(str);
                }
            });
        }
    }*/

    /*function getByPlantype(plan_type,pre_exist_condition,state,age)
    {
        var url_link = '<?php echo site_url("products/getProducts/getByPlantype/") ?>';
        $.ajax({
            url : url_link,
            method : 'post',
            async : false,
            data : {data : pre_exist_condition,data1 : state,data2 : age,data3 : plan_type},
            success : function(str)
            {
                $(".product-list").html(str);
                clearCart();
            }
        });
        var customer_id = '<?php echo isset($customer) ? $customer->customer_id : '' ?>';
        var agent_id = '<?php echo isset($customer) ? $customer->agent_id : '' ?>';
        var verification_agent_id = '<?php echo isset($customer) ? $customer->verification_agent_id : '' ?>';
        var final_agent_id = "";
        if(agent_id != "" && verification_agent_id != "")
        {
            final_agent_id = agent_id+','+verification_agent_id;
        }
        else if(agent_id != "")
        {
            final_agent_id = agent_id;
        }
        else if(verification_agent_id != "")
        {
            final_agent_id = verification_agent_id;
        }

        if(customer_id != "")
        {
            var url_link1 = '<?php echo site_url("products/manage_agent_product/getAll/") ?>';
            $.ajax({
                url : url_link1,
                method : 'post',
                data : {data : final_agent_id},
                async : false,
                success : function(str)
                {
                    $('.product-list .row').append(str);
                }
            });
        }
    }*/

    function callAllFilterValue()
    {
        var plan_type_filter_array = [];
        var company_filter_array = [];
        var deductible_amount_array = [];
        var maxbenefits_filter_array = [];
        var coinsurance_filter_array = [];
        var obj = {};
        var filter_array = [];
        var plan_type = $('#plan_type').val();
        var pre_exist_condition = $("[name='pre_exist_condition']:checked").val();
        var state = $('#state').val();
        var age = $('#age').val();

        $('#product_type_filter ul.jstree-children li.jstree-node.jstree-leaf').each(function(index){
          if($(this).attr('aria-selected') == "true")
          {
            plan_type_filter_array.push($(this).attr('id'));
          }
        });
        if(plan_type_filter_array.length > 0)
        {
            obj['category_id'] = plan_type_filter_array;
        }

        $('#company_filter ul.jstree-children li.jstree-node.jstree-leaf').each(function(index)
        {
          if($(this).attr('aria-selected') == "true")
          {
            company_filter_array.push($(this).attr('id'));
          }
        });
        if(company_filter_array.length > 0)
        {
            obj['underwriting_company'] = company_filter_array;
        }

        $('#deductible_filter ul.jstree-children li.jstree-node.jstree-leaf').each(function(index)
        {
          if($(this).attr('aria-selected') == "true")
          {
            deductible_amount_array.push($(this).attr('id'));
          }
        });
        if(deductible_amount_array.length > 0)
        {
            obj['deductible_amount'] = deductible_amount_array;
        }

        $('#maxbenefits_filter ul.jstree-children li.jstree-node.jstree-leaf').each(function(index)
        {
          if($(this).attr('aria-selected') == "true")
          {
            maxbenefits_filter_array.push($(this).attr('id'));
          }
        });
        if(maxbenefits_filter_array.length > 0)
        {
            obj['maximum_benefits'] = maxbenefits_filter_array;
        }

        $('#coinsurance_filter ul.jstree-children li.jstree-node.jstree-leaf').each(function(index)
        {
          if($(this).attr('aria-selected') == "true")
          {
            coinsurance_filter_array.push($(this).attr('id'));
          }
        });
        if(coinsurance_filter_array.length > 0)
        {
            obj['coinsurance'] = coinsurance_filter_array;
        }
        filter_array.push(obj);
        if(filter_array.length > 0)
        {
            getByFiltertype(plan_type,pre_exist_condition,state,age,filter_array);
        }
        else
        {
            getByFiltertype(plan_type,pre_exist_condition,state,age,filter_array);
        }

    }
    function getByFiltertype(plan_type,pre_exist_condition,state,age,filter_array)
    {
        var url_link = '<?php echo site_url("products/getProducts/getByFilter/") ?>';
        $.ajax({
            url : url_link,
            method : 'post',
            async : false,
            data : {pre_exist_condition : pre_exist_condition,state : state,age : age,plan_type : plan_type,filter_array : filter_array},
            success : function(str)
            {
                $(".product-list").html(str);
                clearCart();
            }
        });

        var customer_id = '<?php echo isset($customer) ? $customer->customer_id : '' ?>';
        var agent_id = '<?php echo isset($customer) ? $customer->agent_id : '' ?>';
        var verification_agent_id = '<?php echo isset($customer) ? $customer->verification_agent_id  :'' ?>';
        var final_agent_id = "";
        if(agent_id != "" && verification_agent_id != "")
        {
            final_agent_id = agent_id+','+verification_agent_id;
        }
        else if(agent_id != "")
        {
            final_agent_id = agent_id;
        }
        else if(verification_agent_id != "")
        {
            final_agent_id = verification_agent_id;
        }

        if(customer_id != "")
        {
            var url_link1 = '<?php echo site_url("products/manage_agent_product/getAll/") ?>';
            $.ajax({
                url : url_link1,
                method : 'post',
                data : {data : final_agent_id},
                async : false,
                success : function(str)
                {
                    $('.product-list .row').append(str);
                }
            });
        }
    }
    function clearCart()
    {
        var cart_show = '<a class="btn btn-default btn-sm add_to_cart_show" href="javascript:;"> <i class="fa fa-shopping-cart"></i> Cart '+0+' </a>';
        $('.cart_show').html(cart_show);
        $('#total_montly_due').html('$0.00');
        $('#total_enrollment_fees').html('$0.00');
        $('#total_due_today').html('$0.00');
        $('.first_payment').val('$0.00');
    }
    function additional_members_add_reuired_fields()
    {
        $('.amfirstname').html('First Name <span class="required"> * </span>');
        $('.amlastname').html('Last Name <span class="required"> * </span>');
        $('.amssn').html('Social Security Number <span class="required"> * </span>');
        $('.amrela').html('Relationship <span class="required"> * </span>');
        $('.amdob').html('Date of Birth <span class="required"> * </span>');

        $("[name^=amfname]").each(function () {
           $(this).rules("add", {
               required: true,
               lettersonly: true
           });
        });

        $("[name^=ammname]").each(function () {
           $(this).rules("add", {
               lettersonly: true
           });
        });

        $("[name^=amrelationship]").each(function () {
           $(this).rules("add", {
               required: true,
               lettersonly: true
           });
        });

         $("[name^=amlname]").each(function () {
           $(this).rules("add", {
               required: true,
               lettersonly: true
           });
        });

          $("[name^=amsoc_sec_number]").each(function () {
           $(this).rules("add", {
               required: true
           });
        });

        $("[name^=amdob]").each(function () {
           $(this).rules("add", {
               required: true
           });
        });
    }
    function additional_members_remove_reuired_fields()
    {
        $('.amfirstname').html('First Name');
        $('.amlastname').html('Last Name');
        $('.amssn').html('Social Security Number');
        $('.amrela').html('Relationship');
        $('.amdob').html('Date of Birth');

        $("[name^=amfname],[name^=ammname],[name^=amrelationship],[name^=amlname],[name^=amsoc_sec_number],[name^=amdob]").each(function ()
        {
           $(this).val('');
        });
    }
    function clear_on_change_plan_type()
    {
        $("[name^=amfname],[name^=ammname],[name^=amrelationship],[name^=amlname],[name^=amsoc_sec_number],[name^=amdob]").each(function ()
        {
           $(this).val('');
        });
    }
    function edit_customer_plan_single_spouse_and_single_child(additional_members)
    {
        for (i = 1; i < additional_members.length; i++)
        {
            $('#btnAdd').trigger('click');
        }

        $.each( additional_members, function( i, val )
        {
            if(i == 0)
            {

            }
            else
            {
                if(i == 1)
                {
                    i = i + 1;
                }
                else
                {
                    i = i + 1;
                }
            }
            $('[name="remove-attr['+i+']"]').attr('remove-am-id',val['id']);
            $('input[name="amid['+i+']"]').val(val['id']);
            $('input[name="amfname['+i+']"]').val(val['am_fname']);
            $('input[name="ammname['+i+']"]').val(val['am_mname']);
            $('input[name="amlname['+i+']"]').val(val['am_lname']);
            $('input[name="amsoc_sec_number['+i+']"]').val(val['am_social_sec_number']);
            $('input[name="amrelationship['+i+']"]').val(val['am_relationship']);
            var amdob_arr = val['am_date_of_birth'].split("-");
            $('input[name="amdob['+i+']"]').val(amdob_arr[1]+'/'+amdob_arr[2]+'/'+amdob_arr[0]);
        });
    }
    function edit_customer_plan_family(additional_members)
    {
        for (i = 2; i < additional_members.length; i++)
        {
            $('#btnAdd').trigger('click');
        }

        $.each( additional_members, function( i, val )
        {
            $('input[name="amid['+i+']"]').val(val['id']);
            $('input[name="amfname['+i+']"]').val(val['am_fname']);
            $('input[name="ammname['+i+']"]').val(val['am_mname']);
            $('input[name="amlname['+i+']"]').val(val['am_lname']);
            $('input[name="amsoc_sec_number['+i+']"]').val(val['am_social_sec_number']);
            $('input[name="amrelationship['+i+']"]').val(val['am_relationship']);
            var amdob_arr = val['am_date_of_birth'].split("-");
            $('input[name="amdob['+i+']"]').val(amdob_arr[1]+'/'+amdob_arr[2]+'/'+amdob_arr[0]);

        });
    }
    function height_check()
    {
        var height_feet = $('#app_height-feet').val();
        var height_inches = $('#app_height-Inches').val();
        var weight_value = $('#app_weight').val();
        if(height_feet != "" && height_inches == "" && weight_value == "")
        {
            var url = "<?php echo site_url('customer/checkHeight/Feet/') ?>"+'/'+height_feet;
            $.ajax({
             type: 'post',
             url: url,
             success: function (response)
             {
                var return_value = $.parseJSON(response);
                if(return_value['status'] == "false")
                {
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $('.height_main').addClass('has-error');
                    $('#app_height-Inches,#app_weight').attr('disabled','true');
                    $( ".help-block.height-Inches" ).after('<span id="feet-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for height feet. Based on your height feet range needs to fall within ('+return_value["first"]+"-"+return_value["last"]+').</span>');
                    $("#app_height-feet").focus();
                    //$(".button-next").css("pointer-events","none");
                }
                else
                {
                    $('.height_main').removeClass('has-error');
                    $('#app_height-Inches').removeAttr('disabled');
                    $( "#feet-error" ).remove();
                    $("#app_height-Inches").focus();
                    //$(".button-next").css("pointer-events","unset");
                }
             }
           });
        }
        else if(height_feet == "" && height_inches != "" && weight_value == "")
        {
            var url = "<?php echo site_url('customer/checkHeight/Inches/') ?>"+'/'+height_inches;
            $.ajax({
             type: 'post',
             url: url,
             success: function (response)
             {
                var return_value = $.parseJSON(response);
                if(return_value['status'] == "false")
                {
                    $('.height_main').addClass('has-error');
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $('#app_weight').attr('disabled','true');
                    $( ".help-block.height-Inches" ).after('<span id="inches-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for height inches. Based on your height inches range needs to fall within ('+return_value["first"]+"-"+return_value["last"]+').</span>');
                    $("#app_height-Inches").focus();
                    //$(".button-next").css("pointer-events","none");
                }
                else
                {
                    $('.height_main').removeClass('has-error');
                    $( "#inches-error" ).remove();
                    $('#app_weight').removeAttr('disabled');
                    $("#app_weight").focus();
                    //$(".button-next").css("pointer-events","unset");
                }
             }
           });
        }
        else if(height_feet != "" && height_inches != "" && weight_value == "")
        {
            var url = "<?php echo site_url('customer/checkHeight/Both/') ?>";
            $.ajax({
             type: 'post',
             url: url,
             data: {height_feet : height_feet,height_inches : height_inches},
             success: function (response)
             {
                var return_value = $.parseJSON(response);
                if(return_value['remove_products'].length != 0)
                {
                    if(return_value['remove_products'].length > 0)
                    {
                        $('.step.step2').trigger('click');
                        $('#app_height-feet,#app_height-Inches,app_weight').val('');
                        $('#app_height-Inches,#app_weight').attr('disabled','true');

                    }
                    for (var i = 0; i < return_value['remove_products'].length; i++)
                    {
                        $( ".product-list .col-md-3 .portlet-title .actions .remove_to_cart" ).each(function( index )
                        {
                          if($(this).attr('remove-id') == return_value['remove_products'][i])
                          {
                                $(this).trigger('click');
                          }
                        });
                    }
                    for (var i = 0; i < return_value['remove_products_id'].length; i++)
                    {
                        $( ".product-list .col-md-3 .portlet-title .actions .add_to_cart" ).each(function( index )
                        {
                          if($(this).attr('data-id') == return_value['remove_products_id'][i])
                          {
                             $(this).parent('.actions').parent('.portlet-title').parent('.portlet').parent('.col-md-3').remove();
                          }
                        });
                    }
                }
                if(return_value['customer_status'] == "false")
                {
                    $('.height_main').addClass('has-error');
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $( ".help-block.height-Inches" ).after('<span id="height-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for height. Based on your height range needs to fall within ('+return_value["first"]+"-"+return_value["last"]+').</span>');
                    $("#app_height-Inches").focus();
                }
                else if(return_value['status'] == "false")
                {
                    $('.height_main').addClass('has-error');
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    if(return_value['product_name'] != "")
                    {
                        //$( ".help-block.height-Inches" ).after('<span id="height-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for ('+return_value['product_name']+'). Based on your height range needs to fall within ('+return_value["first"]+"-"+return_value["last"]+').</span>');
                        var msg = 'Unfortunately you do not qualify for ('+return_value['product_name']+'). Based on your height range needs to fall within ('+return_value["first"]+"-"+return_value["last"]+').';
                        swal(msg);
                    }
                    //$(".button-next").css("pointer-events","none");
                }
                else
                {
                    $('.height_main').removeClass('has-error');
                    $( "#height-error" ).remove();
                    $('#app_weight').removeAttr('disabled');
                    $("#app_weight").focus();
                    //$(".button-next").css("pointer-events","unset");
                }
             }
           });
        }
    }
    function weight_check()
    {
        var weight_value = $('#app_weight').val();
        var height_feet = $('#app_height-feet').val();
        var height_inches = $('#app_height-Inches').val();
        if(weight_value != "" && height_feet == "" && height_inches == "")
        {
            var url = "<?php echo site_url('customer/checkWeight/checkweight') ?>"+'/'+weight_value;
            $.ajax({
             type: 'post',
             url: url,
             success: function (response)
             {
                var return_value = $.parseJSON(response);
                if(return_value['status'] == "false")
                {
                    $( "#weight-error" ).remove();
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $('.weight_main').addClass('has-error');
                    $( ".help-block.weight-block" ).after('<span id="weight-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for weight. Based on your weight range needs to fall within ('+return_value["first"]+"-"+return_value["last"]+').</span>');
                    $("#app_weight").focus();
                    //$(".button-next").css("pointer-events","none");
                }
                else
                {
                    $('.weight_main').removeClass('has-error');
                    $( "#weight-error" ).remove();
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $("#app_height-feet").focus();
                    //$(".button-next").css("pointer-events","unset");
                }
             }
           });
        }
        else if(weight_value != "" && height_feet != "" && height_inches != "")
        {
            var url = "<?php echo site_url('customer/checkWeight/checkheightandweight') ?>";
            $.ajax({
             type: 'post',
             url: url,
             data: {height_feet : height_feet,height_inches : height_inches,weight_value : weight_value},
             success: function (response)
             {
                var return_value = $.parseJSON(response);
                if(return_value['remove_products'].length != 0)
                {
                    if(return_value['remove_products'].length > 0)
                    {
                        $('.step.step2').trigger('click');
                    }
                    for (var i = 0; i < return_value['remove_products'].length; i++)
                    {
                        $( ".product-list .col-md-3 .portlet-title .actions .remove_to_cart" ).each(function( index )
                        {
                          if($(this).attr('remove-id') == return_value['remove_products'][i])
                          {
                                $(this).trigger('click');
                          }
                        });
                    };
                    for (var i = 0; i < return_value['remove_products_id'].length; i++)
                    {
                        $( ".product-list .col-md-3 .portlet-title .actions .add_to_cart" ).each(function( index )
                        {
                          if($(this).attr('data-id') == return_value['remove_products_id'][i])
                          {
                             $(this).parent('.actions').parent('.portlet-title').parent('.portlet').parent('.col-md-3').remove();
                          }
                        });
                    };
                }
                if(return_value['customer_status'] == "false")
                {
                    $( "#weight-error" ).remove();
                    $('.weight_main').addClass('has-error');
                    $( ".help-block.weight-block" ).after('<span id="weight-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for weight. Based on your weight range needs to fall within ('+return_value["weight_first"]+"-"+return_value["weight_last"]+').</span>');
                    $("#app_weight").focus();
                }
                else if(return_value['status'] == "false")
                {
                    $( "#weight-error" ).remove();
                    $('.weight_main').addClass('has-error');
                    if(return_value['product_name'] != "")
                    {
                        //$( ".help-block.weight-block" ).after('<span id="weight-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for weight. Based on your weight range needs to fall within ('+return_value["weight_first"]+"-"+return_value["weight_last"]+').</span>');
                        var msg = 'Unfortunately you do not qualify for weight. Based on your weight range needs to fall within ('+return_value["weight_first"]+"-"+return_value["weight_last"]+').';
                        swal(msg);
                    }
                    //$(".button-next").css("pointer-events","none");
                }
                else
                {
                    $('.weight_main').removeClass('has-error');
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $( "#weight-error" ).remove();
                    //$(".button-next").css("pointer-events","unset");
                }
             }
           });
        }
    }
    function americo_required_fields()
    {
        $('.us_citizen').html('Is the proposed insured a U.S. Citizen? <span class="required"> * </span>');
        $('.currently_employed').html('Is the proposed insured currently employed? <span class="required"> * </span>');
        $('.current_address').html('How long at current address? <span class="required"> * </span>');
        $('.height_class').html('Height <span class="required"> * </span>');
        $('.weight_class').html('Weight <span class="required"> * </span>');
        var settings = $('form').validate().settings;
        $('[name="app_height-feet"]').attr('id','app_height-feet');
        $('[name="app_height-Inches"]').attr('id','app_height-Inches');
        $('[name="app_weight"]').attr('id','app_weight');
        $('#app_height-feet,#app_height-Inches,#app_weight').val('');
        $('[name="app_height-feet"],[name="app_height-Inches"],[name="app_weight"]').val('');
        $('[name="app_height-Inches"],[name="app_weight"]').attr('disabled','true');
        $('#app_height-Inches,#app_weight').attr('disabled','true');
        $('#app_height-feet').focus();
        // Modify validation settings
        $.extend(true, settings, {
           rules: {
               // Add validation of year
               "app_us_citizen": {
                   required: true,
               },
               "app_employed": {
                    required:true
                },
                "app_how_to_long": {
                    required:true
                },
                "app_height-feet": {
                    required:true,
                    digits:true,
                    min: 1
                },
                "app_height-Inches": {
                    required:true,
                    digits:true,
                    min : 0,
                    max : 11
                },
                "app_weight": {
                    required:true,
                    digits:true
                }
           }
        });
    }
    function americo_not_required_fields()
    {
        $('.us_citizen').html('Is the proposed insured a U.S. Citizen?');
        $('.currently_employed').html('Is the proposed insured currently employed?');
        $('.current_address').html('How long at current address?');
        $('.height_class').html('Height');
        $('.weight_class').html('Weight');
        var settings = $('form').validate().settings;
        $('[name="app_height-feet"]').removeAttr('id');
        $('[name="app_height-Inches"]').removeAttr('id');
        $('[name="app_weight"]').removeAttr('id');
        $('#app_height-Inches,#app_weight').removeAttr('disabled');
        $('#app_height-feet,#app_height-Inches,#app_weight').val('');
        $('[name="app_height-feet"],[name="app_height-Inches"],[name="app_weight"]').val('');
        $('.height_main').removeClass('has-error');
        $('.weight_main').removeClass('has-error');
        $('.us_citizen').parent('div').removeClass('has-error');
        $('.currently_employed').parent('div').removeClass('has-error');
        $('.current_address').parent('div').removeClass('has-error');
    }
    function format2(n, currency)
    {
        return currency + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }
    function RequiredFields(application_fields_array)
    {
        $.each(application_fields_array,function(idx, obj)
        {
            if(obj == "required")
            {
                if(idx == "app_marital_status")
                {
                    $('[name="app_marital_status"]').parent().parent().parent().parent().find('.required').show();
                    $('[name="app_marital_status"]').attr("required","true");
                }
                else if(idx == "app_gender")
                {
                    $('[name="app_gender"]').parent().parent().parent().parent().find('.required').show();
                    $('[name="app_gender"]').attr("required","true");
                }
                else if(idx == "app_us_citizen")
                {
                    $('[name="app_us_citizen"]').parent().parent().parent().parent().find('.required').show();
                    $('[name="app_us_citizen"]').attr("required","true");
                }
                else if(idx == "app_employed")
                {
                    $('[name="app_employed"]').parent().parent().parent().parent().find('.required').show();
                    $('[name="app_employed"]').attr("required","true");
                }
                else if(idx == "app_height")
                {
                    $('[name="app_height-feet"],[name="app_height-Inches"]').attr("required","true");
                    $('[name="app_height-feet"]').parent().parent().find('.required').show();
                }
                else if(idx == "app_how_to_long")
                {
                    $('[name="app_how_to_long"],[name="app_another_address"],[name="app_another_zip"],[name="app_another_time_at_address"]').attr("required","true");
                    $('[name="app_how_to_long"],[name="app_another_address"],[name="app_another_zip"],[name="app_another_time_at_address"]').parent().parent().find('.required').show();
                }
                else if(idx == "app_birth_state")
                {
                    $('[name="app_birth_country"],[name="app_birth_state"]').attr("required","true");
                    $('[name="app_birth_country"],[name="app_birth_state"]').parent().parent().find('.required').show();
                }
                else
                {
                    $('[name='+idx+']').attr("required","true");
                    $('[name='+idx+']').parent().parent().find('.required').show();
                }
            }
            else
            {
                if(idx == "app_marital_status")
                {
                    $('[name="app_marital_status"]').parent().parent().parent().parent().find('.required').hide();
                    $('[name="app_marital_status"]').removeAttr("required");
                }
                else if(idx == "app_gender")
                {
                    $('[name="app_gender"]').parent().parent().parent().parent().find('.required').hide();
                    $('[name="app_gender"]').removeAttr("required");
                }
                else if(idx == "app_us_citizen")
                {
                    $('[name="app_us_citizen"]').parent().parent().parent().parent().find('.required').hide();
                    $('[name="app_us_citizen"]').removeAttr("required");
                }
                else if(idx == "app_employed")
                {
                    $('[name="app_employed"]').parent().parent().parent().parent().find('.required').hide();
                    $('[name="app_employed"]').removeAttr("required");
                }
                else if(idx == "app_height")
                {
                    $('[name="app_height-feet"],[name="app_height-Inches"]').removeAttr("required");
                    $('[name="app_height-feet"]').parent().parent().find('.required').hide();
                }
                else if(idx == "app_how_to_long")
                {
                    $('[name="app_how_to_long"],[name="app_another_address"],[name="app_another_zip"],[name="app_another_time_at_address"]').removeAttr("required");
                    $('[name="app_how_to_long"],[name="app_another_address"],[name="app_another_zip"],[name="app_another_time_at_address"]').parent().parent().find('.required').hide();
                }
                else if(idx == "app_birth_state")
                {
                    $('[name="app_birth_country"],[name="app_birth_state"]').removeAttr("required");
                    $('[name="app_birth_country"],[name="app_birth_state"]').parent().parent().find('.required').hide();
                }
                else
                {
                    $('[name='+idx+']').removeAttr("required");
                    $('[name='+idx+']').parent().parent().find('.required').hide();
                }
            }
        });
    }
</script>
