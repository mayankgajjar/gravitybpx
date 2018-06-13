<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Add New Field</h4>
</div>
<form class="form-horizontal" role="form" id="custom-field-frm" onsubmit="formSubmit(event)">     
    <div class="message"></div>
    <div class="modal-body">
        <div class="form-body form-custom-field">
            <input type="hidden" name="lead_id" value="<?php echo encode_url($lead) ?>" />
            <input type="hidden" name="is_deleted" value="y" />
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo 'Select Field' ?></label>
                <div class="col-md-6">
                    <select name="field" class="form-control">
                        <option value=""><?php echo 'Please select field to remove' ?></option>
                        <?php foreach($customFields as $field): ?>
                        <option value="<?php echo $field->field_id ?>"><?php echo $field->field_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>   
    <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn blue"><?php echo 'Delete Field' ?></button>
    </div>
</form>  

<script>
jQuery('#custom-field-frm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            field : {
                required: true,                    
            },
        },
        highlight: function (element) { // hightlight error inputs
             $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });

function formSubmit(event){
    event.preventDefault();
    var postData = jQuery('#custom-field-frm').serialize();
    jQuery.ajax({
        url : '<?php echo site_url("age/lead/fieldelete") ?>',
        method : 'post',
        dataType : 'json',
        data : postData,
        success : function(result){
            var flag = Boolean(result.success);
            jQuery('.message').html(result.html);
            renderCustomFields();            
            setTimeout(function(){
                jQuery('#ajaxremove').modal('hide');
            }, 1000);            
        }
    });
}
</script>