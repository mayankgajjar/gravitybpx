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
        <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
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
        <link href="<?php echo site_url('assets/theam_assets/layouts/layout/css/layout.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/layouts/layout/css/themes/grey.min.css'); ?>" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo site_url('assets/theam_assets/layouts/layout/css/custom.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/css/agencycustom.css'); ?>" rel="stylesheet" type="text/css" />
        <?php if (isset($select2) && $select2 == TRUE): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/select2/css/select2.min.css' ?>">
            <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/select2/css/select2-bootstrap.min.css' ?>">
        <?php endif; ?>
        <?php if (isset($datatable) && $datatable == TRUE): ?>
            <link href="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/datatables/datatables.min.css'; ?>" rel="stylesheet" type="text/css" />
            <link href="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'; ?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <?php if (isset($sweetAlert) && $sweetAlert == TRUE): ?>
            <link href="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/swal/sweet-alert.css'; ?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <?php if (isset($colorpicker) && $colorpicker == TRUE): ?>
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <?php if (isset($datepicker) && $datepicker == TRUE): ?>
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
        <script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.min.js'); ?>" type="text/javascript"></script>
        <?php if (isset($datatable) && $datatable == TRUE): ?>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/scripts/datatable.js' ?>" type="text/javascript"></script>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/datatables/datatables.min.js'; ?>" type="text/javascript"></script>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'; ?>" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($sweetAlert) && $sweetAlert == TRUE): ?>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/swal/sweet-alert.js'; ?>" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($validation) && $validation == TRUE): ?>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js'; ?>" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($datepicker) && $datepicker == TRUE): ?>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'; ?>" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($select2) && $select2 == TRUE): ?>
            <script src="<?php echo $this->config->item('base_url') . 'assets/theam_assets/global/plugins/select2/js/select2.full.min.js'; ?>" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($colorpicker) && $colorpicker == TRUE): ?>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($audiojs) && $audiojs == TRUE): ?>
            <script type="text/javascript" src="<?php echo site_url() ?>assets/phone/audiojs/audio.min.js"></script>
        <?php endif; ?>
        <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
        <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/pages/css/customcss.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url() ?>assets/theam_assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
<!--        <script type="text/javascript" src="<?php echo site_url() ?>assets/theam_assets/pages/scripts/jquery.countup.js"></script>
        <script type="text/javascript" src="https://www.doubango.org/sipml5/SIPml-api.js?svn=250"></script>-->
        <?php if (isset($fancybox) && $fancybox == TRUE): ?>
            <link href="<?php echo site_url() ?>assets/theam_assets/global/css/jquery.fancybox.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo site_url() ?>assets/theam_assets/pages/scripts/jquery.fancybox.js" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($ckeditor) && $ckeditor == TRUE): ?>
            <script src="<?php echo site_url('assets/theam_assets/global/plugins/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($calendar) && $calendar == TRUE): ?>
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/moment.min.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <?php endif; ?>
        <?php if (isset($daterangepicker) && $daterangepicker == TRUE): ?>
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
            <script src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
            <!--script src="<?php echo site_url() ?>assets/theam_assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script> -->
        <?php endif; ?>
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <?php $this->load->view('templates/agency_header'); ?>
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <?php $this->load->view('templates/agency_sidebar'); ?>
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <?php
                    echo $body;
                    ?>
                    <?php //$this->load->view('dialer/phone/web') ?>
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
                <!-- END CONTENT BODY -->
            </div>
            
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
                <?php $this->load->view('templates/agency_agentlist') ?>
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner"> <?php echo date('Y') ?> &copy;
                <a href="javascript:;" style="color:white;"><?php echo 'Gravity BPX' ?></a>
            </div>
            <div class="scroll-to-top">
                <i class="icon-arrow-up"></i>
            </div>
        </div>
        <!-- END FOOTER -->
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
        <script src="<?php echo site_url('assets/theam_assets/layouts/layout/scripts/layout.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/layouts/layout/scripts/demo.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/theam_assets/layouts/global/scripts/quick-sidebar.min.js'); ?>" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

    <script>
        jQuery(function () {
            jQuery("li.active .arrow").addClass("open");
        });
       /*---------------- Desktop Notification For task --------------- */

        setInterval(function () {
            var msg = "";
            $.ajax({
                url: '<?php echo base_url() ?>agency/check_task_notification',
                datatype: 'json',
                success: function (data) {
                    $.each(JSON.parse(data), function (key, val) {
                        if (data != "") {
                            notifymetask(val.task_description);
                        }
                    });
                },
            });
        }, 60000);
        function notifymetask(msg) {
            if (Notification.permission === "granted") {

                ///var notification = new Notification(msg);
                var notification = new Notification('Task Reminder', {
                    icon: '<?= base_url() ?>assets/images/color_logo.png',
                    body: msg,
                });
                //mycallSession.onclose = function () { mycallSession = null; };
                //mycallSession.show();
            } else if (Notification.permission !== 'denied') {
                Notification.requestPermission(function (permission) {
                    // If the user accepts, let's create a notification
                    if (permission === "granted") {
                        var notification = new Notification("Incoming call from 1234");
                    }
                });
            }
        }
        /*---------------- End Desktop Notification For task --------------- */
    </script>
</html>