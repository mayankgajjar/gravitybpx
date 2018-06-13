<?php

class Vusers_m extends My_Model{
    protected $_table_name     = 'vicidial_users';
    protected $_primary_key    = 'user_id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'user_id';
    protected $_timestamps     = FALSE;

    public $rules = array(
       'email' => array(
           'field' => 'email',
           'label' => 'Email Address',
           'rules' => 'trim|required|valid_email|callback__unique_email'
       ),
       'pass' => array(
           'field' => 'pass',
           'label' => 'Password',
           'rules' => 'trim|required'
       ),
        'full_name' => array(
            'field' => 'full_name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        'user_group' => array(
            'field' => 'user_group',
            'label' => 'User Group',
            'rules' => 'trim|required'
        )
    );

    public $roles = array(
        '9' => array('delete_users' => '1','delete_user_groups' => '1', 'delete_lists' => '1', 'delete_campaigns' => '1', 'delete_ingroups' => '1', 'delete_remote_agents' => '1', 'load_leads' => '1', 'campaign_detail' => '1', 'ast_admin_access' => '1', 'ast_delete_phones' => '1', 'delete_scripts' => '1', 'modify_leads' => '1', 'hotkeys_active' => '0','change_agent_campaign' => '1', 'agent_choose_ingroups' => '1', 'closer_campaigns' =>' AGENTDIRECT -', 'scheduled_callbacks' => '1', 'agentonly_callbacks' => '0', 'agentcall_manual' => '1', 'vicidial_recording' => '1', 'vicidial_transfers' => '1', 'delete_filters' => '1', 'alter_agent_interface_options' => '1', 'closer_default_blended' => '0', 'delete_call_times' => '1', 'modify_call_times' => '1', 'modify_users' => '1','modify_campaigns' => '1', 'modify_lists' => '1', 'modify_scripts' => '1', 'modify_filters' => '1', 'modify_ingroups' => '1', 'modify_usergroups' => '1', 'modify_remoteagents' => '1', 'modify_servers' => '1', 'view_reports' => '1' , 'vicidial_recording_override' => 'ALLFORCE', 'alter_custdata_override' => 'NOT_ACTIVE', 'qc_enabled' => '0', 'qc_user_level' => '1', 'qc_pass' => '0', 'qc_finish' => '0', 'qc_commit' => '0', 'add_timeclock_log' => '1', 'modify_timeclock_log' => '1', 'delete_timeclock_log' => '1', 'alter_custphone_override' => 'NOT_ACTIVE', 'vdc_agent_api_access' => '0', 'modify_inbound_dids'  => '0', 'delete_inbound_dids' => '0', 'alert_enabled' => '0', 'download_lists' => '1', 'agent_shift_enforcement_override' => 'DISABLED', 'manager_shift_enforcement_override'=> '0', 'shift_override_flag' => '0', 'export_reports' => '1', 'delete_from_dnc' => '1', 'allow_alerts' => '0', 'agent_call_log_view_override' => 'DISABLED', 'callcard_admin' => '1', 'agent_choose_blended' => '1', 'realtime_block_user_info' => '0', 'custom_fields_modify' => '0', 'force_change_password' => 'N', 'agent_lead_search_override' => 'NOT_ACTIVE', 'modify_shifts' => '1', 'modify_phones' => '1', 'modify_carriers' => '1', 'modify_labels' => '1', 'modify_statuses' => '1', 'modify_voicemail' => '1', 'modify_audiostore' => '1', 'modify_moh' => '1', 'modify_tts' => '1', 'preset_contact_search' => 'NOT_ACTIVE', 'modify_contacts' => '1', 'modify_same_user_level' => '1', 'admin_hide_lead_data' => '0', 'admin_hide_phone_data' => '0', 'agentcall_email' => '0', 'modify_email_accounts' => '0', 'alter_admin_interface_options' => '1', 'modify_colors' => '1'),
        '8' => array('delete_users' => '0','delete_user_groups' => '1', 'delete_lists' => '1', 'delete_campaigns' => '1', 'delete_ingroups' => '1', 'delete_remote_agents' => '1', 'load_leads' => '1', 'campaign_detail' => '1', 'ast_admin_access' => '0', 'ast_delete_phones' => '0', 'delete_scripts' => '0', 'modify_leads' => '1', 'hotkeys_active' => '0','change_agent_campaign' => '1', 'agent_choose_ingroups' => '1', 'closer_campaigns' => '', 'scheduled_callbacks' => '1', 'agentonly_callbacks' => '0', 'agentcall_manual' => '0', 'vicidial_recording' => '1', 'vicidial_transfers' => '0', 'delete_filters' => '0', 'alter_agent_interface_options' => '0', 'closer_default_blended' => '0', 'delete_call_times' => '1', 'modify_call_times' => '1', 'modify_users' => '1','modify_campaigns' => '1', 'modify_lists' => '1', 'modify_scripts' => '0', 'modify_filters' => '0', 'modify_ingroups' => '1', 'modify_usergroups' => '1', 'modify_remoteagents' => '0', 'modify_servers' => '0', 'view_reports' => '0' , 'vicidial_recording_override' => 'ALLFORCE', 'alter_custdata_override' => 'NOT_ACTIVE', 'qc_enabled' => '0', 'qc_user_level' => '1', 'qc_pass' => '0', 'qc_finish' => '0', 'qc_commit' => '0', 'add_timeclock_log' => '0', 'modify_timeclock_log' => '0', 'delete_timeclock_log' => '0', 'alter_custphone_override' => 'NOT_ACTIVE', 'vdc_agent_api_access' => '0', 'modify_inbound_dids'  => '1', 'delete_inbound_dids' => '1', 'alert_enabled' => '0', 'download_lists' => '1', 'agent_shift_enforcement_override' => 'DISABLED', 'manager_shift_enforcement_override'=> '0', 'shift_override_flag' => '0', 'export_reports' => '1', 'delete_from_dnc' => '1', 'allow_alerts' => '0', 'agent_call_log_view_override' => 'DISABLED', 'callcard_admin' => '1', 'agent_choose_blended' => '1', 'realtime_block_user_info' => '0', 'custom_fields_modify' => '0', 'force_change_password' => 'N', 'agent_lead_search_override' => 'NOT_ACTIVE', 'modify_shifts' => '0', 'modify_phones' => '0', 'modify_carriers' => '0', 'modify_labels' => '0', 'modify_statuses' => '0', 'modify_voicemail' => '0', 'modify_audiostore' => '0', 'modify_moh' => '0', 'modify_tts' => '0', 'preset_contact_search' => 'NOT_ACTIVE', 'modify_contacts' => '0', 'modify_same_user_level' => '1', 'admin_hide_lead_data' => '0', 'admin_hide_phone_data' => '0', 'agentcall_email' => '0', 'modify_email_accounts' => '0', 'alter_admin_interface_options' => '0', 'modify_colors' => '0'),
        '1' => array('delete_users' => '0','delete_user_groups' => '0', 'delete_lists' => '0', 'delete_campaigns' => '0', 'delete_ingroups' => '0', 'delete_remote_agents' => '0', 'load_leads' => '0', 'campaign_detail' => '0', 'ast_admin_access' => '0', 'ast_delete_phones' => '0', 'delete_scripts' => '0', 'modify_leads' => '0', 'hotkeys_active' => '0','change_agent_campaign' => '0', 'agent_choose_ingroups' => '1', 'closer_campaigns' => '', 'scheduled_callbacks' => '1', 'agentonly_callbacks' => '1', 'agentcall_manual' => '1', 'vicidial_recording' => '1', 'vicidial_transfers' => '1', 'delete_filters' => '0', 'alter_agent_interface_options' => '0', 'closer_default_blended' => '1', 'delete_call_times' => '0', 'modify_call_times' => '0', 'modify_users' => '0','modify_campaigns' => '0', 'modify_lists' => '0', 'modify_scripts' => '0', 'modify_filters' => '0', 'modify_ingroups' => '0', 'modify_usergroups' => '0', 'modify_remoteagents' => '0', 'modify_servers' => '0', 'view_reports' => '0', 'vicidial_recording_override' => 'DISABLED', 'alter_custdata_override' => 'NOT_ACTIVE', 'qc_enabled' => '0', 'qc_user_level' => '1', 'qc_pass' => '0', 'qc_finish' => '0', 'qc_commit' => '0', 'add_timeclock_log' => '0', 'modify_timeclock_log' => '0', 'delete_timeclock_log' => '0', 'alter_custphone_override' => 'NOT_ACTIVE', 'vdc_agent_api_access' => '0', 'modify_inbound_dids'  => '0', 'delete_inbound_dids' => '0', 'alert_enabled' => '0', 'download_lists' => '0', 'agent_shift_enforcement_override' => 'DISABLED', 'manager_shift_enforcement_override'=> '0', 'shift_override_flag' => '0', 'export_reports' => '0', 'delete_from_dnc' => '0', 'allow_alerts' => '0', 'agent_call_log_view_override' => 'DISABLED', 'callcard_admin' => '0', 'agent_choose_blended' => '1', 'realtime_block_user_info' => '0', 'custom_fields_modify' => '0', 'force_change_password' => 'N', 'agent_lead_search_override' => 'NOT_ACTIVE', 'modify_shifts' => '0', 'modify_phones' => '0', 'modify_carriers' => '0', 'modify_labels' => '0', 'modify_statuses' => '0', 'modify_voicemail' => '0', 'modify_audiostore' => '0', 'modify_moh' => '0', 'modify_tts' => '0', 'preset_contact_search' => 'NOT_ACTIVE', 'modify_contacts' => '0', 'modify_same_user_level' => '1', 'admin_hide_lead_data' => '0', 'admin_hide_phone_data' => '0', 'agentcall_email' => '0', 'modify_email_accounts' => '0', 'alter_admin_interface_options' => '1', 'modify_colors' => '0'),
    );

    public function __construct() {
        parent::__construct();
	$this->db = $this->vicidialdb->db;
    }

    public function cretaeTempTable(){
        $CI = &get_instance();
        $query = "SELECT * FROM {$this->_table_name}";
        $results = $this->vicidialdb->db->query($query)->result_array();
        $sql = "SHOW CREATE TABLE {$this->_table_name}";
        $define = $this->vicidialdb->db->query($sql)->row_array();
        $defination = $define['Create Table'];
        if ($CI->db->table_exists($define['Table']) == TRUE ){
            $sql = "TRUNCATE {$define['Table']}";
            $CI->db->query($sql);
        }else{
             $CI->db->query($defination);
        }
        foreach($results as  $rows){
           $qry = "INSERT INTO {$define['Table']} SET";
           foreach($rows as $key => $row) {
              $qry.= " {$key} = '{$row}',";
           }
           $qry = rtrim($qry, ',');
           $CI->db->query($qry);
        }
    }

    public function get_new()
    {
        $group = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $group->$colom =  $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $group;
    }

    public function addAgencyFromCrm($data = array(), $id = NULL)
    {
       try{
           $group = $this->get_by(array('user_level' => '8', 'active' => 'Y'), TRUE);
           $userData = array(
               'email' => $data['email'],
               'user_level' => '8',
               'user_group' => $group->user_group,
               'full_name' => $data['name'],
               'active' => 'Y',
           );
           if($id == NULL){
              $userData['user'] = $data['user'];
           }
           if(isset($data['password'])){
               $userData['pass'] = $data['password'];
           }
           $roles = $this->roles['8'];
           $newUserData = array_merge($userData, $roles);

           $vicidialUSerId = $this->save($newUserData,$id);
           $CI = &get_instance();
           $CI->load->model('agency_model');
           $CI->agency_model->update($data['id'],array('vicidial_user_id' => $vicidialUSerId));
           return TRUE;
       }catch (Exception $e){
           $this->seesion->set_flashdata('error', $e->getMessage()) ;
       }
    }

    public function addAgentFromCrm($data = array(), $id = NULL){
       try{
            //$group = $this->get_by(array('user_level' => '1', 'active' => 'Y'), TRUE);
            $userData = array(
                'email' => $data['email'],
                'user_level' => '1',
                //'user_group' => $group->user_group,
                'full_name' => $data['name'],
                'active' => 'Y',
                'user' => $data['user'],
            );
           if(isset($data['password'])){
               $userData['pass'] = $data['password'];
           }
            $roles = $this->roles['1'];
            $newUserData = array_merge($userData, $roles);
            $vicidialUSerId = $this->save($userData,$id);
            $CI = &get_instance();
            $CI->load->model('agent_model');
            $CI->agent_model->update($data['id'],array('vicidial_user_id' => $vicidialUSerId));
            return TRUE;
       }catch (Excepton $e){
          $this->seesion->set_flashdata('error', $e->getMessage()) ;
       }
    }
    public function queryForAgency($where='',$order='',$limit=''){
        $this->cretaeTempTable();
        $CI= &get_instance();
        $sql = "SELECT main.*,age.name,age.id FROM {$CI->db->protect_identifiers($this->_table_name, TRUE)} AS main,{$CI->db->protect_identifiers('agencies', TRUE)} AS age";

        if( $where != '' ){
                $sql.= "{$where}";
                $sql.= " AND main.user_id = age.vicidial_user_id ";
        }else{
            $sql.= " WHERE main.user_id = age.vicidial_user_id ";
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
    public function queryForAgent($where='',$order='',$limit=''){
        $this->cretaeTempTable();
        $CI= &get_instance();
        $sql = "SELECT main.*,age.fname,age.lname,age.id,agec.name,agec.id as agency_id FROM {$CI->db->protect_identifiers($this->_table_name, TRUE)} AS main,{$CI->db->protect_identifiers('agents', TRUE)} AS age, {$CI->db->protect_identifiers('agencies', TRUE)} AS agec";

        if( $where != '' ){
                $sql.= "{$where}";
                $sql.= " AND main.user_id = age.vicidial_user_id AND age.agency_id = agec.id ";
        }else{
            $sql.= " WHERE main.user_id = age.vicidial_user_id AND age.agency_id = agec.id ";
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
    public function save($data, $id = NULL) {
        $editId = $id;
        $id = parent::save($data, $id);
        if( $editId == NULL ){
            $CI = &get_instance();
            $CI->load->model('vicidial/vphones_m','vphones_m');
            $lastId = $CI->vphones_m->getLastInserted();
            $seq = $lastId + 1;
            $phoneData = array(
                'extension' => 'CRM'.$seq,
                'dialplan_number' => $seq,
                'voicemail_id' => $seq,
                'login' => 'crm'.$seq,
                'pass' => 'crm'.$seq,
                'conf_secret' => 'utyghujikoplit65',
                'active' => 'Y',
                'fullname' => 'CRM'.$seq
            );
            $default = $CI->vphones_m->_default;
            $newPhoneData = array_merge($phoneData,$default);
            $phoneID = $CI->vphones_m->save($newPhoneData);
            if($phoneID > 0){
                $CI->db->set(array('vicidial_user_id' => $id , 'vicidial_phone_id' => $phoneID));
                $CI->db->insert('users_phones');
                $CI->db->last_query();
            }
        }else{
            $CI = &get_instance();
            $CI->load->model('vicidial/vphones_m','vphones_m');
            $server_ip = $CI->vphones_m->_server_ip;
            $this->db->query("UPDATE servers SET rebuild_conf_files='Y' WHERE server_ip='".$server_ip."'");
        }
        return $id;
    }
    public function delete($id) {
        parent::delete($id);
        $CI = &get_instance();
        /* get the vicidial phone id from CRM table users_phones*/
        $CI->db->where('vicidial_user_id',$id);
        $phone = $CI->db->get('users_phones')->row();
        /* delete the phone from vicidial */
        $CI->load->model('vicidial/vphones_m','vphones_m');
        $phone = $CI->vphones_m->get_by(array('id' => $phone->vicidial_phone_id), TRUE);
        $CI->vphones_m->delete($phone->id);
        /* delete the record from crm table */
        $CI->db->where('vicidial_user_id',$id);
        $CI->db->limit(1);
        $CI->db->delete('users_phones');
    }
}
