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
    <form action="" method="post" id="event-form" onsubmit="return getdata(this, event)">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
                <div class="caption font-dark">
                    <i class="fa fa-building-o font-dark"></i>
                    <span class="caption-subject bold uppercase" style="font-size: 16px;"><?php echo $title; ?></span>
                </div>
            </div>
            <input type="hidden" name="type" value="event" class="type">
            <div class="modal-body"> 
                <div class="portlet-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Date <span class="required"> * </span></label> 
                            <div class="date-error-fixes lead_input_div date-range-fixes">
                                <div class="input-group date-picker input-daterange" data-date-format="mm/dd/yyyy">
                                    <input type="text" class="form-control" name="event_start_date">
                                    <span class="input-group-addon"> To </span>
                                    <input type="text" class="form-control" name="event_end_date"> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Start Time <span class="required"> * </span> </label>
                            <div class="lead_input_div">
                                <input type="text" class="form-control timepicker timepicker-24" name="event_start_time">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-clock-o"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">End Time <span class="required"> * </span> </label>
                            <div class="lead_input_div">
                                <input type="text" class="form-control timepicker timepicker-24" name="event_end_time">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-clock-o"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Event Color <span class="required"> * </span> </label> 
                            <div class="nipl_input_div">    
                            <input type="text" id="hue-demo-pop" class="form-control demo" data-control="hue" value="#ff6161" name="event_color">
                            </div>
                            </div>
                        <div class="form-group">
                            <label class="control-label">Event <span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <textarea rows="4" cols="10" name="event_desc" class="form-control" id="event_desc" placeholder="Event Description"></textarea>
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

<script type="text/javascript">
jQuery('.input-daterange').datepicker({
    orientation: "bottom",
});
$('.timepicker-24').timepicker({
    autoclose: true,
    minuteStep: 5,
    showSeconds: false,
    showMeridian: false
});

            jQuery('#hue-demo-pop').minicolors({
                control: $(this).attr('data-control') || 'hue',
                defaultValue: $(this).attr('data-defaultValue') || '',
                inline: $(this).attr('data-inline') === 'true',
                letterCase: $(this).attr('data-letterCase') || 'lowercase',
                opacity: $(this).attr('data-opacity'),
                position: $(this).attr('data-position') || 'bottom left',
                change: function(hex, opacity) {
                    if (!hex) return;
                    if (opacity) hex += ', ' + opacity;
                    if (typeof console === 'object') {
                        //console.log(hex);
                    }
                },
                theme: 'bootstrap'
            });
            
    jQuery('#event-form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            event_start_date : {
                required: true,                    
            },
            event_end_date :{
                required: true
            },
            event_start_time:{
                 required: true
            },
            event_end_time:{
                 required: true
            },
            event_desc:{
                required : true,                                 
            },               
        },
        highlight: function (element) { // hightlight error inputs
            $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        errorPlacement: function (error, element) { // render error placement for each input type
            if (element.attr("name") == "event_start_date") { 
                error.insertAfter(element.parent('.input-daterange'));
            } else if (element.attr("name") == "event_end_date") { 
                error.insertAfter(element.parent('.input-daterange'));
            }else if (element.attr("name") == "event_start_time") { 
                error.insertAfter(element.parent('.input-group'));
            }else if (element.attr("name") == "event_end_time") { 
                error.insertAfter(element.parent('.input-group'));
            } else {
                error.insertAfter(element); // for other inputs, just perform default behavior
            }
        },            
    });
</script>
