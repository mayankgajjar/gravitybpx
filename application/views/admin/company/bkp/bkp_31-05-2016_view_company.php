<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="assets/theam_assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="assets/theam_assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="assets/theam_assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/swal/sweet-alert.css" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN PAGE HEADER-->   
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="<?php echo site_url(); ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>View Companies</span>
            </li>
        </ul>
        <div class="page-toolbar">           
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> View Companies </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> Company Listing</span>
        </div>  
        <div class="actions">
            <a href="<?php echo site_url('company/manage_company/add') ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"> Add Company </span>
            </a>            
        </div>      
    </div>
    <div class="portlet-body"> 
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
       
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /> 
                    </th>  
                    <th width="25%"> Company Name </th>
                    <th width="35%"> Company Logo </th>                        
                    <th width="15%"> Actions </th>
                </tr>
            </thead>
            <tbody>
                <?php                        
                        foreach ($company as $key => $value) 
                        {
                        ?>
                            <tr>      
                                <td><input type="checkbox" class="checkboxes" value="<?php echo $value['id']; ?>" /></td>                                                          
                                <td>
                                    <?php echo $value['company_name']; ?>
                                </td>
                                <td>
                                    <img src="uploads/company_logo/<?php echo $value['company_logo']; ?>" width="200px" height="100px" />
                                </td>                                                                                            
                                <td>                                    
                                    <a style="text-decoration: none !important;" href="admin/manage_company/edit/<?php echo $value['id']; ?>">
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
    </div>
</div>
                                        
<!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="assets/theam_assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/theam_assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="assets/theam_assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/swal/sweet-alert.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<script type="text/javascript">
    $('document').ready(function(){
        $('#company').parents('li').addClass('open');
        $('#company').siblings('.arrow').addClass('open');
        $('#company').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#company'));
        $('#view_company').parents('li').addClass('active'); 

        $('.delete').click(function()
        {            
            id = $(this).attr('id');
            swal({
                title: "Are you sure?",
                text: "You are going to delete this company!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url : 'Admin/manage_company/delete/'+id,
                    success : function(status){
                        if(status)
                        {
                            swal({
                              title: "Deleted",
                              text: "Company has been deleted successfully",
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