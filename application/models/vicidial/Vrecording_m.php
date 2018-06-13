<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vrecording_m extends My_Model{
    protected $_table_name     = 'recording_log';
    protected $_primary_key    = 'recording_id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'recording_id';
    protected $_timestamps     = FALSE;    
    public $_tempTable;
    
    public function __construct() {
        parent::__construct();
        $this->db = $this->vicidialdb->db;
    }

    public function cretaeTempTable($svWhere = '')
    {   
        $CI = &get_instance();
        
        $query = "SELECT * FROM {$this->_table_name}";

        $results = $this->db->query($query)->result_array();

        /* get defination of the table */
        $sql = "SHOW CREATE TABLE {$this->_table_name}";
        $define = $this->db->query($sql)->row_array();
        $defination = $define['Create Table'];
        $tablename = $define['Table'].'_temp';
        $this->_tempTable = $tablename;        
        $defination = str_replace($define['Table'], $tablename, $defination);
        if ($CI->db->table_exists($tablename) == TRUE ){
            $sql = "TRUNCATE {$tablename}";
            $CI->db->query($sql);
        }else{
            $CI->db->query($defination);
            $sql = "ALTER TABLE {$this->_tempTable} ADD user_id int(11)";
            $CI->db->query($sql);
        }
        foreach($results as  $rows){
           $user = $this->vusers_m->get_by(array('user' => $rows['user']), TRUE); 
           $rows['user_id'] = $user->user_id;           
           $qry = "INSERT INTO {$this->_tempTable} SET";
           foreach($rows as $key => $row) {
              //$values .= " {$key} = '{$this->db->escape($row)}',";
              $qry.= " {$key} = {$this->db->escape($row)},";
           }
           $qry = rtrim($qry, ',');
           $CI->db->query($qry);
        }
    }    
    
}
