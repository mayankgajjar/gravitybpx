<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $label; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title"><?php echo $maintitle; ?> </h3>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
        <div class="actions" style="margin-left: 20px">
            <a href="<?=base_url('ven/lead/lead_bulk_upload')?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Import Leads Via CSV"; ?></span>
            </a>
        </div>
        <div class="actions">
            <a href="<?php echo site_url('ven/lead/edit'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Add New Lead"; ?></span>
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <form class="categories_from" id="quickform" action="<?php echo site_url('ven/lead/massaction'); ?> " name="categories_form" method="post" onsubmit="javascript:submitform(event)">
            <?php if ($this->session->flashdata()) : ?>
                <?php if ($this->session->flashdata('error') != "") : ?>
                    <div class='alert alert-danger'>
                        <i class="fa-lg fa fa-warning"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php else : ?>
                    <div class='alert alert-success'>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4" style="float:right">
                        <div class="table-group-actions pull-right">
                            <select name="action" class="table-group-action-input form-control input-inline input-small input-sm">
                                <option value="">Select...</option>
                                <option value="del">Delete</option>
                            </select>
                            <button class="btn btn-sm btn-success table-group-action-submit">
                                <i class="fa fa-check"></i> Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="group-checkable" data-set="#datatable .checkboxes" />
                        </th>
                        <th> First Name</th>
                        <th> Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th> Action  </th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">
    jQuery(function () {
        jQuery('#vendor').addClass('open');
        jQuery('.view_vendor').addClass('active');
        jQuery('#datatable').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url('ven/lead/leadjson'); ?>",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [0, 5]
                }, {
                    "searchable": false,
                    "targets": [0, 5]
                }],
            "order": [
                [0, "DESC"]
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

        jQuery(document).on('click', '.delete', function (event) {
            event.preventDefault();
            var href = jQuery(this).attr('href');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                html: false
            }, function () {
                location.href = href;
            });
        });
    });
    function submitform(event) {

        var length = jQuery('.checkboxes:checked').length;
        if (length <= 0) {
            event.preventDefault();
            swal({
                title: "Error",
                text: "Please select atleast on record!",
                type: "error",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "",
                closeOnConfirm: true,
                html: false
            }, function () {
                event.preventDefault();
            });
        }
    }
    $('#leads').parents('li').addClass('open');
    $('#leads').siblings('.arrow').addClass('open');
    $('#leads').parents('li').addClass('active');
    $('#view_leads').parents('li').addClass('active');
</script>