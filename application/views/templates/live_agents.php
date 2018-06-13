<!-- BEGIN QUICK SIDEBAR -->
<a href="javascript:;" class="page-quick-sidebar-toggler">
    <i class="icon-login"></i>
</a>
<style type="text/css">
    .media-offline{border-left: 10px solid grey;}
    .media-online{border-left: 10px solid green;}
    .media-pause{border-left: 10px solid red;}
    .status-text{
        float: right;
        font-size: 17px;
        text-transform: uppercase;
        font-weight: bold;
        color: #31c7b2;
    }
</style>
<div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
    <div class="page-quick-sidebar">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"><?php echo 'Team Members' ?>
                    <!--span class="badge badge-danger">2</span-->
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                    <h3 class="list-heading">Staff</h3>
                    <div id="agent_status">
                        <ul class="media-list list-items side-userstatus" data-bind="foreach : userstatus">
                        <li data-bind="attr: { 'class' : 'media ' + mediaclass() , 'id' : 'media-' + mediaagentid }" data-extension="" >
                            <div class="media-status"></div>

                            <img class="media-object" data-bind="attr:{ src: uavatar }">
                            <div class="media-body">
                                <h4 class="media-heading"><span data-bind="text:uname"></span><span class="status-text"></span></h4>
                                <div class="media-heading-sub" data-bind="text:agenttype"></div>
                                <div class="media-heading-sub"><a class="select-link" href="#"  style="display:none;"><?php echo "Click For Transfer" ?></a></div>
                            </div>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END QUICK SIDEBAR -->