<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/datatables.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="<?php echo site_url('assets/theam_assets/global/css/components-md.min.css'); ?>" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/css/plugins-md.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> Categories Listing</span>
        </div>  
        <div class="actions">
            <a href="<?php echo site_url('category/manage_category/add'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"> Add Category </span>
            </a>            
        </div>      
    </div>
    <div class="portlet-body">
        <form class="categories_from" action="<?php echo site_url('category/manage_category/multipledelete'); ?> " name="categories_form" method="post">        
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
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4" style="float:right">
                        <div class="table-group-actions pull-right">                                                            
                            <select name="massaction" class="table-group-action-input form-control input-inline input-small input-sm">
                                <option value="">Select...</option>                                
                                <option value="delete">Delete</option>
                            </select>
                            <button class="btn btn-sm btn-success table-group-action-submit">
                                <i class="fa fa-check"></i> Submit</button>                            
                        </div>
                    </div>                      
                </div>
            </div>                    
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /> 
                        </th>  
                        <th width="45%"> Category Name </th>
                        <th width="15%"> Is Active </th>                        
                        <th width="15%"> Actions </th>
                    </tr>
                </thead>
                <tbody>
                    <?php                        
                            foreach ($categories as $key => $value) 
                            {
                            ?>
                                <tr>      
                                    <td><input name="delete_ids[]" type="checkbox" class="checkboxes" value="<?php echo $value['id']; ?>" /></td>                                                          
                                    <td>
                                        <?php echo $value['category_name']; ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($value['is_active'] == 2)
                                            {
                                                echo "Disable";
                                            }
                                            else
                                            {
                                                echo "Enable";   
                                            }
                                        ?>
                                    </td>                                                                                            
                                    <td>                                    
                                        <a style="text-decoration: none !important;" href="<?php echo site_url('category/manage_category/edit/'.$value['id']); ?>">
                                            <i class="fa  fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>&nbsp;&nbsp;
                                        <a href="javascript:;" id="<?php echo $value['id'] ?>" title="Delete" class="delete">
                                            <span class="fa fa-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            } 
                    ?>                                                               
                </tbody>
            </table>
        </form>             
    </div>
</div>
                                        
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo site_url('assets/theam_assets/global/scripts/app.min.js'); ?>" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/scripts/datatable.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/datatables/datatables.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/table-datatables-managed.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<script type="text/javascript">
    $('document').ready(function(){
        $('#category').parents('li').addClass('open');
        $('#category').siblings('.arrow').addClass('open');
        $('#category').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#category'));
        $('#view_category').parents('li').addClass('active'); 

        $('.delete').click(function()
        {            
            id = $(this).attr('id');
            swal({
                title: "Are you sure?",
                text: "You are going to delete this category!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function(){
                var url = "<?php echo site_url('category/manage_category/delete'); ?>"
                $.ajax({
                    url : url,
                    success : function(status)
                    {
                        if(status)
                        {
                            swal({
                              title: "Deleted",
                              text: "Category has been deleted successfully",
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
    });
</script>       