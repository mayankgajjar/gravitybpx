<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/datatables.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">    
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase">Add Category</span>
        </div>        
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal form-row-seperated" action="<?php echo site_url('category/manage_category/add'); ?>" enctype="multipart/form-data" name="category_form" method="post" id="category_form">            
            <div class="tabbable-bordered">                               
                <div class="form-body">
                    <?php
                        if(isset($categories) && $categories != "")
                        {                                    
                            $category_id = $categories->id;
                            $category_name = $categories->category_name;                                            
                            $is_active = $categories->is_active;                                            
                        }
                        else
                        {
                            $category_id = "";
                            $category_name = ""; 
                            $is_active = "";
                        }
                    ?>
                    <input type="hidden" class="form-control" name="id" value="<?php echo $category_id; ?>" placeholder="">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Category Name:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="category_name" value="<?php echo $category_name; ?>" placeholder="">
                            <span class="help-block"> Provide category Name </span>
                        </div>                                        
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Status:
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            <select class="table-group-action-input form-control" name="is_active">
                                <option <?php if($is_active == ""){ echo "selected"; } ?> value="">Select Status</option>
                                <option <?php if($is_active == 1){ echo "selected"; }else{ echo ""; } ?> value="1">Enable</option>
                                <option <?php if($is_active == 2){ echo "selected"; }else{ echo ""; } ?> value="2">Disable</option>
                            </select>
                        </div>
                    </div>                                                                
                </div>                                        
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-9">
                        <div class="actions btn-set">
                            <?php if($category_id == "")
                            {
                            ?>                                        
                            <button type="reset" class="btn btn-secondary-outline">
                                <i class="fa fa-reply"></i> Reset
                            </button>
                            <?php
                            }
                            ?>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> Save
                            </button>
                            <!--<button class="btn btn-success">
                                <i class="fa fa-check-circle"></i> Save & Continue Edit
                            </button> -->
                        </div>  
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
<script src="<?php echo site_url('assets/theam_assets/global/scripts/datatable.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/datatables/datatables.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.pack.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/plupload/js/plupload.full.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->        
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script type="text/javascript">
    $('document').ready(function(){
        $('#category').parents('li').addClass('open');
        $('#category').siblings('.arrow').addClass('open');
        $('#category').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#category'));
        $('#view_category').parents('li').addClass('active');

        $("#category_form").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            rules: {
                "category_name": {
                    required: true                            
                },
                "is_active": {
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
               error.insertAfter(element); // for other inputs, just perform default behavior              
            },           
            submitHandler: function(form) {
                 success.show();
                error.hide();
                form.submit();
            }
        });        
    });
</script>  