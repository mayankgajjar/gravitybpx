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
                        <select name="agency_id" class="form-control" class="agency_id">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <?php echo get_menu($agencies) ?>
<!--                             <?php foreach ($agencies as $key => $agency) :  ?>
                                <option name="<?php echo $agency['id']; ?>"><?php echo $agency['name']; ?></option>
                            <?php endforeach; ?>
 -->                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign ID"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="campaign_id" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign Name"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="campaign_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign Description"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <textarea name="campaign_desc" class="form-control"> </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Agent Groups"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <select name="agent_group" id="agent_group" class="form-control">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Active"; ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <select name="active" id="active" class="form-control">
                            <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                            <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Park Music-on-Hold"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="campaign_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Web Form"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="campaign_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Allow Closers"; ?></label>
                    <div class="col-md-4">
                        <select name="active" id="active" class="form-control">
                            <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                            <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Minimum Hopper Level"; ?></label>
                    <div class="col-md-4">
                        <select name="active" id="active" class="form-control">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Auto Dial Level"; ?></label>
                    <div class="col-md-4">
                        <select name="active" id="active" class="form-control">
                        </select>
                        <span class="help-block"> <?php echo '(0 = off)' ?>  </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Next Agent Call"; ?></label>
                    <div class="col-md-4">
                        <select name="active" id="active" class="form-control">
                            <option value="<?php echo "random"; ?>"><?php echo "random"; ?></option>
                            <option value="<?php echo "oldest_call_start"; ?>"><?php echo "oldest_call_start"; ?></option>
                            <option value="<?php echo "oldest_call_finish"; ?>"><?php echo "oldest_call_finish"; ?></option>
                            <option value="<?php echo "campaign_rank"; ?>"><?php echo "campaign_rank"; ?></option>
                            <option value="<?php echo "overall_user_level"; ?>"><?php echo "overall_user_level"; ?></option>
                            <option value="<?php echo "fewest_calls"; ?>"><?php echo "fewest_calls"; ?></option>
                            <option value="<?php echo "longest_wait_time"; ?>"><?php echo "longest_wait_time"; ?></option>
                            <option value="<?php echo "campaign_grade_random"; ?>"><?php echo "campaign_grade_random"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Local Call Time"; ?></label>
                    <div class="col-md-4">
                        <select name="active" id="active" class="form-control">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Voicemail"; ?></label>
                    <div class="col-md-4">
                            <input type="text" name="campaign_name" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Script"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="script">
                            <option value=""><?php echo "None"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Get Call Launch"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="script">
                            <option value=""><?php echo "None"; ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn blue" type="submit"><?php echo 'Submit' ?></button>
                        <button class="btn btn-circle grey-salsa btn-outline" type="button">Cancel</button>
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
                    minlength: 6
                },
                // password: {
                //     required: true,
                //     minlength: 5
                // },
                // confirm_password: {
                //     required: true,
                //     minlength: 5,
                //     equalTo: "#password"
                // },
                // email: {
                //     required: true,
                //     email: true
                // },
                // topic: {
                //     required: "#newsletter:checked",
                //     minlength: 2
                // },
                // agree: "required"
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            // messages: {
            //     firstname: "Please enter your firstname",
            //     lastname: "Please enter your lastname",
            //     username: {
            //         required: "Please enter a username",
            //         minlength: "Your username must consist of at least 2 characters"
            //     },
            //     password: {
            //         required: "Please provide a password",
            //         minlength: "Your password must be at least 5 characters long"
            //     },
            //     confirm_password: {
            //         required: "Please provide a password",
            //         minlength: "Your password must be at least 5 characters long",
            //         equalTo: "Please enter the same password as above"
            //     },
            //     email: "Please enter a valid email address",
            //     agree: "Please accept our policy"
            // }
        });
    });
</script>