<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leadorder_m extends My_Model {

    protected $_table_name = 'lead_order';
    protected $_primary_key = 'order_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'order_id';
    protected $_timestamps = TRUE;
//    public $rules = array(
//        'first_name' => array(
//            'field' => 'first_name',
//            'label' => 'First Name',
//            'rules' => 'trim|required'
//        ),
//        'list_name' => array(
//            'field' => 'last_name',
//            'label' => 'Last Name',
//            'rules' => 'trim|required'
//        ),
//        'phone' => array(
//            'field' => 'phone',
//            'label' => 'Phone Number',
//            'rules' => 'trim|required|numeric',
//        ),
//        'email' => array(
//            'field' => 'email',
//            'label' => 'Email ID',
//            'rules' => 'trim|valid_email'
//        )
//    );

    public function get_new() {
        $lead = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $lead->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $lead;
    }
    
    public function queryForAgency($where='',$order='',$limit=''){
        $agentlist = getAgentFromAgncyId();
        $sql = "SELECT ol.order_id,CONCAT(a.fname,' ',a.lname) as agent_name,ol.lead_type,ol.lead_category,ol.lead_quantity,ol.total_amount,ol.transaction_id,ol.transaction_date FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} ol LEFT JOIN agents a ON ol.agent_id = a.id ";

        if( $where != '' ){
            $sql.= "{$where} AND ol.agent_id IN({$agentlist})";
        }else{
            $sql.= " WHERE ol.agent_id IN({$agentlist})";
        }

        if( $order != '' )
            $sql.= "{$order}";
        else
            $sql.= " ORDER BY {$this->_primary_key} DESC";

        if( $limit != '' )
            $sql.= "{$limit} ";

        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
            return $query->result_array();
        else
            return false;
    }

}
