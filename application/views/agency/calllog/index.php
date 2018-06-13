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
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Agent Name </th>
                    <th> Member ID </th>
                    <th> Mobile Number </th>
                    <th> Call Start Time </th>
                    <th> Call End Time </th>
                    <th> Call Duration (seconds) </th>
                    <th> Call Type </th>
                    <th> Call Recording </th>
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
            "sAjaxSource": "<?php echo site_url('age/calllog/AgencyCalllogJson'); ?>",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [0 , 8]
                }, {
                    "searchable": false,
                    "targets": [0 , 8]
                }],
            "order": [
                [4, "DESC"]
            ],

        });
    });
</script>
