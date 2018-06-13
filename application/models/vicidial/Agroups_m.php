<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agroups_m extends My_Model{
    protected $_table_name     = 'agency_agent_groups';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;
    public $_tempTable = 'vicidial_user_groups';

    public function cretaeTempTable(){
        $query = "SELECT * FROM vicidial_user_groups";
        $results = $this->vicidialdb->db->query($query)->result_array();
        $sql = "SHOW CREATE TABLE vicidial_user_groups";
        $define = $this->vicidialdb->db->query($sql)->row_array();
        $defination = $define['Create Table'];
        if ($this->db->table_exists($define['Table']) == TRUE ){
            $sql = "TRUNCATE {$define['Table']}";
            $this->db->query($sql);
        }else{
             $this->db->query($defination);
        }
        foreach($results as  $rows){
           $qry = "INSERT INTO {$define['Table']} SET";
           foreach($rows as $key => $row) {
              $qry.= " {$key} = '{$row}',";
           }
           $qry = rtrim($qry, ',');
           $this->db->query($qry);
        }
    }

    public function query($where='',$order='',$limit=''){
        $this->cretaeTempTable();
        $CI = &get_instance();
        $sql = "SELECT main.*, age.name, age.id as agency_id FROM {$this->db->protect_identifiers('vicidial_user_groups', TRUE)} AS main, {$CI->db->protect_identifiers($this->_table_name, TRUE)} AS sec, {$CI->db->protect_identifiers('agencies', TRUE)} AS age";
        $query = "select id from {$CI->db->protect_identifiers('agencies',TRUE)} WHERE parent_agency={$this->session->userdata('agency')->id}";
        $results = $CI->db->query($query)->result_array();
        $ids[] = $this->session->userdata('agency')->id;
        foreach($results as $result){
            $ids[] = $result['id'];
        }
        $ids = implode(',', $ids);
        if( $where != '' ){
                $sql.= "{$where}";
                $sql.= " AND main.id = sec.vicidial_group_id AND age.id = sec.agency_id AND sec.agency_id IN({$ids}) ";
        }else{
            $sql.= " WHERE main.id = sec.vicidial_group_id AND age.id = sec.agency_id AND sec.agency_id IN({$ids}) ";
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
    public function getAgencyGroup($agencyId){
        $this->cretaeTempTable();
        $sql = "SELECT main.*, age.name, age.id as agency_id FROM {$this->db->protect_identifiers('vicidial_user_groups', TRUE)} AS main, {$this->db->protect_identifiers($this->_table_name, TRUE)} AS sec, {$this->db->protect_identifiers('agencies', TRUE)} AS age";
        $sql.= " WHERE main.id = sec.vicidial_group_id AND age.id = sec.agency_id AND sec.agency_id = {$agencyId}";
        $query = $this->db->query($sql);
        if( $query->num_rows() > 0 )
            return $query->result();
        else
            return false;
    }
    public function queryForAdmin($where='',$order='',$limit=''){
        $this->cretaeTempTable();
        $sql = "SELECT main.id AS `main.id`, main.user_group AS `main.user_group`, main.group_name AS `main.group_name`, age.name AS `age.name`, age.id AS `main.agency_id`  FROM {$this->db->protect_identifiers($this->_tempTable, TRUE)} main LEFT JOIN {$this->db->protect_identifiers($this->_table_name, TRUE)} sub ON sub.vicidial_group_id = main.id LEFT JOIN {$this->db->protect_identifiers('agencies', TRUE)} age ON sub.agency_id = age.id ";

        if( $where != '' ){
            $sql.= "{$where}";
        }

        if( $order != '' )
            $sql.= "{$order}";
        else
            $sql.= " ORDER BY main.{$this->_primary_key} DESC";

        if( $limit != '' )
            $sql.= "{$limit} ";

        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
            return $query->result_array();
        else
            return false;
    }
}
