<style>
    .lead_input_div{
        position: relative;
        display: inline-block;
        width:70%;
    }
    .lead_input_div input{width: 100% !important;}
    .lead_input_div span.input-group-btn {
        position: absolute;
        right: 42px;
        top: 0px;
    }
    .nipl-lead-model .input-group.date-picker.input-daterange input{
        width:100%;
    }
    .nipl-lead-model .input-daterange {
        width: 70%;
    }
</style>
<div class="modal-dialog modal-lg nipl-lead-model">
    <?php // PR($this->session->userdata('agent')); ?>
    <form action="" method="post" id="task-form"  onsubmit="return getdata(this,event)">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
                <div class="caption font-dark">
                    <i class="fa fa-building-o font-dark"></i>
                    <span class="caption-subject bold uppercase" style="font-size: 16px;"><?php echo $title; ?></span>
                </div>
            </div>
            <input type="hidden" name="type" value="task" class="type">
            <div class="modal-body">
                <div class="portlet-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Task Description<span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <textarea rows="3" cols="10" name="task_description" class="form-control" id="task_description" placeholder="Task Description"></textarea>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label">Task Date<span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <input type="text" class="form-control" name="task_date" id="task_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Task Start Time <span class="required"> * </span> </label>
                            <div class="lead_input_div">
                                <input type="text" class="form-control timepicker timepicker-24" name="task_start_time">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Task End Time <span class="required"> * </span> </label>
                            <div class="lead_input_div">
                                <input type="text" class="form-control timepicker timepicker-24" name="task_end_time">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Agent Name </label>
                            <div class="nipl_input_div">
                                <select name="assign_agent_id" class="form-control" >
                                    <option value=""><?php echo 'Please Select Agent' ?></option>
                                    <?php foreach($agent_list as $agent): ?>
                                        <option value="<?php echo $agent['id']; ?>"><?php echo $agent['agent_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Task Note </label>
                            <div class="nipl_input_div">
                                <textarea rows="3" cols="10" name="task_note" class="form-control" id="task_note" placeholder="Task Note"></textarea>
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
    <!-- /.modal-content -->
    </form>
</div>
<!-- /.modal-dialog -->
<script type="text/javascript">
    $('.timepicker-24').timepicker({
        autoclose: true,
        minuteStep: 5,
        showSeconds: false,
        showMeridian: false
    });
    jQuery('[name="task_date"]').datepicker({
        format: "mm/dd/yyyy",
        startDate : new Date(), 
        orientation: "bottom auto"
    });

    jQuery('#task-form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            task_date: {
                required: true,
            },
            task_description: {
                required: true
            },
            task_end_time: {
                required: true
            },
            task_start_time: {
                required: true,
            },
        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        errorPlacement: function (error, element) { // render error placement for each input type
            if (element.attr("name") == "task_start_time") {
                error.insertAfter(element.parent('.input-group'));
            }else if (element.attr("name") == "task_end_time") {
                error.insertAfter(element.parent('.input-group'));
            } else {
                error.insertAfter(element); // for other inputs, just perform default behavior
            }
        },
    });
</script>