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
                                <th><?php echo 'Agent<br/>Selectable'; ?></th>
                                <th><?php echo 'Human<br/>Answer'; ?></th>
                                <th><?php echo 'Sale'; ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th><?php echo 'DNC'; ?>&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th><?php echo 'Customer<br/>Contact'; ?></th>
                                <th><?php echo 'Not<br/>Interested'; ?></th>
                                <th><?php echo 'Unworkable'; ?></th>
                                <th><?php echo 'Scheduled<br/>Callback'; ?></th>
                                <th><?php echo 'Completed'; ?></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($statuses as $status): ?>
                            <tr id="status-<?php echo $status->status ?>">
                                <td>&nbsp;&nbsp;<?php echo $status->status; ?>&nbsp;&nbsp;</td>
                                <td>
                                    <input type="hidden" name="id" value="<?php echo encode_url($status->id); ?>" />
                                    <input type="hidden" name="model" value="<?php echo 'dcstatuses_m'; ?>" />
<!--                                    <input type="hidden" name="campaign_id" value="<?php echo encode_url($status->campaign_id) ?>" />-->
                                    <input value="<?php echo $status->status_name; ?>" name="status_name" class="form-control" /></td>
                                <td>
                                    <select name="category" class="form-control">
                                        <option value="" selected="">-</option>
                                        <?php foreach($categories as $category): ?>
                                            <option value="<?php echo $category->id; ?>" <?php echo optionSetValue($category->id, $status->category) ?>><?php echo $category->vsc_id; ?></option>
                                         <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="selectable" id="selectable" class="form-control">
                                         <option value="<?php echo "Y"; ?>" <?php echo optionSetValue('Y', $status->selectable) ?>><?php echo "Y"; ?></option>
                                         <option value="<?php echo "N"; ?>" <?php echo optionSetValue('N', $status->selectable) ?>><?php echo "N"; ?></option>
                                     </select>
                                </td>
                                <td>
                                    <select name="human_answered" id="human_answered" class="form-control">
                                         <option value="<?php echo "Y"; ?>" <?php echo optionSetValue('Y', $status->human_answered) ?>><?php echo "Y"; ?></option>
                                         <option value="<?php echo "N"; ?>" <?php echo optionSetValue('N', $status->human_answered) ?>><?php echo "N"; ?></option>
                                     </select>
                                </td>
                                <td>
                                    <select name="sale" id="sale" class="form-control">
                                         <option value="<?php echo "Y"; ?>" <?php echo optionSetValue('Y', $status->sale) ?>><?php echo "Y"; ?></option>
                                         <option value="<?php echo "N"; ?>" <?php echo optionSetValue('N', $status->sale) ?>><?php echo "N"; ?></option>
                                     </select>
                                </td>
                                <td>
                                    <select name="dnc" id="dnc" class="form-control">
                                         <option value="<?php echo "Y"; ?>" <?php echo optionSetValue('Y', $status->dnc) ?>><?php echo "Y"; ?></option>
                                         <option value="<?php echo "N"; ?>" <?php echo optionSetValue('N', $status->dnc) ?>><?php echo "N"; ?></option>
                                     </select>
                                </td>
                                <td>
                                    <select name="customer_contact" id="customer_contact" class="form-control">
                                         <option value="<?php echo "Y"; ?>" <?php echo optionSetValue('Y', $status->customer_contact) ?>><?php echo "Y"; ?></option>
                                         <option value="<?php echo "N"; ?>" <?php echo optionSetValue('N', $status->customer_contact) ?>><?php echo "N"; ?></option>
                                     </select>
                                </td>
                                <td>
                                    <select name="not_interested" id="not_interested" class="form-control">
                                         <option value="<?php echo "Y"; ?>" <?php echo optionSetValue('Y', $status->not_interested) ?>><?php echo "Y"; ?></option>
                                         <option value="<?php echo "N"; ?>" <?php echo optionSetValue('N', $status->not_interested) ?>><?php echo "N"; ?></option>
                                     </select>
                                </td>
                                <td>
                                    <select name="unworkable" id="unworkable" class="form-control">
                                         <option value="<?php echo "Y"; ?>" <?php echo optionSetValue('Y', $status->unworkable) ?>><?php echo "Y"; ?></option>
                                         <option value="<?php echo "N"; ?>" <?php echo optionSetValue('N', $status->unworkable) ?>><?php echo "N"; ?></option>
                                     </select>
                                </td>
                                <td>
                                    <select name="scheduled_callback" id="scheduled_callback" class="form-control">
                                         <option value="<?php echo "Y"; ?>" <?php echo optionSetValue('Y', $status->scheduled_callback) ?>><?php echo "Y"; ?></option>
                                         <option value="<?php echo "N"; ?>" <?php echo optionSetValue('N', $status->scheduled_callback) ?>><?php echo "N"; ?></option>
                                     </select>
                                </td>
                                <td>
                                    <select name="completed" id="completed" class="form-control">
                                         <option value="<?php echo "Y"; ?>" <?php echo optionSetValue('Y', $status->completed) ?>><?php echo "Y"; ?></option>
                                         <option value="<?php echo "N"; ?>" <?php echo optionSetValue('N', $status->completed) ?>><?php echo "N"; ?></option>
                                     </select>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onclick="javascript:edit('<?php echo $status->status ?>')"><i aria-hidden="true" class="fa  fa-pencil-square-o"></i></a>&nbsp;
                                    <a href="javascript:void(0)" onclick="javascript:deleteAll('<?php echo $status->status ?>')"><i aria-hidden="true" class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="form">
                        <h3><?php echo 'Add New Custom Campaign Status'; ?></h3>
                        <form name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                         <div class="form-body">
                             <input type="hidden" name="campaign_id" value="<?php echo encode_url($campaign->id) ?>" />
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Status Id"; ?><span class="required"> * </span></label>
                                 <div class="col-md-4">
                                     <input type="text" name="status" class="form-control">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Status Name"; ?><span class="required"> * </span></label>
                                 <div class="col-md-4">
                                     <input type="text" name="status_name" class="form-control">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Agent Selectable"; ?></label>
                                 <div class="col-md-4">
                                     <select name="selectable" id="selectable" class="form-control">
                                         <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                                         <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Human Answer"; ?></label>
                                 <div class="col-md-4">
                                     <select name="human_answered" id="human_answered" class="form-control">
                                         <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                                         <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Sale"; ?>    </label>
                                 <div class="col-md-4">
                                     <select name="sale" id="sale" class="form-control">
                                         <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                                         <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "DNC"; ?></label>
                                 <div class="col-md-4">
                                     <select name="dnc" id="dnc" class="form-control">
                                         <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                                         <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Customer Contact"; ?></label>
                                 <div class="col-md-4">
                                     <select name="customer_contact" id="customer_contact" class="form-control">
                                         <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                                         <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Not Interested"; ?></label>
                                 <div class="col-md-4">
                                     <select name="not_interested" id="not_interested" class="form-control">
                                         <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                                         <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Unworkable"; ?></label>
                                 <div class="col-md-4">
                                     <select name="unworkable" id="unworkable" class="form-control">
                                         <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                                         <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Callback"; ?></label>
                                 <div class="col-md-4">
                                     <select name="scheduled_callbacks" id="scheduled_callback" class="form-control">
                                         <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                                         <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Completed"; ?></label>
                                 <div class="col-md-4">
                                     <select name="completed" id="completed" class="form-control">
                                         <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                                         <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
                                     </select>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Completed"; ?></label>
                                 <div class="col-md-4">
                                     <select name="category" id="category" class="form-control">
                                         <option value=""><?php echo '-' ?></option>
                                         <?php foreach($categories as $category): ?>
                                         <option value="<?php $category->id; ?>"><?php echo $category->vsc_id; ?></option>
                                         <?php endforeach; ?>
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