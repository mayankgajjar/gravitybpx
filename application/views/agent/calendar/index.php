<div class="error-msg"></div>
<?php if(validation_errors() != ''): ?>
    <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>
<style>
.fc-content .fc-time{
    display:none;
}
span#event_end_date-error {
    width: 45%;
    float: right;
}
.event_list .event_desc{
    cursor: pointer;
}
</style>
<div class="page-content-col">
    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered calendar">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green sbold uppercase">Calendar</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                             <button class="btn btn-primary" data-toggle="modal" data-target="#InfoModalColor2" title="Add New Event">Add New Event</button>
                            
                            <!-- ======== Event List ========== -->
                            <div class="list_event">
                                <?php $this->load->view('agent/calendar/list_event'); ?>
                            </div>    
                            <!-- ======== Event List ========== -->
                        </div>
                        <div class="col-md-9 col-sm-12">
                            <div id="calendar" class="has-toolbar"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE BASE CONTENT -->
</div>

<!-- ================ Start : Model ================    --> 
<div class="modal fade" id="InfoModalColor2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form name="frmevent" id="frmevent" method="post">
        <div class="modal-content modal-no-shadow modal-no-border">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Add New Event</h4>
          </div>
           <div class="modal-body">
                <div class="the-box">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                       <label>Date</label>
                       <div class="input-group date-picker input-daterange" data-date-format="mm/dd/yyyy">
                            <input type="text" class="form-control" name="event_start_date">
                            <span class="input-group-addon"> To </span>
                            <input type="text" class="form-control" name="event_end_date"> </div>
                        <!-- /input-group -->
                    </div>
                    </div><!-- /.col-sm-12 -->
                </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Time</label>
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker timepicker-24" name="event_start_time">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>    
                        </div><!-- /.col-sm-6 -->
                        <div class="col-sm-6">
                             <div class="form-group">
                                <div class="form-group">
                                    <label>End Time</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker timepicker-24" name="event_end_time">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>      
                            </div>
                        </div> <!-- /.col-sm-6 -->       
                    </div><!-- /.row -->   
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Event Color</label>
                            <input type="text" id="hue-demo" class="form-control demo" data-control="hue" value="#ff6161" name="event_color">
                        </div><!-- /.col-sm-12 -->  
                    </div>  <!-- /.row -->   
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label>Event</label>
                                    <textarea class="form-control" style="resize:none;" name="event_desc" id="event_desc" ></textarea>
                            </div><!-- /.form-group -->
                        </div><!-- /.col-sm-6 -->
                    </div><!-- /.row -->
                </div><!-- /.the-box -->
          </div><!-- /.modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn blue" name="Submit" value="Submit">Save changes</button>
          </div><!-- /.modal-footer -->
        </div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->
     </form>   
  </div><!-- /.modal-dialog -->
</div><!-- /#InfoModalColor2 -->    
<!-- ================ End : Model ================  -->


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

/*------------ For Delete Event --------------*/
jQuery(document).on('click', '.delete', function(event){
    event.preventDefault();
    var href = jQuery(this).attr('href');
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this event details!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false,
      html: false
    }, function(){
        // location.href = href;
        jQuery.ajax({
            url : href,
            method : 'post',
            dataType : 'json',
            success : function(result){
                $('.list_event').html(result.sider);
                $('.cancel').click();
                initCalendar(result.json);
                var msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Event deleted successfully.</div>';
                $(".error-msg").html(msg); 
            }
        });    
            
    });
});
/*------------ End For Delete Event --------------*/


/*---------------- Create New Event --------*/
 jQuery("#frmevent").submit(function(event) {
    event.preventDefault();
    jQuery.ajax({
        url : "<?=BASE_URL('calendar/add_event');?>",
        method : 'post',
        dataType : 'json',
        data: jQuery("#frmevent").serialize(),
        success : function(result){
            console.log("=== "+result.success);
            if(result.success){
                $('.list_event').html(result.sider);
                initCalendar(result.json);
                $("#InfoModalColor2").modal('hide');
                var msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Event saved successfully.</div>';
            }else{
                var msg = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Error into save event.</div>';
            }
            $(".error-msg").html(msg); 
        }
    });    
 });   
 /*---------------- End Create New Event --------*/
       
/*------------------ For Calendar ----------------------- */
function initCalendar(event_data) {
   
    /*-------------- For Event Dynamic Data -- */
    var event_array = [];
    for (i = 0; i < event_data.length; i++) 
    {           
        //var start11_time = new Date(y, m, d, 12, 10);
        var date1 = event_data[i]['event_start_date'].split('-');
        var time1 = event_data[i]['event_start_time'].split(':');
        var start_time = new Date(date1[0], (date1[1]-1) , date1[2], time1[0], time1[1]);
        
        var date2 = event_data[i]['event_end_date'].split('-');
        var time2 = event_data[i]['event_end_time'].split(':');
        var end_time = new Date(date2[0], (date2[1]-1) , date2[2], time2[0], time2[1]);

        event_array.push({title : event_data[i]['event_start_time']+ " - "+ event_data[i]['event_end_time'] +"\n"+event_data[i]['event_desc'], start : start_time,end : end_time,backgroundColor : event_data[i]['event_color']});
    }

    /*-------------- End For Event Dynamic Data -- */

    if (!jQuery().fullCalendar) {
        return;
    }

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var h = {};

    if (App.isRTL()) {
        if ($('#calendar').parents(".portlet").width() <= 720) {
            $('#calendar').addClass("mobile");
            h = {
                right: 'title, prev, next',
                center: '',
                left: 'agendaDay, agendaWeek, month, today'
            };
        } else {
            $('#calendar').removeClass("mobile");
            h = {
                right: 'title',
                center: '',
                left: 'agendaDay, agendaWeek, month, today, prev,next'
            };
        }
    } else {
        if ($('#calendar').parents(".portlet").width() <= 720) {
            $('#calendar').addClass("mobile");
            h = {
                left: 'title, prev, next',
                center: '',
                right: 'today,month,agendaWeek,agendaDay'
            };
        } else {
            $('#calendar').removeClass("mobile");
            h = {
                left: 'title',
                center: '',
                right: 'prev,next,today,month,agendaWeek,agendaDay'
            };
        }
    }

    //predefined events

    $('#calendar').fullCalendar('destroy'); // destroy the calendar
    $('#calendar').fullCalendar({ //re-initialize the calendar
        header: h,
        defaultView: 'month', // change default view with available options from http://arshaw.com/fullcalendar/docs/views/Available_Views/
        slotMinutes: 15,
        events : event_array
        // events: [{
        //     title: 'Lunch',
        //     start: new Date(y, m, d, 12, 0),
        //     end: new Date(y, m, d, 14, 0),
        //     backgroundColor: App.getBrandColor('grey'),
        //     allDay: false,
        //     url: 'http://google.com/',
        // }]
    });

}
/*-------------- End For Calendar ---------------- */
function gotodate(date){
    var date_arr = date.split('-');
    var year = '2017';
    var month = '1';
    if(date_arr.length > 2){
        year = date_arr[0];
        month = date_arr[1];
    }    
    jQuery('#calendar').fullCalendar('gotoDate', new Date(year, month-1));
}


jQuery(document).ready(function() {
   initCalendar(<?php echo json_encode($event_data);?>);
   jQuery('#frmevent').validate({
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
});
</script>