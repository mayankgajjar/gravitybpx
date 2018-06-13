<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/swal/sweet-alert.css" rel="stylesheet" type="text/css" />
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
                <span>Add Company</span>
            </li>
        </ul>
        <div class="page-toolbar">           
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Add Company </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">    
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase">Add Company</span>
        </div>        
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal form-row-seperated" action="Admin/manage_company/add" enctype="multipart/form-data" name="product_form" method="post" id="company_form">            
            <div class="tabbable-bordered">               
                
                        <div class="form-body">
                            <?php
                                if(isset($company) && $company != "")
                                {                                    
                                    $company_id = $company->id;
                                    $company_name = $company->company_name;                                            
                                    $company_logo = $company->company_logo;                                            
                                }
                                else
                                {
                                    $company_id = "";
                                    $company_name = "";
                                    $company_logo = "";                                            
                                }
                            ?>
                            <input type="hidden" class="form-control" name="id" value="<?php echo $company_id; ?>" placeholder="">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Company Name:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="company_name" value="<?php echo $company_name; ?>" placeholder="">
                                    <span class="help-block"> Provide company name </span>
                                </div>                                        
                            </div>                                    
                            <div class="form-group product_brochure">
                                <label class="col-md-3 control-label">Company Logo:                                    
                                </label>                                                                        
                                <div class="col-md-9">                                   
                                    <div class="company_logo">
                                        <img src="uploads/company_logo/<?php echo $company_logo; ?>" class="img-responsive" alt="">
                                    </div>    
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
                                            <div>
                                                <span class="btn red btn-outline btn-file">
                                                    <span class="fileinput-new"> <?php if($company_logo != ""){ echo "Upload New Logo"; }else{ echo "Upload Logo"; } ?></span>
                                                    <span class="fileinput-exists">Change Logo</span>
                                                    <input type="file" name="company_logo">
                                                </span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>
                                    <span class="help-block"> Provide company logo</span>                                                                                       
                                </div>
                            </div>                                                                                        
                        </div>
                                            
                     <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="actions btn-set">
                                <?php if($company_id == "")
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
<script src="assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/plupload/js/plupload.full.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/swal/sweet-alert.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->        
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script type="text/javascript">
    $('document').ready(function(){
        $('#company').parents('li').addClass('open');
        $('#company').siblings('.arrow').addClass('open');
        $('#company').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#company'));
        $('#add_company').parents('li').addClass('active');

       

        $("#company_form").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            rules: {
                "company_name": {
                    required: true                            
                },
                "company_logo": {
                    required: false                                
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

            /*success: function (label) 
            {
                if (element.attr("name") == "pre_existing_conditions" || element.attr("name") == "product_brochure" || element.attr("name") == "product_state_id[]" || element.attr("name") == "age_from" || element.attr("name") == "age_to" || element.attr("name") == "height_feet_from" || element.attr("name") == "height_feet_to" || element.attr("name") == "height_inches_from" || element.attr("name") == "height_inches_to" || element.attr("name") == "weight_from" || element.attr("name") == "weight_to")
                {
                        label.closest('.form-group').removeClass('has-error');
                        label.remove(); // remove error label here
                }
                else
                { // display success icon for other inputs
                        label.closest('.form-group').removeClass('has-error');
                        label.remove();
                }
            },
*/
            errorPlacement: function (error, element)
            { 
               error.insertAfter(element); // for other inputs, just perform default behavior              
            },

            /*errorPlacement: function(error, element) {
               if (element.closest('.input-icon').size() === 1)
                {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },*/

            submitHandler: function(form) {
                 success.show();
                error.hide();
                form.submit();
            }
        });        
    });
</script>  