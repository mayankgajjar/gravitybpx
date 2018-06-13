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
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/moment.min.js'); ?>" type="text/javascript"></script>
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
        <?php if (isset($audiojs) && $audiojs == TRUE): ?>
            <script src="<?php echo site_url() ?>assets/phone/audiojs/audio.min.js" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($email) && $email == TRUE): ?>
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo site_url() ?>assets/theam_assets/apps/css/inbox.min.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo site_url() ?>assets/theam_assets/apps/scripts/inbox.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/apps/scripts/inbox.min.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/jquery.fileupload-audio.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/jquery.fileupload-video.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript"></script>
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
                <a class="go2top" href="#index" style="display: inline;">
                    <i class="icon-arrow-up"></i>
                </a>
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
        <!--<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
            <div class = "html-data"></div>
        </div> -->
        <!-- /Add new task modal -->
        <div class="modal fade bs-modal-lg" id="add-task" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="html-data"></div>
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
<?php if ($this->session->userdata('user')->id == 116): ?>
                var plivoUsername = 'brandon170622050331';
                var plivoPassword = 'narola21';
<?php elseif ($this->session->userdata('user')->id == 67): ?>
                var plivoUsername = 'clayton170622050411';
                var plivoPassword = 'narola21';
<?php elseif ($this->session->userdata('user')->id == 118): ?>
                var plivoUsername = 'davidpaul170622055813';
                var plivoPassword = 'narola21';
<?php else: ?>
                var plivoUsername = 'gravitybpx170615104909';
                var plivoPassword = 'narola21';
<?php endif; ?>
            var agent_type = '<?php echo $this->session->userdata("agent")->agent_type ?>';
            var liveAgentId = '<?php echo $this->session->userdata('liveagent')->liveagent ?>';
            var siteUrl = '<?php echo site_url(); ?>';
            var agentId = '<?php echo $this->session->userdata('agent')->id ?>';
            var phoneNumber = '<?php echo ($this->session->userdata('agent')->plivo_phone != '') ? str_replace(array('(', ')', ' ', '-'), '', $this->session->userdata('agent')->plivo_phone) : '5597951559'; ?>';
        </script>
        <script type="text/javascript" src="<?php echo site_url() . 'assets/js/main.js' ?>"></script>
        <script type="text/javascript" src="https://s3.amazonaws.com/plivosdk/web/plivo.min.js"></script>
        <script type="text/javascript" src="<?php echo site_url() . 'assets/js/dialer.js' ?>"></script>
        <script type="text/javascript" src="<?php echo site_url() . 'assets/js/common.js' ?>"></script>
        <?php sessionTimer();
        check_user_login(); ?>
        <script src="<?php echo base_url('assets/theam_assets/global/scripts/knockout-3.4.2.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('node_modules/socket.io-client/dist/socket.io.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url() . 'assets/js/kodatabind.js' ?>"></script>
        <script type="text/javascript">
            var MyAgentViewModel = {
                notification: ko.observableArray([]),
                userstatus: ko.observableArray([]),
<?php if (isset($email) && $email == TRUE): ?>
                    oFolders: ko.observableArray([]),
                    allsendmail: ko.observableArray([]),
                    oMessageList: ko.observableArray([]),
                    oMailBox: ko.observable('INBOX'),
                    totalMessage: ko.observable(),
                    index: ko.observable(),
                    oMailBoxActual: ko.observable('INBOX'),
                    spinner: '<tr id="tr-spinner"><td colspan="4" style="text-align:center;"><img src="' + siteUrl + 'assets/images/loading-spinner-blue.gif"></td></tr>',
                    getNextSet: function () {
                        var currentIndex = this.index();
                        var nextIndex = currentIndex;
                        //getMessageListJson(this.oMailBoxActual(), nextIndex);
                        var url = encodeURI("email/getMessageJson?folder=" + this.oMailBoxActual() + "&offset=" + nextIndex);
                        jQuery('#email-list').append(this.spinner);
                        jQuery('html, body').animate({
                            scrollTop: jQuery("#tr-spinner").offset().top
                        }, 2000);
                        jQuery.getJSON(url, function (data) {
                            MyAgentViewModel.totalMessage(data.total);
                            MyAgentViewModel.index(data.count);
                            jQuery.map(data.messages, function (value) {
                                MyAgentViewModel.oMessageList.push(new messageList(value));
                            });
                            jQuery("#tr-spinner").remove();
                        });
                    },
                    composeAction: function () {
                        jQuery('#loading').modal('show');
                        jQuery('#email-list-table').hide();
                        $.ajax({
                            url: siteUrl + 'email/compose_mail',
                            success: function (data) {
                                $('#loading').modal('hide');
                                $('#email-content').show();
                                $('#email-content').html(data);
                                $('.header-title').html('Compose');

                            }
                        });
                    },
<?php endif; ?>
            };
            var chatModel = {
                chat: ko.observableArray([]),
            }
            ko.applyBindings(MyAgentViewModel);
            var socket = io.connect('http://' + window.location.hostname + ':3000');
            var user_id = <?= $this->session->userdata('user')->id ?>;
            var agency_id = <?= $this->session->userdata('agent')->agency_id ?>;

            function fetch_chat_data() {
                if ($('.dialer-chatbox-wrapper').css('display') != 'none' && $('.chatbox-screen').css('display') != 'none') {
                    var phonenumber = jQuery('#phone_num').val();
                    var postData = {
                        phone: '1' + phonenumber,
                        agent: agentId
                    };
                    socket.emit('getChatData', {post_Data: postData});
                }
            }

            function check_new_messages() {
                var phoneArray = [];
                $(".chat-head").each(function (key, index) {
                    var phone_no = $(this).data('phone');
                    phoneArray.push('1' + phone_no);
                });
                if (phoneArray.length > 0) {
                    socket.emit('getNewMsg', {phone_Data: phoneArray, agentid: agentId});
                }
            }

            $(document).ready(function () {

                setInterval(function () {
                    socket.emit('getData', {userid: user_id, agencyid: agency_id});
                    // socket.emit('getcountnoti', { userid: user_id });
                }, 3000);

                setInterval(function () {
                    fetch_chat_data();
                    check_new_messages();
                }, 6000);

                setInterval(function () {
                    socket.emit('getPushNotification', {userid: user_id, agencyid: agency_id, agentid: agentId});
                }, 60000);

                socket.on('new_notification', function (data) {
                    jQuery('.notifications1').html('');
                    jQuery.map(JSON.parse(data), function (value) {
                        MyAgentViewModel.notification.push(new getNotification(value.status, value.log_id, value.title, value.log_type, value.created));
                    });
                });
                socket.on('count_notification', function (data) {
                    jQuery('.user_notification').html(data[0].total_notification);
                });
                socket.on('get_agent_status', function (data) {
                    jQuery('.side-userstatus').html('');
                    jQuery.map(JSON.parse(data), function (value) {
                        MyAgentViewModel.userstatus.push(new getUserStatus(value));
                    });

                });
                socket.on('new_message', function (data) {
                    jQuery.map(JSON.parse(data), function (value) {
                        $('.phone-' + value).addClass('unseen_msg');
                    });

                });
                socket.on('chat_text', function (data) {

                    /* For Check Scroll*/
                    var scroll = '';
                    if ($('.chat_ul.scroller').scrollTop() + $('.chat_ul.scroller').innerHeight() >= $('.chat_ul.scroller')[0].scrollHeight) {
                        scroll = 'true';
                    }
                    /* /For Check Scroll*/

                    jQuery('.chat_ul').html('');
                    var chat_data = JSON.parse(data);

                    jQuery.map(chat_data.sms_data, function (value) {
                        value.agent_image = chat_data.agent_image;
                        value.lead_image = chat_data.lead_image;
                        chatModel.chat.push(new getUserChat(value));
                    });

                    /* For Bottom Scroll*/
                    if (scroll) {
                        var bottomCoord = jQuery('.chat_ul.scroller')[0].scrollHeight;
                        jQuery('.chat_ul.scroller').slimScroll({scrollTo: bottomCoord});
                    }
                    /* /For Bottom Scroll*/

                });
                socket.on('get_task_notification', function (data) {
                    if (data.length > 1) {
                        $.each(JSON.parse(data), function (key, val) {
                            notifymetask(val.task_description);
                        });
                    }
                });
                socket.on('get_event_notification', function (data) {
                    if (data.length > 1) {
                        $.each(JSON.parse(data), function (key, val) {
                            notifyme(val.event_desc);
                        });
                    }
                });
            });
        </script>
        <?php if (isset($email) && $email == TRUE): ?>
            <script type="text/javascript" src="<?php echo site_url() . 'assets/js/email-client.js' ?>"></script>
<?php endif; ?>
        <script type="text/javascript" src="<?php echo site_url() . 'assets/js/sms.js' ?>"></script>
    </body>
</html>
