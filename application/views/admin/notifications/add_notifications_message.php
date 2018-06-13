    <!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Add Notification Message</span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Add Notification Message </h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="icon-bubble font-dark"></i>
            <span class="caption-subject bold uppercase">Add Notification Message</span>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal form-row-seperated" action="<?php echo site_url('notifications/manage_notifications_message/add') ?>" name="notifications_message_form" method="post" id="notifications_message_form">
            <div class="tabbable-bordered">
                        <div class="form-body">
                            <?php
                                if(isset($notifications_message) && $notifications_message != ""){
                                    $notifications_type_id = $notifications_message->notifications_type_id;
                                    $notifications_message_id = $notifications_message->notifications_message_id;
                                    $notifications_message_title = $notifications_message->notifications_message_title;
                                    $notifications_message_content = $notifications_message->notifications_message_content;
                                    $is_active = $notifications_message->is_active;
                                }else{
                                    $notifications_type_id = "";
                                    $notifications_message_id = "";
                                    $notifications_message_title = "";
                                    $notifications_message_content = "";
                                    $is_active = "";
                                }
                            ?>
                            <input type="hidden" class="form-control" name="notifications_message_id" value="<?php echo $notifications_message_id; ?>" placeholder="">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Notification Type:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <select name="notifications_type_id" id="notifications_type_id" class="form-control">
                                        <option value="">Select Notification Type</option>
                                        <?php foreach ($notifications_type as $value) : ?>
                                                <option <?php if(isset($notifications_message) && $value['notifications_type_id'] == $notifications_message->notifications_type_id){ echo "selected"; }else{ echo ""; } ?> value="<?php echo $value['notifications_type_id'] ?>">
                                                    <?php echo $value['notifications_type_name'] ?>
                                                </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block"> Select notification type </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Notification Message Title:</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="notifications_message_title" value="<?php echo $notifications_message_title; ?>" placeholder="">
                                    <span class="help-block"> Provide notification message title </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Notification Message:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="notifications_message_content"><?php echo $notifications_message_content; ?></textarea>
                                    <span class="help-block"> Provide notification message </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Status:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <select class="table-group-action-input form-control" name="is_active">
                                        <option <?php if($is_active == ""){ echo "selected"; } ?> value="">Select Status</option>
                                        <option <?php if($is_active == 1){ echo "selected"; }else{ echo ""; } ?> value="1">Enable</option>
                                        <option <?php if($is_active == 2){ echo "selected"; }else{ echo ""; } ?> value="2">Disable</option>
                                    </select>
                                    <span class="help-block"> Select status </span>
                                </div>
                            </div>
                        </div>

                     <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="actions btn-set">
                                <?php if($notifications_message_id == ""): ?>
                                <button type="reset" class="btn btn-secondary-outline">
                                    <i class="fa fa-reply"></i> Reset
                                </button>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('document').ready(function(){
        $('#notifications').parents('li').addClass('open');
        $('#notifications').siblings('.arrow').addClass('open');
        $('#notifications_message').parents('li').addClass('open');
        $('#notifications_message').siblings('.arrow').addClass('open');
        $('#notifications_message').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#notifications_message'));
        $('#add_notifications_message').parents('li').addClass('active');
        $("#notifications_message_form").validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            rules: {
                "notifications_type_id": {
                    required: true
                },
                "notifications_message_title": {
                    required: false
                },
                "notifications_message_content": {
                    required: true
                },
                "is_active":{
                    required: true
                }
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function (element){
                $(element).closest('.form-group').removeClass('has-error');
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element){
               error.insertAfter(element); // for other inputs, just perform default behavior
            },
            submitHandler: function(form) {
                success.show();
                error.hide();
                form.submit();
            }
        });
    });
</script>