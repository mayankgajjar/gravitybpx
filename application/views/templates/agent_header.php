<button data-target=".navbar-responsive-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
    <span class="sr-only"><?php echo 'Toggle navigation' ?></span>
    <span class="toggle-icon">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </span>
</button>
<a href="<?php echo site_url('agent') ?>" class="page-logo" id="index">
    <?php
    $path = "assets/theam_assets/layouts/layout/img/logo.png";
    $image_name = get_option('site_logo');
    if ($image_name != "") {
        $path = "uploads/logo/$image_name";
    }
    ?>
    <img alt="Logo" src="<?php echo $path; ?>" />
</a>
<p class="call-status page-logo" id="MainStatuSSpan" style="line-height: 15px;height:auto;font-weight:bold;color:#ED6B75;display:block;position:fixed;text-align:center;top:0;width:100%;z-index:10000;"></p>
<div class="topbar-actions">
    <div class="btn-group dropdown-statuses status-dropdown" id="header_agent_status">
        <button id="phone_status" href="javascript:;" class="btn btn-sm md-skip dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <span class="plivo-status-icon"><i class="fa fa-square status-busy"></i></span>
            <span class="user-status-current plivo-status">Pause</span>
            <b class="caret"></b>
        </button>
        <ul class="dropdown-menu status-dropdown">
            <li>
                <a onClick="changeStatus('ready')"><i class="fa fa-check-circle"></i><?php echo 'Online' ?></a>
            </li>
            <li>
                <a onClick="changeStatus('busy')"><i class="fa fa-minus-circle"></i><?php echo 'Busy' ?></a>
            </li>
            <li>
                <a onClick="changeStatus('away')"><i class="fa fa-clock-o"></i><?php echo 'Away' ?></a>
            </li>
            <li>
                <a onClick="changeStatus('lunch')"><i class="fa fa-square" aria-hidden="true"></i><?php echo 'Lunch' ?></a>
            </li>
        </ul>
    </div><!-- .btn-group-red btn-group -->
    <?php
    $this->load->view('agent/crm/create');
    ?>
    <div id="header_notification_bar" class="btn-group-notification btn-group">
        <?php if ($this->session->userdata("agent")->agent_type == 1) : ?>
            <button data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="btn btn-sm md-skip dropdown-toggle" type="button">
                <i class="icon-bell"></i>
                <span class="badge alert_notification1 user_notification"></span>
            </button>
            <ul class="dropdown-menu-v2">
                <li class="external">
                    <h3><span class="bold">Notifications</span></h3>
                </li>
                <li>
                    <div class="NotificationDiv">
                        <!-- <ul class="dropdown-menu-list notifications1 scroller" style="height: 250px;" data-handle-color="#637283">
                        </ul>  -->
                        <ul class="dropdown-menu-list notifications1 scroller" style="height: 250px;" data-handle-color="#637283" data-bind="foreach: notification">
                            <li data-bind="attr: { class : classe }">
                                <a href="#" data-bind="attr: { href: url }">
                                    <span class="details">
                                        <span class="label label-sm label-icon label-success">
                                            <span data-bind="html: log_type"></span>
                                        </span> <p data-bind="text: title"></p>
                                    </span>
                                    <span class="time" data-bind="text: time"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        <?php elseif ($this->session->userdata("agent")->agent_type == 2): ?>
            <button data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="btn btn-sm md-skip dropdown-toggle" type="button">
                <i class="icon-bell"></i>
                <span class="badge alert_notification2 user_notification"></span>
            </button>
            <ul class="dropdown-menu-v2">
                <li class="external">
                    <h3><span class="bold">Notifications</span></h3>
                </li>
                <li>
                    <div class="NotificationDiv">
                        <!-- <ul class="dropdown-menu-list notifications2 scroller" style="height: 250px;" data-handle-color="#637283">
                        </ul> -->
                        <ul class="dropdown-menu-list notifications1 scroller" style="height: 250px;" data-handle-color="#637283" data-bind="foreach: notification">
                            <li data-bind="attr: { class : classe }">
                                <a href="#" data-bind="attr: { href: url }">
                                    <span class="details">
                                        <span class="label label-sm label-icon label-success">
                                            <span data-bind="html: log_type"></span>
                                        </span> <p data-bind="text: title"></p>
                                    </span>
                                    <span class="time" data-bind="text: time"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        <?php else: ?>
            <button data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="btn btn-sm md-skip dropdown-toggle" type="button">
                <i class="icon-bell"></i>
                <span class="badge alert_notification3 user_notification"></span>
            </button>
            <ul class="dropdown-menu-v2">
                <li class="external">
                    <h3><span class="bold">Notifications</span></h3>
                </li>
                <li>
                    <div class="NotificationDiv">
                        <!-- <ul class="dropdown-menu-list notifications3 scroller" style="height: 250px;" data-handle-color="#637283">
                        </ul> -->
                        <ul class="dropdown-menu-list notifications1 scroller" style="height: 250px;" data-handle-color="#637283" data-bind="foreach: notification">
                            <li data-bind="attr: { class : classe }">
                                <a href="#" data-bind="attr: { href: url }">
                                    <span class="details">
                                        <span class="label label-sm label-icon label-success">
                                            <span data-bind="html: log_type"></span>
                                        </span> <p data-bind="text: title"></p>
                                    </span>
                                    <span class="time" data-bind="text: time"></span>
                                </a>
                            </li>
                        </ul>   
                    </div>
                </li>
            </ul>
        <?php endif; ?>
    </div><!-- .header notification -->
    <div class="btn-group-img btn-group">
        <?php
        $profile = $this->session->userdata('agent')->profile_image;
        if (empty($profile) || is_null($profile)) {
            $profile = 'uploads/agents/no-photo-available.jpg';
        } else {
            $profile = 'uploads/agents/' . $profile;
        }
        $r = rand(12501, 48525);
        $profile .= "?" . $r;
        ?>
        <button data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="btn btn-sm md-skip dropdown-toggle" type="button">
            <span><?php echo $this->session->userdata('user')->email_id; ?></span>
            <img alt="" src="<?php echo $profile; ?>" />
        </button>
        <ul role="menu" class="dropdown-menu-v2">
            <li>
                <a href="<?php echo site_url('agent/profile') ?>">
                    <i class="icon-user"></i><?php echo 'My Profile' ?>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('others/logout') ?>" id="logoutBtn" onclick="Plivo.conn.logout();">
                    <i class="icon-user"></i><?php echo 'Logout' ?>
                </a>
            </li>
        </ul>
    </div><!-- .btn-group-img btn-group -->
    <button data-toggle="collapse" class="quick-sidebar-toggler md-skip" type="button">
        <span class="sr-only">Toggle Quick Sidebar</span>
        <i class="icon-logout"></i>
    </button>
</div>