<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Add Category</span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Add Category </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
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
                    if (isset($categories) && $categories != "") {
                        $category_id = $categories->id;
                        $category_name = $categories->category_name;
                        $is_active = $categories->is_active;
                    } else {
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
                                <option <?php if ($is_active == "") {
                        echo "selected";
                    } ?> value="">Select Status</option>
                                <option <?php if ($is_active == 1) {
                        echo "selected";
                    } else {
                        echo "";
                    } ?> value="1">Enable</option>
                                <option <?php if ($is_active == 2) {
                        echo "selected";
                    } else {
                        echo "";
                    } ?> value="2">Disable</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-9">
                        <div class="actions btn-set">
                            <?php
                            if ($category_id == "") {
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
<script type="text/javascript">
    $('document').ready(function () {
        $('#category').parents('li').addClass('open');
        $('#category').siblings('.arrow').addClass('open');
        $('#category').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#category'));
        $('#view_category').parent('a').parent('li').parent('ul').parent('li').addClass('active');

        $("#category_form").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            rules: {
                "category_name": {
                    required: true
                },
                "is_active": {
                    required: true
                }
            },
            invalidHandler: function (event, validator)
            {
            },
            highlight: function (element) { // hightlight error inputs
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
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element)
            {
                error.insertAfter(element); // for other inputs, just perform default behavior
            },
            submitHandler: function (form) {
                success.show();
                error.hide();
                form.submit();
            }
        });
    });
</script>