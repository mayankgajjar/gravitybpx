<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <base href="<?php echo base_url(); ?>"/>
        <!-- favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo site_url() ?>uploads/logo/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php echo site_url() ?>uploads/logo/favicon/manifest.json">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,300,700" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/uniform/css/uniform.default.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo site_url('assets/theam_assets/global/css/components-md.min.css'); ?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/css/plugins-md.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->

        <?php /* <link href="<?php echo site_url('assets/theam_assets/layouts/layout/css/themes/grey.min.css'); ?>" rel="stylesheet" type="text/css" id="style_color" /> */ ?>

        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-toastr/toastr.min.css'); ?>" rel="stylesheet" type="text/css" />
        <?php //if (isset($datepicker) && $datepicker == TRUE): ?>
        <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <?php //endif; ?>
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.min.js'); ?>" type="text/javascript"></script>
        <?php if (isset($select2) && $select2 == TRUE): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/select2/css/select2.min.css' ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/select2/css/select2-bootstrap.min.css' ?>">
        <?php endif; ?>
        <?php if (isset($datatable) && $datatable == TRUE): ?>
            <link href="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/datatables/datatables.min.css'; ?>" rel="stylesheet" type="text/css" />
            <link href="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <?php //if(isset($sweetAlert) && $sweetAlert == TRUE): ?>
        <link href="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/swal/sweet-alert.css'; ?>" rel="stylesheet" type="text/css" />
        <?php //endif; ?>
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.min.js'); ?>" type="text/javascript"></script>
        <?php if (isset($datatable) && $datatable == TRUE): ?>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/scripts/datatable.js' ?>" type="text/javascript"></script>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/datatables/datatables.min.js'; ?>" type="text/javascript"></script>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'; ?>" type="text/javascript"></script>
        <?php endif; ?>
        <?php //if(isset($sweetAlert) && $sweetAlert == TRUE): ?>
        <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/swal/sweet-alert.js'; ?>" type="text/javascript"></script>
        <?php //endif; ?>
        <?php //if (isset($validation) && $validation == TRUE): ?>
        <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js'; ?>" type="text/javascript"></script>
        <?php //endif; ?>
        <?php //if (isset($datepicker) && $datepicker == TRUE): ?>
        <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'; ?>" type="text/javascript"></script>
        <?php //endif; ?>
        <?php if (isset($select2) && $select2 == TRUE): ?>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/select2/js/select2.full.min.js'; ?>" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($counterup) && $counterup == true): ?>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/counterup/jquery.waypoints.min.js'; ?>" type="text/javascript"></script>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/counterup/jquery.counterup.min.js'; ?>" type="text/javascript"></script>
        <?php endif; ?>
        <script src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
        <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/pages/css/customcss.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url() ?>assets/theam_assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/layouts/layout5/css/layout.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/layouts/layout5/css/custom.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/css/agentcustom.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url() ?>assets/css/dialer.css" rel="stylesheet" type="text/css" />
        <?php if (isset($dashabord) && $dashabord == TRUE) : ?>
            <link href="<?php echo site_url('assets/theam_assets/global/plugins/fullcalendar/fullcalendar.min.css'); ?>" rel="stylesheet" type="text/css" />
            <link href="<?php echo site_url('assets/theam_assets/global/plugins/jqvmap/jqvmap/jqvmap.css'); ?>" rel="stylesheet" type="text/css" />
            <script type="text/javascript" src="<?php echo site_url() ?>assets/theam_assets/global/plugins/moment.min.js"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($amcharts) && $amcharts == true): ?>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
        <?php endif; ?>
        <script type="text/javascript" src="<?php echo site_url() ?>assets/theam_assets/pages/scripts/jquery.countup.js"></script>
        <!--script type="text/javascript" src="https://www.doubango.org/sipml5/SIPml-api.js?svn=250"></script-->

        <?php if (isset($fancybox) && $fancybox == TRUE): ?>
            <link href="<?php echo site_url() ?>assets/theam_assets/global/css/jquery.fancybox.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo site_url() ?>assets/theam_assets/pages/scripts/jquery.fancybox.js" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($ckeditor) && $ckeditor == TRUE): ?>
            <script src="<?php echo site_url('assets/theam_assets/global/plugins/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($map['js'])): ?>
            <?php echo $map['js']; ?>
        <?php endif; ?>
        <?php if (isset($calendar) && $calendar == TRUE): ?>
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/moment.min.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <?php endif; ?>
        <?php //if (isset($colorpicker) && $colorpicker == TRUE): ?>
        <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
        <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>
        <script src="<?php echo site_url() ?>assets/theam_assets/pages/scripts/components-color-pickers.min.js" type="text/javascript"></script>
        <?php //endif; ?>

        <?php //if (isset($daterangepicker) && $daterangepicker == TRUE): ?>
        <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <!--script src="<?php echo site_url() ?>assets/theam_assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script> -->
        <?php //endif; ?>
        <?php if (isset($knockout) && $knockout == TRUE): ?>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/scripts/knockout-3.4.2.js" type="text/javascript"></script>
        <?php endif; ?>
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="wrapper">
            <header class="page-header">
                <nav class="navbar mega-menu" role="navigation">
                    <div class="container-fluid">
                        <div class="clearfix navbar-fixed-top">
                            <?php $this->load->view('templates/agent_header'); ?>
                        </div>
                        <div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse static">
                            <?php $this->load->view('templates/agent_sidebar'); ?>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="container-fluid">
                <div class="page-content">
                    <?php echo $body; ?>
                    <?php $this->load->view('dialer/phone/new-web.php') ?>
                </div>
                <p class="copyright"><?php echo date('Y') ?> &copy;
                    <a href="javascript:;" style="color:white;"><?php echo 'Gravity BPX' ?></a></p>
            </div>
        </div>
        <div class="modal fade" id="loading" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?php echo site_url() ?>/assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                        <span> &nbsp;&nbsp;Loading... </span>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('templates/live_agents') ?>
        <!--[if lt IE 9]>
<script src="assets/theam_assets/global/plugins/respond.min.js"></script>
<script src="assets/theam_assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/js.cookie.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.blockui.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/uniform/jquery.uniform.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo site_url('assets/theam_assets/global/scripts/app.min.js'); ?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo site_url('assets/theam_assets/layouts/layout5/scripts/layout.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/layouts/layout/scripts/demo.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/layouts/global/scripts/quick-sidebar.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-toastr/toastr.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/pages/scripts/ui-toastr.js') ?>" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script type="text/javascript">
            var plivoUsername = 'gravitybpx170615104909';
            var plivoPassword = 'narola21';
            var agent_type = '<?php echo $this->session->userdata("agent")->agent_type ?>';
            var liveAgentId = '<?php echo $this->session->userdata('liveagent')->liveagent ?>';
            var siteUrl = '<?php echo site_url(); ?>';
            var agentId = '<?php echo $this->session->userdata('agent')->id ?>';
            var phoneNumber = '<?php echo str_replace(array('(',')',' ','-'),'',$this->session->userdata('agent')->phone_number); ?>';
        </script>
        <script type="text/javascript" src="<?php echo site_url().'assets/js/main.js' ?>"></script>
        <script type="text/javascript" src="https://s3.amazonaws.com/plivosdk/web/plivo.min.js"></script>
        <script type="text/javascript" src="<?php echo site_url().'assets/js/dialer.js' ?>"></script>
    </body>
</html>
