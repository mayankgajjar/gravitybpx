<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avoicemail_m extends My_Model{
    protected $_table_name     = 'agency_voicemail';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;
    public $_temptable;

    public function createTempTable(){
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
        $query = "SELECT * FROM vicidial_voicemail";
        $results = $CI->vicidialdb->db->query($query)->result_array();
        /* get defination of the table */
        $sql = "SHOW CREATE TABLE vicidial_voicemail";
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
              $qry.= " {$key} = {$this->db->escape($row)},";
           }
           $qry = rtrim($qry, ',');
           $this->db->query($qry);
        }
    }

    public function queryForAgency($where = '', $order = '', $limit = '') {
        $this->createTempTable();
        $sql = "SELECT main.*,sub.*,age.name FROM {$this->db->protect_identifiers($this->_temptable, TRUE)} AS main, {$this->db->protect_identifiers($this->_table_name, TRUE)} as sub,{$this->db->protect_identifiers('agencies', TRUE)} as age  ";
        $lists = getAgencies();
        if( $where != '' ){
            $sql.= "{$where} AND main.voicemail_id = sub.vicidial_voicemail_id AND sub.agency_id IN({$lists}) AND age.id = sub.agency_id ";
        }else{
            $sql.= " WHERE main.voicemail_id = sub.vicidial_voicemail_id AND sub.agency_id IN({$lists}) AND age.id = sub.agency_id ";
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