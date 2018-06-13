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
<h3 class="page-title"><?php echo $pagetitle; ?> </h3>

<?php if(validation_errors() != ''): ?>
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-settings font-dark"></i>
			<span class="caption-subject font-dark sbold uppercase"><?php echo $title; ?></span>
		</div>
	</div>
	<div class="portlet-body form">
		<form class="form-horizontal" id="commentForm" method="post">
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo "Name"; ?><span class="required"> * </span></label>
					<div class="col-md-4">
						<input class="form-control" type="text" name="name" value="<?php echo $template->name; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo "Event"; ?><span class="required"> * </span></label>
					<div class="col-md-4">
						<?php $eventsData = $this->config->item('mail_events') ?>
						<select class="form-control" name="event" id="event" onChange="javascript:ajaxVarible(this.value)">
							<option value="">Please Select</option>
							<?php foreach( $eventsData as $k => $events ): ?>
								 <optgroup label="<?php echo $k ?>">
								 	<?php foreach ($events as $key => $event): ?>
										<option data-module="<?php echo $k; ?>" value="<?php echo $key; ?>" <?php echo $key == $template->event ? 'selected="selected"':''; ?>><?php echo $event ?></option>
									<?php endforeach; ?>		
								</optgroup>	
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo "Subject"; ?><span class="required"> * </span></label>
					<div class="col-md-4">
						<input class="form-control" id="subject" type="text" name="subject" value="<?php echo $template->subject; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo "Body"; ?><span class="required"> * </span></label>
					 <a href="" id="var-url" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ajax" style="padding: 0px 5px;">Add variable</a>
					<div class="col-md-7">
						<textarea class="form-control ckeditor" name="body" rows="50" data-error-container="#editor2_error"><?php echo $template->body ?></textarea>						
						<div id="editor2_error"> </div>
					</div>
				</div>										      

		   </div>
			<div class="form-actions">
				<div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn green" type="submit">Submit</button>
                        <a class="btn default" href="<?php echo site_url('adm/email_template');?>">Cancel</a>
                    </div>
                </div>				
			</div>
		</form>
	</div>
</div>
<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo base_url() ?>assets/images/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
<script>
$(".email_template").addClass('active');

jQuery(function(){
		jQuery("#commentForm").validate({			
			rules: {
				name: "required",
				subject : "required",
				event : "required",
				body: "required",
			},
 			errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input			
            invalidHandler: function (event, validator) { //display error alert on form submit              
                    //success1.hide();
                    //error1.show();
                    //App.scrollTo(error1, -200);
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                      .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                     .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                 label
                     .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
		    errorPlacement: function (error, element) { // render error placement for each input type
		        if (element.parent(".input-group").size() > 0) {
		            error.insertAfter(element.parent(".input-group"));
		        } else if (element.attr("data-error-container")) { 
		            error.appendTo(element.attr("data-error-container"));
		        } else if (element.parents('.radio-list').size() > 0) { 
		            error.appendTo(element.parents('.radio-list').attr("data-error-container"));
		        } else if (element.parents('.radio-inline').size() > 0) { 
		            error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
		        } else if (element.parents('.checkbox-list').size() > 0) {
		            error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
		        } else if (element.parents('.checkbox-inline').size() > 0) { 
		            error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
		        } else {
		            error.insertAfter(element); // for other inputs, just perform default behavior
		        }
		    },  
            submitHandler: function (form) {
                 success1.show();
                 error1.hide();
            }            
		});	
        jQuery(document).on('click','#add_var',function () {
            var field = $('#sel_field').val();
            var f = $("input[type=radio]:checked").val();
            if (typeof f !== typeof undefined && f !== false) {
                if (field == 'subject') {
                    var html = $('#' + field);
                    var t = $(html).val();
                    var newtext = t + " " + f;
                    $('#' + field).val(newtext);
                } else {
                    var html = CKEDITOR.instances['body'].getData();
                    var newtext = html + " " + f;
                    CKEDITOR.instances[field].setData(newtext);
                }
            }
            $("#myModal input[type=radio]:checked").removeAttr('checked');
            $('#myModal').modal('hide');
        });
        <?php if( $template->id ): ?>        
     		$module = jQuery('#event :selected').data('module');   	
     		console.log($module);
        	ajaxVarible($module);
        <?php endif; ?>
});

function ajaxVarible(value){
	 $module = jQuery('#event :selected').data('module');
	 var res = $module.replace(" ", "_");
	 $url = '<?php echo site_url('adm/email_template/setvariable') ?>'+'/'+res;	 
	 jQuery('#var-url').attr('href',$url);
}
</script>
