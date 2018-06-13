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
            <a href="<?php echo site_url('agency'); ?>" class="nav-link ">
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
                    <a href="<?php echo site_url('agency/agencyedit'); ?>" class="nav-link ">
                        <span class="title" id='add_agency'>Add Sub-Agency</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('agency/agencyindex') ?>" class="nav-link ">
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
                    <a href="<?php echo site_url('agency/agentedit'); ?>" class="nav-link ">
                        <span class="title" id='add_agent'>Add Agent</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo site_url('agency/agentindex/'); ?>" class="nav-link ">
                        <span class="title" id='view_agent'>View Agents</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-user"></i>
                <span class="title" id='customer'>Customer</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="<?php echo site_url('customer/manage_customer/view'); ?>" class="nav-link ">
                        <span class="title" id='view_customer'>View Customers</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--  <li class="nav-item" id='vendor'>
             <a href="javascript:;" class="nav-link nav-toggle">
                 <i class="icon-user"></i>
                 <span class="title">Vendor</span>
                 <span class="arrow"></span>
             </a>
             <ul class="sub-menu">
                 <li class="nav-item add_vendor">
                     <a href="<?php echo site_url('age/vendor/edit'); ?>" class="nav-link ">
                         <span class="title">Add Vendor</span>
                     </a>
                 </li>
                 <li class="nav-item view_vendor">
                     <a href="<?php echo site_url('age/vendor/index/'); ?>" class="nav-link ">
                         <span class="title">View Vendor</span>
                     </a>
                 </li>
             </ul>
         </li> -->
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-shopping-cart"></i>
                <span class="title" id='leadstore'><?php echo 'CRM' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('age/lead/index') ?>">
                        <span class="title" id="lead"><?php echo 'Lead' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('age/lead/opportunities') ?>">
                        <span class="title" id="opportunity"><?php echo 'Opportunitie ' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('age/lead/clients') ?>">
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
                    <a class="nav-link" href="<?php echo site_url('age/campaign/index') ?>">
                        <span class="title"><?php echo 'Campaign' ?></span>
                    </a>
                </li>
                <li class="nav-item archive-campaign">
                    <a class="nav-link" href="<?php echo site_url('age/campaign/archiveindex') ?>">
                        <span class="title"><?php echo 'Archive Campaign' ?></span>
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
                    <a href="<?php echo site_url('age/billing/transaction'); ?>" class="nav-link">
                        <span class="title" id='tran'>Transaction</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="<?php echo site_url('email_send/email_send_function'); ?>" class="nav-link">
                <i class="fa fa-envelope-o"></i>
                <span class="title" id='mail_send'>Email Send</span>
            </a>
        </li>
        <li class="nav-item order_lead">
            <a href="<?php echo site_url('age/order_lead/index'); ?>" class="nav-link">
                <i class="fa fa-shopping-cart"></i>
                <span class="title" id='order_lead'>Leads Order</span>
            </a>
        </li>
        <li class="nav-item order_lead">
            <a href="<?php echo site_url('age/tasks/index'); ?>" class="nav-link">
                <i class="fa fa-tasks"></i>
                <span class="title" id='order_lead'>Tasks</span>
            </a>
        </li>
        <li class="nav-item order_lead">
            <a href="<?php echo site_url('age/voicemails/index'); ?>" class="nav-link">
                <i class="fa fa-microphone"></i>
                <span class="title" id='order_lead'>Voice mail</span>
            </a>
        </li>
        <li class="nav-item order_lead">
            <a href="<?php echo site_url('age/calllog/index'); ?>" class="nav-link">
                <i class="fa fa-list-alt"></i>
                <span class="title" id='order_lead'>Call Log</span>
            </a>
        </li>
        <li class="nav-item order_lead">
            <a href="<?php echo site_url('age/smslog/index'); ?>" class="nav-link">
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
        <li class="nav-item" id="acampaign">
            <a class="nav-link nav-toggle ">
                <i class="icon-flag"></i>
                <span class="title"><?php echo 'Campaign Section' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item campaign">
                    <a class="nav-link nav-toggle" href="<?php echo site_url('dialer/acampaign/index'); ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Campaign" ?></span>
                    </a>
                </li>
                <li class="nav-item status">
                    <a class="nav-link nav-toggle" href="<?php echo site_url('dialer/acampaign/statusindex') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Statuses" ?></span>
                    </a>
                </li>
                <li class="nav-item auto-alt">
                    <a class="nav-link nav-toggle" href="<?php echo site_url('dialer/acampaign/autoaltindex') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Auto-Alt Dial" ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id="alists">
            <a class="nav-link nav-toggle ">
                <i class="icon-list"></i>
                <span class="title"><?php echo 'Lists' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item list-index">
                    <a class="nav-link" data-ref="alists" href="<?php echo site_url('dialer/alists/index') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Show Lists" ?></span>
                    </a>
                </li>
                <li class="nav-item list-add">
                    <a class="nav-link" data-ref="alists" href="<?php echo site_url('dialer/alists/edit') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Add A New List" ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-ref="alists" href="<?php echo site_url('dialer/alists/searchlead') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Search For A Lead"; ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-ref="alists" href="<?php echo site_url('dialer/alists/addlead') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Add A New Lead"; ?></span>
                    </a>
                </li>
                <!--                <li class="nav-item">
                                    <a class="nav-link" data-ref="alists" href="#">
                                        <i class="icon-settings"></i>
                                        <span class="title"><?php echo "Add-Delete DNC Number"; ?></span>
                                    </a>
                                </li>-->
                <li class="nav-item">
                    <a class="nav-link" data-ref="alists" href="<?php echo site_url('dialer/alists/loadlead') ?>">
                        <i class=""></i>
                        <span class="title"><?php echo "Load New Leads"; ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id="afilter">
            <a class="nav-link nav-toggle">
                <i class="fa fa-filter"></i>
                <span class="title"><?php echo "Filters" ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu" id="">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/afilter/index') ?>">
                        <i class="icon-settings"></i>
                        <span class="title"><?php echo 'Show Filters' ?></span>
                    </a>
                </li>
                <li class="nav-item add-filter">
                    <a class="nav-link" href="<?php echo site_url('dialer/afilter/edit') ?>">
                        <i class="icon-settings"></i>
                        <span class="title"><?php echo 'Add New Filter' ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id="ainbound">
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
                            <a class="nav-link" href="<?php echo site_url('dialer/ainbound/groupindex') ?>">
                                <span class="title"><?php echo "Show In-Groups" ?></span>
                            </a>
                        </li>
                        <li class="nav-item ingroup-edit">
                            <a class="nav-link" href="<?php echo site_url('dialer/ainbound/groupedit') ?>">
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
                            <a class="nav-link" href="<?php echo site_url('dialer/ainbound/didindex') ?>">
                                <span class="title"><?php echo 'Show DIDs' ?></span>
                            </a>
                        </li>
                        <li class="nav-item did-edit">
                            <a class="nav-link" href="<?php echo site_url('dialer/ainbound/didedit') ?>">
                                <span class="title"><?php echo 'Add New DID' ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php /* <li class="nav-item nav-toggle" id="call-menu">
                  <a class="nav-link nav-toggle">
                  <i class="icon-folder"></i>
                  <span class="title"><?php echo 'Call Menus' ?></span>
                  <span class="arrow"></span>
                  </a>
                  <ul class="sub-menu">
                  <li class="nav-item">
                  <a class="nav-link" href="<?php echo site_url('dialer/ainbound/menuindex') ?>">
                  <span class="title"><?php echo 'Show Call Menus' ?></span>
                  </a>
                  </li>
                  <li class="nav-item menu-edit">
                  <a class="nav-link" href="<?php echo site_url('dialer/ainbound/menuedit') ?>">
                  <span class="title"><?php echo 'Add New Call Menu' ?></span>
                  </a>
                  </li>
                  </ul>
                  </li> */ ?>
            </ul>
        </li>
        <li class="nav-item" id="aremote">
            <a class="nav-link nav-toggle">
                <i class="icon-user"></i>
                <span class="title"><?php echo 'Remote Agents' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/aremote/index') ?>">
                        <span class="title"><?php echo 'Show Remote Agents' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/aremote/groupindex') ?>">
                        <span class="title"><?php echo 'Show Extension Group' ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id="ausers">
            <a class="nav-link nav-toggle ">
                <i class="icon-users"></i>
                <span class="title"><?php echo 'User Section' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-link agency">
                    <a class="nav-link" href="<?php echo site_url('dialer/ausers/agencyusers') ?>">
                        <i class="icon-settings"></i>
                        <span class="title"><?php echo 'Agencies' ?></span>
                    </a>
                </li>
                <li class="nav-link agent">
                    <a class="nav-link" href="<?php echo site_url('dialer/ausers/agenctusers') ?>">
                        <i class="icon-settings"></i>
                        <span class="title"><?php echo 'Agents' ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item" id="agroup">
            <a class="nav-link nav-toggle">
                <i class="icon-user-follow"></i>
                <span class="title"><?php echo 'Agent Groups' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/agroup/index') ?>">
                        <span class="title"><?php echo 'Groups' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/agroup/edit') ?>">
                        <span class="title"><?php echo 'Add New Group' ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li id="aphones" class="nav-item">
            <a class="nav-link nav-toggle">
                <i class="fa fa-phone"></i>
                <span class="title"><?php echo 'Phones' ?></span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/aphones/agencyindex') ?>">
                        <i></i>
                        <span class="title"><?php echo 'Show Agency phone' ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('dialer/aphones/agentndex') ?>">
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
                    <a class="nav-link" data-ref="voicemail" href="<?php echo site_url('dialer/avoicemail/index'); ?>">
                        <i></i>
                        <span class="title"><?php echo "Voicemail" ?></span>
                    </a>
                </li>
                <li class="nav-item audio">
                    <a class="nav-link" href="<?php echo site_url('dialer/aaudio/index'); ?>">
                        <i></i>
                        <span class="title"><?php echo "Audio Store" ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li id="transfer" class="nav-item">
            <a href="<?php echo site_url('dialer/ltransfer/index') ?>" class="nav-link">
                <i class="fa fa-bullhorn"></i>
                <span class="title"><?php echo "Transfer Lead" ?></span>
            </a>
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