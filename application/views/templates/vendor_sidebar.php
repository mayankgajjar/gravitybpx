<div class="page-sidebar navbar-collapse collapse">
    <?php
    $ci = & get_instance();
    $menu = $ci->router->fetch_class();
    $currentUrl = base_url(uri_string());
    ?>
    <ul class="page-sidebar-menu page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
        <li class="sidebar-toggler-wrapper hide">
            <div class="sidebar-toggler"> </div>
        </li>
        <li class="nav-item start">
            <a href="<?php echo site_url('vendor'); ?>" class="nav-link ">
                <i class="icon-bar-chart"></i>
                <span class="title" id='dashboard'>Dashboard</span>
                <span class="selected"></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-industry"></i>
                <span class="title" id='leads'>Leads</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('ven/lead/edit'); ?>" class="nav-link ">
                        <span class="title" id='add_lead'>Add Lead</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('ven/lead/index') ?>" class="nav-link ">
                        <span class="title" id='view_leads'>View Leads</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <script type="text/javascript">
        jQuery(function () {
<?php if (isset($_GET['did']) && $_GET['did'] == 'yes'): ?>
    <?php $currentUrl .= '?did=yes' ?>
<?php endif; ?>
            var current = '<?php echo $currentUrl ?>';
<?php if ($menu == 'calltime'): ?>
                jQuery('.dialer').addClass('active');
<?php endif; ?>
<?php if ($menu == 'sreport' || $menu == 'treport'): ?>
    <?php $menu = 'report' ?>
<?php endif; ?>
            jQuery('#<?php echo $menu; ?>').addClass('active');
            jQuery('.page-sidebar-menu li a ').each(function () {
                var href = jQuery(this).attr('href');
                if (href == current) {
                    jQuery(this).parent('li').addClass('active');
                    jQuery('#<?php echo $menu; ?>').addClass('active');
                    var cla = jQuery(this).attr('data-class');
                    if (typeof cla != 'undefined') {
                        jQuery('.' + cla).addClass('active');
                    }
                    var dta = jQuery(this).attr('data-ref');
                    if (typeof dta != 'undefined') {
                        jQuery('.' + dta).addClass('active');
                    }
                }
            });
        });
    </script>
</div>

<!-- END SIDEBAR -->