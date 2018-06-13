<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agents extends My_Model {

    protected $_table_name = 'agents';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = FALSE;

    public function query($where = '', $order = '', $limit = '') {
        $sql = "SELECT main.id AS `main.id`, main.fname AS `main.fname`, main.lname AS `main.lname`, main.phone_number AS `main.phone_number`, CASE WHEN main.agent_type = '1' THEN 'Sales Agent' WHEN main.agent_type = '2' THEN 'Verification Agent' WHEN main.agent_type = '3' THEN 'Processing Agent' END AS `main.agent_type`, sip_end_point AS `main.sip_end_point`, agency.name AS `agency.name`,users.id AS `users.id`,users.email_id AS `users.email_id`,users.user_token, main.vicidial_user_id as `main.vicidial_user_id` FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} main LEFT JOIN {$this->db->protect_identifiers('agencies', TRUE)} AS agency ON main.agency_id = agency.id LEFT JOIN {$this->db->protect_identifiers('users', TRUE)} AS users ON main.user_id = users.id";

       if ($where != '') {
            $sql.= " {$where}";
        }

        if ($order != '')
            $sql.= " {$order}";
        else
            $sql.= " ORDER BY main.{$this->_primary_key} DESC";

        if ($limit != '')
            $sql.= "{$limit} ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    public function queryForAgency($where = '', $order = '', $limit = '') {
        $sql = "SELECT main.id AS `main.id`, main.fname AS `main.fname`, main.lname AS `main.lname`, main.phone_number AS `main.phone_number`, CASE WHEN main.agent_type = '1' THEN 'Sales Agent' WHEN main.agent_type = '2' THEN 'Verification Agent' WHEN main.agent_type = '3' THEN 'Processing Agent' END AS `main.agent_type`, agency.name AS `agency.name`,users.email_id AS `users.email_id`, main.vicidial_user_id as `main.vicidial_user_id` FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} main LEFT JOIN {$this->db->protect_identifiers('agencies', TRUE)} AS agency ON main.agency_id = agency.id LEFT JOIN {$this->db->protect_identifiers('users', TRUE)} AS users ON main.user_id = users.id";
        $lists = getAgencies();
        if($where == ''){
            $where = 'WHERE main.agency_id IN('.$lists.')';
        }else{
            $where .= 'AND main.agency_id IN('.$lists.')';
        }

       if ($where != '') {
            $sql.= " {$where}";
        }

        if ($order != '')
            $sql.= " {$order}";
        else
            $sql.= " ORDER BY main.{$this->_primary_key} DESC";

        if ($limit != '')
            $sql.= "{$limit} ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    public function updateAgentBalance($agentId = NULL ,$money = 0, $op = 'add'){
        if($money > 0 && $agentId){
            $agent = $this->get($agentId, TRUE);
            $currentBalance = $agent->balance;
            switch ($op) {
                case 'add':
                    $currentBalance = $currentBalance + $money;
                    break;
                case 'sub';
                    $currentBalance = $currentBalance - $money;
                    break;
                default:
                    break;
            }
            $this->save(array('balance' => $currentBalance), $agentId);
        }
    }
}
