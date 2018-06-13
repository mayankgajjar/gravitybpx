<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login Page</title>
        <base href="<?php echo base_url(); ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- favicon -->
<!--        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-57x57.png">
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
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-16x16.png">-->
        <link rel="manifest" href="<?php echo site_url() ?>uploads/logo/favicon/manifest.json">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/uniform/css/uniform.default.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/select2/css/select2-bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo site_url('assets/theam_assets/global/css/components-md.min.css'); ?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/css/plugins-md.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo site_url('assets/theam_assets/pages/css/login.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/dropzone/dropzone.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/dropzone/basic.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <link rel="shortcut icon" href="favicon.ico" />
        <script type="text/javascript">
            var error_show_agency = 0;
            var error_show_agent = 0;
        </script>
        <?php
        if ($this->session->flashdata('error_server_register_agency') != "") {
            ?>
            <script type="text/javascript">
                var error_show_agency = 1;
            </script>
            <?php
        }
        ?>
        <?php
        if ($this->session->flashdata('error_server_register_agent') != "") {
            ?>
            <script type="text/javascript">
                var error_show_agent = 1;
            </script>
            <?php
        }
        ?>
    </head>
</html>