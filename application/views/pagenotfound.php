<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

<link href="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />

<link href="<?php echo $this->config->item('base_url') ?>assets/theam_assets/pages/css/error.min.css" rel="stylesheet" type="text/css" />
</head>
<body class=" page-404-full-page">
<div class="row">
    <div class="col-md-12 page-404">
        <div class="number font-red"> 404 </div>
        <div class="details">
            <h3>Oops! You're lost.</h3>
            <p> We can not find the page you're looking for.
                <br/>
                <a href="<?php echo site_url() ?>"> Return home </a> or try the search bar below. </p>
        </div>
    </div>
</div>

<script src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/scripts/app.min.js" type="text/javascript"></script>    
</body>
</html>