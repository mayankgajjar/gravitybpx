<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/datatables.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="<?php echo site_url('assets/theam_assets/global/css/components-md.min.css'); ?>" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/css/plugins-md.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
                        
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-shopping-cart font-dark"></i>
            <span class="caption-subject bold uppercase">Products Listing</span>
        </div>
        <div class="actions">
            <a href="<?php echo site_url('products/manage_products/add'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"> New Product </span>
            </a>            
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body table-scrollable">
        <div class="">
            <div class="table-container product_table">
                <div class="table-actions-wrapper">                
                    <span> </span>
                    <select class="table-group-action-input form-control input-inline input-small input-sm">
                        <option value="">Select...</option>
                        <option value="1">Published</option>
                        <option value="2">Not Published</option>
                        <!--<option value="delete">Delete</option>-->
                    </select>
                    <button class="btn btn-sm btn-success table-group-action-submit">
                        <i class="fa fa-check"></i> Submit</button>
                </div>
                <?php 
                    if($this->session->flashdata())
                    {
                        ?>
                        <div class='alert alert-success'>
                            <?php echo $this->session->flashdata('msg'); ?>
                        </div>
                        <?php
                    }
                    ?>
                <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_products">
                    <thead>
                        <tr role="row" class="heading">
                            <th width="1%">
                                <input type="checkbox" class="group-checkable"> </th>
                            <th width="5%"> ID </th>
                            <th width="15%"> Category </th>
                            <th width="15%"> Product&nbsp;Name </th>
                            <th width="15%"> Company </th>
                            <th width="15%"> Product Levels </th>
                            <th width="20%"> Price </th>                        
                            <th width="15%"> Age </th>                        
                            <th width="15%"> Status </th>
                            <th width="5%"> Actions </th>
                        </tr>
                        <tr role="row" class="filter">
                            <td> </td>                        
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="product_id">
                            </td>
                            <td>
                                <select name="product_category" class="form-control  form-filter input-sm">
                                    <option value="">Select Category</option>
                                    <?php                                                        
                                        foreach ($categories as $value) 
                                        {
                                        ?>
                                            <option value="<?php echo $value['id'] ?>">
                                                <?php echo $value['category_name'] ?>
                                            </option>
                                        <?php
                                        }
                                   
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="product_name">
                            </td>
                            <td>                            
                                <input type="text" class="form-control form-filter input-sm" name="product_company">
                            </td>
                            <td>                            
                                <input type="text" class="form-control form-filter input-sm" name="product_levels">
                            </td>                         
                            <td>
                                <div class="margin-bottom-5">
                                    <input type="text" class="form-control form-filter input-sm" name="product_price_from" placeholder="From" /> </div>
                                    <input type="text" class="form-control form-filter input-sm" name="product_price_to" placeholder="To" /> 
                            </td>                        
                            <td>
                                <div class="margin-bottom-5">
                                    <input type="text" class="form-control form-filter input-sm" name="product_age_from" placeholder="From" /> </div>
                                    <input type="text" class="form-control form-filter input-sm" name="product_age_to" placeholder="To" /> 
                            </td>                                          
                            <td>
                                <select name="product_status" class="form-control form-filter input-sm">
                                    <option value="">Select...</option>
                                    <option value="1">Published</option>
                                    <option value="2">Not Published</option>                                
                                </select>
                            </td>
                            <td>
                                <div class="margin-bottom-5">
                                    <button class="btn btn-sm btn-success filter-submit margin-bottom">
                                        <i class="fa fa-search"></i> Search</button>
                                </div>
                                <button class="btn btn-sm btn-default filter-cancel">
                                    <i class="fa fa-times"></i> Reset</button>
                            </td>
                        </tr>
                    </thead>
                    <tbody>                                                  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->


<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/scripts/datatable.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/datatables/datatables.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/fancybox/source/jquery.fancybox.pack.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/ecommerce-products.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
    $('document').ready(function(){
        $('#products').parents('li').addClass('open');
        $('#products').siblings('.arrow').addClass('open');
        $('#products').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#products'));
        $('#view_product').parents('li').addClass('active');        
    });
    $(document).on('click','.delete',function ()    
    {           
            id = $(this).attr('id');
            swal({
                title: "Are you sure?",
                text: "You are going to delete this Product!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function(){
                var url = "<?php echo  site_url('products/manage_products/delete');?>"+'/'+id;
                $.ajax({
                    url : url,
                    success : function(status){
                        if(status)
                        {
                            swal({
                              title: "Deleted",
                              text: "Product has been deleted successfully",
                              showConfirmButton: false
                            });
                            location.reload();
                        }
                        else
                        {
                            swal('Failed!','There is some problem in delete, please try again.','error');
                        }
                    }
                });
            });
        });
</script>       