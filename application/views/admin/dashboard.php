    <!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Dashboard</span>
            </li>
        </ul>
        <div class="page-toolbar">
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Dashboard
        <small>dashboard & statistics</small>
    </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form id="groupForm" name="groupForm" id="groupForm" action="" method="post" class="form-inline" >
                <select multiple class="col-md-12 form-control" name="campaign_id[]" style="display: none;">
                    <option selected value="ALL-ACTIVE">ALL-ACTIVE -</option>
                </select>
                <input type="hidden" name="RR" id="RR" value="40"/>
                <input type="hidden" name="with_inbound" id="with_inbound" value="Y"/>
                <input type="hidden" name="NOLEADSalert" id="NOLEADSalert" value=""/>
                <input type="hidden" name="DROPINGROUPstats" id="DROPINGROUPstats" value="0"/>
                <input type="hidden" name="DROPINGROUPstats" id="CARRIERstats" value="0"/>
                <input type="hidden" name="PRESETstats" id="PRESETstats" value="0" />
                <input type="hidden" name="AGENTtimeSTATS" id="AGENTtimeSTATS" value="0" />
                <input type="hidden" name="droppedOFtotal" id="droppedOFtotal" value="" />
                <input type="hidden" name="adastats" id="adastats" value="1"/>
                <input type="hidden" name="ALLINGROUPstats" id="ALLINGROUPstats" value="0" />
                <input type="hidden" name="PHONEdisplay" id="PHONEdisplay" value="0"/>
                <input type="hidden" name="SERVdisplay" id="SERVdisplay" value="0"/>
                <input type="hidden" name="UGdisplay" id="UGdisplay" value="0" />
                <input type="hidden" name="CUSTPHONEdisplay" id="CUSTPHONEdisplay" value="0" />
                <input type="hidden" name="CALLSdisplay" id="CALLSdisplay" value="1" />
            <div class="portlet light bordered">
                    <div class="portlet-title">
                        <h4 class="caption-subject font-dark bold uppercase text-center"><?php echo 'Dialer Real Time Data' ?></h4>
                    </div>
                    <div class="portlet-title tabbable-line">
                        <div class="caption col-md-3" style="display: none;">
                            <i class="icon-bubbles font-dark hide"></i>
                            <span id="refresh_countdown_text" class="caption-subject font-dark bold uppercase"><?php echo 'Refresh' ?>:<span id="refresh_countdown"></span></span>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="">
                                <a href="javascript:update_variables('adastats','');" id="text_adastats"> <?php echo "View More"  ?> </a>
                            </li>
                            <li>
                                <a href="javascript:update_variables('UGdisplay','');" id="text_UGdisplay"> <?php echo "View User Group"  ?> </a>
                            </li>
                            <li>
                                <a href="javascript:update_variables('SERVdisplay','');" id="text_SERVdisplay"> <?php echo "Show Server Info"  ?> </a>
                            </li>
                            <li>
                                <a href="javascript:update_variables('CALLSdisplay','');" id="text_CALLSdisplay"> <?php echo "Hide Waiting Calls"  ?> </a>
                            </li>
                            <li>
                                <a href="javascript:update_variables('ALLINGROUPstats','');" id="text_ALLINGROUPstats"> <?php echo "Show In-Groups Stats"  ?> </a>
                            </li>
                            <li>
                                <a href="javascript:update_variables('PHONEdisplay','');" id="text_PHONEdisplay"> <?php echo "Show Phones"  ?> </a>
                            </li>
                            <li>
                                <a href="javascript:update_variables('CUSTPHONEdisplay','');" id="text_CUSTPHONEdisplay"> <?php echo "Show Customphones"  ?> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body text-center">
                        <div class="form-group" style="display:none;">
                            <label for="monitor_phone"><?php echo 'Campaigns' ?></label>
                            <select multiple class="form-control" name="campaign_id[]" style="display: none;">
                                <option selected value="ALL-ACTIVE">ALL-ACTIVE -</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="monitor_phone" ><?php echo 'Monitor' ?>:</label>
                            <select name="monitor_active" id="monitor_active" class="form-control">
                                <option value=""><?php echo 'NONE' ?></option>
                                <option value="MONITOR"><?php echo 'MONITOR' ?></option>
                                <option value="BARGE"><?php echo 'BARGE' ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="monitor_phone" ><?php echo 'Phone' ?>:</label>
                            <input type="text" name="monitor_phone" id="monitor_phone" class="form-control">
                        </div>
                        <button class="btn btn-default blue" type="submit"><?php echo 'Reload' ?></button>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div id="realtime_content"></div>
                        </div>
                    </div>
            </div>
            </form>
        <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="1349">0</span>
                    </div>
                    <div class="desc"> New Feedbacks </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="12,5">0</span>M$ </div>
                    <div class="desc"> Total Profit </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="549">0</span>
                    </div>
                    <div class="desc"> New Orders </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number"> +
                        <span data-counter="counterup" data-value="89"></span>% </div>
                    <div class="desc"> Brand Popularity </div>
                </div>
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Site Visits</span>
                        <span class="caption-helper">weekly stats...</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <label class="btn red btn-outline btn-circle btn-sm active">
                                <input type="radio" name="options" class="toggle" id="option1">New</label>
                            <label class="btn red btn-outline btn-circle btn-sm">
                                <input type="radio" name="options" class="toggle" id="option2">Returning</label>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="site_statistics_loading">
                        <img src="assets/theam_assets/global/img/loading.gif" alt="loading" /> </div>
                    <div id="site_statistics_content" class="display-none">
                        <div id="site_statistics" class="chart"> </div>
                    </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
        <div class="col-md-6 col-sm-6">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-red-sunglo hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Revenue</span>
                        <span class="caption-helper">monthly stats...</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a href="" class="btn dark btn-outline btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Filter Range
                                <span class="fa fa-angle-down"> </span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;"> Q1 2014
                                        <span class="label label-sm label-default"> past </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;"> Q2 2014
                                        <span class="label label-sm label-default"> past </span>
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="javascript:;"> Q3 2014
                                        <span class="label label-sm label-success"> current </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;"> Q4 2014
                                        <span class="label label-sm label-warning"> upcoming </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="site_activities_loading">
                        <img src="assets/theam_assets/global/img/loading.gif" alt="loading" /> </div>
                    <div id="site_activities_content" class="display-none">
                        <div id="site_activities" style="height: 228px;"> </div>
                    </div>
                    <div style="margin: 20px 0 10px 30px">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                                <span class="label label-sm label-success"> Revenue: </span>
                                <h3>$13,234</h3>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                                <span class="label label-sm label-info"> Tax: </span>
                                <h3>$134,900</h3>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                                <span class="label label-sm label-danger"> Shipment: </span>
                                <h3>$1,134</h3>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                                <span class="label label-sm label-warning"> Orders: </span>
                                <h3>235090</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Comments</span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#portlet_comments_1" data-toggle="tab"> Pending </a>
                        </li>
                        <li>
                            <a href="#portlet_comments_2" data-toggle="tab"> Approved </a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="portlet_comments_1">
                            <!-- BEGIN: Comments -->
                            <div class="mt-comments">
                                <div class="mt-comment">
                                    <div class="mt-comment-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar1.jpg" /> </div>
                                    <div class="mt-comment-body">
                                        <div class="mt-comment-info">
                                            <span class="mt-comment-author">Michael Baker</span>
                                            <span class="mt-comment-date">26 Feb, 10:30AM</span>
                                        </div>
                                        <div class="mt-comment-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy. </div>
                                        <div class="mt-comment-details">
                                            <span class="mt-comment-status mt-comment-status-pending">Pending</span>
                                            <ul class="mt-comment-actions">
                                                <li>
                                                    <a href="#">Quick Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#">View</a>
                                                </li>
                                                <li>
                                                    <a href="#">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-comment">
                                    <div class="mt-comment-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar6.jpg" /> </div>
                                    <div class="mt-comment-body">
                                        <div class="mt-comment-info">
                                            <span class="mt-comment-author">Larisa Maskalyova</span>
                                            <span class="mt-comment-date">12 Feb, 08:30AM</span>
                                        </div>
                                        <div class="mt-comment-text"> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </div>
                                        <div class="mt-comment-details">
                                            <span class="mt-comment-status mt-comment-status-rejected">Rejected</span>
                                            <ul class="mt-comment-actions">
                                                <li>
                                                    <a href="#">Quick Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#">View</a>
                                                </li>
                                                <li>
                                                    <a href="#">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-comment">
                                    <div class="mt-comment-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar8.jpg" /> </div>
                                    <div class="mt-comment-body">
                                        <div class="mt-comment-info">
                                            <span class="mt-comment-author">Natasha Kim</span>
                                            <span class="mt-comment-date">19 Dec,09:50 AM</span>
                                        </div>
                                        <div class="mt-comment-text"> The generated Lorem or non-characteristic Ipsum is therefore or non-characteristic always free from repetition, injected humour, or non-characteristic words etc. </div>
                                        <div class="mt-comment-details">
                                            <span class="mt-comment-status mt-comment-status-pending">Pending</span>
                                            <ul class="mt-comment-actions">
                                                <li>
                                                    <a href="#">Quick Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#">View</a>
                                                </li>
                                                <li>
                                                    <a href="#">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-comment">
                                    <div class="mt-comment-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar4.jpg" /> </div>
                                    <div class="mt-comment-body">
                                        <div class="mt-comment-info">
                                            <span class="mt-comment-author">Sebastian Davidson</span>
                                            <span class="mt-comment-date">10 Dec, 09:20 AM</span>
                                        </div>
                                        <div class="mt-comment-text"> The standard chunk of Lorem or non-characteristic Ipsum used since the 1500s or non-characteristic is reproduced below for those interested. </div>
                                        <div class="mt-comment-details">
                                            <span class="mt-comment-status mt-comment-status-rejected">Rejected</span>
                                            <ul class="mt-comment-actions">
                                                <li>
                                                    <a href="#">Quick Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#">View</a>
                                                </li>
                                                <li>
                                                    <a href="#">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Comments -->
                        </div>
                        <div class="tab-pane" id="portlet_comments_2">
                            <!-- BEGIN: Comments -->
                            <div class="mt-comments">
                                <div class="mt-comment">
                                    <div class="mt-comment-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar4.jpg" /> </div>
                                    <div class="mt-comment-body">
                                        <div class="mt-comment-info">
                                            <span class="mt-comment-author">Michael Baker</span>
                                            <span class="mt-comment-date">26 Feb, 10:30AM</span>
                                        </div>
                                        <div class="mt-comment-text"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy. </div>
                                        <div class="mt-comment-details">
                                            <span class="mt-comment-status mt-comment-status-approved">Approved</span>
                                            <ul class="mt-comment-actions">
                                                <li>
                                                    <a href="#">Quick Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#">View</a>
                                                </li>
                                                <li>
                                                    <a href="#">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-comment">
                                    <div class="mt-comment-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar8.jpg" /> </div>
                                    <div class="mt-comment-body">
                                        <div class="mt-comment-info">
                                            <span class="mt-comment-author">Larisa Maskalyova</span>
                                            <span class="mt-comment-date">12 Feb, 08:30AM</span>
                                        </div>
                                        <div class="mt-comment-text"> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </div>
                                        <div class="mt-comment-details">
                                            <span class="mt-comment-status mt-comment-status-approved">Approved</span>
                                            <ul class="mt-comment-actions">
                                                <li>
                                                    <a href="#">Quick Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#">View</a>
                                                </li>
                                                <li>
                                                    <a href="#">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-comment">
                                    <div class="mt-comment-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar6.jpg" /> </div>
                                    <div class="mt-comment-body">
                                        <div class="mt-comment-info">
                                            <span class="mt-comment-author">Natasha Kim</span>
                                            <span class="mt-comment-date">19 Dec,09:50 AM</span>
                                        </div>
                                        <div class="mt-comment-text"> The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc. </div>
                                        <div class="mt-comment-details">
                                            <span class="mt-comment-status mt-comment-status-approved">Approved</span>
                                            <ul class="mt-comment-actions">
                                                <li>
                                                    <a href="#">Quick Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#">View</a>
                                                </li>
                                                <li>
                                                    <a href="#">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-comment">
                                    <div class="mt-comment-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar1.jpg" /> </div>
                                    <div class="mt-comment-body">
                                        <div class="mt-comment-info">
                                            <span class="mt-comment-author">Sebastian Davidson</span>
                                            <span class="mt-comment-date">10 Dec, 09:20 AM</span>
                                        </div>
                                        <div class="mt-comment-text"> The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. </div>
                                        <div class="mt-comment-details">
                                            <span class="mt-comment-status mt-comment-status-approved">Approved</span>
                                            <ul class="mt-comment-actions">
                                                <li>
                                                    <a href="#">Quick Edit</a>
                                                </li>
                                                <li>
                                                    <a href="#">View</a>
                                                </li>
                                                <li>
                                                    <a href="#">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Comments -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Quick Actions</span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_actions_pending" data-toggle="tab"> Pending </a>
                        </li>
                        <li>
                            <a href="#tab_actions_completed" data-toggle="tab"> Completed </a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_actions_pending">
                            <!-- BEGIN: Actions -->
                            <div class="mt-actions">
                                <div class="mt-action">
                                    <div class="mt-action-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar10.jpg" /> </div>
                                    <div class="mt-action-body">
                                        <div class="mt-action-row">
                                            <div class="mt-action-info ">
                                                <div class="mt-action-icon ">
                                                    <i class="icon-magnet"></i>
                                                </div>
                                                <div class="mt-action-details ">
                                                    <span class="mt-action-author">Natasha Kim</span>
                                                    <p class="mt-action-desc">pending for approval pending for approval pending for approval pending for approval</p>
                                                </div>
                                            </div>
                                            <div class="mt-action-datetime ">
                                                <span class="mt-action-date">3 jun</span>
                                                <span class="mt-action-dot bg-green"></span>
                                                <span class="mt-action-time">9:30-13:00</span>
                                            </div>
                                            <div class="mt-action-buttons ">
                                                <div class="btn-group btn-group-circle">
                                                    <button type="button" class="btn btn-outline green btn-sm">Appove</button>
                                                    <button type="button" class="btn btn-outline red btn-sm">Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-action">
                                    <div class="mt-action-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar3.jpg" /> </div>
                                    <div class="mt-action-body">
                                        <div class="mt-action-row">
                                            <div class="mt-action-info ">
                                                <div class="mt-action-icon ">
                                                    <i class=" icon-bubbles"></i>
                                                </div>
                                                <div class="mt-action-details ">
                                                    <span class="mt-action-author">Gavin Bond</span>
                                                    <p class="mt-action-desc">pending for approval</p>
                                                </div>
                                            </div>
                                            <div class="mt-action-datetime ">
                                                <span class="mt-action-date">3 jun</span>
                                                <span class="mt-action-dot bg-red"></span>
                                                <span class="mt-action-time">9:30-13:00</span>
                                            </div>
                                            <div class="mt-action-buttons ">
                                                <div class="btn-group btn-group-circle">
                                                    <button type="button" class="btn btn-outline green btn-sm">Appove</button>
                                                    <button type="button" class="btn btn-outline red btn-sm">Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-action">
                                    <div class="mt-action-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar2.jpg" /> </div>
                                    <div class="mt-action-body">
                                        <div class="mt-action-row">
                                            <div class="mt-action-info ">
                                                <div class="mt-action-icon ">
                                                    <i class="icon-call-in"></i>
                                                </div>
                                                <div class="mt-action-details ">
                                                    <span class="mt-action-author">Diana Berri</span>
                                                    <p class="mt-action-desc">pending for approval pending for approval pending for approval pending for approval</p>
                                                </div>
                                            </div>
                                            <div class="mt-action-datetime ">
                                                <span class="mt-action-date">3 jun</span>
                                                <span class="mt-action-dot bg-green"></span>
                                                <span class="mt-action-time">9:30-13:00</span>
                                            </div>
                                            <div class="mt-action-buttons ">
                                                <div class="btn-group btn-group-circle">
                                                    <button type="button" class="btn btn-outline green btn-sm">Appove</button>
                                                    <button type="button" class="btn btn-outline red btn-sm">Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-action">
                                    <div class="mt-action-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar7.jpg" /> </div>
                                    <div class="mt-action-body">
                                        <div class="mt-action-row">
                                            <div class="mt-action-info ">
                                                <div class="mt-action-icon ">
                                                    <i class=" icon-bell"></i>
                                                </div>
                                                <div class="mt-action-details ">
                                                    <span class="mt-action-author">John Clark</span>
                                                    <p class="mt-action-desc">pending for approval pending for approval pending for approval pending for approval</p>
                                                </div>
                                            </div>
                                            <div class="mt-action-datetime ">
                                                <span class="mt-action-date">3 jun</span>
                                                <span class="mt-action-dot bg-red"></span>
                                                <span class="mt-action-time">9:30-13:00</span>
                                            </div>
                                            <div class="mt-action-buttons ">
                                                <div class="btn-group btn-group-circle">
                                                    <button type="button" class="btn btn-outline green btn-sm">Appove</button>
                                                    <button type="button" class="btn btn-outline red btn-sm">Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-action">
                                    <div class="mt-action-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar8.jpg" /> </div>
                                    <div class="mt-action-body">
                                        <div class="mt-action-row">
                                            <div class="mt-action-info ">
                                                <div class="mt-action-icon ">
                                                    <i class="icon-magnet"></i>
                                                </div>
                                                <div class="mt-action-details ">
                                                    <span class="mt-action-author">Donna Clarkson </span>
                                                    <p class="mt-action-desc">pending for approval pending for approval pending for approval pending for approval</p>
                                                </div>
                                            </div>
                                            <div class="mt-action-datetime ">
                                                <span class="mt-action-date">3 jun</span>
                                                <span class="mt-action-dot bg-green"></span>
                                                <span class="mt-action-time">9:30-13:00</span>
                                            </div>
                                            <div class="mt-action-buttons ">
                                                <div class="btn-group btn-group-circle">
                                                    <button type="button" class="btn btn-outline green btn-sm">Appove</button>
                                                    <button type="button" class="btn btn-outline red btn-sm">Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-action">
                                    <div class="mt-action-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar9.jpg" /> </div>
                                    <div class="mt-action-body">
                                        <div class="mt-action-row">
                                            <div class="mt-action-info ">
                                                <div class="mt-action-icon ">
                                                    <i class="icon-magnet"></i>
                                                </div>
                                                <div class="mt-action-details ">
                                                    <span class="mt-action-author">Tom Larson</span>
                                                    <p class="mt-action-desc">pending for approval pending for approval pending for approval pending for approval</p>
                                                </div>
                                            </div>
                                            <div class="mt-action-datetime ">
                                                <span class="mt-action-date">3 jun</span>
                                                <span class="mt-action-dot bg-green"></span>
                                                <span class="mt-action-time">9:30-13:00</span>
                                            </div>
                                            <div class="mt-action-buttons ">
                                                <div class="btn-group btn-group-circle">
                                                    <button type="button" class="btn btn-outline green btn-sm">Appove</button>
                                                    <button type="button" class="btn btn-outline red btn-sm">Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Actions -->
                        </div>
                        <div class="tab-pane" id="tab_actions_completed">
                            <!-- BEGIN:Completed-->
                            <div class="mt-actions">
                                <div class="mt-action">
                                    <div class="mt-action-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar1.jpg" /> </div>
                                    <div class="mt-action-body">
                                        <div class="mt-action-row">
                                            <div class="mt-action-info ">
                                                <div class="mt-action-icon ">
                                                    <i class="icon-action-redo"></i>
                                                </div>
                                                <div class="mt-action-details ">
                                                    <span class="mt-action-author">Frank Cameron</span>
                                                    <p class="mt-action-desc">pending for approval pending for approval pending for approval pending for approval</p>
                                                </div>
                                            </div>
                                            <div class="mt-action-datetime ">
                                                <span class="mt-action-date">3 jun</span>
                                                <span class="mt-action-dot bg-red"></span>
                                                <span class="mt-action-time">9:30-13:00</span>
                                            </div>
                                            <div class="mt-action-buttons ">
                                                <div class="btn-group btn-group-circle">
                                                    <button type="button" class="btn btn-outline green btn-sm">Appove</button>
                                                    <button type="button" class="btn btn-outline red btn-sm">Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-action">
                                    <div class="mt-action-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar8.jpg" /> </div>
                                    <div class="mt-action-body">
                                        <div class="mt-action-row">
                                            <div class="mt-action-info ">
                                                <div class="mt-action-icon ">
                                                    <i class="icon-cup"></i>
                                                </div>
                                                <div class="mt-action-details ">
                                                    <span class="mt-action-author">Ella Davidson </span>
                                                    <p class="mt-action-desc">pending for approval pending for approval pending for approval pending for approval</p>
                                                </div>
                                            </div>
                                            <div class="mt-action-datetime ">
                                                <span class="mt-action-date">3 jun</span>
                                                <span class="mt-action-dot bg-green"></span>
                                                <span class="mt-action-time">9:30-13:00</span>
                                            </div>
                                            <div class="mt-action-buttons">
                                                <div class="btn-group btn-group-circle">
                                                    <button type="button" class="btn btn-outline green btn-sm">Appove</button>
                                                    <button type="button" class="btn btn-outline red btn-sm">Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-action">
                                    <div class="mt-action-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar5.jpg" /> </div>
                                    <div class="mt-action-body">
                                        <div class="mt-action-row">
                                            <div class="mt-action-info ">
                                                <div class="mt-action-icon ">
                                                    <i class=" icon-graduation"></i>
                                                </div>
                                                <div class="mt-action-details ">
                                                    <span class="mt-action-author">Jason Dickens </span>
                                                    <p class="mt-action-desc">pending for approval pending for approval pending for approval pending for approval</p>
                                                </div>
                                            </div>
                                            <div class="mt-action-datetime ">
                                                <span class="mt-action-date">3 jun</span>
                                                <span class="mt-action-dot bg-red"></span>
                                                <span class="mt-action-time">9:30-13:00</span>
                                            </div>
                                            <div class="mt-action-buttons ">
                                                <div class="btn-group btn-group-circle">
                                                    <button type="button" class="btn btn-outline green btn-sm">Appove</button>
                                                    <button type="button" class="btn btn-outline red btn-sm">Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-action">
                                    <div class="mt-action-img">
                                        <img src="assets/theam_assets/pages/media/users/avatar2.jpg" /> </div>
                                    <div class="mt-action-body">
                                        <div class="mt-action-row">
                                            <div class="mt-action-info ">
                                                <div class="mt-action-icon ">
                                                    <i class="icon-badge"></i>
                                                </div>
                                                <div class="mt-action-details ">
                                                    <span class="mt-action-author">Jan Kim</span>
                                                    <p class="mt-action-desc">pending for approval pending for approval pending for approval pending for approval</p>
                                                </div>
                                            </div>
                                            <div class="mt-action-datetime ">
                                                <span class="mt-action-date">3 jun</span>
                                                <span class="mt-action-dot bg-green"></span>
                                                <span class="mt-action-time">9:30-13:00</span>
                                            </div>
                                            <div class="mt-action-buttons ">
                                                <div class="btn-group btn-group-circle">
                                                    <button type="button" class="btn btn-outline green btn-sm">Appove</button>
                                                    <button type="button" class="btn btn-outline red btn-sm">Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Completed -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Recent Activities</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn btn-sm blue btn-outline btn-circle" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Filter By
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
                                <label>
                                    <input type="checkbox" /> Finance</label>
                                <label>
                                    <input type="checkbox" checked="" /> Membership</label>
                                <label>
                                    <input type="checkbox" /> Customer Support</label>
                                <label>
                                    <input type="checkbox" checked="" /> HR</label>
                                <label>
                                    <input type="checkbox" /> System</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                        <ul class="feeds">
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 4 pending tasks.
                                                <span class="label label-sm label-warning "> Take action
                                                    <i class="fa fa-share"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> Just now </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> Finance Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-danger">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> New order received with
                                                <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 30 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-default">
                                                <i class="fa fa-bell-o"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> Web server hardware needs to be upgraded.
                                                <span class="label label-sm label-default "> Overdue </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 2 hours </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-default">
                                                    <i class="fa fa-briefcase"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> IPO Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-check"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 4 pending tasks.
                                                <span class="label label-sm label-warning "> Take action
                                                    <i class="fa fa-share"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> Just now </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-danger">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> Finance Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-default">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-info">
                                                <i class="fa fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> New order received with
                                                <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 30 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-success">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> You have 5 pending membership that requires a quick review. </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 24 mins </div>
                                </div>
                            </li>
                            <li>
                                <div class="col1">
                                    <div class="cont">
                                        <div class="cont-col1">
                                            <div class="label label-sm label-warning">
                                                <i class="fa fa-bell-o"></i>
                                            </div>
                                        </div>
                                        <div class="cont-col2">
                                            <div class="desc"> Web server hardware needs to be upgraded.
                                                <span class="label label-sm label-default "> Overdue </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="date"> 2 hours </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-info">
                                                    <i class="fa fa-briefcase"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> IPO Report for year 2013 has been released. </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 20 mins </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="scroller-footer">
                        <div class="btn-arrow-link pull-right">
                            <a href="javascript:;">See All Records</a>
                            <i class="icon-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="portlet light tasks-widget bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Tasks</span>
                        <span class="caption-helper">tasks summary...</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn green btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> More
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;"> All Project </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;"> AirAsia </a>
                                </li>
                                <li>
                                    <a href="javascript:;"> Cruise </a>
                                </li>
                                <li>
                                    <a href="javascript:;"> HSBC </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;"> Pending
                                        <span class="badge badge-danger"> 4 </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;"> Completed
                                        <span class="badge badge-success"> 12 </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;"> Overdue
                                        <span class="badge badge-warning"> 9 </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="task-content">
                        <div class="scroller" style="height: 312px;" data-always-visible="1" data-rail-visible1="1">
                            <!-- START TASK LIST -->
                            <ul class="task-list">
                                <li>
                                    <div class="task-checkbox">
                                        <input type="checkbox" class="liChild" value="" /> </div>
                                    <div class="task-title">
                                        <span class="task-title-sp"> Present 2013 Year IPO Statistics at Board Meeting </span>
                                        <span class="label label-sm label-success">Company</span>
                                        <span class="task-bell">
                                            <i class="fa fa-bell-o"></i>
                                        </span>
                                    </div>
                                    <div class="task-config">
                                        <div class="task-config-btn btn-group">
                                            <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="fa fa-cog"></i>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-check"></i> Complete </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Cancel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="task-checkbox">
                                        <input type="checkbox" class="liChild" value="" /> </div>
                                    <div class="task-title">
                                        <span class="task-title-sp"> Hold An Interview for Marketing Manager Position </span>
                                        <span class="label label-sm label-danger">Marketing</span>
                                    </div>
                                    <div class="task-config">
                                        <div class="task-config-btn btn-group">
                                            <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="fa fa-cog"></i>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-check"></i> Complete </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Cancel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="task-checkbox">
                                        <input type="checkbox" class="liChild" value="" /> </div>
                                    <div class="task-title">
                                        <span class="task-title-sp"> AirAsia Intranet System Project Internal Meeting </span>
                                        <span class="label label-sm label-success">AirAsia</span>
                                        <span class="task-bell">
                                            <i class="fa fa-bell-o"></i>
                                        </span>
                                    </div>
                                    <div class="task-config">
                                        <div class="task-config-btn btn-group">
                                            <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="fa fa-cog"></i>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-check"></i> Complete </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Cancel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="task-checkbox">
                                        <input type="checkbox" class="liChild" value="" /> </div>
                                    <div class="task-title">
                                        <span class="task-title-sp"> Technical Management Meeting </span>
                                        <span class="label label-sm label-warning">Company</span>
                                    </div>
                                    <div class="task-config">
                                        <div class="task-config-btn btn-group">
                                            <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="fa fa-cog"></i>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-check"></i> Complete </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Cancel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="task-checkbox">
                                        <input type="checkbox" class="liChild" value="" /> </div>
                                    <div class="task-title">
                                        <span class="task-title-sp"> Kick-off Company CRM Mobile App Development </span>
                                        <span class="label label-sm label-info">Internal Products</span>
                                    </div>
                                    <div class="task-config">
                                        <div class="task-config-btn btn-group">
                                            <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="fa fa-cog"></i>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-check"></i> Complete </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Cancel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="task-checkbox">
                                        <input type="checkbox" class="liChild" value="" /> </div>
                                    <div class="task-title">
                                        <span class="task-title-sp"> Prepare Commercial Offer For SmartVision Website Rewamp </span>
                                        <span class="label label-sm label-danger">SmartVision</span>
                                    </div>
                                    <div class="task-config">
                                        <div class="task-config-btn btn-group">
                                            <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="fa fa-cog"></i>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-check"></i> Complete </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Cancel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="task-checkbox">
                                        <input type="checkbox" class="liChild" value="" /> </div>
                                    <div class="task-title">
                                        <span class="task-title-sp"> Sign-Off The Comercial Agreement With AutoSmart </span>
                                        <span class="label label-sm label-default">AutoSmart</span>
                                        <span class="task-bell">
                                            <i class="fa fa-bell-o"></i>
                                        </span>
                                    </div>
                                    <div class="task-config">
                                        <div class="task-config-btn btn-group dropup">
                                            <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="fa fa-cog"></i>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-check"></i> Complete </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Cancel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="task-checkbox">
                                        <input type="checkbox" class="liChild" value="" /> </div>
                                    <div class="task-title">
                                        <span class="task-title-sp"> Company Staff Meeting </span>
                                        <span class="label label-sm label-success">Cruise</span>
                                        <span class="task-bell">
                                            <i class="fa fa-bell-o"></i>
                                        </span>
                                    </div>
                                    <div class="task-config">
                                        <div class="task-config-btn btn-group dropup">
                                            <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="fa fa-cog"></i>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-check"></i> Complete </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Cancel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="last-line">
                                    <div class="task-checkbox">
                                        <input type="checkbox" class="liChild" value="" /> </div>
                                    <div class="task-title">
                                        <span class="task-title-sp"> KeenThemes Investment Discussion </span>
                                        <span class="label label-sm label-warning">KeenThemes </span>
                                    </div>
                                    <div class="task-config">
                                        <div class="task-config-btn btn-group dropup">
                                            <a class="btn btn-sm default" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <i class="fa fa-cog"></i>
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-check"></i> Complete </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="fa fa-trash-o"></i> Cancel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- END START TASK LIST -->
                        </div>
                    </div>
                    <div class="task-footer">
                        <div class="btn-arrow-link pull-right">
                            <a href="javascript:;">See All Records</a>
                            <i class="icon-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-cursor font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">General Stats</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn btn-sm btn-circle red easy-pie-chart-reload">
                            <i class="fa fa-repeat"></i> Reload </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="easy-pie-chart">
                                <div class="number transactions" data-percent="55">
                                    <span>+55</span>% </div>
                                <a class="title" href="javascript:;"> Transactions
                                    <i class="icon-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="margin-bottom-10 visible-sm"> </div>
                        <div class="col-md-4">
                            <div class="easy-pie-chart">
                                <div class="number visits" data-percent="85">
                                    <span>+85</span>% </div>
                                <a class="title" href="javascript:;"> New Visits
                                    <i class="icon-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="margin-bottom-10 visible-sm"> </div>
                        <div class="col-md-4">
                            <div class="easy-pie-chart">
                                <div class="number bounce" data-percent="46">
                                    <span>-46</span>% </div>
                                <a class="title" href="javascript:;"> Bounce
                                    <i class="icon-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-equalizer font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Server Stats</span>
                        <span class="caption-helper">monthly stats...</span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"> </a>
                        <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                        <a href="" class="reload"> </a>
                        <a href="" class="remove"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="sparkline-chart">
                                <div class="number" id="sparkline_bar5"></div>
                                <a class="title" href="javascript:;"> Network
                                    <i class="icon-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="margin-bottom-10 visible-sm"> </div>
                        <div class="col-md-4">
                            <div class="sparkline-chart">
                                <div class="number" id="sparkline_bar6"></div>
                                <a class="title" href="javascript:;"> CPU Load
                                    <i class="icon-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="margin-bottom-10 visible-sm"> </div>
                        <div class="col-md-4">
                            <div class="sparkline-chart">
                                <div class="number" id="sparkline_line"></div>
                                <a class="title" href="javascript:;"> Load Rate
                                    <i class="icon-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <!-- BEGIN REGIONAL STATS PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-share font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Regional Stats</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-cloud-upload"></i>
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-wrench"></i>
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" data-container="false" data-placement="bottom" href="javascript:;"> </a>
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-trash"></i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="region_statistics_loading">
                        <img src="assets/theam_assets/global/img/loading.gif" alt="loading" /> </div>
                    <div id="region_statistics_content" class="display-none">
                        <div class="btn-toolbar margin-bottom-10">
                            <div class="btn-group btn-group-circle" data-toggle="buttons">
                                <a href="" class="btn grey-salsa btn-sm active"> Users </a>
                                <a href="" class="btn grey-salsa btn-sm"> Orders </a>
                            </div>
                            <div class="btn-group pull-right">
                                <a href="" class="btn btn-circle grey-salsa btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Select Region
                                    <span class="fa fa-angle-down"> </span>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:;" id="regional_stat_world"> World </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" id="regional_stat_usa"> USA </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" id="regional_stat_europe"> Europe </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" id="regional_stat_russia"> Russia </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" id="regional_stat_germany"> Germany </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="vmap_world" class="vmaps display-none"> </div>
                        <div id="vmap_usa" class="vmaps display-none"> </div>
                        <div id="vmap_europe" class="vmaps display-none"> </div>
                        <div id="vmap_russia" class="vmaps display-none"> </div>
                        <div id="vmap_germany" class="vmaps display-none"> </div>
                    </div>
                </div>
            </div>
            <!-- END REGIONAL STATS PORTLET-->
        </div>
        <div class="col-md-6 col-sm-6">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-globe font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Feeds</span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" class="active" data-toggle="tab"> System </a>
                        </li>
                        <li>
                            <a href="#tab_1_2" data-toggle="tab"> Activities </a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <!--BEGIN TABS-->
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
                                <ul class="feeds">
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-bell-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> You have 4 pending tasks.
                                                        <span class="label label-sm label-info"> Take action
                                                            <i class="fa fa-share"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> Just now </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New version v1.4 just lunched! </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 20 mins </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> Database server #12 overloaded. Please fix the issue. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 24 mins </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 30 mins </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 40 mins </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-warning">
                                                        <i class="fa fa-plus"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New user registered. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 1.5 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-bell-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> Web server hardware needs to be upgraded.
                                                        <span class="label label-sm label-default "> Overdue </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 2 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-default">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 3 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-warning">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 5 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 18 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-default">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 21 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 22 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-default">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 21 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 22 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-default">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 21 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 22 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-default">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 21 hours </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> New order received. Please take care of it. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 22 hours </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1_2">
                            <div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible1="1">
                                <ul class="feeds">
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New user registered </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> Just now </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New order received </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> 10 mins </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> Order #24DOP4 has been rejected.
                                                        <span class="label label-sm label-danger "> Take action
                                                            <i class="fa fa-share"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 24 mins </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New user registered </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> Just now </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New user registered </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> Just now </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New user registered </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> Just now </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New user registered </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> Just now </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New user registered </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> Just now </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New user registered </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> Just now </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <div class="col1">
                                                <div class="cont">
                                                    <div class="cont-col1">
                                                        <div class="label label-sm label-success">
                                                            <i class="fa fa-bell-o"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cont-col2">
                                                        <div class="desc"> New user registered </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col2">
                                                <div class="date"> Just now </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--END TABS-->
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <!-- BEGIN PORTLET-->
            <div class="portlet light calendar bordered">
                <div class="portlet-title ">
                    <div class="caption">
                        <i class="icon-calendar font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Feeds</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="calendar"> </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
        <div class="col-md-6 col-sm-6">
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
                                <img class="avatar" alt="" src="assets/theam_assets/layouts/layout/img/avatar2.jpg" />
                                <div class="message">
                                    <span class="arrow"> </span>
                                    <a href="javascript:;" class="name"> Lisa Wong </a>
                                    <span class="datetime"> at 20:11 </span>
                                    <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="assets/theam_assets/layouts/layout/img/avatar2.jpg" />
                                <div class="message">
                                    <span class="arrow"> </span>
                                    <a href="javascript:;" class="name"> Lisa Wong </a>
                                    <span class="datetime"> at 20:11 </span>
                                    <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="in">
                                <img class="avatar" alt="" src="assets/theam_assets/layouts/layout/img/avatar1.jpg" />
                                <div class="message">
                                    <span class="arrow"> </span>
                                    <a href="javascript:;" class="name"> Bob Nilson </a>
                                    <span class="datetime"> at 20:30 </span>
                                    <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="in">
                                <img class="avatar" alt="" src="assets/theam_assets/layouts/layout/img/avatar1.jpg" />
                                <div class="message">
                                    <span class="arrow"> </span>
                                    <a href="javascript:;" class="name"> Bob Nilson </a>
                                    <span class="datetime"> at 20:30 </span>
                                    <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="assets/theam_assets/layouts/layout/img/avatar3.jpg" />
                                <div class="message">
                                    <span class="arrow"> </span>
                                    <a href="javascript:;" class="name"> Richard Doe </a>
                                    <span class="datetime"> at 20:33 </span>
                                    <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="in">
                                <img class="avatar" alt="" src="assets/theam_assets/layouts/layout/img/avatar3.jpg" />
                                <div class="message">
                                    <span class="arrow"> </span>
                                    <a href="javascript:;" class="name"> Richard Doe </a>
                                    <span class="datetime"> at 20:35 </span>
                                    <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="assets/theam_assets/layouts/layout/img/avatar1.jpg" />
                                <div class="message">
                                    <span class="arrow"> </span>
                                    <a href="javascript:;" class="name"> Bob Nilson </a>
                                    <span class="datetime"> at 20:40 </span>
                                    <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="in">
                                <img class="avatar" alt="" src="assets/theam_assets/layouts/layout/img/avatar3.jpg" />
                                <div class="message">
                                    <span class="arrow"> </span>
                                    <a href="javascript:;" class="name"> Richard Doe </a>
                                    <span class="datetime"> at 20:40 </span>
                                    <span class="body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                </div>
                            </li>
                            <li class="out">
                                <img class="avatar" alt="" src="assets/theam_assets/layouts/layout/img/avatar1.jpg" />
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
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bubble font-dark hide"></i>
                        <span class="caption-subject font-hide bold uppercase">Recent Users</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn green-haze btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;"> Option 1</a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;">Option 2</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Option 3</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Option 4</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4">
                            <!--begin: widget 1-1 -->
                            <div class="mt-widget-1">
                                <div class="mt-icon">
                                    <a href="#">
                                        <i class="icon-plus"></i>
                                    </a>
                                </div>
                                <div class="mt-img">
                                    <img src="assets/theam_assets/pages/media/users/avatar80_8.jpg"> </div>
                                <div class="mt-body">
                                    <h3 class="mt-username">Diana Ellison</h3>
                                    <p class="mt-user-title"> Lorem Ipsum is simply dummy text. </p>
                                    <div class="mt-stats">
                                        <div class="btn-group btn-group btn-group-justified">
                                            <a href="javascript:;" class="btn font-red">
                                                <i class="icon-bubbles"></i> 1,7k </a>
                                            <a href="javascript:;" class="btn font-green">
                                                <i class="icon-social-twitter"></i> 2,6k </a>
                                            <a href="javascript:;" class="btn font-yellow">
                                                <i class="icon-emoticon-smile"></i> 3,7k </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: widget 1-1 -->
                        </div>
                        <div class="col-md-4">
                            <!--begin: widget 1-2 -->
                            <div class="mt-widget-1">
                                <div class="mt-icon">
                                    <a href="#">
                                        <i class="icon-plus"></i>
                                    </a>
                                </div>
                                <div class="mt-img">
                                    <img src="assets/theam_assets/pages/media/users/avatar80_7.jpg"> </div>
                                <div class="mt-body">
                                    <h3 class="mt-username">Jason Baker</h3>
                                    <p class="mt-user-title"> Lorem Ipsum is simply dummy text. </p>
                                    <div class="mt-stats">
                                        <div class="btn-group btn-group btn-group-justified">
                                            <a href="javascript:;" class="btn font-yellow">
                                                <i class="icon-bubbles"></i> 1,7k </a>
                                            <a href="javascript:;" class="btn font-blue">
                                                <i class="icon-social-twitter"></i> 2,6k </a>
                                            <a href="javascript:;" class="btn font-green">
                                                <i class="icon-emoticon-smile"></i> 3,7k </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: widget 1-2 -->
                        </div>
                        <div class="col-md-4">
                            <!--begin: widget 1-3 -->
                            <div class="mt-widget-1">
                                <div class="mt-icon">
                                    <a href="#">
                                        <i class="icon-plus"></i>
                                    </a>
                                </div>
                                <div class="mt-img">
                                    <img src="assets/theam_assets/pages/media/users/avatar80_6.jpg"> </div>
                                <div class="mt-body">
                                    <h3 class="mt-username">Julia Berry</h3>
                                    <p class="mt-user-title"> Lorem Ipsum is simply dummy text. </p>
                                    <div class="mt-stats">
                                        <div class="btn-group btn-group btn-group-justified">
                                            <a href="javascript:;" class="btn font-yellow">
                                                <i class="icon-bubbles"></i> 1,7k </a>
                                            <a href="javascript:;" class="btn font-red">
                                                <i class="icon-social-twitter"></i> 2,6k </a>
                                            <a href="javascript:;" class="btn font-green">
                                                <i class="icon-emoticon-smile"></i> 3,7k </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end: widget 1-3 -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-microphone font-dark hide"></i>
                        <span class="caption-subject bold font-dark uppercase"> Recent Works</span>
                        <span class="caption-helper">default option...</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <label class="btn red btn-outline btn-circle btn-sm active">
                                <input type="radio" name="options" class="toggle" id="option1">Settings</label>
                            <label class="btn  red btn-outline btn-circle btn-sm">
                                <input type="radio" name="options" class="toggle" id="option2">Tools</label>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-widget-2">
                                <div class="mt-head" style="background-image: url(assets/theam_assets/pages/img/background/32.jpg);">
                                    <div class="mt-head-label">
                                        <button type="button" class="btn btn-success">Manhattan</button>
                                    </div>
                                    <div class="mt-head-user">
                                        <div class="mt-head-user-img">
                                            <img src="assets/theam_assets/pages/img/avatars/team7.jpg"> </div>
                                        <div class="mt-head-user-info">
                                            <span class="mt-user-name">Chris Jagers</span>
                                            <span class="mt-user-time">
                                                <i class="icon-emoticon-smile"></i> 3 mins ago </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-body">
                                    <h3 class="mt-body-title"> Thomas Clark </h3>
                                    <p class="mt-body-description"> It is a long established fact that a reader will be distracted </p>
                                    <ul class="mt-body-stats">
                                        <li class="font-green">
                                            <i class="icon-emoticon-smile"></i> 3,7k</li>
                                        <li class="font-yellow">
                                            <i class=" icon-social-twitter"></i> 3,7k</li>
                                        <li class="font-red">
                                            <i class="  icon-bubbles"></i> 3,7k</li>
                                    </ul>
                                    <div class="mt-body-actions">
                                        <div class="btn-group btn-group btn-group-justified">
                                            <a href="javascript:;" class="btn">
                                                <i class="icon-bubbles"></i> Bookmark </a>
                                            <a href="javascript:;" class="btn ">
                                                <i class="icon-social-twitter"></i> Share </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-widget-2">
                                <div class="mt-head" style="background-image: url(assets/theam_assets/pages/img/background/43.jpg);">
                                    <div class="mt-head-label">
                                        <button type="button" class="btn btn-danger">London</button>
                                    </div>
                                    <div class="mt-head-user">
                                        <div class="mt-head-user-img">
                                            <img src="assets/theam_assets/pages/img/avatars/team3.jpg"> </div>
                                        <div class="mt-head-user-info">
                                            <span class="mt-user-name">Harry Harris</span>
                                            <span class="mt-user-time">
                                                <i class="icon-user"></i> 3 mins ago </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-body">
                                    <h3 class="mt-body-title"> Christian Davidson </h3>
                                    <p class="mt-body-description"> It is a long established fact that a reader will be distracted </p>
                                    <ul class="mt-body-stats">
                                        <li class="font-green">
                                            <i class="icon-emoticon-smile"></i> 3,7k</li>
                                        <li class="font-yellow">
                                            <i class=" icon-social-twitter"></i> 3,7k</li>
                                        <li class="font-red">
                                            <i class="  icon-bubbles"></i> 3,7k</li>
                                    </ul>
                                    <div class="mt-body-actions">
                                        <div class="btn-group btn-group btn-group-justified">
                                            <a href="javascript:;" class="btn ">
                                                <i class="icon-bubbles"></i> Bookmark </a>
                                            <a href="javascript:;" class="btn ">
                                                <i class="icon-social-twitter"></i> Share </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-microphone font-dark hide"></i>
                        <span class="caption-subject bold font-dark uppercase"> Recent Projects</span>
                        <span class="caption-helper">default option...</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <label class="btn blue btn-outline btn-circle btn-sm active">
                                <input type="radio" name="options" class="toggle" id="option1">Actions</label>
                            <label class="btn  blue btn-outline btn-circle btn-sm">
                                <input type="radio" name="options" class="toggle" id="option2">Tools</label>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mt-widget-4">
                                <div class="mt-img-container">
                                    <img src="assets/theam_assets/pages/img/background/34.jpg" /> </div>
                                <div class="mt-container bg-purple-opacity">
                                    <div class="mt-head-title"> Website Revamp & Deployment </div>
                                    <div class="mt-body-icons">
                                        <a href="#">
                                            <i class=" icon-pencil"></i>
                                        </a>
                                        <a href="#">
                                            <i class=" icon-map"></i>
                                        </a>
                                        <a href="#">
                                            <i class=" icon-trash"></i>
                                        </a>
                                    </div>
                                    <div class="mt-footer-button">
                                        <button type="button" class="btn btn-circle btn-danger btn-sm">Dior</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mt-widget-4">
                                <div class="mt-img-container">
                                    <img src="assets/theam_assets/pages/img/background/46.jpg" /> </div>
                                <div class="mt-container bg-green-opacity">
                                    <div class="mt-head-title"> CRM Development & Deployment </div>
                                    <div class="mt-body-icons">
                                        <a href="#">
                                            <i class=" icon-social-twitter"></i>
                                        </a>
                                        <a href="#">
                                            <i class=" icon-bubbles"></i>
                                        </a>
                                        <a href="#">
                                            <i class=" icon-bell"></i>
                                        </a>
                                    </div>
                                    <div class="mt-footer-button">
                                        <button type="button" class="btn btn-circle blue-ebonyclay btn-sm">Nike</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mt-widget-4">
                                <div class="mt-img-container">
                                    <img src="assets/theam_assets/pages/img/background/37.jpg" /> </div>
                                <div class="mt-container bg-dark-opacity">
                                    <div class="mt-head-title"> Marketing Campaigns </div>
                                    <div class="mt-body-icons">
                                        <a href="#">
                                            <i class=" icon-bubbles"></i>
                                        </a>
                                        <a href="#">
                                            <i class=" icon-map"></i>
                                        </a>
                                        <a href="#">
                                            <i class=" icon-cup"></i>
                                        </a>
                                    </div>
                                    <div class="mt-footer-button">
                                        <button type="button" class="btn btn-circle btn-success btn-sm">Honda</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-microphone font-dark hide"></i>
                        <span class="caption-subject bold font-dark uppercase"> Activities</span>
                        <span class="caption-helper">default option...</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a class="btn red btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="javascript:;"> Option 1</a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="javascript:;">Option 2</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Option 3</a>
                                </li>
                                <li>
                                    <a href="javascript:;">Option 4</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mt-widget-3">
                                <div class="mt-head bg-blue-hoki">
                                    <div class="mt-head-icon">
                                        <i class=" icon-social-twitter"></i>
                                    </div>
                                    <div class="mt-head-desc"> Lorem Ipsum is simply dummy text of the ... </div>
                                    <span class="mt-head-date"> 25 Jan, 2015 </span>
                                    <div class="mt-head-button">
                                        <button type="button" class="btn btn-circle btn-outline white btn-sm">Add</button>
                                    </div>
                                </div>
                                <div class="mt-body-actions-icons">
                                    <div class="btn-group btn-group btn-group-justified">
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-align-justify"></i>
                                            </span>RECORD </a>
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-camera"></i>
                                            </span>PHOTO </a>
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>DATE </a>
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-record"></i>
                                            </span>RANC </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mt-widget-3">
                                <div class="mt-head bg-red">
                                    <div class="mt-head-icon">
                                        <i class="icon-user"></i>
                                    </div>
                                    <div class="mt-head-desc"> Lorem Ipsum is simply dummy text of the ... </div>
                                    <span class="mt-head-date"> 12 Feb, 2016 </span>
                                    <div class="mt-head-button">
                                        <button type="button" class="btn btn-circle btn-outline white btn-sm">Add</button>
                                    </div>
                                </div>
                                <div class="mt-body-actions-icons">
                                    <div class="btn-group btn-group btn-group-justified">
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-align-justify"></i>
                                            </span>RECORD </a>
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-camera"></i>
                                            </span>PHOTO </a>
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>DATE </a>
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-record"></i>
                                            </span>RANC </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mt-widget-3">
                                <div class="mt-head bg-green">
                                    <div class="mt-head-icon">
                                        <i class=" icon-graduation"></i>
                                    </div>
                                    <div class="mt-head-desc"> Lorem Ipsum is simply dummy text of the ... </div>
                                    <span class="mt-head-date"> 3 Mar, 2015 </span>
                                    <div class="mt-head-button">
                                        <button type="button" class="btn btn-circle btn-outline white btn-sm">Add</button>
                                    </div>
                                </div>
                                <div class="mt-body-actions-icons">
                                    <div class="btn-group btn-group btn-group-justified">
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-align-justify"></i>
                                            </span>RECORD </a>
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-camera"></i>
                                            </span>PHOTO </a>
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>DATE </a>
                                        <a href="javascript:;" class="btn ">
                                            <span class="mt-icon">
                                                <i class="glyphicon glyphicon-record"></i>
                                            </span>RANC </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $('document').ready(function(){
        $('#dashboard').parents('li').addClass('open');
        $('#dashboard').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#dashboard'));
    });
</script>
<script type="text/javascript">
window.onload = startup;
function startup(){
    realtime_refresh_display();
}
var ar_refresh = <?php echo 1; ?>;
var ar_seconds = <?php echo 1; ?>;
var $start_count=0;
function realtime_refresh_display(){
    if ($start_count < 1){
        gather_realtime_content();
    }
    $start_count++;
    if (ar_seconds > 0){
        document.getElementById("refresh_countdown").innerHTML = "" + ar_seconds + "";
        ar_seconds = (ar_seconds - 1);
        setTimeout("realtime_refresh_display()",1000);
    }else{
        document.getElementById("refresh_countdown").innerHTML = "0";
        ar_seconds = ar_refresh;
        //window.location.reload();
        gather_realtime_content();
        setTimeout("realtime_refresh_display()",1000);
    }
}
function gather_realtime_content(){
   //jQuery('#loading').modal('show');
   var postData = jQuery('#groupForm').serialize();
   jQuery.ajax({
        url : '<?php echo site_url('dialer/report/realtimeajax') ?>',
        method : 'post',
        dataType : 'JSON',
        data : postData,
        success : function(result){
            var flag = Boolean(result.success);
            jQuery('#realtime_content').html(result.html);
            jQuery('#loading').modal('hide');
        }
   });
   //jQuery('#loading').modal('hide');
}
function update_variables(task_option,task_choice,force_reload){
    if (task_option == 'adastats'){
        var adastats = parseInt(jQuery('#adastats').val());
        if (adastats == 1){
            jQuery('#adastats').val('2');
            jQuery('#text_adastats').html('View Less');
            jQuery('#text_adastats').parent('li').addClass('active');
        }else{
            jQuery('#adastats').val('1');
            jQuery('#text_adastats').html('View More');
            jQuery('#text_adastats').parent('li').removeClass('active');
        }
    } //if (task_option == 'adastats'){

    if(task_option == 'ALLINGROUPstats'){
        var ALLINGROUPstats = parseInt(jQuery('#ALLINGROUPstats').val());
        if(ALLINGROUPstats == 0){
            jQuery('#ALLINGROUPstats').val('1');
            jQuery('#text_ALLINGROUPstats').html('<?php echo "Hide In-Group Stats" ?>');
            jQuery('#text_ALLINGROUPstats').parent('li').addClass('active');
        }else{
            jQuery('#ALLINGROUPstats').val('0');
            jQuery('#text_ALLINGROUPstats').html('<?php echo "Show In-Group Stats" ?>')
            jQuery('#text_ALLINGROUPstats').parent('li').removeClass('active');
        }
    } //if(task_option == 'ALLINGROUPstats')
    if (task_option == 'PHONEdisplay'){
        var PHONEdisplay = parseInt(jQuery('#PHONEdisplay').val());
        if(PHONEdisplay == 0){
            jQuery('#PHONEdisplay').val('1');
            jQuery('#text_PHONEdisplay').html('<?php echo "Hide Phone" ?>');
            jQuery('#text_PHONEdisplay').parent('li').addClass('active');
        }else{
            jQuery('#PHONEdisplay').val('0');
            jQuery('#text_PHONEdisplay').html('<?php echo "Show Phone" ?>');
            jQuery('#text_PHONEdisplay').parent('li').removeClass('active');
        }
    }
    if (task_option == 'SERVdisplay'){
        var SERVdisplay = parseInt(jQuery('#SERVdisplay').val());
        if(SERVdisplay == 0){
            jQuery('#SERVdisplay').val('1');
            jQuery('#text_SERVdisplay').html('<?php echo "Hide Server Info" ?>');
            jQuery('#text_SERVdisplay').parent('li').addClass('active');
        }else{
            jQuery('#SERVdisplay').val('0');
            jQuery('#text_SERVdisplay').html('<?php echo "Show Server Info" ?>');
            jQuery('#text_SERVdisplay').parent('li').removeClass('active');
        }
    }
    if (task_option == 'UGdisplay'){
        var UGdisplay = parseInt(jQuery('#UGdisplay').val());
        if(UGdisplay == 0){
            jQuery('#UGdisplay').val('1');
            jQuery('#text_UGdisplay').html('<?php echo "Hide User Group" ?>');
            jQuery('#text_UGdisplay').parent('li').addClass('active');
        }else{
            jQuery('#UGdisplay').val('0');
            jQuery('#text_UGdisplay').html('<?php echo "Show User Group" ?>');
            jQuery('#text_UGdisplay').parent('li').removeClass('active');
        }
    }
    if(task_option == 'CUSTPHONEdisplay'){
        var CUSTPHONEdisplay = parseInt(jQuery('#CUSTPHONEdisplay').val());
        if(CUSTPHONEdisplay == 0){
            jQuery('#CUSTPHONEdisplay').val('1');
            jQuery('#text_CUSTPHONEdisplay').html('<?php echo "Hide Customphone" ?>');
            jQuery('#text_CUSTPHONEdisplay').parent('li').addClass('active');
        }else{
            jQuery('#CUSTPHONEdisplay').val('0');
            jQuery('#text_CUSTPHONEdisplay').html('<?php echo "Show Customphone" ?>');
            jQuery('#text_CUSTPHONEdisplay').parent('li').removeClass('active');
        }
    }
    if(task_option == 'CALLSdisplay'){
        var CALLSdisplay = parseInt(jQuery('#CALLSdisplay').val());
        if(CALLSdisplay == 0){
            jQuery('#CALLSdisplay').val('1');
            jQuery('#text_CALLSdisplay').html('<?php echo "Hide Waiting Calls" ?>');
            jQuery('#text_CALLSdisplay').parent('li').removeClass('active');
        }else{
            jQuery('#CALLSdisplay').val('0');
            jQuery('#text_CALLSdisplay').html('<?php echo "Show Waiting Calls" ?>');
            jQuery('#text_CALLSdisplay').parent('li').addClass('active');
        }
    }
    gather_realtime_content();
}
function send_monitor(session_id,server_ip,stage){
    var monitor_phone = jQuery('#monitor_phone').val();
    var postData = {
          phone_login : monitor_phone,
          session_id : session_id,
          server_ip: server_ip,
          stage : stage
    };
    jQuery.ajax({
        url : '<?php echo site_url('dialer/report/monitor') ?>',
        method : 'POST',
        dataType : 'json',
        data : postData,
        success : function(result){
            var flag = Boolean(result.success);
            var msg = result.html;
            var regXFerr = new RegExp("ERROR","g");
            var regXFscs = new RegExp("SUCCESS","g");
            if (msg.match(regXFerr)){
                    alert(msg);
            }
            if (msg.match(regXFscs)){
                alert("<?php echo "SUCCESS: calling"; ?> " + monitor_phone);
            }
        }
    });
}
function jsonpcallback(data) {
    //do stuff with JSON
    //console.log(data.statusText);
}

jQuery(document).on('submit','#groupForm',function(event){
    event.preventDefault();
    jQuery('#responsive').modal("hide");
    gather_realtime_content();
});
</script>