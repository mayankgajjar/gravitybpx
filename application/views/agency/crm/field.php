<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Add New Field</h4>
</div>
<form class="form-horizontal" role="form" id="custom-field-frm" onsubmit="formSubmit(event)">     
    <div class="message"></div>
    <div class="modal-body">
        <div class="form-body form-custom-field">
            <input type="hidden" name="lead_id" value="<?php echo encode_url($lead) ?>" />
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Select Field' ?></label>
                <div class="col-md-3 control-label">
                    <select name="field" class="form-control" onchange="javascript:refreshOptions(this.value)">
                        <option value="add_new">Add New</option>
                        <?php foreach($customFields as $field): ?>
                        <option value="<?php echo $field->field_id ?>"><?php echo $field->field_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Field Name' ?><span class="required">*</span></label>
                <div class="col-md-5">
                    <input type="text" name="field_name" class="form-control" /> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Field Label' ?><span class="required">*</span></label>
                <div class="col-md-5">
                   <input type="text" name="field_label" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Is required' ?></label>
                <div class="col-md-5">                    
                    <label class="radio-inline"><input type="radio" name="field_required" value="yes" /><?php echo 'Yes' ?></label>
                    <label class="radio-inline"><input type="radio" name="field_required" value="no" checked /><?php echo 'No' ?></label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Field Type' ?></label>
                <div class="col-md-5">
                    <select name="field_type" class="form-control" onchange="chageOptions(this.value)">
                        <option value="text" selected="selected" label="text">text</option>
                        <option value="select" label="select">select</option>
                        <option value="textarea" label="textarea">textarea</option>
                        <option value="radio" label="radio">radio</option>
                        <option value="checkbox" label="checkbox">checkbox</option>
                        <option value="phone" label="phone">phone</option>
                        <option value="email" label="email">email</option>
                    </select>
                </div>
            </div>
            <div class="form-group del-group" style="display: none;">
                <label class="col-md-3 control-label"><?php echo 'Is deleted' ?></label>
                <div class="col-md-5">
                    <label class="radio-inline"><input type="radio" name="is_deleted" value="y" />Yes</label>
                    <label class="radio-inline"><input type="radio" name="is_deleted" value="n" />No</label>
                </div>
            </div>
            <div class="form-group options-group" style="display: none;">
                <label class="col-md-3 control-label"><?php echo 'Options' ?></label>
                <div class="col-md-5">
                    <div class="line">
                        <input type="text" name="field_options[]" class="form-control" />
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn green" type="button" onclick="addOption()">&plus;</button>
                </div>
            </div>
        </div>
    </div>   
    <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn blue">Save changes</button>
    </div>
</form>  

<script>
jQuery('#custom-field-frm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            field_name : {
                required: true,                    
            },
            field_label : {
                required: true,                    
            },
        },
        highlight: function (element) { // hightlight error inputs
             $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
function chageOptions(value){    
    switch(value){
        case 'text':
        case 'textarea':
        case 'phone':
        case 'email':
            jQuery('.options-group').hide();
            break;
        case 'select':
        case 'radio':
        case 'checkbox':
            jQuery('.options-group').show();
            break;
    }
}
function addOption(){
    var html = '<div class="form-group"><label class="col-md-3 control-label"></label><div class="col-md-5"><div class="line"><input type="text" name="field_options[]" class="form-control" /></div></div><div class="col-md-1"><button class="btn green" type="button" onclick="addOption()">&plus;</button></div><div class="col-md-1"><button class="btn green" type="button" onclick="removeOption(this)">&times;</button></div></div>';
    jQuery('.form-custom-field').append(html);
}
function removeOption(ele){
    jQuery(ele).parent('div').parent('div').remove();
}
function formSubmit(event){
    event.preventDefault();
    var postData = jQuery('#custom-field-frm').serialize();
    jQuery.ajax({
        url : '<?php echo site_url("age/lead/fieldedit") ?>',
        method : 'post',
        dataType : 'json',
        data : postData,
        success : function(result){
            var flag = Boolean(result.success);
            jQuery('.message').html(result.html);
            renderCustomFields();
            refreshOptions('add_new');
            setTimeout(function(){
                jQuery('#ajax').modal('hide');
            }, 1000);            
        }
    });
}
function refreshOptions(optionId){
    if(optionId > 0){
        jQuery('.del-group').show();
        jQuery('[name="field_type"] option').removeAttr('selected');
        jQuery('.line').parent('div').parent('div').each(function(){
            if(jQuery(this).hasClass('options-group')){
                jQuery(this).find('input').val('');
            }else{
                var ele = jQuery(this).find('button').eq(1);                
                removeOption(ele);               
            }
        });        
        jQuery.ajax({
            url : '<?php echo site_url("age/lead/refreshoption") ?>',
            method  : 'post',
            dataType : 'json',
            data : {is_ajax : true, option : optionId},
            success : function(result){                
                var flag = Boolean(result.success);
                if(flag){
                    var fieldId = result.json.field_id;
                    var fieldName = result.json.field_name;
                    var fieldLabel = result.json.field_settings.label;
                    var isRequired = result.json.field_settings.required;
                    var fieldType = result.json.field_settings.type;
                    var options = result.json.field_settings.options;
                    if(isRequired == 'yes'){
                        jQuery('[value="yes"]').trigger('click');
                    }else{
                        jQuery('[value="no"]').trigger('click');
                    }
                    jQuery('[name="field_name"]').val(fieldName);
                    jQuery('[name="field_label"]').val(fieldLabel);
                    jQuery('[name="field_type"] option').each(function(){
                        if(jQuery(this).attr('value') == fieldType){
                            jQuery(this).attr('selected', 'selected');
                        }
                    });
                    chageOptions(fieldType);
                    if(fieldType == 'select' || fieldType == 'radio' || fieldType == 'checkbox'){
                        jQuery(options).each(function(index, value){
                            if(index == 0){
                                jQuery('.options-group').find('input').val(value);
                            }else{
                                var html = '<div class="form-group"><label class="col-md-3 control-label"></label><div class="col-md-5"><div class="line"><input type="text" name="field_options[]" class="form-control" value="'+value+'" /></div></div><div class="col-md-1"><button class="btn green" type="button" onclick="addOption()">&plus;</button></div><div class="col-md-1"><button class="btn green" type="button" onclick="removeOption(this)">&times;</button></div></div>';
                                jQuery('.form-custom-field').append(html);                                
                            }                            
                        });                        
                    }
                }
            }
        });
    }else{        
        jQuery('.del-group').hide();
        jQuery('[name="field_name"]').val('');
        jQuery('[name="field_label"]').val('');
        jQuery('[value="no"]').trigger('click');
        jQuery('.line').parent('div').parent('div').each(function(){
            if(jQuery(this).hasClass('options-group')){
                jQuery(this).find('input').val('');
            }else{
                var ele = jQuery(this).find('button').eq(1);                
                removeOption(ele);               
            }
        });
    }
}
</script>    