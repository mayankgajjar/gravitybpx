<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $title; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title"><?php echo $title; ?> </h3>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
</div>
<?php endif; ?>
<?php if(validation_errors() != ''): ?>
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <form name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Agency"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <?php  $tree = buildTree($agencies,0); ?>
                        <select name="agency_id" class="form-control" class="agency_id">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <?php echo printTree($tree,0, null, $campaign->agency_id ); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign ID"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="campaign_id" class="form-control" maxlength="8" size="10" value="<?php echo $campaign->campaign_id ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign Name"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="campaign_name" class="form-control" maxlength="30" size="30" value="<?php echo $campaign->campaign_name ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign Description"; ?></label>
                    <div class="col-md-4">
                        <textarea name="campaign_description" class="form-control"><?php echo $campaign->campaign_description ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Active"; ?></label>
                    <div class="col-md-4">
                        <select name="active" id="active" class="form-control">
                            <option value="<?php echo "Y"; ?>" <?php echo optionSetValue($campaign->active,'Y') ?>><?php echo "Yes"; ?></option>
                            <option value="<?php echo "N"; ?>" <?php echo optionSetValue($campaign->active,'N') ?>><?php echo "No"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Park Music-on-Hold"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="park_file_name" class="form-control" value="<?php echo $campaign->park_file_name ?>">
                    </div>
                    <div class="col-md-3">
                        <a href="#"><?php echo "moh chooser"; ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Web Form"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="web_form_address" class="form-control" value="<?php echo $campaign->web_form_address ?>">
                    </div>
                </div>
                <?php if( (bool)get_dialer_option('outbound_autodial_active') == TRUE ) : ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Allow Closers"; ?></label>
                    <div class="col-md-4">
                        <select name="allow_closers" id="allow_closers" class="form-control">
                            <option value="<?php echo "Y"; ?>" <?php echo optionSetValue($campaign->allow_closers,'Y') ?>><?php echo "Yes"; ?></option>
                            <option value="<?php echo "N"; ?>" <?php echo optionSetValue($campaign->allow_closers,'N') ?>><?php echo "No"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Minimum Hopper Level"; ?></label>
                    <div class="col-md-4">
                        <select name="hopper_level" id="hopper_level" class="form-control">
                            <option value="<?php echo 1; ?>"  <?php echo optionSetValue($campaign->hopper_level,'1') ?>><?php echo 1; ?></option>
                            <option value="<?php echo 5; ?>"  <?php echo optionSetValue($campaign->hopper_level,'5') ?>><?php echo 5; ?></option>
                            <option value="<?php echo 10; ?>" <?php echo optionSetValue($campaign->hopper_level,'10') ?>><?php echo 10; ?></option>
                            <option value="<?php echo 20; ?>" <?php echo optionSetValue($campaign->hopper_level,'20') ?>><?php echo 20; ?></option>
                            <option value="<?php echo 50; ?>" <?php echo optionSetValue($campaign->hopper_level,'50') ?>><?php echo 50; ?></option>
                            <option value="<?php echo 100; ?>" <?php echo optionSetValue($campaign->hopper_level,'100') ?>><?php echo 100; ?></option>
                            <option value="<?php echo 200; ?>" <?php echo optionSetValue($campaign->hopper_level,'200') ?>><?php echo 200; ?></option>
                            <option value="<?php echo 500; ?>"  <?php echo optionSetValue($campaign->hopper_level,'500') ?>><?php echo 500; ?></option>
                            <option value="<?php echo 1000; ?>" <?php echo optionSetValue($campaign->hopper_level,'1000') ?>><?php echo 1000; ?></option>
                            <option value="<?php echo 2000; ?>" <?php echo optionSetValue($campaign->hopper_level,'2000') ?>><?php echo 2000; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Auto Dial Level"; ?></label>
                    <div class="col-md-4">
                        <?php $limit = get_dialer_option('auto_dial_limit'); ?>
                        <select name="auto_dial_level" id="auto_dial_level" class="form-control">
                            <?php $adl = 0; ?>
                            <?php while( $adl <= $limit ): ?>
                            <option value="<?php echo $adl ?>" <?php echo optionSetValue($campaign->auto_dial_level,$adl) ?>><?php echo $adl ?></option>
                                <?php
				if ($adl < 1)
					{$adl = ($adl + 1);}
				else
					{
					if ($adl < 3)
						{$adl = ($adl + 0.1);}
					else
						{
						if ($adl < 4)
							{$adl = ($adl + 0.25);}
						else
							{
							if ($adl < 5)
								{$adl = ($adl + 0.5);}
							else
								{
								if ($adl < 10)
									{$adl = ($adl + 1);}
								else
									{
									if ($adl < 20)
										{$adl = ($adl + 2);}
									else
										{
										if ($adl < 40)
											{$adl = ($adl + 5);}
										else
											{
											if ($adl < 200)
												{$adl = ($adl + 10);}
											else
												{
												if ($adl < 400)
													{$adl = ($adl + 50);}
												else
													{
													if ($adl < 1000)
														{$adl = ($adl + 100);}
													else
														{$adl = ($adl + 1);}
													}
												}
											}
										}
									}
								}
							}
						}
					}

                                ?>
                            <?php endwhile; ?>
                        </select>
                        <span class="help-block"> <?php echo '(0 = off)' ?>  </span>
                    </div>
                </div>
            <?php endif; ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Next Agent Call"; ?></label>
                    <div class="col-md-4">
                        <select name="next_agent_call" id="next_agent_call" class="form-control">
                            <option value="<?php echo "random"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'random') ?>><?php echo "random"; ?></option>
                            <option value="<?php echo "oldest_call_start"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'oldest_call_start') ?>><?php echo "oldest_call_start"; ?></option>
                            <option value="<?php echo "oldest_call_finish"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'oldest_call_finish') ?>><?php echo "oldest_call_finish"; ?></option>
                            <option value="<?php echo "campaign_rank"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'campaign_rank') ?>><?php echo "campaign_rank"; ?></option>
                            <option value="<?php echo "overall_user_level"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'overall_user_level') ?>><?php echo "overall_user_level"; ?></option>
                            <option value="<?php echo "fewest_calls"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'fewest_calls') ?>><?php echo "fewest_calls"; ?></option>
                            <option value="<?php echo "longest_wait_time"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'longest_wait_time') ?>><?php echo "longest_wait_time"; ?></option>
                            <option value="<?php echo "campaign_grade_random"; ?>" <?php echo optionSetValue($campaign->next_agent_call,'campaign_grade_random') ?>><?php echo "campaign_grade_random"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Local Call Time"; ?></label>
                    <div class="col-md-4">
                        <select name="local_call_time" id="local_call_time" class="form-control">
                            <?php echo get_local_call_times($campaign->local_call_time); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Voicemail"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="voicemail_ext" class="form-control" maxlength="10" value="<?php echo $campaign->voicemail_ext; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Script"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="campaign_script">
                            <?php echo get_scripts_options($campaign->campaign_script); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Get Call Launch"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="get_call_launch">
                            <option value="None" <?php echo optionSetValue($campaign->get_call_launch,'None') ?>><?php echo "None"; ?></option>
                            <option value="SCRIPT" <?php echo optionSetValue($campaign->get_call_launch,'SCRIPT') ?>><?php echo "SCRIPT"; ?></option>
                            <option value="WEBFORM" <?php echo optionSetValue($campaign->get_call_launch,'WEBFORM') ?>><?php echo "WEBFORM"; ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn blue" type="submit"><?php echo 'Submit' ?></button>
                        <button class="btn btn-circle grey-salsa btn-outline" type="button" onclick="location.href='<?php site_url('dialer/campaign/index') ?>'">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    jQuery(function(){
     jQuery("#form").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                agency_id: "required",
                campaign_name: "required",
                campaign_id: {
                    required: true,
                    maxlength: 6
                },

            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });
    });
</script>
