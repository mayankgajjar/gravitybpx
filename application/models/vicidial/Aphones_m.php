<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aphones_m extends My_Model{
    protected $_table_name     = 'users_phones';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = FALSE;
    public $_temptable;


    public function createTempTable(){
        $query = "SELECT * FROM phones";
        $results = $this->vicidialdb->db->query($query)->result_array();
        $sql = "SHOW CREATE TABLE phones";
        $define = $this->vicidialdb->db->query($sql)->row_array();
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
              $qry.= " {$key} = '{$row}',";
           }
           $qry = rtrim($qry, ',');
           $this->db->query($qry);
        }
    }

    public function queryForAgency($where = '', $order = '', $limit = '') {
        $this->createTempTable();
        $sql = "SELECT p.*, age.name,age.id as agency_id FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} as main,{$this->db->protect_identifiers($this->_temptable, TRUE)} as p, {$this->db->protect_identifiers('agencies', TRUE)} age";
        $ids = '';
        if($this->session->userdata("user")->group_name == 'Agency'){
            $query = "select id from {$this->db->protect_identifiers('agencies',TRUE)} WHERE parent_agency={$this->session->userdata('agency')->id}";
            $results = $this->db->query($query)->result_array();
            $ids[] = $this->session->userdata('agency')->id;
            foreach($results as $result){
                $ids[] = $result['id'];
            }
            $ids = 'AND age.id IN ('.implode(',', $ids).')';
        }
        if( $where != '' ){
            $sql.= "{$where} AND main.vicidial_phone_id = p.id AND main.vicidial_user_id = age.vicidial_user_id {$ids}";
        }else{
            $sql.= " WHERE main.vicidial_phone_id = p.id AND main.vicidial_user_id = age.vicidial_user_id {$ids}";
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

    public function queryForAgent($where = '', $order = '', $limit = '') {
        $this->createTempTable();
        $sql = "SELECT p.*, age.fname, age.lname,age.id as agent_id FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} as main,{$this->db->protect_identifiers($this->_temptable, TRUE)} as p, {$this->db->protect_identifiers('agents', TRUE)} age";
        $ids = '';
        if($this->session->userdata("user")->group_name == 'Agency'){
            $query = "select id from {$this->db->protect_identifiers('agencies',TRUE)} WHERE parent_agency={$this->session->userdata('agency')->id}";
            $results = $this->db->query($query)->result_array();
            $ids[] = $this->session->userdata('agency')->id;
            foreach($results as $result){
                $ids[] = $result['id'];
            }
            $ids = 'AND age.agency_id IN ('.implode(',', $ids).')';
        }
        if( $where != '' ){
            $sql.= "{$where} AND main.vicidial_phone_id = p.id AND main.vicidial_user_id = age.vicidial_user_id {$ids}";
        }else{
            $sql.= " WHERE main.vicidial_phone_id = p.id AND main.vicidial_user_id = age.vicidial_user_id {$ids}";
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
