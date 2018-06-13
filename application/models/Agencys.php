<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agencys extends My_Model {

    protected $_table_name = 'agencies';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = FALSE;

    public function query($where = '', $order = '', $limit = '') {
        $sql = "SELECT main.id AS `main.id`,main.domain AS `main.domain`,main.name AS `main.name`,main.service_email AS `main.service_email`,CONCAT(main.fname, ' ', main.lname) AS `main.fname`, main.vicidial_user_id AS `main.vicidial_user_id`,main.phone_number AS `main.phone_number`,sub.name AS `sub.name` FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} main LEFT JOIN {$this->db->protect_identifiers($this->_table_name, TRUE)} sub ON main.parent_agency = sub.id";

        if ($where != '') {
            $sql.= " {$where} ";
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
        $sql = "SELECT main.id AS `main.id`,main.domain AS `main.domain`, main.name AS `main.name`,main.service_email AS `main.service_email`,CONCAT(main.fname, ' ', main.lname) AS `main.fname`, main.vicidial_user_id AS `main.vicidial_user_id`,main.phone_number AS `main.phone_number`,sub.name AS `sub.name` FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} main LEFT JOIN {$this->db->protect_identifiers($this->_table_name, TRUE)} sub ON main.parent_agency = sub.id";
        if($where == ''){
            $where = 'WHERE main.parent_agency='.$this->session->userdata('agency')->id;
        }else{
            $where .= 'AND main.parent_agency='.$this->session->userdata('agency')->id;
        }

        if ($where != '') {
            $sql.= " {$where} ";
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

}
