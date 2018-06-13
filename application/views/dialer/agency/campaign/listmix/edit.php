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
<div class="msg"></div>
<h3 class="page-title"><?php echo $title; ?> </h3>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="tabbable-line">
            <?php $this->load->view('dialer/admin/campaign/tabs') ?>
            <div class="tab-content">
                <div class="tab-pane active" id="">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                        <thead>
                            <tr>
                                <th id="first"><?php echo 'Status'; ?></th>
                                <th><?php echo 'Description'; ?></th>
                                <th><?php echo 'Category'; ?></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div class="form">
                        <h3><?php echo 'Ad New List Mix'; ?></h3>
                        <form name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                         <div class="form-body">
                             <input type="hidden" name="campaign_id" value="<?php echo encode_url($campaign->id) ?>" />
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Mix Id"; ?><span class="required"> * </span></label>
                                 <div class="col-md-4">
                                     <input type="text" name="vcl_id" class="form-control">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Status Name"; ?><span class="required"> * </span></label>
                                 <div class="col-md-4">
                                     <input type="text" name="vcl_name" class="form-control">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Mix Method"; ?></label>
                                 <div class="col-md-4">
                                     <select name="mix_method" id="mix_method" class="form-control">
                                         <option value="<?php echo "EVEN_MIX"; ?>"><?php echo "EVEN_MIX"; ?></option>
                                         <option value="<?php echo "IN_ORDER"; ?>"><?php echo "IN_ORDER"; ?></option>
                                         <option value="<?php echo "RANDOM"; ?>"><?php echo "RANDOM"; ?></option>
                                     </select>
                                 </div>
                             </div>
                         </div>
                         <div class="form-actions">
                             <div class="row">
                                 <div class="col-md-offset-3 col-md-9">
                                     <button class="btn blue" type="submit"><?php echo 'Submit' ?></button>
<!--                                     <button class="btn btn-circle grey-salsa btn-outline" type="button">Cancel</button>-->
                                 </div>
                             </div>
                         </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery('.status').addClass('active');
    jQuery(function(){
     jQuery('#datatable').dataTable({
       columnDefs: [
            { width: 200, targets: 0 }
        ],
   "ordering": false,
   "aoColumnDefs": [
            { "sWidth": "20%", "aTargets": [ -1 ] }
        ],
     });
//     jQuery("#form").validate({
//            errorElement: 'span', //default input error message container
//            errorClass: 'help-block help-block-error', // default input error message class
//            focusInvalid: false, // do not focus the last invalid input
//            ignore: "", // validate all fields including form hidden input
//            rules: {
//                agency_id: "required",
//                campaign_name: "required",
//                campaign_id: {
//                    required: true,
//                    minlength: 6
//                },
//                // password: {
//                //     required: true,
//                //     minlength: 5
//                // },
//                // confirm_password: {
//                //     required: true,
//                //     minlength: 5,
//                //     equalTo: "#password"
//                // },
//                // email: {
//                //     required: true,
//                //     email: true
//                // },
//                // topic: {
//                //     required: "#newsletter:checked",
//                //     minlength: 2
//                // },
//                // agree: "required"
//            },
//            highlight: function (element) { // hightlight error inputs
//                 $(element)
//                        .closest('.form-group').addClass('has-error'); // set error class to the control group
//            },
//            // messages: {
//            //     firstname: "Please enter your firstname",
//            //     lastname: "Please enter your lastname",
//            //     username: {
//            //         required: "Please enter a username",
//            //         minlength: "Your username must consist of at least 2 characters"
//            //     },
//            //     password: {
//            //         required: "Please provide a password",
//            //         minlength: "Your password must be at least 5 characters long"
//            //     },
//            //     confirm_password: {
//            //         required: "Please provide a password",
//            //         minlength: "Your password must be at least 5 characters long",
//            //         equalTo: "Please enter the same password as above"
//            //     },
//            //     email: "Please enter a valid email address",
//            //     agree: "Please accept our policy"
//            // }
//        });
    });
    function edit(status)
    {
        var inputs = jQuery('#status-'+status).find('input','select');
        var selects = jQuery('#status-'+status).find('select');
        var obj = {};
        inputs.each(function(){
            var name = jQuery(this).attr('name');
            obj[name] = jQuery(this).val();
        });
        selects.each(function(){
            var name = jQuery(this).attr('name');
            obj[name] = jQuery(this).val();
        });

        jQuery.ajax({
            url: '<?php echo site_url('dialer/campaign/ajaxedit/') ?>',
            dataType: 'JSON',
            data : obj,
            method: 'POST',
            success: function(result){
                var flag = Boolean(result.success);
                if( flag == true ){
                    var msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.msg +'</div>';
                    location.reload();
                }else{
                    var msg = '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.msg+'</div>';
                }
                jQuery('.msg').html(msg);
            }
        });
    }
    function deleteAll(status)
    {
        var inputs = jQuery('#status-'+status).find('input','select');
        var selects = jQuery('#status-'+status).find('select');
        var obj = {};
        inputs.each(function(){
            var name = jQuery(this).attr('name');
            obj[name] = jQuery(this).val();
        });
        selects.each(function(){
            var name = jQuery(this).attr('name');
            obj[name] = jQuery(this).val();
        });

        jQuery.ajax({
            url: '<?php echo site_url('dialer/campaign/deleteall') ?>',
            dataType: 'JSON',
            data : obj,
            method: 'POST',
            success: function(result){
                var flag = Boolean(result.success);
                if( flag == true ){
                    var msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.msg +'</div>';
                    location.reload();
                }else{
                    var msg = '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.msg+'</div>';
                }
                jQuery('.msg').html(msg);
            }
        });
    }
</script>
<style>#first{width: auto!important;}</style>