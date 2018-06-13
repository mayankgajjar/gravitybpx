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
            <?php $this->load->view('dialer/admin/campaign/tabs') ?>
            <div class="tab-content">
                <div class="tab-pane active" id="">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                        <thead>
                            <tr>
                                <th id="first"> <?php echo 'Pause Code' ?> </th>
                                <th id="first"> <?php echo 'Pause Code Name' ?> </th>
                                <th id="first"> <?php echo 'Billable' ?> </th>
                                <th> &nbsp; </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($pausecodes as $key=>$pausecode): ?>
                            <tr id="code-<?php echo $pausecode->id ?>">
                                <td>
                                    <input type="hidden" name="id" value="<?php echo encode_url($pausecode->id) ?>" />
                                    <input type="hidden" name="model" value="<?php echo 'dpausecode_m' ?>" />
                                    <?php echo $pausecode->pause_code; ?>
                                </td>
                                <td>
                                    <input name="pause_code_name" maxlength="30" size="20" class="form-control" value="<?php echo $pausecode->pause_code_name; ?>"/>
                                </td>
                                <td>
                                    <select name="billable" class="form-control">
                                        <option value="<?php echo 'YES' ?>" <?php echo optionSetValue('YES', $pausecode->billable) ?>><?php echo 'YES' ?></option>
                                        <option value="<?php echo 'NO' ?>" <?php echo optionSetValue('NO', $pausecode->billable) ?>><?php echo 'NO' ?></option>
                                        <option value="<?php echo 'HALF' ?>" <?php echo optionSetValue('HALF', $pausecode->billable) ?>><?php echo 'HALF' ?></option>
                                    </select>
                                </td>
                                <td>
                                    <a onclick="javascript:edit('<?php echo $pausecode->id ?>')" href="javascript:void(0)"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                    <a onclick="javascript:deleteAll('<?php echo $pausecode->id ?>')" href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="form">
                        <h3><?php echo 'Add New Auto Alt Number Dialing Status'; ?></h3>
                    <form name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <input type="hidden"  name="campaign_id" value="<?php echo encode_url($campaign->id); ?>" />
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo 'Pause Code' ?><span class="required">*</span></label>
                                <div class="col-md-4">
                                    <input name="pause_code" maxlength="6" size="8" class="form-control"  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo 'Pause Code Name' ?><span class="required">*</span></label>
                                <div class="col-md-4">
                                    <input name="pause_code_name"  maxlength="30" size="20" class="form-control"  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "Status"; ?><span class="required">*</span></label>
                                <div class="col-md-4">
                                    <select class="form-control" name="billable">
                                        <option value="<?php echo 'YES' ?>"><?php echo 'YES' ?></option>
                                        <option value="<?php echo 'NO' ?>"><?php echo 'NO' ?></option>
                                        <option value="<?php echo 'HALF' ?>"><?php echo 'HALF' ?></option>
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
     jQuery('.pause-code').addClass('active');
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
                pause_code: {
                    required : true,
                    maxlength : 6
                },
                pause_code_name: {
                    required : true,
                    maxlenght: 30
                },
                billable: "required",
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });
    });
    function edit(status)
    {
        var inputs = jQuery('#code-'+status).find('input','select');
        var selects = jQuery('#code-'+status).find('select');
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
            url: 'http://localhost/crm/dialer/campaign/ajaxedit',
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
        var inputs = jQuery('#code-'+status).find('input','select');
        var selects = jQuery('#code-'+status).find('select');
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