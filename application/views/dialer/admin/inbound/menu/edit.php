<style>
    .form_bs .form-group {
  margin-bottom: 10px;
  margin-right: 5px;
  margin-top: 10px;
}
.double {
  margin: 15px 0;
}
.double > select {
  border: 1px solid #cccccc;
  border-radius: 4px;
  box-shadow: none;
  height: 36px;
}
.double input, .single input {
  border: 1px solid #cccccc;
  border-radius: 4px;
  height: 36px;
  text-indent: 10px;
}
.single {
  margin: 15px 0;
}
.form_bs .form-group > label {
  margin-right: 5px;
}
</style>
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
                    <label class="col-md-3 control-label"><?php echo 'Menu ID' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="menu_id" id="menu_id" class="form-control" maxlength="50" value="<?php echo $menu->menu_id ?>"/>
                        <span class="help-content"><?php echo "(no spaces or special characters)" ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Menu Name' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="menu_name" id="menu_name" class="form-control" maxlength="100" value="<?php echo $menu->menu_name ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Agency' ?></label>
                    <div class="col-md-4">
                        <?php  $tree = buildTree($agencies,0); ?>
                        <select name="agency_id" class="form-control" class="agency_id" onchange="javascript:selectGroup(this.value)">
                            <option value=""><?php echo "Please Select Agency"; ?></option>
                            <?php echo printTreeWithEncrypt($tree,0, null, $menu->agency_id ); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Admin User Group' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <select class="form-control" name="user_group" id="user_group">
                            <option value="---ALL---" <?php echo optionSetValue('','---ALL---') ?>><?php echo 'All Admin User Groups' ?></option>
                            <?php foreach($groups as $group) : ?>
                            <option value="<?php echo $group->user_group; ?>" <?php echo optionSetValue($menu->user_group, $group->user_group) ?>><?php echo $group->user_group.' - '.$group->group_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Menu Prompt' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="menu_prompt" id="menu_prompt" class="form-control" maxlength="255" value="<?php echo $menu->menu_prompt ?>"/>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo site_url('dialer/ajax/sound/menu_prompt') ?>" data-target="#ajax" data-toggle="modal"><?php echo 'Audio Chooser' ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Menu Timeout' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="menu_timeout" id="menu_timeout" class="form-control" maxlength="5" value="<?php echo $menu->menu_timeout ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Menu Timeout Prompt' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="menu_timeout_prompt" id="menu_timeout_prompt" class="form-control" maxlength="255" value="<?php echo $menu->menu_timeout_prompt ?>"/>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo site_url('dialer/ajax/sound/menu_timeout_prompt') ?>" data-target="#ajax" data-toggle="modal"><?php echo 'Audio Chooser' ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Menu Invalid Prompt' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="menu_invalid_prompt" id="menu_invalid_prompt" class="form-control" maxlength="255" value="<?php echo $menu->menu_invalid_prompt ?>"/>
                    </div>
                    <div class="col-md-2">
                        <a href="<?php echo site_url('dialer/ajax/sound/menu_invalid_prompt') ?>" data-target="#ajax" data-toggle="modal"><?php echo 'Audio Chooser' ?></a>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Menu Repeat' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="menu_repeat" id="menu_repeat" class="form-control" maxlength="5" value="<?php echo $menu->menu_repeat ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Menu Time Check' ?></label>
                    <div class="col-md-4">
                        <select name="menu_time_check" id="menu_time_check" class="form-control">
                            <option value="0" selected=""><?php echo '0 - No Time Check' ?></option>
                            <option value="1" <?php echo optionSetValue($menu->menu_time_check,'1') ?>><?php echo '1 - Time Check' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Call Menu" ?></label>
                    <div class="col-md-4">
                        <select name="call_time_id" id="call_time_id" class="form-control">
                            <option value="" selected=""><?php echo 'Please Select' ?></option>
                            <?php echo get_local_call_times($menu->call_time_id); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Track Calls in Real-Time Report' ?></label>
                    <div class="col-md-4">
                        <select name="track_in_vdac" id="track_in_vdac" class="form-control">
                            <option value="0" selected=""><?php echo '0 - No Realtime Tracking' ?></option>
                            <option value="1" <?php echo optionSetValue($menu->track_in_vdac,'1') ?>><?php echo '1 - Realtime Tracking' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Tracking Group' ?></label>
                    <div class="col-md-4">
                        <select name="tracking_group" id="tracking_group" class="form-control">
                            <option value="CALLMENU" <?php echo optionSetValue($menu->tracking_group,'CALLMENU') ?>><?php echo 'CALLMENU - Default' ?></option>
                            <?php foreach($inboundGroups as $ingroup): ?>
                            <option value="<?php echo $ingroup->group_id ?>" <?php echo optionSetValue($menu->tracking_group, $ingroup->group_id) ?>><?php echo $ingroup->group_id.' - '.$ingroup->group_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Log Key Press' ?></label>
                    <div class="col-md-4">
                        <select name="dtmf_log" id="dtmf_log" class="form-control">
                            <option value="0"><?php echo '0 - No DTMF Logging' ?></option>
                            <option value="1" <?php echo optionSetValue($menu->dtmf_log,'1') ?>><?php echo '1 - DTMF Logging Enabled' ?></option>
                        </select>
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
<?php if(strlen($menu->menu_id) > 0): ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo "Call Menu Options"; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <form id="options" name="options" id="groupForm" action="<?php echo 'dialer/inbound/savemenuoption' ?>" method="post" class="form-inline" >
            <input type="hidden" name="menu_id" value="<?php echo $menu->menu_id ?>" />
            <div class="form-body form_bs">
                <table class="table table-bordered">
                    <?php
                            $dtmf[0]='0';				$dtmf_key[0]='0';
                            $dtmf[1]='1';				$dtmf_key[1]='1';
                            $dtmf[2]='2';				$dtmf_key[2]='2';
                            $dtmf[3]='3';				$dtmf_key[3]='3';
                            $dtmf[4]='4';				$dtmf_key[4]='4';
                            $dtmf[5]='5';				$dtmf_key[5]='5';
                            $dtmf[6]='6';				$dtmf_key[6]='6';
                            $dtmf[7]='7';				$dtmf_key[7]='7';
                            $dtmf[8]='8';				$dtmf_key[8]='8';
                            $dtmf[9]='9';				$dtmf_key[9]='9';
                            $dtmf[10]='HASH';			$dtmf_key[10]='#';
                            $dtmf[11]='STAR';			$dtmf_key[11]='*';
                            $dtmf[12]='A';				$dtmf_key[12]='A';
                            $dtmf[13]='B';				$dtmf_key[13]='B';
                            $dtmf[14]='C';				$dtmf_key[14]='C';
                            $dtmf[15]='D';				$dtmf_key[15]='D';
                            $dtmf[16]='TIMECHECK';		$dtmf_key[16]='TIMECHECK';
                            $dtmf[17]='TIMEOUT';		$dtmf_key[17]='TIMEOUT';
                            $dtmf[18]='INVALID';		$dtmf_key[18]='INVALID';
                            $dtmf[19]='INVALID_2ND';	$dtmf_key[19]='INVALID_2ND';
                            $dtmf[20]='INVALID_3RD';	$dtmf_key[20]='INVALID_3RD';
                    ?>
                    <?php $j = 0; ?>
                    <?php $menus_to_print = count($options) ?>
                    <?php
                        while ($menus_to_print > $j){
                            $Aoption_value[$j] = $options[$j]->option_value;
                            $Aoption_description[$j] =	$options[$j]->option_description;
                            $Aoption_route[$j] = $options[$j]->option_route;
                            $Aoption_route_value[$j] =	$options[$j]->option_route_value;
                            $Aoption_route_value_context[$j] = $options[$j]->option_route_value_context;
                            $j++;
                        }
                    ?>
                    <?php

                        $j=0;
                        $data = getMenuOptions($menu->agency_id);
                        $data = (array) json_decode($data);
                        extract($data);
                        while ($menus_to_print > $j) :
                            $choose_height = (($j * 80) + 550);
                            $option_value = $Aoption_value[$j];
                            $option_description = $Aoption_description[$j];
                            $option_route = $Aoption_route[$j];
                            $option_route_value = $Aoption_route_value[$j];
                            $option_route_value_context = $Aoption_route_value_context[$j];

                            $dtmf_list = "<select class='form-control' size=1 name=option_value_$j>";
                            $h=0;
                            while ($h <= 20){
				$dtmf_list .= "<option";
                                if ( (preg_match("/$dtmf[$h]/",$option_value) && (strlen($option_value) == strlen($dtmf[$h])) ) )
					{$dtmf_list .= " selected";}
				$dtmf_list .= " value=\"$dtmf[$h]\"> $dtmf_key[$h]</option>";
				$h++;
                            }
                            $dtmf_list .= "</select>";
                            echo "<tr><td colspan=2><div class='form-group'>
                                    <label>".("Option").":</label> $dtmf_list </div>
                                    <div class='form-group'><label>".("Description").":</label> <input class='form-control' type=text name=option_description_$j size=40 maxlength=255 value=\"$option_description\"></div>
                                    <div class='form-group'><label>".("Route").":</label> <select class='form-control' size=1 name=option_route_$j id=option_route_$j onChange=\"call_menu_option('$j','$option_route','$option_route_value','$option_route_value_context','$choose_height');\">
                                    <option value='CALLMENU'>".("CALLMENU")."</option>
                                    <option value='INGROUP'>".("INGROUP")."</option>
                                    <option value='DID'>".("DID")."</option>
                                    <option value='HANGUP'>".("HANGUP")."</option>
                                    <option value='EXTENSION'>".("EXTENSION")."</option>
                                    <option value='PHONE'>".("PHONE")."</option>
                                    <option value='VOICEMAIL'>".("VOICEMAIL")."</option>
                                    <option value='VMAIL_NO_INST'>".("VMAIL_NO_INST")."</option>
                                    <option value='AGI'>".("AGI")."</option>
                                    <option value=\"\">* ".("REMOVE")." *</option>
                                    <option selected value=\"$option_route\">$option_route</option>
                                    </select></div>";
                            echo "<div class='form-group' id=\"option_value_value_context_$j\" name=\"option_value_value_context_$j\">\n";
                            if ($option_route=='CALLMENU'){
				echo "<label name=option_route_link_$j id=option_route_link_$j>";
				echo "Call Menu:";
				echo "</label>";
				echo " <select class='form-control' size=1 name=option_route_value_$j id=option_route_value_$j>$call_menu_list<option SELECTED>$option_route_value</option></select>\n";
                            }
			    if ($option_route=='INGROUP'){
				if (strlen($option_route_value_context) < 10)
					{$option_route_value_context = 'CID,LB,998,TESTCAMP,1,,,,';}
				$IGoption_route_value_context = explode(",",$option_route_value_context);
				$IGhandle_method =			$IGoption_route_value_context[0];
				$IGsearch_method =			$IGoption_route_value_context[1];
				$IGlist_id =				$IGoption_route_value_context[2];
				$IGcampaign_id =			$IGoption_route_value_context[3];
				$IGphone_code =				$IGoption_route_value_context[4];
				$IGvid_enter_filename =		$IGoption_route_value_context[5];
				$IGvid_id_number_filename =	$IGoption_route_value_context[6];
				$IGvid_confirm_filename =	$IGoption_route_value_context[7];
				$IGvid_validate_digits =	$IGoption_route_value_context[8];

				echo "<div class='double' ><label name=option_route_link_$j id=option_route_link_$j>";
				echo "In-Group:";
				echo "</label>";
				echo " <input  type=hidden name=option_route_value_context_$j id=option_route_value_context_$j value=\"$option_route_value_context\">";
				echo " <select size=1 name=option_route_value_$j id=option_route_value_$j>";
				echo "$ingroup_list<option SELECTED>$option_route_value</option></select>";
				echo " &nbsp; ".("<label>Handle Method</label>").": <select size=1 name=IGhandle_method_$j id=IGhandle_method_$j>";
				echo "$IGhandle_method_list<option SELECTED>$IGhandle_method</option></select> $NWB#call_menu-ingroup_settings$NWE\n </div>";
				echo "<div class='double'>".("<label>Search Method</label>").": <select size=1 name=IGsearch_method_$j id=IGsearch_method_$j>";
				echo "$IGsearch_method_list<option SELECTED>$IGsearch_method</option></select>\n";
				echo " &nbsp; ".("<label>List ID</label>").": <input type=text size=5 maxlength=19 name=IGlist_id_$j id=IGlist_id_$j value=\"$IGlist_id\"></div>";
				echo "<div class='double'>".("<label>Campaign ID</label>").": <select size=1 name=IGcampaign_id_$j id=IGcampaign_id_$j>";
				echo "$IGcampaign_id_list<option SELECTED>$IGcampaign_id</option></select>\n";
				echo " &nbsp; ".("<label>Phone Code</label>").": <input type=text size=5 maxlength=14 name=IGphone_code_$j id=IGphone_code_$j value=\"$IGphone_code\"></div>";
				echo "<div class='single'>&nbsp; ".("<label>VID Enter Filename</label>").": <input type=text name=IGvid_enter_filename_$j id=IGvid_enter_filename_$j size=40 maxlength=255 value=\"$IGvid_enter_filename\"> <a data-toggle='modal' data-target='#ajax' href='".site_url('dialer/ajax/sound/IGvid_enter_filename_'.$j)."'>".("audio chooser")."</a></div>";
				echo "<div class='single'>&nbsp; ".("<label>VID ID Number Filename</label>").": <input type=text name=IGvid_id_number_filename_$j id=IGvid_id_number_filename_$j size=40 maxlength=255 value=\"$IGvid_id_number_filename\"> <a data-toggle='modal' data-target='#ajax' href='".site_url('dialer/ajax/sound/IGvid_id_number_filename_'.$j)."'>".("audio chooser")."</a></div>";
				echo "<div class='double'>&nbsp; ".("<label>VID Confirm Filename</label>").": <input type=text name=IGvid_confirm_filename_$j id=IGvid_confirm_filename_$j size=40 maxlength=255 value=\"$IGvid_confirm_filename\"> <a data-toggle='modal' data-target='#ajax' href='".site_url('dialer/ajax/sound/IGvid_confirm_filename_'.$j)."'>".("audio chooser")."</a>";
				echo " &nbsp; ".("<label>VID Digits</label>").": <input type=text size=3 maxlength=3 name=IGvid_validate_digits_$j id=IGvid_validate_digits_$j value=\"$IGvid_validate_digits\"> </div>";
				}
                                if ($option_route=='DID'){
				$stmt="SELECT did_id from vicidial_inbound_dids where did_pattern='$option_route_value';";
				$rslt= $this->vicidialdb->db->query($stmt);
				$row = $rslt->row();
				$did_id = $row->did_id;

				echo "<label name=option_route_link_$j id=option_route_link_$j>";
				echo "DID:</a>";
				echo "</label>";
				echo " <select class='form-control' size=1 name=option_route_value_$j id=option_route_value_$j onChange=\"call_menu_link('$j','DID');\">$did_list<option SELECTED>$option_route_value</option></select>\n";
				}
                            if ($option_route=='HANGUP'){
				echo ("<label>Audio File").":</label> <input class='form-control' type=text name=option_route_value_$j id=option_route_value_$j size=50 maxlength=255 value=\"$option_route_value\"> <a href='".site_url('dialer/ajax/sound/option_route_value_'.$j)."'>".("audio chooser")."</a>\n";
                            }
                            if ($option_route=='EXTENSION'){
				echo ("<label>Extension").":</label> <input class='form-control' type=text name=option_route_value_$j id=option_route_value_$j size=20 maxlength=255 value=\"$option_route_value\"> &nbsp; ".("Context").": <input type=text name=option_route_value_context_$j id=option_route_value_context_$j size=20 maxlength=255 value=\"$option_route_value_context\">\n";
                            }
                            if ($option_route=='PHONE'){
				echo ("<label>Phone").":</label> <select class='form-control' size=1 name=option_route_value_$j id=option_route_value_$j>$phone_list<option SELECTED>$option_route_value</option></select>\n";
                            }
                            if ( ($option_route=='VOICEMAIL') or ($option_route=='VMAIL_NO_INST') ){
				echo ("<label>Voicemail Box").":</label> <input class='form-control' type=text name=option_route_value_$j id=option_route_value_$j size=12 maxlength=10 value=\"$option_route_value\"> <a data-toggle='modal' data-target='#ajax' href='".site_url('dialer/ajax/getvoicemaillist/option_route_value_'.$j)."'>".("voicemail chooser")."</a>\n";
                            }
                            if ($option_route=='AGI'){
				echo ("<label>AGI").":</label> <input class='form-control' type=text name=option_route_value_$j id=option_route_value_$j size=80 maxlength=255 value=\"$option_route_value\">\n";
                            }

			echo "</div>
			</td></tr>\n";
			$j++;
                        endwhile; //while ($menus_to_print > $j)
                    ?>
                    <?php
                        while ($j <= 20):
                            $choose_height = (($j * 80) + 550);
                            $dtmf_list = "<select size=1 class='form-control' name=option_value_$j><option value=\"\"></option>";
                            $h=0;
                            while ($h <= 20){
				$dtmf_list .= "<option value=\"$dtmf[$h]\"> $dtmf_key[$h]</option>";
				$h++;
                            }
                            $dtmf_list .= "</select>";
                            echo "<tr><td colspan=2><div class='form-group'>
                                 ".("<label>Option").":</label> $dtmf_list </div><div class='form-group'>
                                 ".("<label>Description").":</label> <input class='form-control' type=text name=option_description_$j size=40 maxlength=255 value=\"\"></div><div class='form-group'>
                                 ".("<label>Route").":</label> <select class='form-control' size=1 name=option_route_$j id=option_route_$j onChange=\"call_menu_option('$j','','','','$choose_height');\">
				<option value='CALLMENU'>".("CALLMENU")."</option>
				<option value='INGROUP'>".("INGROUP")."</option>
				<option value='DID'>".("DID")."</option>
				<option value='HANGUP'>".("HANGUP")."</option>
				<option value='EXTENSION'>".("EXTENSION")."</option>
				<option value='PHONE'>".("PHONE")."</option>
				<option value='VOICEMAIL'>".("VOICEMAIL")."</option>
				<option value='VMAIL_NO_INST'>".("VMAIL_NO_INST")."</option>
				<option value='AGI'>".("AGI")."</option>
				<option SELECTED value=\"\"> </option>
			</select></div>
			<div class='form-group' id=\"option_value_value_context_$j\" name=\"option_value_value_context_$j\">\n";
			echo "</div>
			 </td></tr>\n";
			$j++;
                        endwhile;
                    ?>
                </table>
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
<?php endif; ?>
<script type="text/javascript">
jQuery(function(){
    jQuery('.menu-edit').addClass('active');
    jQuery('#call-menu').addClass('active');
    jQuery('#groupForm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules:{
           menu_id :{
               required: true,
               minlenght: 2,
               maxlenght: 50,

           },
           menu_name:{
               required: true,
               maxlenght: 255,
           }
       },
        highlight: function (element) { // hightlight error inputs
             $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
});
function selectGroup(agency_id, groupId){
    groupId = '<?php echo isset($menu->group_id) ? $menu->group_id : "" ?>';
    jQuery.ajax({
        url : '<?php echo site_url('dialer/ajax/getAgencyGroup/') ?>',
        method : 'POST',
        dataType : 'json',
        data : {id : agency_id,group: groupId},
        success: function(result){
            var flag = Boolean(result.success);
            jQuery('#user_group').replaceWith(result.html);
        }
    });
}
function chooseFile(file, id){
    jQuery('#'+ id).val(file);
    jQuery('#ajax').modal('hide');
}
function selectTrackingGroup(agencyId, groupId){
    groupId = '<?php echo $menu->tracking_group ?>';
    jQuery.ajax({
       url : '<?php echo site_url('dialer/ajax/') ?>',
       method : 'POST',
       dataType : 'json',
       data : {id: agencyId, group: groupId},
       success: function(result){
           var flag = Boolean(result.success);
           jQuery('#tracking_group').replaceWith(result.html);
       }
    });
}
function call_menu_option(option,route,value,value_context,chooser_height){
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
//    console.log(call_menu_list);
//    console.log(ingroup_list);
//    console.log(IGcampaign_id_list);
//    console.log(IGhandle_method_list);
//    console.log(IGsearch_method_list);
//    console.log(did_list);
//    console.log(phone_list);
    var select_list = document.getElementById("option_route_" + option);
    var selected_route = select_list.value;
    var span_to_update = document.getElementById("option_value_value_context_" + option);
    if (selected_route=='CALLMENU'){
        if (route == selected_route){
            selected_value = '<option SELECTED value="' + value + '">' + value + "</option>\n";
        }else{
            value='';
        }
        new_content = '<label name=option_route_link_' + option + ' id=option_route_link_' + option + "><?php echo ("Call Menu"); ?>:</label><select class='form-control' size=1 name=option_route_value_" + option + " id=option_route_value_" + option + " onChange=\"call_menu_link('" + option + "','CALLMENU');\">" + call_menu_list + "\n" + selected_value + '</select>';
    }
    if (selected_route=='INGROUP'){
        if (value_context.length < 10){value_context = 'CID,LB,998,TESTCAMP,1,,,,';}
        var value_context_split =		value_context.split(",");
        var IGhandle_method =			value_context_split[0];
        var IGsearch_method =			value_context_split[1];
        var IGlist_id =					value_context_split[2];
        var IGcampaign_id =				value_context_split[3];
        var IGphone_code =				value_context_split[4];
        var IGvid_enter_filename =		value_context_split[5];
        var IGvid_id_number_filename =	value_context_split[6];
        var IGvid_confirm_filename =	value_context_split[7];
        var IGvid_validate_digits =		value_context_split[8];

        if (route == selected_route){
            selected_value = '<option SELECTED>' + value + '</option>';
        }

        new_content = '<input type=hidden name=option_route_value_context_' + option + ' id=option_route_value_context_' + option + ' value="' + selected_value + '">';
        new_content = new_content + '<div class="double"><label name=option_route_link_' + option + 'id=option_route_link_' + option + '>';
        new_content = new_content + '<?php echo ("In-Group"); ?>:</label>';
        new_content = new_content + '<select size=1 name=option_route_value_' + option + ' id=option_route_value_' + option + ' onChange="call_menu_link("' + option + '","INGROUP");">';
        new_content = new_content + '' + ingroup_list + "\n" + selected_value + '</select>';
        new_content = new_content + ' &nbsp; <?php echo ("Handle Method"); ?>: <select size=1 name=IGhandle_method_' + option + ' id=IGhandle_method_' + option + '>';
        new_content = new_content + '' + IGhandle_method_list + "\n" + '<option SELECTED>' + IGhandle_method + '</select></div>';
        new_content = new_content + '<div class="double"><?php echo ("Search Method"); ?>: <select size=1 name=IGsearch_method_' + option + ' id=IGsearch_method_' + option + '>';
        new_content = new_content + '' + IGsearch_method_list + "\n" + '<option SELECTED>' + IGsearch_method + '</select>';
        new_content = new_content + ' &nbsp; <?php echo ("List ID"); ?>: <input type=text size=5 maxlength=14 name=IGlist_id_' + option + ' id=IGlist_id_' + option + ' value="' + IGlist_id + '"></div>';
        new_content = new_content + '<div class="double"><?php echo ("Campaign ID"); ?>: <select size=1 name=IGcampaign_id_' + option + ' id=IGcampaign_id_' + option + '>';
        new_content = new_content + '' + IGcampaign_id_list + "\n" + '<option SELECTED>' + IGcampaign_id + '</select>';
        new_content = new_content + ' &nbsp; <?php echo ("Phone Code"); ?>: <input type=text size=5 maxlength=14 name=IGphone_code_' + option + ' id=IGphone_code_' + option + ' value="' + IGphone_code + '"></div>';
        new_content = new_content + "<div class='single'>&nbsp; <?php echo ("VID Enter Filename"); ?>: <input type=text name=IGvid_enter_filename_" + option + " id=IGvid_enter_filename_" + option + " size=40 maxlength=255 value=\"" + IGvid_enter_filename + "\"> <a data-toggle='modal' data-target='#ajax' href='<?php echo site_url('dialer/ajax/sound/IGvid_enter_filename_') ?>"+option+"'><?php echo ("audio chooser"); ?></a></div>";
        new_content = new_content + "<div class='single'>&nbsp; <?php echo ("VID ID Number Filename"); ?>: <input type=text name=IGvid_id_number_filename_" + option + " id=IGvid_id_number_filename_" + option + " size=40 maxlength=255 value=\"" + IGvid_id_number_filename + "\"> <a data-toggle='modal' data-target='#ajax' href='<?php echo site_url('dialer/ajax/sound/IGvid_id_number_filename_') ?>"+option+"'><?php echo ("audio chooser"); ?></a></div>";
        new_content = new_content + "<div class='double'>&nbsp; <?php echo ("VID Confirm Filename"); ?>: <input type=text name=IGvid_confirm_filename_" + option + " id=IGvid_confirm_filename_" + option + " size=40 maxlength=255 value=\"" + IGvid_confirm_filename + "\"> <a data-toggle='modal' data-target='#ajax' href='<?php echo site_url('dialer/ajax/sound/IGvid_confirm_filename_') ?>"+option+"'><?php echo ("audio chooser"); ?></a>";
        new_content = new_content + ' &nbsp; <?php echo ("VID Digits"); ?>: <input type=text size=3 maxlength=3 name=IGvid_validate_digits_' + option + ' id=IGvid_validate_digits_' + option + ' value="' + IGvid_validate_digits + '"></div>';
    }
    if (selected_route=='DID'){
        if (route == selected_route){
            selected_value = '<option SELECTED value="' + value + '">' + value + "</option>\n";
        }else{
            value='';
        }
        new_content = '<label name=option_route_link_' + option + ' id=option_route_link_' + option + '><?php echo ("DID"); ?>:</label><select class="form-control" size=1 name=option_route_value_' + option + ' id=option_route_value_' + option + ">" + did_list + "\n" + selected_value + '</select>';
    }
    if (selected_route=='HANGUP'){
        if (route == selected_route){
            selected_value = value;
        }else{
            value='vm-goodbye';
        }
        new_content = "<label><?php echo ("Audio File"); ?>:</label> <input class='form-control' type=text name=option_route_value_" + option + " id=option_route_value_" + option + " size=40 maxlength=255 value=\"" + selected_value + "\"> <a data-toggle='modal' data-target='#ajax' href='<?php echo site_url('dialer/ajax/sound/option_route_value_') ?>"+option+"' ><?php echo ("audio chooser"); ?></a>";
    }
    if (selected_route=='EXTENSION'){
        if (route == selected_route){
            selected_value = value;
            selected_context = value_context;
        }else{
            value='8304';
        }
        new_content = "<label><?php echo ("Extension"); ?>:</label> <input class='form-control' type=text name=option_route_value_" + option + " id=option_route_value_" + option + " size=20 maxlength=255 value=\"" + selected_value + "\"> &nbsp; <?php echo ("Context"); ?>: <input type=text name=option_route_value_context_" + option + " id=option_route_value_context_" + option + " size=20 maxlength=255 value=\"" + selected_context + "\"> ";
    }
    if (selected_route=='PHONE'){
        if (route == selected_route){
            selected_value = '<option SELECTED value="' + value + '">' + value + "</option>\n";
        }else{
            value='';
        }
        new_content = '<label><?php echo ("Phone"); ?>:</label> <select class="form-control" size=1 name=option_route_value_' + option + ' id=option_route_value_' + option + '>' + phone_list + "\n" + selected_value + '</select>';
    }
    if ( (selected_route=='VOICEMAIL') || (selected_route=='VMAIL_NO_INST') ){
        if (route == selected_route){
            selected_value = value;
        }else{
            value='';
        }
        new_content = "<label><?php echo ("Voicemail Box"); ?>:</label> <input class='form-control' type=text name=option_route_value_" + option + " id=option_route_value_" + option + " size=12 maxlength=10 value=\"" + selected_value + "\"> <a data-toggle='modal' data-target='#ajax' href='<?php echo site_url('dialer/ajax/getvoicemaillist/option_route_value_') ?>"+option+"'><?php echo ("voicemail chooser"); ?></a>";
    }
    if (selected_route=='AGI'){
        if (route == selected_route){
            selected_value = value;
        }else{
            value='';
        }
        new_content = "<label><?php echo ("AGI"); ?>:</label> <input class='form-control' type=text name=option_route_value_" + option + " id=option_route_value_" + option + " size=80 maxlength=255 value=\"" + selected_value + "\"> ";
    }
    if (new_content.length < 1){new_content = selected_route}
    span_to_update.innerHTML = new_content;
    jQuery('#loading').modal('hide');
}
function selectVoicemail(voicemail, field){
    jQuery('#'+field).val(voicemail);
    jQuery('#ajax').modal('hide');
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