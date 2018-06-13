<?php
defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
    function dump ($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable
        ob_start();
        var_dump($var);
        $output = ob_get_clean();

        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';

        // Output
        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}


if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}

if(!function_exists('get_dialer_option'))
{
	function get_dialer_option($name = NULL)
	{
		$CI =& get_instance();
                $CI->load->library('vicidialdb');
                $CI->vicidialdb->db->select('label_title,label_first_name,label_middle_initial,label_last_name,label_address1,label_address2,label_address3,label_city,label_state,label_province,label_postal_code,label_vendor_lead_code,label_gender,label_phone_number,label_phone_code,label_alt_phone,label_security_phrase,label_email,label_comments');
                $CI->vicidialdb->db->from('system_settings');
		$query = $CI->vicidialdb->db->get();
                $option = $query->unbuffered_row();
		if(!$option){
			return '';
		}
		return $option;
	}
}

if(!function_exists('optionSetValue'))
{
	function optionSetValue($value, $check)
	{
		$selected = "";
		if( trim($value) == trim($check))
		{
			$selected = 'selected="selected"';
		}
		return $selected;
	}
}

if(!function_exists('get_local_call_times'))
{
    function get_local_call_times($check = '')
    {
        $CI = &get_instance();
        $CI->load->model('vicidial/vcalltime_m','vcalltime_m');
        $callTimes = $CI->vcalltime_m->get();
        $options = '';

        foreach ($callTimes as $key => $calltime) {
            if($check == $calltime->call_time_id){
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $options .= '<option value="'.$calltime->call_time_id.'" '.$selected.'>'.$calltime->call_time_id.'-'.$calltime->call_time_name.'</option>';
        }
        return $options;
    }
}

if(!function_exists('get_scripts_options'))
{
    function get_scripts_options($check = '')
    {
        $CI = &get_instance();
        $CI->load->model('dscripts_m');
        $scripts = $CI->dscripts_m->get();
        $options = '<option value="None" selected="selected">None</option>\n';
        foreach ($scripts as $key => $script) {
            if($check == $script->id){
                $selected = 'selected="selected"';
            }else {
                $selected = '';
            }
            $options .= '<option value="'.$script->id.'" '.$selected.'>'.$script->script_id.'-'.$script->script_name.'</option>';
        }
        return $options;
    }
}

if(!function_exists('gethotKeyStatuses'))
{
    function gethotKeyStatuses($check = '', $campaign_id)
    {
        $CI = &get_instance();
        $CI->load->model('dstatuses_m');
        $CI->load->model('dcstatuses_m');

        $statuses = $CI->dstatuses_m->get();
        $HKstatuses_list = '<option value="">Please Select Option</option>';
        foreach ($statuses as $key => $status) {
            if(preg_match('/Y/i', $status->selectable)){
                    $HKstatuses_list .= "<option data-id=\"$status->status\" data-name=\"$status->status_name\" value=\"$status->status-----$status->status_name\">$status->status - $status->status_name</option>\n";
            }
        }
        $customStatuses = $CI->dcstatuses_m->get_by(array('campaign_id' => $campaign_id));

        if( count($customStatuses) > 0 ){
            foreach($customStatuses as $cStatus){
                if(preg_match('/Y/i', $cStatus->selectable)){
                    $HKstatuses_list .= "<option data-id=\"$cStatus->status\" data-name=\"$cStatus->status_name\" value=\"$cStatus->status-----$cStatus->status_name\">$cStatus->status - $cStatus->status_name</option>\n";
                }
            }
        }
        return $HKstatuses_list;
    }
}
if( !function_exists('getLeadRecycleStatuses') ){

	function getLeadRecycleStatuses($check = NULL,  $campaign_id)
	{
		$CI =& get_instance();
                $CI->load->model('vicidial/vstatuses','vstatuses');
//                $CI->load->model('dcstatuses_m');
		$statuses = $CI->vstatuses->get();
		$LRstatuses_list = '<option selected="" value="">Please Select Option</option>';

		foreach ($statuses as $key => $lrstatus) {
                        if( $check == $lrstatus->status ){
                            $selected = 'selected="selected"';
                        }else{
                           $selected = '';
                        }
			$LRstatuses_list .= "<option {$selected} value=\"$lrstatus->status\">$lrstatus->status - $lrstatus->status_name</option>\n";
		}
//                $customStatuses = $CI->dcstatuses_m->get_by(array('campaign_id' => $campaign_id));
//                if( count($customStatuses) > 0 ){
//                    foreach($customStatuses as $cStatus){
//                        if( $check == $cStatus->status ){
//                            $selected = 'selected="selected"';
//                        }else{
//                           $selected = '';
//                        }
//                        $LRstatuses_list .= "<option {$selected} data-id=\"$cStatus->status\" data-name=\"$cStatus->status_name\" value=\"$cStatus->status\">$cStatus->status - $cStatus->status_name</option>\n";
//                    }
//                }
                return $LRstatuses_list;

	}
}
if( !function_exists('getDialStatuses') )
{
    function getDialStatuses($check = NULL,  $campaign_id)
    {
        $CI = & get_instance();
        $CI->load->model('dstatuses_m');
        $CI->load->model('dcstatuses_m');
        $statuses = $CI->dstatuses_m->get();
        $Dialstatuses_list = '<option value="">-None-</option>';
        foreach ($statuses as $key => $lrstatus) {
            if( $lrstatus->status != 'CBHOLD' ){
                if( $check == $lrstatus->status ){
                    $selected = 'selected="selected"';
                }else{
                   $selected = '';
                }
                $Dialstatuses_list .= "<option {$selected} value=\"$lrstatus->status\">$lrstatus->status - $lrstatus->status_name</option>\n";
            }
         }
        $customStatuses = $CI->dcstatuses_m->get_by(array('campaign_id' => $campaign_id));
        if( count($customStatuses) > 0 ){
            foreach($customStatuses as $cStatus){
                if( $check == $cStatus->status ){
                    $selected = 'selected="selected"';
                }else{
                   $selected = '';
                }
                $Dialstatuses_list .= "<option {$selected} data-id=\"$cStatus->status\" data-name=\"$cStatus->status_name\" value=\"$cStatus->status\">$cStatus->status - $cStatus->status_name</option>\n";
            }
        }

        return $Dialstatuses_list;
    }
}
if(!function_exists('clean')){
    function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}
if(!function_exists('getFilterList')){
    function getFilterList($check = NULL){
        $filters_list="<option value=\"\">NONE</option>\n";
        $CI = &get_instance();
        $CI->load->model('vicidial/vlfilters_m','vlfilters_m');
        $filters = $CI->vlfilters_m->get();
        foreach($filters as $filter){
            $selected = '';
            if($filter->lead_filter_id == $check){
                $selected = 'selected="selected"';
            }
            $filters_list .= "<option value=\"$filter->lead_filter_id\">$filter->lead_filter_id - $filter->lead_filter_name</option>\n";
        }
        return $filters_list;
    }
}
if(!function_exists('getGroups')){
    function getGroups($parentAgency, $currentAgency, $check = ""){
        $CI = &get_instance();
        $CI->load->model('vicidial/vugroup_m','vugroup_m');
        $array = array($parentAgency, $currentAgency);
        $CI->db->where_in('agency_id',$array);
        $groups = $CI->db->get('agency_agent_groups')->result();
        $options = '';
        if(count($groups) > 0){
            foreach ($groups as $group){
                $viciGroup = $CI->vugroup_m->get_by(array('id' => $group->vicidial_group_id), true);
                if($viciGroup){
                    $selected = '';
                    if( trim($check) == $viciGroup->user_group ){
                        $selected = 'selected="selected"';
                    }
                    $options .= '<option value="'.$viciGroup->user_group.'" '.$selected.'>'.$viciGroup->user_group.' - '.$viciGroup->group_name.'</option>';
                }
            }
        }
        return $options;
    }
}
if(!function_exists('get_client_ip')){
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}

if(!function_exists('lookup_gmt')){
    function lookup_gmt($phone_code, $postel_code){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $query = "SELECT postal_code,state,GMT_offset,DST,DST_range,country,country_code FROM vicidial_postal_codes where country_code = '{$phone_code}' and postal_code like '{$postel_code}'";
        $row = $CI->vicidialdb->db->query($query)->row();
        return $row;
    }
}

if(!function_exists('getDespositionStatus')){
    function getDespositionStatus($lead, $check){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $scheduled_callback='';
        $statuses_list='';
        /* check schedule callback */
        $stmt="SELECT scheduled_callback from vicidial_statuses where status='{$lead->status}'";
        $results = $CI->vicidialdb->db->query($stmt)->row_array();
        if(count($results) > 0){
            if (strlen($results['scheduled_callback'])>0 ){
                $scheduled_callback =	$results['scheduled_callback'];
            }
        }
        $stmt="SELECT scheduled_callback from vicidial_campaign_statuses where status='{$lead->status}'";
        $results = $CI->vicidialdb->db->query($stmt)->row_array();
        if(count($results) > 0){
            if (strlen($results['scheduled_callback'])>0 ){
                $scheduled_callback =	$results['scheduled_callback'];
            }
        }
        $o=0;
        $DS=0;
        $stmt = "SELECT status,status_name,selectable,human_answered,category,sale,dnc,customer_contact,not_interested,unworkable from vicidial_statuses where selectable='Y' order by status";
        $query = $CI->vicidialdb->db->query($stmt);
        $results = $query->result();
        $statuses_to_print = $query->num_rows();
        while($statuses_to_print > $o){
            $selected = '';
            if($check == $results[$o]->status){
                $selected = 'selected="selected"';
                $DS++;
            }
            $statuses_list.= '<option value="'.$results[$o]->status.'" '.$selected.'>'.$results[$o]->status.'-'.$results[$o]->status_name.'</option>';
            $o++;
        }

        $CI->load->model('vicidial/vlists_m','vlists_m');
        $list = $CI->vlists_m->get_by(array('list_id' => $lead->list_id), TRUE);
        $campaign_id = $list->campaign_id;
        $stmt="SELECT status,status_name,selectable,campaign_id,human_answered,category,sale,dnc,customer_contact,not_interested,unworkable from vicidial_campaign_statuses where campaign_id='$campaign_id' and selectable='Y' order by status";
        $query = $CI->vicidialdb->db->query($stmt);
        $CAMPstatuses_to_print = $query->num_rows();
        $results = $query->result();
        $o=0;
        $CBhold_set=0;
        while($CAMPstatuses_to_print > $o){
            $selected = '';
            if($check == $results[$o]->status){
                $selected = 'selected="selected"';
                $DS++;
            }
            $statuses_list.= '<option value="'.$results[$o]->status.'" '.$selected.'>'.$results[$o]->status.'-'.$results[$o]->status_name.'</option>';
            if ($results[$o]->status == 'CBHOLD') {$CBhold_set++;}
            $o++;
        }
        if ($lead->status == 'CBHOLD') {$CBhold_set++;}
        if ($DS < 1){
            $statuses_list .= "<option SELECTED value=\"$lead->status\">$lead->status</option>\n";
        }
        if ($CBhold_set < 1){
            $statuses_list .= "<option value=\"CBHOLD\">CBHOLD - Scheduled Callback</option>\n";
        }
        return $statuses_list;
    }
}

if(!function_exists('getAgencyLists')){
    function getAgencyLists(){
        $CI = &get_instance();
        $query = "select id from {$CI->db->protect_identifiers('agencies',TRUE)} WHERE parent_agency={$CI->session->userdata('agency')->id}";
        $results = $CI->db->query($query)->result_array();
        $ids[] = $CI->session->userdata('agency')->id;
        foreach($results as $result){
            $ids[] = $result['id'];
        }
        $CI->db->where_in('agency_id',$ids);
        $array = $CI->db->get('agency_lists')->result_array();
        if($array){
           $lists = implode(',',array_column($array, 'vicidial_list_id'));
        }else{
            $lists = implode(',',array("''"));
        }
        return $lists;
    }
}

if(!function_exists('getAgencies')){
    function getAgencies(){
        $CI = &get_instance();
        $query = "select id from {$CI->db->protect_identifiers('agencies',TRUE)} WHERE parent_agency={$CI->session->userdata('agency')->id}";
        $results = $CI->db->query($query)->result_array();
        $ids[] = $CI->session->userdata('agency')->id;
        foreach($results as $result){
            $ids[] = $result['id'];
        }
        return implode(',',$ids);
    }
}

if(!function_exists('getVoicemailZones')){
    function getVoicemailZones(){
        $CI =& get_instance();
        $CI->load->library('vicidialdb');
        $CI->vicidialdb->db->select('voicemail_timezones');
        $CI->vicidialdb->db->from('system_settings');
        $query = $CI->vicidialdb->db->get();
        $option = $query->unbuffered_row();
        return $option->voicemail_timezones;
    }
}
/**
 * get the sound files from the vicidial server
 */
if(!function_exists('getSoundFileList')){
    function getSoundFileList(){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $tablename = 'system_settings';
        $qry = "SELECT sounds_web_server,sounds_web_directory FROM {$tablename}";
        $query = $CI->vicidialdb->db->query($qry);
        $row = $query->unbuffered_row();
        $url = $CI->config->item('vicidial_url');
        $url .= $row->sounds_web_directory;
        $html = file_get_contents($url);
        $count = preg_match_all('/<td><a href="([^"]+)">[^<]*<\/a><\/td>/i', $html, $files);
       /* for ($i = 1; $i < $count; ++$i) {
            echo "File: " . $files[1][$i] . "<br />\n";
        }*/
        return $files;
    }
}

if(!function_exists('cleanFileName')){
    function cleanFileName($audiofile_name){
        $audiofile_name = preg_replace("/ /",'',$audiofile_name);
        $audiofile_name = preg_replace("/@/",'',$audiofile_name);
        $audiofile_name = preg_replace("/\(/",'',$audiofile_name);
        $audiofile_name = preg_replace("/\)/",'',$audiofile_name);
        $audiofile_name = preg_replace("/\#/",'',$audiofile_name);
        $audiofile_name = preg_replace("/\&/",'',$audiofile_name);
        $audiofile_name = preg_replace("/\*/",'',$audiofile_name);
        $audiofile_name = preg_replace("/\!/",'',$audiofile_name);
        $audiofile_name = preg_replace("/\%/",'',$audiofile_name);
        $audiofile_name = preg_replace("/\^/",'',$audiofile_name);
        return $audiofile_name;
    }
}

if(!function_exists('voicemailList')){
    function voicemailList(){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $stmt="SELECT voicemail_id,fullname,email from vicidial_voicemail where active='Y' order by voicemail_id";
        $voicemails1 = $CI->vicidialdb->db->query($stmt)->result_array();
        $stmt="SELECT voicemail_id,fullname,email,extension from phones where active='Y' order by voicemail_id";
        $voicemails2 = $CI->vicidialdb->db->query($stmt)->result_array();
        return array_merge($voicemails1,$voicemails2);
    }
}

if(!function_exists('getInboundGroups')){
    function getInboundGroups($agencyId = NULL){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $stmt = "SELECT group_id,group_name from vicidial_inbound_groups where group_id NOT IN('AGENTDIRECT','AGENTDIRECT_CHAT') order by group_id";
        if($agencyId){

        }
        $query = $CI->vicidialdb->db->query($stmt);
        $result = $query->result();
        return $result;
    }
}

if(!function_exists('getMenuOptions')){
   function getMenuOptions($agnecyId = 0){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $CI->load->model('agency_model');
        $CI->load->model('vicidial/indid_m','indid_m');
        $CI->load->model('vicidial/ainded_m','ainded_m');
        $CI->load->model('vicidial/vugroup_m','vugroup_m');
        $CI->load->model('vicidial/vclassmenu_m', 'vclassmenu_m');
        $CI->load->model('vicidial/acallmenu_m', 'acallmenu_m');
        $CI->load->model('vicidial/vcalloption_m','vcalloption_m');
        $CI->load->model('vicidial/vcampaigns_m', 'vcampaigns_m');
        $CI->load->model('vicidial/aphones_m','aphones_m');

        $call_menu_list = '';
        $ingroup_list='';
        $IGcampaign_id_list='';
        $did_list='';
        $phone_list='';
        $IGhandle_method_list = '<option>CID</option><option>CIDLOOKUP</option><option>CIDLOOKUPRL</option><option>CIDLOOKUPRC</option><option>CIDLOOKUPALT</option><option>CIDLOOKUPRLALT</option><option>CIDLOOKUPRCALT</option><option>CIDLOOKUPADDR3</option><option>CIDLOOKUPRLADDR3</option><option>CIDLOOKUPRCADDR3</option><option>CIDLOOKUPALTADDR3</option><option>CIDLOOKUPRLALTADDR3</option><option>CIDLOOKUPRCALTADDR3</option><option>ANI</option><option>ANILOOKUP</option><option>ANILOOKUPRL</option><option>VIDPROMPT</option><option>VIDPROMPTLOOKUP</option><option>VIDPROMPTLOOKUPRL</option><option>VIDPROMPTLOOKUPRC</option><option>CLOSER</option><option>3DIGITID</option><option>4DIGITID</option><option>5DIGITID</option><option>10DIGITID</option>';
        $IGsearch_method_list = '<option value="LB">LB - '.("Load Balanced").'</option><option value="LO">LO - '.("Load Balanced Overflow").'</option><option value="SO">SO - '.("Server Only").'</option>';

        $id = $agnecyId;
            if($agnecyId > 0){
                $CI->vclassmenu_m->createTempTable();
                $tempTable = $CI->vclassmenu_m->_temptable;
                $stmt="SELECT menu_id,menu_name from {$tempTable} as main,agency_call_menu as sub WHERE main.menu_id = sub.vicidial_menu_id AND sub.agency_id = {$id} ORDER BY menu_id limit 10000;";
                $query = $CI->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $call_menu_list.= '<option value="'.$row['menu_id'].'">'.$row['menu_id'].' - '.$row['menu_name'].'</option>';
                }
                /*
                 * to do : add agency filter
                 */
                $stmt="SELECT group_id,group_name from vicidial_inbound_groups where active='Y' and group_id NOT LIKE \"AGENTDIRECT%\" order by group_id;";
                $query = $CI->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $ingroup_list.= '<option value="'.$row['group_id'].'">'.$row['group_id'].' - '.$row['group_name'].'</option>';
                }
                /* campaigns */
                $CI->vcampaigns_m->cretaeTempTable();
                $stmt="SELECT campaign_id,campaign_name from vicidial_campaigns as main,agency_campaigns as sub where active='Y' AND main.campaign_id = sub.vicidial_campaign_id AND sub.agency_id = {$id}  order by campaign_id;";
                $query = $CI->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $IGcampaign_id_list.= '<option value="'.$row['campaign_id'].'">'.$row['campaign_id'].' - '.$row['campaign_name'].'</option>';
                }
                /* did options*/
                $CI->indid_m->createTempTable();
                $tempTable = $CI->indid_m->_temptable ;
                $stmt="SELECT main.did_id,did_pattern,did_description,did_route from {$tempTable} as main,agency_inbound_did as sub where did_active='Y' AND main.did_id = sub.vicidial_did_id order by did_pattern;";
                $query = $CI->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $did_list.= '<option value="'.$row['did_pattern'].'">'.$row['did_pattern'].' - '.$row['did_description'].'</option>';
                }
                /* phone list */
                $CI->aphones_m->createTempTable();
                $tempTable = $CI->aphones_m->_temptable;
                $ids[] = $id;
                $vUserIds = array();
                $stmt = "SELECT id,vicidial_user_id FROM agencies WHERE id = $id";
                $query = $CI->db->query($stmt);
                $row = $query->row_array();
                $vUserIds[] = $row['vicidial_user_id'];
//                $stmt = "SELECT id,vicidial_user_id FROM agencies WHERE parent_agency = $id";
//                $query = $this->db->query($stmt);
//                $results = $query->result_array();
//                foreach($results as $row){
//                    $ids = $row['id'];
//                    $vUserIds[] = $row['vicidial_user_id'];
//                }
                $stmt = "SELECT id,vicidial_user_id FROM agents WHERE agency_id = $id";
                $query = $CI->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $vUserIds[] = $row['vicidial_user_id'];
                }
                $vUserIds = implode(',', $vUserIds);
                $stmt="SELECT login,server_ip,extension,dialplan_number from {$tempTable} as main, users_phones as sub where active='Y' AND main.id = sub.vicidial_phone_id AND sub.vicidial_user_id IN({$vUserIds}) order by login,server_ip;";
                $query = $CI->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $phone_list.= '<option value="'.$row['login'].'">'.$row['login'].' - '.$row['server_ip'].' - '.$row['extension'].' - '.$row['dialplan_number'].'</option>';
                }
            }else{
                /* call menu */
                $stmt="SELECT menu_id,menu_name from vicidial_call_menu order by menu_id limit 10000;";
                $query = $CI->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $call_menu_list.= '<option value="'.$row['menu_id'].'">'.$row['menu_id'].' - '.$row['menu_name'].'</option>';
                }
                /* inbound group */
                $stmt="SELECT group_id,group_name from vicidial_inbound_groups where active='Y' and group_id NOT LIKE \"AGENTDIRECT%\" order by group_id;";
                $query = $CI->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $ingroup_list.= '<option value="'.$row['group_id'].'">'.$row['group_id'].' - '.$row['group_name'].'</option>';
                }
                /* campaigns */
                $stmt="SELECT campaign_id,campaign_name from vicidial_campaigns where active='Y' order by campaign_id;";
                $query = $CI->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $IGcampaign_id_list.= '<option value="'.$row['campaign_id'].'">'.$row['campaign_id'].' - '.$row['campaign_name'].'</option>';
                }
                /* did options*/
                $stmt="SELECT did_pattern,did_description,did_route from vicidial_inbound_dids where did_active='Y' order by did_pattern;";
                $query = $CI->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $did_list.= '<option value="'.$row['did_pattern'].'">'.$row['did_pattern'].' - '.$row['did_description'].'</option>';
                }
                /* phone list */
                $stmt="SELECT login,server_ip,extension,dialplan_number from phones where active='Y' order by login,server_ip;";
                $query = $CI->vicidialdb->db->query($stmt);
                $results = $query->result_array();
                foreach($results as $row){
                    $phone_list.= '<option value="'.$row['login'].'">'.$row['login'].' - '.$row['server_ip'].' - '.$row['extension'].' - '.$row['dialplan_number'].'</option>';
                }
            }
            $output['call_menu_list'] = $call_menu_list;
            $output['ingroup_list'] = $ingroup_list;
            $output['IGcampaign_id_list'] = $IGcampaign_id_list;
            $output['did_list'] = $did_list;
            $output['phone_list'] = $phone_list;
            return json_encode($output);
   }
}

if(!function_exists('getScripts')){
    function getScripts($check = ''){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $stmt = "SELECT script_id,script_name from vicidial_scripts order by script_id";
        $query = $CI->vicidialdb->db->query($stmt);
        $results = $query->result();
        $QCscripts_list = "";
        foreach($results as $row){
            $selected = '';
            if($check == $row->script_id){
                $selected = 'selected="selected"';
            }
            $QCscripts_list .= '<option value="'.$row->script_id.'" '.$selected.'>'.$row->script_id.' - '.$row->script_name.'</option>';
        }
        return $QCscripts_list;
    }
}

/**
 * this function will get agency from vicidial user id
 */
if(!function_exists('getAgncyFromUsetId')){
    function getAgncyFromUserId($vUserId){
        $CI = &get_instance();
        if($vUserId > 0){
            $stmt = "SELECT * FROM agencies WHERE vicidial_user_id = {$vUserId}";
            $query = $CI->db->query($stmt);
            $row = $query->row();
            if($row){
               $vUserId = $row->id;
            }else{
                $stmt = "SELECT * FROM agents WHERE vicidial_user_id = {$vUserId}";
                $query = $CI->db->query($stmt);
                $row = $query->row();
                if($row){
                   $vUserId = $row->agency_id;
                }
            }
        }
        return $vUserId;
    }
}
/*
 * get the agency inbound groups for user settings
 */
if(!function_exists('getInboundGroupsForUser')){
    function getInboundGroupsForUser($agencyId = NULL){
        $CI = &get_instance();
        $CI->load->model('vicidial/vingroup_m','vingroup_m');
        $CI->vingroup_m->createTempTable();
        $_tempTable = $CI->vingroup_m->_temptable;
        if($agencyId){
            $sql = "SELECT main.*,amain.id,amain.agency_id,age.name FROM {$CI->db->protect_identifiers($_tempTable, TRUE)} AS main LEFT JOIN {$CI->db->protect_identifiers('agency_inbound_group', TRUE)} amain ON amain.vicidial_ingroup_id=main.group_id LEFT JOIN {$CI->db->protect_identifiers('agencies', TRUE)} age ON amain.agency_id=age.id WHERE amain.agency_id = {$agencyId}";
            $query = $CI->db->query($sql);
            $results1 = $query->result();
            $sql = "SELECT main.*,amain.id,amain.agency_id,age.name FROM {$CI->db->protect_identifiers($_tempTable, TRUE)} AS main LEFT JOIN {$CI->db->protect_identifiers('agency_inbound_group', TRUE)} amain ON amain.vicidial_ingroup_id=main.group_id LEFT JOIN {$CI->db->protect_identifiers('agencies', TRUE)} age ON amain.agency_id=age.id WHERE amain.agency_id IS NULL";
            $query = $CI->db->query($sql);
            $results2 = $query->result();
            $results = array_merge($results1,$results2);
        }else{
            $results = FALSE;
        }
        if(!$results){
            $sql = "SELECT main.*,amain.id,amain.agency_id,age.name FROM {$CI->db->protect_identifiers($_tempTable, TRUE)} AS main LEFT JOIN {$CI->db->protect_identifiers('agency_inbound_group', TRUE)} amain ON amain.vicidial_ingroup_id=main.group_id LEFT JOIN {$CI->db->protect_identifiers('agencies', TRUE)} age ON amain.agency_id=age.id";
            $query = $CI->db->query($sql);
            $results = $query->result();

        }
        return $results;
    }
}
##### BEGIN reformat seconds into HH:MM:SS or MM:SS #####
if(!function_exists('sec_convert')){
    function sec_convert($sec,$precision){
        $sec = round($sec,0);
        if ($sec < 1){
            if ($precision == 'HF')
                {return "0:00:00";}
            else{
                if ($precision == 'S'){
                    return "0";
                }else{
                    return "0:00";
                }
            }
        }else{
            if ($precision == 'HF'){
                $precision='H';
            }else{
                if ( ($sec < 3600) and ($precision != 'S') ) {$precision='M';}
            }
            if ($precision == 'H'){
                $Fhours_H =	MathZDC($sec, 3600);
                $Fhours_H_int = floor($Fhours_H);
                $Fhours_H_int = intval("$Fhours_H_int");
                $Fhours_M = ($Fhours_H - $Fhours_H_int);
                $Fhours_M = ($Fhours_M * 60);
                $Fhours_M_int = floor($Fhours_M);
                $Fhours_M_int = intval("$Fhours_M_int");
                $Fhours_S = ($Fhours_M - $Fhours_M_int);
                $Fhours_S = ($Fhours_S * 60);
                $Fhours_S = round($Fhours_S, 0);
                if ($Fhours_S < 10) {$Fhours_S = "0$Fhours_S";}
                    if ($Fhours_M_int < 10) {$Fhours_M_int = "0$Fhours_M_int";}
                    $Ftime = "$Fhours_H_int:$Fhours_M_int:$Fhours_S";
            }
            if ($precision == 'M'){
                $Fminutes_M = MathZDC($sec, 60);
                $Fminutes_M_int = floor($Fminutes_M);
                $Fminutes_M_int = intval("$Fminutes_M_int");
                $Fminutes_S = ($Fminutes_M - $Fminutes_M_int);
                $Fminutes_S = ($Fminutes_S * 60);
                $Fminutes_S = round($Fminutes_S, 0);
                if ($Fminutes_S < 10) {$Fminutes_S = "0$Fminutes_S";}
                    $Ftime = "$Fminutes_M_int:$Fminutes_S";
            }
            if ($precision == 'S'){
                $Ftime = $sec;
            }
        return "$Ftime";
        }
    }
}
if(!function_exists('MathZDC')){
    function MathZDC($dividend, $divisor, $quotient=0){
        if ($divisor==0){
            return $quotient;
        }else if ($dividend==0){
            return 0;
        }else{
            return ($dividend/$divisor);
        }
    }
}
if(!function_exists('_QXZ')){
    function _QXZ($English_text, $sprintf=0, $align="l", $v_one='', $v_two='', $v_three='', $v_four='', $v_five='', $v_six='', $v_seven='', $v_eight='', $v_nine=''){
	if (preg_match("/%\ds/",$English_text)){
            $English_text = preg_replace("/%1s/", $v_one, $English_text);
            $English_text = preg_replace("/%2s/", $v_two, $English_text);
            $English_text = preg_replace("/%3s/", $v_three, $English_text);
            $English_text = preg_replace("/%4s/", $v_four, $English_text);
            $English_text = preg_replace("/%5s/", $v_five, $English_text);
            $English_text = preg_replace("/%6s/", $v_six, $English_text);
            $English_text = preg_replace("/%7s/", $v_seven, $English_text);
            $English_text = preg_replace("/%8s/", $v_eight, $English_text);
            $English_text = preg_replace("/%9s/", $v_nine, $English_text);
        }
        if ($sprintf > 0){
            if ($align=="r"){
                $fmt="%".$sprintf."s";
            }else{
                $fmt="%-".$sprintf."s";
            }
            $English_text=sprintf($fmt, $English_text);
        }
        return $English_text;
    }
}

if(!function_exists('getAgencyGroup')){
    function getAgencyGroup($agencyId){
        $CI = &get_instance();
        $CI->load->model('vicidial/agroups_m', 'agroups_m');
        $groups = $CI->agroups_m->getAgencyGroup($agencyId);
        if(!$groups){
            return array();
        }
        return $groups;
    }
}

if(!function_exists('getTemplates')){
    function getTemplates(){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $sql = "SELECT template_id,template_name FROM vicidial_conf_templates ORDER BY template_id";
        $query = $CI->vicidialdb->db->query($sql);
        $result = $query->result();
        return $result;
    }
}
if(!function_exists('getDisposition')){
    /**
     * get the dispositions statuses for agent screen
     * @return [type] [description]
     */
    function getDisposition($campaignId){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $sql = "SELECT STATUS , status_name, scheduled_callback, selectable FROM vicidial_statuses WHERE STATUS !=  'NEW' AND selectable='Y' ORDER BY `vicidial_statuses`.`selectable`  DESC LIMIT 500";
        $statuses1 = $CI->vicidialdb->db->query($sql)->result();
        $sql = "SELECT status AS `STATUS`,status_name,scheduled_callback,selectable FROM vicidial_campaign_statuses WHERE status != 'NEW' and campaign_id='$campaignId' order by status limit 500";
        $statuses2 = $CI->vicidialdb->db->query($sql)->result();
        $statuses = array_merge($statuses1, $statuses2);
        return $statuses;
    }
}
if(!function_exists('dialer_helper.php')){
    function getLiveAgents($agencyId){
        $CI = &get_instance();
        //VICI CODE
//        $CI->load->library('vicidialdb');
        $sql = "SELECT * FROM agents LEFT JOIN live_agents as live on agents.user_id=live.user WHERE agency_id = {$agencyId}";
        $query = $CI->db->query($sql);
        $result = $query->result();
        return $result;
    }
}
if(!function_exists('getAgentPhoneExtension')){
    function getAgentPhoneExtension($vicidialId = null){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $extension = '';
        if($vicidialId){
            $sql = "SELECT * FROM users_phones WHERE vicidial_user_id = {$vicidialId}";
            $query = $CI->db->query($sql);
            $row = $query->row_array();
            if($row){
                $sql = "SELECT dialplan_number FROM phones WHERE id={$row['vicidial_phone_id']}";
                $query = $CI->vicidialdb->db->query($sql);
                $row = $query->row();
                if($row){
                    $extension = $row->dialplan_number;
                }
            }
        }
        return $extension;
    }
}
if(!function_exists('getViciusername')){
    function getViciusername($agentId){
        $CI = &get_instance();
        $username = '';
        if($agentId > 0){
            $sql = "SELECT * FROM vicidial_users WHERE user_id={$agentId}";
            $query = $CI->vicidialdb->db->query($sql);
            $row = $query->row_array();
            $username = $row['user'];
        }
        return $username;
    }
}
/**
 * delete previous session data from vicidial screen
 */
if(!function_exists('deleteViciSession')){
    function deleteViciSession($user){
        $CI = &get_instance();
        $sql = "DELETE FROM vicidial_session_data WHERE user='{$user}'";
        $query = $CI->vicidialdb->db->query($sql);
    }
}