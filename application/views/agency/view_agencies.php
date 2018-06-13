<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/datatables.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE HEADER-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>View Agencies</span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> View Agencies </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-industry font-dark"></i>
            <span class="caption-subject bold uppercase">Agencies</span>
        </div>
        <div class="actions">
            <a href="<?php echo site_url('agency/agencyedit'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"> Add Agency </span>
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <?php if ($this->session->flashdata('msg')): ?>
            <div class='alert alert-success'>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php endif; ?>
        <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Owner</th>
                    <th>Phone</th>
                    <th>Parent Agency</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($agencies as $agency) {
                    ?>
                    <tr>
                        <td><?php echo $agency['name'] ?></td>
                        <td><?php echo $agency['email_id'] ?></td>
                        <td><?php echo $agency['fname'] . ' ' . $agency['lname'] ?></td>
                        <td><?php echo $agency['phone_number'] ?></td>
                        <td><?php
                if ($agency['parent_agency'] != 0) {
                    echo $agency['parent_name'];
                } else {
                    echo 'No Parent';
                }
                    ?>
                        </td>
                        <td>
                            <a class="info" title="Information" id="<?php echo $agency['id'] ?>" href="<?php echo site_url('agency/manage_agency/agency_info/' . $agency['id']); ?>">
                                <span class="fa fa-info"></span>
                            </a>&nbsp;&nbsp;
                            <a class="info" title="Edit" style="text-decoration:none;" id="<?php echo encode_url($agency['id']) ?>" href="<?php echo site_url('agency/agencyedit/' . encode_url($agency['id'])) ?>">
                                <span class="fa  fa-pencil-square-o"></span>
                            </a>&nbsp;&nbsp;
                            <a class="delete" title="Delete" id="<?php echo encode_url($agency['id']) ?>" href="javascript:;">
                                <span class="fa fa-trash"></span>
                            </a>&nbsp;&nbsp;
                            <?php $id = $agency['vicidial_user_id'] ?>
                            <?php if($id > 0): ?>
                                <?php $user = $this->vusers_m->get_by(array('user_id' => $id), TRUE); ?>
                                <?php if($user): ?>
                                    <a target="_blank" href="<?php echo site_url('dialer/ausers/edit/'.  encode_url($id)) ?>"><?php echo 'Dialer User' ?></a>
                                    <?php $phone = $this->aphones_m->get_by(array('vicidial_user_id' => $id), TRUE);?>
                                    <?php if(!$phone): ?>
                                        <a href="<?php echo site_url('dialer/aphones/createphone/'.$id) ?>"><?php echo 'Create Phone' ?></a>
                                    <?php endif; ?>
                                <?php else: ?>
                                <a href="<?php echo site_url('dialer/ausers/createagency/'.encode_url($agency['id'])) ?>"><?php echo 'Create Dialer User' ?></a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?php echo site_url('dialer/ausers/createagency/'.encode_url($agency['id'])) ?>"><?php echo 'Create Dialer User' ?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
    <?php
}
?>
            </tbody>
        </table>
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/scripts/datatable.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/datatables/datatables.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/swal/sweet-alert.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo site_url('assets/theam_assets/pages/scripts/table-datatables-buttons.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
    $('document').ready(function ()
    {
        $('#agency').parents('li').addClass('open');
        $('#agency').siblings('.arrow').addClass('open');
        $('#agency').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#agency'));
        $('#view_agency').parents('li').addClass('active');
        $('.delete').click(function ()
        {
            id = $(this).attr('id');
            swal({
                title: "Are you sure?",
                text: "You are going to delete this Agency!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function ()
            {
                var url = "<?php echo site_url('agency/deleteagency') ?>" + "/" + id;
                $.ajax({
                    url: url,
                    success: function (status) {
                        if (status)
                        {
                            swal({
                                title: "Deleted",
                                text: "Agency has been deleted successfully",
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