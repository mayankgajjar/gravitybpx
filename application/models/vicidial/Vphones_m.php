<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vphones_m extends My_Model {
    protected $_table_name     = 'phones';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = FALSE;
    public $_server_ip      = '173.254.218.90';
    public $rules = array(
        'extension' => array(
                'field' => 'extension',
                'label' =>  'Extension Id',
                'rules' => 'trim|required'
        ),
        'dialplan_number' => array(
                'field' => 'dialplan_number',
                'label' =>  'Dialplan Number',
                'rules' => 'trim|required'
        ),
        'voicemail_id' => array(
                'field' => 'voicemail_id',
                'label' =>  'Voicemail Id',
                'rules' => 'trim|required'
        ),
        'login' => array(
                'field' => 'login',
                'label' =>  'Login Id',
                'rules' => 'trim|required'
        ),
        'pass' => array(
                'field' => 'pass',
                'label' =>  'Password',
                'rules' => 'trim|required'
        ),
        'conf_secret' => array(
                'field' => 'conf_secret',
                'label' =>  'Registration Password',
                'rules' => 'trim|required'
        ),
    );

    public $_default = array(
            'phone_ip' => '', 'computer_ip' => '', 'server_ip' => '', 'status' => 'ACTIVE', 'phone_type' => 'CCagent', 'company' => '', 'picture' => '' , 'messages' => '0' , 'old_messages' => '0', 'protocol' => 'SIP',
            'local_gmt' => '-5.00', 'ASTmgrUSERNAME' => 'cron', 'login_user' => '', 'login_pass' => '', 'login_campaign' => '', 'park_on_extension' => '8301', 'conf_on_extension' => '8302', 'VICIDIAL_park_on_extension' => '8301', 'VICIDIAL_park_on_filename' => 'park',
            'monitor_prefix' => '8612', 'recording_exten' => '8309', 'voicemail_exten' => '8501', 'voicemail_dump_exten' => '85026666666666', 'ext_context' => 'default', 'dtmf_send_extension' => 'local/8500998@default', 'call_out_number_group' => 'Zap/g2/',
            'client_browser' => '/usr/bin/mozilla', 'install_directory' => '/usr/local/perl_TK', 'local_web_callerID_URL' => 'http://astguiclient.sf.net/test_callerid_output.php', 'VICIDIAL_web_URL' => 'http://astguiclient.sf.net/test_VICIDIAL_output.php', 'AGI_call_logging_enabled' => '1',
            'user_switching_enabled' => '1', 'conferencing_enabled' => '1', 'admin_hangup_enabled' => '0', 'admin_hijack_enabled' => '0', 'admin_monitor_enabled' => '1', 'call_parking_enabled' => '1', 'updater_check_enabled' => '1', 'AFLogging_enabled' => '1', 'QUEUE_ACTION_enabled' => '1',
            'CallerID_popup_enabled' => '1', 'voicemail_button_enabled' => '1', 'enable_fast_refresh' => '0', 'fast_refresh_rate' => '1000', 'enable_persistant_mysql' => '0', 'auto_dial_next_number' => '1', 'VDstop_rec_after_each_call' => '1', 'DBX_server' => '', 'DBX_database' => 'asterisk',
            'DBX_pass' => '1234', 'DBX_port' => '3306', 'DBY_server' => '', 'DBY_database' => 'asterisk', 'DBY_user' => 'cron', 'DBY_pass' => '1234', 'DBY_port' => '3306', 'outbound_cid' => '0', 'enable_sipsak_messages' => '0', 'email' => '', 'template_id' => 'websip', 'conf_override' => '',
            'phone_context' => 'default', 'phone_ring_timeout' => '60', 'delete_vm_after_email' => 'N', 'is_webphone' => 'N', 'use_external_server_ip' => 'N', 'codecs_list' => '', 'codecs_with_template' => '0', 'webphone_dialpad' => 'Y', 'on_hook_agent' => 'N', 'webphone_auto_answer' => 'Y',
            'voicemail_timezone' => 'eastern', 'voicemail_options' => '', 'user_group' => '---ALL---', 'voicemail_greeting' => '', 'voicemail_dump_exten_no_inst' => '85026666666667', 'voicemail_instructions' => 'Y', 'on_login_report' => 'N', 'unavail_dialplan_fwd_exten' => '', 'unavail_dialplan_fwd_context' => '',
            'nva_call_url' => '', 'nva_search_method' => 'NONE', 'nva_error_filename' => '', 'nva_new_list_id' => '995', 'nva_new_phone_code' => '1', 'nva_new_status' => 'NVAINS', 'webphone_dialbox' => 'Y', 'webphone_mute' => 'Y', 'webphone_volume' => 'Y', 'webphone_debug' => 'N', 'outbound_alt_cid' => ''
    );

    public function __construct() {
        parent::__construct();
        $this->_default['computer_ip'] = get_client_ip();
        $this->_default['server_ip'] = '173.254.218.90';
        $this->db = $this->vicidialdb->db;
    }

    public function getLastInserted() {
	   $this->db->select_max($this->_primary_key);
	   $Q = $this->db->get($this->_table_name);
	   $row = $Q->row_array();
	   return $row[$this->_primary_key];
    }

    public function save($data, $id = NULL)
    {
            if($this->_timestamps == TRUE){
                    $now = date('Y-m-d H:i:s');
                    $id || $data['created'] = $now;
                    $data['modified'] = $now;
            }

            if( $id === NULL ){
                    !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
                    $this->db->set($data);
                    $this->db->insert($this->_table_name);
                    $id = $this->db->insert_id();
            }else{
                    $filter = $this->_primary_filter;
                    $id = $filter($id);
                    $this->db->set($data);
                    $this->db->where($this->_primary_key, $id);
                    $this->db->update($this->_table_name);
            }
            $this->db->query("UPDATE servers SET rebuild_conf_files='Y' WHERE server_ip='".$this->_default['server_ip']."'");
            return $id;
    }

}
