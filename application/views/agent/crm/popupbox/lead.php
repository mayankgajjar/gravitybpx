<style>
    .nipl-lead-model textarea,.nipl-lead-model select{
        width: 70% !important;
        display: inline-block;
    }
</style>
<div class="modal-dialog modal-lg nipl-lead-model">
    <form action="" method="post" id="lead-form" class="com-form" onsubmit="return getdata(this, event)">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
                <div class="caption font-dark">
                    <i class="fa fa-building-o font-dark"></i>
                    <span class="caption-subject bold uppercase" style="font-size: 16px;"><?php echo $title; ?></span>
                </div>
            </div>
            <input type="hidden" name="type" value="lead" class="type">
            <div class="modal-body"> 
                <div class="portlet-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">First Name <span class="required"> * </span></label> 
                            <div class="nipl_input_div">
                                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" >
                            </div>
                            
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name <span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email </label>
                            <div class="nipl_input_div">
                                <input type="email" name="email" class="form-control" id="email" placeholder="demo@exampal.com" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number  <span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address </label> 
                            <div>
                                <textarea rows="4" cols="10" name="address" class="form-control" id="address" ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">State </label>
                            <div>
                                <select name="state" class="form-control"  onchange="javascript:selectCity(this)">
                                    <option value=""><?php echo 'Please Select' ?></option>
                                    <?php foreach($states as $state): ?>
                                    <option value="<?php echo $state->abbreviation; ?>" data-id="<?php echo $state->id ?>" <?php echo optionSetValue($state->abbreviation, $lead->state) ?>><?php echo $state->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">City </label> 
                            <div>
                                <select class="form-control" name="city"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Zip Code </label> 
                            <div class="nipl_input_div">
                                <input type="text" name="postal_code" class="form-control" id="postal_code">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <input type="submit" class="btn green" id="save" name="Save_Changes" value="Save Changes" >
            </div>
        </div>
    </form>
    <!-- /.modal-content -->
</div> 
<!-- /.modal-dialog -->
<script>
    
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

    jQuery('#lead-form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true
            },
            email: {
                email: true
            },
            phone: {
                required: true,
                digits: true,
                minlength: 10
            },
        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        errorPlacement: function (error, element) { // render error placement for each input type
            if (element.attr("type") == "radio") { // for uniform radio buttons, insert the after the given container
                error.appendTo(element.parent('label').parent('div'));
            } else if (element.attr("name") == "bid_id") { // for uniform checkboxes, insert the after the given container
                error.insertAfter("#form_bid_error");
            } else {
                error.insertAfter(element); // for other inputs, just perform default behavior
            }
        },
    });
    
</script>