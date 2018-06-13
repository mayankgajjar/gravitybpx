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
        <form id="teamform" name="teamform" method="post">
            <input type="hidden" name="file_download" value="0" id="file_download"/>
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                         <div class="form-group">
                            <label><?php echo 'Dates' ?>: </label>
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control" name="query_date" value="<?php echo isset($postData['query_date']) ? $postData['query_date'] :  date('m/d/Y') ?>">
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" name="end_date" value="<?php echo isset($postData['end_date']) ? $postData['end_date'] : date('m/d/Y') ?>">
                            </div>
                         </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo 'Ageny' ?></label>
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
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo "Campaigns" ?>: </label>
                            <?php
                                $groups = isset($postData['group']) && count($postData['group']) > 0 ? $postData['group'] : array();
                                $selected = '';
                                if(in_array('--ALL--', $groups)){
                                    $selected = 'selected = "selected"';
                                }
                            ?>
                            <?php if ($this->session->userdata ( 'user' )->group_name == 'Agency'): ?>
                            <select multiple="" name="group[]" class="form-control" id="groupcam">
                                <?php foreach($campaigns as $campaign): ?>
                                    <?php
                                        $selected = '';
                                        if(in_array($campaign->campaign_id, $groups)){
                                            $selected = 'selected="selected"';
                                        }
                                    ?>
                                    <option value="<?php echo $campaign->campaign_id ?>" <?php echo $selected; ?> <?php if(!isset($postData['group'])) { echo 'selected="selected"'; } ?>><?php echo $campaign->campaign_id.' - '.$campaign->campaign_name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php else: ?>
                            <select multiple="" name="group[]" class="form-control" id="groupcam">
                                <option value="--ALL--" <?php echo $selected ?> <?php if(!isset($postData['group'])){ echo 'selected="selected"'; } ?>><?php echo '-- ALL CAMPAIGNS --' ?></option>
                                <?php foreach($campaigns as $campaign): ?>
                                    <?php
                                        $selected = '';
                                        if(in_array($campaign->campaign_id, $groups)){
                                            $selected = 'selected="selected"';
                                        }
                                    ?>
                                    <option value="<?php echo $campaign->campaign_id ?>" <?php echo $selected; ?>><?php echo $campaign->campaign_id.' - '.$campaign->campaign_name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                             <label><?php echo "Teams/Users Group" ?>: </label>
                             <?php $postuGroups = isset($postData['user_group']) ? $postData['user_group'] : array() ?>
                             <?php if ($this->session->userdata ( 'user' )->group_name == 'Agency'): ?>
                             <select multiple="" name="user_group[]" id="user_group" class="form-control">
                                 <?php foreach($user_groups as $usergroup): ?>
                                    <?php $selected = '' ?>
                                    <?php if(in_array($usergroup['user_group'], $postuGroups)): ?>
                                        <?php $selected = 'selected="selected"'; ?>
                                    <?php endif; ?>
                                    <option <?php echo (count($postuGroups)) == 0 ? 'selected="selected"' : ''; ?> value="<?php echo $usergroup['user_group'] ?>" <?php echo $selected; ?>><?php echo $usergroup['user_group'] ?></option>
                                 <?php endforeach; ?>
                             </select>
                             <?php else: ?>
                             <select multiple="" name="user_group[]" id="user_group" class="form-control">
                                 <?php foreach($user_groups as $usergroup): ?>
                                    <?php $selected = '' ?>
                                    <?php if(in_array($usergroup->user_group, $postuGroups)): ?>
                                        <?php $selected = 'selected="selected"'; ?>
                                    <?php endif; ?>
                                    <option <?php if(!isset($postData['user_group'])){ echo 'selected="selected"'; } ?>  value="<?php echo $usergroup->user_group ?>" <?php echo $selected; ?>><?php echo $usergroup->user_group ?></option>
                                 <?php endforeach; ?>
                             </select>
                             <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-9">
                        <button class="btn blue" type="button" onClick="checkDownload(0)">Submit</button>
                        <a class="btn blue" href="javascript:checkDownload(1)"><?php echo 'Download' ?></a>
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
    jQuery("#teamform").submit();
}
function selectOther(agency){
    jQuery('#loading').modal("show");
    jQuery.ajax({
        url: '<?php echo site_url('dialer/report/getother') ?>',
        method: 'POST',
        data: { id : agency},
        dataType:'JSON',
        success: function(result){
             var flag = Boolean(result.success);
             if(flag == true){
                jQuery('#groupcam').replaceWith(result.campaign);
                jQuery('#user_group').replaceWith(result.groups);
            }
            jQuery('#loading').modal("hide");
        }
    });
}
jQuery(function(){
    jQuery('.input-daterange').datepicker({
        orientation: "bottom",
    });
});
</script>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"><?php echo 'Result' ?></span>
        </div>
    </div>
    <div class="portlet-body">
        <?php if(isset($result)): ?>
            <?php echo $result; ?>
            <script type="text/javascript">
                jQuery(function(){
                    <?php if(isset($postData['agency_id']) && strlen($postData['agency_id']) > 0): ?>
                        selectOther('<?php echo $postData['agency_id'] ?>');
                    <?php endif; ?>
                });
            </script>
        <?php endif; ?>
    </div>
</div>
