<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $title; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title"><?php echo $title; ?> </h3>
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
<form name="leadForm" id="leadForm" class="form-horizontal" method="post">    
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
        <div class="actions">
            <?php if($lead->lead_id != '') : ?>
                <?php if($lead->status != '' && $lead->status == 'Lead') :?>
                    <a href="<?=base_url('adm/lead/change_status/Opportunity/'.encode_url($lead->lead_id))?>" class="btn green"><i class="fa fa-refresh"></i> Convert Lead to Opportunities</a>
                    <a href="<?=base_url('adm/lead/change_status/Client/'.encode_url($lead->lead_id))?>" class="btn green"><i class="fa fa-refresh"></i> Convert Lead to Client</a>
                <?php elseif($lead->status != '' && $lead->status == 'Opportunity') :?>
                    <a href="<?=base_url('adm/lead/change_status/Lead/'.encode_url($lead->lead_id))?>" class="btn green"><i class="fa fa-refresh"></i> Convert Opportunities to Lead</a>
                    <a href="<?=base_url('adm/lead/change_status/Client/'.encode_url($lead->lead_id))?>" class="btn green"><i class="fa fa-refresh"></i> Convert Opportunities to Client</a>
                <?php elseif($lead->status != '' && $lead->status == 'Client') :?>
                    <a href="<?=base_url('adm/lead/change_status/Lead/'.encode_url($lead->lead_id))?>" class="btn green"><i class="fa fa-refresh"></i> Convert Client to Lead</a>
                    <a href="<?=base_url('adm/lead/change_status/Opportunity/'.encode_url($lead->lead_id))?>" class="btn green"><i class="fa fa-refresh"></i> Convert Client to Opportunities</a>
                <?php endif; ?>
            <?php endif; ?>            
        </div>
    </div>
    <div class="portlet-body">        
            <div class="form-body">
                <input type="hidden" name="status" value="<?php echo $status ?>" />
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agency' ?></label>
                    <div class="col-md-4">
                        <?php  $tree = buildTree($agencies,0); ?>
                        <select name="agency_id" class="form-control" class="agency_id" onchange="javascript:selectAgent(this.value)">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <?php echo printTree($tree,0, null, isset($lead->agency_id) ? $lead->agency_id : '' ); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agents' ?></label>
                    <div class="col-md-4">                        
                        <select class="form-control selectpicker" name="user">
                            <option value=""><?php echo 'Please Select Agent' ?></option>
                            <?php foreach($agents as $agent): ?>
                                <optgroup label="<?php echo $agent['name'] ?>">
                                    <?php if($agent['total'] > 0): ?>
                                        <?php $ages = explode(',',$agent['names']); ?>
                                        <?php $ids = explode(',',$agent['agents'] ) ?>
                                        <?php foreach($ages as $key => $ag): ?>
                                            <option data-agency="<?php echo $agent['name'] ?>" value="<?php echo encode_url($ids[$key]) ?>" <?php echo isset($lead->user) && $lead->user == $ids[$key] ? 'selected="selected"':''; ?>><?php echo $ag ?></option>
                                        <?php endforeach; ?>                                    
                                    <?php endif; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>                
                <div class="form-group">
                    <label class="col-md-3  control-label"><?php echo 'Name'  ?><span class="required">*</span></label>
                    <div class="col-md-2">
                        <input type="text" name="first_name" placeholder="First Name" class="form-control" value="<?php echo $lead->first_name ?>" />
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="middle_name" placeholder="Middle Name" class="form-control" value="<?php echo $lead->middle_name ?>" />
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="last_name" placeholder="Last Name" class="form-control" value="<?php echo $lead->last_name ?>" />
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="col-md-3  control-label"><?php echo 'Email' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="email" class="form-control" value="<?php echo $lead->email ?>"/>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3  control-label"><?php echo 'Dial Code' ?></label>
                    <div class="col-md-1">
                        <input type="text" name="dialcode" class="form-control" value="<?php echo $lead->dialcode ?>" />
                    </div>
                </div>                  
                <div class="form-group">
                    <label class="col-md-3  control-label"><?php echo 'Phone' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="phone" class="form-control" value="<?php echo $lead->phone ?>" />
                    </div>
                </div> 
                <div class="form-group">                    
                    <label class="col-md-3  control-label"><?php echo 'Cell Phone' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="cellphone" class="form-control" value="<?php echo isset($lead->cellphone) && ($lead->cellphone !=0) ? $lead->cellphone : ''; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3  control-label"><?php echo 'Work Phone' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="work_phone" class="form-control" value="<?php echo isset($lead->work_phone) && ($lead->work_phone !=0) ? $lead->work_phone : ''; ?>" />
                    </div>
                </div>                
                <div class="form-group">
                    <label class="col-md-3  control-label"><?php echo 'Address' ?></label>
                    <div class="col-md-6">                                                
                        <input name="address" type="text" placeholder="<?php echo 'Street Address' ?>"  class="form-control" value="<?php echo $lead->address ?>"/>
                        <br />
                        <input name="address1" type="text" placeholder="<?php echo 'Street Address' ?>" class="form-control" value="<?php echo $lead->address1 ?>"/>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3  control-label"><?php echo 'Country' ?></label>
                    <div class="col-md-4">
                        <select name="country" class="form-control">
                            <?php foreach($countries as $country): ?>
                                <option value="<?php echo $country->sortname ?>" <?php echo optionSetValue($country->sortname, $lead->country ) ?>><?php echo $country->name ?></option>
                            <?php endforeach; ?>
                        </select>                    
                    </div>
                </div>                
                <div class="form-group">
                    <label class="col-md-3  control-label">&nbsp;</label>
                    <div class="col-md-2" >
                        <label><?php echo 'State' ?></label>
                        <select name="state" class="form-control"  onchange="javascript:selectCity(this)">
                            <option value=""><?php echo 'Please Select' ?></option>
                            <?php foreach($states as $state): ?>
                            <option value="<?php echo $state->abbreviation; ?>" data-id="<?php echo $state->id ?>" <?php echo optionSetValue($state->abbreviation, $lead->state) ?>><?php echo $state->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label><?php echo 'City' ?></label>
                        <select class="form-control" name="city">
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label><?php echo 'Zip Code' ?></label>
                        <input type="text" name="postal_code" class="form-control" value="<?php echo $lead->postal_code ?>" placeholder="Zip Code"/>
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="col-md-3  control-label"><?php echo 'Personal'  ?></label>
                    <div class="col-md-4">
                        <div class="radio-list">
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="optionsRadios4" value="M" <?php echo $lead->gender == 'M' ? 'checked' : '' ?>> <?php echo 'Male' ?> 
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="optionsRadios5" value="F" <?php echo $lead->gender == 'F' ? 'checked' : '' ?>> <?php echo 'Female' ?>
                            </label>                            
                        </div>                        
                    </div>                    
                </div>
                <div class="form-group">
                    <label class="col-md-3  control-label">&nbsp;</label>
                    <div class="col-md-2">
                        <label><?php echo 'Height' ?></label>
                        <select class="form-control" name="height" >
                            <option value=""><?php echo 'Select Height' ?></option>
                            <option value="4' 6&quot;" <?php echo optionSetValue("4' 6\"", $lead->height ) ?>>4' 6"</option>
                            <option value="4' 7&quot;" <?php echo optionSetValue("4' 7\"", $lead->height ) ?>>4' 7"</option>
                            <option value="4' 8&quot;" <?php echo optionSetValue("4' 8\"", $lead->height ) ?>>4' 8"</option>
                            <option value="4' 9&quot;" <?php echo optionSetValue("4' 9\"", $lead->height ) ?>>4' 9"</option>
                            <option value="4' 10&quot;" <?php echo optionSetValue("4' 10\"", $lead->height ) ?>>4' 10"</option>
                            <option value="4' 11&quot;" <?php echo optionSetValue("4' 11\"", $lead->height ) ?>>4' 11"</option>
                            <option value="5' 0&quot;" <?php echo optionSetValue("5' 0\"", $lead->height ) ?>>5' 0"</option>
                            <option value="5' 1&quot;" <?php echo optionSetValue("5' 1\"", $lead->height ) ?>>5' 1"</option>
                            <option value="5' 2&quot;" <?php echo optionSetValue("5' 2\"", $lead->height ) ?>>5' 2"</option>
                            <option value="5' 3&quot;" <?php echo optionSetValue("5' 3\"", $lead->height ) ?>>5' 3"</option>
                            <option value="5' 4&quot;" <?php echo optionSetValue("5' 4\"", $lead->height ) ?>>5' 4"</option>
                            <option value="5' 5&quot;" <?php echo optionSetValue("5' 5\"", $lead->height ) ?>>5' 5"</option>
                            <option value="5' 6&quot;" <?php echo optionSetValue("5' 6\"", $lead->height ) ?>>5' 6"</option>
                            <option value="5' 7&quot;" <?php echo optionSetValue("5' 7\"", $lead->height ) ?>>5' 7"</option>
                            <option value="5' 8&quot;" <?php echo optionSetValue("5' 8\"", $lead->height ) ?>>5' 8"</option>
                            <option value="5' 9&quot;" <?php echo optionSetValue("5' 9\"", $lead->height ) ?>>5' 9"</option>
                            <option value="5' 10&quot;" <?php echo optionSetValue("5' 10\"", $lead->height ) ?>>5' 10"</option>
                            <option value="5' 11&quot;" <?php echo optionSetValue("5' 11\"", $lead->height ) ?>>5' 11"</option>
                            <option value="6' 0&quot;" <?php echo optionSetValue("6' 00\"", $lead->height ) ?>>6' 0"</option>
                            <option value="6' 1&quot;" <?php echo optionSetValue("6' 1\"", $lead->height ) ?>>6' 1"</option>
                            <option value="6' 2&quot;" <?php echo optionSetValue("6' 2\"", $lead->height ) ?>>6' 2"</option>
                            <option value="6' 3&quot;" <?php echo optionSetValue("6' 3\"", $lead->height ) ?>>6' 3"</option>
                            <option value="6' 4&quot;" <?php echo optionSetValue("6' 4\"", $lead->height ) ?>>6' 4"</option>
                            <option value="6' 5&quot;" <?php echo optionSetValue("6' 5\"", $lead->height ) ?>>6' 5"</option>
                            <option value="6' 6&quot;" <?php echo optionSetValue("6' 6\"", $lead->height ) ?>>6' 6"</option>
                            <option value="6' 7&quot;" <?php echo optionSetValue("6' 7\"", $lead->height ) ?>>6' 7"</option>
                            <option value="6' 8&quot;" <?php echo optionSetValue("6' 8\"", $lead->height ) ?>>6' 8"</option>
                            <option value="6' 9&quot;" <?php echo optionSetValue("6' 9\"", $lead->height ) ?>>6' 9"</option>                            
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label><?php echo 'Weight' ?></label>
                        <input name="weight" type="text" class="form-control" value="<?php echo $lead->weight ?>"/>
                    </div>
                    <div class="col-md-2">
                        <label><?php echo 'Date of Birth' ?></label>
                        <input type="text" placeholder="mm/dd/yyyy" name="date_of_birth" class="form-control" value="<?php echo strlen($lead->date_of_birth) > 0 ? date('m/d/Y', strtotime($lead->date_of_birth)) : '' ?>"/>
                    </div>                    
                </div>
                <?php if($status == 'Opportunity') :?>
                    <div class="form-group">
                        <label class="col-md-3  control-label"><?php echo 'Opportunity Status' ?></label>
                        <div class="col-md-4">
                            <select name="opportunity_status" class="form-control" id="opportunity_status">
                                <option value="Pre-Qualified"><?php echo 'Pre-Qualified' ?></option>                            
                                <option value="Appointment Set"><?php echo 'Appointment Set' ?></option>                            
                                <option value="Quote Sent"><?php echo 'Quote Sent' ?></option>                            
                                <option value="Quote Accepted"><?php echo 'Quote Accepted' ?></option>                            
                                <option value="Deal Won"><?php echo 'Deal Won' ?></option>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>    
                <div class="form-group">
                    <label class="col-md-3  control-label"><?php echo 'Source' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="source" class="form-control" />
                    </div>
                </div>     
                <div class="form-group">
                    <label class="col-md-3  control-label"><?php echo 'Lead Status' ?></label>
                    <div class="col-md-4">
                        <select name="lead_status" class="form-control" id="lead_status">
                            <option value="1"><?php echo 'Active' ?></option>                            
                            <option value="0"><?php echo 'Inactive' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3  control-label"><?php echo 'Notes' ?></label>
                    <div class="col-md-6">
                        <textarea name="notes" class="form-control" style="height:100px;"><?php echo $lead->notes ?></textarea>
                    </div>
                </div>
            </div>

        
    </div>
    
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo 'Additional Information'; ?> </span>
        </div>
        <div class="actions">
        </div>
    </div>
    
    <div class="portlet-body">
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Mothers Maiden Name' ?></label>
                <div class="col-md-4">
                    <input type="text" name="mothers_maiden_name" class="form-control" value="<?php echo $lead->mothers_maiden_name ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Drivers License Number' ?></label>
                <div class="col-md-4">
                    <input type="text" name="license_number" class="form-control" value="<?php echo $lead->license_number ?>" />
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Social Security Number' ?></label>
                <div class="col-md-4">
                    <input type="text" name="security_number" class="form-control" value="<?php echo $lead->security_number ?>" />
                </div>
            </div> -->
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Occupation' ?></label>
                <div class="col-md-4">
                    <input type="text" name="occupation" class="form-control" value="<?php echo $lead->occupation ?>" />
                </div>
            </div>            
        </div>   
    </div>
    <?php if($lead->lead_id > 0 ): ?>
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo 'Custom Fields'; ?> </span>
        </div>
        <div class="actions">
            <a href="<?php echo site_url('adm/lead/addfield/'. encode_url($lead->lead_id)) ?>" class="btn green" type="button" data-target="#ajax" data-toggle="modal"><?php echo 'Add Field' ?></a>
            <a href="<?php echo site_url('adm/lead/removefield/'. encode_url($lead->lead_id)) ?>" class="btn green" type="button" data-target="#ajaxremove" data-toggle="modal"><?php echo 'Remove Field' ?></a>
        </div>
    </div>    

    <div class="portlet-body">
        <div class="form-body custom-fi-body">
            
        </div>                
    </div>
    <?php endif; ?>
    <div class="portlet-body">
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-4 col-md-8">
                    <button class="btn green" type="submit">Submit</button>
                    <a class="btn" href="<?php echo $cancelurl; ?>">Cancel</a>
                </div>
            </div>
        </div>        
    </div>    
</div>
</form>
<!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
        <div class="modal fade" id="ajax" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                        <span> &nbsp;&nbsp;Loading... </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ajaxremove" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                        <span> &nbsp;&nbsp;Loading... </span>
                    </div>
                </div>
            </div>
        </div>
<!-- /.modal -->
<script type="text/javascript">
    <?php if($lead->lead_id > 0): ?>
        var requireJson = <?php echo isset($requiredJson) ? $requiredJson : ''; ?>;
    <?php else: ?>
        var requireJson = '';
    <?php endif; ?>    
    jQuery(function(){
        renderCustomFields();
        var endDate = new Date();
        jQuery('[name="date_of_birth"]').datepicker({
            format: "mm/dd/yyyy",
            endDate: endDate,
            orientation: "bottom auto"
        });
        <?php if(isset($lead->lead_id) && $lead->lead_id > 0): ?> 
            selectCity(jQuery('[name="state"]'), '<?php echo $lead->city ?>')
        <?php endif; ?>
        jQuery('#leadstore').parent('a').parent('li').addClass('open');
        if('<?=lcfirst($status)?>' == 'lead'){
            jQuery('#index_lead').parent('a').parent('li').parent('ul').show();
            jQuery('#index_lead').parent('a').parent('li').addClass('active');
        }else{
            jQuery('#<?php  echo lcfirst($status) ?>').parent('a').parent('li').parent('ul').show();
            jQuery('#<?php  echo lcfirst($status) ?>').parent('a').parent('li').addClass('active');
        }
        jQuery('#leadForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                first_name : {
                    required: true,                    
                },
                last_name :{
                    required: true
                },
                email:{
                    email: true
                },
                phone:{
                    required : true,
                    digits: true,
                    minlength: 10                                  
                }
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });        
    });
    function selectAgent(agenctId){
        jQuery('#loading').modal('show');
        if(typeof agenctId == 'undefined'){
            agenctId = '';
        }
        jQuery.ajax({
            url : '<?php echo site_url('ajax/getagents') ?>',
            method : 'post',
            dataType : 'json',
            data : {is_ajax: true,id:agenctId},
            success : function(result){
                jQuery('[name="user"]').html(result.html);
                jQuery('#loading').modal('hide');
            }
        });             
    }    
    function selectCity(state,city_name){
        jQuery('#loading').modal('show');
        var state_id = jQuery(state).find(":selected").attr('data-id');
        if(typeof state_id == 'undefined'){
            state_id = '';
        }
        jQuery.ajax({
            url : '<?php echo site_url('ajax/getcity') ?>',
            method : 'post',
            dataType : 'json',
            data : {state : state_id, city : city_name},
            success : function(result){
                jQuery('[name="city"]').replaceWith(result.result);
                jQuery('#loading').modal('hide');
            }
        });
    }    
    function renderCustomFields(){
        jQuery.ajax({
            url : '<?php echo site_url("adm/lead/renderfields/". encode_url($lead->lead_id)) ?>',
            method : 'post',
            dataType : 'json',
            success : function(result){
                requireJson = result.refreshjson;
                jQuery('.custom-fi-body').html(result.html);
                jQuery.each(requireJson, function(index, value){
                    jQuery('[name="custom_field['+value.field_id+']"]').rules("add",{
                        required: true,
                    });
                });                                 
            }
        });
    }    
</script>