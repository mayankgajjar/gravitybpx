<link href="assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE TITLE-->
	<h3 class="page-title"> Agency Information
	</h3>
<!-- END PAGE TITLE-->					
	<div class="portlet light portlet-fit portlet-datatable bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-home font-dark"></i>
				<span class="caption-subject font-dark sbold uppercase">
					<?php echo chk($agency->name) ?>
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
					<li>
						<a href="#tab_4" data-toggle="tab">Bank Information
						</a>
					</li>
					<li>
						<a href="#tab_5" data-toggle="tab">Downline Agency</a>
					</li>
					<li>
						<a href="#tab_6" data-toggle="tab">Downline Agent</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1">
						<table class='table'>
							<tr>
								<td style='width:40%'>
									Name
								</td>
								<td style='width:60%'>
									<?php echo chk($agency->name) ?>
								</td>
							</tr>
							<tr>
								<td>
									Profile Image
								</td>
								<td>
									<?php
										if(empty($agency->profile_image) || is_null($agency->profile_image))
										{
											echo 'No Profile Image Available';
										}
										else
										{
											?>
											<img src="uploads/logo/<?php echo $agency->profile_image; ?>" style='max-height:200px;max-width:200px;'/>
											<?php
										}
									?>
								</td>
							</tr>
							<tr>
								<td>
									Upline Agency
								</td>
								<td>
									<?php echo chk($agency->parent_name) ?>
								</td>
							</tr>
							<tr>
								<td>
									Email Address
								</td>
								<td>
									<?php echo chk($agency->email_id) ?>
								</td>
							</tr>
							<tr>
								<td>
									Password
								</td>
								<td>
									<?php echo chk($agency->password) ?>
								</td>
							</tr>
						</table>
					</div>
					<div class="tab-pane" id="tab_2">
						<table class='table'>
							<tr>
								<td style='width:40%'>
									First Name
								</td>
								<td style='width:60%'>
									<?php echo chk($agency->fname) ?>
								</td>
							</tr>
							<tr>
								<td>
									Last Name
								</td>
								<td>
									<?php echo chk($agency->lname) ?>
								</td>
							</tr>
							<tr>
								<td>
									Phone Number
								</td>
								<td>
									<?php echo chk($agency->phone_number) ?>
								</td>
							</tr>
							<tr>
								<td>
									Fax Number
								</td>
								<td>
									<?php echo chk($agency->fax_number) ?>
								</td>
							</tr>
							<?php
								if(empty($agency->address_line_2) || is_null($agency->address_line_2))
								{
									?>
									<tr>
										<td>
											Address
										</td>
										<td>
											<?php echo chk($agency->address_line_1) ?>
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
											<?php echo chk($agency->address_line_1) ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php echo $agency->address_line_2; ?>
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
									<?php echo $agency->country; ?>
								</td>
							</tr>
							<tr>
								<td>
									State
								</td>
								<td>
									<?php echo $agency->state; ?>
								</td>
							</tr>
							<tr>
								<td>
									City
								</td>
								<td>
									<?php echo $agency->city; ?>
								</td>
							</tr>
							<tr>
								<td>
									Zip Code
								</td>
								<td>
									<?php echo chk($agency->zip_code) ?>
								</td>
							</tr>
						</table>
					</div>
					<div class="tab-pane" id="tab_3">
						<table class='table'>
							<tr>
								<td style='width:40%'>
									Resident License Number
								</td>
								<td style='width:60%'>
									<?php echo chk($agency->resident_license_number) ?>
								</td>
							</tr>
							<tr>
								<td>
									Resident License State
								</td>
								<td>
									<?php echo chk($agency->resident_state) ?>
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
							<tr>
								<td>
									Service Phone Number
								</td>
								<td>
									<?php echo chk($agency->service_phone_number) ?>
								</td>
							</tr>
							<tr>
								<td>
									Service Fax Number
								</td>
								<td>
									<?php echo chk($agency->service_fax_number) ?>
								</td>
							</tr>
							<tr>
								<td>
									Service Email Address
								</td>
								<td>
									<?php echo chk($agency->service_email) ?>
								</td>
							</tr>
						</table>
					</div>
					<div class="tab-pane" id="tab_4">
						<div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption font-green-sharp">
									<i class="icon-speech font-green-sharp"></i>
									<span class="caption-subject bold uppercase">Credit Card Information</span>
									<span class="caption-helper"></span>
								</div>
							</div>
							<div class="portlet-body">
								<div class="scroller" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd" style='height:100%'>
									<table class='table'>
										<tr>
											<td style='width:40%'>
												Card Type
											</td>
											<td style='width:60%'>
												<?php echo chk($agency->card_type) ?>
											</td>
										</tr>
										<tr>
											<td>
												Name on Card
											</td>
											<td>
												<?php echo chk($agency->card_name) ?>
											</td>
										</tr>
										<tr>
											<td>
												Card Number
											</td>
											<td>
												<?php echo chk($agency->card_number) ?>
											</td>
										</tr>
										<tr>
											<td>
												Expiration Date
											</td>
											<td>
												<?php echo chk($agency->expiration_date) ?>
											</td>
										</tr>
										<tr>
											<td>
												CCV Number
											</td>
											<td>
												<?php echo chk($agency->ccv_number) ?>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						<div class="portlet light bordered">
							<div class="portlet-title">
								<div class="caption font-green-sharp">
									<i class="icon-speech font-green-sharp"></i>
									<span class="caption-subject bold uppercase">Bank Information</span>
									<span class="caption-helper"></span>
								</div>
							</div>
							<div class="portlet-body">
								<div class="scroller" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd" style='height:100%'>
									<table class='table'>
										<tr>
											<td style='width:40%'>
												Name of bank
											</td>
											<td style='width:60%'>
												<?php echo chk($agency->full_name) ?>
											</td>
										</tr>
										<tr>
											<td>
												Bank Account Number
											</td>
											<td>
												<?php echo chk($agency->bank_account_number) ?>
											</td>
										</tr>
										<tr>
											<td>
												Bank Routing Number
											</td>
											<td>
												<?php echo chk($agency->bank_routing_number) ?>
											</td>
										</tr>
										<tr>
											<td>
												Bank Address
											</td>
											<td>
												<?php echo chk($agency->street_address) ?>
											</td>
										</tr>
										<tr>
											<td>
												Bank City
											</td>
											<td>
												<?php echo chk($agency->bank_city) ?>
											</td>
										</tr>
										<tr>
											<td>
												Bank Zip code
											</td>
											<td>
												<?php echo chk($agency->bank_zip_code); ?>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>					
					<div class="tab-pane" id="tab_5">
						<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
								<tr>
									<th>Name</th>
									<th>Signed Up Date</th>
									<th>Resident Licensed State</th>
									<th>Resident Licensed Number</th>
									<th>Non-Resident Licensed State</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($agency->downline as $child)
									{
										?>
										<tr>
											<td><?php echo $child['name'] ?></td>
											<td>
												<?php
													$date = new DateTime($child['created_at']);
													echo $date->format('d-m-Y');
												?>
											</td>
											<td><?php echo $child['resident_state'] ?></td>
											<td><?php echo $child['resident_license_number'] ?></td>
											<td><a class="btn btn-outline dark" data-toggle="modal" href="#responsive_<?php echo $child['id'] ?>"> View State </a></td>
										</tr>
										<!-- Non-resident state model -->
										<div id="responsive_<?php echo $child['id'] ?>" class="modal fade" style='top:0px;left:40%;width:60%;' tabindex="-1" data-width="760">
											<div class="modal-header">
												<h4 class="modal-title">Non-Resident License State</h4>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="checkbox-list">
													<?php
														if(count($child['non_resident_state']) > 0)
														{
															foreach($child['non_resident_state'] as $state)
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
										<?php
									}
								?>
							</tbody>
						</table>
					</div>
					<div class="tab-pane" id="tab_6">
						<table class="table table-striped table-bordered table-hover" id="agent_info">
							<thead>
								<tr>
									<th>Name</th>
									<!--<th>Last Name</th>-->
									<th>Signed Up Date</th>
									<th>Resident Licensed State</th>
									<th>Resident Licensed Number</th>
									<th>Non-resident Licensed State</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($agency->downline_agent as $child)
									{
										?>
										<tr>
											<td><?php echo $child['fname'].' '.$child['lname'] ?></td>
											<!--<td><?php echo $child['lname'] ?></td>-->
											<td>
												<?php
													$date = new DateTime($child['created_at']);
													echo $date->format('d-m-Y');
												?>
											</td>
											<td><?php echo $child['resident_state'] ?></td>
											<td><?php echo $child['resident_license_number'] ?></td>
											<td><a class="btn btn-outline dark" data-toggle="modal" href="#responsive_<?php echo $child['id'] ?>">View State </a></td>
										</tr>
										<!-- Non-resident state model -->
										<div id="responsive_<?php echo $child['id'] ?>" class="modal fade" style='top:0px;left:40%;width:60%;' tabindex="-1" data-width="760">
											<div class="modal-header">
												<h4 class="modal-title">Non-Resident License State</h4>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="checkbox-list">
													<?php
														if(count($child['non_resident_state']) > 0)
														{
															foreach($child['non_resident_state'] as $state)
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
										<?php
									}
								?>
							</tbody>
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
					if(count($agency->non_resident_state) > 0)
					{
						foreach($agency->non_resident_state as $state)
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
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/theam_assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="assets/theam_assets/pages/scripts/table-datatables-buttons_agency_info.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
    $('document').ready(function(){
		$('#agency').parents('li').addClass('open');
		$('#agency').siblings('.arrow').addClass('open');
		$('#agency').parents('li').addClass('active');
		$('<span class="selected"></span>').insertAfter($('#agency'));
		$('#view_agency').parents('li').addClass('active');
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