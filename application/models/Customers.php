<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends My_Model{

    protected $_table_name = 'customers';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = FALSE;

    public function queryForAgent($where = '', $order = '', $limit = '') {
    	$agentId = $this->session->userdata('agent')->id;
        $sql = "SELECT main.id AS `main.id`, CONCAT(main.fname, ' ', main.mname, ' ', main.lname) AS `main.fname`, main.gender AS `main.gender`, main.date_of_birth AS `main.date_of_birth`, main.zipcode AS `main.zipcode`, main.phone_number AS 'main.phone_number', main.email AS `main.email`  FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} main ";
        if($where == ''){
        	$where = "WHERE main.agent_id = {$agentId}";
        }else{
        	$where .= "AND main.agent_id = {$agentId}";
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