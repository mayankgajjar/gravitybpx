<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LeadSmsLog_m extends My_Model {

    protected $_table_name = 'lead_sms_log';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = TRUE;

    /**
     * @uses Get chat history
     */
    public function chat_history($leadPhone = null) {
        if ($leadPhone == null) {
            exit('Lead Phone Number NULL || ERROR');
        }
    }


    public function getAgentPlivoNumbers($agencyID = null) {
        if ($agencyID == null) {
            exit('Agency ID NULL || ERROR');
        }
        $this->db->select('CONCAT(1,plivo_phone) as plivo_phone');
        $this->db->where('agency_id', $agencyID);
        $this->db->where('plivo_phone !=""');
        $agent_number = $this->db->get('agents')->result_array();
        $agent_number = array_column($agent_number, 'plivo_phone');
        return $agent_number;
    }

}
