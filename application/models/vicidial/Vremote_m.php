<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vremote_m extends My_Model{
    protected $_table_name     = 'vicidial_remote_agents';
    protected $_primary_key    = 'remote_agent_id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'remote_agent_id';
    protected $_timestamps     = FALSE;
    public $_temptable;
    public $rules = array(
        'agency_id' => array(
            'field' => 'agency_id',
            'label' => 'Agency',
            'rules' => 'trim|required'
        ),
        'user_start' => array(
            'field' => 'user_start',
            'label' => 'User',
            'rules' => 'trim|required|callback__unique_remote_id'
        )
    );
    public $default = array(
        'on_hook_ring_time' => '15', 'on_hook_agent' => 'N', 'extension_group' => 'NONE', 'extension_group_order' => 'NONE', 'status' => 'INACTIVE', 'server_ip' => VICIDIAL_SERVER_IP, 'number_of_lines' => '1'
    );
    public function __construct() {
        parent::__construct();
        $this->db = $this->vicidialdb->db;
    }
    public function get_new(){
        $ragent = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $val = '';
            if(array_key_exists($colom,$this->default)){
                $val = $this->default[$colom];
            }
            $ragent->$colom =  $this->input->post($colom) ? $this->input->post($colom) : $val ;
        }
        return $ragent;
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
