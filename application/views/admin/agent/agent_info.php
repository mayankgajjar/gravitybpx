<link href="assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE TITLE-->
	<h3 class="page-title"> Agent Information
	</h3>
<!-- END PAGE TITLE-->
					
	<div class="portlet light portlet-fit portlet-datatable bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-user font-dark"></i>
				<span class="caption-subject font-dark sbold uppercase">
					<?php echo $agent->fname.' '.$agent->lname ?>
				</span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="tabbable-line">
				<ul class="nav nav-tabs nav-tabs-lg">
					<li class="active">
						<a href="#tab_1" data-toggle="tab">Account Details</a>
					</li>
					<li>
						<a href="#tab_2" data-toggle="tab">Profile Information
						</a>
					</li>
					<li>
						<a href="#tab_3" data-toggle="tab">License Information</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1">
						<table class='table'>
							<tr>
								<td style='width:40%'>
									First Name
								</td>
								<td style='width:60%'>
									<?php echo chk($agent->fname) ?>
								</td>
							</tr>
							<tr>
								<td>
									Middle Name
								</td>
								<td>
									<?php echo chk($agent->mname) ?>
								</td>
							</tr>
							<tr>
								<td>
									Last Name
								</td>
								<td>
									<?php echo chk($agent->lname) ?>
								</td>
							</tr>
							<tr>
								<td>
									Email Address
								</td>
								<td>
									<?php echo chk($agent->email_id) ?>
								</td>
							</tr>
							<tr>
								<td>
									Agent Type
								</td>
								<td>
									<?php 
										$type = '';
										switch($agent->agent_type)
										{
											case 1:
											{
												$type = 'Sales Agent';
												break;
											}
											case 2:
											{
												$type = 'Verification Agent';
												break;
											}
											case 3:
											{
												$type = 'Processing Agent';
												break;
											}
										}
										echo chk($type);
									?>
								</td>
							</tr>
							<tr>
								<td>
									Parent Agency
								</td>
								<td>
									<?php echo chk($agent->parent_name) ?>
								</td>
							</tr>							
						</table>
					</div>
					<div class="tab-pane" id="tab_2">
						<table class='table'>
							<tr>
								<td style='width:40%'>
									Phone Number
								</td>
								<td style='width:60%'>
									<?php echo chk($agent->phone_number) ?>
								</td>
							</tr>
							<tr>
								<td>
									Fax Number
								</td>
								<td>
									<?php echo chk($agent->fax_number) ?>
								</td>
							</tr>
							<tr>
								<td>
									Date of Birth
								</td>
								<td>
									<?php echo chk($agent->date_of_birth) ?>
								</td>
							</tr>
							<?php
								if(empty($agent->address_line_2) || is_null($agent->address_line_2))
								{
									?>
									<tr>
										<td rowspan='1'>
											Address
										</td>
										<td>
											<?php echo chk($agent->address_line_1) ?>
											
										</td>
									</tr>
									<?php
								}
								else
								{
									?>
									<tr>
										<td rowspan='2'>
											Address
										</td>
										<td>
											<?php echo chk($agent->address_line_1) ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php echo $agent->address_line_2; ?>
										</td>
									</tr>
									<?php
								}
							?>
							<tr>
								<td>
									Country
								</td>
								<td>
									<?php echo $agent->country; ?>
								</td>
							</tr>
							<tr>
								<td>
									State
								</td>
								<td>
									<?php echo $agent->state; ?>
								</td>
							</tr>
							<tr>
								<td>
									City
								</td>
								<td>
									<?php echo $agent->city; ?>
								</td>
							</tr>
							<tr>
								<td>
									Zip Code
								</td>
								<td>
									<?php echo chk($agent->zip_code) ?>
								</td>
							</tr>
						</table>
					</div>
					<div class="tab-pane" id="tab_3">
						<table class='table'>	
							<tr>
								<td style='width:40%'>
									National Producer Number
								</td>
								<td style='width:60%'>
									<?php echo chk($agent->national_producer_number) ?>
								</td>
							</tr>
							<tr>
								<td>
									Resident License Number
								</td>
								<td>
									<?php echo chk($agent->resident_license_number) ?>
								</td>
							</tr>
							<tr>
								<td>
									Resident License State
								</td>
								<td>
									<?php echo chk($agent->resident_state) ?>
								</td>
							</tr>
							<tr>
								<td>
									Non-resident License State
								</td>
								<td>
									<a class="btn btn-outline dark" data-toggle="modal" href="#responsive"> View State </a>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Non-resident state model -->
	<div id="responsive" class="modal fade" style='top:0px;left:40%;width:60%;' tabindex="-1" data-width="760">
		<div class="modal-header">
			<h4 class="modal-title">Select Non-Resident License State</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="checkbox-list">
				<?php
					if(count($agent->non_resident_state) > 0)
					{
						foreach($agent->non_resident_state as $state)
						{
							?>
							<div class='col-sm-6 col-md-4 col-lg-3'>
								<label>
									<?php echo $state['name'] ?>
								</label>
							</div>
							<?php
						}
					}
					else
					{
						?>
						<div class='col-sm-12'>
							<label>
								No State Found
							</label>
						</div>
						<?php
					}
				?>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" data-dismiss='modal' class="btn btn-outline">Close</button>
		</div>
	</div>
<script type="text/javascript">
    $('document').ready(function(){
		$('#agent').parents('li').addClass('open');
		$('#agent').siblings('.arrow').addClass('open');
		$('#agent').parents('li').addClass('active');
		$('<span class="selected"></span>').insertAfter($('#agent'));
		$('#view_agent').parents('li').addClass('active');
	});
</script>
<?php
	function chk($str)
	{
		if(empty($str) || is_null($str))
		{
			return '---------------';
		}
		return $str;
	}
?>