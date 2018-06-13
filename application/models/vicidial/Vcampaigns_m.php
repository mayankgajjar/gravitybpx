<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vcampaigns_m extends My_Model {

    protected $_table_name     = 'vicidial_campaigns';
    protected $_primary_key    = 'campaign_id';
    protected $_primary_filter = 'strval';
    protected $_order_by       = 'campaign_id';
    protected $_timestamps     = FALSE;

    public $rules = array(
        'campaign_id' => array(
            'field' => 'campaign_id',
            'label' => 'Campaign Id',
            'rules' => 'trim|required|callback__unique_campaign_id'
        ),
        'agency_id' => array(
            'field' => 'agency_id',
            'label' => 'Agency',
            'rules' => 'trim|required'
        ),
        'campaign_name' => array(
            'field' => 'campaign_name',
            'label' => 'Campaign Name',
            'rules' => 'trim|required'
        )
    );

    public $default =array(
        'dial_status_a' => '', 'dial_status_b' => '', 'dial_status_c' => '', 'dial_status_d' => '', 'dial_status_e' => '', 'park_ext' => '', 'park_file_name' => '',
        'web_form_address' => '', 'hopper_level' => '1', 'next_agent_call' => 'longest_wait_time', 'local_call_time' => '24hours', 'voicemail_ext' => '', 'dial_timeout' => '60', 'dial_prefix' => '9',
        'campaign_rec_exten' => '8309', 'campaign_recording' => 'ONDEMAND', 'campaign_rec_filename' => 'FULLDATE_CUSTPHONE', 'campaign_script' => '', 'get_call_launch' => 'NONE', 'am_message_exten' => 'vm-goodbye', 'amd_send_to_vmx' => 'N', 'xferconf_a_dtmf' => '', 'xferconf_a_number' => '', 'xferconf_b_dtmf' => '', 'xferconf_b_number' => '',
        'alt_number_dialing' => 'N', 'scheduled_callbacks' => 'N', 'drop_call_seconds' => '5', 'drop_action' => 'AUDIO', 'safe_harbor_exten' => '8307', 'display_dialable_count' => 'Y', 'wrapup_seconds' => '0', 'wrapup_message' => 'Wrapup Call', 'allcalls_delay' => '0', 'omit_phone_code' => 'N', 'available_only_ratio_tally' => 'N', 'adaptive_dropped_percentage' => '100', 'adaptive_maximum_level' => '200', 'adaptive_latest_server_time' => '2100', 'adaptive_intensity' => '0', 'adaptive_dl_diff_target' => '0', 'concurrent_transfers' => 'AUTO',
        'auto_alt_dial' => 'NONE', 'agent_pause_codes_active' => 'N', 'campaign_description' => '', 'campaign_stats_refresh' => 'N', 'dial_statuses' => ' A AA NA NEW -', 'auto_alt_dial' => 'NONE', 'agent_pause_codes_active' => 'N', 'campaign_description' => '', 'campaign_stats_refresh' => 'N', 'dial_statuses' => ' A AA NA NEW -', 'disable_alter_custdata' => 'N', 'no_hopper_leads_logins' => 'Y', 'list_order_mix' => 'DISABLED', 'manual_dial_list_id' => '998', 'default_xfer_group' => 'AGENTDIRECT', 'xfer_groups' => ' AGENTDIRECT inbound_line -', 'queue_priority' => '50', 'drop_inbound_group' => '---NONE---', 'qc_enabled' => 'N', 'qc_statuses' => NULL, 'qc_lists' => NULL, 'qc_shift_id' => '24HRMIDNIGHT',
        'qc_get_record_launch' => 'NONE', 'qc_show_recording' => 'Y', 'qc_web_form_address' => NULL, 'qc_script' => NULL, 'survey_first_audio_file' => 'US_pol_survey_hello', 'survey_dtmf_digits' => '1238', 'survey_ni_digit' => '8', 'survey_opt_in_audio_file' => 'US_pol_survey_transfer', 'survey_method' => 'AGENT_XFER', 'survey_ni_status' => 'NI', 'survey_response_digit_map' => '1-DEMOCRAT|2-REPUBLICAN|3-INDEPENDANT|8-OPTOUT|X-NO RESPONSE|', 'survey_xfer_exten' => '8300', 'survey_camp_record_dir' => '/home/survey', 'disable_alter_custphone' => 'Y', 'display_queue_count' => 'Y', 'manual_dial_filter' => 'NONE', 'agent_clipboard_copy' => 'NONE', 'agent_extended_alt_dial' => 'N', 'use_campaign_dnc' => 'N', 'three_way_call_cid' => 'CAMPAIGN', 'three_way_dial_prefix' => '', 'web_form_target' => 'vdcwebform', 'vtiger_search_category' => 'LEAD', 'vtiger_create_call_record' => 'Y', 'vtiger_create_lead_record' => 'Y', 'vtiger_screen_login' => 'Y', 'cpd_amd_action' => 'DISABLED',
        'agent_allow_group_alias' => 'N', 'default_group_alias' => '', 'vtiger_search_dead' => 'ASK', 'vtiger_status_call' => 'N', 'survey_third_digit' => '', 'survey_third_audio_file' => 'US_thanks_no_contact', 'agent_allow_group_alias' => 'N', 'default_group_alias' => '', 'vtiger_search_dead' => 'ASK', 'vtiger_status_call' => 'N', 'survey_third_digit' => '', 'survey_third_audio_file' => 'US_thanks_no_contact','survey_third_status' => 'NI', 'survey_third_exten' => '8300', 'survey_fourth_audio_file' => 'US_thanks_no_contact', 'survey_fourth_status' => 'NI', 'survey_fourth_exten' => '8300', 'drop_lockout_time' => '0', 'quick_transfer_button' => 'N', 'prepopulate_transfer_preset' => 'N', 'drop_rate_group' => 'DISABLED', 'view_calls_in_queue' => 'NONE', 'view_calls_in_queue_launch' => 'MANUAL', 'grab_calls_in_queue' => 'N', 'call_requeue_button' => 'N', 'pause_after_each_call' => 'N', 'no_hopper_dialing' => 'N', 'agent_dial_owner_only' => 'NONE', 'agent_display_dialable_leads' => 'N',
        'web_form_address_two' => '', 'agent_select_territories' => '', 'waitforsilence_options' => '', 'campaign_calldate' => NULL, 'crm_popup_login' => 'N', 'crm_login_address' => '', 'timer_action' => 'NONE', 'timer_action_message' => '', 'timer_action_seconds' => '1', 'start_call_url' => '', 'dispo_call_url' => '', 'xferconf_c_number' => '', 'xferconf_d_number' => '', 'xferconf_e_number' => '', 'use_custom_cid' => 'N', 'scheduled_callbacks_alert' => 'NONE', 'queuemetrics_callstatus_override' => 'DISABLED', 'extension_appended_cidname' => 'N', 'scheduled_callbacks_count' => 'ALL_ACTIVE', 'manual_dial_override' => 'NONE', 'blind_monitor_warning' => 'DISABLED', 'blind_monitor_message' => 'Someone is blind monitoring your session', 'blind_monitor_filename' => '', 'inbound_queue_no_dial' => 'DISABLED', 'timer_action_destination' => '', 'enable_xfer_presets' => 'DISABLED', 'hide_xfer_number_to_dial' => 'DISABLED', 'manual_dial_prefix' => '', 'customer_3way_hangup_logging' => 'ENABLED', 'customer_3way_hangup_seconds' => '5',
        'customer_3way_hangup_action' => 'NONE', 'ivr_park_call' => 'DISABLED', 'ivr_park_call_agi' => '', 'manual_preview_dial' => 'PREVIEW_AND_SKIP', 'realtime_agent_time_stats' => 'CALLS_WAIT_CUST_ACW_PAUSE', 'use_auto_hopper' => 'N', 'auto_hopper_multi' => '1', 'auto_hopper_level' => '0', 'auto_trim_hopper' => 'Y', 'api_manual_dial' => 'STANDARD', 'manual_dial_call_time_check' => 'DISABLED', 'display_leads_count' => 'N', 'lead_order_randomize' => 'N', 'lead_order_secondary' => 'LEAD_ASCEND', 'per_call_notes' => 'DISABLED', 'my_callback_option' => 'UNCHECKED', 'agent_lead_search' => 'DISABLED', 'agent_lead_search_method' => 'CAMPLISTS_ALL', 'queuemetrics_phone_environment' => '', 'auto_pause_precall' => 'N', 'auto_pause_precall_code' => 'PRECAL', 'auto_resume_precall' => 'N', 'manual_dial_cid' => 'CAMPAIGN', 'post_phone_time_diff_alert' => 'DISABLED', 'custom_3way_button_transfer' => 'DISABLED', 'available_only_tally_threshold' => 'DISABLED', 'available_only_tally_threshold_agents' => '0', 'dial_level_threshold' => 'DISABLED',
        'dial_level_threshold_agents' => '0', 'safe_harbor_audio' => 'buzz', 'safe_harbor_menu_id' => '', 'survey_menu_id' => '', 'callback_days_limit' => '0', 'dl_diff_target_method' => 'ADAPT_CALC_ONLY', 'disable_dispo_screen' => 'DISPO_ENABLED', 'disable_dispo_status' => '', 'screen_labels' => '--SYSTEM-SETTINGS--', 'status_display_fields' => 'CALLID', 'na_call_url' => '', 'survey_recording' => 'N', 'pllb_grouping' => 'DISABLED', 'pllb_grouping_limit' => '50', 'call_count_limit' => '0', 'call_count_target' => '3', 'callback_hours_block' => '0', 'callback_list_calltime' => 'DISABLED', 'user_group' => '---ALL---', 'hopper_vlc_dup_check' => 'N', 'in_group_dial' => 'DISABLED', 'in_group_dial_select' => 'CAMPAIGN_SELECTED', 'safe_harbor_audio_field' => 'DISABLED', 'pause_after_next_call' => 'DISABLED', 'owner_populate' => 'DISABLED', 'use_other_campaign_dnc' => '', 'allow_emails' => 'N', 'amd_inbound_group' => 'AGENTDIRECT', 'amd_callmenu' => '---NONE---', 'survey_wait_sec' => '10', 'manual_dial_lead_id' => 'N', 'dead_max' => '0',
        'dead_max_dispo' => 'DCMX', 'dispo_max' => '0', 'dispo_max_dispo' => 'DISMX', 'pause_max' => '0', 'max_inbound_calls' => '0', 'manual_dial_search_checkbox' => 'SELECTED', 'hide_call_log_info' => 'N', 'timer_alt_seconds' => '0', 'wrapup_bypass' => 'ENABLED', 'callback_active_limit' => '0', 'callback_active_limit_override'  => 'N', 'allow_chats' => 'N', 'comments_all_tabs' => 'DISABLED', 'comments_dispo_screen' => 'DISABLED', 'comments_callback_screen' => 'DISABLED', 'qc_comment_history' => 'CLICK', 'show_previous_callback' => 'ENABLED', 'clear_script' => 'DISABLED', 'cpd_unknown_action' => 'DISABLED', 'manual_dial_search_filter' => 'NONE', 'web_form_address_three' => '', 'manual_dial_override_field' => 'ENABLED', 'status_display_ingroup' => 'ENABLED', 'customer_gone_seconds' => '30', 'agent_display_fields' => '', 'am_message_wildcards' => 'N', 'manual_dial_timeout' => '', 'routing_initiated_recordings' => 'N', 'manual_dial_hopper_check' => 'N', 'callback_useronly_move_minutes' => '0', 'ofcom_uk_drop_calc' => 'N'
    );

    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
	    $this->db = $CI->vicidialdb->db;
    }

    public function cretaeTempTable($svWhere = '')
    {
        $CI = &get_instance();
  //      $file = FCPATH.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'file.txt';

//        if(file_exists($file)){
//           @unlink($file);
//        }

//        $file = str_replace("\\",'/' ,$file);
        /* dump all data from the file */
        //$query = "SELECT * INTO OUTFILE '{$file}' FROM vicidial_campaigns";
        $query = "SELECT * FROM vicidial_campaigns";

        $results = $this->db->query($query)->result_array();

        /* get defination of the table */
        $sql = "SHOW CREATE TABLE vicidial_campaigns";
        $define = $this->db->query($sql)->row_array();
        $defination = $define['Create Table'];

        if ($CI->db->table_exists($define['Table']) == TRUE ){
            $sql = "TRUNCATE {$define['Table']}";
            $CI->db->query($sql);
        }else{
             $CI->db->query($defination);
        }
        $values = " SET ";
        foreach($results as  $rows){
           $qry = "INSERT INTO {$define['Table']} SET";
           foreach($rows as $key => $row) {
              $values .= " {$key} = '{$row}',";
              $qry.= " {$key} = '{$row}',";
           }
           $qry = rtrim($qry, ',');
           $CI->db->query($qry);
        }
        //$values = rtrim($values, ',');
        //$sql = "LOAD DATA LOCAL INFILE '{$file}' INTO TABLE {$define['Table']}";
        //$sql = "INSERT INTO '{$define['Table']}' {$values}";
        //$CI->db->query($sql);
    }

    public function get_new(){
        $campaign = new stdClass();
        $campaign->campaign_id = $this->input->post('campaign_id') ? $this->input->post('campaign_id') : '';
        $campaign->campaign_name = $this->input->post('campaign_name') ? $this->input->post('campaign_name') : '';
        $campaign->active = $this->input->post('active') ? $this->input->post('active') : 'Y';
        $campaign->lead_filter_id = $this->input->post('lead_filter_id') ? $this->input->post('lead_filter_id') : '';
        $campaign->dial_method = $this->input->post('dial_method') ? $this->input->post('dial_method') : '';
        $campaign->auto_dial_level = $this->input->post('auto_dial_level') ? $this->input->post('auto_dial_level') : '';
        $campaign->campaign_vdad_exten = $this->input->post('campaign_vdad_exten') ? $this->input->post('campaign_vdad_exten') : '8368';
        $campaign->campaign_cid = $this->input->post('campaign_cid') ? $this->input->post('campaign_cid') : '0000000000';
        $campaign->use_internal_dnc = $this->input->post('use_internal_dnc') ? $this->input->post('use_internal_dnc') : 'N';
        $campaign->allow_closers =  $this->input->post('allow_closers') ? $this->input->post('allow_closers') : 'N';
        $campaign->campaign_allow_inbound = $this->input->post('campaign_allow_inbound') ? $this->input->post('campaign_allow_inbound') : 'N';
        return $campaign;
    }

    /**
     * Save and update the data table according to the passed parameter.
     * @param type $data
     * @param type|null $id
     * @return type
     */
    public function save($data, $id = NULL)
    {
        if($this->_timestamps == TRUE){
            $now = date('Y-m-d H:i:s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }
        $data['campaign_changedate'] =  date('Y-m-d H:i:s');
        if( $id === NULL ){
            $this->db->set($data);
            $this->db->insert($this->_table_name);
            $id = $this->getLastInserted();
        }else{
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);
        }
        return $id;
    }

    public function getLastInserted() {
	//$this->db->select_max($this->_primary_key);
	//$Q = $this->db->get($this->_table_name);
        $query = $this->db->query("SELECT * FROM {$this->_table_name} order by created DESC limit 1");
	//$query = $Q->result_array();
        $row = $query->row_array();

	return $row[$this->_primary_key];
    }

    public function query($where='',$order='',$limit='')
    {
        $this->cretaeTempTable();
        $CI = &get_instance();

        $sql = "SELECT main.*, age.name as agency_name, age.id as agency_id FROM {$CI->db->protect_identifiers($this->_table_name, TRUE)} AS main, {$CI->db->protect_identifiers('agency_campaigns', TRUE)} AS sec, {$CI->db->protect_identifiers('agencies', TRUE)} AS age";

        if( $where != '' ){
            $sql.= "{$where}";
            $sql.= " AND main.campaign_id = sec.vicidial_campaign_id AND age.id = sec.agency_id  ";
        }else{
            $sql.= " WHERE main.campaign_id = sec.vicidial_campaign_id AND age.id = sec.agency_id ";
        }

        if( $order != '' )
            $sql.= "{$order}";
        else
            $sql.= " ORDER BY {$this->_primary_key} DESC";

        if( $limit != '' )
            $sql.= "{$limit} ";

        $query = $CI->db->query($sql);

        if( $query->num_rows() > 0 )
            return $query->result_array();
        else
            return false;
    }

    public function queryForAgency($where='',$order='',$limit='')
    {
        $this->cretaeTempTable();
        $CI = &get_instance();
        $sql = "SELECT main.*, age.name as agency_name, age.id as agency_id FROM {$CI->db->protect_identifiers($this->_table_name, TRUE)} AS main, {$CI->db->protect_identifiers('agency_campaigns', TRUE)} AS sec, {$CI->db->protect_identifiers('agencies', TRUE)} AS age";
        $query = "select id from {$CI->db->protect_identifiers('agencies',TRUE)} WHERE parent_agency={$this->session->userdata('agency')->id}";
        $results = $CI->db->query($query)->result_array();
        $ids[] = $this->session->userdata('agency')->id;
        foreach($results as $result){
            $ids[] = $result['id'];
        }
        $ids = implode(',', $ids);
        if( $where != '' ){
                $sql.= "{$where}";
                $sql.= " AND main.campaign_id = sec.vicidial_campaign_id AND age.id = sec.agency_id AND sec.agency_id IN({$ids}) ";
        }else{
            $sql.= " WHERE main.campaign_id = sec.vicidial_campaign_id AND age.id = sec.agency_id AND sec.agency_id IN({$ids}) ";
        }

        if( $order != '' )
            $sql.= "{$order}";
        else
            $sql.= " ORDER BY {$this->_primary_key} DESC";

        if( $limit != '' )
            $sql.= "{$limit} ";

        $query = $CI->db->query($sql);

        if( $query->num_rows() > 0 )
            return $query->result_array();
        else
            return false;
    }

    public function getByAgencyId(){
        $this->cretaeTempTable();
        $CI = &get_instance();
        $sql = "SELECT main.* FROM {$CI->db->protect_identifiers($this->_table_name, TRUE)} AS main, {$CI->db->protect_identifiers('agency_campaigns', TRUE)} AS sec, {$CI->db->protect_identifiers('agencies', TRUE)} AS age";
        $query = "select id from {$CI->db->protect_identifiers('agencies',TRUE)} WHERE parent_agency={$this->session->userdata('agency')->id}";
        $results = $CI->db->query($query)->result_array();
        $ids[] = $this->session->userdata('agency')->id;
        foreach($results as $result){
            $ids[] = $result['id'];
        }
        $ids = implode(',', $ids);
        $sql.= " WHERE main.campaign_id = sec.vicidial_campaign_id AND age.id = sec.agency_id AND sec.agency_id IN({$ids}) ";
        $query = $CI->db->query($sql);
        if( $query->num_rows() > 0 )
            return $query->result_array();
        else
            return false;
    }
}
