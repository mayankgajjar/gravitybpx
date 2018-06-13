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
                    <h3 class="list-heading">All Agent List</h3>
                    <div id="agent_status">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END QUICK SIDEBAR -->
<script type="text/javascript">
    liveagent();
    timer = setInterval(function () {
        liveagent();
    }, 10000);
    function liveagent() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'checker/AllAgentByAgencyid'; ?>',
            success: function (data) {
                $('#agent_status').html(data);
            }
        });
    }
</script>