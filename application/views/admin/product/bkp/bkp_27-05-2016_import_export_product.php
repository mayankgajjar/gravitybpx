<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/datatables.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
 <!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-summernote/summernote.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered import_product_csv">    
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-shopping-cart font-dark"></i>
            <span class="caption-subject bold uppercase">Upload Products CSV</span>
        </div>        
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">        
        <div class='alert alert-success'>
            CSV Data is successfully imported.
        </div>
        <div class="custom-alerts alert alert-danger fade in">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
            <i class="fa-lg fa fa-warning"></i>  CSV Data is not successfully imported.
        </div>                
        <form class="form-horizontal form-row-seperated" action="" enctype="multipart/form-data" name="products_csv_form" method="post" id="products_csv_form">
                <div class="form-group product_brochure">
                    <label class="col-md-3 control-label">Products Csv:
                        <span class="required"> * </span>
                    </label>                                                                        
                    <div class="col-md-9">                        
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail pdf-name" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                            <div>
                                <span class="btn red btn-outline btn-file">
                                    <span class="fileinput-new"> Upload Csv</span>
                                    <span class="fileinput-exists"> Change </span>
                                    <input type="file" name="products_csv">                                    
                                </span>
                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div> 
                        <span class="help-block"> Provide products csv (Uploaded document CSV)</span>                                                                                       
                    </div>
                </div>                
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-9">
                        <div class="actions btn-set">
                            <button type="reset" class="btn btn-secondary-outline">
                                <i class="fa fa-reply"></i> Reset
                            </button>                            
                            <button type="submit" name="submit" value="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> Save
                            </button>                            
                        </div>  
                    </div>                                                                                                      
                </div>
        </form>        
    </div>    
</div>
<div class="blockUI blockMsg blockElement" style="z-index: 1011; position: absolute; padding: 0px; margin: 0px; width: 30%; top: 389px; left: 493.5px; text-align: center; color: rgb(0, 0, 0); border: 0px none; cursor: default; display: none;">
    <div class="loading-message loading-message-boxed">
        <img src="<?php echo site_url('assets/theam_assets/global/img/loading-spinner-grey.gif'); ?>" align=""><span>&nbsp;&nbsp;Loading...</span>
    </div>
</div>
 <div class="row main_product_list">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Products List</span>
                </div>
                <div class="actions">                    
                </div>
            </div>
            <div class="portlet-body">                
                <table class="product_list table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th> Category </th>
                            <th> Product Name </th>
                            <th> Company </th>
                            <th> Product Level </th>
                            <th> Price </th>                            
                        </tr>
                    </thead>
                    <tbody>                                              
                        
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/raphael.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/jquery.usmap.js'); ?>" type="text/javascript"></script>
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
<!-- <script src="assets/theam_assets/pages/scripts/jquery.maskedinput.js" type="text/javascript"></script> -->
<!-- END PAGE LEVEL PLUGINS -->  
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo site_url('assets/theam_assets/global/scripts/app.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/table-datatables-managed.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery.input-ip-address-control-1.0.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/form-input-mask.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinputcsv.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-markdown/lib/markdown.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-summernote/summernote.min.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script type="text/javascript">
    $('document').ready(function()
    {            
        $('#import_export_products').parents('li').addClass('open');
        $('#import_export_products').siblings('.arrow').addClass('open');
        $('#import_export_products').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#import_export_products'));
        $('#import_products').parents('li').addClass('active');        
        $('#products_csv_form .btn.btn-secondary-outline').click(function(){
            $('.alert-success,.alert-danger,.main_product_list').hide();
        });
        $('.alert-success,.alert-danger,.main_product_list').hide();
        $('.blockElement').hide();
        $(document).ajaxStart(function() {
                $('.blockElement').show();
            }).ajaxStop(function() {
                $('.blockElement').hide();
        });
        var form = $('#products_csv_form');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({            
            doNotHideMessage: true,
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,                
            rules: {               
                "products_csv": {
                    required: true,
                },                                
            },       
            invalidHandler: function(event, validator) 
            {                                                                              
                success.hide();
                error.show();
                App.scrollTo(error, -200);
            },            
            highlight: function(element)
            {                 
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (element)
            {                            
                $(element).closest('.form-group').removeClass('has-error');                            
            },
            success: function(label)
            {                                                
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },        
            errorPlacement: function (error, element)
            {                
                if (element.attr("name") == "products_csv")
                {                   
                }
                else 
                {
                    error.insertAfter(element);
                }
            },        
            submitHandler: function(form)
            {                                         
                success.show();
                error.hide();                
                var url_link = '<?php echo site_url("importexportproducts/manage_products_csv/import/") ?>';                          
                var formData = new FormData($("#products_csv_form")[0]);

                $.ajax({
                    url : url_link,                    
                    type : 'post',
                    data : formData,
                    async : false,
                    cache: false,
                    contentType: false,                                                            
                    processData:false,                                                  
                    success : function(str)
                    {                                                                                                                                          
                        if(str != "")
                        {
                            $('.product_list tbody').html('');
                            $('.product_list tbody').html(str);
                            $('.main_product_list,.alert-success').show();
                            $(".product_list").dataTable();                            
                        }
                        else
                        {
                            $('.main_product_list,.alert-danger').hide();
                        }                                            
                    }
                });
                
            }
        });              
    });
</script>