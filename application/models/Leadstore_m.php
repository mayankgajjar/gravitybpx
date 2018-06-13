<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leadstore_m extends My_Model {

    protected $_table_name = 'lead_store_mst';
    protected $_primary_key = 'lead_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'lead_id';
    protected $_timestamps = TRUE;
    public $rules = array(
        'first_name' => array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required'
        ),
        'last_name' => array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required'
        ),
        'phone' => array(
            'field' => 'phone',
            'label' => 'Phone Number',
            'rules' => 'trim|required|numeric',
        ),
        'email' => array(
            'field' => 'email',
            'label' => 'Email ID',
            'rules' => 'trim|valid_email'
        )
    );

    public function get_new() {
        $lead = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $lead->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $lead;
    }

    public function query($where = '', $order = '', $limit = '') {

        $sql = "SELECT CONCAT(main.first_name,' ',main.last_name) AS `main.first_name`, main.member_id,main.dispo,main.user,main.lead_id, main.phone, (CASE WHEN TRIM(main.city) IS NULL THEN '' ELSE CONCAT(main.city,', ',main.state) END)  AS city, main.status, main.last_local_call_time, (CASE WHEN a.name IS NULL THEN 'Admin' ELSE a.name END) AS `name`, (CASE WHEN ag.id IS NULL THEN 'Not Asssigned' ELSE CONCAT(ag.fname,' ',ag.lname) END) AS `ag.fname`  FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} main LEFT JOIN agencies a ON main.agency_id = a.id LEFT JOIN agents ag ON main.user = ag.id ";

        if ($where != '') {
            $sql .= "{$where}";
        }

        if ($order != '')
            $sql .= "{$order}";
        else
            $sql .= " ORDER BY {$this->_primary_key} DESC";

        if ($limit != '')
            $sql .= "{$limit} ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    public function queryForAgency($where = '', $order = '', $limit = '') {
        $agencylist = getAgencies();
        $sql = "SELECT CONCAT(main.first_name,' ',main.last_name) AS `main.first_name`, main.member_id,main.dispo,main.user,main.lead_id, main.phone, (CASE WHEN TRIM(main.city) IS NULL THEN '' ELSE CONCAT(main.city,', ',main.state) END)  AS city, main.status, main.last_local_call_time, (CASE WHEN a.name IS NULL THEN 'Admin' ELSE a.name END) AS `name`, (CASE WHEN ag.id IS NULL THEN 'Not Asssigned' ELSE CONCAT(ag.fname,' ',ag.lname) END) AS `ag.fname`  FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} main LEFT JOIN agencies a ON main.agency_id = a.id LEFT JOIN agents ag ON main.user = ag.id ";

        if ($where != '') {
            $sql .= "{$where} AND a.id IN({$agencylist})";
        } else {
            $sql .= " WHERE a.id IN({$agencylist})";
        }

        if ($order != '')
            $sql .= "{$order}";
        else
            $sql .= " ORDER BY {$this->_primary_key} DESC";

        if ($limit != '')
            $sql .= "{$limit} ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    public function queryForAgent($where = '', $order = '', $limit = '') {
        $sql = "SELECT CONCAT(main.first_name,' ',main.last_name) AS `main.first_name`, main.lead_category,main.member_id,main.dispo,main.user,main.gender,main.source,main.email,main.postal_code,main.lead_id, main.phone,(CASE WHEN TRIM(main.city) IS NULL THEN '' ELSE CONCAT(main.city,', ',main.state) END)  AS city, main.status, main.last_local_call_time, (CASE WHEN a.name IS NULL THEN 'Admin' ELSE a.name END) AS `name`, (CASE WHEN ag.id IS NULL THEN 'Not Asssigned' ELSE CONCAT(ag.fname,' ',ag.lname) END) AS `ag.fname`  FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} main JOIN agencies a ON main.agency_id = a.id JOIN agents ag ON main.user = ag.id ";

        if ($where != '') {
            $sql .= "{$where} AND ag.id = {$this->session->userdata('agent')->id} ";
        } else {
            $sql .= " WHERE ag.id = {$this->session->userdata('agent')->id} ";
        }

        if ($order != '')
            $sql .= "{$order}";
        else
            $sql .= " ORDER BY {$this->_primary_key} DESC";

        if ($limit != '')
            $sql .= "{$limit} ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    /**
     * @uses GET email address from LEAD ID
     * @param init $leadId
     * @return string EMAIL ADDRESS OF GIVEN LEAD
     */
    public function getLeadEmail($leadId = "") {
        if ($leadId == "") {
            exit('LEAD ID NULL MODEL|| ERROR');
        }
        $this->db->select('email');
        $this->db->where(array('lead_id' => $leadId));
        $this->db->limit('0', '1');
        $query = $this->db->get('lead_store_mst');
        $res = $query->result();
        $resEmail = $res[0]->email;
        return $resEmail;
    }

    /**
     * @uses GET Phone Number from LEAD ID
     * @param init $leadId
     * @return string Phone Number OF GIVEN LEAD
     */
    public function getLeadNumber($leadId = "") {
        if ($leadId == "") {
            exit('LEAD ID NULL MODEL|| ERROR');
        }
        $this->db->select('phone');
        $this->db->where(array('lead_id' => $leadId));
        $this->db->limit('0', '1');
        $query = $this->db->get('lead_store_mst');
        $res = $query->result();
        $resPhno = $res[0]->phone;
        $resPhno = str_replace("-", "", $resPhno);
        if (strlen($resPhno) == 12) {
            return str_replace("-", "", $resPhno);
        } else {
            return '1' . str_replace("-", "", $resPhno);
        }
    }

    /**
     * @uses GET ID FROM PHONE NUMBER
     * @param INIT $phoneNumber LEAD'S phone number
     * @return INIT $leadID LEAD ID
     */
    public function getIdByPhoneNumber($phoneNumber){
        
    }
}
