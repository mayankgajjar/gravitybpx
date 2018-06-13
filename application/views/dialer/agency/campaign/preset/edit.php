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
                                <th id="first"><?php echo '#'; ?></th>
                                <th><?php echo 'Preset Name'; ?></th>
                                <th><?php echo 'Number'; ?></th>
                                <th><?php echo 'DTMF'; ?></th>
                                <th><?php echo 'Hide'; ?></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($presets as $preset): ?>
                            <tr id="preset-<?php echo $preset->id ?>">
                                <td>&nbsp;&nbsp;<?php echo $i; ?>&nbsp;&nbsp;</td>
                                <td>
                                    <input type="hidden" name="id" value="<?php echo encode_url($preset->id); ?>" />
                                    <input type="hidden" name="model" value="<?php echo 'dpreset_m'; ?>" />
                                    <?php echo $preset->preset_name; ?>
                                </td>
                                <td>
                                    <input name="preset_number" class="form-control" value="<?php echo $preset->preset_number; ?>" />
                                </td>
                                <td>
                                    <input name="preset_dtmf" class="form-control" value="<?php echo $preset->preset_dtmf; ?>" />
                                </td>
                                <td>
                                    <select name="preset_hide_number" class="form-control">
                                        <option value="Y" <?php echo optionSetValue('Y', $preset->preset_hide_number) ?>><?php echo 'Y' ?></option>
                                        <option value="N" <?php echo optionSetValue('N', $preset->preset_hide_number) ?>><?php echo 'N' ?></option>
                                    </select>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onclick="javascript:edit('<?php echo $preset->id ?>')"><i aria-hidden="true" class="fa  fa-pencil-square-o"></i></a>&nbsp;
                                    <a href="javascript:void(0)" onclick="javascript:deleteAll('<?php echo $preset->id ?>')"><i aria-hidden="true" class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="form">
                        <h3><?php echo 'Add New Custom Campaign Status'; ?></h3>
                        <form name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                         <div class="form-body">
                             <input type="hidden" name="campaign_id" value="<?php echo encode_url($campaign->id) ?>" />
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Preset Name"; ?><span class="required"> * </span></label>
                                 <div class="col-md-4">
                                     <input type="text" name="preset_name" maxlength="40" size="20" class="form-control">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Preset Number"; ?><span class="required"> * </span></label>
                                 <div class="col-md-4">
                                     <input type="text" name="preset_number" class="form-control" maxlength="50">
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Preset DTMF"; ?><span class="required"> * </span></label>
                                 <div class="col-md-4">
                                    <input name="preset_dtmf" class="form-control" maxlength="50" />
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label class="col-md-3 control-label"><?php echo "Preset Hide Number"; ?></label>
                                 <div class="col-md-4">
                                     <select name="preset_hide_number" id="preset_hide_number" class="form-control">
                                         <option value="<?php echo "Y"; ?>"><?php echo "Yes"; ?></option>
                                         <option value="<?php echo "N"; ?>"><?php echo "No"; ?></option>
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
    jQuery('.presets').addClass('active');
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
     jQuery("#form").validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                preset_name: {
                    required:  true,
                    maxlenght: 40
                },
                preset_number: {
                    required: true,
                    maxlenght:50
                },
                preset_dtmf:{
                    required : true,
                    maxlenght: 50
                }
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });
    });
    function edit(status)
    {
        var inputs = jQuery('#preset-'+status).find('input','select');
        var selects = jQuery('#preset-'+status).find('select');
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
        var inputs = jQuery('#preset-'+status).find('input','select');
        var selects = jQuery('#preset-'+status).find('select');
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