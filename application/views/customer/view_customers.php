<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>View Customers</span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> View Customers </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="icon-user font-dark"></i>
            <span class="caption-subject bold uppercase">Customers</span>
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
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Zip Code</th>
                    <th>Phone Number</th>
                    <th>Email Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer) : ?>
                    <tr>
                        <td><?php echo $customer['fname'] . " " . $customer['mname'] . " " . $customer['lname']; ?></td>
                        <td>
                            <?php if ($customer['gender'] == "male") : ?>
                                <?php echo "Male"; ?>
                            <?php elseif($customer['gender'] == "female") : ?>
                                <?php echo "Female"; ?>
                            <?php else : ?>
                                <?php echo ""; ?>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $customer['date_of_birth']; ?></td>
                        <td><?php echo $customer['zipcode']; ?></td>
                        <td><?php echo $customer['phone_number']; ?></td>
                        <td><?php echo $customer['email']; ?></td>
                        <td>
                            <?php if ($this->session->userdata('agency') && $this->session->userdata('agency')->id != "") : ?>
                                <a class="info" title="Information" id="<?php echo $customer['id']; ?>" href="<?php echo site_url('customer/manage_customer/customer_info/' . $customer['id']); ?>">
                                    <span class="fa fa-info"></span>
                                </a>&nbsp;&nbsp;
                                <a style="text-decoration: none;" class="info"  title="Edit" id="<?php echo $customer['id'] ?>" href="<?php echo site_url('customer/manage_customer/getCustomerById/' . $customer['id']); ?>">
                                    <i class="fa  fa-pencil-square-o"></i>
                                </a>
                            <?php else : ?>
                                <a class="info" title="Information" id="<?php echo $customer['id']; ?>" href="<?php echo site_url('customer/manage_customer/customer_info/' . $customer['id']); ?>">
                                    <span class="fa fa-info"></span>
                                </a>&nbsp;&nbsp;
                                <a style="text-decoration: none;" class="info"  title="Edit" id="<?php echo $customer['id'] ?>" href="<?php echo site_url('customer/manage_customer/getCustomerById/' . $customer['id']); ?>">
                                    <i class="fa  fa-pencil-square-o"></i>
                                </a>&nbsp;&nbsp;
                                <a class="delete" title="Delete" id="<?php echo $customer['id'] ?>" href="javascript:;">
                                    <span class="fa fa-trash"></span>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $('document').ready(function () {
        jQuery('#sample_1').dataTable({
            "columnDefs": [{
                    'orderable': false,
                    'targets': [6]
                }, {
                    "searchable": false,
                    "targets": [6]
                }],
        });
        $('#customer').parents('li').addClass('open');
        $('#customer').siblings('.arrow').addClass('open');
        $('#customer').parents('li').addClass('active');
        $('#view_customer').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#customer'));
        $('.delete').click(function ()
        {
            id = $(this).attr('id');
            swal({
                title: "Are you sure?",
                text: "You are going to delete this customer!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function () {
                var url = "<?php echo site_url('customer/manage_customer/delete'); ?>" + '/' + id;
                $.ajax({
                    url: url,
                    success: function (status)
                    {
                        if (status)
                        {
                            swal({
                                title: "Deleted",
                                text: "Customer has been deleted successfully",
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
