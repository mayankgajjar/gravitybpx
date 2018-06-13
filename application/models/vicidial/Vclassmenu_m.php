<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vclassmenu_m extends My_Model{
    protected $_table_name = 'vicidial_call_menu';
    protected $_primary_key = 'menu_id';
    protected $_primary_filter = 'strval';
    protected $_order_by = 'menu_id';
    protected $_timestamps = FALSE;
    public $_temptable;

    public $rules = array(
        'menu_id' => array(
            'field' => 'menu_id',
            'label' => 'Menu ID',
            'rules' => 'trim|required|callback__check_string|callback__unique_menu_id'
        ),
        'menu_name' => array(
            'field' => 'menu_name',
            'label' => 'Menu Name',
            'rules' => 'trim|required'
        )
    );

    public function __construct() {
        parent::__construct();
        $this->db = $this->vicidialdb->db;
    }
    public function get_new(){
        $menu = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $menu->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        $menu->agency_id = $this->input->post('agency_id') ? $this->input->post('agency_id') : '';
        return $menu;
    }
    public function getLastInserted() {
	//$this->db->select_max($this->_primary_key);
	//$Q = $this->db->get($this->_table_name);
        $query = $this->db->query("SELECT * FROM {$this->_table_name} order by created DESC limit 1");
	//$query = $Q->result_array();
        $row = $query->row_array();

	return $row[$this->_primary_key];
    }
    public function save($data, $id = NULL){
        if($this->_timestamps == TRUE){
            $now = date('Y-m-d H:i:s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }

        if( $id === NULL ){
            //!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
            $this->db->set($data);
            $this->db->insert($this->_table_name);
            $id = $this->getLastInserted();
        }else{
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);
        }
        return $id;
    }
    public function createTempTable(){
        $CI = &get_instance();
        $results = (array)$this->get();
        /* get defination of the table */
        $sql = "SHOW CREATE TABLE {$this->_table_name}";
        $define = $this->db->query($sql)->row_array();
        $defination = $define['Create Table'];
        $tablename = $define['Table'].'_temp';
        $this->_temptable = $tablename;
        $defination = str_replace($define['Table'], $tablename, $defination);
        if ($CI->db->table_exists($tablename) == TRUE ){
            $sql = "TRUNCATE {$tablename}";
            $CI->db->query($sql);
        }else{
             $CI->db->query($defination);
        }
        foreach($results as  $rows){
           $qry = "INSERT INTO {$this->_temptable} SET";
           foreach($rows as $key => $row) {
              //$values .= " {$key} = '{$this->db->escape($row)}',";
              $qry.= " {$key} = {$this->db->escape($row)},";
           }
           $qry = rtrim($qry, ',');
           $CI->db->query($qry);
        }
    }
}
