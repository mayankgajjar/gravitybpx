<form class="form-horizontal" method="post" id="peopleForm" onsubmit="personForm(event)">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo 'Additional Person' ?></h4>
</div>
<div class="modal-body">
    <div class="msgpepform">
    </div>
        <div class="form-group form-group-md">
            <input type="hidden" name="lead_id" value="<?php echo encode_url($leadId) ?>"/>
            <input type="hidden" name="people_id" value="<?php echo$people->people_id > 0 ? encode_url($people->people_id) : '' ?>"/>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Name' ?>:</label>
                    <div class="col-md-8">
                        <input type="text" name="name" class="form-control" value="<?php echo $people->name ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Phone' ?>:</label>
                    <div class="col-md-8">
                        <input type="text" name="phone" class="form-control" value="<?php echo $people->phone ?>" />
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Address' ?>:</label>
                    <div class="col-md-8">
                        <input type="text" name="address" class="form-control" value="<?php echo $people->address ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'State' ?>:</label>
                    <div class="col-md-8">
                        <select name="state" id="peoplestate" class="form-control"  onchange="javascript:selectCity(this)">
                            <option value=""><?php echo 'Please Select' ?></option>
                            <?php foreach($states as $state): ?>
                            <option value="<?php echo $state->abbreviation; ?>" data-id="<?php echo $state->id ?>" <?php echo optionSetValue($state->abbreviation, $people->state) ?>><?php echo $state->name ?></option>
                            <?php endforeach; ?>
                        </select>                        
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Relationship' ?>:</label>
                    <div class="col-md-8">
                        <?php 
                            $str = "Spouse,Partner,Child,Employee,Dependent,Mother,Father,Relative"; 
                            $relateArr = explode(',', $str);
                        ?>
                        <select class="form-control" name="relation">
                            <option value=""><?php echo 'Please Select' ?></option>
                            <?php foreach($relateArr as $relate): ?>
                            <option value="<?php echo $relate ?>" <?php echo optionSetValue($relate, $people->relation) ?>><?php echo $relate ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Height' ?>:</label>
                    <div class="col-md-8">
                        <input type="text" name="height" class="form-control" value="<?php echo $people->height ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Gender' ?>:</label>
                    <div class="col-md-8">
                        <select name="gender" class="form-control">
                            <option value=""><?php echo 'Please Select' ?></option>
                            <option value="Male" <?php echo optionSetValue('Male', $people->gender) ?>><?php echo 'Male' ?></option>
                            <option value="Female" <?php echo optionSetValue('Female', $people->gender) ?>><?php echo 'Female' ?></option>
                        </select>
                    </div>
                </div>                 
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Twitter' ?>:</label>
                    <div class="col-md-8">
                        <input type="text" name="tweet_hand" class="form-control" value="<?php echo $people->tweet_hand ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Notes' ?>:</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="notes"><?php echo $people->notes ?></textarea>
                    </div>
                </div>
            </div>
             <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Email' ?>:</label>
                    <div class="col-md-8">
                        <input type="text" name="email" class="form-control" value="<?php echo $people->email ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Cell Phone' ?>:</label>
                    <div class="col-md-8">
                        <input type="text" name="cell_phone" class="form-control" value="<?php echo $people->cell_phone ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'City' ?>:</label>
                    <div class="col-md-8">
                        <select class="form-control" name="city">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Zip' ?>:</label>
                    <div class="col-md-8">
                        <input type="text" name="zip" class="form-control" value="<?php echo $people->zip ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'DOB' ?>:</label>
                    <div class="col-md-8">
                        <?php 
                            $date = strtotime($people->date_of_birth);
                            if($date > 0){
                                $strdate = date('m/d/Y', $date);
                            }else{
                                $strdate = '';
                            }
                        ?>
                        <input type="text" name="date_of_birth" class="form-control" value="<?php echo $strdate ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Weight' ?>:</label>
                    <div class="col-md-8">
                        <input type="text" name="weight" class="form-control" value="<?php echo $people->weight ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Facebook' ?>:</label>
                    <div class="col-md-8">
                        <input type="text" name="fb_user_ID" class="form-control" value="<?php echo $people->fb_user_ID ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Linkedin URL' ?>:</label>
                    <div class="col-md-8">
                        <input type="text" name="linkedln_URL" class="form-control" value="<?php echo $people->linkedln_URL ?>"/>
                    </div>
                </div>
             </div>
        </div>
    <script type="text/javascript">
            <?php if($people->people_id > 0): ?>                    
                    selectCity(jQuery('#peoplestate'), '<?php echo $people->city ?>');
            <?php endif; ?>        
        jQuery(function(){             
            var endDate = new Date();
            jQuery('[name="date_of_birth"]').datepicker({
                format: "mm/dd/yyyy",
                endDate: endDate,
                orientation: "bottom auto"
            });            
            jQuery('#peopleForm').validate({
                 errorElement: 'span', //default input error message container
                 errorClass: 'help-block help-block-error', // default input error message class
                 focusInvalid: false, // do not focus the last invalid input
                 ignore: "", // validate all fields including form hidden input
                 rules: {
                     name : {
                         required: true,                    
                     },
                     email:{
                         required: true,
                         email: true
                     },
                     phone:{
                         required : true,
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
        });
    </script>    
</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn blue"><?php echo 'Save Person' ?></button>
</div>
</form>
