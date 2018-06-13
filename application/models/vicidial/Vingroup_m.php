<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vingroup_m extends My_Model{
    protected $_table_name = 'vicidial_inbound_groups';
    protected $_primary_key = 'group_id';
    protected $_primary_filter = 'strval';
    protected $_order_by = 'group_id';
    protected $_timestamps = FALSE;
    public $_temptable;
    public $default = array(
        'web_form_address' => '', 'fronter_display' => 'Y', 'ingroup_script' => '', 'xferconf_a_dtmf' => '', 'xferconf_a_number' => '', 'xferconf_b_dtmf' => '', 'xferconf_b_number' => '',
        'drop_action' => 'MESSAGE', 'drop_exten' => '8307', 'call_time_id' => '24hours', 'after_hours_action' => 'MESSAGE', 'after_hours_message_filename' => 'vm-goodbye', 'after_hours_exten' => '8300',
        'after_hours_voicemail' => '', 'welcome_message_filename' => '---NONE---', 'moh_context' => 'default', 'onhold_prompt_filename' => 'generic_hold', 'prompt_interval' => '60', 'agent_alert_exten' => 'ding',
        'agent_alert_delay' => '1000', 'default_xfer_group' => '---NONE---', 'queue_priority' => '0', 'drop_inbound_group' => '---NONE---', 'ingroup_recording_override' => 'DISABLED', 'ingroup_rec_filename' => 'NONE',
        'qc_enabled' => 'N', 'qc_statuses' => '', 'qc_shift_id' => '24HRMIDNIGHT', 'qc_get_record_launch' => 'NONE', 'qc_web_form_address' => '', 'qc_script' => '', 'play_place_in_line' => 'N', 'play_estimate_hold_time' => 'N',
        'hold_time_option' => 'NONE', 'hold_time_option_seconds' => '360', 'hold_time_option_exten' => '8300', 'hold_time_option_voicemail' => '', 'hold_time_option_xfer_group' => '---NONE---', 'hold_time_option_callback_filename' => 'vm-hangup',
        'hold_time_option_callback_list_id' => '999', 'hold_recall_xfer_group' => '---NONE---', 'no_delay_call_route' => 'N', 'play_welcome_message' => 'ALWAYS', 'answer_sec_pct_rt_stat_one' => '20', 'answer_sec_pct_rt_stat_two' => '30',
        'default_group_alias' => '', 'no_agent_no_queue' => 'N', 'no_agent_action' => 'MESSAGE', 'no_agent_action_value' => 'nbdy-avail-to-take-call|vm-goodbye', 'web_form_address_two' => '', 'timer_action' => 'NONE', 'timer_action_message' => '',
        'timer_action_seconds' => '-1', 'start_call_url' => '', 'dispo_call_url' => '', 'xferconf_c_number' => '', 'xferconf_d_number' => '', 'xferconf_e_number' => '', 'ignore_list_script_override' => 'N', 'extension_appended_cidname' => 'N',
        'uniqueid_status_prefix' => '', 'hold_time_option_minimum' => 0, 'hold_time_option_press_filename' => 'to-be-called-back|digits/1', 'hold_time_option_callmenu' => '', 'hold_time_option_no_block' => 'N', 'hold_time_option_prompt_seconds' => 10,
        'onhold_prompt_no_block' => 'N', 'onhold_prompt_seconds' => 10, 'hold_time_second_option' => 'NONE', 'wait_hold_option_priority' => 'WAIT', 'wait_time_option' => 'NONE', 'wait_time_second_option' => 'NONE', 'wait_time_third_option' => 'NONE',
        'wait_time_option_seconds' => 120, 'wait_time_option_exten' => 8300, 'wait_time_option_voicemail' => '', 'wait_time_option_xfer_group' => '---NONE---', 'wait_time_option_callmenu' => '', 'wait_time_option_callback_filename' => 'vm-hangup',
        'wait_time_option_callback_list_id' => '999', 'wait_time_option_press_filename' => 'to-be-called-back|digits/1', 'wait_time_option_no_block' => 'N', 'wait_time_option_prompt_seconds' => '10', 'timer_action_destination' => '',
        'add_lead_url' => '', 'eht_minimum_prompt_filename' => '', 'eht_minimum_prompt_no_block' => '', 'eht_minimum_prompt_seconds' => '', 'on_hook_ring_time' => '15', 'na_call_url' => '', 'on_hook_cid' => 'GENERIC', 'group_calldate' => '',
        'action_xfer_cid' => 'CUSTOMER', 'drop_callmenu' => '', 'after_hours_callmenu' => '', 'max_calls_method' => 'DISABLED', 'max_calls_count' => '0', 'max_calls_action' => 'NO_AGENT_NO_QUEUE', 'dial_ingroup_cid' => '',
        'group_handling' => 'PHONE', 'web_form_address_three' => '', 'populate_lead_ingroup' => 'ENABLED', 'drop_lead_reset' => 'N', 'after_hours_lead_reset' => 'N', 'nanq_lead_reset' => 'N', 'wait_time_lead_reset' => 'N', 'hold_time_lead_reset' => 'N',
        'status_group_id' => '', 'routing_initiated_recordings' => 'N', 'on_hook_cid_number' => '', 'drop_call_seconds' => '360', 'next_agent_call' => 'longest_wait_time', 'group_id' => '', 'group_name' => '', 'group_color' => '', 'active' => '', 'get_call_launch' => '',
        'user_group' => ''
        );
    public $rules = array(
        'group_id' => array(
          'field' => 'group_id',
          'label' => 'Group ID',
          'rules' => 'trim|required|callback__check_ingroup_string|callback__unique_ingroup_id'
        ),
        'group_name' => array(
            'field' => 'group_name',
            'label' => 'Group Name',
            'rules' => 'trim|required'
        ),
        'group_color' => array(
            'field' => 'group_color',
            'label' => 'Color Group',
            'rules' => 'trim|required'
        )
    );

    public function __construct() {
        parent::__construct();
        $this->db = $this->vicidialdb->db;
    }

    public function get_new(){
        $ingroup = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $ingroup->$colom = $this->input->post($colom) ? $this->input->post($colom) : isset($this->default[$colom]) ? $this->default[$colom] : '' ;
        }
        $ingroup->agency_id = $this->input->post('agency_id') ? $this->input->post($colom) : 0;
//        $ingroup->next_agent_call = $this->input->post'longest_wait_time';
//        $ingroup->fronter_display = 'Y';
//        $ingroup->get_call_launch = 'NONE';
//        $ingroup->drop_call_seconds = '360';
//        $ingroup->drop_action = 'MESSAGE';
//        $ingroup->drop_exten = '8307';
//        $ingroup->call_time_id = '24hours';
//        $ingroup->after_hours_action = 'MESSAGE';
//        $ingroup->after_hours_message_filename = 'vm-goodbye';
//        $ingroup->active = 'Y';
//        $ingroup->prompt_interval = '60';
//        $ingroup->onhold_prompt_filename = 'generic_hold';
//        $ingroup->play_welcome_message = 'ALWAYS';
//        $ingroup->welcome_message_filename = '---NONE---';
//        $ingroup->no_agent_no_queue = 'N';
//        $ingroup->after_hours_exten ='8300';
        return $ingroup;
    }
    public function getLastInserted() {
        $query = $this->db->query("SELECT * FROM {$this->_table_name} order by created DESC limit 1");
        $row = $query->row_array();

	return $row[$this->_primary_key];
    }
    public function save($data, $id = NULL){
        if($this->_timestamps == TRUE){
            $now = date('Y-m-d H:i:s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }

        if( $id === NULL ){
            //!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
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
    public function createTempTable(){
        $CI = &get_instance();
        $results = (array)$this->get();
        /* get defination of the table */
        $sql = "SHOW CREATE TABLE {$this->_table_name}";
        $define = $this->db->query($sql)->row_array();
        $defination = $define['Create Table'];
        $tablename = $define['Table'].'_temp';
        $this->_temptable = $tablename;
        $defination = str_replace($define['Table'], $tablename, $defination);
        if ($CI->db->table_exists($tablename) == TRUE ){
            $sql = "TRUNCATE {$tablename}";
            $CI->db->query($sql);
        }else{
             $CI->db->query($defination);
        }
        foreach($results as  $rows){
           $qry = "INSERT INTO {$this->_temptable} SET";
           foreach($rows as $key => $row) {
              //$values .= " {$key} = '{$this->db->escape($row)}',";
              $qry.= " {$key} = {$this->db->escape($row)},";
           }
           $qry = rtrim($qry, ',');
           $CI->db->query($qry);
        }
    }
}
