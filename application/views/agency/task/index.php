<div class="breadcrumbs">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo $label; ?>
        </li>
    </ol>
</div>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
        <div class="actions">
            <a class="btn btn-info open-box" data-toggle="modal" href="#add-task" data-custom-value="task">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Add New Task"; ?></span>
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
            <thead>
                <tr>
                    <th><input type="checkbox" class="group-checkable" data-set="#datatable .checkboxes" /></th>
                    <th> Added By </th>
                    <th> Assigned Agent </th>
                    <th> Task Description </th>
                    <th> Task  Date </th>
                    <th> Task Start Time </th>
                    <th> Task End Time </th>
                    <th> Task Status </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<!-- /.modal -->
<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
    <div id="view_task"></div>
</div>
<!-- /.modal -->

<!-- /Add new task modal -->
<div class="modal fade bs-modal-lg" id="add-task" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="html-data"></div>
</div>
<!-- /Add new task modal -->
<script type="text/javascript">
    jQuery(function () {
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
    });
    var table = $('#datatable').DataTable();
    table.destroy();
    jQuery('#datatable').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "<?php base_url() ?>age/tasks/taskjson",
        "columnDefs": [{
                'orderable': false,
                'targets': [0, 7]
            }, {
                "searchable": false,
                "targets": [0, 7]
            }],
        "order": [
            [0, "DESC"]
        ]
    });

    $(document).on("click", ".open-box", function () {
        var box_type = $(this).data("custom-value");
        $.ajax({
            method: "POST",
            url: '<?php echo base_url('age/tasks/get_popup_box') ?>',
            data: {boxtype: box_type},
            success: function (data) {
                $('.html-data').html(data);
            }
        });
    });
    function getdata(getform, e) {
        e.preventDefault();
        if (jQuery('#task-form').valid()) {
            var frmarr = $(getform).serializeArray();
            $.ajax({
                method: "POST",
                url: '<?php echo base_url('age/tasks/create_save') ?>',
                data: frmarr,
                success: function (data) {
                    console.log(data);
                    if (data == 'error') {
                        //location.reload();
                    } else {
                        $(location).attr('href', data);
                    }
                }
            });
        }
    }
    $(document).ready(function () {
        $(document).on("click", ".view_task", function () {
            var task_id = $(this).data("custom-value");
            $.ajax({
                type: "POST",
                url: "<?php base_url() ?>age/tasks/view_task",
                data: {taskid: task_id},
                success: function (data) {
                    $('#view_task').html(data);
                },
            });
        });
    });
    $(document).on("click", ".task_done", function () {
        event.preventDefault();
        var task_id = $(this).data("custom-value");
        swal({
            title: "Are you sure?",
            text: "Are you sure you have complete this task?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, complete it!",
            closeOnConfirm: false,
            html: false
        }, function () {
            $.ajax({
                method: "POST",
                url: "<?php base_url() ?>age/tasks/done_task",
                data: {taskid: task_id},
                success: function (data) {
                    swal("success", data, "success");
                    var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                    $lmTable.fnDraw();
                }
            });
        });
    });
    $(document).on("click", ".delete_task", function () {
        event.preventDefault();
        var task_id = $(this).data("custom-value");
        swal({
            title: "Are you sure?",
            text: "Are you sure you have Delete this task?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, complete it!",
            closeOnConfirm: false,
            html: false
        }, function () {
            $.ajax({
                method: "POST",
                url: "<?php base_url() ?>age/tasks/deleteTask",
                data: {taskid: task_id},
                success: function (data) {
                    swal("success", data, "success");
                    var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                    $lmTable.fnDraw();
                }
            });
        });
    });
</script>
<style>
    .nipl-lead-model {
        max-width: 700px;
    }
    .nipl-lead-model .portlet-body .form-body {
        max-width: 550px;
        margin: 0 auto;
    }
    .nipl-lead-model .portlet-body .form-body label {
        display: inline-block;
        width: 30%;
        float: left;
        font-size: 15px;
        margin-top: 7px;
    }
    .nipl-lead-model .portlet-body .form-body .form-group div.nipl_input_div{
        display: inline-block;
        width: 70%;
    }
    .btn.btn-outline.dark{
        color: #32c5d2;
        border-color: #32c5d2;
    }
    .btn.btn-outline.dark:hover{
        background: #32c5d2;
        color:#fff;
        border-color: #32c5d2;
    }
    .lead_input_div {
        display: inline-block;
        position: relative;
        width: 70%;
    }
</style>