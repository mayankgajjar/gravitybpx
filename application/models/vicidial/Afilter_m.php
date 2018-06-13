<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Afilter_m extends My_Model{
    protected $_table_name     = 'agency_filters';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = FALSE;
    protected $_temptable;

    private function createTempTable(){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $query = "SELECT * FROM vicidial_lead_filters";
        $results = $CI->vicidialdb->db->query($query)->result_array();
        /* get defination of the table */
        $sql = "SHOW CREATE TABLE vicidial_lead_filters";
        $define = $CI->vicidialdb->db->query($sql)->row_array();
        $defination = $define['Create Table'];
        $tablename = $define['Table'].'_temp';
        $this->_temptable = $tablename;
        $defination = str_replace($define['Table'], $tablename, $defination);
        if ($this->db->table_exists($tablename) == TRUE ){
            $sql = "TRUNCATE {$tablename}";
            $this->db->query($sql);
        }else{
             $this->db->query($defination);
        }
        foreach($results as  $rows){
           $qry = "INSERT INTO {$this->_temptable} SET";
           foreach($rows as $key => $row) {
              //$values .= " {$key} = '{$this->db->escape($row)}',";
              $qry.= " {$key} = {$this->db->escape($row)},";
           }
           $qry = rtrim($qry, ',');
           $this->db->query($qry);
        }
    }
    public function queryForAgency($where = '', $order = '', $limit = '') {
        $this->createTempTable();
        $sql = "SELECT main.*,sub.* FROM {$this->db->protect_identifiers($this->_temptable, TRUE)} AS main, {$this->db->protect_identifiers($this->_table_name, TRUE)} as sub ";
        $lists = getAgencies();
        if( $where != '' ){
            $sql.= "{$where} AND main.lead_filter_id = sub.vicidial_filter_id AND sub.agency_id IN({$lists})";
        }else{
            $sql.= " WHERE main.lead_filter_id = sub.vicidial_filter_id AND sub.agency_id IN({$lists})";
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
