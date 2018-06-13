<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vlfilters_m extends My_Model{
    protected $_table_name     = 'vicidial_lead_filters';
    protected $_primary_key    = 'lead_filter_id';
    protected $_primary_filter = 'strval';
    protected $_order_by       = 'lead_filter_id';
    protected $_timestamps     = FALSE;

    public $rules = array(
        'lead_filter_id' => array(
            'field' => 'lead_filter_id',
            'label' => 'Filter ID',
            'rules' => 'trim|required|min_length[2]|max_length[20]|callback__check_string|callback__unique_filter_id'
        ),
        'lead_filter_name' => array(
            'field' => 'lead_filter_name',
            'label' => 'Filter Name',
            'rules' => 'trim|required|min_length[2]|max_length[30]'
        ),
        'filter_options' => array(
            'field' => 'filter_options',
            'label' => 'Filter',
            'rules' => 'trim|required',
        )
    );

    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
	$this->db = $CI->vicidialdb->db;
    }
    public function get_new(){
        $filter = new stdClass();
        $filter->lead_filter_id = $this->input->post('lead_filter_id') ? $this->input->post('lead_filter_id') : '';
        $filter->lead_filter_name = $this->input->post('lead_filter_name') ? $this->input->post('lead_filter_name') : '';
        $filter->lead_filter_comments = $this->input->post('lead_filter_comments') ? $this->input->post('lead_filter_comments') : '';
        $filter->lead_filter_sql = $this->input->post('lead_filter_sql') ? $this->input->post('lead_filter_sql') : '';
        $filter->user_group = $this->input->post('user_group') ? $this->input->post('user_group') : '';
        $filter->filter_type = $this->input->post('filter_type') ? $this->input->post('filter_type') : '';
        $filter->filter_options = $this->input->post('filter_options') ? $this->input->post('filter_options') : '';
        $filter->filter_values = $this->input->post('filter_values') ? $this->input->post('filter_values') : '';
        return $filter;
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
            $id = $id;
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);
        }
        return $id;
    }

}
