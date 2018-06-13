<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="assets/theam_assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<script src="assets/theam_assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
<!-- BEGIN SAMPLE FORM PORTLET-->
<form class="form-horizontal" action="" id="submit_form" method="POST" enctype='multipart/form-data'>
		
	<div class="form-group" id='responsive'>
		<label class="control-label col-md-3">Non-Resident License State
		</label>
		<!-- Non-resident state model -->
		<div class="row">
			<div class="checkbox-list">
				<?php
					foreach($states as $state)
					{
						?>
						<div class='col-sm-6 col-md-4 col-lg-3'>
							<label>
								<input class='states' type="checkbox" name="nonresident_license_stat[]" value="<?php echo $state['id'] ?>" data-title="<?php echo $state['name'] ?>" /><?php echo $state['name'] ?>
							</label>
						</div>
						<?php
					}
				?>
			</div>
			<div class='col-sm-9'>
				<button type="button" style='float:left' id='select_all' class="btn btn-outline">Select All</button>
				<button type="button" style='float:left' id='deselect_all' class="btn btn-outline">Deselect All</button>
			</div>
		</div>
	</div>
	<div class='row'>
		<input type='submit' id='submit' class='form-control'>
	</div>
</form>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/theam_assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/pages/scripts/jquery.maskedinput.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="assets/theam_assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/pages/scripts/form-wizard.js" type="text/javascript"></script>
<script src="assets/theam_assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
<script src="assets/theam_assets/pages/scripts/form-dropzone.js" type="text/javascript"></script>
<script type="text/javascript">
    $('document').ready(function(){
		$('#responsive').on('click','#select_all',function(){
			// $('.states').each(function(){
				// $(this).closest('span').addClass('checked');
				// $(this).attr('checked',true);
				// $.uniform.update($(this));
			// });
			$('.states').closest('span').addClass('checked');
			$('.states').prop('checked',true);
			$.uniform.update();
		});
		
		$('#responsive').on('click','#deselect_all',function(){
			$('.states').closest('span').removeClass('checked');
			$('.states').prop('checked',false);
		});
		
		$('#submit').click(function(){
			$('.states:checked').each(function(){
				alert($(this).val());
			});
			alert('hii');
			return false;
		})
	});
</script>