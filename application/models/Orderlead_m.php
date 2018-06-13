<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orderlead_m extends My_Model{

    protected $_table_name = 'lead_order';
    protected $_primary_key = 'order_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'order_id';
    protected $_timestamps = TRUE;
  
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
