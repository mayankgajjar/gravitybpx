<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css'); ?>" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE HEADER-->   
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="<?php echo site_url(); ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Product Information</span>
            </li>
        </ul>
        <div class="page-toolbar">           
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Product Information </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
<div class="row">
	<div class="col-md-12">
		<div class="portlet box light portlet-fit portlet-datatable bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-shopping-cart font-dark"></i>
				<span class="caption-subject font-dark sbold uppercase">
				<?php echo chk($products->product_name) ?>					
				</span>
			</div>
		</div>
		<div class="portlet-body">
			<div class="table-scrollable">
				<table class='table'>
					<tr>
						<td>
							Product Category
						</td>
						<td>
							<?php echo chk($products->category_name); ?>
						</td>
					</tr>
					<tr>
						<td>
							Product Name
						</td>
						<td>
							<?php echo chk($products->product_name) ?>
						</td>
					</tr>
					<tr>
						<td>
							Company
						</td>
						<td>
							<?php echo chk($products->company_name); ?>
						</td>
					</tr>
					<tr>
						<td>
							Country
						</td>
						<td>
							<?php echo chk($products->country_name); ?>
						</td>
					</tr>
					<tr>
						<td>
							States
						</td>
						<td>
							<?php echo chk($products->product_states_names); ?>
						</td>
					</tr>
					<tr>
						<td>
							Product Levels
						</td>
						<td>
							<?php echo chk($products->product_levels); ?>						
						</td>
					</tr>
					<tr>
						<td>
							Product Price
						</td>
						<td>
							<?php 
								if($products->product_price != "")
								{
									echo toMoney($products->product_price);
								}						
								else
								{								
									echo chk($products->product_price);
								}
							?>
						</td>
					</tr>
					<tr>
						<td>
							Product Overview
						</td>
						<td>
							<?php echo chk($products->product_overview); ?>
						</td>
					</tr>
					<tr>
						<td>
							Product Description
						</td>
						<td>
							<?php echo chk($products->product_description); ?>
						</td>
					</tr>
					<tr>
						<td>
							Product Brochure
						</td>
						<td>
							<?php echo chk($products->product_brochure); ?>
						</td>
					</tr>
					<tr>
						<td>
							Application Information
						</td>
						<td>
							<?php 
								$products_application_information = explode('&', unserialize($products->application_information));								

								if($products_application_information[0] == "app_fname=required")
								{
									echo "First Name is Required <br/>";
								}
								else								
								{
									echo "First Name is Not Required <br/>";
								}

								if($products_application_information[1] == "app_mname=required")
								{
									echo "Middle Name is Required <br/>";
								}
								else								
								{
									echo "Middle Name is Not Required <br/>";
								}

								if($products_application_information[2] == "app_lname=required")
								{
									echo "Last Name is Required <br/>";
								}
								else								
								{
									echo "Last Name is Not Required <br/>";
								}

								if($products_application_information[3] == "app_marital_status=required")
								{
									echo "Marital Status is Required <br/>";
								}
								else								
								{
									echo "Marital Status is Not Required <br/>";
								}

								if($products_application_information[4] == "app_gender=required")
								{
									echo "Gender is Required <br/>";
								}
								else								
								{
									echo "Gender is Not Required <br/>";
								}

								if($products_application_information[5] == "app_height=required")
								{
									echo "Height is Required <br/>";
								}
								else								
								{
									echo "Height is Not Required <br/>";
								}

								if($products_application_information[6] == "app_weight=required")
								{
									echo "Weight is Required <br/>";
								}
								else								
								{
									echo "Weight is Not Required <br/>";
								}

								if($products_application_information[7] == "app_primary_email=required")
								{
									echo "Primary Mailing Address is Required <br/>";
								}
								else								
								{
									echo "Primary Mailing Address is Not Required <br/>";
								}

								if($products_application_information[8] == "app_zipcode=required")
								{
									echo "Zip Code is Required <br/>";
								}
								else								
								{
									echo "Zip Code is Not Required <br/>";
								}

								if($products_application_information[9] == "app_how_long_address=required")
								{
									echo "How long at current address? is Required <br/>";
								}
								else								
								{
									echo "How long at current address? Not Required <br/>";
								}

								if($products_application_information[10] == "app_phone_number=required")
								{
									echo "Phone Number is Required <br/>";
								}
								else								
								{
									echo "Phone Number is Not Required <br/>";
								}

								if($products_application_information[11] == "app_email=required")
								{
									echo "Email Address is Required <br/>";
								}
								else								
								{
									echo "Email Address is Not Required <br/>";
								}

								if($products_application_information[12] == "app_social_sec_number=required")
								{
									echo "Social Security Number is Required <br/>";
								}
								else								
								{
									echo "Social Security Number is Not Required <br/>";
								}

								if($products_application_information[13] == "app_date_of_birth=required")
								{
									echo "Date of Birth is Required <br/>";
								}
								else								
								{
									echo "Date of Birth is Not Required <br/>";
								}

								if($products_application_information[14] == "app_birth_state_id=required")
								{
									echo "Birth State is Required <br/>";
								}
								else								
								{
									echo "Birth State is Not Required <br/>";
								}

								if($products_application_information[15] == "app_is_us_citizen=required")
								{
									echo "Is the Proposed Insured a U.S. Citizen? is Required <br/>";
								}
								else								
								{
									echo "Is the Proposed Insured a U.S. Citizen? is Not Required <br/>";
								}

								if($products_application_information[16] == "app_is_employed=required")
								{
									echo "Is The Proposed Insured currently employed? is Required <br/>";
								}
								else								
								{
									echo "Is The Proposed Insured currently employed? is Not Required <br/>";
								}

								if($products_application_information[17] == "app_employer=required")
								{
									echo "Employer is Required <br/>";
								}
								else								
								{
									echo "Employer is Not Required <br/>";
								}

								if($products_application_information[18] == "app_occupation=required")
								{
									echo "Occupation is Required <br/>";
								}
								else								
								{
									echo "Occupation is Not Required <br/>";
								}

								if($products_application_information[19] == "app_annual_salary=required")
								{
									echo "Annual Salary is Required <br/>";
								}
								else								
								{
									echo "Annual Salary is Not Required <br/>";
								}

								if($products_application_information[20] == "app_desc_of_job_duties=required")
								{
									echo "Description of Job Duties is Required <br/>";
								}
								else								
								{
									echo "Description of Job Duties is Not Required <br/>";
								}

								if($products_application_information[21] == "app_driver_license=required")
								{
									echo "Driver’s License is Required <br/>";
								}
								else								
								{
									echo "Driver’s License is Not Required <br/>";
								}																
							?>
						</td>
					</tr>
					<tr>
						<td>
							Age
						</td>
						<td>
							<?php 
								if($products->age_from != "" && $products->age_to != "")
								{
								?>
									From: <?php echo $products->age_from; ?> To: <?php echo $products->age_to;
								}						
								else
								{				
									if($products->age_from != "")
									{
									?>
										From: <?php echo $products->age_from;
									}
									else
									{
									?>
										From: <?php echo '---------------';
									}				
									if($products->age_to != "")
									{
									?>
										To: <?php echo $products->age_to;
									}
									else
									{
									?>
										To: <?php echo '---------------';
									}											
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
								if($products->height_feet_from != "" && $products->height_feet_to != "")
								{
								?>
									Height Feet From : <?php echo $products->height_feet_from; ?> To: <?php echo $products->height_feet_to;
								}						
								else
								{				
									if($products->height_feet_from != "")
									{
									?>
										Height Feet From : <?php echo $products->height_feet_from;
									}
									else
									{
									?>
										Height Feet From : <?php echo '---------------';
									}				
									if($products->height_feet_to != "")
									{
									?>
										To: <?php echo $products->height_feet_to;
									}
									else
									{
									?>
										To: <?php echo '---------------';
									}											
								}
							?>
								<br/>
							<?php 
								if($products->height_inches_from != "" && $products->height_inches_to != "")
								{
								?>
									Height Inches From : <?php echo $products->height_inches_from; ?> To: <?php echo $products->height_inches_to;
								}						
								else
								{				
									if($products->height_inches_from != "")
									{
									?>
										Height Inches From : <?php echo $products->height_inches_from;
									}
									else
									{
									?>
										Height Inches From : <?php echo '---------------';
									}				
									if($products->height_inches_to != "")
									{
									?>
										To: <?php echo $products->height_inches_to;
									}
									else
									{
									?>
										To: <?php echo '---------------';
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
							<?php 
								if($products->weight_from != "" && $products->weight_to != "")
								{
								?>
									From : <?php echo $products->weight_from; ?> To: <?php echo $products->weight_to;
								}						
								else
								{				
									if($products->weight_from != "")
									{
									?>
										From : <?php echo $products->weight_from;
									}
									else
									{
									?>
										From : <?php echo '---------------';
									}				
									if($products->weight_to != "")
									{
									?>
										To: <?php echo $products->weight_to;
									}
									else
									{
									?>
										To: <?php echo '---------------';
									}											
								}
							?>													
						</td>
					</tr>
					<tr>
						<td>
							Pre-Existing
						</td>
						<td>
							<?php 
								if($products->pre_existing_conditions == "yes")
								{
									echo "Yes";		
								}
								else
								{
									echo "No";
								}
							?>						
						</td>
					</tr>
					<tr>
						<td>
							Enrollment Fee
						</td>
						<td>
							<?php 
								if($products->enrollment_fee != "")
								{
									echo toMoney($products->enrollment_fee);
								}
								else
								{					
									echo chk($products->enrollment_fee);
								}
								?>
						</td>
					</tr>
					<tr>
						<td>
							Monthly Payment
						</td>
						<td>
							<?php 
								if($products->monthly_payment != "")
								{
									echo toMoney($products->monthly_payment);
								}
								else
								{
									echo chk($products->monthly_payment);
								}							
							?>
						</td>
					</tr>
					<tr>
						<td>
							Co-Pay
						</td>
						<td>
							<?php 
								if($products->co_pays != "")
								{
									echo toMoney($products->co_pays);
								}
								else
								{
									echo chk($products->co_pays);
								}							
							?>
						</td>
					</tr>
					<tr>
						<td>
							Specialist Co-Pay
						</td>
						<td>
							<?php 
								if($products->specialist_co_pay != "")
								{
									echo toMoney($products->specialist_co_pay);
								}
								else
								{
									echo chk($products->specialist_co_pay);
								}							
							?>
						</td>
					</tr>
					<tr>
						<td>
							Coinsurance
						</td>
						<td>
							<?php 
								if($products->coinsurance != "")
								{
									echo $products->coinsurance.'%';
								}
								else
								{
									echo chk($products->coinsurance);
								}							
							?>
						</td>
					</tr>
					<tr>
						<td>
							Deductible Amount
						</td>
						<td>
							<?php 
								if($products->deductible_amount != "")
								{
									echo toMoney($products->deductible_amount);
								}
								else
								{
									echo chk($products->deductible_amount);
								}							
							?>
						</td>
					</tr>
					<tr>
						<td>
							Maximum Benefits
						</td>
						<td>
							<?php 
								if($products->maximum_benefits != "")
								{
									echo toMoney($products->maximum_benefits);
								}
								else
								{
									echo chk($products->maximum_benefits);
								}							
							?>
						</td>
					</tr>
					<tr>
						<td>
							Maximum out of pocket
						</td>
						<td>
							<?php 
								if($products->maximum_out_of_pocket != "")
								{
									echo toMoney($products->maximum_out_of_pocket); 
								}
								else
								{
									echo chk($products->maximum_out_of_pocket); 		
								}
							?>
						</td>
					</tr>
					<?php /*
					<tr>
						<td>
							Post Date
						</td>
						<td>
							<?php echo chk($products->post_date); ?>
						</td>
					</tr>
					*/ ?>
					<tr>
						<td>
							Status
						</td>
						<td>
							<?php 
								if($products->is_active == 1)
								{
									echo "Published";
								}
								else
								{
									echo "Not Published";
								}							
							?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	</div>
</div>						
	
<script type="text/javascript">
    $('document').ready(function(){
		$('#products').parents('li').addClass('open');
		$('#products').siblings('.arrow').addClass('open');
		$('#products').parents('li').addClass('active');
		$('<span class="selected"></span>').insertAfter($('#products'));
		$('#view_products').parents('li').addClass('active');
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