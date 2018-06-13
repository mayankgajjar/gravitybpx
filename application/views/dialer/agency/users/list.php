<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $breadcrumb; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title"><?php echo $title; ?> </h3>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
<!--        <div class="actions">
            <a href="<?php echo site_url($addactioncontroller ); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Add Campaign"; ?></span>
            </a>
        </div>-->
    </div>
    <div class="portlet-body">
        <form class="categories_from" action="<?php echo site_url('dialer/acampaign/campaignmassaction'); ?> " name="categories_form" method="post">
            <?php
            if($this->session->flashdata())
            {
                if($this->session->flashdata('error') != "")
                {
                ?>
                    <div class='alert alert-danger'>
                        <i class="fa-lg fa fa-warning"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php
                }
                else
                {
                ?>
                    <div class='alert alert-success'>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php
                }
            }
            ?>
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-8"></div>
<!--                    <div class="col-md-4" style="float:right">
                        <div class="table-group-actions pull-right">
                            <select name="action" class="table-group-action-input form-control input-inline input-small input-sm">
                                <option value="">Select...</option>
                                <option value="del">Delete</option>
                            </select>
                            <button class="btn btn-sm btn-success table-group-action-submit">
                                <i class="fa fa-check"></i> Submit</button>
                        </div>
                    </div>-->
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                    <thead>
                            <tr>
                                    <th id="first">Agency Name</th>
                                    <th>User ID</th>
                                    <th>Full Name</th>
                                    <th>Level</th>
                                    <th>Group</th>
                                    <th>Actions</th>
                            </tr>
                    </thead>
                <tbody>
                    <?php foreach($agencies as $agency) :?>
                        <tr>
                            <?php $dialerUser = $this->vusers_m->get_by(array('user_id' => $agency['vicidial_user_id']),TRUE); ?>
                            <td><a href="<?php echo site_url('agency/manage_agency/agency_info/'.$agency['id']) ?>"><?php echo $agency['name'] ?></a></td>
                            <td>
                                <?php if($dialerUser): ?>
                                    <?php echo $dialerUser->user ?>
                                <?php else: ?>
                                    <?php echo 'None'; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($dialerUser): ?>
                                    <?php echo $dialerUser->full_name ?>
                                <?php else: ?>
                                    <?php echo 'None'; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($dialerUser): ?>
                                    <?php echo $dialerUser->user_level; ?>
                                <?php else: ?>
                                    <?php echo 'None'; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($dialerUser): ?>
                                    <?php echo $dialerUser->user_group; ?>
                                <?php else: ?>
                                    <?php echo 'None'; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($dialerUser): ?>
                                    <a class="info" title="Edit" style="text-decoration:none;" id="<?php echo encode_url($dialerUser->user_id) ?>" href="<?php echo site_url('dialer/ausers/edit/'.encode_url($dialerUser->user_id)) ?>">
                                        <span class="fa  fa-pencil-square-o"></span>
                                    </a>&nbsp;&nbsp;
<!--                                    <a class="delete" title="Delete" id="<?php echo encode_url($agency['id']) ?>" href="javascript:;">
                                        <span class="fa fa-trash"></span>
                                    </a>-->
                                <?php else: ?>
                                    <a class="info" title="<?php echo 'Create Dialer User' ?>" href="<?php echo site_url('dialer/ausers/createagency/'.  encode_url($agency['id'])) ?>"><?php echo "Create Dialer User" ?></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php  endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<script type="text/javascript">
    $('document').ready(function(){
        jQuery('#datatable').dataTable( {
//                "bProcessing": true,
//                "bServerSide": true,
//                "sAjaxSource": "<?php //echo site_url('dialer/acampaign/indexJson'); ?>",
                "columnDefs": [ {
                    'orderable': false,
                    'targets': [5]
                },{
                    "searchable": false,
                    "targets": [5]
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
        jQuery(document).on('click', '.delete', function(event){
            event.preventDefault();
            id = jQuery(this).attr('href');
            swal({
                title: "Are you sure?",
                text: "You are going to delete this campaign!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function(isConfirm){
                if(isConfirm){
                    location.href =  id;
                }
            });
        });
    });
</script>
<style type="">#first{width: 30%!important;}</style>