<?php
	$profile = $this->session->userdata('agent')->profile_image;
	if(empty($profile) || is_null($profile))
	{
		$profile = 'uploads/agents/no-photo-available.jpg';
	}
	else
	{
		$profile = 'uploads/agents/'.$profile;
	}
	$r = rand(12501,48525);
	$profile .= "?".$r;
?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<style>
#filter_data .actions{
    margin: 15px 5px;
    float: right;
}
#filter_data .actions label{
    margin-bottom: 5px;
}
.fc-content .fc-time{
    display:none;
}
</style>
<script type="text/javascript">
    jQuery(function(){
            var showMap = function(name) {
                jQuery('.vmaps').hide();
                jQuery('#vmap_' + name).show();
                jQuery('#region_statistics_content').show();
                jQuery('#region_statistics_loading').hide();
            };
            var setMap = function(name) {
                var map = jQuery('#vmap_' + name);
                if (map.size() !== 1) {
                    return;
                }

                var data = {
                    map: 'world_en',
                    backgroundColor: null,
                    borderColor: '#333333',
                    borderOpacity: 0.5,
                    borderWidth: 1,
                    color: '#c6c6c6',
                    enableZoom: true,
                    hoverColor: '#c9dfaf',
                    hoverOpacity: null,
                    values: sample_data,
                    normalizeFunction: 'linear',
                    scaleColors: ['#b6da93', '#909cae'],
                    selectedColor: '#c9dfaf',
                    selectedRegion: null,
                    showTooltip: true,
                    onLabelShow: function(event, label, code) {

                    },
                    onRegionOver: function(event, code) {
                        if (code == 'ca') {
                            event.preventDefault();
                        }
                    },
                    onRegionClick: function(element, code, region) {
                        var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
                        alert(message);
                    }
                };

                data.map = name + '_en';

                map.width(map.parent().parent().width());
                map.show();
                map.vectorMap(data);
                map.hide();
            };
             setMap("usa");
             showMap("usa");

           var initCalendar = function(event_data) {

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

            if ($('#calendar').width() <= 400) {
                $('#calendar').addClass("mobile");
                h = {
                    left: 'title, prev, next',
                    center: '',
                    right: 'today,month,agendaWeek,agendaDay'
                };
            } else {
                $('#calendar').removeClass("mobile");
                if (App.isRTL()) {
                    h = {
                        right: 'title',
                        center: '',
                        left: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                } else {
                    h = {
                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                }
            }



            $('#calendar').fullCalendar('destroy'); // destroy the calendar
            $('#calendar').fullCalendar({ //re-initialize the calendar
                header: h,
                defaultView: 'month', // change default view with available options from http://arshaw.com/fullcalendar/docs/views/Available_Views/
                slotMinutes: 15,
                events: event_array
            });
        };
        initCalendar(<?php echo json_encode($event_data);?>);
    });
</script>
<style type="text/css">
    .jqvmap-zoomin, .jqvmap-zoomout{width: 15px;height: 15px;}
</style>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="breadcrumbs">
        <h1 class="page-title"> Dashboard </h1>
        <ol class="breadcrumb">
            <li><a href="#"><?php echo 'Home' ?></a></li>
            <li class="active">
                <?php echo 'Dashboard' ?>
            </li>
        </ol>
    </div>
<?php if ($this->session->flashdata('success') != ''): ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error') != ''): ?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>
<!-- Filter Data -->
<div class="row">
    <!-- <div class="col-sm-9"></div>
     <form name="filter_data" method="POST" id="filter_data">
        <div class="col-sm-3">
            <div class="form-group">
                <select name="duration" id="duration" class="form-control" onchange="$('#filter_data').submit();">
                    <option value="Today">Today</option>
                    <option value="Week">This Week</option>
                    <option value="Month" selected>This Month</option>
                    <option value="Quarter">This Quarter</option>
                    <option value="Year">This Year</option>
                    <option value="All">All Time</option>
                </select>
                <script>
                    $("#duration").val("<?php echo $duration; ?>");
                </script>
            </div>
        </div>
    </form>         -->
    <form name="filter_data" method="POST" id="filter_data">
        <div class="actions">
            <div class="btn-group btn-group-devided" data-toggle="buttons">
                <label class="btn green btn-outline btn-circle btn-sm Today">
                    <input type="radio" name="duration" class="toggle" value="Today">Today</label>
                <label class="btn green btn-outline btn-circle btn-sm Week">
                    <input type="radio" name="duration" class="toggle" value="Week">This Week</label>
                <label class="btn green btn-outline btn-circle btn-sm Month">
                    <input type="radio" name="duration" class="toggle" value="Month">This Month</label>
                <label class="btn green btn-outline btn-circle btn-sm Quarter">
                    <input type="radio" name="duration" class="toggle" value="Quarter">This Quarter</label>
                <label class="btn green btn-outline btn-circle btn-sm Year">
                    <input type="radio" name="duration" class="toggle" value="Year">This Year</label>
                <label class="btn green btn-outline btn-circle btn-sm All">
                    <input type="radio" name="duration" class="toggle" value="All">All Time</label>
            </div>
        </div>
        <script>
            $("input[name=duration]").change(function(){
                $('#filter_data').submit();
            });
            $(".<?php echo $duration; ?>").addClass('active');
        </script>
    </form>
</div>
<!-- End Filter Data -->

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span data-value="7800" data-counter="counterup">0</span>
                        <small class="font-green-sharp">$</small>
                    </h3>
                    <small>TOTAL SALES</small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span class="progress-bar progress-bar-success green-sharp" style="width: 76%;">
                        <span class="sr-only">76% progress</span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title"> progress </div>
                    <div class="status-number"> 76% </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-red-haze">
                        <span data-value="<?=$totalAssignedLeads?>" data-counter="counterup">0</span>
                    </h3>
                    <small>TOTAL LEADS</small>
                </div>
                <div class="icon">
                    <i class="fa fa-comments"></i>
                </div>
            </div>
            <!-- ============ For Fetch Lead Percentage ========= -->
            <?php if($totalLeads != 0 && $totalAssignedLeads != 0) {
                $leadprecentage = round((($totalAssignedLeads/$totalLeads)*100),2);
            }else{
                $leadprecentage = 0;
            }?>
            <!-- ============ End For Fetch Lead Percentage ========= -->
            <div class="progress-info">
                <div class="progress">
                    <span class="progress-bar progress-bar-success red-haze" style="width: <?php echo $leadprecentage; ?>%;">
                        <span class="sr-only"><?php echo $leadprecentage; ?>% change</span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title"> change </div>
                    <div class="status-number"> <?php echo $leadprecentage; ?>% </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-blue-sharp">
                        <span data-value="<?=$totalAssignedPremium?>" data-counter="counterup">0</span>
                    </h3>
                    <small>TOTAL PREMIUM</small>
                </div>
                <div class="icon">
                    <i class="icon-basket"></i>
                </div>
            </div>
             <!-- ============ For Fetch Lead Percentage ========= -->
            <?php if($totalPremium != 0 && $totalAssignedPremium != 0) {
                $premiumprecentage = round((($totalAssignedPremium/$totalPremium)*100),2);
            }else{
                $premiumprecentage = 0;
            }?>
            <!-- ============ End For Fetch Lead Percentage ========= -->
            <div class="progress-info">
                <div class="progress">
                    <span class="progress-bar progress-bar-success blue-sharp" style="width: 45%;">
                        <span class="sr-only"><?php echo $premiumprecentage; ?>% change</span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title"> change </div>
                    <div class="status-number"> <?php echo $premiumprecentage; ?>%  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-purple-soft">
                        <span data-value="276" data-counter="counterup">0</span>
                    </h3>
                    <small>TOTAL COMMISSIONS</small>
                </div>
                <div class="icon">
                    <i class="icon-user"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span class="progress-bar progress-bar-success purple-soft" style="width: 57%;">
                        <span class="sr-only">56% change</span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title"> change </div>
                    <div class="status-number"> 57% </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Sales Chart -->
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">Sales</span>
                    <span class="caption-helper">distance stats...</span>
                </div>
                <!-- <div class="actions">
                    <a href="#" class="btn btn-circle btn-icon-only btn-default">
                        <i class="icon-cloud-upload"></i>
                    </a>
                    <a href="#" class="btn btn-circle btn-icon-only btn-default">
                        <i class="icon-wrench"></i>
                    </a>
                    <a href="#" class="btn btn-circle btn-icon-only btn-default">
                        <i class="icon-trash"></i>
                    </a>
                    <a href="#" class="btn btn-circle btn-icon-only btn-default fullscreen" data-original-title="" title=""> </a>
                </div> -->
            </div>
            <div class="portlet-body">
                <?php
                    $grapth = strtolower($duration);
                    $this->load->view('agent/sales_chart/'.$grapth);
                ?>
            </div>
        </div>
    </div>
    <!-- End Sales Chart -->
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-share font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Regional Stats</span>
                </div>
                <div class="actions">
                    <!--<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                        <i class="icon-cloud-upload"></i>
                    </a>
                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                        <i class="icon-wrench"></i>
                    </a>
                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" data-container="false" data-placement="bottom" href="javascript:;"> </a>
                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                        <i class="icon-trash"></i>
                    </a>-->
                </div>
            </div>
            <div class="portlet-body">
                <?php echo $map['html']; ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6">
        <!-- BEGIN PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-globe font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Feed</span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1_1" class="active" data-toggle="tab"> System </a>
                    </li>
                    <li>
                        <a href="#tab_1_2" data-toggle="tab"> Activity </a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <!--BEGIN TABS-->
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1_1">
                        <div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
                            <ul class="feeds">
                                <?php if(count($system_feed_data) > 0) :?>
                                    <?php foreach($system_feed_data as $system) :?>
                                        <li>
                                            <?php if($system['log_url'] != '') :?>
                                                <a href="<?=base_url().$system['log_url']?>">
                                            <?php endif; ?>    
                                                    <div class="col1">
                                                        <div class="cont">
                                                            <div class="cont-col1">
                                                                <div class="label label-sm label-success">
                                                                    <?php echo feed_status($system['log_type']); ?>
                                                                </div>
                                                            </div>
                                                            <div class="cont-col2">
                                                                <div class="desc"><?=$system['title']?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col2">
                                                        <div class="date"> <?=time_ago($system['created'])?> </div>
                                                    </div>
                                            <?php if($system['log_url'] != '') :?>
                                                </a>
                                            <?php endif; ?> 
                                        </li>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <li>
                                        No System Feed Found 
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_1_2">
                        <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                            <ul class="feeds">
                                <?php if(count($activity_feed_data) > 0) :?>
                                    <?php foreach($activity_feed_data as $activity) :?>
                                        <li>
                                            <?php if($activity['log_url'] != '') :?>
                                                <a href="<?=base_url().$activity['log_url']?>">
                                            <?php endif; ?>    
                                                <div class="col1">
                                                    <div class="cont">
                                                        <div class="cont-col1">
                                                            <div class="label label-sm label-success">
                                                                <?php echo feed_status($activity['log_type']); ?>
                                                            </div>
                                                        </div>
                                                        <div class="cont-col2">
                                                            <div class="desc"><?=$activity['title']?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col2">
                                                    <div class="date">  <?=time_ago($activity['created'])?> </div>
                                                </div>
                                             <?php if($activity['log_url'] != '') :?>
                                                </a>
                                            <?php endif; ?> 
                                        </li>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <li>
                                        No Activity Feed Found 
                                    </li>
                                <?php endif; ?>    
                            </ul>
                        </div>
                    </div>
                </div>
                <!--END TABS-->
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
    <div class="col-md-6 col-sm-6">
        <!-- BEGIN PORTLET-->
        <div class="portlet light calendar bordered">
            <div class="portlet-title ">
                <div class="caption">
                    <i class="icon-calendar font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Calendar</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="calendar"> </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
<div class="row">

    <div class="col-md-12 col-sm-12">
        <!-- BEGIN PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bubble font-hide hide"></i>
                    <span class="caption-subject font-hide bold uppercase">Chats</span>
                </div>
                <div class="actions">
                    <div class="portlet-input input-inline">
                        <div class="input-icon right">
                            <i class="icon-magnifier"></i>
                            <input type="text" class="form-control input-circle" placeholder="search..."> </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body" id="chats">
                <div class="scroller" style="height: 525px;" data-always-visible="1" data-rail-visible1="1">
                    <ul class="chats">
                        <li class="out">
                            <img class="avatar" alt="" src="<?php echo site_url() ?>assets/theam_assets/layouts/layout/img/avatar2.jpg" />
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name"> Lisa Wong </a>
                                <span class="datetime"> at 20:11 </span>
                                <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                            </div>
                        </li>
                        <li class="out">
                            <img class="avatar" alt="" src="<?php echo site_url() ?>assets/theam_assets/layouts/layout/img/avatar2.jpg" />
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name"> Lisa Wong </a>
                                <span class="datetime"> at 20:11 </span>
                                <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                            </div>
                        </li>
                        <li class="in">
                            <img class="avatar" alt="" src="<?php echo site_url() ?>assets/theam_assets/layouts/layout/img/avatar1.jpg" />
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name"> Bob Nilson </a>
                                <span class="datetime"> at 20:30 </span>
                                <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                            </div>
                        </li>
                        <li class="in">
                            <img class="avatar" alt="" src="<?php echo site_url() ?>assets/theam_assets/layouts/layout/img/avatar1.jpg" />
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name"> Bob Nilson </a>
                                <span class="datetime"> at 20:30 </span>
                                <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                            </div>
                        </li>
                        <li class="out">
                            <img class="avatar" alt="" src="<?php echo site_url() ?>assets/theam_assets/layouts/layout/img/avatar3.jpg" />
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name"> Richard Doe </a>
                                <span class="datetime"> at 20:33 </span>
                                <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                            </div>
                        </li>
                        <li class="in">
                            <img class="avatar" alt="" src="<?php echo site_url() ?>assets/theam_assets/layouts/layout/img/avatar3.jpg" />
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name"> Richard Doe </a>
                                <span class="datetime"> at 20:35 </span>
                                <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                            </div>
                        </li>
                        <li class="out">
                            <img class="avatar" alt="" src="<?php echo site_url() ?>assets/theam_assets/layouts/layout/img/avatar1.jpg" />
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name"> Bob Nilson </a>
                                <span class="datetime"> at 20:40 </span>
                                <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                            </div>
                        </li>
                        <li class="in">
                            <img class="avatar" alt="" src="<?php echo site_url() ?>assets/theam_assets/layouts/layout/img/avatar3.jpg" />
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name"> Richard Doe </a>
                                <span class="datetime"> at 20:40 </span>
                                <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                            </div>
                        </li>
                        <li class="out">
                            <img class="avatar" alt="" src="<?php echo site_url() ?>assets/theam_assets/layouts/layout/img/avatar1.jpg" />
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name"> Bob Nilson </a>
                                <span class="datetime"> at 20:54 </span>
                                <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. sed diam nonummy nibh euismod tincidunt ut laoreet. </span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="chat-form">
                    <div class="input-cont">
                        <input class="form-control" type="text" placeholder="Type a message here..." /> </div>
                    <div class="btn-cont">
                        <span class="arrow"> </span>
                        <a href="" class="btn blue icn-only">
                            <i class="fa fa-check icon-white"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
