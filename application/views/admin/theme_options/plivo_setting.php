<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css" /> -->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Plivo Setting</span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Plivo Setting </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa font-dark"></i>
            <span class="caption-subject bold uppercase">Plivo Setting</span>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <?php
        if ($this->session->flashdata()) {
            if ($this->session->flashdata('error') != "") {
                ?>
                <div class='alert alert-danger'>
                    <i class="fa-lg fa fa-warning"></i>
        <?php echo $this->session->flashdata('error'); ?>
                </div>
                    <?php
                } else {
                    ?>
                <div class='alert alert-success'>
                <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <?php
            }
        }
        ?>

        <form class="form-horizontal form-row-seperated" action="<?php echo site_url('others/theme_options/add/plivo_setting'); ?>" id="stripesetting_form" method="post">
        <?php
        if (!empty($plivo_setting_result)) {
            $plivo_setting_data = unserialize($plivo_setting_result['theme_options_values']);
            $id = $plivo_setting_result['id'];
            $plivo_auth_id = $plivo_setting_data['plivo_auth_id'];
            $plivo_auth_token = $plivo_setting_data['plivo_auth_token'];
        } else {
            $id = '';
            $plivo_auth_id = "";
            $plivo_auth_token = "";

        }
        ?>
            <input type="hidden" name="plivo_setting_id" value="<?php echo $id; ?>" />
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'AUTH ID'  ?><span class="required">*</span></label>
                    <div class="col-md-5">
                        <input class="form-control" type="password" name="plivo_auth_id" value="<?php echo $plivo_auth_id; ?>"/>
                        <span class="help-block"> <?php echo 'Plivo authentication ID' ?> </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'AUTH Token' ?><span class="required">*</span></label>
                    <div class="col-md-5">
                        <input class="form-control" type="password" name="plivo_auth_token" value="<?php echo $plivo_auth_token; ?>"/>
                        <span class="help-block"> <?php echo 'Plivo authentication Token' ?> </span>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="reset" class="btn btn-secondary-outline">
                            <i class="fa fa-reply"></i> Reset
                        </button>
                        <button class="btn green" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script type="text/javascript">
                        $('document').ready(function () {
                            $('#setting').addClass('open');
                            $('#setting').addClass('active');
                            $('#plivosetting').parents('li').addClass('active');

                            $("#stripesetting_form").validate({
                                errorElement: 'span',
                                errorClass: 'help-block help-block-error',
                                rules: {
                                    "plivo_auth_id": {
                                        required: true
                                    },
                                    "plivo_auth_token": {
                                        required: true
                                    }
                                },
                                invalidHandler: function (event, validator)
                                {
                                },
                                highlight: function (element) { // hightlight error inputs
                                    $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                                },
                                unhighlight: function (element)
                                {
                                    $(element).closest('.form-group').removeClass('has-error');
                                },
                                success: function (label) {
                                    label.closest('.form-group').removeClass('has-error');
                                    label.remove();
                                },
                                errorPlacement: function (error, element)
                                {
                                    error.insertAfter(element); // for other inputs, just perform default behavior
                                },
                                submitHandler: function (form) {
                                    success.show();
                                    error.hide();
                                    form.submit();
                                }
                            });
                        });
</script>