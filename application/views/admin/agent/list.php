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
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
</div>
<?php endif; ?>
<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo $this->session->flashdata('error'); ?>
</div>
<?php endif; ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4" style="float:right">
<!--                     <div class="table-group-actions pull-right">
                        <select name="action" class="table-group-action-input form-control input-inline input-small input-sm">
                            <option value="">Select...</option>
                            <option value="del">Delete</option>
                        </select>
                        <button class="btn btn-sm btn-success table-group-action-submit">
                            <i class="fa fa-check"></i> Submit</button>
                    </div> -->
                </div>
            </div>
        </div>
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
            <thead>
                <tr>
                    <th>&nbsp;<?php echo '#' ?>&nbsp;</th>
                    <th><?php echo "First Name"; ?></th>
                    <th><?php echo "Last Name"; ?></th>
                    <th><?php echo "Email"; ?></th>
                    <th><?php echo "Phone"; ?></th>
                    <th><?php echo "Agent Type"; ?></th>
                    <th><?php echo "Parent Agency"; ?></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        jQuery(function(){
            jQuery(document).on('click', '.plivo', function(){
                var agentId = jQuery(this).attr('data-agent');
                var postData = {
                    is_ajax : true,
                };
                jQuery.ajax({
                    url : '<?php echo site_url("adm/agent/create_endpoint") ?>/'+agentId,
                    method : 'post',
                    dataType : 'json',
                    data : postData,
                    success : function(result){
                        var flag = Boolean(result.success);
                        if(flag){
                            var html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>&nbsp;'+result.msg+'</div>'
                            jQuery('.page-title').after(html);
                            location.reload();
                        }
                    }
                });
            });
            jQuery('#view_agent').parent('a').parent('li').addClass('active');
            jQuery('#view_agent').parent('a').parent('li').parent('ul').parent('li').addClass('active');
            jQuery('#datatable').dataTable({
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo site_url('admin/agentindexjson'); ?>",
                "columnDefs": [ {
                    'orderable': false,
                    'targets': [0,7]
                },{
                    "searchable": false,
                    "targets": [0,7]
                }],
                "order": [[0, "DESC"]]
            });
            jQuery('#datatable').find('.group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).prop("checked", true);
                        $(this).parents('tr').addClass("active");
                    } else {
                        $(this).prop("checked", false);
                        $(this).parents('tr').removeClass("active");
                    }
                });
                jQuery.uniform.update(set);
            });
            jQuery('#datatable').on('change', 'tbody tr .checkboxes', function () {
                $(this).parents('tr').toggleClass("active");
            });
        jQuery(document).on('click', '.delete', function(event){
            event.preventDefault();
            id = $(this).attr('href');
            swal({
                title: "Are you sure?",
                text: "You are going to delete this Agent Record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function(isConfirm){
                if(isConfirm){
                    jQuery.ajax({
                        url : id,
                        type : 'GET',
                        success : function(status){
                            if(status){
                                swal({
                                    title: "Deleted",
                                    text: "Agent has been deleted successfully",
                                    showConfirmButton: false
                                });
                                location.reload();
                            }else{
                                swal('Failed!','There is some problem in delete, please try again.','error');
                            }
                        }
                    });
                }
            });
        });
     });
    </script>
</div>
