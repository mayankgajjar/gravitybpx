<style>
    .dataTables_length{display: none}
</style>
<div class="breadcrumbs">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo 'Dialer' ?>
        </li>
    </ol>
</div>

<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered video-screen">
            <div class="portlet-body">
                <div class="video-call">
                    <button><i class="fa fa-play" aria-hidden="true"></i></button>
                    <h2>Start video Call</h2>
                </div>
                <div class="screen-share">
                    <button><i class="fa fa-desktop" aria-hidden="true"></i></button>
                    <h2>Start Screen Share</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark"><?php echo 'Scripts' ?></span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="javascript:;" class="btn green btn-sm" aria-expanded="true">
                            <?php echo 'Select Script' ?>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="javascript:;"> Pending
                                    <span class="badge badge-danger"> 4 </span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;"> Completed
                                    <span class="badge badge-success"> 12 </span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;"> Overdue
                                    <span class="badge badge-warning"> 9 </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="portlet-body scripts">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce viverra vitae nulla non sodales. Curabitur consequat nunc vel velit posuere finibus. Donec auctor interdum vulputate. Maecenas id risus hendrerit, placerat nulla tincidunt, tristique sem. Vivamus mattis turpis in tortor iaculis, non facilisis nulla dictum. Praesent eu justo non neque fringilla laoreet. Integer luctus ultrices luctus. Nulla facilisi. Sed auctor vehicula sapien ac dapibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut eget pulvinar mi. Mauris aliquet, justo sed elementum blandit, arcu felis congue dolor, at porttitor justo ligula vitae augue. Ut maximus tincidunt nulla, at auctor diam pretium non. Duis ut semper purus.
                </p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce viverra vitae nulla non sodales. Curabitur consequat nunc vel velit posuere finibus. Donec auctor interdum vulputate. Maecenas id risus hendrerit, placerat nulla tincidunt, tristique sem. Vivamus mattis turpis in tortor iaculis, non facilisis nulla dictum. Praesent eu justo non neque fringilla laoreet.
                </p>
                <div class="buttons-actions">
                    <button class="btn green">BACK</button>
                    <button class="btn green">NEXT</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-green-sharp">
                        <span data-counter="counterup" data-value="<?php echo $totalInbound; ?>">0</span>
                    </h3>
                    <small><?php echo 'TOTAL INBOUND CALLS' ?></small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: 76%;" class="progress-bar progress-bar-success green-sharp">
                        <span class="sr-only">76% progress</span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title"> GOAL </div>
                    <div class="status-number"> 76% </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-red-haze">
                        <span data-counter="counterup" data-value="<?php echo $totalOutbound; ?>">0</span>
                    </h3>
                    <small><?php echo 'TOTAL OUTBOUND CALLS' ?></small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: 85%;" class="progress-bar progress-bar-success red-haze">
                        <span class="sr-only">85% change</span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title"> GOAL </div>
                    <div class="status-number"> 85% </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-blue-sharp">
                        <span data-counter="counterup" data-value="11">0</span>
                    </h3>
                    <small><?php echo 'TOTAL SALES' ?></small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: 45%;" class="progress-bar progress-bar-success blue-sharp">
                        <span class="sr-only">45% grow</span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title"> GOAL </div>
                    <div class="status-number"> 45% </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 bordered">
            <div class="display">
                <div class="number">
                    <h3 class="font-purple-soft">
                        <span data-counter="counterup" data-value="136">0</span>
                    </h3>
                    <small><?php echo 'TOTAL REMAINING LEADS' ?></small>
                </div>
                <div class="icon">
                    <i class="icon-pie-chart"></i>
                </div>
            </div>
            <div class="progress-info">
                <div class="progress">
                    <span style="width: 57%;" class="progress-bar progress-bar-success purple-soft">
                        <span class="sr-only">56% change</span>
                    </span>
                </div>
                <div class="status">
                    <div class="status-title"> GOAL </div>
                    <div class="status-number"> 57% </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark"><?php echo 'Recent Calls' ?></span>
                </div>
                <div class="actions">

                </div>
            </div>
            <div class="portlet-body">
                <div class="mt-actions">
                    <?php foreach ($callLogs as $callog): ?>
                        <div class="mt-action">
                            <div class="mt-action-img">
                                <img width="40" src="<?php echo site_url() ?>uploads/agents/users.jpg">
                            </div>
                            <div class="mt-action-body">
                                <div class="mt-action-row">
                                    <div class="mt-action-info ">
                                        <div class="mt-action-icon ">
                                            <i aria-hidden="true" class="<?php echo($callog['type'] == 'outbound') ? 'icon-call-out' : 'icon-call-in' ?>"></i>
                                        </div>
                                        <div class="mt-action-details ">
                                            <span class="mt-action-author"><?php echo $callog['first_name'] . ' ' . $callog['last_name'] ?></span>
                                            <p class="mt-action-desc"><?php echo $callog['phone'] ?></p>

                                        </div>
                                    </div>
                                    <div class="mt-action-buttons ">
                                        <div class="btn-group">
                                            <a class="a-tooltip callAction" data-call-value="<?= $callog['phone']; ?>"><i class="icon-call-out"></i></a>
                                            <a class="a-tooltip sms_lead" href="javasceipt:;" data-placement="bottom" title="Message" href="javasceipt:;" style="font-size: 12px;" data-target="#smsbox" data-toggle="modal" data-lead-id='<?php echo encode_url($callog['lead_id']); ?>' ><i class="fa fa-2x fa-comments-o"></i></a>
                                            <a class="a-tooltip" href="<?php echo site_url('lead/emailpopup/' . encode_url($callog['lead_id'])) ?>" data-target="#ajaxemail" title="Email Message" data-toggle="modal"><i class="icon-envelope"></i></a>
                                            <a class="a-tooltip" data-placement="bottom" href="<?php echo site_url('lead/filepopup/' . encode_url($callog['lead_id'])) ?>" data-target="#ajax" title="File Upload" data-toggle="modal"><i class="  icon-paper-clip"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark"><?php echo 'Tasks:' ?></span>
                </div>
                <div class="actions">

                    <div class="btn-group">
                        <a class="btn red btn-sm btn-info open-box" data-custom-value="task">
                            <i class="fa fa-plus"></i>
                            <span class="hidden-xs"><?php echo "Add Task"; ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="mt-actions tasks">
                    <div class="mt-action">
                        <div class="mt-action-body">
                            <div class="mt-action-row">
                                <div class="mt-action-info">
                                    <div class="task-dial">
                                        <div class="portlet-body">
                                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> Task Description </th>
                                                        <th> Task Date </th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="smsbox" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="sms-text-box">
                <div class="modal-body">
                    <img src="<?php echo site_url() ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                    <span> &nbsp;&nbsp;Loading... </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajaxemail" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo site_url() ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo site_url() ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).on("click", ".sms_lead", function (event) {
        var checkIDS = [];
        var idsJson = [];
        var ID = $(this).attr("data-lead-id");
        checkIDS.push({
            'send': ID
        });
        idsJson = JSON.stringify(checkIDS);
        jQuery.ajax({
            url: '<?= site_url('lead/sendSMS/') ?>',
            method: 'post',
            data: {idsJson: idsJson, reload: 'false'},
            success: function (result) {
                jQuery(".sms-text-box").html(result);
            }
        });
    });
    jQuery(document).on("click", ".callAction", function (event) {
        var phoneNumber = jQuery(this).attr("data-call-value");
        jQuery('#phone_num').val(phoneNumber);
        jQuery('.dialer-icon').trigger('mouseover');
        console.log(phoneNumber);
        $("#callBtn").trigger("click");
    });

    jQuery(function () {
        jQuery('#datatable').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url('task/dialertaskjson'); ?>",
             "columnDefs": [{
                    'orderable': false,
                    'targets': [0 , 1]
                }, {
                    "searchable": false,
                    "targets": [0 , 1]
                }],
            "order": [
                [2, "DESC"]
            ]
        });

    });
</script>
