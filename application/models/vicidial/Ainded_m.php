<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ainded_m extends My_Model{
    protected $_table_name = 'agency_inbound_did';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = TRUE;

    public function query($where = '', $order = '', $limit = '') {
        $CI = &get_instance();
        $this->indid_m->createTempTable();
        $_tempTable = $this->indid_m->_temptable;
        //$sql = "SELECT * FROM {$this->db->protect_identifiers($_tempTable, TRUE)} AS main,{$this->db->protect_identifiers($this->_table_name, TRUE)} AS amain WHERE amain.vicidial_did_id=main.did_id ";
        $sql = "SELECT main.*,amain.id,amain.agency_id,age.name FROM {$this->db->protect_identifiers($_tempTable, TRUE)} AS main LEFT JOIN {$this->db->protect_identifiers($this->_table_name, TRUE)} amain ON amain.vicidial_did_id=main.did_id LEFT JOIN {$this->db->protect_identifiers('agencies', TRUE)} age ON amain.agency_id=age.id ";
        if( $this->session->userdata("user")->group_name == 'Agency' ){
            $list = getAgencies();
        }
        if( $where != '' ){
            $sql.= "{$where}";
            if(isset($list)){
                $sql.= " AND age.id IN($list) ";
            }
        }else{
            if(isset($list)){
                $sql.= "WHERE age.id IN($list) ";
            }
        }

        if( $order != '' )
            $sql.= "{$order}";
        else
                $sql.= " ORDER BY amain.created DESC";

        if( $limit != '' )
            $sql.= "{$limit} ";

        $query = $this->db->query($sql);

    if( $query->num_rows() > 0 )
        return $query->result_array();
    else
        return false;
    }
}
