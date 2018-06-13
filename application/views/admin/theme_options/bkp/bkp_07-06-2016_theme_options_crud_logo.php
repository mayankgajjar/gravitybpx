<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS --> 
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<!-- BEGIN PAGE HEADER-->   
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="<?php echo site_url(); ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Logo</span>
            </li>
        </ul>
        <div class="page-toolbar">           
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Logo </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
<div class="portlet light bordered import_product_csv">    
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="icon-settings font-dark"></i>
            <span class="caption-subject bold uppercase">Site Logo</span>
        </div>        
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <?php 
            if($this->session->flashdata())
            {
                if($this->session->flashdata('error') != "")
                {
                ?>
                    <div class='alert alert-danger'>
                        <i class="fa-lg fa fa-warning"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php    
                }
                else
                {                    
                ?>
                    <div class='alert alert-success'>
                        <?php echo $this->session->flashdata('msg'); ?>
                    </div>
                <?php
                }
            }
        ?>                             
        <form class="form-horizontal form-row-seperated" action="<?php echo site_url('others/theme_options/add/logo'); ?>" enctype="multipart/form-data" name="theme_options" method="post" id="theme_options1">
                <?php
                    /*echo '<pre>';
                    print_r($logo_data);*/
                    if(!empty($logo_data))
                    {
                        $id = $logo_data['id'];
                        $logo_image = $logo_data['theme_options_values'];
                    }
                    else
                    {
                        $id = "";
                        $logo_image = "";   
                    }
                ?>
                <input type="hidden" name="theme_options_logo_id" value="<?php echo $id; ?>"/>
                <div class="form-group product_brochure">
                    <label class="col-md-3 control-label">Logo:
                        <span class="required"> * </span>
                    </label>                                                                        
                    <div class="col-md-9">
                        <?php
                            if($logo_image != "")
                            {
                        ?>      
                                <div class="image_site_logo">
                                    <img src="<?php echo site_url().'uploads/logo/'.$logo_image; ?>" />
                                </div>
                        <?php        
                            }
                        ?>                        
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail logo-name" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                            <div>
                                <span class="btn red btn-outline btn-file">
                                    <span class="fileinput-new"> Upload Logo</span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" name="site_logo" value="<?php echo $logo_image; ?>">                                    
                                </span>
                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div> 
                        <span class="help-block"> Provide site logo</span>                                                                                       
                    </div>
                </div>                
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-9">
                        <div class="actions btn-set">
                            <button type="reset" class="btn btn-secondary-outline">
                                <i class="fa fa-reply"></i> Reset
                            </button>                            
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> Save
                            </button>                            
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
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.pack.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/plupload/js/plupload.full.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script type="text/javascript">
    $('document').ready(function()
    {            
        $('#setting').parents('li').addClass('open');
        $('#setting').siblings('.arrow').addClass('open');
        $('#setting').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#setting'));
        $('#theme_options').parents('li').addClass('active');        
        $('#logo').parents('li').addClass('active');        
                    
        $("#theme_options1").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            rules: {
                "site_logo": {
                    required: true                            
                }
            },          
            invalidHandler: function(event, validator) 
            {             
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element)
            {
                 // revert the change done by hightlight                 
                    $(element)
                        .closest('.form-group').removeClass('has-error');
                    // set error class to the control group
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element)
            { 
               if (element.attr("name") == "site_logo")
                {                   
                }
                else 
                {
                    error.insertAfter(element);
                }             
            },           
            submitHandler: function(form) {
                 success.show();
                error.hide();
                form.submit();
            }
        });               
    });
</script>