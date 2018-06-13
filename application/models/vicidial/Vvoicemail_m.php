<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vvoicemail_m extends My_Model{
    protected $_table_name     = 'vicidial_voicemail';
    protected $_primary_key    = 'voicemail_id';
    protected $_primary_filter = 'strval';
    protected $_order_by       = 'voicemail_id';
    protected $_timestamps     = FALSE;

    public $rules = array(
        'voicemail_id' => array(
            'field' => 'voicemail_id',
            'label' => 'Voicemail ID',
            'rules' => 'trim|required|callback__unique_voicemail_id|min_length[2]|max_length[20]'
        ),
        'pass' => array(
            'field' => 'pass',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[2]|max_length[10]'
        ),
        'fullname' => array(
            'field' => 'fullname',
            'label' => 'Name',
            'rules' => 'trim|required|min_length[2]|max_length[100]'
        )
    );

    public function __construct() {
        parent::__construct();
        $this->db = $this->vicidialdb->db;
    }
    public function get_new() {
        $voicemail = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $voicemail->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $voicemail;
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
}
