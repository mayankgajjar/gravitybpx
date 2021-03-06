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
                <span>View Agents</span>
            </li>
        </ul>
        <div class="page-toolbar">
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> View Agents </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-dark">
			<i class="icon-user font-dark"></i>
			<span class="caption-subject bold uppercase">Agents</span>
		</div>
		<div class="actions">
            <a href="<?php echo site_url('agency/agentedit'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"> Add Agent </span>
            </a>
        </div>
	</div>
	<div class="portlet-body">
		<?php if( $this->session->flashdata('msg') ): ?>
		<div class='alert alert-success'>
			<?php echo $this->session->flashdata('msg'); ?>
		</div>
		<?php endif; ?>
		<table class="table table-striped table-bordered table-hover" id="sample_1">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email Address</th>
					<th>Phone</th>
					<th>Agent Type</th>
					<th>Parent Agency</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($agents as $agent)
					{
						?>
						<tr>
							<td><?php echo $agent['fname']?></td>
							<td><?php echo $agent['lname']?></td>
							<td><?php echo $agent['email_id'] ?></td>
							<td><?php echo $agent['phone_number'] ?></td>
							<td><?php
									if($agent['agent_type'] == 1)
									{
										echo 'Sales Agent';
									}
									else if($agent['agent_type'] == 2)
									{
										echo 'Verification Agent';
									}
									else if($agent['agent_type'] == 3)
									{
										echo 'Processing Agent';
									}
								?>
							</td>
							<td><?php echo $agent['parent_name'] ?></td>
							<td>
								<a class="info" title="Information" id="<?php echo $agent['id'] ?>" href="<?php echo site_url('agency/manage_agent/agent_info/'.$agent['id']); ?>">
									<span class="fa fa-info"></span>
								</a>&nbsp;&nbsp;
								<a style="text-decoration: none;" class="info"  title="Edit" id="<?php echo $agent['id'] ?>" href="<?php echo site_url('agency/agentedit/'.encode_url($agent['id'])); ?>">
									<i class="fa  fa-pencil-square-o"></i>
								</a>&nbsp;&nbsp;
								<a class="delete" title="Delete" id="<?php echo encode_url($agent['id']) ?>" href="javascript:;">
									<span class="fa fa-trash"></span>
								</a>&nbsp;&nbsp;
                                                            <?php $id = $agent['vicidial_user_id'] ?>
                                                            <?php if($id > 0): ?>
                                                                <?php $user = $this->vusers_m->get_by(array('user_id' => $id), TRUE); ?>
                                                                <?php if($user): ?>
                                                                    <a target="_blank" href="<?php echo site_url('dialer/ausers/edit/'.  encode_url($id)) ?>"><?php echo 'Dialer User' ?></a>
                                                                    <?php $phone = $this->aphones_m->get_by(array('vicidial_user_id' => $id), TRUE);?>
                                                                    <?php if(!$phone): ?>
                                                                        <a href="<?php echo site_url('dialer/aphones/createphone/'.$id) ?>"><?php echo 'Create Phone' ?></a>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                <a href="<?php echo site_url('dialer/ausers/createagent/'.encode_url($agent['id'])) ?>"><?php echo 'Create Dialer User' ?></a>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <a href="<?php echo site_url('dialer/ausers/createagent/'.encode_url($agent['id'])) ?>"><?php echo 'Create Dialer User' ?></a>
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
<script src="assets/theam_assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/swal/sweet-alert.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/theam_assets/pages/scripts/table-datatables-buttons_agent.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
    $('document').ready(function(){
		$('#agent').parents('li').addClass('open');
		$('<span class="selected"></span>').insertAfter($('#agent'));
		$('#view_agent').parents('li').addClass('active');
		$('.delete').click(function(){
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
			function(){
				$.ajax({
					url : 'agency/deleteagent/'+id,
					success : function(status){
						if(status)
						{
							swal({
							  title: "Deleted",
							  text: "Agent has been deleted successfully",
							  showConfirmButton: false
							});
							location.reload();
						}
						else
						{
							swal('Failed!','There is some problem in delete, please try again.','error');
						}
					}
				});
			}
		)
		});
	});
</script>