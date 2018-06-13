<!-- BEGIN PAGE HEADER-->
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="<?php echo site_url(); ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Add Notification Type</span>
            </li>
        </ul>
        <div class="page-toolbar">
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Add Notification Type </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="icon-bubble font-dark"></i>
            <span class="caption-subject bold uppercase">Add Notification Type</span>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <form class="form-horizontal form-row-seperated" action="<?php echo site_url('notifications/manage_notifications_type/add') ?>" name="notifications_type_form" method="post" id="notifications_type_form">
            <div class="tabbable-bordered">
                        <div class="form-body">
                            <?php
                                if(isset($notifications_type) && $notifications_type != ""){
                                    $notifications_type_id = $notifications_type->notifications_type_id;
                                    $notifications_type_name = $notifications_type->notifications_type_name;
                                    $is_active = $notifications_type->is_active;
                                }else{
                                    $notifications_type_id = "";
                                    $notifications_type_name = "";
                                    $is_active = "";
                                }
                            ?>
                            <input type="hidden" class="form-control" name="notifications_type_id" value="<?php echo $notifications_type_id; ?>" placeholder="">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Notification Type Name:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="notifications_type_name" value="<?php echo $notifications_type_name; ?>" placeholder="">
                                    <span class="help-block"> Provide notification type name </span>
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
                                <?php if($notifications_type_id == ""): ?>
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
        $('#notifications_type').parents('li').addClass('open');
        $('#notifications_type').siblings('.arrow').addClass('open');
        $('#notifications_type').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#notifications_type'));
        $('#add_notifications_type').parents('li').addClass('active');
        $("#notifications_type_form").validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            rules: {
                "notifications_type_name": {
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