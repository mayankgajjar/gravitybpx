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
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
        <div class="actions">
        </div>
    </div>

    <div class="portlet-body">
        <form name="calltimeform" id="calltimeform" method="post" class="form-horizontal">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "List ID"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="list_id" class="form-control" value="<?php echo $list->list_id ?>" />
                        <span class="help-content"> <?php echo "digits only"; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "List Name"; ?><span class="required" aria-required="true"> * </span></label>
                    <div class="col-md-4">
                        <input type="text" name="list_name" class="form-control" value="<?php echo $list->list_name  ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "List Description"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="list_description" class="form-control" value="<?php echo $list->list_description ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agency' ?></label>
                    <div class="col-md-4">
                        <?php  $tree = buildTree($agencies,0); ?>
                        <select name="agency_id" class="form-control" class="agency_id" onchange="javascript:selectCampaign(this.value)">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <?php echo printTree($tree,0, null, $alist->agency_id ); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Campaign'; ?></label>
                    <div class="col-md-4">
                        <select name="campaign_id" id="campaign_id" class="form-control">
                            <option value="" selected=""><?php echo ''; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Active' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="active">
                            <option value="Y" <?php echo optionSetValue($list->active, 'Y') ?>><?php echo 'Yes' ?></option>
                            <option value="N" <?php echo optionSetValue($list->active, 'N') ?>><?php echo 'No' ?></option>
                        </select>
                    </div>
                </div>
                <?php //if($list->list_id > 0 ): ?>
<!--                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Reset Lead-Called-Status for this list' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="reset_list">
                            <option value="Y" <?php echo optionSetValue($list->reset_list, 'Y') ?>><?php echo 'Yes' ?></option>
                            <option value="N" selected=""><?php echo 'No' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Reset Times"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="reset_time" class="form-control" value="<?php echo $list->reset_time ?>" maxlength="100"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Expiration Date"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="expiration_date" id="exdate" class="form-control" value="<?php echo $list->expiration_date  ?>" maxlength="10"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Local Call Time' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="local_call_time">
                            <option value="campaign" <?php echo optionSetValue($list->local_call_time, 'campaign') ?>><?php echo 'Campaign - Use Campaign Settings' ?></option>
                            <?php get_local_call_times($list->local_call_time) ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Audit Comments' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="audit_comments">
                            <option value="Y" <?php echo optionSetValue($list->audit_comments, 'Y') ?>><?php echo 'Yes' ?></option>
                            <option value="N" selected=""><?php echo 'No' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo 'Agent Script Override' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="agent_script_override">
                            <option value=""><?php echo '-' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Campaign CID Override"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="campaign_cid_override" class="form-control" value="<?php echo $list->campaign_cid_override  ?>" maxlength="20"/>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo "Answering Machine Message Override"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="am_message_exten_override" class="form-control" value="<?php echo $list->am_message_exten_override  ?>" maxlength="100"/>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo 'Drop Inbound Group Override' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="drop_inbound_group_override">
                            <option value=""><?php echo '-NONE-' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo "Web Form"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="web_form_address" class="form-control" value="<?php echo $list->web_form_address ?>" maxlength="9999"/>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo "No Agent Call URL"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="na_call_url" class="form-control" value="<?php echo $list->na_call_url  ?>" maxlength="9999"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf Number 1 Override"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_a_number" class="form-control" value="<?php echo $list->xferconf_a_number ?>" maxlength="50"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf Number 2 Override"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_b_number" class="form-control" value="<?php echo $list->xferconf_b_number ?>" maxlength="50"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf Number 3 Override"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_c_number" class="form-control" value="<?php echo $list->xferconf_c_number ?>" maxlength="50"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf Number 4 Override"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_d_number" class="form-control" value="<?php echo $list->xferconf_d_number ?>" maxlength="50"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Transfer-Conf Number 5 Override"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="xferconf_e_number" class="form-control" value="<?php echo $list->xferconf_e_number ?>" maxlength="50"/>
                    </div>
                </div>
                <div class="form-group" style="display: none;">
                    <label class="col-md-3 control-label"><?php echo 'Inventory Report' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="inventory_report">
                            <option value="Y" <?php echo optionSetValue('Y', $list->inventory_report) ?>><?php echo 'Yes' ?></option>
                            <option value="N" selected=""><?php echo 'No' ?></option>
                        </select>
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Time Zone Setting' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="time_zone_setting">
                            <option value="COUNTRY_AND_AREA_CODE" <?php echo optionSetValue('COUNTRY_AND_AREA_CODE', $list->time_zone_setting) ?>><?php echo 'COUNTRY_AND_AREA_CODE' ?></option>
                            <option value="POSTAL_CODE" <?php echo optionSetValue('POSTAL_CODE', $list->time_zone_setting) ?>><?php echo 'POSTAL_CODE' ?></option>
                            <option value="POSTAL_CODE" <?php echo optionSetValue('POSTAL_CODE', $list->time_zone_setting) ?>><?php echo 'POSTAL_CODE' ?></option>
                            <option value="NANPA_PREFIX" <?php echo optionSetValue('NANPA_PREFIX', $list->time_zone_setting) ?>><?php echo 'NANPA_PREFIX' ?></option>
                            <option value="OWNER_TIME_ZONE_CODE" <?php echo optionSetValue('OWNER_TIME_ZONE_CODE', $list->time_zone_setting) ?>><?php echo 'OWNER_TIME_ZONE_CODE' ?></option>
                        </select>
                    </div>
                </div>
                <?php //endif; ?>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn blue">Submit</button>
                        <!--button type="button" class="btn btn-circle grey-salsa btn-outline">Cancel</button-->
                    </div>
                </div>
            </div>
        </form>
        <script type="text/javascript">
            function selectCampaign(value){
               jQuery.ajax({
                   url : '<?php echo site_url('dialer/lists/getCampaigns/') ?>',
                   method : 'POST',
                   dataType : 'json',
                   data : {id : value, campaign : '<?php echo $list->campaign_id ?>'},
                   success: function(result){
                       var flag = Boolean(result.success);
                       jQuery('#campaign_id').replaceWith(result.html);
                   }
               });
            }
            jQuery(function(){
                <?php if($list->list_id > 0 ): ?>
                    selectCampaign('<?php echo $alist->agency_id ?>');
                    jQuery('.list-index').addClass('active');
                <?php else: ?>
                    jQuery('.list-add').addClass('active');
                <?php endif; ?>
                jQuery('#calltimeform').validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "", // validate all fields including form hidden input
                    rules: {
                        list_id : {
                            required: true,
                            number: true
                        },
                        list_name :{
                            required: true
                        }
                    },
                    highlight: function (element) { // hightlight error inputs
                         $(element)
                                .closest('.form-group').addClass('has-error'); // set error class to the control group
                    },
                });
            });
        </script>
    </div>
</div>