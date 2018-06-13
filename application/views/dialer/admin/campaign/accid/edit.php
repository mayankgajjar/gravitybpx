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
                                <th id="first"> <?php echo '#' ?> </th>
                                <th> <?php echo 'Areadcode' ?> </th>
                                <th> <?php echo 'CID Number' ?> </th>
                                <th> <?php echo 'Description' ?> </th>
                                <th> <?php echo 'Active' ?> </th>
                                <th>  <?php echo 'Calls'; ?> </th>
                                <th> &nbsp; </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach($areacodes as $code): ?>
                            <tr id="accid-<?php echo $code->id ?>">
                                <td>
                                    <input type="hidden" name="id" value="<?php echo encode_url($code->id); ?>" />
                                    <input type="hidden" name="model" value="<?php echo 'dcareacode_m'; ?>" />
                                    <?php echo $i; ?></td>
                                <td><?php echo $code->areacode; ?></td>
                                <td><?php echo $code->outbound_cid; ?></td>
                                <td>
                                    <input type="text" name="cid_description" value="<?php echo $code->cid_description; ?>" maxlength="100" />
                                </td>
                                <td>
                                    <input type="checkbox" name="click" class="form-control" onclick="javascript:putActive(this,'<?php echo $code->id ?>')" <?php echo $code->active == 'Y' ? 'checked="checked"':'' ?> />
                                    <input type="hidden" name="active" value="N" id="active-<?php echo $code->id ?>"/>
                                </td>
                                <td><?php echo $code->call_count_today; ?></td>
                                <td>
                                    <a onclick="javascript:edit('<?php echo $code->id ?>')" href="javascript:void(0)"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <a onclick="javascript:deleteAll('<?php echo $code->id ?>')" href="javascript:void(0)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                                <?php $i++ ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="form">
                        <h3><?php echo 'Add New Custom Campaign Status'; ?></h3>
                    <form name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <input type="hidden"  name="campaign_id" value="<?php echo encode_url($campaign->id); ?>" />
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "Areacode"; ?><span class="required"> * </span></label>
                                <div class="col-md-4">
                                    <input type="text" name="areacode" class="form-control" maxlength="5" size="7"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "Outbound CID"; ?><span class="required"> * </span></label>
                                <div class="col-md-4">
                                    <input type="text" name="outbound_cid" class="form-control" maxlength="20" size="20"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo 'Description'; ?></label>
                                <div class="col-md-4">
                                    <input type="text" name="cid_description" class="form-control"  maxlength="100"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn blue" type="submit"><?php echo 'Submit' ?></button>
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
     jQuery('.ac-cid').addClass('active');
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
                areacode: {
                    required: true,
                    maxlength: 5,
                },
                outbound_cid: {
                    required: true,
                    maxlength: 20,
                },
                cid_description: {
                    maxlength: 100,
                }
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });
    });

    function putActive(element,id)
    {
        if(jQuery(element).is(':checked'))
            jQuery('#active-'+id).val('Y');
        else
            jQuery('#active-'+id).val('N');
    }
    function edit(status)
    {
        var inputs = jQuery('#accid-'+status).find('input');
        var selects = jQuery('#accid-'+status).find('select');
        var obj = {};
        inputs.each(function(){
            var name = jQuery(this).attr('name');
            if( name != 'click' )
                obj[name] = jQuery(this).val();
        });
        selects.each(function(){
            var name = jQuery(this).attr('name');
            obj[name] = jQuery(this).val();
        });

        jQuery.ajax({
            url: '<?php echo site_url('dialer/campaign/ajaxedit') ?>',
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
        var inputs = jQuery('#accid-'+status).find('input','select');
        var selects = jQuery('#accid-'+status).find('select');
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