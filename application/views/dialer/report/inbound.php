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
    <div class="tool-box"></div>
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
            <span class="caption-subject bold uppercase"><?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <form id="groupForm" name="groupForm" id="groupForm" action="" method="post">
            <input type="hidden" name="file_download" id="file_download" />
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo 'Agency' ?>:</label>
                            <?php if ($this->session->userdata ( 'user' )->group_name == 'Agency'): ?>
                                <?php $tree = buildTree($agencies,0); ?>
                                <select name="agency_id" class="form-control" id="agency_id" onchange="javascript:selectOther(this.value)">
                                    <option value=""><?php echo "Please Select Agency"; ?></option>
                                    <?php echo printTreeWithEncrypt($tree,0, null, isset($postData['agency_id']) ? decode_url($postData['agency_id']) : ''  ); ?>
                                </select>
                            <?php else: ?>
                                <?php $tree = buildTree($agencies,0); ?>
                                <select name="agency_id" class="form-control" id="agency_id" onchange="javascript:selectOther(this.value)">
                                    <option value=""><?php echo "Please Select Agency"; ?></option>
                                <?php echo printTreeWithEncrypt($tree,0, null, isset($postData['agency_id']) ? decode_url($postData['agency_id']) : ''  ); ?>
                                </select>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo 'Dates' ?>: </label>
                            <div class="input-group date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control" name="query_date" value="<?php echo isset($postData['query_date']) ? $postData['query_date'] :  date('m/d/Y') ?>">
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" name="end_date" value="<?php echo isset($postData['end_date']) ? $postData['end_date'] : date('m/d/Y') ?>">
                            </div>
                        </div>
                    </div>
                    <?php if(isset($did) && $did['did'] == 'yes'): ?>
                        <div class="col-md-4">
                            <div class="form-group">
                            <?php $groupsPost = isset($postData['group']) ? $postData['group'] : array(); ?>
                                <label><?php echo 'Inbound DIDs' ?></label>
                                <?php if ($this->session->userdata ('user')->group_name == 'Agency'): ?>
                                    <select name="group[]" class="form-control" id="groupcall" multiple="">
                                        <?php foreach($ingroups as $ingroup): ?>
                                            <?php $selected = ''; ?>
                                            <?php if(in_array($ingroup['did_pattern'], $groupsPost)): ?>
                                                <?php $selected = 'selected="selected"'; ?>
                                            <?php endif; ?>
                                            <option value="<?php echo $ingroup['did_pattern'] ?>" <?php echo $selected ?> <?php echo (!isset($postData['group'])) ? 'selected="selected"':''; ?>><?php echo $ingroup['did_pattern'].'-'.$ingroup['did_description'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <select name="group[]" class="form-control" id="groupcall" multiple="">
                                        <?php $selected = ''; ?>
                                        <?php if(in_array('---NONE---', $groupsPost)): ?>
                                        <?php $selected = 'selected="selected"'; ?>
                                        <?php endif; ?>
                                        <option value="<?php echo '---NONE---' ?>" <?php echo $selected; ?>><?php echo '---NONE---' ?></option>
                                        <?php foreach($ingroups as $ingroup): ?>
                                            <?php $selected = ''; ?>
                                            <?php if(in_array($ingroup['did_pattern'], $groupsPost)): ?>
                                                <?php $selected = 'selected="selected"'; ?>
                                            <?php endif; ?>
                                            <option value="<?php echo $ingroup['did_pattern'] ?>" <?php echo $selected ?> <?php echo (!isset($postData['group'])) ? 'selected="selected"':''; ?>><?php echo $ingroup['did_pattern'].'-'.$ingroup['did_description'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                            <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo 'Inbound Groups' ?></label>
                                <?php if ($this->session->userdata ('user')->group_name == 'Agency'): ?>
                                    <?php $groupsPost = isset($postData['group']) ? $postData['group'] : array(); ?>
                                    <select multiple="" name="group[]" id="groupcall" class="form-control">
                                            <?php foreach($ingroups as $ingroup): ?>
                                            <?php $selected = ''; ?>
                                            <?php if(in_array($ingroup['group_id'], $groupsPost)): ?>
                                                <?php $selected = 'selected="selected"'; ?>
                                            <?php endif; ?>
                                            <option value="<?php echo $ingroup['group_id'] ?>" <?php echo $selected ?> <?php echo (!isset($postData['group'])) ? 'selected="selected"':''; ?>><?php echo $ingroup['group_id'].'-'.$ingroup['group_name'] ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <?php $groupsPost = isset($postData['group']) ? $postData['group'] : array(); ?>
                                    <select multiple="" name="group[]" id="groupcall" class="form-control">
                                            <?php $selected = ''; ?>
                                            <?php if(in_array('---NONE---', $groupsPost)): ?>
                                                <?php $selected = 'selected="selected"'; ?>
                                            <?php endif; ?>
                                            <option value="<?php echo '---NONE---' ?>" <?php echo $selected; ?>><?php echo '---NONE---' ?></option>
                                            <?php foreach($ingroups as $ingroup): ?>
                                            <?php $selected = ''; ?>
                                            <?php if(in_array($ingroup['group_id'], $groupsPost)): ?>
                                                <?php $selected = 'selected="selected"'; ?>
                                            <?php endif; ?>
                                            <option value="<?php echo $ingroup['group_id'] ?>" <?php echo $selected ?>><?php echo $ingroup['group_id'].'-'.$ingroup['group_name'] ?></option>
                                            <?php endforeach; ?>
                                    </select>

                                <?php endif; ?>
                            </div>
                        </div>
                <?php endif; ?>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-9">
                        <button class="btn blue" type="button" onClick="checkDownload(0)"><?php echo 'Submit' ?></button>
                        <!--button type="button" class="btn btn-circle grey-salsa btn-outline">Cancel</button-->
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function checkDownload(value){
    jQuery("#file_download").val(value);
    jQuery("#groupForm").submit();
}
function selectOther(agencyId){
    jQuery('#loading').modal('show');
    var group = '<?php echo isset($postData['group']) ? json_encode($postData['group']) : ''  ?>' ;
    var href = '<?php echo site_url("dialer/treport/getIngroup") ?>';
    var ajaxData = {id:agencyId,ingroup: group};
    <?php if(isset($did) && $did['did'] == 'yes'): ?>
        href = '<?php echo site_url("dialer/treport/getInboundDid") ?>';
        ajaxData = {id:agencyId, ingroup: group};
    <?php endif; ?>
    jQuery.ajax({
        url: href,
        method: 'POST',
        data: ajaxData,
        dataType:'JSON',
        success:function(result){
            var flag = result.success;
            jQuery('#groupcall').replaceWith(result.html);
            jQuery('#loading').modal('hide');
        }
    });
}
jQuery(function(){
    jQuery('.input-daterange').datepicker({
        orientation: "bottom",
    });
});
</script>
<?php if(isset($result)  && $result == TRUE) : ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"><?php echo 'Result'; ?></span>
        </div>
    </div>
    <div class="portlet-body">
        <?php echo $output ?>
    </div>
    <script type="text/javascript">
        jQuery(function(){
            selectOther('<?php echo $this->input->post('agency_id') ?>');
        });
    </script>
    <style type="text/css">
        .green{background-color: #008000;color: #ffffff;}
        .red{background-color: #ff0000;color: #ffffff;}
    </style>
</div>
<?php endif; ?>