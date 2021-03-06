<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>View Categories</span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> View Categories </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->

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
            <?php if ($this->session->flashdata())  : ?>
                <?php if ($this->session->flashdata('error') != "") : ?>
                    <div class='alert alert-danger'>
                        <i class="fa-lg fa fa-warning"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php else : ?>
                    <div class='alert alert-success'>
                        <?php echo $this->session->flashdata('msg'); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
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
                    <?php foreach ($categories as $key => $value) : ?>
                        <tr>
                            <td><input name="delete_ids[]" type="checkbox" class="checkboxes" value="<?php echo $value['id']; ?>" /></td>
                            <td><?php echo $value['category_name']; ?></td>
                            <td>
                                <?php if ($value['is_active'] == 2) : ?>
                                    <?php echo "Disable"; ?>
                                <?php else : ?>
                                    <?php echo "Enable"; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a style="text-decoration: none !important;" href="<?php echo site_url('category/manage_category/edit/' . $value['id']); ?>">
                                    <i class="fa  fa-pencil-square-o" aria-hidden="true"></i>
                                </a>&nbsp;&nbsp;
                                <a href="javascript:;" id="<?php echo $value['id'] ?>" title="Delete" class="delete">
                                    <span class="fa fa-trash"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('document').ready(function () {
        jQuery('#sample_1').dataTable({
            "columnDefs": [{// set default column settings
                    'orderable': false,
                    'targets': [0, 3]
                }, {
                    "searchable": false,
                    "targets": [0, 3]
                }],
            "order": [
                [1, "asc"]
            ]
        });
        var tableWrapper = jQuery('#sample_1');
        jQuery('#sample_1').find('.group-checkable').change(function () {
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
        jQuery('#sample_1').on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
        });
        $('#category').parents('li').addClass('open');
        $('#category').siblings('.arrow').addClass('open');
        $('#category').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#category'));
        $('#view_category').parents('li').addClass('active');

        $('.delete').click(function ()
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
            function () {
                var url = "<?php echo site_url('category/manage_category/delete'); ?>"
                $.ajax({
                    url: url,
                    success: function (status)
                    {
                        if (status)
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
                            swal('Failed!', 'There is some problem in delete, please try again.', 'error');
                        }
                    }
                });
            });
        });
    });
</script>