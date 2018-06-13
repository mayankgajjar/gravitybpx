<?php 
    $filters = array();
    if($campaign->campaign_id != '' || $campaign->campaign_id != 'NULL'){
        $filters = @unserialize($campaign->filters);
    }

?>


<!-- Wizard -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-wizard.min.js'); ?>" type="text/javascript"></script>  
<!-- End Wizard -->

<!-- Range Slider -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/ion.rangeslider/css/ion.rangeSlider.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css'); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo site_url('assets/theam_assets/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js'); ?>" type="text/javascript"></script>
<!-- End Range Slider -->

<!-- Map  -->
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/raphael.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/color.jquery.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/jquery.usmap.js'); ?>" type="text/javascript"></script>
<!-- End Map  -->

<!-- Mask -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'); ?>" type="text/javascript"></script>
<!-- End Mask -->

<!-- Tag Input -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'); ?>" rel="stylesheet" type="text/css" /> 
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/components-bootstrap-tagsinput.min.js'); ?>" type="text/javascript"></script>
<!-- End Tag Input -->

<style type="text/css">
.label{color: #818181;font-family: proxima-nova,Montserrat,Roboto,Arial,Helvetica,sans-serif;font-size: 12px;font-weight: 600;text-transform: uppercase;}
.value{font-size: 18px;font-weight: 700;}
.column{background-clip: padding-box;background-color: #f0f0f0;border-radius: 3px;padding: 10px 15px;}
.text-blue {color: #4c8cc9 !important;cursor: pointer;}
.text-green {color: #82be37 !important;}
.note {color: #8e8e8e;font-size: 12px;font-style: italic;border-left: none;margin: 0 0 20px 13px; box-shadow: none;}
.label-sates{text-align: left!important;}
div.inputTags-list {background-color: #f9f9f9;border: 1px solid rgba(25, 188, 156, 0.35);border-radius: 4px;box-shadow: 1px 2px 2px rgba(221, 221, 221, 0.2);display: inline-block;padding: 6px;width: 100%;}
div.inputTags-list input.inputTags-field {background-color: rgba(0, 0, 0, 0);border: medium none;margin-left: 4px;}
input.inputTags-field {display: inline-block;width: 8rem;}
div.inputTags-list span.inputTags-item {background-color: #32c5d2;border-radius: 3px;color: #ffffff;display: inline-block;margin: 2px;opacity: 1;padding: 3px 22px 4px 8px;position: relative;text-align: center;}
div.inputTags-list span.inputTags-item span.value {cursor: pointer;}
div.inputTags-list span.inputTags-item i {cursor: pointer;font-family: sans-serif;font-size: 20px;font-weight: 400;position: absolute;right: 6px;top: 50%;transform: translateY(-50%);transition: color 0.2s ease 0s;z-index: 10;}
.schedule-time table div.checker{display: none;}
.select{background-color: #ABD378;}
.bootstrap-tagsinput{width: 100%;}
.optionsfil{margin-left: 30px;margin-bottom: 15px;}
.progress {height: 20px;}
</style>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo "Campaign" ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title">Campaign</h3>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
</div>
<?php endif; ?>
<?php if(validation_errors() != ''): ?>
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<div id="form_wizard_1" class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-settings font-dark"></i>
            <span class="caption-subject font-dark sbold uppercase"><?=$listtitle?></span>
        </div>
    </div>
    <div  class="portlet-body form">
        <form id="submit_form" class="form-horizontal" method="post">
            <div class="form-wizard">
                <div class="form-body">
                    <ul class="nav nav-pills nav-justified steps">
                        <li>
                            <a href="#tab1" data-toggle="tab" class="step">
                                <span class="number"> 1 </span>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Campaign Type </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab2" data-toggle="tab" class="step">
                                <span class="number"> 2 </span>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Lead Type </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab3" data-toggle="tab" class="step active">
                                <span class="number"> 3 </span>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Bid Type </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab4" data-toggle="tab" class="step">
                                <span class="number"> 4 </span>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Confirm </span>
                            </a>
                        </li>
                    </ul>
                    <div id="bar" class="progress progress-striped" role="progressbar">
                        <div class="progress-bar progress-bar-success"> </div>
                    </div>
                     <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <h3 class="block">Select a Lead Category</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3">Lead Category
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <?php $verticals = $this->vertical_m->getActiveVetical(); ?>                                     
                                    <select class="form-control" name="campcat" id="campcat" onChange="javascript:popopCondition(this)">
                                        <?php if(count($verticals) > 0) :?>  
                                            <?php foreach($verticals as $vertical): ?>
                                                <option value="<?php echo $vertical->id ?>" data-ispop="<?php echo $vertical->is_condition ?>" data-poptext="<?php echo $vertical->condition_text; ?>" <?php echo $campaign->campcat == $vertical->id ? 'selected="selected"':''; ?>><?php echo $vertical->cat_name ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>    
                                    </select>
                                </div>
                            </div>
                        </div><!-- tab 1 -->
                        <div class="tab-pane" id="tab2">
                            <h3 class="block">Select an Lead Type</h3>
                            <p>Select one of the lead types below that you want this campaign to participate in.</p>
                            <div class="form-group">
                                <label class="control-label col-md-3">Lead Type
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                        <div class="radio-list">
                                        <label id="auct_type<?php echo AUCTION_TYPE_DATA ?>" style="display:none;">
                                            <input type="radio" name="auct_type" value="<?php echo AUCTION_TYPE_DATA ?>" data-title="<?php echo 'Data' ?>" <?php echo $campaign->auct_type == AUCTION_TYPE_DATA ? 'checked="checked"':''; ?> /> <strong> Data </strong> <br />
                                            <span>In a data auction, we sell leads that are collected from an online sign-up process on a website. It is much easier to get more targeted results from these leads because of the extensive data we collect from them. Data leads are sent directly to your dashboard, CRM, and/or email in real time depending on which delivery methods to setup on your campaign.</span>
                                        </label>                                            
                                        <label id="auct_type<?php echo AUCTION_TYPE_LIVE_TRANSFER ?>" style="display:none;">
                                          <input type="radio" name="auct_type" value="<?php echo AUCTION_TYPE_LIVE_TRANSFER ?>" data-title="<?php echo 'Live Transfer' ?>" <?php echo $campaign->auct_type == AUCTION_TYPE_LIVE_TRANSFER ? 'checked="checked"':''; ?> /> <strong> Live Transfer</strong><br/>
                                           <span>In a live transfer auction, our trained call center representatives pre-qualify every lead before transferring a call to you.</span>                                       
                                        </label>                                        

                                    </div>
                                    <div id="form_gender_error"> </div>
                                </div>
                            </div>
                        </div>  <!-- tab2 -->
                        <div class="tab-pane" id="tab3">
                            <h3 class="block">Select a Bid Type</h3>
                            <div class="form-group">
                                <label class="control-label col-md-3"> Bid Type
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">                                
                                    <div class="radio-list">
                                        <?php $bids = $this->bid_m->getActiveBids();?>
                                        <?php if(count($bids) > 0) :?>  
                                            <?php foreach( $bids as $bid ): ?>
                                              <label id="bid_id<?php echo $bid->lead_bid_id; ?>" style="display: none;">
                                                   <input type="radio" name="bid_id" value="<?php echo $bid->lead_bid_id; ?>" data-title="<?php echo $bid->name; ?>" <?php echo $campaign->bid_id == $bid->lead_bid_id ? 'checked="checked"':''; ?>  /> <strong><?php echo $bid->name ?></strong>
                                                   <p><strong>Minimum Bid:</strong><?php echo $bid->minbid; ?><br /><span><?php echo $bid->descr; ?></span></p>                                                                   
                                              </label>
                                            <?php endforeach; ?>
                                        <?php endif;?>    
                                    </div>
                                    <div id="form_bid_error"> </div>                               
                                </div>
                            </div>
                        </div><!-- tab3 -->
                        <div class="tab-pane" id="tab4">
                            <h3 class="block">Campaign</h3>
                            <h4 class="form-section">Campaign Type</h4>
                            <div class="form-group">                                
                                <div class="col-md-4 ">
                                    <div class="column">
                                        <p class="label">Lead Category:<i title="The lead product you are buying" aria-hidden="true" class="fa fa-fw text-blue"></i></p><br/>
                                         <p class="form-control-static value" data-display="campcat"> </p>
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="column">
                                        <p class="label">Lead Type:<i title="The type of lead you are buying -- typically Data or Live Transfer" aria-hidden="true" class="fa fa-fw text-blue"></i></p><br/>
                                        <p class="form-control-static value" data-display="auct_type"> </p>
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                   <div class="column"> 
                                        <div>Bid Type:<i title="The type of bid you are using to purchase this lead -- shared, exclusive, etc." aria-hidden="true" class="fa fa-fw text-blue"></i></div>
                                        <p class="form-control-static value" data-display="bid_id"> </p>  
                                    </div>    
                                </div>                                                                
                            </div>
                            <h4 class="form-section">Name Your Campaign</h4>                           
                            <div class="form-group">                                
                                <label class="control-label col-md-3">Select Buyer Account<span class="required" aria-required="true"> * </span></label>
                                <div class="col-md-4 "> 
                                    <select name="user_id" class="form-control">
                                        <option value=""><?php echo 'Please Select' ?></option>
                                        <?php if(isset($buyers) && count($buyers) > 0) :?>   
                                            <?php foreach($buyers as $buyer): ?>
                                            <option value="<?php echo $buyer->id ?>" <?php echo $campaign->user_id == $buyer->id ? 'selected="selected"':'' ?> ><?php echo $buyer->fname.' '.$buyer->lname; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">                                
                                <label class="control-label col-md-3">Campaign Name<span class="required" aria-required="true"> * </span></label>
                                <div class="col-md-4 "> 
                                    <input type="text" name="name" class="form-control" value="<?php echo $campaign->name; ?>" />
                                    <span class="help-block">Give your campaign a unique name.</span>    
                                </div>
                            </div>
                            <div class="form-group">                                
                                <label class="control-label col-md-3">Description</label>
                                <div class="col-md-4 ">
                                    <textarea class="form-control" name="descr"><?php echo $campaign->descr; ?></textarea>                                     
                                </div>
                            </div>
                    <div class="filters">  
                           <?php if (!empty($pre_filters)): ?>
                           <div class="filter-prec">
                            <h4 class="form-section"><?php echo 'Precision Targeting' ?></h4>
                            <p>Every one of our Live Transfers is guaranteed to be in one of your targeted states, under 65 years old, and has said they want to speak with a licensed health insurance agent. By using the filters below, you can focus your campaign to only target the highest qualified prospects.</p>                           
                                <div class="form-group">
                                    <label class="control-label col-md-3">&nbsp;</label>
                                    <div class="col-md-8">
                                        <div class="checkbox-list">                                            
                                            <?php foreach($pre_filters as $key => $val): ?>
                                                <label id="prec_<?php echo $val->filter_id; ?>" style="display:none;">
                                                    <?php 
                                                        switch ($val->name) {
                                                            case 'filter_by_age':
                                                                $click = 'onClick="toggleAge(this)"';
                                                                break;
                                                            case 'filter_by_zip':
                                                                $click = 'onClick="toggleLocation(\'zip-group\')"';
                                                                break;
                                                            default:
                                                                $click = '';
                                                                break;
                                                        }

                                                        $checked = '';
                                                        $optionsDisplay = "style='display: none;'";
                                                        if( isset($filters[$val->name]) && $filters[$val->name] === $val->filter_value ){
                                                            $checked = 'checked="checked"';
                                                            $optionsDisplay = "style='display: block;'";
                                                            if($val->name == 'filter_by_zip'){
                                                        ?>
                                                            <script type="text/javascript">
                                                                jQuery(function(){
                                                                   toggleLocation('zip-group'); 
                                                                });
                                                            </script>
                                                        <?php        
                                                            }
                                                        }
                                                    ?>                                                    
                                                    <input class="<?php echo strlen($val->options) > 0 ? 'toggle-opt':'' ?>" data-name="<?php echo $val->name; ?>" type="checkbox" name="filters[<?php echo $val->name; ?>]" value="<?php echo $val->filter_value; ?>"  disabled="disabled" <?php echo $click; ?> <?php echo $checked  ?> />
                                                   <span><?php echo $val->filter_label; ?></span><br/> 
                                                   <?php if($val->note != '' || $val->note !== 'NULL'): ?>
                                                    <span class="note"><?php echo $val->note; ?></span>
                                                   <?php endif; ?>                                                     
                                                </label>
                                                <?php if($val->name == 'filter_by_age'): ?>
                                                    <div id="age_slider" style="display:<?php echo isset($filters['age']) && $filters['age'] != '' ? 'block':'none' ?>">
                                                        <input type="text" id="filter_age" name="filters[age]" value="<?php echo isset($filters['age']) && $filters['age'] != '' ?  $filters['age']:'';  ?>" />
                                                    </div>
                                                <?php endif; ?>
                                                <?php if( strlen($val->options) > 0 ): ?>
                                                   <div class="optionsfil options-<?php echo $val->name; ?>" <?php echo $optionsDisplay; ?> style="margin-bottom: 10px;"/> 
                                                     <?php $optionsFil = @$filters['options'][$val->name] ?>
                                                     <?php foreach(@unserialize($val->options) as $options): ?> 
                                                        <label class="control-label"> <input type="checkbox" name="filters[options][<?php echo $val->name; ?>][<?php echo $options['name'] ?>]" value="<?php echo $options['value'] ?>" <?php echo isset($optionsFil[$options['name']]) ? "checked='checked'":""  ?> /> <?php echo $options['label']; ?></label>
                                                    <?php endforeach; ?>
                                                   </div> 
                                                <?php endif; ?>                                                
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                               </div> 
                           <?php endif; ?> 
                           <?php if(!empty($aff_filters)): ?>
                               <div class="filter-aff">
                                <h4 class="form-section"><?php echo 'Affordability Filters' ?></h4>
                                <p><span style="color: red;">*</span> For all affordability filters, X is $150 for an individual, $200 for an individual + spouse, $250 for a family.</p>
                                <div class="form-group">                            
                                    <label class="control-label col-md-3">&nbsp;</label>
                                    <div class="col-md-8">
                                        <?php foreach($aff_filters as $key => $val): ?>
                                            <?php
                                                        $checked = '';
                                                        if( isset($filters[$val->name]) && $filters[$val->name] === $val->filter_value ){
                                                            $checked = 'checked="checked"';
                                                        }
                                            ?>
                                            <label id="aff_<?php echo $val->filter_id ?>" style="display:none;">
                                                <input type="radio" name="filters[<?php echo $val->name; ?>]" value="<?php echo $val->filter_value; ?>" class="form-control" disabled="disabled" <?php echo $checked  ?>  />
                                               <span><?php echo $val->filter_label; ?></span><br/> 
                                               <?php if($val->note != '' || $val->note !== 'NULL'): ?>
                                                <span class="note"><?php echo $val->note; ?></span>
                                               <?php endif; ?>                                                  
                                            </label>

                                        <?php endforeach; ?>
                                    </div>
                                </div> 
                             </div>      
                           <?php endif; ?>
                            <div class="live_transfer" style="display:none;">
<!--                             <h4 class="form-section"><?php echo 'Precision Targeting' ?></h4>
                            <p>Every one of our Live Transfers is guaranteed to be in one of your targeted states, under 65 years old, and has said they want to speak with a licensed health insurance agent. By using the filters below, you can focus your campaign to only target the highest qualified prospects.</p>
                            <div class="form-group">                                
                                <label class="control-label col-md-3">&nbsp;</label>
                                <div class="col-md-8 ">
                                    <div class="checkbox-list">
                                        <label>
                                           <input type="checkbox" name="filters[major_medical_conditions]" value="exclude"  />
                                           <span>Only target leads who have indicated they have no major medical conditions</span><br/> 
                                           <span class="note">Enabling this filter will increase your minimum bid by <strong class="text-green">$5.00</strong></span>
                                        </label>                                    
                                        <label>
                                           <input type="checkbox" name="filters[filter_by_age]"  onClick="toggleAge(this)" value="1"/>
                                           <span>Only target leads between certain age ranges</span><br/> 
                                           <span class="note">Enabling this filter will increase your minimum bid by <strong class="text-green">$2.50</strong></span>
                                        </label>
                                        <div id="age_slider" style="display:none">
                                            <input type="text" id="filter_age" name="filters[age]" value="" />
                                        </div>                                                                        
                                        <label>
                                           <input type="checkbox" name="filters[filter_by_zip]"  onClick="toggleLocation('zip-group')"/>
                                           <span>Only target leads who live in specific zip codes</span><br/> 
                                           <span class="note">Enabling this filter will increase your minimum bid by <strong class="text-green">$2.50</strong></span>
                                        </label>
                                    </div>                                    
                                </div>
                            </div> -->

<!-- 
 -->
                           </div> <!-- .live_transfer --> 
                           <!-- Location Targeting -->
                           <div class="location_target">
                           <h4 class="form-section"><?php echo 'Location Targeting' ?></h4>
                           <p>Target your campaign so you only receive leads from certain states or zip codes. Each campaign can target states or zip codes, but not both. If you would like to target both zip codes and states, create separate campaigns for each category.</p>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "Your campaign is currently targeting:"; ?></label>
                                <div class="col-md-4">
                                    <div class="btn-target-switch">
                                        <input type="checkbox" id="loc-switch" class="make-switch" data-off-text="Zip" data-on-text="state" <?php if($campaign->ref_zipcodes == '') { echo "checked"; }?> />
                                        <input type="hidden" name="location-switch" id="location-switch">
                                    </div>                                    
                                </div>
                            </div>                           
                           <div class="state-group">                            
                           <div class="form-group">
                              <label class="control-label col-md-3">&nbsp;</label>
                              <div class="col-md-6 ">
                                <div id="map" style="width: 500px; height: 300px;"></div>
                                <div id="clicked-state"></div>                                
                              </div>                            
                           </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Targeted states:</label>
                                <div class="control-label label-sates col-md-5 ">
                                    <strong class="count-state"></strong>&nbsp; states selected.
                                </div>
                                <div class="col-md-4 "> 
                                    <button class="btn green" id="clear" type="button" >CLEAR SELECTION</button>
                                </div>                               
                            </div>                          
                            <?php 
                                $states = $this->State_model->getAll();
                            ?>                      
                            <div class="form-group">
                                <label class="control-label col-md-3">&nbsp;</label>
                                <div class="col-md-9 ">
                                    <div class="">
                                        <?php if(count($states) > 0) :?>   
                                            <?php $i=0;foreach($states as $state): ?>
                                                <?php if( $i == 0 || $i%12 == 0 ){ echo '<div class="col-md-3">'; } ?>
                                                <label style="width:100%;">
                                                   <input type="checkbox" class="state state-<?php echo $state['abbreviation']; ?>" data-state="<?php echo $state['abbreviation']; ?>" name="state[]" value="<?php echo $state['abbreviation']; ?>" data-title="" />
                                                   <span><?php echo $state['name']; ?></span>                                           
                                                </label>
                                                <?php $i++; ?>
                                                <?php if(  $i%12 == 0 ){ echo '</div>'; } ?>                                                                            
                                            <?php endforeach; ?>
                                       <?php endif; ?>     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .state_group  -->
                    <div class="zip-group" style="display:none;">
                        <div class="form-group">
                            <label class="control-label col-md-3"><?php echo "Enter zip codes below to add them to your list of targeted zip codes."; ?></label>
                            <div class="col-md-9 ">
                                <input type="text" name="ref_zipcodes" data-role="tagsinput" class="form-control" value="<?php echo $campaign->ref_zipcodes; ?>" />
                            </div>                            
                        </div>    
                    </div><!-- .zip-group -->
                    </div> <!-- Location Targeting -->
                </div><!-- .filters -->       

                       <h4 class="form-section"><?php echo 'Maximum Bid' ?></h4>
                        <p><strong>Set the maximum price you are willing to pay per lead.</strong> You will never be charged more than your maximum bid, and in most cases you will be charged significantly less than your maximum bid.</p>                           
                       <div class="form-group">
                            <label class="control-label col-md-3">Maximum Bid<span class="required"> * </span></label>
                            <div class="col-md-2">
                                <div class="input-group max_cost">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                    <input type="text" class="form-control" name="max_cost" value="<?php echo $campaign->max_cost; ?>"/>
                                    <input type="hidden" class="form-control" name="min_cost" value="<?php echo $campaign->min_cost ?>"/>
                                </div>    
                            </div>
                       </div>
                        <!--  Delivery Schedule-->                                                   
                       <h4 class="form-section"><?php echo "Delivery Schedule"; ?></h4>
                       <p>By default, leads are delivered as soon as possible. However, if you would like your leads delivered only on certain days and/or at certain times, you may customize your delivery schedule.</p>
                       <div class="form-group">
                            <label class="control-label col-md-3">&nbsp;</label>
                            <div class="col-md-4">
                                <div class="checkbox-list">
                                    <label>                                                                             
                                            <input type="checkbox" name="custom_schedule" id="custom_schedule" <?php echo $campaign->ref_schedule != '' ? 'checked="checked"':''; ?>/><?php echo 'Customize Lead Delivery Schedule' ?>                                         
                                    </label>
                                </div>  
                            </div>                              
                       </div>                           
                       <div class="form-group schedule-time" style="display:<?php echo $campaign->ref_schedule != '' ? 'block':'none'; ?>">
                            <label class="control-label col-md-3">&nbsp;</label>
                            <div class="col-md-9">

                                <?php $schedule = array() ?>
                                <?php if($campaign->ref_schedule !== 'NULL' ): ?>
                                    <?php $scheduleTime = unserialize($campaign->ref_schedule) ?>
                                <?php endif; ?> 
     
                                <?php echo '* All times are in MST.' ?>
                                <table class="table">
                                    <tr>
                                        <th><?php echo "Monday"; ?></th>
                                        <th><?php echo "Tuesday"; ?></th>
                                        <th><?php echo "Wednesday"; ?></th>
                                        <th><?php echo "Thursday"; ?></th>
                                        <th><?php echo "Friday"; ?></th>
                                        <th><?php echo "Saturday"; ?></th>
                                        <th><?php echo "Sunday"; ?></th>
                                    </tr>
                                    <?php   $schedules = array(
                                                    '12-1 AM','1-2 AM','2-3 AM','3-4 AM','4-5 AM','5-6 AM','6-7 AM','7-8 AM','8-9 AM','9-10 AM','10-11 AM','11-12 PM','12-1 PM','1-2 PM','2-3 PM','3-4 PM','4-5 PM','5-6 PM','6-7 PM','7-8 PM','8-9 PM','9-10 PM','11-12 AM'
                                            );  
                                            $weekArr = array(0 => 'mon', 1 => 'tue', 2 => 'wed', 3 => 'thu', 4 => 'fri', 5 => 'sat', 6 => 'sun' );
                                    ?>
                                    <tr>
                                       <?php for($i = 0; $i<7; $i++ ): ?>  
                                           <?php
                                                $time = array();
                                                if(isset($scheduleTime[$weekArr[$i]])){
                                                    $time = $scheduleTime[$weekArr[$i]];
                                                }                                                
                                           ?>
                                           <td>                                            
                                           <?php foreach($schedules as  $key => $schedule): ?>
                                            
                                              <label class="col-md-12 schedule <?php echo in_array($schedule, $time) ? 'select':''; ?>" id="schedule-<?php echo "$i"."$key"; ?>">     
                                                <input type="checkbox" name="schedule_time[<?php echo $weekArr[$i]; ?>][]" value="<?php echo $schedule; ?>" data-id="<?php echo "$i"."$key"; ?>" <?php echo in_array($schedule, $time) ? 'checked="checked"':''; ?>/>
                                                    <span ><?php echo $schedule; ?></span>                                                
                                              </label>      
                                           
                                           <?php endforeach; ?> 
                                            </td>
                                       <?php endfor; ?>
                                    </tr>
                                </table>
                            </div>
                       </div>
                       <h4 class="form-section"><?php echo "Call Transfer and Lead Delivery Settings"; ?></h4>
                       <p>Please enter the phone number you would like us to use when trying to transfer a lead to you.</p>
                       <div class="form-group">
                            <label class="control-label col-md-3">Phone Number<span class="required"> * </span></label>
                            <div class="col-md-4">
                                <div class="input-group delivery_phone_err">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="text" class="form-control" name="delivery_phone" value="<?php echo $campaign->delivery_phone ?>"/>
                                </div>                                
                            </div>

                       </div>
                       <p>We can send you a copy of your leads to you via email. Just enter a list of email addresses you want the leads sent to below.</p>
                       <div class="form-group">
                             <label class="control-label col-md-3">Email Subscribers</label>
                             <div class="col-md-9">
                                <input type="text" name="delivery_email" data-role="tagsinput" id="email_subscriber" class="form-control" value="<?php echo $campaign->delivery_email; ?>" />
                             </div>                            
                       </div>
                       <div class="form-group">
                            <label class="control-label col-md-3">&nbsp;</label>
                            <div class="col-md-9">
                                <div class="email-test">
                                    <button type="button" class="btn green" onClick="emailTest()"><?php echo "Email Test Lead"; ?></button>
                                </div> 
                            </div>
                       </div>
                       <h4 class="form-section"><?php echo "Call Throttling Settings"; ?></h4>
                       <p>You can enable lead throttling here. When lead throttling is enabled, we will only send one lead during the interval you set. The timer starts as soon as the lead has been transferred to you.</p>
                       <div class="form-group">
                            <label class="control-label col-md-3">&nbsp;</label>
                            <div class="col-md-9">
                                <div class="checkbox-list">
                                    <label>
                                        <input class="form-control" type="checkbox" name="" id="callthrot"  /> <?php echo "Enable Lead Throttling" ?>
                                    </label>
                                </div>
                            </div>
                       </div>
                       <div class="form-group callthrot" style="display:none;">
                            <label class="control-label col-md-3">&nbsp;</label>
                            <div class="col-md-4">
                                <select name="lead_throtle" class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="<?php echo "5 minutes"; ?>"  <?php echo $campaign->lead_throtle == "5 minutes" ? 'selected="selected"':''; ?>><?php echo "5 minutes"; ?></option>
                                    <option value="<?php echo "10 minutes"; ?>" <?php echo $campaign->lead_throtle == "10 minutes" ? 'selected="selected"':''; ?>><?php echo "10 minutes"; ?></option>
                                    <option value="<?php echo "15 minutes"; ?>" <?php echo $campaign->lead_throtle == "15 minutes" ? 'selected="selected"':''; ?>><?php echo "15 minutes"; ?></option>
                                    <option value="<?php echo "20 minutes"; ?>" <?php echo $campaign->lead_throtle == "20 minutes" ? 'selected="selected"':''; ?>><?php echo "20 minutes"; ?></option>
                                    <option value="<?php echo "25 minutes"; ?>" <?php echo $campaign->lead_throtle == "25 minutes" ? 'selected="selected"':''; ?>><?php echo "25 minutes"; ?></option>
                                    <option value="<?php echo "30 minutes"; ?>" <?php echo $campaign->lead_throtle == "30 minutes" ? 'selected="selected"':''; ?>><?php echo "30 minutes"; ?></option>
                                </select>
                            </div>
                       </div>
                       <!-- Location Targeting -->
                       <h4 class="form-section"><?php echo 'Daily Budget' ?></h4>
                        <p>Limit the amount of money this campaign will spend per day. Setting the daily budget to $0 will give this campaign an unlimited budget.</p>                           
                       <div class="form-group">
                            <label class="control-label col-md-3">Daily Budget</label>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                    <input type="text" class="form-control" name="daily_budget" value="<?php echo $campaign->daily_budget ?>"/>
                                </div>    
                            </div>
                       </div>
                       <h4 class="form-section"><?php echo 'Campaign Status' ?></h4>
                       <p>Set this campaign to active to start receiving leads. A campaign can be set active or paused at any time. You will not receive leads from this campaign if it is paused, even if your delivery schedule is currently active.</p>                           
                       <div class="form-group">
                            <label class="control-label col-md-3">&nbsp;</label>
                            <div class="col-md-5">                                
                                     <label>
                                           <?php if($campaign->active == 1): ?>
                                                <?php $check = 'checked="checked"' ?>
                                           <?php else: ?>     
                                                <?php $check = ''; ?>
                                           <?php endif; ?>
                                           <input type="checkbox" data-on-text="Active" data-off-text="Paused" name="active" class="make-switch" <?php echo $check; ?> data-on-text="<?php echo ACTIVE; ?>" data-off-text="<?php echo DEACTIVE; ?>"/> 
                                        <!-- <input type="radio" name="active" value="<?php echo DEACTIVE; ?>" checked="checked" class="make-switch"/> Paused -->
                                    </label>                                
                                        <!-- <label><input type="radio" name="active" value="<?php echo ACTIVE; ?>" />Active</label> -->                                                                  
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
                </div>
            </div>
        </form>
    </div>  
</div>

<script type="text/javascript">
    jQuery(function(){             
        jQuery('#active').val("<?php echo $bid->active ?>");
        jQuery('#bid').addClass('active');
        jQuery('.campaign').addClass('active');       
    });


    var FormWizard = function () {
    return {
        //main function to initiate the module
        init: function () {

            if (!jQuery().bootstrapWizard) {

                return;
            }

            function format(state) {
                if (!state.id) return state.text; // optgroup
                return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            }

            var form = $('#submit_form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);

            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    //account
                    auct_type: {                        
                        required: true
                    },
                    campcat: {                        
                        required: true
                    },
                    bid_id: {                        
                        required: true
                    }, 
                    user_id:{
                       required: true, 
                    }, 
                    max_cost:{
                       required: true, 
                    },
                    name:{
                      required: true,   
                    },
                    delivery_phone:{
                      required: true  
                    }                                        
                },

                messages: { // custom messages for radio buttons and checkboxes
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("name") == "auct_type") { // for uniform radio buttons, insert the after the given container
                        error.insertAfter("#form_gender_error");
                    } else if (element.attr("name") == "bid_id") { // for uniform checkboxes, insert the after the given container
                        error.insertAfter("#form_bid_error");
                    }else if (element.attr("name") == "delivery_phone") { // for delivery phone , insert the after given class
                        error.insertAfter(".delivery_phone_err");
                    } 
                    else if (element.attr("name") == "max_cost") { // for delivery phone , insert the after given class
                        error.insertAfter(".max_cost");
                    }else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    
                    App.scrollTo(error, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                },

                submitHandler: function (form) {                    
                    form.submit()
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
                }

            });

            var displayConfirm = function() {
                var input = $('[name="auct_type"]', form);
                var text  = '';
                input.each(function(){                    
                    if( jQuery(this).is(":checked") ){
                        text  = jQuery(this).val();  
                    } 
                });
                
                if( text === '<?php echo AUCTION_TYPE_LIVE_TRANSFER ?>' ){
                    jQuery('.<?php echo AUCTION_TYPE_LIVE_TRANSFER?>').show();
                    jQuery('.<?php echo AUCTION_TYPE_LIVE_TRANSFER?>').find('input').prop( "disabled", false );
                }else{
                    jQuery('.<?php echo AUCTION_TYPE_LIVE_TRANSFER?>').hide();
                    jQuery('.<?php echo AUCTION_TYPE_LIVE_TRANSFER?>').find('input').prop( "disabled", true );
                }                
                $('#tab4 .form-control-static', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));                        
                    } else if ($(this).attr("data-display") == 'payment[]') {
                        var payment = [];
                        $('[name="payment[]"]:checked', form).each(function(){ 
                            payment.push($(this).attr('data-title'));
                        });
                        $(this).html(payment.join("<br>"));
                    }
                });
            }

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    displayConfirm();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.page-title'));
            }

            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    return false;
                    
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }

                    if(index == 1){
                       var campcat = jQuery('#campcat').val();
                       jQuery.ajax({
                         url : '<?php echo site_url("age/campaign/checkvertical") ?>',
                         method : 'POST',   
                         dataType : 'json',                         
                         data : {vertical : campcat, isAjax : true},
                         async : false,
                         success : function(result){
                            
                            jQuery('#tab2').find('.radio-list > label').hide();
                            jQuery.each(result.auctions,function(index, val){
                                jQuery('#auct_type'+val).show();                            
                            }); 
                            jQuery('#tab3').find('.radio-list > label').hide();
                            jQuery.each(result.bid,function(index,val){                             
                                jQuery('#bid_id'+val).show();
                            });

                            if( typeof result.filters['precision'] != 'undefined' && result.filters['precision'].length > 0 ){
                                 jQuery('.filter-prec').show();
                                jQuery.each(result.filters['precision'],function(index,val){
                                    jQuery('#prec_'+val).show();
                                    jQuery('#prec_'+val).find('div').removeClass('disabled');
                                    jQuery('#prec_'+val).find('input').removeAttr('disabled');                                
                                });
                            }else{
                                jQuery('.filter-prec').hide();
                            }
                            if( typeof result.filters['affordability'] != 'undefined' &&  result.filters['affordability'].length > 0 ){
                                jQuery('.filter-aff').show();
                                jQuery.each(result.filters['affordability'],function(index,val){
                                    jQuery('#aff_'+val).show();
                                    jQuery('#aff_'+val).find('div').removeClass('disabled');
                                    jQuery('#aff_'+val).find('input').removeAttr('disabled');                                
                                });
                            }else{
                                jQuery('.filter-aff').hide();
                            }                            
                         }
                       });
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });
            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
                //alert('Finished! Hope you like it :)');
            }).hide();
        }
    };

}();

jQuery(document).ready(function() {    
    var fillArray = Array();
    FormWizard.init();
     $('.text-blue').tooltip(); 
      $('#map').usmap({      
        stateHoverStyles: {fill: '#888888'},  
        'click' : function(event, data) {
               var a = fillArray.indexOf(data.name);
               if ( a > -1 ){
                    jQuery('.state-'+data.name).prop('checked',false);
                    // jQuery('.state-'+data.name).trigger('click');
                    jQuery('.state-'+data.name).parent('span').removeClass('checked');
                    $('#' + data.name).css('fill', '');
                    fillArray.splice(a, 1);
               }else{
                    $('#' + data.name).css('fill', '#26A1AB'); 
                    fillArray.push(data.name);
                     jQuery('.state-'+data.name).prop('checked',true);
                    // jQuery('.state-'+data.name).trigger('click');
                    jQuery('.state-'+data.name).parent('span').addClass('checked');
               }
               jQuery('.count-state').html($(".state:checked").length);                                 
        }
      });
      jQuery(document).on('click','.state',function(){
         var id = jQuery(this).attr('data-state');
         if( jQuery(this).is(":checked") == true ){
            jQuery('#'+id).css('fill', '#26A1AB');
            fillArray.push(id);
         }else{            
            jQuery('#' + id).css('fill', '');
            var a = fillArray.indexOf(id); 
            if ( a > -1 ){
               fillArray.splice(a, 1); 
            }
         } 
         jQuery('.count-state').html($(".state:checked").length);
      });

      jQuery(document).on('click','#clear',function(){
         var len = $(".state:checked").length;
         if(len > 0){
            for(var i=0;i< len;i++){
               jQuery('#' + fillArray[i]).css('fill', '');                
               jQuery('.state-'+fillArray[i]).attr('checked',false);
               jQuery('.state-'+fillArray[i]).parent('span').removeClass('checked');                               
            }
            fillArray = Array();
         }
         jQuery('.count-state').html($(".state:checked").length);
      });

      jQuery(document).on('click','#custom_schedule',function(){
         jQuery('.schedule-time').toggle();
      });
      jQuery(document).on('click','#callthrot',function(){
         jQuery('.callthrot').toggle();
      });
      //$('#email_subscriber').inputTags();   
      $("[name='active']").bootstrapSwitch();
      //$("[name='loc_zip']").inputTags();
      $("#loc-switch").bootstrapSwitch();
      var age_slider_from = 0;
      var age_slider_to = 0;
      if( $('#filter_age').val() !== ''){
        var value = $('#filter_age').val();
        var numbers = value.split(";");
        age_slider_from = numbers[0];
        age_slider_to = numbers[1];        
      }              
      $("#filter_age").ionRangeSlider({
            type: "int",
            grid: false,
            min: 18,
            max: 120,
            from: age_slider_from,
            to: age_slider_to,
            prefix: ""        
      });
      jQuery(document).on('click','.schedule input',function(){
            var data_id = jQuery(this).attr('data-id');
            if(jQuery('#schedule-'+data_id).hasClass('select') == true){
                jQuery('#schedule-'+data_id).removeClass('select');    
            }else{
                jQuery('#schedule-'+data_id).addClass('select');
            }        
      });
      <?php if($campaign->campaign_id != ''): ?>
            jQuery('.button-next').trigger('click');
            jQuery('.button-next').trigger('click');
            jQuery('.button-next').trigger('click');

           <?php if($campaign->lead_throtle != 'NULL'): ?>
                jQuery('#callthrot').trigger('click');
           <?php endif; ?>
           <?php if($campaign->ref_states != 'NULL'): ?>                
                <?php foreach(explode(',',$campaign->ref_states) as $state): ?>
                    jQuery('.state-<?php echo $state  ?>').trigger('click');
                <?php endforeach; ?>    
           <?php endif; ?>
           /* For Check state or zipcode select */
           <?php if($campaign->ref_zipcodes == ''): ?> 
                jQuery('.state-group').show();
                jQuery('.zip-group').hide();
                jQuery('#location-switch').val('state');
           <?php else : ?>
                jQuery('.state-group').hide();
                jQuery('.zip-group').show();
                jQuery('#location-switch').val('zipcode');   
           <?php endif;?>
           /* End For Check state or zipcode select */
      <?php endif; ?>
      $("[name='delivery_phone']").inputmask("mask",{mask:"<?php echo PHONE_FORMAT; ?>"});

      jQuery('#loc-switch').on('switchChange.bootstrapSwitch', function(event, state) {   
              var status = '';
              if(state == true){
                jQuery('.state-group').show();
                jQuery('.zip-group').hide();
                jQuery('#location-switch').val('state');
              }else{
                jQuery('.state-group').hide();
                jQuery('.zip-group').show();
                jQuery('#location-switch').val('zipcode');
              }
        });

      jQuery(document).on('click','.toggle-opt',function(){
         var name = jQuery(this).attr('data-name');
         if(jQuery(this).is(':checked') == true){
            jQuery('.options-'+name).show();
         }else{
            jQuery('.options-'+name).hide();
         }
      });
});
function toggleLocation(element)
{
    jQuery('.state-group').toggle();
    jQuery('.zip-group').toggle();
}
function toggleAge(element)
{   
    if( jQuery(element).is(':checked') == true){
        jQuery('#age_slider').css('display','block');    
    }else{
        jQuery('#age_slider').css('display','none');    
    }    
}
function emailTest()
{
    var emails   = jQuery('#email_subscriber').val();
    var camcat   = jQuery('#campcat').find('option:selected').text();
    var auctType = jQuery("[name='bid_id']:checked").attr('data-title');
    jQuery.ajax({
        url : '<?php echo site_url("age/campaign/testemail") ?>',
        method : 'POST',
        dataType : 'json',
        data : {mails : emails,isAjax : true,vertical: camcat,aucttype: auctType},       
        success : function(res){
          console.log(res);
        },
    }); 
}
function popopCondition(vertical)
{
    var isPop = jQuery(vertical).find('option:selected').attr('data-ispop');
    if(isPop == 1){
        var popText = jQuery(vertical).find('option:selected').attr('data-poptext');
      swal({
                    title: "Please Agree to the Following:",
                    text: popText,
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true
                },
          function(isConfirm){                                                                                                   
            if (isConfirm == false){                                                     
                jQuery(vertical).find('option:selected').removeAttr('selected');
                jQuery(vertical).find('option').eq(0).attr('selected','selected');
            }
   });
  }
}
</script>