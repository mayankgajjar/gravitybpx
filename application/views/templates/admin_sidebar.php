<div class="page-sidebar navbar-collapse collapse">
    <?php
    $ci = & get_instance();
    $menu = $ci->router->fetch_class();
    $method = $ci->router->fetch_method();
    $currentUrl = base_url(uri_string());
    ?>
    <ul class="page-sidebar-menu page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
        <li class="sidebar-toggler-wrapper hide">
            <div class="sidebar-toggler"> </div>
        </li>
        <li class="nav-item start">
            <a href="<?php echo site_url('admin'); ?>" class="nav-link ">
                <i class="icon-bar-chart"></i>
                <span class="title" id='dashboard'>Dashboard</span>
                <span class="selected"></span>
            </a>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-industry"></i>
                <span class="title" id='agency'>Agency</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('admin/manage_agency/add'); ?>" class="nav-link">
                        <span class="title" id='add_agency'>Add Agency</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('admin/agencyindex'); ?>" class="nav-link ">
                        <span class="title" id='view_agency'>View Agencies</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-user"></i>
                <span class="title" id='agent'>Agent</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('admin/manage_agent/add'); ?>" class="nav-link ">
                        <span class="title" id='add_agent'>Add Agent</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('admin/agentindex'); ?>" class="nav-link ">
                        <span class="title" id='view_agent'>View Agents</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-building-o"></i>
                <span class="title" id='company'>Company</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('company/manage_company/add'); ?>" class="nav-link ">
                        <span class="title" id='add_company'>Add Company</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('company/manage_company/view'); ?>" class="nav-link ">
                        <span class="title" id='view_company'>View Companies</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-shopping-cart"></i>
                <span class="title" id='product'>Products</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('products/manage_products/add'); ?>" class="nav-link ">
                        <span class="title" id='add_product'>Add Product</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('products/manage_products/view'); ?>" class="nav-link ">
                        <span class="title" id='view_product'>View Products</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-building-o"></i>
                <span class="title" id='categories'>Categories</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('category/manage_category/add'); ?>" class="nav-link ">
                        <span class="title" id='add_category'>Add Category</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('category/manage_category/view'); ?>" class="nav-link ">
                        <span class="title" id='view_category'>View Categories</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-shopping-cart"></i>
                <span class="title" id='import_export_products'>Import/Export Products</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('importexportproducts/manage_products_csv/import'); ?>" class="nav-link ">
                        <span class="title" id='import_products'>Import Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('importexportproducts/manage_products_csv/export'); ?>" class="nav-link ">
                        <span class="title" id='exports_products'>Export Products</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id='lead'>
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-shopping-cart"></i>
                <span class="title"><?php echo 'CRM' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('adm/lead/index') ?>">
                        <span class="title" id="index_lead"><?php echo 'Lead' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('adm/lead/opportunities') ?>">
                        <span class="title" id="opportunity"><?php echo 'Opportunitie ' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('adm/lead/clients') ?>">
                        <span class="title" id="client"><?php echo 'Client' ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item" id="bid">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-camera"></i>
                <span class="title"><?php echo 'Campaign' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item campaign">
                    <a class="nav-link" href="<?php echo site_url('adm/campaign/index') ?>">
                        <span class="title"><?php echo 'Campaign' ?></span>
                    </a>
                </li>
                <li class="nav-item archive-campaign">
                    <a class="nav-link" href="<?php echo site_url('adm/campaign/archiveindex') ?>">
                        <span class="title"><?php echo 'Archive Campaign' ?></span>
                    </a>
                </li>
                <li class="nav-item campaign-type">
                    <a class="nav-link" href="<?php echo site_url('adm/vertical/index') ?>">
                        <span class="title"><?php echo 'Campaign Type' ?></span>
                    </a>
                </li>
                <li class="nav-item bid-type">
                    <a class="nav-link" href="<?php echo site_url('adm/bid/index') ?>">
                        <span class="title"><?php echo 'Bid Type' ?></span>
                    </a>
                </li>
                <li class="nav-item campaign-filters">
                    <a class="nav-link" href="<?php echo site_url('adm/filter/index') ?>">
                        <span class="title"><?php echo 'Filters' ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id='vendor'>
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-user"></i>
                <span class="title">Vendor</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item add_vendor">
                    <a href="<?php echo site_url('adm/vendor/edit'); ?>" class="nav-link ">
                        <span class="title">Add Vendor</span>
                    </a>
                </li>
                <li class="nav-item view_vendor">
                    <a href="<?php echo site_url('adm/vendor/index'); ?>" class="nav-link ">
                        <span class="title">View Vendor</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id="billing">
            <a href="javascript:;" class="nav-link nav-toggle" >
                <i class="icon-settings"></i>
                <span class="title" id='setting'>Billing</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('adm/billing/transaction'); ?>" class="nav-link">
                        <span class="title" id='tran'>Transaction</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item" id="setting">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title" id='setting'>Setting</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-settings"></i> Theme Options
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="<?php echo site_url('others/theme_options/add/logo'); ?>" class="nav-link">
                                <span class="title" id='logo'>Logo</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('others/theme_options/add/notifications_setting'); ?>" class="nav-link">
                                <span class="title" id='setting_notifications'>Notifications</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('others/theme_options/add/stripe_setting'); ?>" class="nav-link">
                        <i class="fa fa-cc-stripe"></i>
                        <span class="title" id="stripesetting">Stripe Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('others/theme_options/add/email_setting'); ?>" class="nav-link">
                        <i class="fa fa-envelope-o"></i>
                        <span class="title" id="emailsetting">Email Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('others/theme_options/add/plivo_setting'); ?>" class="nav-link">
                        <i class="fa fa-phone"></i>
                        <span class="title" id="plivosetting">Plivo Settings</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-bubble"></i>
                <span class="title" id='notifications'>Notifications</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-bubble"></i>
                        <span class="title" id='notifications_type'>Notification Type</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="<?php echo site_url('notifications/manage_notifications_type/add'); ?>" class="nav-link ">
                                <span class="title" id='add_notifications_type'>Add Notification Type</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('notifications/manage_notifications_type/view'); ?>" class="nav-link ">
                                <span class="title" id='view_notifications_type'>View Notification Type</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-bubble"></i>
                        <span class="title" id='notifications_message'>Notification Message</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="<?php echo site_url('notifications/manage_notifications_message/add'); ?>" class="nav-link ">
                                <span class="title" id='add_notifications_message'>Add Notification Message</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo site_url('notifications/manage_notifications_message/view'); ?>" class="nav-link ">
                                <span class="title" id='view_notifications_message'>View Notification Message</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="<?php echo site_url('email_send/email_send_function'); ?>" class="nav-link">
                <i class="fa fa-envelope-o"></i>
                <span class="title" id='mail_send'>Email Send</span>
            </a>
        </li>
        <li class="nav-item email_template">
            <a href="<?php echo site_url('adm/email_template'); ?>" class="nav-link">
                <i class="fa fa-envelope"></i>
                <span class="title" id='mail_send'>Manage Email Template</span>
            </a>
        </li>
        <li class="nav-item order_lead">
            <a href="<?php echo site_url('adm/order_lead/index'); ?>" class="nav-link">
                <i class="fa fa-shopping-cart"></i>
                <span class="title" id='order_lead'>Leads Order</span>
            </a>
        </li>
        <li class="nav-item order_lead">
            <a href="<?php echo site_url('adm/voicemails/index'); ?>" class="nav-link">
                <i class="fa fa-microphone"></i>
                <span class="title" id='order_lead'>Voice mail</span>
            </a>
        </li>
        <li class="nav-item order_lead">
            <a href="<?php echo site_url('adm/calllog/index'); ?>" class="nav-link">
                <i class="fa fa-list-alt"></i>
                <span class="title" id='order_lead'>Call Log</span>
            </a>
        </li>
        <li class="nav-item order_lead">
            <a href="<?php echo site_url('adm/smslog/index'); ?>" class="nav-link">
                <i class="fa fa-comments"></i>
                <span class="title" id='order_lead'>SMS Log</span>
            </a>
        </li>
        <li class="heading">
            <h3 class="uppercase"><?php echo "Dialer" ?></h3>
        </li>
        <li class="nav-item" id="report">
            <a class="nav-link nav-toggle" href="#">
                <i class="icon-docs"></i>
                <span class="title"><?php echo 'Reports' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/report/userstat') ?>">
                        <i></i>
                        <span class="title"><?php echo "Agent Stats" ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/report/realtime') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Real Time Report' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/report/outbound') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Outbound Calling Report' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/report/agent') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Agent Performance Detail' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/sreport/team') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Team Performance Detail' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/sreport/status') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Agent Status Detail' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/sreport/calls') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Export Calls Report' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/treport/inbound') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Inbound Report' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/treport/inbound?did=yes') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Inbound Report By DID' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/treport/recreport') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Recording Report' ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id="users">
            <a class="nav-link nav-toggle" href="#">
                <i class="icon-users"></i>
                <span class="title"><?php echo 'Users'; ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/users/index') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Show All Users' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/users/edit') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Add New User' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/users/agencyindex') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Show Agencies Users' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/users/agentindex') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Show Agents Users' ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id="campaign">
            <a class="nav-link nav-toggle ">
                <i class="icon-flag"></i>
                <span class="title"><?php echo 'Campaign Section' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item campaign">
                    <a class="nav-link nav-toggle" href="<?php echo site_url('dialer/campaign/index'); ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Campaign" ?></span>
                    </a>
                </li>
                <li class="nav-item status">
                    <a class="nav-link nav-toggle" href="<?php echo site_url('dialer/campaign/statusindex') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Statuses" ?></span>
                    </a>
                </li>
                <li class="nav-item auto-alt">
                    <a class="nav-link nav-toggle" href="<?php echo site_url('dialer/campaign/autoaltindex') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Auto-Alt Dial" ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php //if( (bool)get_dialer_option('outbound_autodial_active') == TRUE ) : ?>
        <li class="nav-item" id="lists">
            <a class="nav-link nav-toggle ">
                <i class="icon-list"></i>
                <span class="title"><?php echo 'Lists' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item list-index">
                    <a class="nav-link" data-ref="lists" href="<?php echo site_url('dialer/lists/index'); ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Show Lists" ?></span>
                    </a>
                </li>
                <li class="nav-item list-add">
                    <a class="nav-link" data-ref="lists" href="<?php echo site_url('dialer/lists/edit'); ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Add A New List" ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-ref="lists" href="<?php echo site_url('dialer/lists/searchlead') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Search For A Lead"; ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-ref="lists" href="<?php echo site_url('dialer/lists/addlead') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Add A New Lead"; ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-ref="lists" href="<?php echo site_url('dialer/lists/dncindex') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Add-Delete DNC Number"; ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-ref="lists" href="<?php echo site_url('dialer/lists/loadlead') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Load New Leads"; ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php //endif; ?>
        <li class="nav-item" id="filter">
            <a class="nav-link nav-toggle">
                <i class="fa fa-filter"></i>
                <span class="title"><?php echo "Filters" ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu" id="">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/filter/index') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo 'Show Filters' ?></span>
                    </a>
                </li>
                <li class="nav-item add-filter">
                    <a class="nav-link" href="<?php echo site_url('dialer/filter/edit') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo 'Add New Filter' ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id="inbound">
            <a class="nav-link nav-toggle">
                <i class="icon-call-in"></i>
                <span class="title"><?php echo 'Inbound' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu" id="in-group">
                <li class="nav-item nav-toggle" id="ingroup">
                    <a class="nav-link nav-toggle">
                        <i class=""></i>
                        <span class="title"><?php echo "In-Groups" ?></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('dialer/inbound/groupindex') ?>">
                                <span class="title"><?php echo "Show In-Groups" ?></span>
                            </a>
                        </li>
                        <li class="nav-item ingroup-edit">
                            <a class="nav-link" href="<?php echo site_url('dialer/inbound/groupedit') ?>">
                                <span class="title"><?php echo "Add New In-Group" ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-toggle" id="did">
                    <a class="nav-link nav-toggle">
                        <i class=""></i>
                        <span class="title"><?php echo 'DIDs' ?></span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('dialer/inbound/didindex') ?>">
                                <span class="title"><?php echo 'Show DIDs' ?></span>
                            </a>
                        </li>
                        <li class="nav-item did-edit">
                            <a class="nav-link" href="<?php echo site_url('dialer/inbound/didedit') ?>">
                                <span class="title"><?php echo 'Add New DID' ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--                 <li class="nav-item nav-toggle" id="call-menu">
                                    <a class="nav-link nav-toggle">
                                        <i class="icon-folder"></i>
                                        <span class="title"><?php echo 'Call Menus' ?></span>
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?php echo site_url('dialer/inbound/menuindex') ?>">
                                                <span class="title"><?php echo 'Show Call Menus' ?></span>
                                            </a>
                                        </li>
                                        <li class="nav-item menu-edit">
                                            <a class="nav-link" href="<?php echo site_url('dialer/inbound/menuedit') ?>">
                                                <span class="title"><?php echo 'Add New Call Menu' ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> -->
            </ul>
        </li>
        <li class="nav-item" id="remote">
            <a class="nav-link nav-toggle">
                <i class="icon-user"></i>
                <span class="title"><?php echo 'Remote Agents' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/remote/index') ?>">
                        <span class="title"><?php echo 'Show Remote Agents' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/remote/groupindex') ?>">
                        <span class="title"><?php echo 'Show Extension Group' ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id="group">
            <a class="nav-link nav-toggle">
                <i class="icon-user-follow"></i>
                <span class="title"><?php echo 'User Group' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/group/index'); ?>">
                        <i></i>
                        <span class="title"><?php echo 'Show User Group'; ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/group/edit'); ?>">
                        <i></i>
                        <span class="title"><?php echo 'Add New User Group'; ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li id="phones" class="nav-item">
            <a class="nav-link nav-toggle">
                <i class="fa fa-phone"></i>
                <span class="title"><?php echo 'Phones' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/phones/index') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Show all phone' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/phones/agencyindex') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Show Agency phone' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/phones/agentndex') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Show Agent phone' ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item voicemail audio">
            <a class="nav-link nav-toggle ">
                <i class="icon-settings"></i>
                <span class="title"><?php echo 'Setting' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item voicemail" >
                    <a class="nav-link" data-ref="voicemail" href="<?php echo site_url('dialer/voicemail/index'); ?>">
                        <i></i>
                        <span class="title"><?php echo "Voicemail" ?></span>
                    </a>
                </li>
                <li class="nav-item audio">
                    <a class="nav-link" href="<?php echo site_url('dialer/audio/index'); ?>">
                        <i></i>
                        <span class="title"><?php echo "Audio Store" ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li id="statuses" class="nav-item">
            <a href="" class="nav-link nav-toggle">
                <i class="fa fa-check"></i>
                <span class="title"><?php echo 'Statuses' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('dialer/statuses/index') ?>" class="nav-link">
                        <i></i>
                        <span><?php echo 'View' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('dialer/statuses/edit') ?>" class="nav-link">
                        <i></i>
                        <span><?php echo 'Add' ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li id="transfer" class="nav-item">
            <a href="<?php echo site_url('dialer/ltransfer/index') ?>" class="nav-link">
                <i class="fa fa-bullhorn"></i>
                <span><?php echo 'Transfer Lead' ?></span>
            </a>
        </li>
        <?php /*
          <li class="nav-item">
          <a href="<?php echo site_url('dialer'); ?>" class="nav-link">
          <i class="fa fa-headphones"></i>
          <span class="title" id='dialer'>Dialer System</span>
          </a>
          </li> */ ?>
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
<?php if ($menu == 'sreport'): ?>
    <?php $menu = 'report' ?>
<?php endif; ?>
<?php if ($menu == 'treport'): ?>
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