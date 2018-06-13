<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/datatables.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
 <!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-summernote/summernote.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">    
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-shopping-cart font-dark"></i>
            <span class="caption-subject bold uppercase">Add Product</span>
        </div>        
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">        
        <form class="form-horizontal form-row-seperated" action="<?php echo site_url('products/manage_products/add') ?>" enctype="multipart/form-data" name="product_form" method="post" id="product_form">                                                   
                <?php
                    if(isset($products) && $products != "")
                    {                       
                        $product_id = $products->id;
                        $product_name = $products->product_name;
                        $underwriting_company = $products->underwriting_company;
                        $product_levels = $products->product_levels;
                        $plan_type = $products->plan_type;
                        $product_price = $products->product_price;                       
                        $product_overview = $products->product_overview;
                        $product_description = $products->product_description;
                        $product_brochure = $products->product_brochure;                        
                        if(unserialize($products->application_information) != "")
                        {                                                        
                            if(!empty(explode('&',unserialize($products->application_information))))
                            {
                                $application_information = explode('&',unserialize($products->application_information));
                            }
                            else
                            {
                                $application_information = array();       
                            }                            
                        }
                        else
                        {
                            $application_information = array();
                        }                        
                        $age_from = $products->age_from;
                        $age_to = $products->age_to;
                        $height_feet_from = $products->height_feet_from;
                        $height_feet_to = $products->height_feet_to;
                        $height_inches_from = $products->height_inches_from;
                        $height_inches_to = $products->height_inches_to;
                        $weight_from = $products->weight_from;
                        $weight_to = $products->weight_to;
                        $pre_existing_conditions = $products->pre_existing_conditions;
                        $enrollment_fee = $products->enrollment_fee;
                        $monthly_payment = $products->monthly_payment;
                        $co_pays = $products->co_pays;
                        if($co_pays != "" && $co_pays == 0)
                        {
                            $co_pays = "";   
                        }
                        $specialist_co_pay = $products->specialist_co_pay;
                        if($specialist_co_pay != "" && $specialist_co_pay == 0)
                        {
                            $specialist_co_pay = "";   
                        }
                        $coinsurance = $products->coinsurance;
                        if($coinsurance != "" && $coinsurance == 0)
                        {
                            $coinsurance = "";   
                        }
                        $deductible_amount = $products->deductible_amount;
                        if($deductible_amount != "" && $deductible_amount == 0)
                        {
                            $deductible_amount = "";   
                        }
                        $maximum_benefits = $products->maximum_benefits;
                        if($maximum_benefits != "" && $maximum_benefits == 0)
                        {
                            $maximum_benefits = "";   
                        }
                        $maximum_out_of_pocket = $products->maximum_out_of_pocket;
                        if($maximum_out_of_pocket != "" && $maximum_out_of_pocket == 0)
                        {
                            $maximum_out_of_pocket = "";   
                        }
                        //$post_date = date('m/d/Y',strtotime($products->post_date));
                        $is_active = $products->is_active;
                        $product_states_ids = $products->state_id;                        
                    }
                    else
                    {
                        $product_id = "";
                        $product_name = "";
                        $underwriting_company = "";
                        $product_levels = "";
                        $plan_type = "";
                        $product_price = "";
                        $product_overview = "";
                        $product_description = "";
                        $product_brochure = "";
                        $application_information = array();
                        $age_from = "";
                        $age_to = "";
                        $height_feet_from = "";
                        $height_feet_to = "";
                        $height_inches_from = "";
                        $height_inches_to = "";
                        $weight_from = "";
                        $weight_to = "";
                        $pre_existing_conditions = "";
                        $enrollment_fee = "";
                        $monthly_payment = "";
                        $co_pays = "";
                        $specialist_co_pay = "";
                        $coinsurance = "";
                        $deductible_amount = "";
                        $maximum_benefits = "";
                        $maximum_out_of_pocket = "";
                        $post_date = "";
                        $is_active = "";
                        $product_states_ids = ""; 
                    }
                    if($pre_existing_conditions == "yes")
                    {
                    ?>
                        <script type="text/javascript">
                            $('document').ready(function()
                            {
                                $("#pre_existing_conditions_yes").trigger("click");
                            });
                        </script>
                    <?php
                    }
                    elseif ($pre_existing_conditions == "no") 
                    {
                    ?>
                        <script type="text/javascript">
                            $('document').ready(function()
                            {
                                $("#pre_existing_conditions_no").trigger("click");
                            });
                        </script>
                    <?php
                    }
                    if($product_brochure != "")
                    {
                    ?>
                        <script type="text/javascript">
                            $('document').ready(function()
                            {                                                    
                                /*$(".fileinput").addClass('fileinput-exists');
                                $(".fileinput").removeClass('fileinput-new');                                                    
                                $(".pdf-name").attr('style','line-height:150px');
                                $(".fileinput-new").hide();
                                $(".fileinput-exists").show();
                                $(".btn.red.fileinput-exists").show();*/
                            });
                        </script>
                    <?php
                    }                                                    
                ?>
                <input type="hidden" class="form-control" name="product_id" value="<?php echo $product_id; ?>" placeholder="">
                <div class="form-group">
                    <label class="col-md-3 control-label">Product Category:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <select name="product_category" id="product_category" class="form-control">
                            <option value="">Select Category</option>
                            <?php                                                        
                                foreach ($categories as $value) 
                                {
                                ?>
                                    <option <?php if(isset($products) && $value['id'] == $products->category_id){ echo "selected"; }else{ echo ""; } ?> value="<?php echo $value['id'] ?>">
                                        <?php echo $value['category_name'] ?>
                                    </option>
                                <?php
                                }
                           
                            ?>
                        </select>
                        <span class="help-block"> Select category </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Product Name:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="product_name" value="<?php echo $product_name; ?>" placeholder="">
                        <span class="help-block"> Provide product name </span>
                    </div>                                        
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Company:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <select name="underwriting_company" id="underwriting_company" class="form-control">
                            <option value="">Select Company</option>
                            <?php
                            foreach ($company as $value) 
                            {
                            ?>
                                <option <?php if($value['id'] == $underwriting_company){ echo "selected"; }else{ echo ""; } ?> value="<?php echo $value['id'] ?>">
                                    <?php echo $value['company_name'] ?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="help-block"> Select company </span>
                    </div>
                </div>                                   
                <div class="form-group">
                    <label class="col-md-3 control-label">Country:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <select name="product_country" id="product_country" class="form-control">
                            <option value="">Select Country</option>
                            <?php                                                        
                                foreach ($country as $value) 
                                {
                                ?>
                                    <option <?php if(isset($products) && $value['id'] == $products->country_id){ echo "selected"; }else{ echo ""; } ?> value="<?php echo $value['id'] ?>">
                                        <?php echo $value['name'] ?>
                                    </option>
                                <?php
                                }
                           
                            ?>
                        </select>
                        <span class="help-block"> Select country </span>
                    </div>
                </div>                                                
                <div class="form-group states_list">
                    <label class="col-md-3 control-label">States:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <div class="map-show">
                            <div id="map" style="width: 600px; height: 400px;"></div>
                            <div id="clicked-state"></div>
                        </div>                                                
                        <div id="no-states"><span class="help-block">Please select country</span></div>                        
                    </div>
                </div>                
                <div class="form-group state-list">
                    <label class="control-label col-md-3">Targeted states:</label>
                    <div class="control-label label-sates col-md-3 ">
                        <strong class="count-state"></strong>&nbsp; states selected.
                    </div>
                    <div class="col-md-6">                         
                        <button class="btn green" id="select-all" type="button" >SELECT ALL</button>
                        <button class="btn green" id="clear" type="button" >DESELECT ALL</button>
                    </div>                                                
                </div>                                                               
                <div class="form-group state-list">
                    <label class="control-label col-md-3">&nbsp;</label>
                    <div class="col-md-9 ">
                        <div class="checkbox-list">                          
                        </div>                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label 
                    col-md-3">Plan Type
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <select class="form-control" name="plan_type" id="plan_type">
                            <option <?php if($plan_type == ""){ echo "selected"; }else{ echo ""; } ?> value="">Select any one</option>
                            <option <?php if($plan_type == "all"){ echo "selected"; }else{ echo ""; } ?> value="all">All</option>
                            <option <?php if($plan_type == "single"){ echo "selected"; }else{ echo ""; } ?> value="single">Single</option>
                            <option <?php if($plan_type == "single_spouse"){ echo "selected"; }else{ echo ""; } ?> value="single_spouse">Single+Spouse</option>
                            <option <?php if($plan_type == "single_child"){ echo "selected"; }else{ echo ""; } ?> value="single_child">Single+Child</option>
                            <option <?php if($plan_type == "family"){ echo "selected"; }else{ echo ""; } ?> value="family">Family</option>
                        </select>
                        <span class="help-block">Select plan type</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Product Levels:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="product_levels" value="<?php echo $product_levels; ?>" placeholder="">
                        <span class="help-block"> Provide product levels </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Product Price:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control mask_currency2" name="product_price" placeholder="" value="<?php echo $product_price; ?>">
                        <span class="help-block"> Provide product price </span>
                    </div>
                </div>
                <div class="form-group pro_over">
                    <label class="col-md-3 control-label">Product Overview:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <textarea id="product_overview" class="wysihtml5 form-control" rows="6" name="product_overview"><?php echo $product_overview; ?></textarea>
                        <span class="help-block"> Provide product overview </span>
                    </div>
                </div>
                <div class="form-group pro_desc">
                    <label class="col-md-3 control-label">Product Description:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <textarea id="product_description" class="wysihtml5 form-control" rows="6" name="product_description"><?php echo $product_description; ?></textarea>
                        <span class="help-block"> Provide product description </span>
                    </div>
                </div>
                <div class="form-group product_brochure">
                    <label class="col-md-3 control-label">Product Brochure:
                        <!-- <span class="required"> * </span> -->
                    </label>                                                                        
                    <div class="col-md-9">
                        <?php 
                            if($product_brochure != "")
                            {
                            ?>                                            
                                    <div class="edit-pdf"><?php echo $product_brochure; ?></div>                                          
                            <?php
                            }
                        ?>    
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail pdf-name" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                            <div>
                                <span class="btn red btn-outline btn-file">
                                    <span class="fileinput-new"> <?php if($product_brochure !=""){?> Select New Pdf <?php }else{?> Select pdf <?php } ?></span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" name="product_brochure" value="<?php echo $product_brochure; ?>">
                                    <input type="hidden" name="file_value" value="<?php echo $product_brochure; ?>">
                                </span>
                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div> 
                        <span class="help-block"> Provide product brochure (Uploaded document PDF)</span>                                                                                       
                    </div>
                </div>
                <div class="form-group app_info_error">
                    <label class="col-md-3 control-label">Application Information:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">                        
                        <button data-toggle="modal" data-target=".bs-example-modal-lg" class="btn red btn-outline application_information" type="button" name="application_information">Select</button>
                        <input type="hidden" name="application_product_information" value="<?php echo unserialize($products->application_information); ?>" class="" />
                        <?php /* <textarea class="form-control" rows="6" name="application_information"><?php echo $application_information; ?></textarea> */ ?>
                        <span class="help-block"> Provide application information </span>
                    </div>
                </div>                        
                <div class="form-group">
                    <label class="col-md-3 control-label">Age:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <div class="input-group input-large input-daterange" >
                            <input type="text" class="form-control" name="age_from" value="<?php echo $age_from; ?>">
                            <span class="input-group-addon"> to </span>
                            <input type="text" class="form-control" name="age_to" value="<?php echo $age_to; ?>">
                        </div>
                        <span class="help-block age_from"> Provide age from </span>                                                  
                        <span class="help-block age_to weight_to"> Provide age to </span>                                                  
                    </div>
                </div>
                <div class="form-group height_main">
                    <label class="col-md-3 control-label">Height:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <div class="height_custom">
                            <div class="input-group input-large input-daterange">
                                <input type="text" class="form-control" id="height_feet_from" name="height_feet_from" value="<?php echo $height_feet_from; ?>" >
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" id="height_feet_to" name="height_feet_to" value="<?php echo $height_feet_to; ?>"  >
                            </div>
                            <span class="help-block height_from"> Provide feet from </span>                                                  
                            <span class="help-block height_to"> Provide feet to </span>                                                  
                        </div>                     
                        <div class="height_custom error-show-height">                       
                            <div class="input-group input-large input-daterange" >
                                <input type="text" class="form-control" id="height_inches_from" name="height_inches_from" value="<?php echo $height_inches_from; ?>" >
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" id="height_inches_to" name="height_inches_to" value="<?php echo $height_inches_to; ?>" >
                            </div>
                            <span class="help-block height_from"> Provide inches from </span>                                                  
                            <span class="help-block height_to"> Provide inches to </span>                                                  
                        </div>
                    </div>
                </div>
                <div class="form-group weight_main">
                    <label class="col-md-3 control-label">Weight:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <div class="input-group input-large input-daterange" >
                            <input type="text" class="form-control" id="weight_from" name="weight_from" value="<?php echo $weight_from; ?>" >
                            <span class="input-group-addon"> to </span>
                            <input type="text" class="form-control" id="weight_to" name="weight_to" value="<?php echo $weight_to; ?>" >
                        </div>
                        <span class="help-block age_from"> Provide weight from </span>                                                  
                        <span class="help-block age_to weight_error"> Provide weight to </span>                                                  
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Allow Pre-Existing?
                        <span class="required"> * </span>
                    </label>                                
                    <div class="col-md-9">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" class="md-radiobtn" value="yes" name="pre_existing_conditions" id="pre_existing_conditions_yes">
                                <label for="pre_existing_conditions_yes">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Yes </label>
                            </div>
                            <div class="md-radio">
                                <input type="radio" class="md-radiobtn" value="no" name="pre_existing_conditions" id="pre_existing_conditions_no">
                                <label for="pre_existing_conditions_no">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> No </label>
                            </div>                                      
                        </div>                                    
                        <span class="help-block">Select pre-existing</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Enrollment Fee
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control enrollment_free_ch first_payment_cal mask_currency2" name="enrollment_fee" value="<?php echo $enrollment_fee; ?>" />
                        <span class="help-block"> Provide enrollment fee</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Monthly Payment
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control monthly_payment_ch first_payment_cal mask_currency2" name="monthly_payment" value="<?php echo $monthly_payment; ?>" />
                        <span class="help-block"> Provide monthly payment</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Co-Pay
                        <!-- <span class="required"> * </span> -->
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control co_pays_ch mask_currency2" name="co_pays" value="<?php echo $co_pays; ?>" />
                        <span class="help-block"> Provide co-pay</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Specialist Co-Pay
                        <!-- <span class="required"> * </span> -->
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control specialist_co_pay_ch mask_currency2" name="specialist_co_pay" value="<?php echo $specialist_co_pay; ?>" />
                        <span class="help-block"> Provide specialist co-pay</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Coinsurance
                        <!-- <span class="required"> * </span> -->
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control coinsurance_ch percentage" name="coinsurance" value="<?php echo $coinsurance; ?>" />
                        <span class="help-block"> Provide coinsurance </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Deductible Amount
                        <!-- <span class="required"> * </span> -->
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control deductible_amount_ch mask_currency2" name="deductible_amount" value="<?php echo $deductible_amount; ?>" />
                        <span class="help-block"> Provide deductible amount</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Maximum Benefits
                        <!-- <span class="required"> * </span> -->
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control maxmium_benifits_ch maximum_benefits mask_currency2" name="maximum_benefits" value="<?php echo $maximum_benefits; ?>" />
                        <span class="help-block"> Provide maximum benefits</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Maximum out of pocket
                        <!-- <span class="required"> * </span> -->
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control maximum_out_of_pocket_ch maximum_benefits mask_currency2" name="maximum_out_of_pocket" value="<?php echo $maximum_out_of_pocket; ?>" />
                        <span class="help-block">Provide maximum out of pocket</span>
                    </div>
                </div>
                <?php /*
                 <div class="form-group">
                    <label class="control-label col-md-3">Post Date
                        <!-- <span class="required"> * </span> -->
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control form-control-inline mask_date2 input-medium date-picker" name="post_date" value="<?php echo $post_date; ?>"  />
                        <span class="help-block"> Provide post date</span>
                    </div>
                </div> */ ?>                                                                                                             
                <div class="form-group">
                    <label class="col-md-3 control-label">Status:
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-9">
                        <select class="table-group-action-input form-control" name="is_active">
                            <option <?php if($is_active == ""){ echo "selected"; } ?> value="">Select Status</option>
                            <option <?php if($is_active == 1){ echo "selected"; }else{ echo ""; } ?> value="1">Published</option>
                            <option <?php if($is_active == 2){ echo "selected"; }else{ echo ""; } ?> value="2">Not Published</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-9">
                        <div class="actions btn-set">
                            <?php if($product_id == "")
                            {
                            ?>                                        
                            <button type="reset" class="btn btn-secondary-outline">
                                <i class="fa fa-reply"></i> Reset
                            </button>
                            <?php
                            }
                            ?>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> Save
                            </button>
                            <!--<button class="btn btn-success">
                                <i class="fa fa-check-circle"></i> Save & Continue Edit
                            </button> -->
                        </div>  
                    </div>                                                                                                      
           
        </form>
        <div class="customer_model modal fade bs-example-modal-lg  modal-lg" aria-labelledby="myLargeModalLabel" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Product Application Information</h4>
                    </div>
                    <div class="modal-body">
                        <div class="add_new_form fancybox1">
                            <form class="form-horizontal" id="add_product_fields" method="POST">                                                        
                                <div class="form-group">
                                    <label class="control-label col-md-5">First Name</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">                                                
                                                <input type="radio" class="md-radiobtn" value="required" name="app_fname" id="app_fname_required" <?php if(in_array("app_fname=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_fname_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_fname" id="app_fname_not_required" <?php if(in_array("app_fname=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_fname_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Middle Name</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_mname" id="app_mname_required" <?php if(in_array("app_mname=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_mname_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_mname" id="app_mname_not_required" <?php if(in_array("app_mname=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_mname_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Last Name</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_lname" id="app_lname_required" <?php if(in_array("app_mname=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_lname_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_lname" id="app_lname_not_required" <?php if(in_array("app_mname=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_lname_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Marital Status</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">                                                
                                                <input type="radio" class="md-radiobtn" value="required" name="app_marital_status" id="app_marital_status_required" <?php if(in_array("app_marital_status=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_marital_status_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_marital_status" id="app_marital_status_not_required" <?php if(in_array("app_marital_status=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_marital_status_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Gender</label>
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_gender" id="app_gender_required" <?php if(in_array("app_gender=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_gender_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_gender" id="app_gender_not_required" <?php if(in_array("app_gender=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_gender_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Height</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_height" id="app_height_required" <?php if(in_array("app_height=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_height_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_height" id="app_height_not_required" <?php if(in_array("app_height=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_height_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Weight</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_weight" id="app_weight_required" <?php if(in_array("app_weight=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_weight_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_weight" id="app_weight_not__required" <?php if(in_array("app_weight=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_weight_not__required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Primary Mailing Address</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_primary_email" id="app_primary_email_required" <?php if(in_array("app_primary_email=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_primary_email_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_primary_email" id="app_primary_email_not_required" <?php if(in_array("app_primary_email=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_primary_email_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Zip Code</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_zip" id="app_zip_required" <?php if(in_array("app_zip=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_zip_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_zip" id="app_zip_not_required" <?php if(in_array("app_zip=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_zip_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <?php /*
                                <div class="form-group">
                                    <label class="control-label col-md-5">City</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_city" id="app_city_required" <?php if(in_array("app_city=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_city_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_city" id="app_city_not_required" <?php if(in_array("app_city=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_city_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">State</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_state" id="app_state_required" <?php if(in_array("app_state=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_state_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_state" id="app_state_not_required" <?php if(in_array("app_state=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_state_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div> */ ?>
                                <div class="form-group">
                                    <label class="control-label col-md-5">How long at current address?</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_how_to_long" id="app_how_to_long_required" <?php if(in_array("app_how_to_long=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_how_to_long_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_how_to_long" id="app_how_to_long_not_required" <?php if(in_array("app_how_to_long=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_how_to_long_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Phone Number</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_phone_number" id="app_phone_number_required" <?php if(in_array("app_phone_number=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_phone_number_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_phone_number" id="app_phone_number_not_required" <?php if(in_array("app_phone_number=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_phone_number_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Email Address</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_email" id="app_email_required" <?php if(in_array("app_email=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_email_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_email" id="app_email_not_required" <?php if(in_array("app_email=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_email_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Social Security Number</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_soc_sec_number" id="app_soc_sec_number_required" <?php if(in_array("app_soc_sec_number=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_soc_sec_number_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_soc_sec_number" id="app_soc_sec_number_not__required" <?php if(in_array("app_soc_sec_number=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_soc_sec_number_not__required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Date of Birth</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_dob" id="app_dob_required" <?php if(in_array("app_dob=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_dob_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_dob" id="app_dob_not_required" <?php if(in_array("app_dob=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_dob_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <?php /*
                                <div class="form-group">
                                    <label class="control-label col-md-5">Age</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_age" id="app_age_required" <?php if(in_array("app_age=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_age_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_age" id="app_age_not_required" <?php if(in_array("app_age=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_age_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Birth Country</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_birth_country_id" id="app_birth_country_id_required" <?php if(in_array("app_birth_country_id=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_birth_country_id_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_birth_country_id" id="app_birth_country_id_not_required" <?php if(in_array("app_birth_country_id=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_birth_country_id_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div> */ ?>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Birth State</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_birth_state" id="app_birth_state_required" <?php if(in_array("app_birth_state=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_birth_state_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_birth_state" id="app_birth_state_not_required" <?php if(in_array("app_birth_state=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_birth_state_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Is the Proposed Insured a U.S. Citizen?</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_us_citizen" id="app_us_citizen_required" <?php if(in_array("app_us_citizen=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_us_citizen_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_us_citizen" id="app_us_citizen_not_required" <?php if(in_array("app_us_citizen=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_us_citizen_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Is The Proposed Insured currently employed?</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_employed" id="app_employed_required" <?php if(in_array("app_employed=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_employed_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_employed" id="app_employed_not_required" <?php if(in_array("app_employed=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_employed_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Employer</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_employer" id="app_employer_required" <?php if(in_array("app_employer=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_employer_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_employer" id="app_employer_not_required" <?php if(in_array("app_employer=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_employer_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Occupation</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_occupation" id="app_occupation_required" <?php if(in_array("app_occupation=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_occupation_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_occupation" id="app_occupation_not_required" <?php if(in_array("app_occupation=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_occupation_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Annual Salary</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_annual_salary" id="app_annual_salary_required" <?php if(in_array("app_annual_salary=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_annual_salary_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_annual_salary" id="app_annual_salary_not_required" <?php if(in_array("app_annual_salary=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_annual_salary_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Description of Job Duties</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_des_of_job_duties" id="app_des_of_job_duties_required" <?php if(in_array("app_des_of_job_duties=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_des_of_job_duties_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_des_of_job_duties" id="app_des_of_job_duties_not_required" <?php if(in_array("app_des_of_job_duties=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_des_of_job_duties_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Driver’s License</label>                                
                                    <div class="col-md-7">
                                        <div class="md-radio-inline">
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="required" name="app_driver_license" id="app_driver_license_required" <?php if(in_array("app_driver_license=required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_driver_license_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Required </label>
                                            </div>
                                            <div class="md-radio">
                                                <input type="radio" class="md-radiobtn" value="not_required" name="app_driver_license" id="app_driver_license_not_required" <?php if(in_array("app_driver_license=not_required", $application_information)){ echo "checked"; }else{ echo ""; }?>>
                                                <label for="app_driver_license_not_required">
                                                    <span class="inc"></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span> Not Required </label>
                                            </div>                                      
                                        </div>                                                                            
                                    </div>
                                </div>                               
                                <div class="form-group">
                                    <label class="col-md-5 control-label"></label>
                                    <div class="col-md-7">
                                        <div class="actions btn-set">                            
                                            <button type="reset" class="btn btn-secondary-outline">
                                                <i class="fa fa-reply"></i> Reset
                                            </button>                            
                                            <button type="submit" class="btn btn-success application_product submit-class">
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
<!-- END EXAMPLE TABLE PORTLET-->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/raphael.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/jquery.usmap.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/scripts/datatable.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/datatables/datatables.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.pack.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/plupload/js/plupload.full.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.js'); ?>" type="text/javascript"></script>
<!-- <script src="assets/theam_assets/pages/scripts/jquery.maskedinput.js" type="text/javascript"></script> -->
<!-- END PAGE LEVEL PLUGINS -->  
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo site_url('assets/theam_assets/global/scripts/app.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/ecommerce-products-edit.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.input-ip-address-control-1.0.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-input-mask.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinputpdf.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-markdown/lib/markdown.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-summernote/summernote.min.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script type="text/javascript">
    $('document').ready(function(){
        var fillArray = Array();
        $('[name="product_overview"],[name="product_description"]').wysihtml5();            
        $('#products').parents('li').addClass('open');
        $('#products').siblings('.arrow').addClass('open');
        $('#products').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#products'));
        $('#add_product').parents('li').addClass('active');        
        $('.state-list,.map-show').hide();
        $('#no-states').show();
        $('#map').usmap({      
            stateHoverStyles: {fill: '#888888'},  
            'click' : function(event, data)
            {
                   var a = fillArray.indexOf(data.name);
                   if ( a > -1 ){
                        $('.state-'+data.name).attr('checked',false);
                        $('.state-'+data.name).parent('span').removeClass('checked');
                        $('#' + data.name).css('fill', '');
                        fillArray.splice(a, 1);
                   }else{
                        $('#' + data.name).css('fill', '#26A1AB'); 
                        fillArray.push(data.name);
                        $('.state-'+data.name).attr('checked',true);
                        $('.state-'+data.name).parent('span').addClass('checked');
                   }
                   $('.count-state').html(fillArray.length);                                 
            }
        });
        $(document).on('click','.state',function()
        {
             var id = $(this).attr('data-state');
             if( $(this).is(":checked") == true )
             {
                $('#'+id).css('fill', '#26A1AB');
                fillArray.push(id);
             }
             else
             {
                $('#' + id).css('fill', '');
                var a = fillArray.indexOf(id); 
                if ( a > -1 ){
                   fillArray.splice(a, 1); 
                }
             } 
             $('.count-state').html(fillArray.length);
        });
        $(document).on('click','#clear',function()
        {
             var len = fillArray.length;
             if(len > 0)
             {
                for(var i=0;i< len;i++)
                {
                   $('#' + fillArray[i]).css('fill', '');                
                   $('.state-'+fillArray[i]).attr('checked',false);
                   $('.state-'+fillArray[i]).parent('span').removeClass('checked');                               
                }
                fillArray = Array();
             }
             $('.count-state').html(fillArray.length);
        });
        $(document).on('click','#select-all',function()
        {
             $('#clear').trigger('click');
             $('.state').trigger('click');
        });

        $('[name="product_country"]').change(function()
        {
            var cid = $(this).val();
            if(cid == 3)
            {
                $('.state-list,.map-show').show();
                $('#no-states').hide();
            }
            var url = '<?php echo site_url("products/prodcut_state/getByCountryId") ?>'+'/'+cid;
            $.ajax({
                url : url,
                method : 'get',
                success : function(str)
                {
                    $('.checkbox-list').html(str);                   
                    /*$('[name="product_state_id[]"]').change(function()
                    {
                        var numberOfChecked = $('[name="product_state_id[]"]:checked').length;                                                
                        if($(this).is(":checked")) 
                        {
                            $(".state-list").removeClass('has-error');                
                        }            
                        else
                        {
                            if(numberOfChecked == 0)
                            {
                                $(".state-list").addClass('has-error');                
                            }
                            else
                            {
                                $(".state-list").removeClass('has-error');                
                            }
                        }
                    });*/
                }
            });
        });
        var edit_state = '<?php echo $products->id ?>';
        if(edit_state != "")
        {                
            $('[name="product_country"]').trigger('change');            
            var state_checked = '<?php echo $products->state_id ?>';
            var state_checkedArray = state_checked.split(',');            
            var explode1 = function()
            {                                                                                                                                                                                                                                                             
                $(".checkbox-list input").each(function() 
                {                       
                    var value_text = $(this).val();                                                                
                    if($.inArray(value_text,state_checkedArray) != -1)
                    {
                        $(this).trigger('click');
                    }
                });
            };                                                                                               
            setTimeout(explode1, 1000);           
        }
        $('.application_information').click(function()
        {
            $('body').addClass('overh');
        });
        $('.modal-header .close').click(function()
        {
            $('body').removeClass('overh');            
        });
        $('#myModal').click(function()
        {
            if($(this).hasClass( "fade" ) == "true")
            {                
            }
            else
            {
                $('body').removeClass('overh');
            }                        
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
        var form = $('#product_form');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({            
            doNotHideMessage: true,
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: ":hidden:not(textarea)",            
            rules: {
                "product_category": {
                    required: true,                            
                },                
                "product_name": {
                    required: true,                            
                },
                "underwriting_company": {
                    required: true,                                
                },
                "product_country": {
                    required: true,
                },
                "product_state_id[]": {
                    required: true,
                },                
                "product_levels": {
                    required: true,
                },
                "plan_type": {
                    required: true,
                },
                "product_price": {
                    required: true,
                    currency: true,
                },
                "product_overview": {
                    required: true,                                            
                },
                "product_description": {
                    required: true,                    
                },
                "product_brochure": {
                    required: false,
                },                
                "application_product_information": {
                    required: true,
                },
                "age_from": {
                    required: true,
                },
                "age_to": {
                    required: true,
                },
                "height_feet_from": {
                    required: true,
                },
                "height_feet_to": {
                    required: true,
                },
                "height_inches_from": {
                    required: true,
                },
                "height_inches_to": {
                    required: true,
                },
                "weight_from": {
                    required: true,
                },
                "weight_to": {
                    required: true,
                },
                "pre_existing_conditions": {
                    required: true,
                },
                "enrollment_fee": {
                    required: true,
                    currency: true,
                },
                "monthly_payment": {
                    required: true,
                    currency: true,
                },
                "coinsurance":{
                    percentage: true,
                },
                "is_active": {
                    required: true,
                },
            },       
            invalidHandler: function(event, validator) 
            {                                                  
                var count_check = 0;
                $(".checkbox-list input").each(function(index)
                {
                    if($(this).prop("checked") == true)
                    {
                        count_check = count_check + 1; 
                    }                                            
                });
                if(count_check == 0)
                {
                    $(".states_list").addClass('has-error');                    
                }
                else
                {
                    $(".states_list").removeClass('has-error');
                }
                if($("[name='application_product_information']").val() == "")
                {
                    $(".app_info_error").addClass('has-error');                    
                }
                else
                {
                    $(".app_info_error").removeClass('has-error');
                    
                }                
                success.hide();
                error.show();
                App.scrollTo(error, -200);
            },            
            highlight: function(element)
            {                 
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element)
            {                            
                $(element).closest('.form-group').removeClass('has-error');                            
            },
            success: function(label)
            {                                                
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },        
            errorPlacement: function (error, element)
            {                
                if (element.attr("name") == "pre_existing_conditions" || element.attr("name") == "product_brochure" || element.attr("name") == "age_from" || element.attr("name") == "age_to" || element.attr("name") == "height_feet_from" || element.attr("name") == "height_feet_to" || element.attr("name") == "height_inches_from" || element.attr("name") == "height_inches_to" || element.attr("name") == "weight_from" || element.attr("name") == "weight_to" || element.attr("name") == "product_state_id[]" )
                {
                    //error.insertAfter("#form_gender_error");
                }
                else 
                {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },        
            submitHandler: function(form)
            {
                if($("[name='application_product_information']").val() == "")
                {
                    $(".app_info_error").addClass('has-error');
                    return false;
                }
                else
                {
                    $(".app_info_error").removeClass('has-error');
                    return true;
                }                            
                success.show();
                error.hide();
                form.submit();
            }
        });
        
        var form1 = $('#add_product_fields');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        form1.validate({            
            doNotHideMessage: true,
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: ":hidden:not(textarea)",            
            rules: {                
                "app_fname": {
                    required: true,                            
                },
                "app_mname": {
                    required: true,                            
                },
                "app_lname": {
                    required: true,                            
                },
                "app_marital_status": {
                    required: true,                            
                },
                "app_gender": {
                    required: true,                            
                },
                "app_height": {
                    required: true,                            
                },
                "app_weight": {
                    required: true,                            
                },
                "app_primary_email": {
                    required: true,                            
                },
                "app_zip": {
                    required: true,                            
                },
                "app_how_to_long": {
                    required: true,                            
                },
                "app_phone_number": {
                    required: true,                            
                },
                "app_email": {
                    required: true,                            
                },
                "app_soc_sec_number": {
                    required: true,                            
                },                
                "app_dob": {
                    required: true,                            
                },
                "app_birth_state": {
                    required: true,                            
                },
                "app_us_citizen": {
                    required: true,                            
                },
                "app_employed": {
                    required: true,                            
                },
                "app_employer": {
                    required: true,                            
                },
                "app_occupation": {
                    required: true,                            
                },
                "app_annual_salary": {
                    required: true,                            
                },
                "app_des_of_job_duties": {
                    required: true,                            
                },
                "app_driver_license": {
                    required: true,                            
                }
            },       
            invalidHandler: function(event, validator) 
            {                                                                  
                success1.hide();
                error1.show();
                App.scrollTo(error1, -200);
            },            
            highlight: function(element)
            {                 
                $(element).closest('.form-group').addClass('has-error');               
            },
            unhighlight: function (element)
            {                            
                $(element).closest('.form-group').removeClass('has-error');                            
            },
            success: function(label)
            {                                                
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },        
            errorPlacement: function (error, element)
            {                
                if (element.attr("name") != "")
                {
                    //error.insertAfter("#form_gender_error");
                }
                else 
                {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },        
            submitHandler: function(form)
            {                                                       
                success1.show();
                error1.hide();
                //form1.submit();
            }
        });

        $( "#add_product_fields" ).submit(function(event)
        {            
           event.preventDefault();
           var return_value = parseInt(0);
           $( "#add_product_fields .form-group" ).each(function(index)
           {                                           
                if($(this).hasClass( "has-error") == true)
                {                    
                    return_value = parseInt(return_value) + parseInt(1);
                }
           });                    
           if(parseInt(return_value) > parseInt(0))
           {                
                return false;
           }
           else
           {                            
               var data = $("#add_product_fields").serialize();           
               $('[name="application_product_information"]').val(data);           
               $('#myModal').modal('hide');           
               //$("#add_product_fields .btn.btn-secondary-outline").trigger('click');                            
           }                                 
        });
        var edit_company_id = "<?php echo $products->underwriting_company ?>";
        $('[name="underwriting_company"]').change(function()
        {                      
            if($('[name="underwriting_company"]').val() == 6)
            {
                //$('#height_feet_to,#height_inches_from,#height_inches_to,#weight_to').attr('disabled','true');
                if(edit_company_id == "")
                {
                    $('#height_feet_from,#height_feet_to,#height_inches_from,#height_inches_to,#weight_from,#weight_to').val('');
                }                
                $('#height_feet_from').change(function()
                {            
                    $('#height_feet_to,#height_inches_from,#height_inches_to,#weight_from,#weight_to').val('');
                    height_check();            
                });
                $('#height_feet_to').change(function()
                {            
                    $('#height_inches_from,#height_inches_to,#weight_from,#weight_to').val('');
                    height_check();
                });
                $('#height_inches_from').change(function()
                {            
                    $('#height_inches_to,#weight_from,#weight_to').val('');
                    height_check();
                });
                $('#height_inches_to').change(function()
                {            
                    $('#weight_from,#weight_to').val('');
                    height_check();
                });
                $( '#weight_from' ).change(function()
                {            
                    $('#weight_to').val('');
                    weight_check();
                });
                $( '#weight_to' ).change(function()
                {            
                    weight_check();
                });
            }
            else
            {
                $('#height_feet_from,#height_feet_to,#height_inches_from,#height_inches_to,#weight_from,#weight_to').val('');
            }
        });        
        
        if(edit_company_id != "" && edit_company_id == 6)
        {
            $('[name="underwriting_company"]').trigger('change');
        }

        function height_check()
        {
            var height_feet_from = $('#height_feet_from').val();
            var height_feet_to = $('#height_feet_to').val();
            var height_inches_from = $('#height_inches_from').val();
            var height_inches_to = $('#height_inches_to').val();
            var weight_from = $('#weight_from').val();
            var weight_to = $('#weight_to').val();             
            if(height_feet_from != "" && height_feet_to == "" && height_inches_from == "" && height_inches_to == "")
            {                            
                var height_feet_msg = "height_feet_from";
                height_feet(height_feet_from,height_feet_msg);
            }
            else if(height_feet_from != "" && height_feet_to != "" && height_inches_from == "" && height_inches_to == "")
            {                   
                if(height_feet_from <= height_feet_to)
                {                    
                    var height_feet_msg = "height_feet_to";
                    height_feet(height_feet_to,height_feet_msg);    
                }
                else
                {
                    $("#height_feet_to").focus();
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $('.height_main').addClass('has-error');
                    $( ".error-show-height" ).after('<span id="feet-error" style="color:#f3565d !important" class="help-block">Please input value greater then or equal to '+height_feet_from+'</span>');
                    //$(".btn.btn-success").css("pointer-events","none");                    
                }             
            }
            else if(height_feet_from != "" && height_feet_to != "" && height_inches_from != "" && height_inches_to == "")
            {                
                var height_inches_msg = "height_inches_from";
                height_inches_start(height_feet_from,height_inches_from,height_inches_msg);
            }
            else if(height_feet_from != "" && height_feet_to !="" && height_inches_from != "" && height_inches_to != "")
            {                
                var height_inches_msg = "height_inches_to";                
                height_inches_end(height_feet_to,height_inches_to,height_inches_msg);
            }            
        }
        function weight_check()
        {            
            var height_feet_from = $('#height_feet_from').val();
            var height_feet_to = $('#height_feet_to').val();
            var height_inches_from = $('#height_inches_from').val();
            var height_inches_to = $('#height_inches_to').val();
            var weight_from_value = $('#weight_from').val();
            var weight_to_value = $('#weight_to').val();                        
            if(weight_from_value != "" && weight_to_value == "" && height_feet_from == "" && height_feet_to == "" && height_inches_from == "" && height_inches_to == "")
            {                                
                var weight_msg = "weight_from";
                weight(weight_from_value,weight_msg);
            }
            else if(weight_from_value != "" && weight_to_value != "" && height_feet_from == "" && height_feet_to == "" && height_inches_from == "" && height_inches_to == "")
            {                            
                if(parseInt(weight_from_value) <= parseInt(weight_to_value))
                {                   
                     var weight_msg = "weight_to";
                     weight(weight_to_value,weight_msg);    
                }
                else
                {                    
                    $( "#weight-error" ).remove();
                    $('.weight_main').addClass('has-error');
                    $( ".weight_error" ).after('<span id="weight-error" style="color:#f3565d !important" class="help-block">Please input value greater then or equal to '+weight_from_value+'</span>');
                    //$(".btn.btn-success").css("pointer-events","none");
                }
                
            }
            else if(weight_from_value != "" && weight_to_value == "" && height_feet_from != "" && height_feet_to != "" && height_inches_from != "" && height_inches_to != "")
            {                                 
                var weight_msg = "weight_from";
                height_weight(height_feet_from,height_feet_to,height_inches_from,height_inches_to,weight_from_value,weight_to_value,weight_msg);
            }
            else if(weight_from_value != "" && weight_to_value != "" && height_feet_from != "" && height_feet_to != "" && height_inches_from != "" && height_inches_to != "")
            {                                  
                if(parseInt(weight_from_value) <= parseInt(weight_to_value))
                {
                     var weight_msg = "weight_to";
                     height_weight(height_feet_from,height_feet_to,height_inches_from,height_inches_to,weight_from_value,weight_to_value,weight_msg);    
                }
                else
                {                    
                    $( "#weight-error" ).remove();
                    $('.weight_main').addClass('has-error');
                    $( ".weight_error" ).after('<span id="weight-error" style="color:#f3565d !important" class="help-block">Please input value greater then or equal to '+weight_from_value+'</span>');
                    //$(".btn.btn-success").css("pointer-events","none");
                }                 
            }
                          
        }

        function height_feet(height_feet,height_feet_msg)
        {
            var url = "<?php echo site_url('customer/checkHeight/Feet/') ?>";            
            $.ajax({
             type: 'post',
             url: url,
             data: {height_feet : height_feet,admin_pro_height_feet : true},
             success: function (response) 
             {
                var return_value = $.parseJSON(response);                
                if(return_value['status'] == "false")
                {
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $('.height_main').addClass('has-error');
                    $( ".error-show-height" ).after('<span id="feet-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for height feet. Based on your height feet range needs to fall within ('+return_value["first"]+"-"+return_value["last"]+').</span>');
                    //$(".btn.btn-success").css("pointer-events","none");
                    if(height_feet_msg == "height_feet_from")
                    {
                        //$('#height_feet_to').attr('disabled','true');
                        $("#height_feet_from").focus();
                    }
                    else
                    {
                        //$('#height_inches_from').attr('disabled','true');
                        $("#height_feet_from").focus();
                    }
                                        
                }
                else
                {
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $('.height_main').removeClass('has-error');                    
                    $( "#feet-error" ).remove();
                    //$(".btn.btn-success").css("pointer-events","unset");
                    if(height_feet_msg == "height_feet_from")
                    {
                        //$('#height_feet_to').removeAttr('disabled');
                        $("#height_feet_to").focus();
                    }
                    else
                    {
                       // $('#height_inches_from').removeAttr('disabled');
                        $("#height_inches_from").focus();
                    }    
                }                             
             }
           });
        }

        function height_inches(height_inches,height_inches_msg)
        {
            var url = "<?php echo site_url('customer/checkHeight/Inches/') ?>";            
            $.ajax({
             type: 'post',
             url: url,
             data: {height_inches : height_inches,admin_pro_height_inches : true},
             success: function (response) 
             {                
                var return_value = $.parseJSON(response);               
                if(return_value['status'] == "false")
                {
                    $('.height_main').addClass('has-error');
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $( ".error-show-height" ).after('<span id="inches-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for height inches. Based on your height inches range needs to fall within ('+return_value["first"]+"-"+return_value["last"]+').</span>');
                    //$(".btn.btn-success").css("pointer-events","none");
                    if(height_inches_msg == "height_inches_from")
                    {
                        //$('#height_inches_to').attr('disabled','true');
                        $("#height_inches_from").focus();
                    }                    
                }
                else
                {
                    $('.height_main').removeClass('has-error');
                    $( "#inches-error" ).remove();
                    //$(".btn.btn-success").css("pointer-events","unset");
                    if(height_inches_msg == "height_inches_from")
                    {
                        //$('#height_inches_to').removeAttr('disabled');
                        $("#height_inches_to").focus();
                    }                        
                }                         
             }
           });
        }

        function height_inches_start(height_feet_from,height_inches_from,height_inches_msg)
        {
            var url = "<?php echo site_url('customer/checkHeight/inchesStart/') ?>";            
            $.ajax({
             type: 'post',
             url: url,
             data: {height_feet_from : height_feet_from,height_inches_from : height_inches_from},
             success: function (response) 
             {                
                var return_value = $.parseJSON(response);               
                if(return_value['status'] == "false")
                {
                    $('.height_main').addClass('has-error');
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $( ".error-show-height" ).after('<span id="inches-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for height inches. Based on your height inches range needs to fall within ('+return_value["first"]+"-"+return_value["last"]+').</span>');
                    //$(".btn.btn-success").css("pointer-events","none");
                    if(height_inches_msg == "height_inches_from")
                    {
                        //$('#height_inches_to').attr('disabled','true');
                        $("#height_inches_from").focus();
                    }                    
                }
                else
                {
                    $('.height_main').removeClass('has-error');
                    $( "#inches-error" ).remove();
                    //$(".btn.btn-success").css("pointer-events","unset");
                    if(height_inches_msg == "height_inches_from")
                    {
                        //$('#height_inches_to').removeAttr('disabled');
                        $("#height_inches_to").focus();
                    }                        
                }                         
             }
           });
        }

        function height_inches_end(height_feet_to,height_inches_to,height_inches_msg)
        {
            var url = "<?php echo site_url('customer/checkHeight/inchesEnd/') ?>";            
            $.ajax({
             type: 'post',
             url: url,
             data: {height_feet_to : height_feet_to,height_inches_to : height_inches_to},
             success: function (response) 
             {                                
                var return_value = $.parseJSON(response);               
                if(return_value['status'] == "false")
                {
                    $('.height_main').addClass('has-error');
                    $( "#feet-error,#inches-error,#height-error" ).remove();
                    $( ".error-show-height" ).after('<span id="inches-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for height inches. Based on your height inches range needs to fall within ('+return_value["first"]+"-"+return_value["last"]+').</span>');
                    //$(".btn.btn-success").css("pointer-events","none");
                    $("#height_inches_to").focus();
                                        
                }
                else
                {
                    $('.height_main').removeClass('has-error');
                    $( "#inches-error" ).remove();
                    //$(".btn.btn-success").css("pointer-events","unset");
                    if(height_inches_msg == "height_inches_from")
                    {
                        //$('#height_inches_to').removeAttr('disabled');
                        $("#height_inches_to").focus();
                    }                        
                }
             }
           });
        }

        function weight(weight,weight_msg)
        {
            var url = "<?php echo site_url('customer/checkWeight/checkweight') ?>"+'/'+weight;            
            $.ajax({
             type: 'post',
             url: url,             
             success: function (response) 
             {                
                var return_value = $.parseJSON(response);                
                if(return_value['status'] == "false")
                {
                    $( "#weight-error" ).remove();
                    $('.weight_main').addClass('has-error');
                    $( ".weight_error" ).after('<span id="weight-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for weight. Based on your weight range needs to fall within ('+return_value["first"]+"-"+return_value["last"]+').</span>');
                    //$(".btn.btn-success").css("pointer-events","none");
                    if(weight_msg == "weight_from")
                    {
                        //$('#weight_to').attr('disabled','true');
                        $("#height_inches_from").focus();
                    }
                }
                else
                {
                    $('.weight_main').removeClass('has-error');                    
                    $( "#weight-error" ).remove();
                    //$(".btn.btn-success").css("pointer-events","unset");
                    if(weight_msg == "weight_from")
                    {
                        //$('#weight_to').removeAttr('disabled');                                                
                        $("#weight_to").focus();
                    }    
                }
             }
           }); 
        }

        function height_weight(height_feet_from,height_feet_to,height_inches_from,height_inches_to,weight_from_value,weight_to_value,weight_msg)
        {
            var url = "<?php echo site_url('customer/checkWeight/checkheightandweightfromto') ?>";
            $.ajax({
             type: 'post',
             url: url,
             data: {height_feet_from : height_feet_from,height_feet_to : height_feet_to,height_inches_from : height_inches_from,height_inches_to : height_inches_to,weight_from_value : weight_from_value,weight_to_value : weight_to_value},
             success: function (response) 
             {                                                
                var return_value = $.parseJSON(response);                
                if(return_value['status'] == "false")
                {
                    $( "#weight-error" ).remove();
                    $('.weight_main').addClass('has-error');
                    $( ".weight_error" ).after('<span id="weight-error" style="color:#f3565d !important" class="help-block">Unfortunately you do not qualify for weight. Based on your weight range needs to fall within ('+return_value["weight_first"]+"-"+return_value["weight_last"]+').</span>');
                    //$(".button-next").css("pointer-events","none");
                    if(weight_msg == "weight_from")
                    {
                        //$('#weight_to').attr('disabled','true');
                        $("#weight_from").focus();
                    }
                }
                else
                {
                    $('.weight_main').removeClass('has-error');                    
                    $( "#weight-error" ).remove();
                    //$(".button-next").css("pointer-events","unset");
                    if(weight_msg == "weight_from")
                    {
                        //$('#weight_to').removeAttr('disabled');
                        $("#weight_to").focus();   
                    }    
                }
             }
           }); 
        }
    });
</script>