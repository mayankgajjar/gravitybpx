<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vcstatuses_m extends My_Model{
    protected $_table_name     = 'vicidial_campaign_statuses';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = FALSE;

    public  $rules =  array(
        'status' => array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => 'trim|required|min_length[2]|max_length[6]'
        ),
        'status_name' => array(
            'field' => 'status_name',
            'label' => 'Status Name',
            'rules' => 'trim|required'
        )
    );

    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
	$this->db = $CI->vicidialdb->db;
    }

//    public function save($data, $id = NULL)
//    {
//        if($this->_timestamps == TRUE){
//            $now = date('Y-m-d H:i:s');
//            $id || $data['created'] = $now;
//            $data['modified'] = $now;
//        }
//
//        if( $id === NULL ){
//            $this->db->set($data);
//            $this->db->insert($this->_table_name);
//            $id = $this->getLastInserted();
//        }else{
//            $filter = $this->_primary_filter;
//            $id = $filter($id);
//            $this->db->set($data);
//            $this->db->where($this->_primary_key, $id);
//            $this->db->update($this->_table_name);
//        }
//        return $id;
//    }

    public function getLastInserted() {
	$this->db->select_max($this->_primary_key);
	$Q = $this->db->get($this->_table_name);
	$row = $Q->row_array();
	return $row[$this->_primary_key];
    }

}
