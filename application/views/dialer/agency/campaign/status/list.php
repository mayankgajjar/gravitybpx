<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $title; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title"><?php echo $title; ?> </h3>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <form class="categories_from" action="<?php echo site_url(''); ?> " name="categories_form" method="post">
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

                    </div>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                <thead>
                    <tr>
                        <th id="first"><?php echo "Campaign ID"; ?></th>
                        <th><?php echo "Campaign Name"; ?></th>
                        <th><?php echo "Statuses"; ?></th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </form>
    </div>
</div>

<script type="text/javascript">
    $('document').ready(function(){
        jQuery('#datatable').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo site_url('dialer/acampaign/indexJson/status'); ?>",
                "columnDefs": [ {
                    'orderable': false,
                    'targets': [0,3]
                },{
                    "searchable": false,
                    "targets": [0,3]
                }],
                "order": [
                        [0, "DESC"]
                    ]
            });
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
<style>
#first {width: auto !important;}
</style>