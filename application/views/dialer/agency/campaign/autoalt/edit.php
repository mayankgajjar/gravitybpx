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
<div class="msg"></div>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="tabbable-line">
            <?php $this->load->view('dialer/agency/campaign/tabs') ?>
            <div class="tab-content">
                <div class="tab-pane active" id="">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                        <thead>
                            <tr>
                                <th id="first"> <?php echo 'Statuses' ?> </th>
                                <th> &nbsp; </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($autoalts as $key=>$autoalt): ?>
                            <tr id="<?php echo $autoalt ?>">
                                <td>
                                    <input type="hidden" name="id" value="<?php echo encode_url($campaign->campaign_id) ?>" />
                                    <input type="hidden" name="status" value="<?php echo $autoalt; ?>" />
                                    <?php echo $autoalt; ?>
                                </td>
                                <td>
                                    <a onclick="javascript:deleteAll('<?php echo $autoalt ?>')" href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="form">
                        <h3><?php echo 'Add New Auto Alt Number Dialing Status'; ?></h3>
                    <form name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <input type="hidden"  name="campaign_id" value="<?php echo encode_url($campaign->campaign_id); ?>" />
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "Status"; ?></label>
                                <div class="col-md-4">

                                    <select class="form-control" name="status" onchange="javascript:fillHidden(this)">
                                        <?php echo getLeadRecycleStatuses('',$campaign->id) ?>
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
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function(){
     jQuery('.auto-alt').addClass('active');
     jQuery('#datatable').dataTable({
       columnDefs: [
            { width: 200, targets: 0 }
        ],
      "ordering": false,
      "aoColumnDefs": [
            { "sWidth": "20%", "aTargets": [ -1 ] }
        ],
     });
     jQuery("#form").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                status: "required",
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
    function fillHidden(element)
    {
        var option = jQuery(element).find(":selected");
        jQuery('#status').val(option.attr('data-id'));
        jQuery('#status_name').val(option.attr('data-name'));
    }
    function deleteAll(status)
    {
        var inputs = jQuery('#'+status).find('input','select');
        var selects = jQuery('#'+status).find('select');
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
            url: '<?php echo site_url('dialer/acampaign/deletealt') ?>',
            dataType: 'JSON',
            data : obj,
            method: 'POST',
            success: function(result){
                var flag = Boolean(result.success);
                if( flag == true ){
                    var msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.msg +'</div>';
                    location.href = '<?php echo site_url("dialer/acampaign/autoaltedit/".encode_url($campaign->campaign_id)) ?>' ;
                }else{
                    var msg = '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.msg+'</div>';
                }
                jQuery('.msg').html(msg);
            }
        });
    }
</script>
<style>#first{width: auto!important;}</style>