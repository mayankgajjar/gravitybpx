<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Indid_m extends My_Model{
    protected $_table_name = 'vicidial_inbound_dids';
    protected $_primary_key = 'did_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'did_id';
    protected $_timestamps = FALSE;
    public $_temptable;
    public $default = array(
        'exten_context' => 'default', 'server_ip' => '173.254.218.90' , 'call_handle_method' => 'CID', 'agent_search_method' => 'LB', 'list_id' => '999', 'campaign_id' => '',
        'phone_code' => '1', 'record_call' => 'N', 'filter_inbound_number' => 'DISABLED', 'filter_phone_group_id' => '', 'filter_url' => '', 'filter_action' => 'EXTEN',
        'filter_exten_context' => 'default', 'filter_voicemail_ext' => '', 'filter_phone' => '', 'filter_server_ip' => '', 'filter_user' => '', 'filter_user_unavailable_action' => 'VOICEMAIL',
        'filter_user_route_settings_ingroup' => 'AGENTDIRECT', 'filter_group_id' => '---NONE---', 'filter_call_handle_method' => 'CID', 'filter_agent_search_method' => 'LB', 'filter_list_id' => '999',
        'filter_campaign_id' => '', 'filter_phone_code' => '1', 'filter_menu_id' => '', 'filter_clean_cid_number' => '', 'custom_one' => '', 'custom_two' => '', 'custom_three' => '', 'custom_four' => '',
        'custom_five' => '', 'filter_dnc_campaign' => '', 'filter_url_did_redirect' => 'N', 'no_agent_ingroup_redirect' => 'DISABLED', 'no_agent_ingroup_id' => '', 'no_agent_ingroup_extension' => '9998811112',
        'pre_filter_phone_group_id' => '', 'pre_filter_extension' => '', 'entry_list_id' => '0', 'filter_entry_list_id' => '0', 'max_queue_ingroup_calls' => '0', 'max_queue_ingroup_id' => '', 'max_queue_ingroup_extension' => '9998811112',
        'did_carrier_description' => ''

    );
    public $rules = array(
        'did_pattern' => array(
            'field' => 'did_pattern',
            'label' => 'DID Extension',
            'rules' => 'trim|required',
        ),
        'did_description' => array(
            'field' => 'did_description',
            'label' => 'DID Description',
            'rules' => 'trim|required',
        )
    );

    public function __construct() {
        parent::__construct();
        $this->db = $this->vicidialdb->db;
    }
    public function get_new(){
        $did = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $did->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        $did->agency_id = $this->input->post('agency_id') ? $this->input->post('agency_id') : '';
        return $did;
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
