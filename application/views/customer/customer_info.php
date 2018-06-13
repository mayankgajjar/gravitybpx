<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css'); ?>" rel="stylesheet" type="text/css" />
    <div class="breadcrumbs">
        <h1 class="page-title"> <?php echo 'Customer Information'; ?> </h1>     
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo 'Home' ?></a></li>
            <li class="active">
                <?php echo 'Customer Information';; ?>
            </li>
        </ol>        
    </div>    
	
	<div class="portlet light portlet-fit portlet-datatable bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-user font-dark"></i>
				<span class="caption-subject font-dark sbold uppercase">
					<?php echo $customer->fname.' '.$customer->lname ?>
				</span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="tabbable-line">
				<ul class="nav nav-tabs nav-tabs-lg">
					<li class="active">
						<a href="#tab_1" data-toggle="tab">Customer Details</a>
					</li>
					<li>
						<a href="#tab_2" data-toggle="tab">Product</a>
					</li>
					<li>
						<a href="#tab_3" data-toggle="tab">Application</a>
					</li>
					<li>
						<a href="#tab_4" data-toggle="tab">Additional Members</a>
					</li>
					<li>
						<a href="#tab_5" data-toggle="tab">Beneficiaries</a>
					</li>
					<li>
						<a href="#tab_6" data-toggle="tab">Bank Details</a>
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
									<?php echo chk($customer->fname); ?>
								</td>
							</tr>
							<tr>
								<td>
									Middle Name
								</td>
								<td>
									<?php echo chk($customer->mname); ?>
								</td>
							</tr>
							<tr>
								<td>
									Last Name
								</td>
								<td>
									<?php echo chk($customer->lname); ?>
								</td>
							</tr>
							<tr>
								<td>
									Gender
								</td>
								<td>
									<?php 
										if(chk($customer->gender) == "male")
										{
											echo "Male";
										}
										elseif(chk($customer->gender) == "female")
										{
											echo "Female";
										}																			
									?>
								</td>
							</tr>
							<tr>
								<td>
									Date of Birth
								</td>
								<td>
									<?php echo chk($customer->date_of_birth); ?>
								</td>
							</tr>
							<tr>
								<td>
									Age
								</td>
								<td>
									<?php echo chk($customer->age); ?>
								</td>
							</tr>
							<tr>
								<td>
									Zip Code
								</td>
								<td>
									<?php echo chk($customer->zipcode); ?>
								</td>
							</tr>
							<tr>
								<td>
									City
								</td>
								<td>
									<?php echo chk($customer->city); ?>
								</td>
							</tr>
							<tr>
								<td>
									State
								</td>
								<td>
									<?php echo chk($customer->state); ?>
								</td>
							</tr>							
							<tr>
								<td>
									Phone Number
								</td>
								<td>
									<?php echo chk($customer->phone_number); ?>
								</td>
							</tr>
							<tr>
								<td>
									Email Address
								</td>
								<td>
									<?php echo chk($customer->email); ?>
								</td>
							</tr>																					
						</table>
					</div>
					<div class="tab-pane" id="tab_2">
						<table class='table'>
							<tr>
								<td style='width:40%'>
									Pre-Existing Condition? 
								</td>
								<td style='width:60%'>
									<?php 
										if(chk($customer->customer_plan->pre_existing_condition) == "yes")
										{
											echo "Yes";
										}
										elseif(chk($customer->customer_plan->pre_existing_condition) == "no")
										{
											echo "No";
										}																			
									?>
								</td>
							</tr>
							<tr>
								<td>
									Use Tobacco?
								</td>
								<td>
									<?php 
										if(chk($customer->customer_plan->use_tobacco) == "yes")
										{
											echo "Yes";
										}
										elseif(chk($customer->customer_plan->use_tobacco) == "no")
										{
											echo "No";
										}																			
									?>
								</td>
							</tr>
							<tr>
								<td>
									Plan Type
								</td>
								<td>
									<?php
										if($customer->customer_plan->plan_type == "single")
										{
											echo "Single";
										}
										else if($customer->customer_plan->plan_type == "single_spouse")
										{
											echo "Single+Spouse";
										}
										else if($customer->customer_plan->plan_type == "single_child")
										{
											echo "Single+Child";
										}
										else
										{
											echo "Family";
										}
									?>									
								</td>
							</tr>							
							<tr>
								<td>
									First Payment 
								</td>
								<td>
									<?php echo chk($customer->customer_plan->first_payment); ?>
								</td>
							</tr>																					
						</table>
						<?php
							if($customer->products != "")
							{
						?>
						 <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-green">
                                        <i class="icon-settings font-green"></i>
                                        <span class="caption-subject bold uppercase">Customer Products</span>
                                    </div>
                                    <div class="tools"> </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="all">Product Category</th>
                                                <th class="all">Product Name</th>
                                                <th class="min-phone-l">Company</th>
                                                <th class="min-tablet">Company Logo</th>
                                                <th class="none">Product Levels</th>
                                                <th class="none">Product Price</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php
                                        	foreach($customer->products as $key => $value)
											{
												$number = $key + 1;
											?>
	                                            <tr>
	                                                <th><?php echo $number; ?></th>
	                                                <td><?php echo $value['category_name']; ?></td>
	                                                <td><?php echo $value['product_name']; ?></td>
	                                                <td><?php echo $value['company_name']; ?></td>
	                                                <td><img src="uploads/company_logo/<?php echo $value['company_logo']?>"/></td>
	                                                <td><?php echo $value['product_levels']; ?></td>
	                                                <td><?php echo '$'.$value['product_price']; ?></td>
	                                                
	                                            </tr>                                           
	                                        <?php 
	                                        	}
	                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        <?php
                        	}
                        ?>
					</div>
					<div class="tab-pane" id="tab_3">
						<table class='table'>	
							<tr>
								<td style='width:40%'>
									First Name
								</td>
								<td style='width:60%'>
									<?php echo chk($customer->app_fname); ?>
								</td>
							</tr>
							<tr>
								<td>
									Middle Name
								</td>
								<td>
									<?php echo chk($customer->app_mname); ?>
								</td>
							</tr>
							<tr>
								<td>
									Last Name
								</td>
								<td>
									<?php echo chk($customer->app_lname); ?>
								</td>
							</tr>
							<tr>
								<td>
									Marital Status
								</td>
								<td>
									<?php 
										if(chk($customer->app_marital_status) == "married")
										{
											echo "Married";
										}
										elseif(chk($customer->gender) == "single")
										{
											echo "Single";
										}																			
									?>
								</td>
							</tr>
							<tr>
								<td>
									Gender
								</td>
								<td>
									<?php 
										if(chk($customer->app_gender) == "male")
										{
											echo "Male";
										}
										elseif(chk($customer->app_gender) == "female")
										{
											echo "Female";
										}																			
									?>
								</td>
							</tr>
							<tr>
								<td>
									Height
								</td>
								<td>
									<?php 
										if($customer->app_height_feet == "" && $customer->app_height_inches == "")
										{
											echo "---------------";
										}										
										else
										{
											if($customer->app_height_feet != "")
											{
												echo $customer->app_height_feet." Feet  ";
											}
											if($customer->app_height_inches != "")
											{
												echo $customer->app_height_inches." Inches";
											}																						
										}
									?>
								</td>
							</tr>
							<tr>
								<td>
									Weight
								</td>
								<td>
									<?php echo chk($customer->app_weight); ?>
								</td>
							</tr>
							<tr>
								<td>
									Primary Mailing Address
								</td>
								<td>
									<?php echo chk($customer->app_primary_email); ?>
								</td>
							</tr>
							<tr>
								<td>
									Zip Code
								</td>
								<td>
									<?php echo chk($customer->app_zipcode); ?>
								</td>
							</tr>
							<tr>
								<td>
									City
								</td>
								<td>
									<?php echo chk($customer->app_city); ?>
								</td>
							</tr>
							<tr>
								<td>
									State
								</td>
								<td>
									<?php echo chk($customer->app_state); ?>
								</td>
							</tr>
							<tr>
								<td>
									How long at current address?
								</td>
								<td>									
									<?php									
									if($customer->app_how_long_address == 0)
									{
										echo "---------------";
									}
									else
									{
										if($customer->app_how_long_address == 1)
										{
											echo chk($customer->app_how_long_address)." year"; 
										}
										else
										{
											echo chk($customer->app_how_long_address)." years"; 
										}
									}									
									?>
								</td>
							</tr>							
							<?php
								if($customer->app_how_long_address < 6 && $customer->app_how_long_address > 0)
								{
							?>
							<tr>
								<td>
									Address
								</td>
								<td>
									<?php echo chk($customer->app_another_address); ?>
								</td>
							</tr>
							<tr>
								<td>
									Zip Code
								</td>
								<td>
									<?php echo chk($customer->app_another_zipcode); ?>
								</td>
							</tr>
							<tr>
								<td>
									City
								</td>
								<td>
									<?php echo chk($customer->app_another_city); ?>
								</td>
							</tr>
							<tr>
								<td>
									State
								</td>
								<td>
									<?php echo chk($customer->app_another_state); ?>
								</td>
							</tr>
							<tr>
								<td>
									Time at address
								</td>
								<td>
									<?php echo chk($customer->app_another_time_at_address); ?>
								</td>
							</tr>
							<?php		
								}
							?>
							<tr>
								<td>
									Phone Number
								</td>
								<td>
									<?php echo chk($customer->app_phone_number); ?>
								</td>
							</tr>
							<tr>
								<td>
									Email Address
								</td>
								<td>
									<?php echo chk($customer->app_email); ?>
								</td>
							</tr>
							<tr>
								<td>
									Social Security Number
								</td>
								<td>
									<?php echo chk($customer->app_social_sec_number); ?>
								</td>
							</tr>
							<tr>
								<td>
									Date of Birth
								</td>
								<td>
									<?php echo chk($customer->app_date_of_birth); ?>
								</td>
							</tr>							
							<tr>
								<td>
									Age
								</td>
								<td>
									<?php echo chk($customer->app_age); ?>
								</td>
							</tr>
							<tr>
								<td>
									Birth Country
								</td>
								<td>
									<?php echo chk($customer->birth_country); ?>
								</td>
							</tr>
							<tr>
								<td>
									Birth State
								</td>
								<td>
									<?php echo chk($customer->birth_state); ?>
								</td>
							</tr>
							<tr>
								<td>
									Is the Proposed Insured a U.S. Citizen?
								</td>
								<td>
									<?php
										if($customer->app_is_us_citizen == "")
										{
											echo "---------------";
										}										
										else
										{
											if($customer->app_is_us_citizen == "yes")
											{
												echo "Yes";
											}
											if($customer->app_is_us_citizen == "no")
											{
												echo "No";
											}																						
										}
									?>
								</td>
							</tr>
							<tr>
								<td>
									Is The Proposed Insured currently employed?
								</td>
								<td>
									<?php
										if($customer->app_is_employed == "")
										{
											echo "---------------";
										}										
										else
										{
											if($customer->app_is_employed == "yes")
											{
												echo "Yes";
											}
											if($customer->app_is_employed == "no")
											{
												echo "No";
											}																						
										}
									?>
								</td>
							</tr>
							<tr>
								<td>
									Employer
								</td>
								<td>
									<?php echo chk($customer->app_employer); ?>
								</td>
							</tr>
							<tr>
								<td>
									Occupation
								</td>
								<td>
									<?php echo chk($customer->app_occupation); ?>
								</td>
							</tr>
							<tr>
								<td>
									Annual Salary
								</td>
								<td>
									<?php 
										if($customer->app_annual_salary != "")
										{
											echo toMoney($customer->app_annual_salary);
										}
										else
										{
											echo '---------------';
										}
									?>
								</td>
							</tr>				
							<tr>
								<td>
									Description of Job Duties
								</td>
								<td>
									<?php echo chk($customer->app_desc_of_job_duties); ?>
								</td>
							</tr>
							<tr>
								<td>
									Driver’s License
								</td>
								<td>
									<?php echo chk($customer->app_driver_license); ?>
								</td>
							</tr>							
						</table>
					</div>
					<div class="tab-pane" id="tab_4">						
							<?php 						
							if($customer->additional_members != "")
							{						
								foreach($customer->additional_members as $key => $value)
								{
									$number = $key + 1;
							?>	
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption font-green-sharp">
											<i class="icon-speech font-green-sharp"></i>
											<span class="caption-subject bold uppercase"><?php echo $number." Additional Member" ?></span>
											<span class="caption-helper"></span>
										</div>
									</div>
									<div class="portlet-body">
										<div class="scroller" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd" style='height:100%'>
											<table class='table'>										
												<tr>
													<td style='width:40%'>
														First Name
													</td>
													<td style='width:60%'>
														<?php echo chk($value['am_fname']); ?>
													</td>
												</tr>
												<tr>
													<td>
														Middle Name
													</td>
													<td>
														<?php echo chk($value['am_mname']); ?>
													</td>
												</tr>
												<tr>
													<td>
														Last Name
													</td>
													<td>
														<?php echo chk($value['am_lname']); ?>
													</td>
												</tr>														
												<tr>
													<td>
														Social Security Number
													</td>
													<td>
														<?php echo chk($value['am_social_sec_number']); ?>
													</td>
												</tr>
												<tr>
													<td>
														Relationship
													</td>
													<td>
														<?php echo chk($value['am_relationship']); ?>
													</td>
												</tr>
												<tr>
													<td>
														Date of Birth
													</td>
													<td>
														<?php echo chk($value['am_date_of_birth']); ?>
													</td>
												</tr>	
											</table>
										</div>
									</div>
								</div>
							<?php
								}
							}
							?>													
						
					</div>
					<div class="tab-pane" id="tab_5">
						<?php 
							if($customer->customer_beneficiaries != "")
							{
								foreach($customer->customer_beneficiaries as $key => $value)
								{
									$number = $key + 1;
							?>	
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption font-green-sharp">
											<i class="icon-speech font-green-sharp"></i>
											<span class="caption-subject bold uppercase"><?php echo $number." Beneficiar" ?></span>
											<span class="caption-helper"></span>
										</div>
									</div>
									<div class="portlet-body">
										<div class="scroller" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd" style='height:100%'>
											<table class='table'>										
												<tr>
													<td style='width:40%'>
														First Name
													</td>
													<td style='width:60%'>
														<?php echo chk($value['be_fname']); ?>
													</td>
												</tr>
												<tr>
													<td>
														Middle Name
													</td>
													<td>
														<?php echo chk($value['be_mname']); ?>
													</td>
												</tr>
												<tr>
													<td>
														Last Name
													</td>
													<td>
														<?php echo chk($value['be_lname']); ?>
													</td>
												</tr>														
												<tr>
													<td>
														Social Security Number
													</td>
													<td>
														<?php echo chk($value['be_social_sec_number']); ?>
													</td>
												</tr>
												<tr>
													<td>
														Relationship
													</td>
													<td>
														<?php echo chk($value['be_relationship']); ?>
													</td>
												</tr>
												<tr>
													<td>
														Date of Birth
													</td>
													<td>
														<?php echo chk($value['be_date_of_birth']); ?>
													</td>
												</tr>
												<tr>
													<td>
														Phone Number
													</td>
													<td>
														<?php echo chk($value['be_phone_number']); ?>
													</td>
												</tr>
												<tr>
													<td>
														Email Address
													</td>
													<td>
														<?php echo chk($value['be_email']); ?>
													</td>
												</tr>
												<tr>
													<td>
														% of Share
													</td>
													<td>
														<?php echo chk($value['be_per_of_share']); ?>
													</td>
												</tr>	
											</table>
										</div>
									</div>
								</div>
							<?php
								}
							}
							?>								
					</div>
					<div class="tab-pane" id="tab_6">					
						<?php
							if($customer->bank_name != "")
							{
							?>
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
														Bank Name
													</td>
													<td style='width:60%'>
														<?php echo chk($customer->bank_name); ?>
													</td>
												</tr>
												<tr>
													<td>
														Bank Address
													</td>
													<td>
														<?php echo chk($customer->bank_address); ?>
													</td>
												</tr>
												<tr>
													<td>
														Country
													</td>
													<td>
														<?php echo chk($customer->bank_country); ?>
													</td>
												</tr>
												<tr>
													<td>
														State
													</td>
													<td>
														<?php echo chk($customer->bank_state); ?>
													</td>
												</tr>													
												<tr>
													<td>
														City
													</td>
													<td>
														<?php echo chk($customer->bank_city); ?>
													</td>
												</tr>	
												<tr>
													<td>
														Zip Code
													</td>
													<td>
														<?php echo chk($customer->bank_zipcode); ?>
													</td>
												</tr>	
												<tr>
													<td>
														Bank Routing (ABA) Number
													</td>
													<td>
														<?php echo chk($customer->bank_routing_number); ?>
													</td>
												</tr>
												<tr>
													<td>
														Bank Account Number
													</td>
													<td>
														<?php echo chk($customer->bank_account_number); ?>
													</td>
												</tr>
											</table>
										</div>
									</div>
								</div>	
							<?php																												
							}
							else
							{
							?>
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
												<?php /*
												<tr>
													<td style='width:40%'>
														Credit Card First Name
													</td>
													<td style='width:60%'>
														<?php echo chk($customer->fname_credit_card); ?>
													</td>
												</tr>
												<tr>
													<td>
														Credit Card Middle Name
													</td>
													<td>
														<?php echo chk($customer->mname_credit_card); ?>
													</td>
												</tr>
												<tr>
													<td>
														Credit Card Last Name
													</td>
													<td>
														<?php echo chk($customer->lname_credit_card); ?>
													</td>
												</tr> */ ?>													
												<tr>
													<td>
														Card Type
													</td>
													<td>
														<?php echo chk($customer->card_type); ?>
													</td>
												</tr>	
												<tr>
													<td>
														Credit Card Number
													</td>
													<td>
														<?php echo chk($customer->card_number); ?>
													</td>
												</tr>	
												<tr>
													<td>
														Expiration Date
													</td>
													<td>
														<?php echo chk($customer->expiration_date); ?>
													</td>
												</tr>
												<tr>
													<td>
														CCV Number
													</td>
													<td>
														<?php echo chk($customer->ccv_number); ?>
													</td>
												</tr>
												<tr>
													<td>
														Billing Address Same as Resident Address?
													</td>
													<td>
														<?php 
															if($customer->bill_add_same_resi_add != "")
															{													
																if($customer->bill_add_same_resi_add == 1)
																{
																	echo "Yes";
																}
																else
																{
																	echo "No";
																}											
															}
															else
															{
																echo "---------------";
															}
														?>											
													</td>
												</tr>
												<tr>
													<td>
														Billing Address
													</td>
													<td>
														<?php echo chk($customer->card_address); ?>
													</td>
												</tr>
												<tr>
													<td>
														Country
													</td>
													<td>
														<?php echo chk($customer->card_country); ?>
													</td>
												</tr>
												<tr>
													<td>
														State
													</td>
													<td>
														<?php echo chk($customer->card_state); ?>
													</td>
												</tr>
												<tr>
													<td>
														City
													</td>
													<td>
														<?php echo chk($customer->card_city); ?>
													</td>
												</tr>
												<tr>
													<td>
														Zip Code
													</td>
													<td>
														<?php echo chk($customer->card_zipcode); ?>
													</td>
												</tr>
												<tr>
													<td>
														Notes
													</td>
													<td>
														<?php echo chk($customer->notes); ?>
													</td>
												</tr>									
											</table>
										</div>
									</div>
								</div>
						
							<?php
							}
						?>																						
					</div>
				</div>
			</div>
		</div>
	</div>	
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
<script type="text/javascript">
$('#customer').parents('li').addClass('open');
$('#customer').siblings('.arrow').addClass('open');
$('#customer').parents('li').addClass('active');            
$('#view_customer').parents('li').addClass('active');        
$('<span class="selected"></span>').insertAfter($('#customer'));
</script>