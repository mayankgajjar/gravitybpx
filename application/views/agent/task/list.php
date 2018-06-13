<style>
    .dataTables_wrapper table tbody tr td:last-child {
        width: 70px;
    }
</style>
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
        <div class="actions task-listing-dropdown">

            <a class="btn btn-info open-box" data-custom-value="task">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Add New Task"; ?></span>
            </a>
            <select class="form-control" onchange="javascript:taskstatus(this.value)">
                <option value="view-all">View All</option>
                <option value="received">Received Task</option>
                <option value="assign">Assign Task</option>
            </select>
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
            <thead>
                <tr>
                    <th><input type="checkbox" class="group-checkable" data-set="#datatable .checkboxes" /></th>
                    <th> Task Added By </th>
                    <th> Task  Date </th>
                    <th> Task Description </th>
                    <th> Task Start Time </th>
                    <th> Assigned Agent Name </th>
                    <th> Task Status </th>
                    <th> &nbsp; </th>
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
        jQuery('#datatable').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url('task/taskjson'); ?>",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [0, 7]
                }, {
                    "searchable": false,
                    "targets": [0, 7]
                }],
            "order": [
                [3, "DESC"]
            ]
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
    });
    function taskstatus(status){
        var table = $('#datatable').DataTable();
        table.destroy();
        jQuery('#datatable').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php base_url() ?>task/taskjson?status=" + status,
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
    }
    $( document ).ready(function() {
        $(document).on("click", ".view_task", function () {
            var task_id = $(this).data("custom-value");
            $.ajax({
                type: "POST",
                url: "<?php base_url() ?>task/view_task",
                data: {taskid: task_id},
                success: function (data) {
                    $('#view_task').html(data);
                },
            });
        });
    });

    $(document).on("click", ".task_done", function () {
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
                url: "<?php base_url() ?>task/done_task",
                data: {taskid: task_id},
                success: function (data) {
                    swal("success", data, "success");
                    var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                    $lmTable.fnDraw();
                }
            });
        });
    });
    
    function getdata(getform,e){
        e.preventDefault();
        if (jQuery('#task-form').valid()) {
            var frmarr = $(getform).serializeArray();
            $.ajax({
                method: "POST",
                url: '<?php echo  base_url('crm/create_save') ?>',
                data: frmarr,
                success: function (data) {
                    if(data== 'error'){
                        //location.reload();
                    } else {
                        $(location).attr('href', data);
                    }


                }
            });
        }
    }

</script>