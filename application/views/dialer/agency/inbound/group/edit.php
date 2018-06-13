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
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <form id="groupForm" name="groupForm" id="groupForm" action="" method="post" class="form-horizontal" >
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Group ID' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="group_id" maxlength="20" value="<?php echo $ingroup->group_id ?>"/>
                        <span class="help-content"><?php echo '(no spaces)' ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Group Name' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="group_name" maxlength="30" value="<?php echo $ingroup->group_name ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Color Group' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="group_color" name="group_color" maxlength="7" value="<?php echo $ingroup->group_color ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Active' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="active">
                            <option value="Y" <?php echo optionSetValue($ingroup->active, 'Y') ?>><?php echo 'Yes' ?></option>
                            <option value="N" <?php echo optionSetValue($ingroup->active, 'N') ?>><?php echo 'No' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agency' ?></label>
                    <div class="col-md-4">
                        <?php  $tree = buildTree($agencies,$this->session->userdata('agency')->id); ?>
                        <select name="agency_id" class="form-control" class="agency_id" onchange="javascript:selectGroup(this.value)">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <option value="<?php echo encode_url($this->session->userdata('agency')->id) ?>" selected=""><?php echo '' ?></option>
                            <?php echo printTreeWithEncrypt($tree,0, null, $ingroup->agency_id ); ?>
                        </select>
                        <span class="help-content"><?php echo 'select blank for current agency.' ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Admin User Group' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="user_group" id="user_group">
                            <option value=""><?php echo 'Please Select' ?></option>
                            <?php foreach($groups as $group) : ?>
                            <option value="<?php echo $group['user_group']; ?>" <?php echo optionSetValue($ingroup->user_group, $group['user_group']) ?>><?php echo $group['user_group'].' - '.$group['group_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Next Agent Call' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="next_agent_call">
                            <option value="random" <?php echo optionSetValue('random', $ingroup->next_agent_call) ?>><?php echo 'random' ?></option>
                            <option value="oldest_call_start" <?php echo optionSetValue('oldest_call_start', $ingroup->next_agent_call) ?>><?php echo 'oldest_call_start' ?></option>
                            <option value="oldest_call_finish" <?php echo optionSetValue('oldest_call_finish', $ingroup->next_agent_call) ?>><?php echo 'oldest_call_finish' ?></option>
                            <option value="oldest_inbound_call_start" <?php echo optionSetValue('oldest_inbound_call_start', $ingroup->next_agent_call) ?>><?php echo 'oldest_inbound_call_start' ?></option>
                            <option value="oldest_inbound_call_finish" <?php echo optionSetValue('oldest_inbound_call_finish', $ingroup->next_agent_call) ?>><?php echo 'oldest_inbound_call_finish' ?></option>
                            <option value="overall_user_level" <?php echo optionSetValue('overall_user_level', $ingroup->next_agent_call) ?>><?php echo 'overall_user_level' ?></option>
                            <option value="inbound_group_rank" <?php echo optionSetValue('inbound_group_rank', $ingroup->next_agent_call) ?>><?php echo 'inbound_group_rank' ?></option>
                            <option value="campaign_rank" <?php echo optionSetValue('campaign_rank', $ingroup->next_agent_call) ?> ><?php echo 'campaign_rank' ?></option>
                            <option value="ingroup_grade_random" <?php echo optionSetValue('ingroup_grade_random', $ingroup->next_agent_call) ?>><?php echo 'ingroup_grade_random' ?></option>
                            <option value="campaign_grade_random" <?php echo optionSetValue('campaign_grade_random', $ingroup->next_agent_call) ?>><?php echo 'campaign_grade_random' ?></option>
                            <option value="fewest_calls" <?php echo optionSetValue('fewest_calls', $ingroup->next_agent_call) ?>><?php echo 'fewest_calls' ?></option>
                            <option value="fewest_calls_campaign" <?php echo optionSetValue('fewest_calls_campaign', $ingroup->next_agent_call) ?>><?php echo 'fewest_calls_campaign' ?></option>
                            <option value="longest_wait_time" <?php echo optionSetValue('longest_wait_time', $ingroup->next_agent_call) ?>><?php echo 'longest_wait_time' ?></option>
                            <option value="ring_all" <?php echo optionSetValue('ring_all', $ingroup->next_agent_call) ?>><?php echo 'ring_all' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Script' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="ingroup_script">
                            <option value="" <?php echo optionSetValue('', $ingroup->ingroup_script) ?>>NONE</option>
                            <?php echo getScripts($ingroup->ingroup_script); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Get Call Launch' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="get_call_launch">
                            <option value="NONE" <?php echo optionSetValue('NONE', $ingroup->get_call_launch) ?>>NONE</option>
                            <option value="SCRIPT" <?php echo optionSetValue('SCRIPT', $ingroup->get_call_launch) ?>>SCRIPT</option>
                            <option value="WEBFORM" <?php echo optionSetValue('WEBFORM', $ingroup->get_call_launch) ?>>WEBFORM</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Drop call seconds' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="drop_call_seconds" class="form-control" value="<?php echo $ingroup->drop_call_seconds ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Drop Action' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="drop_action">
                            <option value="HANGUP" <?php echo optionSetValue('HANGUP', $ingroup->drop_action) ?>><?php echo 'HANGUP' ?></option>
                            <option value="HANGUP" <?php echo optionSetValue('HANGUP', $ingroup->drop_action) ?>><?php echo 'MESSAGE' ?></option>
                            <option value="VOICEMAIL" <?php echo optionSetValue('VOICEMAIL', $ingroup->drop_action) ?>><?php echo 'VOICEMAIL' ?></option>
                            <option value="VMAIL_NO_INST" <?php echo optionSetValue('VMAIL_NO_INST', $ingroup->drop_action) ?>><?php echo 'VMAIL_NO_INST' ?></option>
                            <option value="IN_GROUP" <?php echo optionSetValue('IN_GROUP', $ingroup->drop_action) ?>><?php echo 'IN_GROUP' ?></option>
                            <option value="CALLMENU" <?php echo optionSetValue('CALLMENU', $ingroup->drop_action) ?>><?php echo 'CALLMENU' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php  echo 'Voicemail' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="voicemail_ext" id="voicemail_ext" class="form-control" value="<?php echo $ingroup->voicemail_ext ?>" />
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-info" href="<?php echo site_url('dialer/ajax/getvoicemaillist/voicemail_ext') ?>" data-target="#ajax" data-toggle="modal"><?php echo 'voicemail chooser' ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Call Time' ?></label>
                    <div class="col-md-4">
                        <select name="call_time_id" class="form-control">
                        <?php echo get_local_call_times($ingroup->call_time_id); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'After Hours Action' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="after_hours_action">
                            <option value="HANGUP" <?php echo optionSetValue('HANGUP', $ingroup->after_hours_action) ?>><?php echo 'HANGUP' ?></option>
                            <option value="MESSAGE" <?php echo optionSetValue('MESSAGE', $ingroup->after_hours_action) ?>><?php echo 'MESSAGE' ?></option>
                            <option value="VOICEMAIL" <?php echo optionSetValue('VOICEMAIL', $ingroup->after_hours_action) ?>><?php echo 'VOICEMAIL' ?></option>
                            <option value="VMAIL_NO_INST" <?php echo optionSetValue('VMAIL_NO_INST', $ingroup->after_hours_action) ?>><?php echo 'VMAIL_NO_INST' ?></option>
                            <option value="IN_GROUP" <?php echo optionSetValue('IN_GROUP', $ingroup->after_hours_action) ?>><?php echo 'IN_GROUP' ?></option>
                            <option value="CALLMENU" <?php echo optionSetValue('CALLMENU', $ingroup->after_hours_action) ?>><?php echo 'CALLMENU' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php  echo 'After Hours Voicemail' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="after_hours_voicemail" id="after_hours_voicemail" class="form-control" value="<?php echo $ingroup->after_hours_voicemail ?>" />
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-info" href="<?php echo site_url('dialer/ajax/getvoicemaillist/after_hours_voicemail') ?>" data-target="#ajax" data-toggle="modal"><?php echo 'voicemail chooser' ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php  echo 'After Hours Message Filename' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="after_hours_message_filename" id="after_hours_message_filename" class="form-control" value="<?php echo $ingroup->after_hours_message_filename ?>" />
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-info" href="<?php echo site_url('dialer/ajax/sound/after_hours_message_filename') ?>" data-target="#ajax" data-toggle="modal"><?php echo 'audio chooser' ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php  echo 'After Hours Extension' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="after_hours_exten" id="after_hours_exten" class="form-control" value="<?php echo $ingroup->after_hours_exten ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'No Agents No Queueing' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="no_agent_no_queue">
                            <option value="Y" <?php echo optionSetValue('Y', $ingroup->no_agent_no_queue) ?>><?php echo 'Yes' ?></option>
                            <option value="N" <?php echo optionSetValue('N', $ingroup->no_agent_no_queue) ?>><?php echo 'No' ?></option>
                            <option value="NO_PAUSED" <?php echo optionSetValue('NO_PAUSED', $ingroup->no_agent_no_queue) ?>><?php echo 'NO_PAUSED' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'No Agent No Queue Action' ?></label>
                    <div class="col-md-4">
                        <select class="form-control" id="no_agent_action" name="no_agent_action" onchange="javascript:dynamic_call_action('no_agent_action','<?php echo $ingroup->no_agent_action ?>','<?php echo $ingroup->no_agent_action_value ?>','600');">
                            <option value=""></option>
                            <option value="CALLMENU" <?php echo optionSetValue('CALLMENU', $ingroup->no_agent_action) ?>><?php echo 'CALLMENU' ?></option>
                            <option value="INGROUP" <?php echo optionSetValue('INGROUP', $ingroup->no_agent_action) ?>><?php echo 'INGROUP' ?></option>
                            <option value="DID" <?php echo optionSetValue('DID', $ingroup->no_agent_action) ?>><?php echo 'DID' ?></option>
                            <option value="MESSAGE" <?php echo optionSetValue('MESSAGE', $ingroup->no_agent_action) ?>><?php echo 'MESSAGE' ?></option>
                            <option value="EXTENSION" <?php echo optionSetValue('EXTENSION', $ingroup->no_agent_action) ?>><?php echo 'EXTENSION' ?></option>
                            <option value="VOICEMAIL" <?php echo optionSetValue('VOICEMAIL', $ingroup->no_agent_action) ?>><?php echo 'VOICEMAIL' ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 form-group" id="no_agent_action_value_span" name="no_agent_action_value_span">
                <?php if(strlen($ingroup->group_id)): ?>
                    <?php
                        $data = getMenuOptions($ingroup->agency_id);
                        $data = (array) json_decode($data);
                        extract($data);
                        $no_agent_action = $ingroup->no_agent_action;
                        $no_agent_action_value = $ingroup->no_agent_action_value;
                    ?>
                    <?php if($ingroup->no_agent_action == 'CALLMENU' ) : ?>
                        <label class="col-md-3 control-label" id="no_agent_action_value_link" name="no_agent_action_value_link"><?php echo 'Call Menu' ?></label>
                        <div class="col-md-4">
                            <select name="no_agent_action_value" is="no_agent_action_value" class="form-control">
                                <?php echo $call_menu_list ?>
                            </select>
                        </div>
                    <?php endif; //if($ingroup->no_agent_action == 'CALLMENU' ) ?>
                    <?php if($ingroup->no_agent_action == 'INGROUP' ) : ?>
                        <?php if (strlen($no_agent_action_value) < 10): ?>
				<?php $no_agent_action_value = 'SALESLINE,CID,LB,998,TESTCAMP,1'; ?>
                        <?php endif; //if (strlen($no_agent_action_value) < 10) ?>
                        <?php
                            $IGno_agent_action_value = explode(",",$no_agent_action_value);
                            $IGgroup_id =	$IGno_agent_action_value[0];
                            $IGhandle_method =	$IGno_agent_action_value[1];
                            $IGsearch_method =	$IGno_agent_action_value[2];
                            $IGlist_id =	$IGno_agent_action_value[3];
                            $IGcampaign_id =	$IGno_agent_action_value[4];
                            $IGphone_code =	$IGno_agent_action_value[5];
                            $j = '';
                        ?>
                        <div class="col-md-6">
                        <label class="col-md-2" name="no_agent_action_value_link" id="no_agent_action_value_link">
                            <?php echo 'In-Group' ?>
                        </label>
                        <div class="col-md-4">
                            <select class="form-control" name="IGgroup_id_no_agent_action" id="IGgroup_id_no_agent_action">
                                <?php echo $ingroup_list ?>
                                <option SELECTED value="<?php echo $IGgroup_id ?>"><?php echo $IGgroup_id ?></option>
                            </select>
                        </div>
                        <label class="col-md-2">
                            <?php echo 'Handle Method' ?>
                        </label>
                        <div class="col-md-4">
                            <select class="form-control" name="IGhandle_method_<?php echo $j ?>" id="IGhandle_method_<?php echo $j ?>">
                                <?php echo $IGhandle_method_list; ?>
                                <option SELECTED value="<?php echo $IGhandle_method ?>"><?php echo $IGhandle_method ?></option>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <label class="col-md-2">
                            <?php echo 'Search Method' ?>
                        </label>
                        <div class="col-md-4">
                            <select class="form-control" name="IGsearch_method_<?php echo $j ?>" id="IGsearch_method_<?php echo $j ?>">
                                <?php echo $IGsearch_method_list; ?>
                                <option SELECTED value="<?php echo $IGsearch_method ?>"><?php echo $IGsearch_method ?></option>
                            </select>
                        </div>
                        <label class="col-md-2">
                            <?php echo 'List ID' ?>
                        </label>
                        <div class="col-md-4">
                               <input type="text" size="5" maxlength="19" name="IGlist_id_<?php echo $j ?>" id="IGlist_id_<?php echo $j ?>" value="<?php echo $IGlist_id ?>">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <label class="col-md-2">
                            <?php echo 'Campaign ID' ?>
                        </label>
                        <div class="col-md-4">
                            <select class="form-control" name="IGcampaign_id_<?php echo $j ?>" id="IGcampaign_id_<?php echo $j ?>">
                                <?php echo $IGcampaign_id_list; ?>
                                <option SELECTED value="<?php echo $IGcampaign_id ?>"><?php echo $IGcampaign_id ?></option>
                            </select>
                        </div>
                        <label class="col-md-2">
                            <?php echo 'Phone Code' ?>
                        </label>
                        <div class="col-md-4">
                            <input type="text" size="5" maxlength="19" name="IGphone_code_<?php echo $j ?>" id="IGphone_code_<?php echo $j ?>" value="<?php echo $IGphone_code ?>">
                        </div>
                        </div>
                    <?php endif; //if($ingroup->no_agent_action == 'INGROUP' ) ?>
                    <?php if($ingroup->no_agent_action == 'DID' ): ?>
                        <label class="col-md-3 control-label">
                            <?php echo 'DID' ?>
                        </label>
                        <div class="col-md-4">
                            <select name="no_agent_action_value" id="no_agent_action_value" class="form-control">
                                <?php echo $did_list ?>
                                <option SELECTED value="<?php echo $no_agent_action_value ?>"><?php echo $no_agent_action_value ?></option>
                            </select>
                        </div>
                    <?php endif; //if($ingroup->no_agent_action == 'DID' ) ?>
                    <?php if($ingroup->no_agent_action == 'MESSAGE' ): ?>
                        <?php if (strlen($no_agent_action_value) < 3): ?>
                            <?php $no_agent_action_value = 'nbdy-avail-to-take-call|vm-goodbye'; ?>
                        <?php endif; ?>
                        <label class="col-md-3 control-label">
                            <?php echo 'Audio File' ?>
                        </label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="no_agent_action_value" id="no_agent_action_value" size="50" maxlength="255" value="<?php echo $no_agent_action_value ?>" />
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-info" href="<?php echo site_url('dialer/ajax/sound/no_agent_action_value') ?>" data-target="#ajax" data-toggle="modal"><?php echo 'audio chooser' ?></a>
                        </div>
                    <?php endif; //if($ingroup->no_agent_action == 'MESSAGE' ) ?>
                    <?php if($ingroup->no_agent_action == 'EXTENSION'): ?>
                        <?php if( strlen($no_agent_action_value < 3)): ?>
                            <?php $no_agent_action_value = '8304,default'; ?>
                        <?php endif; ?>
                        <?php
                            $EXno_agent_action_value = explode(",",$no_agent_action_value);
                            $EXextension =	$EXno_agent_action_value[0];
                            $EXcontext =	$EXno_agent_action_value[1];
                        ?>
                        <label class="col-md-2 control-label">
                            <?php echo 'Extension' ?>
                        </label>
                        <div class="col-md-2">
                            <input class="form-control" type="text" name="EXextension_no_agent_action" id="EXextension_no_agent_action" size="20" maxlength="255" value="<?php echo $EXextension ?>">
                        </div>
                        <label class="col-md-2 control-label">
                            <?php echo 'Context' ?>
                        </label>
                        <div class="col-md-2">
                            <input class="form-control" type="text" name="EXcontext_no_agent_action" id="EXcontext_no_agent_action" size="20" maxlength="255" value="<?php echo $EXcontext ?>">
                        </div>
                    <?php endif; //if($ingroup->no_agent_action == 'EXTENSION') ?>
                    <?php if(($no_agent_action=='VOICEMAIL') or  ($no_agent_action=='VMAIL_NO_INST')): ?>
                        <label class="col-md-3 control-label"><?php echo 'Voicemail Box' ?></label>
                        <div class="col-md-4">
                            <input class="form-control" type=text name="no_agent_action_value" id="no_agent_action_value" size="12" maxlength="10" value="<?php echo $no_agent_action_value ?>">
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-info" href="<?php echo site_url('dialer/ajax/getvoicemaillist/no_agent_action_value') ?>" data-target="#ajax" data-toggle="modal"><?php echo 'voicemail chooser' ?></a>
                        </div>
                    <?php endif; //if(($no_agent_action=='VOICEMAIL') or  ($no_agent_action=='VMAIL_NO_INST')) ?>
                <?php endif; //if(strlen($ingroup->group_id)) ?>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php  echo 'Welcome Message Filename' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="welcome_message_filename" id="welcome_message_filename" class="form-control" value="<?php echo $ingroup->welcome_message_filename ?>" />
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-info" href="<?php echo site_url('dialer/ajax/sound/welcome_message_filename') ?>" data-target="#ajax" data-toggle="modal"><?php echo 'audio chooser' ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Play Welcome Message' ?></label>
                    <div class="col-md-4">
                        <select name="play_welcome_message" class="form-control">
                            <option value="ALWAYS" <?php echo optionSetValue('ALWAYS', $ingroup->play_welcome_message) ?>>ALWAYS</option>
                            <option value="NEVER" <?php echo optionSetValue('NEVER', $ingroup->play_welcome_message) ?>>NEVER</option>
                            <option value="IF_WAIT_ONLY" <?php echo optionSetValue('IF_WAIT_ONLY', $ingroup->play_welcome_message) ?>>IF_WAIT_ONLY</option>
                            <option value="YES_UNLESS_NODELAY" <?php echo optionSetValue('YES_UNLESS_NODELAY', $ingroup->play_welcome_message) ?>>YES_UNLESS_NODELAY</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php  echo 'On Hold Prompt Filename' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="onhold_prompt_filename" id="onhold_prompt_filename" class="form-control" value="<?php echo $ingroup->onhold_prompt_filename ?>" />
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-info" href="<?php echo site_url('dialer/ajax/sound/onhold_prompt_filename') ?>" data-target="#ajax" data-toggle="modal"><?php echo 'audio chooser' ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php  echo 'On Hold Prompt Interval' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="prompt_interval" id="prompt_interval" maxlength="5" class="form-control" value="<?php echo $ingroup->prompt_interval ?>" />
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
jQuery(function(){
    jQuery('#ingroup, .ingroup-edit').addClass('active');
    jQuery('#group_color').colorpicker();
    <?php if(strlen($ingroup->group_id) > 0): ?>
        jQuery('#no_agent_action_value_span').attr('style','background:#d3d3d3 none repeat scroll 0 0;padding: 10px;');
    <?php endif; ?>
    jQuery('#groupForm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules:{
           group_id :{
               required: true,
               minlenght: 2,
               maxlenght: 20,

           },
           group_name:{
               required: true,
               maxlenght: 50,
           },
           group_color:{
               required: true,
               maxlenght: 7,
           }

       },
        highlight: function (element) { // hightlight error inputs
             $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
});

function selectVoicemail(voicemail,field){
    jQuery('#'+field).val(voicemail);
    jQuery('#ajax').modal('hide');
}
function chooseFile(audio,field){
    jQuery('#'+field).val(audio);
    jQuery('#ajax').modal('hide');
}
function selectGroup(agency_id, groupId){
    groupId = '';
    jQuery('#loading').modal('show');
    jQuery.ajax({
        url : '<?php echo site_url('dialer/ajax/getAgencyGroup/') ?>',
        method : 'POST',
        dataType : 'json',
        data : {id : agency_id,group: groupId},
        success: function(result){
            var flag = Boolean(result.success);
            jQuery('#user_group').replaceWith(result.html);
            jQuery('#loading').modal('hide');
        }
    });
}
function dynamic_call_action(option,route,value,chooser_height){
    jQuery('#loading').modal('show');
    var call_menu_list = '';
    var ingroup_list = '';
    var IGcampaign_id_list = '';
    var IGhandle_method_list = '<?php echo '<option>CID</option><option>CIDLOOKUP</option><option>CIDLOOKUPRL</option><option>CIDLOOKUPRC</option><option>CIDLOOKUPALT</option><option>CIDLOOKUPRLALT</option><option>CIDLOOKUPRCALT</option><option>CIDLOOKUPADDR3</option><option>CIDLOOKUPRLADDR3</option><option>CIDLOOKUPRCADDR3</option><option>CIDLOOKUPALTADDR3</option><option>CIDLOOKUPRLALTADDR3</option><option>CIDLOOKUPRCALTADDR3</option><option>ANI</option><option>ANILOOKUP</option><option>ANILOOKUPRL</option><option>VIDPROMPT</option><option>VIDPROMPTLOOKUP</option><option>VIDPROMPTLOOKUPRL</option><option>VIDPROMPTLOOKUPRC</option><option>CLOSER</option><option>3DIGITID</option><option>4DIGITID</option><option>5DIGITID</option><option>10DIGITID</option>'; ?>';
    var IGsearch_method_list = '<?php echo '<option value="LB">LB - '.("Load Balanced").'</option><option value="LO">LO - '.("Load Balanced Overflow").'</option><option value="SO">SO - '.("Server Only").'</option>'; ?>';
    var did_list = '';
    var phone_list = '';
    var selected_value = '';
    var selected_context = '';
    var new_content = '';
    var agencyId = jQuery('[name="agency_id"]').val();
    jQuery.ajax({
        url : '<?php echo site_url('dialer/ajax/menuoptions') ?>',
        async : false,
        method : 'POST',
        dataType : 'json',
        data : {id: agencyId, menu: ''},
        success : function (result){
            call_menu_list = result.call_menu_list;
            ingroup_list = result.ingroup_list;
            IGcampaign_id_list = result.IGcampaign_id_list;
            did_list = result.did_list;
            phone_list = result.phone_list;
        }
    });
    console.log(option);
    var select_list = document.getElementById(option + "");
    var selected_route = select_list.value;
    var span_to_update = document.getElementById(option + "_value_span");
    var new_content = '';
    if (selected_route == 'CALLMENU'){
        if (route == selected_route){
            selected_value = '<option SELECTED value="' + value + '">' + value + "</option>\n";
        }else{
            value = '';
        }
        new_content = '<label class="col-md-3 control-label" name="' + option + '_value_link" id="' + option + '_value_link"><?php echo "Call Menu"; ?></label><div class="col-md-4"><select class="control-label" size="1" name="' + option + '_value" id="' + option + '_value">' + call_menu_list + "\n" + selected_value + '</select></div>';
    } // if (selected_route == 'CALLMENU'){
    if (selected_route=='INGROUP'){
        if ((route != selected_route) || (value.length < 10) ){
            value = 'SALESLINE,CID,LB,998,TESTCAMP,1,,,,';
        }
        var value_split = value.split(",");
        var IGgroup_id =				value_split[0];
        var IGhandle_method =			value_split[1];
        var IGsearch_method =			value_split[2];
        var IGlist_id =					value_split[3];
        var IGcampaign_id =				value_split[4];
        var IGphone_code =				value_split[5];
        var IGvid_enter_filename =		value_split[6];
        var IGvid_id_number_filename =	value_split[7];
        var IGvid_confirm_filename =	value_split[8];
        var IGvid_validate_digits =		value_split[9];
        if (route == selected_route){
            selected_value = '<option SELECTED>' + IGgroup_id + '</option>';
        }
        new_content = new_content + '<div class="col-md-6"><label class="col-md-2" name="' + option + '_value_link" id="' + option + '_value_link"><?php echo "In-Group"; ?></label> ';
        new_content = new_content + '<div class="col-md-4"><select class="form-control" size="1" name="IGgroup_id_' + option + '" id="IGgroup_id_' + option + '" >';
        new_content = new_content + '' + ingroup_list + "\n" + selected_value + '</select></div>';
        new_content = new_content + '<label class="col-md-2"><?php echo "Handle Method"; ?></label><div class="col-md-4"><select class="form-control" size="1" name="IGhandle_method_' + option + '" id="IGhandle_method_' + option + '">';
        new_content = new_content + '' + IGhandle_method_list + "\n" + '<option SELECTED>' + IGhandle_method + '</select></div></div>';
        new_content = new_content + '<div class="col-md-6"><label class="col-md-2"><?php echo "Search Method"; ?></label><div class="col-md-4"><select class="form-control" size="1" name="IGsearch_method_' + option + '" id="IGsearch_method_' + option + '">';
        new_content = new_content + '' + IGsearch_method_list + "\n" + '<option SELECTED>' + IGsearch_method + '</select></div>';
        new_content = new_content + '<label class="col-md-2"><?php echo "List ID"; ?></label><div class="col-md-4"><input class="form-control" type="text" size="5" maxlength="14" name="IGlist_id_' + option + '" id="IGlist_id_' + option + '" value="' + IGlist_id + '"></div></div>';
        new_content = new_content + '<div class="col-md-6"><label class="col-md-2"><?php echo "Campaign ID"; ?></label><div class="col-md-4"><select class="form-control" size="1" name="IGcampaign_id_' + option + '" id="IGcampaign_id_' + option + '">';
        new_content = new_content + '' + IGcampaign_id_list + "\n" + '<option SELECTED>' + IGcampaign_id + '</select></div>';
        new_content = new_content + '<label class="col-md-2"><?php echo "Phone Code"; ?></label><div class="col-md-4"><input class="form-control" type=text size=5 maxlength=14 name=IGphone_code_' + option + ' id=IGphone_code_' + option + ' value="' + IGphone_code + '" /> </div></div>';
//	new_content = new_content + "<BR> &nbsp; <?php echo "VID Enter Filename"; ?>: <input type=text name=IGvid_enter_filename_" + option + " id=IGvid_enter_filename_" + option + " size=40 maxlength=255 value=\"" + IGvid_enter_filename + "\"> <a href=\"javascript:launch_chooser('IGvid_enter_filename_" + option + "','date'," + chooser_height + ");\"><?php echo "audio chooser"; ?></a>";
//	new_content = new_content + "<BR> &nbsp; <?php echo "VID ID Number Filename"; ?>: <input type=text name=IGvid_id_number_filename_" + option + " id=IGvid_id_number_filename_" + option + " size=40 maxlength=255 value=\"" + IGvid_id_number_filename + "\"> <a href=\"javascript:launch_chooser('IGvid_id_number_filename_" + option + "','date'," + chooser_height + ");\"><?php echo "audio chooser"; ?></a>";
//	new_content = new_content + "<BR> &nbsp; <?php echo "VID Confirm Filename"; ?>: <input type=text name=IGvid_confirm_filename_" + option + " id=IGvid_confirm_filename_" + option + " size=40 maxlength=255 value=\"" + IGvid_confirm_filename + "\"> <a href=\"javascript:launch_chooser('IGvid_confirm_filename_" + option + "','date'," + chooser_height + ");\"><?php echo "audio chooser"; ?></a>";
//	new_content = new_content + ' &nbsp; <?php echo "VID Digits"; ?>: <input type=text size=3 maxlength=3 name=IGvid_validate_digits_' + option + ' id=IGvid_validate_digits_' + option + ' value="' + IGvid_validate_digits + '">';
    } //if (selected_route=='INGROUP')
    if(selected_route=='DID'){
       if (route == selected_route){
           selected_value = '<option SELECTED value="' + value + '">' + value + "</option>\n";
       }else{
           value = '';
       }
       new_content = '<label class="col-md-3 control-label" name="' + option + '_value_link" id="' + option + '_value_link"><?php echo "DID"; ?></label><div class="col-md-4"><select class="form-control" size="1" name="' + option + '_value" id="' + option + '_value">' + did_list + "\n" + selected_value + '</select></div>';
    }
    if (selected_route == 'MESSAGE'){
        if (route == selected_route){
            selected_value = value;
        }else{
            value = 'nbdy-avail-to-take-call|vm-goodbye';
        }
        new_content = "<label class='col-md-3 control-label'><?php echo 'Audio File'; ?></label><div class='col-md-4'><input class='form-control' type='text' name='" + option + "_value' id='" + option + "_value' size='40' maxlength='255' value='" + value + "' /></div><div class='col-md-3'><a href='<?php echo site_url('dialer/ajax/sound') ?>/"+option+"_value' data-target='#ajax' data-toggle='modal' class='btn btn-info'><?php echo "audio chooser" ?></a></div>";
    }
    if (selected_route=='EXTENSION'){
        if ( (route != selected_route) || (value.length < 3) ){
            value = '8304,default';
        }
        var value_split = value.split(",");
        var EXextension =	value_split[0];
        var EXcontext =		value_split[1];
        new_content = "<label class='col-md-2 control-label'><?php echo "Extension"; ?></label><div class='col-md-2'><input class='form-control' type='text' name='EXextension_" + option + "' id='EXextension_" + option + "' size='20' maxlength='255' value='" + EXextension +"'></div><label class='col-md-2 control-label'><?php echo "Context"; ?></label><div class='col-md-2'><input class='form-control' type='text' name='EXcontext_" + option + "' id='EXcontext_" + option + "' size='20' maxlength='255' value='" + EXcontext + "'></div>";
    }
    if ( (selected_route=='VOICEMAIL') || (selected_route=='VMAIL_NO_INST') ){
        if (route == selected_route){
            selected_value = value;
        }else{
            value = '101';
        }
       new_content = "<label class='col-md-3 control-label'><?php echo "Voicemail Box"; ?></label><div class='col-md-4'><input class='form-control' type='text' name='" + option + "_value' id='" + option + "_value' size='12' maxlength='10' value='" + value +"' /></div><a href='<?php echo site_url('dialer/ajax/getvoicemaillist') ?>/"+option+"_value' data-target='#ajax' data-toggle='modal' class='btn btn-info'><?php echo "voicemail chooser"; ?></a>";
    }
    if (new_content.length < 1){
        new_content = selected_route;
    }
    span_to_update.innerHTML = new_content;
    jQuery('#no_agent_action_value_span').attr('style','background:#d3d3d3 none repeat scroll 0 0;padding: 10px;');
    jQuery('#loading').modal('hide');
}
</script>
<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo site_url() ?>/assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>