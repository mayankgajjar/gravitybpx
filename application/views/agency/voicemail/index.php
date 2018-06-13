<div class="breadcrumbs">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agency') ?>"><?php echo 'Home' ?></a></li>
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
        <!--<div class="actions">
            <a class="btn btn-info open-box" data-toggle="modal" href="#add-task" data-custom-value="task">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Add New Task"; ?></span>
            </a>
        </div> -->
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Agent Name </th>
                    <th> From </th>
                    <th> Created Date </th>
                    <th> Voicemail </th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    jQuery(function(){
        jQuery('#datatable').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url('age/voicemails/Agencyvoicemailjson'); ?>",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [0,4]
                }, {
                    "searchable": false,
                    "targets": [0,4]
                }],
            "order": [
                [3, "DESC"]
            ],

        });
    });
</script>
