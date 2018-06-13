<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vregroup_m extends My_Model{
    protected $_table_name     = 'vicidial_extension_groups';
    protected $_primary_key    = 'extension_id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'extension_id';
    protected $_timestamps     = FALSE;
    public $_temptable;
    public $rules = array(
        'extension_group_id' => array(
            'field' => 'extension_group_id',
            'label' => 'Extension Group',
            'rules' => 'trim|required|callback__unique_group_id'
        ),
        'extension' => array(
            'field' => 'extension',
            'label' => 'Extension',
            'rules' => 'trim|required|numeric'
        )
    );
    public $default = array(
        'extension' => '8300', 'rank' => 0 , 'call_count_today' => 0
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
