    <?php
            $ci   = & get_instance();
            $menu = $ci->router->fetch_class();
            $method = $this->router->fetch_method();
            $currentUrl = base_url(uri_string());
    ?>
<a href="<?php echo site_url() ?>" class="page-logo nav-logo" id="index" style="display: none;">
    <img alt="Logo" src="<?php echo site_url() ?>uploads/logo/logo2.png">
</a>
    <ul class="nav navbar-nav">
        <li class="sidebar-toggler-wrapper hide">
            <div class="sidebar-toggler"> </div>
        </li>
        <li class="dropdown dropdown-fw">
            <a class="text-uppercase" href="<?php echo site_url('agent') ?>">
                <span class="dash-icon nav-icons"></span>
                <span class="title"><?php echo 'Dashboard' ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li>
                    <a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a>
                </li>
                <li>
                    <a class="nav-link" href="<?php echo site_url('calendar/index') ?>">
                        <?php echo 'Calendar' ?>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="<?php echo site_url('email/inbox') ?>">
                        <?php echo 'Email' ?>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="<?php echo site_url('task/index') ?>">
                        <?php echo 'Tasks'; ?>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="<?php echo site_url('emailconfiguration/index') ?>">
                        <?php echo 'Email Configuration'; ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown dropdown-fw" id="dialpadd">
            <a class="text-uppercase" href="<?php echo site_url('dial/index'); ?>">
                <span class="head-icon nav-icons"></span>
                <span class="title"><?php echo 'Dialer' ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li class="dropdown">
                    <a href="<?php echo site_url('dial/index'); ?>">
                        <?php echo 'Dialer' ?>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="<?php echo site_url('dial/voicemail'); ?>">
                        <?php echo 'Voicemail' ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown dropdown-fw" id="crm">
            <a class="text-uppercase" href="<?php echo site_url('crm/index') ?>">
                <span class="crm-icon nav-icons"></span>
                <span class="title"><?php echo 'CRM' ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li class="dropdown">
                    <a href="<?php echo site_url('crm/index') ?>">
                        <?php echo 'Overview' ?>
                    </a>
                </li>
                <li class="dropdown" id="lead">
                    <a href="<?php echo site_url('crm/leadindex') ?>">
                        <?php echo 'Leads' ?>
                    </a>
                </li>
                <li class="dropdown" id="opportunity">
                    <a href="<?php echo site_url('crm/opportunities') ?>">
                        <?php echo 'Opportunities' ?>
                    </a>
                </li>
                <li class="dropdown" id="client">
                    <a href="<?php echo site_url('crm/clients') ?>">
                        <?php echo 'Clients' ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown dropdown-fw" id="quote">
            <a class="text-uppercase" href="<?php echo site_url('quote/index') ?>">
                <span class="quote-icon nav-icons"></span>
                <span class="title"><?php echo 'Quote & Apply' ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li class="dropdown">
                    <a href="<?php echo site_url('quote/index') ?>">
                        <?php echo 'New Quote' ?>
                    </a>
                </li>
            </ul>
        </li>
        <li id="leadstr" class="dropdown dropdown-fw <?php if($menu == 'leadstore') { echo 'open'; }?>">
            <a class="text-uppercase" href="<?php echo site_url('leadstore/index') ?>">
                <span class="lead-icon nav-icons"></span>
                <span class="title"><?php echo 'Lead Store' ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li class="dropdown">
                    <a href="<?php echo site_url('leadstore/index') ?>">
                        <?php echo 'Overview' ?>
                    </a>
                </li>
                <li class="dropdown <?php if($menu == 'leadstore' && $method == 'edit') { echo 'active'; }?>">
                    <a href="<?php echo site_url('leadstore/campaigns') ?>">
                        <?php echo 'Campaigns' ?>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="<?php echo site_url('leadstore/archive_campaigns') ?>">
                        <?php echo 'Archive Campaigns' ?>
                    </a>
                </li>
                <!-- <li class="dropdown" id="vendor">
                    <a href="<?php echo site_url('vendor/index') ?>">
                        <?php echo 'Vendors' ?>
                    </a>
                </li> -->
                <li class="dropdown" id="billindm">
                    <a href="<?php echo site_url('billing/transaction') ?>">
                        <?php echo 'Billing' ?>
                    </a>
                </li>
                <li class="dropdown" id='savedfil'>
                    <a href="<?php echo site_url('storecheckout/findex') ?>">
                        <?php echo 'Saved Filters' ?>
                    </a>
                </li>
                <li class="dropdown" id='item-cart'>
                    <a href="<?php echo site_url('storecheckout/cart') ?>">
                        <?php echo 'Cart' ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown dropdown-fw">
            <a class="text-uppercase" href="javascript:;">
                <span class="market-icon nav-icons"></span>
                <span class="title"><?php echo 'Marketing' ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li class="dropdown">
                    <a href="#">
                        <?php echo 'Overview' ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown dropdown-fw">
            <a class="text-uppercase" href="<?php echo site_url('contract/index') ?>">
                <span class="contra-icon nav-icons"></span>
                <span class="title"><?php echo 'Contracting' ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li class="dropdown">
                    <a href="<?php echo site_url('contract/index') ?>">
                        <?php echo 'Pending Activities' ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="dropdown dropdown-fw">
            <a class="text-uppercase" href="<?php echo site_url('commission/index') ?>">
                <span class="comm-icon nav-icons"></span>
                <span class="title"><?php echo 'Commissions' ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li class="dropdown">
                    <a href="<?php echo site_url('commission/index') ?>">
                        <?php echo 'Overview' ?>
                    </a>
                </li>
            </ul>
        </li>
        <?php /* if(isset($this->session->userdata('agent')->agent_type) && $this->session->userdata('agent')->agent_type == 1): ?>
        <li class="dropdown dropdown-fw">
            <a href="<?php echo site_url('customer/manage_customer/add'); ?>" class="text-uppercase">
                <span class="user-icon nav-icons"></span>
                <span class="title" id='customer'>Customer</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li class="dropdown">
                    <a href="<?php echo site_url('customer/manage_customer/add'); ?>">
                        <span class="title" id='add_customer'>Add Customer</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="<?php echo site_url('customer/cindex'); ?>">
                        <span class="title" id='view_customer'>View Customers</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; */ ?>
        <?php /* if(isset($this->session->userdata('agent')->agent_type) && $this->session->userdata('agent')->agent_type == 2): ?>
        <li class="dropdown dropdown-fw">
            <a href="<?php echo site_url('customer/manage_customer/view'); ?>" class="text-uppercase">
                <span class="user-icon nav-icons"></span>
                <span class="title" id='customer'>Customer</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li class="dropdown">
                    <a href="<?php echo site_url('customer/manage_customer/view'); ?>">
                        <span class="title" id='view_customer'>View Customers</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; */ ?>
        <?php /*
        <li class="dropdown dropdown-fw" id="dialer-agent">
            <a class="text-uppercase" href="<?php echo site_url('dialer/agent/user') ?>">
                <span class="title"><?php echo 'Login' ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-fw">
                <li class="dropdown">
                    <a href="<?php echo site_url('dialer/agent/user') ?>">
                        <i></i>
                        <span class="title"><?php echo 'User' ?></span>
                    </a>
                </li>
                <li class="dropdown" >
                    <a href="<?php echo site_url('dialer/agent/phone') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Phone' ?></span>
                    </a>
                </li>
                <li class="dropdown" >
                    <a href="http://173.254.218.90/agc/vicidial.php" target="_blank">
                        <i></i>
                        <span class="title"><?php echo 'Dialer Agent Login' ?></span>
                    </a>
                </li>
            </ul>
        </li>*/ ?>
    </ul>
<script type="text/javascript">
 jQuery(function(){
    var current = '<?php echo $currentUrl ?>';
    var n = current.search("dialer");
    if(n >= 0){
        jQuery('#<?php echo 'dialer-'.$menu; ?>').addClass('active');
    }else{
        jQuery('#<?php echo $menu; ?>').addClass('active');
    }
    jQuery('.navbar-nav li a ').each(function(){
        var href = jQuery(this).attr('href');
        console.log(current)
        if( href == current ){
            jQuery(this).parent('li').prevAll('li.dropdown').find('ul.dropdown-menu').css('z-index','100');
            jQuery(this).parent('li').addClass('active');
            jQuery(this).parent('li').addClass('open');
            jQuery(this).parent('li').parent('.dropdown-menu-fw').parent('li').addClass('open');
            jQuery('#<?php echo $menu; ?>').addClass('active');
            var cla = jQuery(this).attr('data-class');
            if(typeof cla != 'undefined'){
                jQuery('.'+cla).addClass('active');
            }
            var dta = jQuery(this).attr('data-ref');
            if(typeof dta != 'undefined'){
                jQuery('.'+dta).addClass('active');
            }
        }
    });
    jQuery(document).on( 'mouseenter','.fixed>.nav>li>a.text-uppercase', function(){
        $(this).find('ul.dropdown-menu').removeClass('fixed-open');
        /*$('.fixed>.nav>li').each(function(){
            if(jQuery(this).hasClass('active') == false){
                $(this).find('ul.dropdown-menu').removeClass('fixed-open');
            }
        });*/
        $(this).parent('li').find('ul').addClass('fixed-open');
    });
    jQuery(document).on( 'mouseleave','.fixed>.nav', function(event){
        //console.log(event.target)
        $(this).find('ul.dropdown-menu').removeClass('fixed-open');
        /*$('.fixed>.nav>li').each(function(){
            if(jQuery(this).hasClass('active') == false){
                $(this).find('ul.dropdown-menu').removeClass('fixed-open');
            }

        });*/
    });

    jQuery(document).on( 'mouseenter','.static>.nav>li>a.text-uppercase', function(){
        $('.static>.nav>li').each(function(){
            if(jQuery(this).hasClass('active') == false){
                jQuery(this).removeClass('open');
            }
        });
        $(this).parent('li').addClass('open');
    });
    jQuery(document).on( 'mouseleave','.static>.nav', function(event){
        //console.log(event.target)
        $('.static>.nav>li').each(function(){
            if(jQuery(this).hasClass('active') == false){
                jQuery(this).removeClass('open');
            }
        });
    });
 });
</script>
