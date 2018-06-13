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
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
            <thead>
                <tr>
                    <th> # </th>
                    <th> From </th>
                    <th> Created </th>
                    <th> &nbsp; </th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    jQuery(function(){
        jQuery('#dialpadd').addClass('open');
        jQuery('#datatable').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url('dial/voicemailjson'); ?>",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [0,1,2,3]
                }, {
                    "searchable": false,
                    "targets": [0,1,2,3]
                }],
            "order": [
                [3, "DESC"]
            ],

        });
    });
</script>